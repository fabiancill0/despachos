<?php
include 'connections.php';
include 'functions.php';
include 'encdec.php';

$functions = new Functions();
$conn = new Connections();

$connnect = $conn->connectToServ();
$query = "DELETE FROM dba.despafrigode WHERE defe_numero = ? AND paen_numero = ?";
$stmt = odbc_prepare($connnect, $query);
$folio = $_POST['folio'];
$nro_despacho = $_POST['nro_despacho'];
$result = odbc_execute($stmt, [$nro_despacho, $folio]);
$query_enca_update = "UPDATE dba.despafrigoen SET defe_cantar = ?, defe_cancaj = ?, defe_canpal = ? WHERE defe_numero = ?";
$stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
$result = odbc_execute($stmt_enca_update, [$_POST['globalCounter'], $_POST['totCajas'], $_POST['globalCounter'], $_POST['nro_despacho']]);
