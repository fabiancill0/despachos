<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getEncaTarja($folio);
$result = odbc_exec($conexion, $queryEnca);
$row = odbc_fetch_array($result);
if (isset($_GET['type'])) {
    $row_edit = [
        'plde_codigo' => $functions->getNombrePlanta($conexion, $row['lote_pltcod']),
        'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['lote_espcod']),
        'lote_codigo' => $row['lote_espcod'],
        'prod_codigo' => $functions->getNombreProductor($conexion, $row['prod_codigo']),
        'bultos' => number_format($row['bultos'], 0),
        'csg' => $functions->getCSG($conexion, $row['prod_codigo'], $row['csg']),
        'sdp' => $functions->getSDP($conexion, $row['prod_codigo'], $row['csg'], $row['sdp']),
    ];
    echo json_encode($row_edit);
} else {
    if ($row === false) {
        echo json_encode(['error' => 'Tarja no existe o el cliente es incorrecto!']);
    } else {
        $row_edit = [
            'plde_codigo' => $functions->getNombrePlanta($conexion, $row['lote_pltcod']),
            'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['lote_espcod']),
            'lote_codigo' => $row['lote_codigo'],
            'prod_codigo' => $functions->getNombreProductor($conexion, $row['prod_codigo']),
            'bultos' => number_format($row['bultos'], 0),
            'csg' => $functions->getCSG($conexion, $row['prod_codigo'], $row['csg']),
            'sdp' => $functions->getSDP($conexion, $row['prod_codigo'], $row['csg'], $row['sdp']),
        ];
        echo json_encode($row_edit);
    }
}

odbc_close($conexion);
