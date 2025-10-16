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
        <link rel="icon" href="../img/icons/favicon.ico" sizes="32x32">
        <link rel="apple-touch-icon" href="../img/icons/apple-touch-icon.png" type="image/png">
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
        <script src="../js/mod_despachos.js?<?= md5(time()) ?>"></script>
        <script src="../js/quagga.js?<?= md5(time()) ?>"></script>
        <script src="../js/file_input.js?<?= md5(time()) ?>"></script>
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
            <div id="encabezado_despacho" class="mb-5">
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="form-floating">
                                <select class="form-select" id="clientes">
                                    <?php
                                    $functions->getClientesCod($cone->connectToServ());
                                    ?>
                                </select>
                                <label for="clientes">Cliente</label>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="form-floating">
                                <select class="form-select" id="planta">
                                    <?php
                                    $functions->getPlantaDesp($cone->connectToServ());
                                    ?>
                                </select>
                                <label for="planta">Planta</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" class="form-control" id="nro_despacho">
                                    <label for="nro_despacho">Nro Despacho</label>
                                </div>
                                <button type="button" id="get_despacho" class="btn btn-success"><i class="fa-solid fa-square-check"></i></button>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="patente">
                                <label for="patente">Patente</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="form-floating">
                                <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" id="fecha_des">
                                <label for="fecha_des">Fecha</label>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="form-floating">
                                <input type="time" value="<?= date('H:i') ?>" class="form-control" id="hora_des">
                                <label for="hora_des">Hora</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="form-floating">
                                <select class="form-select" id="tipo_mov">
                                    <?php
                                    $functions->getTipoMov($cone->connectToServ());
                                    ?>
                                </select>
                                <label for="tipo_mov">Tipo Mov</label>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="embarque">
                                    <label for="embarque">Embarque</label>
                                </div>
                                <button id="get_embarques" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#busquedaEmbarqueModal" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row align-items-center">
                        <div class="col-6 pe-0">
                            <div class="form-floating">
                                <select class="form-select" id="consig">
                                    <?php
                                    $functions->getConsignatarios($cone->connectToServ());
                                    ?>
                                </select>
                                <label for="consig">Consig.</label>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" id="if_termografo" checked>
                                </div>
                                <input type="text" class="form-control" value="Termógrafo" disabled id="label_termo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="form-floating">
                                <input type="number" style="display: none" id="pto_destino_cod">
                                <input type="text" class="form-control" id="pto_destino">
                                <label for="pto_destino">Puerto</label>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="form-floating">
                                <input type="number" style="display: none" id="nave_cod">
                                <input type="text" class="form-control" id="nave">
                                <label for="nave">Nave</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" value="0" class="form-control" id="tot_cajas">
                                    <label for="tot_cajas">Cajas</label>
                                </div>

                                <div class="form-floating">
                                    <input type="text" class="form-control" id="guia">
                                    <label for="guia">Guía</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ps-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="dus">
                                    <label for="dus">DUS</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="sps">
                                    <label for="sps">SPS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="row">
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
            <button type="button" class="btn btn-success btn-lg col-2" data-bs-toggle="modal" disabled data-bs-target="#exampleModal" id="add_pallet_deta">
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
                            <div class="input-group">
                                <button type="button" id="check_pallet" class="btn btn-success"><i class="fa-solid fa-square-check"></i></button>
                                <div class="form-floating">
                                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control" id="folio">
                                    <label for="folio">Folio</label>
                                </div>
                                <button type="button" id="folio_input_btn" class="btn btn-warning"><i class="fa-solid fa-camera"></i></button>
                            </div>
                            <input id="folio_input" type="file" accept="image/*" capture="camera" style="clip: rect(0 0 0 0); clip-path: inset(50%);  height: 1px;  overflow: hidden;  position: absolute;white-space: nowrap;width: 1px;">
                            <div class="controls" style="display:none">
                                <fieldset class="reader-config-group">
                                    <label>
                                        <span>Barcode-Type</span>
                                        <select name="decoder_readers">
                                            <option value="code_128" selected="selected">Code 128</option>
                                        </select>
                                    </label>
                                    <label>
                                        <span>Resolution (long side)</span>
                                        <select name="input-stream_size">
                                            <option selected="selected" value="1280">1280px</option>
                                        </select>
                                    </label>
                                    <label>
                                        <span>Patch-Size</span>
                                        <select name="locator_patch-size">
                                            <option selected="selected" value="x-large">x-large</option>
                                        </select>
                                    </label>
                                    <label>
                                        <span>Half-Sample</span>
                                        <input type="checkbox" name="locator_half-sample" />
                                    </label>
                                    <label>
                                        <span>Single Channel</span>
                                        <input type="checkbox" name="input-stream_single-channel" />
                                    </label>
                                    <label>
                                        <span>Workers</span>
                                        <select name="numOfWorkers">
                                            <option selected="selected" value="1">1</option>
                                        </select>
                                    </label>
                                </fieldset>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="tipo">
                                    <label for="tipo">Tipo</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="variedad">
                                    <label for="variedad">Variedad</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="embalaje">
                                    <label for="embalaje">Emb</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="categoria">
                                    <label for="categoria">Cat</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="status">
                                    <label for="status">Status</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="condicion">
                                    <label for="condicion">Condición</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="calidad">
                                    <label for="calidad">C.Calidad</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="destino">
                                    <label for="destino">Destino</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="cajas">
                                    <label for="cajas">Cajas</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="etiqueta">
                                    <label for="etiqueta">Etiqueta</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="termografo">
                                    <label class="col-form-label" for="termografo">Termógrafo</label>
                                </div>
                                <div class="form-floating">
                                    <select class="form-select form-select-sm" id="marca_termografo">
                                        <option value="0" selected>N/A</option>
                                        <?php
                                        $functions->getTermografo($cone->connectToServ());
                                        ?>
                                    </select>
                                    <label for="marca_termografo">Marca</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="input-group input-group-sm">
                                <div class="form-floating">
                                    <input type="number" maxlength="4" step="0.1" class="form-control" id="t1_pallet">
                                    <label for="t1_pallet">T1°</label>
                                </div>
                                <div class="form-floating">
                                    <input type="number" maxlength="4" step="0.1" class="form-control" id="t2_pallet">
                                    <label for="t2_pallet">T2°</label>
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