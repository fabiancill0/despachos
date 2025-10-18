<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();

$folio = $_GET['tarja'];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getEncaTarja($folio);
$result = odbc_exec($conexion, $queryEnca);
$row_edit = [];
$row = odbc_fetch_array($result);
$row_edit[] = [
    'fgmb_nrotar' => $row['fgmb_nrotar'],
    'bultos' => number_format($row['bultos'], 0),
    'lote_codigo' => $row['lote_codigo'],
    'prod_codigo' => $row['prod_codigo'],
    'bins_numero' => $row['bins_numero'],
    'lote_pltcod' => $row['lote_pltcod'],
    'lote_espcod' => $row['lote_espcod'],
    'plde_codigo' => $row['lote_pltcod'] . ' - ' . $functions->getNombrePlanta($conexion, $row['lote_pltcod']),
    'espe_codigo' => $row['lote_espcod'] . ' - ' . $functions->getNombreEspecie($conexion, $row['lote_espcod'])
];


echo json_encode($row_edit);
odbc_close($conexion);
