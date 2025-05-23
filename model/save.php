<?php
include 'connections.php';
include 'functions.php';
include 'encdec.php';

$functions = new Functions();
$conn = new Connections();

$query_enca = "INSERT INTO despafrigoen
(plde_codigo, defe_numero, clie_codigo, defe_fecdes, defe_cantar, defe_tiposa, puer_codigo, defe_guides, defe_cantaj,
defe_horade, defe_canpal, tran_codigo, tica_codigo, embq_codigo, defe_patent, defe_pataco, defe_chofer, defe_plasag,
defe_fecact, defe_horact, defe_tpcont, defe_nrcont, tran_fechat, defe_espmul, defe_especi, defe_chfrut, defe_celcho,
defe_nrosps, defe_ctlter, defe_fecdig) VALUES 
()";

$query_deta = "INSERT INTO dba.despafrigode
(plde_codigo, defe_numero, clie_codigo, paen_numero, defe_termog, defe_tempe1, defe_tempe2, defe_ladoes, defe_filaes,tran_fechat, tema_codigo)
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$connnect = $conn->connectToServ();
$ultimo = odbc_fetch_array(odbc_exec($connnect, $functions->getUltimoDespacho($_POST['cliente'])));

$stmt = odbc_prepare($connnect, $query_deta);
foreach ($_POST['palletList'] as $value) {
    $data = explode(';', $value);
    $pallet = $data[0];
    $temp = explode('/', $data[1]);
    $temp1 = $temp[0] == '' ? null : $temp[0];
    $temp2 = $temp[1] == '' ? null : $temp[1];
    $termo = $data[2] == '' ? null : $data[2];
    $termoMarca = $data[3] == 0 ? null : $data[3];
    $éxito = odbc_execute($stmt, [$_POST['planta'], $ultimo['defe_numero'], $_POST['cliente'], $pallet, $termo, $temp1, $temp2, '', '', date('Y-m-d H:i:s'), $termoMarca]);
}
