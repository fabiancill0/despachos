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

$query_deta = "INSERT INTO despafrigode
(plde_codigo, defe_numero, clie_codigo, paen_numero, defe_termog, defe_tempe1, defe_tempe2, defe_ladoes, defe_filaes,
tran_fechat, tema_codigo) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$connnect = $conn->connectToServ();
$ultimo = odbc_fetch_array(odbc_exec($connnect, $functions->getUltimoDespacho($_POST['cliente'])));


$stmt = odbc_prepare($connnect, $query_deta);
$éxito = odbc_execute($stmt, [
    $_POST['planta'],
    $ultimo['defe_numero'],
    $_POST['cliente'],
    $_POST['palletList'],
    $_POST['temp1'],
    $_POST['temp2'],
    $_POST['lado'],
    $_POST['fila'],
    $_POST['fecha_des'],
    $_POST['hora_des'],
    $_POST['tema_codigo']
]);


foreach ($_POST['palletList'] as $value) {
}

echo $ultimo['defe_numero'];
echo $_POST['cliente'];
echo                $_POST['planta'];
echo              $_POST['embarque'];
echo              $_POST['nave'];
echo              $_POST['consignatario'];
echo              $_POST['pto_destino'];
echo              $_POST['guia'];
echo              $_POST['sps'];
echo              $_POST['tot_cajas'];
echo              $_POST['fecha_des'];
echo              $_POST['hora_des'];
echo              $_POST['patente'];
echo              $_POST['tipo_mov'];
echo              print_r($_POST['palletList']);
