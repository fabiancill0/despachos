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
                        $('#deta_despa').append('<tr id="' + valueOfElement.paen_numero + '"><td>' + valueOfElement.paen_numero +
                            '</td><td>' + valueOfElement.pafr_varrot +
                            '</td><td>' + valueOfElement.emba_codigo +
                            '</td><td>' + valueOfElement.etiq_codigo +
                            '</td><td>' + valueOfElement.pafr_calrot +
                            '</td><td>' + valueOfElement.paen_ccajas +
                            '</td><td>' + temp +
                            '</td><td>' + valueOfElement.paen_tipopa +
                            '</td><td>' + valueOfElement.stat_codigo +
                            '</td><td>' + termo +
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
        }

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
        $('#enca_despa').load('data/getEncaDespa.php?cliente=' + $('#clientes').val());
    });
    $('#get_embarques').on('click', function () {
        $('#enca_embarque').load('data/getEncaEmbarque.php?cliente=' + $('#clientes').val());
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