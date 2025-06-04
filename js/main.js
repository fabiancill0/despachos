$(document).ready(function () {
    $('#if_termografo').change(function () {
        if (this.checked) {
            document.getElementById('termografo').removeAttribute('disabled');
        } else {
            document.getElementById('termografo').setAttribute('disabled', '');
        }
    });
    $('#add_pallet_deta').on('click', function () {
        document.getElementById('folio').removeAttribute('disabled');
        document.getElementById('add_pallet').removeAttribute('disabled');
        document.getElementById('edit_pallet').setAttribute('disabled', '');

    })
    $('#add_pallet').on('click', function () {
        var cliente = parseInt($('#folio').val().substring(0, 3));
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
                url: 'data/getDetaPalletDesp.php?folio=' + folio + ';' + cliente,
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
                url: 'model/save.php?type=pallet',
                type: 'POST',
                data: {
                    cliente: cliente,
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
            url: 'model/save.php?type=edit_pallet',
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
                    url: 'data/getDetaDespacho.php?nro_desp=' + $('#nro_despacho').val(),
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
        $('#marca_termografo option[value=0]').prop({ selected: true });
        $('#deta_pallet').html('');
        alert('Datos modificados!');
    });
    $('#check_pallet').on('click', function () {
        var cliente = parseInt($('#folio').val().substring(0, 3));
        var folio = parseInt($('#folio').val().substring(3));
        $.ajax({
            url: 'data/getEncaPallet.php?folio=' + folio + ';' + cliente,
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
                    $('#status').val(data.stat_codigo);
                    document.getElementById('status').setAttribute('disabled', '');
                    $('#condicion').val(data.cond_codigo);
                    document.getElementById('condicion').setAttribute('disabled', '');
                    $('#cajas').val(data.paen_ccajas);
                    document.getElementById('cajas').setAttribute('disabled', '');
                    $('#etiqueta').val(data.etiq_codigo);
                    document.getElementById('etiqueta').setAttribute('disabled', '');
                    $('#deta_pallet').load('data/getDetaPallet.php?folio=' + folio + ';' + cliente);
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
                //$('#save_enca_despacho').hide();
                //$('#update_enca_despacho').show();
                document.getElementById('add_pallet_deta').removeAttribute('disabled');

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
    $('#get_despacho').on('click', function () {
        document.getElementById('add_pallet_deta').removeAttribute('disabled');
        document.getElementById('save_enca_despacho').setAttribute('disabled', '');
        $.ajax({
            url: 'data/getDetaDespacho.php?nro_desp=' + $('#nro_despacho').val(),
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
        })
        $.ajax({
            url: 'data/getEncaDespa.php?nro_desp=' + $('#nro_despacho').val(),
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
                $('#patente').val(data.defe_patent);
                $('#fecha_des').val(data.defe_fecdes);
                $('#hora_des').val(data.defe_horade);
                $('#tipo_mov option[value=' + data.defe_tiposa + ']').prop({ selected: true })
                $('#embarque').val(data.embq_codigo);
                $('#nave').val(data.embq_nomnav);
                $('#nave_cod').val(data.nave_codigo);
                $('#consig option[value=' + data.reci_codigo + ']').prop({ selected: true });
                $('#pto_destino').val(data.nomb_puerto);
                $('#pto_destino_cod').val(data.puer_codigo);
                $('#guia').val(data.defe_guides);
                $('#tot_cajas').val(data.defe_cancaj);
                $('#totCajas').val(data.defe_cancaj);
                $('#globalCounter').val(data.defe_cantar);
                $('#sps').val(data.defe_nrosps);
                $('#dus').val(data.defe_numdus);
            }
        })
    });
    $('#folio').on('keypress', function (e) {
        var cliente = parseInt($('#folio').val().substring(0, 3));
        var folio = parseInt($('#folio').val().substring(3));
        var id = e.which;
        if (id == '13') {
            $.ajax({
                url: 'data/getEncaPallet.php?folio=' + folio + ';' + cliente,
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
                        $('#deta_pallet').load('data/getDetaPallet.php?folio=' + folio + ';' + cliente);
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
            if (inputs[i].type == 'date' || inputs[i].type == 'time') {
            } else {
                inputs[i].value = '';
            }

        }
        for (var i = 0; i < selects.length; i++) {
            selects[i].removeAttribute('disabled');
            if (selects[i].id == 'clientes') {
                $('#' + selects[i].id).load('includes/clientes.php');
            } else if (selects[i].id == 'planta') {
                $('#' + selects[i].id).load('includes/plantas.php');
            } else if (selects[i].id == 'tipo_mov') {
                $('#' + selects[i].id).load('includes/tipo_mov.php');
            } else if (selects[i].id == 'consig') {
                $('#' + selects[i].id).load('includes/consignatarios.php');
            }
        }
        $('#deta_despa').html('');
        //$('#save_enca_despacho').show();
        //$('#update_enca_despacho').hide();
        $('#globalCounter').val(0);
        $('#tot_cajas').val(0);
    });
    $('#save_enca_despacho').on('click', function () {
        document.getElementById('add_pallet_deta').removeAttribute('disabled');
        document.getElementById('nro_despacho').setAttribute('disabled', '');
        document.getElementById('save_enca_despacho').setAttribute('disabled', '');
        const encabezado = document.querySelector('#encabezado_despacho');
        var inputs = encabezado.getElementsByTagName('input');
        var selects = encabezado.getElementsByTagName('select');
        console.log(inputs);
        console.log(selects);
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
            url: 'model/save.php?type=enca',
            type: 'POST',
            data: {
                data_enca: datos
            },
            success: function (data) {
                $('#nro_despacho').val(parseInt(data));
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
    $('#totCajas').val(parseInt($('#totCajas').val()) - parseInt($('#cajas' + id).html()));
    $('#globalCounter').val(parseInt($('#globalCounter').val()) - 1);
    $('#tot_cajas').val($('#totCajas').val());
    $('#' + id).remove();
    $.ajax({
        url: 'model/erase.php',
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
        url: 'data/getEncaPallet.php?type=edit&folio=' + id + ';' + $('#clientes').val(),
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
            $('#deta_pallet').load('data/getDetaPallet.php?folio=' + id + ';' + $('#clientes').val());
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
            $('#nave_cod').val(data.nave_codigo);
            document.getElementById('nave').setAttribute('disabled', '');
            $('#consig').html('<option value="' + data.reci_codigo + '">' + data.reci_nombre + '</option>');
            document.getElementById('consig').setAttribute('disabled', '');
            $('#pto_destino').val(data.nomb_puerto);
            $('#pto_destino_cod').val(data.embq_descar);
            document.getElementById('pto_destino').setAttribute('disabled', '');
            $('#dus').val(data.embq_numdus);
            document.getElementById('dus').setAttribute('disabled', '');
        }
    })
}
function loadDespacho(id) {
    $.ajax({
        url: 'data/getDetaDespacho.php?nro_desp=' + id,
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
    })
    $.ajax({
        url: 'data/getEncaDespa.php?nro_desp=' + id,
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
            $('#patente').val(data.defe_patent);
            $('#fecha_des').val(data.defe_fecdes);
            $('#hora_des').val(data.defe_horade);
            $('#tipo_mov option[value=' + data.defe_tiposa + ']').prop({ selected: true })
            $('#embarque').val(data.embq_codigo);
            $('#nave').val(data.embq_nomnav);
            $('#nave_cod').val(data.nave_codigo);
            $('#consig option[value=' + data.reci_codigo + ']').prop({ selected: true });
            $('#pto_destino').val(data.nomb_puerto);
            $('#pto_destino_cod').val(data.puer_codigo);
            $('#guia').val(data.defe_guides);
            $('#tot_cajas').val(data.defe_cancaj);
            $('#totCajas').val(data.defe_cancaj);
            $('#globalCounter').val(data.defe_cantar);
            $('#sps').val(data.defe_nrosps);
            $('#dus').val(data.defe_numdus);
        }
    })
}
