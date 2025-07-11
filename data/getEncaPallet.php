<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getEncaPallet($folio);
$result = odbc_exec($conexion, $queryEnca);
$row = odbc_fetch_array($result);
if (isset($_GET['type'])) {
    $row_edit = [
        'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['espe_codigo']),
        'cate_codigo' => $functions->getNombreCategoria($conexion, $row['cate_codigo']),
        'stat_codigo' => $functions->getNombreStatus($conexion, $row['stat_codigo']),
        'emba_codigo' => $row['emba_codigo'],
        'cond_codigo' => $functions->getNombreCondicion($conexion, $row['cond_codigo']),
        'paen_ccajas' => $row['paen_ccajas'],
        'etiq_codigo' => $functions->getNombreEtiqueta($conexion, $row['etiq_codigo']),
        'paen_tipopa' => $row['paen_tipopa'] == 1 ? 'COMPLETO' : 'PUCHO',
        'paen_estado' => $row['paen_estado']
    ];
    echo json_encode($row_edit);
} else {
    if ($row === false) {
        echo json_encode(['error' => 'Pallet no existe o el cliente es incorrecto!']);
    } else if ($row['paen_estado'] != 1) {
        echo json_encode(['error' => 'Pallet ya despachado!!']);
    } else {
        $row_edit = [
            'vari_codigo' => $functions->getNombreVariedad($conexion, $row['vari_codigo'], $row['espe_codigo']),
            'cate_codigo' => $functions->getNombreCategoria($conexion, $row['cate_codigo']),
            'stat_codigo' => $functions->getNombreStatus($conexion, $row['stat_codigo']),
            'emba_codigo' => $row['emba_codigo'],
            'cond_codigo' => $functions->getNombreCondicion($conexion, $row['cond_codigo']),
            'paen_ccajas' => $row['paen_ccajas'],
            'etiq_codigo' => $functions->getNombreEtiqueta($conexion, $row['etiq_codigo']),
            'paen_tipopa' => $row['paen_tipopa'] == 1 ? 'COMPLETO' : 'PUCHO',
            'paen_estado' => $row['paen_estado']
        ];
        echo json_encode($row_edit);
    }
}

odbc_close($conexion);
