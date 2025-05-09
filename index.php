<!doctype html>
<html lang="es">

<head>
    <title>Despachos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">
    <script src="https://kit.fontawesome.com/34afac4ad4.js" crossorigin="anonymous"></script>
</head>

<body data-bs-theme="dark">
    <div class="container-fluid">
        <div class="mb-0">
            <div class="row align-items-center">
                <div class="col-3">
                    <label class="col-form-label" for="clientes">Cliente</label>
                </div>
                <div class="col-9">
                    <select class="form-select form-select-sm" id="clientes">
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row align-items-center">
                <div class="col-3">
                    <label class="col-form-label" for="planta">Planta</label>
                </div>
                <div class="col-9">
                    <select class="form-select form-select-sm" id="planta">
                        <option value="">Chada</option>
                        <option value="">Frutango</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row">
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="col-form-label" for="nro_despacho">Nro.Des.</label>
                        </div>
                        <div class="col-8">
                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" class="form-control form-control-sm" id="nro_despacho">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="col-form-label" for="patente">Patente</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="patente">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row">
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="col-form-label" for="fecha_des">Fecha</label>
                        </div>
                        <div class="col-8">
                            <input type="date" value="<?= date('Y-m-d') ?>" class="form-control form-control-sm" id="fecha_des">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="col-form-label" for="hora_des">Hora</label>
                        </div>
                        <div class="col-8">
                            <input type="time" value="<?= date('H:i') ?>" class="form-control form-control-sm" id="hora_des">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row align-items-center">
                <div class="col-3">
                    <label class="col-form-label" for="tipo_mov">Tipo Mov</label>
                </div>
                <div class="col-9">
                    <select class="form-select form-select-sm" id="tipo_mov">
                        <option value="">Embarque Marítimo</option>
                        <option value="">Embarque Terrestre</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row">
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <label class="col-form-label" for="embarque">Embarque</label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="embarque">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <label class="col-form-label" for="nave">Nave</label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="nave">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row align-items-center">
                <div class="col-8">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="col-form-label" for="consig">Consig.</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select form-select-sm" id="consig">
                                <option value="">Rio King</option>
                                <option value="">Frutango</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="if_termografo">
                            <label class="form-check-label" for="if_termografo">Termógrafo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row align-items-center">
                <div class="col-3">
                    <label class="col-form-label" for="pto_destino">Pto Destino</label>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control form-control-sm" id="pto_destino">
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row">
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <label class="col-form-label" for="guia">Guía</label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="guia">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <label class="col-form-label" for="tot_cajas">Cajas</label>
                        </div>
                        <div class="col-7">
                            <input type="number" class="form-control form-control-sm" id="tot_cajas">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <div class="row">
                <div class="col-5">
                    <div class="row align-items-center" style="display:none">
                        <div class="col-5">
                            <label class="col-form-label" for="reserva">Reserva</label>
                        </div>
                        <div class="col-7">
                            <select class="form-select form-select-sm" id="reserva">
                                <option value="">R1</option>
                                <option value="">R2</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <label class="col-form-label" for="dus">DUS</label>
                                </div>
                                <div class="col-7">
                                    <input type="number" class="form-control form-control-sm" id="dus">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <label class="col-form-label" for="sps">SPS</label>
                                </div>
                                <div class="col-7">
                                    <input type="number" class="form-control form-control-sm" id="sps">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <div class="row justify-content-center">
            <button type="button" class="btn btn-primary btn-lg col-3" data-bs-toggle="modal" data-bs-target="#busquedaModal">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <span class="col-1"></span>
            <button type="button" class="btn btn-success btn-lg col-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-square-plus"></i>
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="busquedaModal" tabindex="-1" aria-labelledby="busquedaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="busquedaModalLabel">Busqueda despachos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Fecha</th>
                                    <th>Recibidor</th>
                                    <th>Salida</th>
                                    <th>Cod Puerto</th>
                                    <th>Destino</th>
                                    <th>Guía</th>
                                    <th>Embarque</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-danger btn-lg col-3" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir pallets</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="container-fluid">
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="folio">Folio</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control form-control-sm" id="folio">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="tipo">Tipo</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="tipo">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="variedad">Variedad</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="variedad">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="embalaje">Emb</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="embalaje">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="categoria">Cat</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="categoria">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="status">Status</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="status">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="condicion">Condición</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="condicion">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="calidad">C.Calidad</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="calidad">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="destino">Destino</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="destino">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="cajas">Cajas</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="cajas">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="etiqueta">Etiqueta</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="etiqueta">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="termografo">Termógrafo</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="termografo" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="marca_termografo">Marca</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-select form-select-sm" id="marca_termografo">
                                        <option value="N/A" selected>N/A</option>
                                        <option value="">M1</option>
                                        <option value="">M2</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="t1_pallet">T1°</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" maxlength="4" step="0.1" class="form-control form-control-sm" id="t1_pallet">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <label class="col-form-label" for="t2_pallet">T2°</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" maxlength="4" step="0.1" class="form-control form-control-sm" id="t2_pallet">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="estiba" type="radio" id="estiba_izq" checked>
                                                <label class="form-check-label" for="estiba_izq">Izq</label>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" maxlength="2" class="form-control form-control-sm" id="posicion_izq">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="estiba" type="radio" id="estiba_der">
                                                <label class="form-check-label" for="estiba_der">Der</label>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" maxlength="2" class="form-control form-control-sm" id="posicion_der">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row justify-content-center">
                            <button type="button" id="add_pallet" class="btn btn-success btn-lg col-3"><i class="fa-solid fa-square-plus"></i></button>
                            <span class="col-1"></span>
                            <button type="button" class="btn btn-danger btn-lg col-3" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#if_termografo').change(function() {
                if (this.checked) {
                    document.getElementById('termografo').removeAttribute('disabled');
                } else {
                    document.getElementById('termografo').setAttribute('disabled', '');
                }
            });
            $('#folio').on('keypress', function(e) {
                var id = e.which;
                if (id == '13') {
                    $.ajax({
                        url: 'data/getEncaPallet.php?folio=' + $('#folio').val(),
                        dataType: 'json',
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
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
                        }
                    });
                }
            });
        });
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <div></div>

</body>

</html>