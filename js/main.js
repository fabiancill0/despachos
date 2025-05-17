$(document).ready(function () {
    $('#if_termografo').change(function () {
        if (this.checked) {
            document.getElementById('termografo').removeAttribute('disabled');
        } else {
            document.getElementById('termografo').setAttribute('disabled', '');
        }
    });
    $('#add_pallet').on('click', function () {
        if ($('#' + $('#folio').val()).length) {
            alert('Pallet ya existe!');
            const pallet_inputs = document.querySelector('#detalle_pallet');
            var inputs = pallet_inputs.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            $('#deta_pallet').html('');
            return;
        } else {
            var temp = $('#t1_pallet').val() + '/' + $('#t2_pallet').val();
            var termo = $('#termografo').val();
            $.ajax({
                url: 'data/getDetaPalletDesp.php?folio=' + $('#folio').val(),
                dataType: 'json',
                type: 'GET',
                success: function (data) {
                    $.each(data, function (indexInArray, valueOfElement) {
                        $('#deta_despa').append('<tr id="' + valueOfElement.paen_numero + '">' +
                            '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarPallet(' + valueOfElement.paen_numero + ')"><i class="fa-solid fa-trash"></i></button>' +
                            '<td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editarPallet(' + valueOfElement.paen_numero + ')"><i class="fa-solid fa-pen-to-square"></i></button>' +
                            '</td><td>' + valueOfElement.paen_numero +
                            '</td><td>' + valueOfElement.pafr_varrot +
                            '</td><td>' + valueOfElement.emba_codigo +
                            '</td><td>' + valueOfElement.etiq_codigo +
                            '</td><td>' + valueOfElement.pafr_calrot +
                            '</td><td>' + valueOfElement.paen_ccajas +
                            '</td><td id="temp' + valueOfElement.paen_numero + '">' + temp +
                            '</td><td>' + valueOfElement.paen_tipopa +
                            '</td><td>' + valueOfElement.stat_codigo +
                            '</td><td id="termo' + valueOfElement.paen_numero + '">' + termo +
                            '</td></tr>');
                    });

                }
            });
            const pallet_inputs = document.querySelector('#detalle_pallet');
            var inputs = pallet_inputs.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            $('#deta_pallet').html('');
            alert('Pallet agregado a despacho!');
        }
    });
    $('#edit_pallet').on('click', function () {
        var temp = $('#t1_pallet').val() + '/' + $('#t2_pallet').val();
        var termo = $('#termografo').val();
        $('#temp' + $('#folio').val()).replaceWith('<td id="temp' + $('#folio').val() + '">' + temp + '</td>');
        $('#termo' + $('#folio').val()).replaceWith('<td id="termo' + $('#folio').val() + '">' + termo + '</td>');
        const pallet_inputs = document.querySelector('#detalle_pallet');
        var inputs = pallet_inputs.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
        $('#deta_pallet').html('');
        alert('Datos modificados!');
    });
    $('#check_pallet').on('click', function () {
        $.ajax({
            url: 'data/getEncaPallet.php?folio=' + $('#folio').val(),
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    $('#folio').val('');
                    return;
                } else if (data.paen_estado != 1) {
                    alert('Pallet ya despachado!');
                    $('#folio').val('');
                    return;
                } else {
                    $('#tipo').val(data.paen_tipopa);
                    document.getElementById('tipo').setAttribute('disabled', '');
                    $('#variedad').val(data.vari_codigo);
                    document.getElementById('variedad').setAttribute('disabled', '');
                    $('#embalaje').val(data.emba_codigo);
                    document.getElementById('embalaje').setAttribute('disabled', '');
                    $('#categoria').val(data.cate_codigo);
                    document.getElementById('categoria').setAttribute('disabled', '');
                    $('#status').val(data.stat_codigo);
                    document.getElementById('status').setAttribute('disabled', '');
                    $('#condicion').val(data.cond_codigo);
                    document.getElementById('condicion').setAttribute('disabled', '');
                    $('#cajas').val(data.paen_ccajas);
                    document.getElementById('cajas').setAttribute('disabled', '');
                    $('#etiqueta').val(data.etiq_codigo);
                    document.getElementById('etiqueta').setAttribute('disabled', '');
                    $('#deta_pallet').load('data/getDetaPallet.php?folio=' + $('#folio').val());
                }
            }
        });
    });
    $('#get_enca_despacho').on('click', function () {
        $.ajax({
            beforeSend: function () {
                $('#enca_despa').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            },
            success: function () {
                $('#enca_despa').load('data/getEncaDespa.php?cliente=' + $('#clientes').val());
            }
        });
    });
    $('#get_embarques').on('click', function () {
        $.ajax({
            beforeSend: function () {
                $('#enca_embarque').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            },
            success: function () {
                $('#enca_embarque').load('data/getEncaEmbarque.php?cliente=' + $('#clientes').val());
            }
        });
    });
    $('#folio').on('keypress', function (e) {
        var id = e.which;
        if (id == '13') {
            $.ajax({
                url: 'data/getEncaPallet.php?folio=' + $('#folio').val(),
                dataType: 'json',
                type: 'GET',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                        $('#folio').val('');
                        return;
                    } else if (data.paen_estado != 1) {
                        alert('Pallet ya despachado!');
                        $('#folio').val('');
                        return;
                    } else {
                        $('#tipo').val(data.paen_tipopa);
                        document.getElementById('tipo').setAttribute('disabled', '');
                        $('#variedad').val(data.vari_codigo);
                        document.getElementById('variedad').setAttribute('disabled', '');
                        $('#embalaje').val(data.emba_codigo);
                        document.getElementById('embalaje').setAttribute('disabled', '');
                        $('#categoria').val(data.cate_codigo);
                        document.getElementById('categoria').setAttribute('disabled', '');
                        $('#status').val(data.stat_codigo);
                        document.getElementById('status').setAttribute('disabled', '');
                        $('#condicion').val(data.cond_codigo);
                        document.getElementById('condicion').setAttribute('disabled', '');
                        $('#cajas').val(data.paen_ccajas);
                        document.getElementById('cajas').setAttribute('disabled', '');
                        $('#etiqueta').val(data.etiq_codigo);
                        document.getElementById('etiqueta').setAttribute('disabled', '');
                        $('#deta_pallet').load('data/getDetaPallet.php?folio=' + $('#folio').val());
                    }
                }
            });

        }
    });
});
function eliminarPallet(id) {
    $('#' + id).remove();
    alert('Pallet eliminado!');
}
function editarPallet(id) {
    $.ajax({
        url: 'data/getEncaPallet.php?folio=' + id,
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            var temp = $('#temp' + id).text();
            var temp1 = temp.split('/')[0];
            var temp2 = temp.split('/')[1];
            $('#add_pallet').attr('disabled', '');
            $('#edit_pallet').removeAttr('disabled');
            $('#folio').val(id);
            document.getElementById('folio').setAttribute('disabled', '');
            $('#tipo').val(data.paen_tipopa);
            document.getElementById('tipo').setAttribute('disabled', '');
            $('#variedad').val(data.vari_codigo);
            document.getElementById('variedad').setAttribute('disabled', '');
            $('#embalaje').val(data.emba_codigo);
            document.getElementById('embalaje').setAttribute('disabled', '');
            $('#categoria').val(data.cate_codigo);
            document.getElementById('categoria').setAttribute('disabled', '');
            $('#status').val(data.stat_codigo);
            document.getElementById('status').setAttribute('disabled', '');
            $('#condicion').val(data.cond_codigo);
            document.getElementById('condicion').setAttribute('disabled', '');
            $('#cajas').val(data.paen_ccajas);
            document.getElementById('cajas').setAttribute('disabled', '');
            $('#etiqueta').val(data.etiq_codigo);
            document.getElementById('etiqueta').setAttribute('disabled', '');
            $('#t1_pallet').val(temp1);
            $('#t2_pallet').val(temp2);
            $('#termografo').val($('#termo' + id).text());
            $('#deta_pallet').load('data/getDetaPallet.php?folio=' + id);
        }
    })
}
function loadEmbarque(id) {
    $.ajax({
        url: 'data/getEncaEmbarque.php?data=' + id + ';' + $('#clientes').val(),
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            $('#embarque').val(data.embq_codigo);
            document.getElementById('embarque').setAttribute('disabled', '');
            $('#nave').val(data.embq_nomnav);
            document.getElementById('nave').setAttribute('disabled', '');
            $('#consig').html('<option value="' + data.reci_codigo + '">' + data.reci_codigo + '</option>');
            document.getElementById('consig').setAttribute('disabled', '');
            $('#pto_destino').val(data.embq_descar);
            document.getElementById('pto_destino').setAttribute('disabled', '');
            $('#dus').val(data.embq_numdus);
            document.getElementById('dus').setAttribute('disabled', '');
        }
    })
}
