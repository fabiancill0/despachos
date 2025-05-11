<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
$queryEnca = "SELECT clie_codigo,
paen_tipopa,
vari_codigo,
cate_codigo,
stat_codigo,
emba_codigo,
cond_codigo,
paen_ccajas,
etiq_codigo,
espe_codigo
FROM dba.palletencab WHERE paen_numero = $folio";
$result = odbc_exec($conexion, $queryEnca);
$row = odbc_fetch_array($result);
if ($row === false) {
    echo json_encode(['error' => 'Pallet no existe!']);
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
    ];
    echo json_encode($row_edit);
}
odbc_close($conexion);
