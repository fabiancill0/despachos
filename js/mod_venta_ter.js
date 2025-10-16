var tot_cajas = 0;
var tot_pallets = 0;
$(document).ready(function () {
    $('#folio_input_btn').on('click', function () {
        document.getElementById('folio_input').click();
    })
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
            $.ajax({
                url: '../data/getDetaPalletDesp.php?type=granel&folio_gran=' + folio,
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
                            '</td><td>' + valueOfElement.cate_codigo +
                            '</td><td>' + valueOfElement.etiq_codigo +
                            '</td><td>' + valueOfElement.pafr_calrot +
                            '</td><td><input id="cajas' + valueOfElement.paen_numero + '" style="display:none" value="' + valueOfElement.paen_ccajas + '">' + valueOfElement.paen_ccajas +
                            '</td><td>' + valueOfElement.paen_tipopa +
                            '</td></tr>');
                    });
                    tot_cajas += parseInt($('#cajas' + folio).val());
                    tot_pallets += 1;
                    $('#tot_cajas').val(tot_cajas);
                    $('#tot_tarjas').val(tot_pallets);
                    console.log(tot_cajas);
                    console.log(tot_pallets);
                    $.ajax({
                        url: '../model/save.php?type=pallet_gran',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            cliente: $('#clientes').val(),
                            planta: $('#planta').val(),
                            palletList: folio,
                            tot_cajas: tot_cajas,
                            nro_despacho: $('#nro_despacho').val(),
                            tot_pallets: tot_pallets
                        },
                        success: function (data) {
                            if (data.status === 'success') {
                                alert(data.message);
                                console.log(data.message);
                            } else {
                                alert(data.message);
                                console.log(data.message);
                            }
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
        }
    });
    $('#edit_pallet').on('click', function () {
        $.ajax({
            url: '../model/save.php?type=edit_pallet_gran',
            type: 'POST',
            data: {
                cliente: $('#clientes').val(),
                planta: $('#planta').val(),
                folio: $('#folio').val(),
                nro_despacho: $('#nro_despacho').val(),
            },
            success: function () {
                $.ajax({
                    url: '../data/getDetaDespacho.php?type=granel&nro_desp=' + $('#nro_despacho').val(),
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
                                '</td><td>' + valueOfElement.cate_codigo +
                                '</td><td>' + valueOfElement.etiq_codigo +
                                '</td><td>' + valueOfElement.pafr_calrot +
                                '</td><td><input id="cajas' + valueOfElement.paen_numero + '" style="display:none" value="' + valueOfElement.paen_ccajas + '">' + valueOfElement.paen_ccajas +
                                '</td><td>' + valueOfElement.paen_tipopa +
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
    $('#check_pallet').on('click', function () {
        var folio = parseInt($('#folio').val().substring(3));
        $.ajax({
            url: '../data/getEncaPallet.php?type=granel&folio=' + folio,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
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
                    $('#cajas').val(data.paen_ccajas);
                    document.getElementById('cajas').setAttribute('disabled', '');
                    $('#etiqueta').val(data.etiq_codigo);
                    document.getElementById('etiqueta').setAttribute('disabled', '');
                    $('#deta_pallet').load('../data/getDetaPallet.php?type=granel&folio=' + folio);
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
                $('#enca_despa').load('../data/getEncaDespa.php?type=granel&cliente=' + $('#clientes').val());
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
            url: '../data/getDetaDespacho.php?type=granel&nro_desp=' + $('#nro_despacho').val(),
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
                        '</td><td>' + valueOfElement.cate_codigo +
                        '</td><td>' + valueOfElement.etiq_codigo +
                        '</td><td>' + valueOfElement.pafr_calrot +
                        '</td><td><input id="cajas' + indexInArray + '" style="display:none" value="' + valueOfElement.paen_ccajas + '">' + valueOfElement.paen_ccajas +
                        '</td><td>' + valueOfElement.paen_tipopa +
                        '</td></tr>');
                });
            }
        })
        $.ajax({
            url: '../data/getEncaDespa.php?type=granel&nro_desp=' + $('#nro_despacho').val(),
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
                $('#comprador option[value=' + data.clpr_rut + ']').prop({ selected: true });
                $('#trans option[value=' + data.tran_codigo + ']').prop({ selected: true });
                $('#tipo_camion option[value=' + data.tica_codigo + ']').prop({ selected: true });
                $('#nro_despacho').val(data.defe_numero);
                $('#chofer').val(data.defe_chofer);
                $('#acoplado').val(data.defe_pataco);
                $('#patente').val(data.defe_patent);
                $('#fecha_des').val(data.defe_fecdes);
                $('#hora_des').val(data.defe_horade);
                $('#tipo_mov option[value=' + data.defe_tiposa + ']').prop({ selected: true })
                $('#guia').val(data.defe_guides);
                $('#tot_cajas').val(data.defe_cancaj);
                $('#tot_tarjas').val(data.defe_cantar);
                tot_cajas = parseInt(data.defe_cancaj);
                tot_pallets = parseInt(data.defe_cantar);
                console.log(tot_cajas);
                console.log(tot_pallets);
            }
        })
    });
    $('#folio').on('keypress', function (e) {
        var folio = parseInt($('#folio').val().substring(3));
        var id = e.which;
        if (id == '13') {
            $.ajax({
                url: '../data/getEncaPallet.php?type=granel&folio=' + folio,
                dataType: 'json',
                type: 'GET',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
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
                        $('#cajas').val(data.paen_ccajas);
                        document.getElementById('cajas').setAttribute('disabled', '');
                        $('#etiqueta').val(data.etiq_codigo);
                        document.getElementById('etiqueta').setAttribute('disabled', '');
                        $('#deta_pallet').load('../data/getDetaPallet.php?type=granel&folio=' + folio);
                    }
                }
            });

        }
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
                var date = new Date().toLocaleString('es-CL').split(',')[0].split('-')[2] + '-' + new Date().toLocaleString('es-CL').split(',')[0].split('-')[1] + '-' + new Date().toLocaleString('es-CL').split(',')[0].split('-')[0];
                inputs[i].value = date;
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
            } else if (selects[i].id == 'trans') {
                $('#' + selects[i].id).load('../includes/transportistas.php');
            } else if (selects[i].id == 'tipo_camion') {
                $('#' + selects[i].id).load('../includes/tipo_camion.php');
            } else if (selects[i].id == 'comprador') {
                $('#' + selects[i].id).load('../includes/compradores.php');
            } else if (selects[i].id == 'tipo_mov') {
                selects[i].setAttribute('disabled', '');
            }
        }
        $('#deta_despa').html('');
        //$('#save_enca_despacho').show();
        //$('#update_enca_despacho').hide();
        tot_cajas = 0;
        tot_pallets = 0;
        $('#tot_cajas').val(0);
        $('#tot_tarjas').val(0);
        console.log(tot_cajas);
        console.log(tot_pallets);
    });
    $('#save_enca_despacho').on('click', function () {
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var selects = encabezado.getElementsByTagName('select');
        console.log(inputs);
        console.log(selects);
        for (var i = 1; i < inputs.length; i++) {
            inputs[i].setAttribute('disabled', '');
            if (inputs[i].id == 'chofer' || inputs[i].id == 'patente') {
                if (inputs[i].value == '') {
                    inputs[i].removeAttribute('disabled');
                    alert('Por favor, complete todos los campos obligatorios.');
                    return;

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
        $.ajax({
            url: '../model/save.php?type=enca_granel',
            type: 'POST',
            dataType: 'json',
            data: {
                data_enca: datos
            },
            success: function (data) {
                if (data.status === 'success') {
                    $('#nro_despacho').val(parseInt(data.nro_despacho));
                    alert(data.message);
                } else {
                    alert(data.message);
                }
                console.log(data);
            }
        });
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
    tot_cajas -= parseInt($('#cajas' + id).val());
    tot_pallets -= 1;
    console.log(tot_cajas);
    console.log(tot_pallets);
    $('#tot_cajas').val($('#totCajas').val());
    $('#tot_tarjas').val($('#globalCounter').val());
    $('#' + id).remove();
    $.ajax({
        url: '../model/erase.php',
        type: 'POST',
        dataType: 'json',
        data: {
            type: 'pallet',
            nro_despacho: $('#nro_despacho').val(),
            folio: id,
            tot_cajas: tot_cajas,
            tot_pallets: tot_pallets
        },
        success: function (data) {
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert(data.message);
            }
        }
    });
}
function editarPallet(id) {
    $.ajax({
        url: '../data/getEncaPallet.php?type=edit_granel&folio=' + id,
        dataType: 'json',
        type: 'GET',
        success: function (data) {
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
            $('#cajas').val(data.paen_ccajas);
            document.getElementById('cajas').setAttribute('disabled', '');
            $('#etiqueta').val(data.etiq_codigo);
            document.getElementById('etiqueta').setAttribute('disabled', '');
            $('#deta_pallet').load('../data/getDetaPallet.php?type=granel&folio=' + id);
        }
    })
}
function loadDespacho(id) {
    document.getElementById('save_enca_despacho').setAttribute('disabled', '');
    document.getElementById('add_pallet_deta').removeAttribute('disabled');
    $.ajax({
        url: '../data/getDetaDespacho.php?type=granel&nro_desp=' + id,
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
                    '</td><td>' + valueOfElement.cate_codigo +
                    '</td><td>' + valueOfElement.etiq_codigo +
                    '</td><td>' + valueOfElement.pafr_calrot +
                    '</td><td><input id="cajas' + indexInArray + '" style="display:none" value="' + valueOfElement.paen_ccajas + '">' + valueOfElement.paen_ccajas +
                    '</td><td>' + valueOfElement.paen_tipopa +
                    '</td></tr>');
            });
        }
    })
    $.ajax({
        url: '../data/getEncaDespa.php?type=granel&nro_desp=' + id,
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
            $('#comprador option[value=' + data.clpr_rut + ']').prop({ selected: true });
            $('#trans option[value=' + data.tran_codigo + ']').prop({ selected: true });
            $('#tipo_camion option[value=' + data.tica_codigo + ']').prop({ selected: true });
            $('#nro_despacho').val(data.defe_numero);
            $('#chofer').val(data.defe_chofer);
            $('#acoplado').val(data.defe_pataco);
            $('#patente').val(data.defe_patent);
            $('#fecha_des').val(data.defe_fecdes);
            $('#hora_des').val(data.defe_horade);
            $('#tipo_mov option[value=' + data.defe_tiposa + ']').prop({ selected: true })
            $('#guia').val(data.defe_guides);
            $('#tot_cajas').val(data.defe_cancaj);
            $('#tot_tarjas').val(data.defe_cantar);
            tot_cajas = parseInt(data.defe_cancaj);
            tot_pallets = parseInt(data.defe_cantar);
            console.log(tot_cajas);
            console.log(tot_pallets);
        }
    })
}
