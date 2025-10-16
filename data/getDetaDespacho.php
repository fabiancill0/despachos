<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$despacho = $_GET['nro_desp'];
$connection = $conection->connectToServ();
if (isset($_GET['type'])) {
    $query_despacho = $functions->getDetaDespachoGranel($despacho);
    $data_despacho = odbc_exec($connection, $query_despacho);
    $row_edit = [];
    while ($row = odbc_fetch_array($data_despacho)) {
        $row_edit[$row['paen_numero']] = [
            'clie_codigo' => $row['clie_codigo'],
            'defe_ladoes' => $row['defe_ladoes'],
            'pafr_varrot' => '',
            'emba_codigo' => '',
            'etiq_codigo' => '',
            'pafr_calrot' => '',
            'paen_ccajas' => 0,
            'paen_tipopa' => '',
            'cate_codigo' => ''
        ];
    }
    foreach ($row_edit as $key => $value) {
        $deta_pallet = odbc_fetch_array(odbc_exec($connection, $functions->getDetaPalletDespachoGranel($key, $row_edit[$key]['clie_codigo'])));
        $row_edit[$key]['pafr_varrot'] = $functions->getNombreVariedad($connection, $deta_pallet['pafr_varrot'], $deta_pallet['espe_codigo']);
        $row_edit[$key]['emba_codigo'] = $deta_pallet['emba_codigo'];
        $row_edit[$key]['etiq_codigo'] = $functions->getNombreEtiqueta($connection, $deta_pallet['etiq_codigo']);
        $row_edit[$key]['pafr_calrot'] = $deta_pallet['pafr_calrot'];
        $row_edit[$key]['paen_ccajas'] = $deta_pallet['paen_ccajas'];
        $row_edit[$key]['paen_tipopa'] = $deta_pallet['paen_tipopa'] == 1 ? 'COMPLETO' : 'PUCHO';
        $row_edit[$key]['cate_codigo'] = $functions->getNombreCategoria($connection, $deta_pallet['cate_codigo']);
    }
    if ($row_edit == []) {
        $row_edit = ['error' => 'No se encontraron datos para el despacho solicitado.'];
    }
} else {
    $query_despacho = $functions->getDetaDespacho($despacho);
    $data_despacho = odbc_exec($connection, $query_despacho);
    $row_edit = [];
    while ($row = odbc_fetch_array($data_despacho)) {
        $row_edit[$row['paen_numero']] = [
            'clie_codigo' => $row['clie_codigo'],
            'defe_tempe1' => is_null($row['defe_tempe1']) ? '' : $row['defe_tempe1'],
            'defe_tempe2' => is_null($row['defe_tempe2']) ? '' : $row['defe_tempe2'],
            'defe_ladoes' => $row['defe_ladoes'],
            'defe_termog' => is_null($row['defe_termog']) ? '' : $row['defe_termog'],
            'tema_codigo' => is_null($row['tema_codigo']) ? 0 : $row['tema_codigo'],
            'pafr_varrot' => '',
            'emba_codigo' => '',
            'etiq_codigo' => '',
            'pafr_calrot' => '',
            'paen_ccajas' => 0,
            'paen_tipopa' => '',
            'stat_codigo' => ''
        ];
    }
    foreach ($row_edit as $key => $value) {
        $deta_pallet = odbc_fetch_array(odbc_exec($connection, $functions->getDetaPalletDespacho($key, $row_edit[$key]['clie_codigo'])));
        $row_edit[$key]['pafr_varrot'] = $functions->getNombreVariedad($connection, $deta_pallet['pafr_varrot'], $deta_pallet['espe_codigo']);
        $row_edit[$key]['emba_codigo'] = $deta_pallet['emba_codigo'];
        $row_edit[$key]['etiq_codigo'] = $functions->getNombreEtiqueta($connection, $deta_pallet['etiq_codigo']);
        $row_edit[$key]['pafr_calrot'] = $deta_pallet['pafr_calrot'];
        $row_edit[$key]['paen_ccajas'] = $deta_pallet['paen_ccajas'];
        $row_edit[$key]['paen_tipopa'] = $deta_pallet['paen_tipopa'] == 1 ? 'COMPLETO' : 'PUCHO';
        $row_edit[$key]['stat_codigo'] = $functions->getNombreStatus($connection, $deta_pallet['stat_codigo']);
    }
    if ($row_edit == []) {
        $row_edit = ['error' => 'No se encontraron datos para el despacho solicitado.'];
    }
}

echo json_encode($row_edit);
odbc_close($connection);
