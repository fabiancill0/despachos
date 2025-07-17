$(document).ready(function () {
    $('#add_pallet_deta').on('click', function () {
        document.getElementById('folio').removeAttribute('disabled');
        document.getElementById('add_pallet').removeAttribute('disabled');
        document.getElementById('edit_pallet').setAttribute('disabled', '');
    })
    $('#add_pallet').on('click', function () {
        var folio = parseInt($('#folio').val().substring(3));
        if ($('#' + folio).length) {
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
            var termoMarca = $('#marca_termografo').val();
            $.ajax({
                url: '../data/getDetaPalletDesp.php?folio=' + folio,
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
                            '</td><td id="cajas' + valueOfElement.paen_numero + '">' + valueOfElement.paen_ccajas +
                            '</td><td id="temp' + valueOfElement.paen_numero + '">' + temp +
                            '</td><td>' + valueOfElement.paen_tipopa +
                            '</td><td>' + valueOfElement.stat_codigo +
                            '</td><td id="termo' + valueOfElement.paen_numero + '">' + termo +
                            '</td><td style="display:none" id="termoMarca' + valueOfElement.paen_numero + '">' + termoMarca +
                            '</td></tr>');
                    });

                }
            });
            $('#totCajas').val(parseInt($('#totCajas').val()) + parseInt($('#cajas').val()));
            $('#globalCounter').val(parseInt($('#globalCounter').val()) + 1);
            $('#tot_cajas').val($('#totCajas').val());
            $.ajax({
                url: '../model/save.php?type=pallet',
                type: 'POST',
                data: {
                    cliente: $('#clientes').val(),
                    planta: $('#planta').val(),
                    palletList: folio + ';' + temp + ';' + termo + ';' + termoMarca,
                    totCajas: $('#totCajas').val(),
                    nro_despacho: $('#nro_despacho').val(),
                    globalCounter: $('#globalCounter').val()
                },
                success: function (data) {
                    console.log(data);
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
        var marca_termo = $('#marca_termografo').val();
        $.ajax({
            url: '../model/save.php?type=edit_pallet',
            type: 'POST',
            data: {
                cliente: $('#clientes').val(),
                planta: $('#planta').val(),
                folio: $('#folio').val(),
                temp: temp,
                termo: termo,
                marca_termo: marca_termo,
                nro_despacho: $('#nro_despacho').val(),
            },
            success: function () {
                $.ajax({
                    url: '../data/getDetaDespacho.php?nro_desp=' + $('#nro_despacho').val(),
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
                                '</td><td style="display:none" id="termoMarca' + indexInArray + '">' + valueOfElement.tema_codigo +
                                '</td></tr>');
                        });
                    }
                });
            }
        });
        const pallet_inputs = document.querySelector('#detalle_pallet');
        var inputs = pallet_inputs.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
        $('#deta_pallet').html('');
        alert('Datos modificados!');
    });
    $('#folio').on('keypress', function (e) {
        var folio = parseInt($('#folio').val().substring(3));
        var id = e.which;
        if (id == '13') {
            $.ajax({
                url: '../data/getEncaTarja.php?folio=' + folio + '&cliente=' + $('#clientes').val(),
                dataType: 'json',
                type: 'GET',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                        $('#folio').val('');
                        return;
                    } else {
                        $('#tar_lote').val(data.lote_codigo);
                        document.getElementById('tar_lote').setAttribute('disabled', '');
                        $('#tar_vari').val(data.vari_codigo);
                        document.getElementById('tar_vari').setAttribute('disabled', '');
                        $('#tar_prod').val(data.prod_codigo);
                        document.getElementById('tar_prod').setAttribute('disabled', '');
                        $('#tar_canti').val(data.bultos);
                        document.getElementById('tar_canti').setAttribute('disabled', '');
                        $('#tar_kilos').val(data.kilos);
                        document.getElementById('tar_kilos').setAttribute('disabled', '');
                        //$('#deta_pallet').load('../data/getDetaPallet.php?folio=' + folio);
                    }
                }
            });

        }
    });
    $('#check_pallet').on('click', function () {
        var folio = parseInt($('#folio').val().substring(3));
        $.ajax({
            url: '../data/getEncaTarja.php?folio=' + folio + '&cliente=' + $('#clientes').val(),
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    $('#folio').val('');
                    return;
                } else {
                    $('#tar_lote').val(data.lote_codigo);
                    document.getElementById('tar_lote').setAttribute('disabled', '');
                    $('#tar_vari').val(data.vari_codigo);
                    document.getElementById('tar_vari').setAttribute('disabled', '');
                    $('#tar_prod').val(data.prod_codigo);
                    document.getElementById('tar_prod').setAttribute('disabled', '');
                    $('#tar_canti').val(data.bultos);
                    document.getElementById('tar_canti').setAttribute('disabled', '');
                    $('#tar_kilos').val(data.kilos);
                    document.getElementById('tar_kilos').setAttribute('disabled', '');
                    //$('#deta_pallet').load('../data/getDetaPallet.php?folio=' + folio);
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
                $('#enca_despa').load('../data/getEncaTraspasoCom.php?cliente=' + $('#clientes').val());
                //$('#save_enca_despacho').hide();
                //$('#update_enca_despacho').show();
            }
        });
    });
    $('#get_despacho').on('click', function () {
        if ($('#nro_despacho').val() == '' || $('#nro_despacho').val() == null) {
            alert('Por favor, ingrese un número de despacho válido.');
            return;
        }
        $.ajax({
            url: '../data/getDetaDespacho.php?nro_desp=' + $('#nro_despacho').val(),
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    $('#nro_despacho').val('');
                    return;
                } else {
                    document.getElementById('add_pallet_deta').removeAttribute('disabled');
                    document.getElementById('save_enca_despacho').setAttribute('disabled', '');
                }
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
                        '</td><td style="display:none" id="termoMarca' + indexInArray + '">' + valueOfElement.tema_codigo +
                        '</td></tr>');
                });
            }
        })
        $.ajax({
            url: '../data/getEncaDespa.php?nro_desp=' + $('#nro_despacho').val(),
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                const encabezado = document.querySelector('#encabezado_despacho');
                var inputs = encabezado.getElementsByTagName('input');
                var selects = encabezado.getElementsByTagName('select');
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].setAttribute('disabled', '');
                }
                for (var i = 0; i < selects.length; i++) {
                    selects[i].setAttribute('disabled', '');
                }
                $('#clientes option[value=' + data.clie_codigo + ']').prop({ selected: true });
                $('#planta option[value=' + data.plde_codigo + ']').prop({ selected: true });
                $('#nro_despacho').val(data.defe_numero);
                $('#obs').val(data.defe_numero);
                $('#especie').val(data.defe_numero);
                $('#fecha_des').val(data.defe_fecdes);
                $('#hora_des').val(data.defe_horade);
                $('#guia').val(data.defe_guides);
                $('#tot_bultos').val(data.defe_cancaj);
                $('#tot_kilos').val(data.defe_cancaj);
                $('#totCajas').val(data.defe_cancaj);
                $('#globalCounter').val(data.defe_cantar);
            }
        })
    });

    $('#clear').on('click', function () {
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var selects = encabezado.getElementsByTagName('select');
        document.getElementById('add_pallet_deta').setAttribute('disabled', '');
        document.getElementById('save_enca_despacho').removeAttribute('disabled');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute('disabled');
            if (inputs[i].type == 'date') {
                inputs[i].value = new Date().toISOString().split('T')[0];
            } else if (inputs[i].type == 'time') {
                inputs[i].value = new Date().toTimeString().split(' ')[0].substring(0, 5);
            } else {
                inputs[i].value = '';
            }

        }
        for (var i = 0; i < selects.length; i++) {
            selects[i].removeAttribute('disabled');
            if (selects[i].id == 'clientes') {
                $('#' + selects[i].id).load('../includes/clientes.php');
            } else if (selects[i].id == 'planta') {
                $('#' + selects[i].id).load('../includes/plantas.php');
            } else if (selects[i].id == 'motivo') {
                selects[i].setAttribute('disabled', '')
            } else if (selects[i].id == 'especie') {
                $('#' + selects[i].id).load('../includes/especie.php');
            }
        }
        $('#deta_despa').html('');
        //$('#save_enca_despacho').show();
        //$('#update_enca_despacho').hide();
        $('#tot_bultos').val(0);
        $('#tot_kilos').val(0);
        $('#globalCounter').val(0);
        $('#tot_cajas').val(0);
    });
    $('#save_enca_despacho').on('click', function () {
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var selects = encabezado.getElementsByTagName('select');
        console.log(inputs);
        console.log(selects);
        for (var i = 1; i < inputs.length; i++) {
            inputs[i].setAttribute('disabled', '');
            if (inputs[i].id != 'guia' || inputs[i].id != 'obs') {
            } else {
                if (inputs[i].type != 'date') {
                    if (inputs[i].value == null || inputs[i].value == '') {
                        alert('Por favor, complete todos los campos obligatorios.');
                        inputs[i].removeAttribute('disabled');
                        return;
                    }

                }
            }
        }
        document.getElementById('add_pallet_deta').removeAttribute('disabled');
        document.getElementById('nro_despacho').setAttribute('disabled', '');
        document.getElementById('save_enca_despacho').setAttribute('disabled', '');
        var datos = {}
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].setAttribute('disabled', '');
            if (inputs[i].type == 'checkbox') {
                datos[inputs[i].id] = inputs[i].checked ? 1 : 0;
            } else {
                datos[inputs[i].id] = inputs[i].value;
            }
        }
        for (var i = 0; i < selects.length; i++) {
            selects[i].setAttribute('disabled', '');
            datos[selects[i].id] = selects[i].value;
        }
        /*$.ajax({
            url: '../model/save.php?type=enca',
            type: 'POST',
            data: {
                data_enca: datos
            },
            success: function (data) {
                $('#nro_despacho').val(parseInt(data));
                console.log(data);
            }
        });*/
    });
    /*$('#update_enca_despacho').on('click', function () {
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var selects = encabezado.getElementsByTagName('select');
        console.log(inputs);
        console.log(selects);
        var datos = {}
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'checkbox') {
                datos[inputs[i].id] = inputs[i].checked ? 1 : 0;
            } else {
                datos[inputs[i].id] = inputs[i].value;
            }
        }
        for (var i = 0; i < selects.length; i++) {
            datos[selects[i].id] = selects[i].value;
        }
        $.ajax({
            url: 'model/save.php?type=update_enca',
            type: 'POST',
            data: {
                data_enca: datos,
                totCajas: $('#tot_cajas').val(),
                globalCounter: $('#globalCounter').val()
            },
            success: function (data) {
                console.log(data);
            }
        });
    });*/
});
function eliminarPallet(id) {
    $('#totCajas').val(parseInt($('#totCajas').val()) - parseInt($('#cajas' + id).html()));
    $('#globalCounter').val(parseInt($('#globalCounter').val()) - 1);
    $('#tot_cajas').val($('#totCajas').val());
    $('#' + id).remove();
    $.ajax({
        url: '../model/erase.php',
        type: 'POST',
        data: {
            nro_despacho: $('#nro_despacho').val(),
            folio: id,
            totCajas: $('#totCajas').val(),
            globalCounter: $('#globalCounter').val()
        }
    });
    alert('Pallet eliminado!');
}
function editarPallet(id) {
    $.ajax({
        url: '../data/getEncaPallet.php?type=edit&folio=' + id,
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
            $('#marca_termografo option[value=' + $('#termoMarca' + id).html() + ']').prop({ selected: true });
            $('#deta_pallet').load('../data/getDetaPallet.php?folio=' + id);
        }
    })
}
function loadTraspaso(id) {
    document.getElementById('save_enca_despacho').setAttribute('disabled', '');
    document.getElementById('add_pallet_deta').removeAttribute('disabled');
    $.ajax({
        url: '../data/getDetaTraspasoCom.php?nro_desp=' + id + '&cliente=' + $('#clientes').val(),
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            $('#deta_despa').html('');
            $.each(data, function (indexInArray, valueOfElement) {
                $('#deta_despa').append('<tr id="' + indexInArray + '">' +
                    '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarPallet(' + indexInArray + ')"><i class="fa-solid fa-trash"></i></button>' +
                    '<td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editarPallet(' + indexInArray + ')"><i class="fa-solid fa-pen-to-square"></i></button>' +
                    '</td><td>' + valueOfElement.plde_codigo +
                    '</td><td>' + valueOfElement.lote_espcod +
                    '</td><td>' + valueOfElement.lote_codigo +
                    '</td><td>' + indexInArray +
                    '</td><td>' + valueOfElement.fgmb_canbul +
                    '</td><td>' + valueOfElement.kilos +
                    '</td><td>' + valueOfElement.prod_codigo +
                    '</td></tr>');
            });
        }
    })

    $.ajax({
        url: '../data/getEncaTraspasoCom.php?nro_desp=' + id,
        dataType: 'json',
        type: 'GET',
        success: function (data) {
            const encabezado = document.querySelector('#encabezado_despacho');
            var inputs = encabezado.getElementsByTagName('input');
            var selects = encabezado.getElementsByTagName('select');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].setAttribute('disabled', '');
            }
            for (var i = 0; i < selects.length; i++) {
                selects[i].setAttribute('disabled', '');
            }
            $('#clientes option[value=' + data.clie_codigo + ']').prop({ selected: true });
            $('#planta option[value=' + data.plde_codigo + ']').prop({ selected: true });
            $('#nro_despacho').val(data.mfge_numero);
            $('#obs').val(data.mfge_observ);
            $('#especie option[value=' + data.espe_codigo + ']').prop({ selected: true });
            $('#fecha_des').val(data.mfge_fecmov);
            $('#hora_des').val(data.refg_horasa);
            $('#guia').val(data.mfge_guisii);
            $('#tot_bultos').val(data.mfge_totbul);
            $('#tot_kilos').val(data.mfge_tpneto);
            //$('#totCajas').val(data.defe_cancaj);
            //$('#globalCounter').val(data.defe_cantar);
        }
    })
}
