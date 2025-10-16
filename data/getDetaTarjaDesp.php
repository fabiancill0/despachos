<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();

$folio = $_GET['tarja'];
$cliente = $_GET['cliente'];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getEncaTarja($cliente, $folio);
$result = odbc_exec($conexion, $queryEnca);
$row_edit = [];
$row = odbc_fetch_array($result);
$row_edit[] = [
    'fgmb_nrotar' => $row['fgmb_nrotar'],
    'bultos' => intval($row['bultos']),
    'kilos' => str_replace('.', ',', $row['kilos']),
    'mfgp_pesore' => str_replace('.', ',', $row['mfgp_pesore']),
    'lote_codigo' => $row['lote_codigo'],
    'prod_codigo' => $row['prod_codigo'],
    'bins_numero' => $row['bins_numero']
];


echo json_encode($row_edit);
odbc_close($conexion);
