<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$cliente = $_GET['cliente'];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getEncaTarja($cliente, $folio);
$result = odbc_exec($conexion, $queryEnca);
$row = odbc_fetch_array($result);
if (isset($_GET['type'])) {
    $row_edit = [
        'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['lote_espcod']),
        'lote_codigo' => $row['lote_espcod'],
        'prod_codigo' => $functions->getNombreProductor($conexion, $row['prod_codigo']),
        'bultos' => $row['bultos'],
        'kilos' => number_format($row['kilos'], 2, '.', '')
    ];
    echo json_encode($row_edit);
} else {
    if ($row === false) {
        echo json_encode(['error' => 'Tarja no existe o el cliente es incorrecto!']);
    } else {
        $row_edit = [
            'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['lote_espcod']),
            'lote_codigo' => $row['lote_codigo'],
            'prod_codigo' => $functions->getNombreProductor($conexion, $row['prod_codigo']),
            'bultos' => number_format($row['bultos'], 0),
            'kilos' => number_format($row['kilos'], 2, ',', '.')
        ];
        echo json_encode($row_edit);
    }
}

odbc_close($conexion);
