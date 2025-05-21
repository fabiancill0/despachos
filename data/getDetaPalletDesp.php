<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$data = $_GET['folio'];
$deta = explode(';', $data);
$folio = $deta[0];
$cliente = $deta[1];
$conexion = $conn->connectToServ();
$queryEnca = $functions->getDetaPalletDespacho($folio, $cliente);
$result = odbc_exec($conexion, $queryEnca);
$row_edit = [];
$row = odbc_fetch_array($result);
$row_edit[] = [
    'paen_numero' => $row['paen_numero'],
    'pafr_varrot' => $functions->getNombreVariedad($conexion, $row['pafr_varrot'], $row['espe_codigo']),
    'stat_codigo' => $functions->getNombreStatus($conexion, $row['stat_codigo']),
    'emba_codigo' => $row['emba_codigo'],
    'paen_ccajas' => $row['paen_ccajas'],
    'etiq_codigo' => $functions->getNombreEtiqueta($conexion, $row['etiq_codigo']),
    'paen_tipopa' => $row['paen_tipopa'] == 1 ? 'COMPLETO' : 'PUCHO',
    'pafr_calrot' => $row['pafr_calrot']
];
echo json_encode($row_edit);
