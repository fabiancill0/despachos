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
                url: 'data/getDetaPalletDesp.php?folio=' + $('#folio').val() + ';' + $('#clientes').val(),
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
            url: 'data/getEncaPallet.php?folio=' + $('#folio').val() + ';' + $('#clientes').val(),
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
                url: 'data/getEncaPallet.php?folio=' + $('#folio').val() + ';' + $('#clientes').val(),
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
    $('#save_despacho').on('click', function () {
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var pallets = encabezado.getElementsByTagName('tr');
        console.log(inputs)
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                console.log(inputs[i].id + '-' + inputs[i].checked)
            }
            else {
                console.log(inputs[i].id + '-' + inputs[i].value);
            }
        }
        for (var i = 1; i < pallets.length; i++) {
            console.log(pallets[i].id + '-' + i);
        }
    });
});
function eliminarPallet(id) {
    $('#' + id).remove();
    alert('Pallet eliminado!');
}
function editarPallet(id) {
    $.ajax({
        url: 'data/getEncaPallet.php?folio=' + id + ';' + $('#clientes').val(),
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
function loadDespacho(id) {
    $.ajax({
        url: 'data/getDetaDespacho.php?data=' + id + ';' + $('#clientes').val(),
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            $('#deta_despa').html('');
            $.each(data, function (indexInArray, valueOfElement) {
                $('#deta_despa').append('<tr id="' + indexInArray + '">' +
                    '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarPallet(' + indexInArray + ')"><i class="fa-solid fa-trash"></i></button>' +
                    '<td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editarPallet(' + indexInArray + ')"><i class="fa-solid fa-pen-to-square"></i></button>' +
                    '</td><td>' + indexInArray +
                    '</td><td>' + valueOfElement.pafr_varrot +
                    '</td><td>' + valueOfElement.emba_codigo +
                    '</td><td>' + valueOfElement.etiq_codigo +
                    '</td><td>' + valueOfElement.pafr_calrot +
                    '</td><td>' + valueOfElement.paen_ccajas +
                    '</td><td id="temp' + indexInArray + '">' + valueOfElement.defe_tempe1 + '/' + valueOfElement.defe_tempe2 +
                    '</td><td>' + valueOfElement.paen_tipopa +
                    '</td><td>' + valueOfElement.stat_codigo +
                    '</td><td id="termo' + indexInArray + '">' + valueOfElement.defe_termog +
                    '</td></tr>');
            });
        }
    })
    $.ajax({
        url: 'data/getEncaDespa.php?data=' + id + ';' + $('#clientes').val(),
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            $('#planta option[value=' + data.plde_codigo + ']').prop({ selected: true });
            document.getElementById('planta').setAttribute('disabled', '');
            $('#nro_despacho').val(data.defe_numero);
            document.getElementById('nro_despacho').setAttribute('disabled', '');
            $('#patente').val(data.defe_patent);
            document.getElementById('patente').setAttribute('disabled', '');
            $('#fecha_des').val(data.defe_fecdes);
            document.getElementById('fecha_des').setAttribute('disabled', '');
            $('#hora_des').val(data.defe_horade);
            document.getElementById('hora_des').setAttribute('disabled', '');
            $('#tipo_mov option[value=' + data.defe_tiposa + ']').prop({ selected: true })
            document.getElementById('tipo_mov').setAttribute('disabled', '');
            $('#embarque').val(data.embq_codigo);
            document.getElementById('embarque').setAttribute('disabled', '');
            $('#nave').val(data.embq_nomnav);
            document.getElementById('nave').setAttribute('disabled', '');
            $('#consig').html('<option value="' + data.reci_codigo + '">' + data.reci_codigo + '</option>');
            document.getElementById('consig').setAttribute('disabled', '');
            if (data.defe_ctlter == 1) {
                document.getElementById('if_termografo').setAttribute('checked', '');
                document.getElementById('if_termografo').setAttribute('disabled', '');
            } else {
                document.getElementById('if_termografo').removeAttribute('checked');
                document.getElementById('if_termografo').removeAttribute('disabled');
            }
            $('#pto_destino').val(data.puer_codigo);
            document.getElementById('pto_destino').setAttribute('disabled', '');
            $('#guia').val(data.defe_guides);
            document.getElementById('guia').setAttribute('disabled', '');
            $('#tot_cajas').val(data.defe_cancaj);
            document.getElementById('tot_cajas').setAttribute('disabled', '');
            $('#sps').val(data.defe_nrosps);
            document.getElementById('sps').setAttribute('disabled', '');
        }
    })
}
