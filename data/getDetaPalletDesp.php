<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
$queryEnca = "SELECT enca.paen_numero,
deta.pafr_varrot,
enca.emba_codigo,
enca.etiq_codigo,
deta.pafr_calrot,
enca.paen_ccajas,
enca.paen_tipopa,
enca.stat_codigo,
enca.espe_codigo
FROM dba.palletencab AS enca join DBA.palletfruta as deta on enca.paen_numero = deta.paen_numero where enca.paen_numero = $folio
group by enca.paen_numero,
deta.pafr_varrot,
deta.pafr_calrot,
enca.paen_tipopa,
enca.stat_codigo,
enca.emba_codigo,
enca.paen_ccajas,
enca.etiq_codigo,
enca.espe_codigo";
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
