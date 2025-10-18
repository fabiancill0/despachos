<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$despacho = $_GET['nro_desp'];
$connection = $conection->connectToServ();
$query_despacho = $functions->getDetaTraspaso($despacho);
$data_despacho = odbc_exec($connection, $query_despacho);
$row_edit = [];
while ($row = odbc_fetch_array($data_despacho)) {
    $row_edit[$row['fgmb_nrotar']] = [
        'plde_codigo' => $row['plde_codigo'] . '-' . $functions->getNombrePlanta($connection, $row['plde_codigo']),
        'fgmb_canbul' => number_format($row['fgmb_canbul'], 0),
        'lote_espcod' => $row['lote_espcod'] . '-' . $functions->getNombreEspecie($connection, $row['lote_espcod']),
        'lote_codigo' => $row['lote_codigo'],
        'prod_codigo' => $row['prod_codigo'],
        'bins_numero' => $row['bins_numero'],
        'fgmb_kilbru' => number_format($row['fgmb_kilbru'], 2, ',', '.')
    ];
}
if ($row_edit == []) {
    $row_edit = ['error' => 'No se encontraron datos para el despacho solicitado.'];
}
echo json_encode($row_edit);
odbc_close($connection);
