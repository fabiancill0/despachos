<?php
session_start();
if ($_SESSION['login_active'] == 1) {
    $usuario = $_SESSION['user'];

    include_once '../model/functions.php';
    include_once '../model/connections.php';
    $functions = new Functions();
    $cone = new Connections();
?>
    <!doctype html>
    <html lang="es" data-bs-theme="dark">

    <head>
        <title>Despachos</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="icon" href="../img/web/favicon.ico" sizes="32x32">
        <link rel="apple-touch-icon" href="../img/web/apple-touch-icon.png" type="image/png">
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
        <script src="../js/main.js?<?= md5(time()) ?>"></script>
        <style>
            .table-container {
                max-height: 150px;
                overflow-y: auto;
                width: 100%;
                border: 1px solid #495057;
                border-radius: 0.25rem;
            }

            .table-container thead tr {
                position: sticky;
                top: 0;
                z-index: 1;
                line-height: 30px;
            }

            .table-container tbody tr {
                line-height: 30px;
            }

            .table-container-despachos {
                max-height: 500px;
                overflow-y: auto;
                width: 100%;
                border: 1px solid #495057;
                border-radius: 0.25rem;
            }

            .table-container-despachos thead tr {
                position: sticky;
                top: 0;
                z-index: 1;
                line-height: 30px;
            }

            .table-container-despachos tbody tr {
                line-height: 30px;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Despachos</span>
                <div class="row fixed-right">
                    <div class="col-6">
                        <a href="../main.php"><button class="btn btn-success"><i class="fa-solid fa-arrow-left"></i></button></a>
                    </div>
                    <div class="col-6">
                        <form action="../model/logout.php" method="post">
                            <button class="btn btn-danger" type="submit" value="0" name="out"><i class="fa-solid fa-right-from-bracket"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <input type="number" style="display:none" id="globalCounter" value="0">
            <input type="number" style="display:none" id="totCajas" value="0">
            <div id="encabezado_despacho">
                <div class="mb-0">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <label class="col-form-label" for="clientes">Cliente</label>
                        </div>
                        <div class="col-9">
                            <select class="form-select form-select-sm" id="clientes">
                                <?php
                                $functions->getClientesCod($cone->connectToServ());
                                ?>
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
                                <?php
                                $functions->getPlantaDesp($cone->connectToServ());
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <label class="col-form-label" for="nro_despacho">Nro.Des.</label>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-8 pe-0">
                                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" class="form-control form-control-sm" id="nro_despacho">
                                        </div>
                                        <div class="col-4 ps-0">
                                            <button type="button" id="get_despacho" class="btn btn-success btn-sm"><i class="fa-solid fa-square-check"></i></button>
                                        </div>
                                    </div>
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
                                <?php
                                $functions->getTipoMov($cone->connectToServ());
                                ?>
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
                                    <div class="row">
                                        <div class="col-8 pe-0">
                                            <input type="text" class="form-control form-control-sm" id="embarque">
                                        </div>
                                        <div class="col-4 ps-0">
                                            <button type="button" id="get_embarques" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#busquedaEmbarqueModal"><i class="fa-solid fa-square-check"></i></button>
                                        </div>
                                    </div>
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
                                    <input type="number" style="display: none" id="nave_cod">
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
                                        <?php
                                        $functions->getConsignatarios($cone->connectToServ());
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="if_termografo" checked>
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
                            <input type="number" style="display: none" id="pto_destino_cod">
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
                                    <input type="number" class="form-control form-control-sm" id="tot_cajas" value="0">
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
                        <div class="col-12">
                            <div class="table-container">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Pallet</th>
                                            <th>Variedad</th>
                                            <th>Embalaje</th>
                                            <th>Etiqueta</th>
                                            <th>Calibre</th>
                                            <th>Cajas</th>
                                            <th>Temperaturas</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th>Termógrafo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deta_despa">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->
            <div class="row justify-content-center fixed-bottom">
                <button type="button" class="btn btn-primary btn-lg col-2" data-bs-toggle="modal" data-bs-target="#busquedaModal" id="get_enca_despacho">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <span class="col-1"></span>
                <button type="button" class="btn btn-light btn-lg col-2" id="clear">
                    <i class="fa-solid fa-file"></i>
                </button>
                <span class="col-1"></span>
                <button type="button" class="btn btn-success btn-lg col-2" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled id="add_pallet_deta">
                    <i class="fa-solid fa-square-plus"></i>
                </button>
                <span class="col-1"></span>
                <button type="button" class="btn btn-success btn-lg col-2" id="save_enca_despacho">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
                <button type="button" class="btn btn-warning btn-lg col-2" style="display:none" id="update_enca_despacho">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="busquedaModal" tabindex="-1" aria-labelledby="busquedaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="busquedaModalLabel">Búsqueda despachos</h1>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i></button>
                        </div>
                        <div class="container-fluid">
                            <div class="mt-1 table-container-despachos">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Número Despacho</th>
                                            <th>Fecha Despacho</th>
                                            <th>Código Recibidor</th>
                                            <th>Tipo Salida</th>
                                            <th>Código Puerto</th>
                                            <th>Planta Destino</th>
                                            <th>Guía de Despacho</th>
                                            <th>Nro de Embarque</th>
                                        </tr>
                                    </thead>
                                    <tbody id="enca_despa">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="busquedaEmbarqueModal" tabindex="-1" aria-labelledby="busquedaEmbarqueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="busquedaEmbarqueModalLabel">Búsqueda embarques</h1>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i></button>
                        </div>
                        <div class="container-fluid">
                            <div class="mt-1 table-container-despachos">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Código Embarque</th>
                                            <th>Recibidor</th>
                                            <th>Código Operación</th>
                                            <th>Nave</th>
                                            <th>Fecha Zapre</th>
                                            <th>Embarcador</th>
                                            <th>Puerto Origen</th>
                                            <th>País Destino</th>
                                            <th>Puerto Destino</th>
                                            <th>Tipo Valorización</th>
                                        </tr>
                                    </thead>
                                    <tbody id="enca_embarque">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header" id="header_pallet">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir pallets</h1>
                            <button type="button" id="add_pallet" class="btn btn-success btn-lg"><i class="fa-solid fa-square-plus"></i></button>
                            <button type="button" id="edit_pallet" class="btn btn-warning btn-lg" disabled data-bs-dismiss="modal"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i></button>
                        </div>
                        <div class="container-fluid" id="detalle_pallet">
                            <div class="mb-0">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="col-form-label" for="folio">Folio</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-8 pe-0">
                                                <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control form-control-sm" id="folio">
                                            </div>
                                            <div class="col-4">
                                                <button type="button" id="check_pallet" class="btn btn-success btn-sm col-12"><i class="fa-solid fa-square-check"></i></button>
                                            </div>
                                        </div>
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
                                        <input type="text" class="form-control form-control-sm" id="termografo">
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
                                            <option value="0" selected>N/A</option>
                                            <?php
                                            $functions->getTermografo($cone->connectToServ());
                                            ?>
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
                                                    <input class="form-check-input" name="estiba" type="radio" id="estiba_izq" value="1">
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
                                                    <input class="form-check-input" name="estiba" type="radio" value="2" id="estiba_der">
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
                            <div class="mb-0 table-container">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Embalaje</th>
                                            <th>Variedad</th>
                                            <th>Calibre</th>
                                            <th>Productor</th>
                                            <th>Packing</th>
                                            <th>Fecha</th>
                                            <th>Predio</th>
                                            <th>Cuartel</th>
                                            <th>Cajas</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deta_pallet">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    session_unset();
    session_destroy();
    header('Location: ../login.php');
}
?>