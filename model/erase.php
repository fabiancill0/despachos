<?php
include 'connections.php';
include 'functions.php';
include 'encdec.php';

$functions = new Functions();
$conn = new Connections();

$connnect = $conn->connectToServ();
if (isset($_POST['type']) && $_POST['type'] == 'tarja') {
    $query = "DELETE FROM dba.spro_motvofrutagrandeta_tarjas WHERE mfge_numero = ? AND fgmb_nrotar = ?";
    $stmt = odbc_prepare($connnect, $query);
    $folio = $_POST['folio'];
    $nro_despacho = $_POST['nro_despacho'];
    $cliente = $_POST['cliente'];
    $planta = $_POST['planta'];
    $result = odbc_execute($stmt, [$nro_despacho, $folio]);
    $query_enca_update = "UPDATE dba.spro_motvofrutagranenca SET mfge_tpneto = ?, mfge_totbul = ? 
    WHERE mfge_numero = ? and clie_codigo = ? AND plde_codigo = ? and tpmv_codigo = 36";
    $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
    $result = odbc_execute($stmt_enca_update, [$_POST['totKilos'], $_POST['totBultos'], $_POST['nro_despacho'], $cliente, $planta]);
} else {
    $query = "DELETE FROM dba.despafrigode WHERE defe_numero = ? AND paen_numero = ?";
    $stmt = odbc_prepare($connnect, $query);
    $folio = $_POST['folio'];
    $nro_despacho = $_POST['nro_despacho'];
    $result = odbc_execute($stmt, [$nro_despacho, $folio]);
    $query_enca_update = "UPDATE dba.despafrigoen SET defe_cantar = ?, defe_cancaj = ?, defe_canpal = ? WHERE defe_numero = ?";
    $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
    $result = odbc_execute($stmt_enca_update, [$_POST['globalCounter'], $_POST['totCajas'], $_POST['globalCounter'], $_POST['nro_despacho']]);
}
