<?php
include 'connections.php';
include 'functions.php';
include 'encdec.php';

$functions = new Functions();
$conn = new Connections();

$connnect = $conn->connectToServ();
$ultimo = odbc_fetch_array(odbc_exec($connnect, $functions->getUltimoDespacho()));
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'pallet') {
        $query_deta = "INSERT INTO dba.despafrigode
        (plde_codigo, defe_numero, clie_codigo, paen_numero, defe_termog, defe_tempe1, defe_tempe2, defe_ladoes, defe_filaes,tran_fechat, tema_codigo)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_deta = odbc_prepare($connnect, $query_deta);
        $nro_pallet = $_POST['globalCounter'];
        $data = explode(';', $_POST['palletList']);
        $folio = $data[0];
        $temp = explode('/', $data[1]);
        $temp1 = $temp[0] == '' ? null : $temp[0];
        $temp2 = $temp[1] == '' ? null : $temp[1];
        $termo = $data[2] == '' ? null : $data[2];
        $termoMarca = $data[3] == 0 ? null : $data[3];
        if ($nro_pallet % 2 == 0) {
            $lado = 2;
        } else {
            $lado = 1;
        }
        odbc_execute($stmt_deta, [$_POST['planta'], $_POST['nro_despacho'], $_POST['cliente'], $folio, $termo, $temp1, $temp2, $lado, $nro_pallet, date('Y-m-d H:i:s'), $termoMarca]);

        $query_enca_update = "UPDATE dba.despafrigoen SET defe_cantar = ?, defe_cancaj = ?, defe_canpal = ?, defe_fecact = ?, defe_horact = ? WHERE defe_numero = ?";
        $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
        $result = odbc_execute($stmt_enca_update, [$nro_pallet, $_POST['totCajas'], $nro_pallet, date('Y-m-d'), date('H:i:s'), $_POST['nro_despacho']]);
    } else if ($_GET['type'] == 'edit_pallet') {
        $query_deta = "UPDATE dba.despafrigode SET 
        defe_termog = ?, defe_tempe1 = ?, defe_tempe2 = ?, tran_fechat = ?, tema_codigo = ?
         WHERE plde_codigo = ? AND defe_numero = ? AND clie_codigo = ? AND paen_numero = ?";

        $stmt_deta = odbc_prepare($connnect, $query_deta);
        $temp = explode('/', $_POST['temp']);
        $temp1 = $temp[0] == '' ? null : $temp[0];
        $temp2 = $temp[1] == '' ? null : $temp[1];
        $termo = $_POST['termo'] == '' ? null : $_POST['termo'];
        $termoMarca = $_POST['marca_termo'] == 0 ? null : $_POST['marca_termo'];
        odbc_execute($stmt_deta, [$termo, $temp1, $temp2, date('Y-m-d H:i:s'), $termoMarca, $_POST['planta'], $_POST['nro_despacho'], $_POST['cliente'], $_POST['folio']]);
    } else if ($_GET['type'] == 'enca') {
        $data = $_POST['data_enca'];

        $query_enca_tran = "INSERT INTO dba.despafrigoen (defe_numero, defe_fecdes, defe_horade, defe_tiposa, puer_codigo, defe_guides, plde_codigo, clie_codigo, 
        embq_codigo, tran_fechat, defe_nrosps, defe_numdus, defe_ctlter, defe_patent, defe_fecdig) VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_enca = odbc_prepare($connnect, $query_enca_tran);
        $nuevo = $ultimo['defe_numero'] + 1;
        $result = odbc_execute($stmt_enca, [
            $nuevo,
            $data['fecha_des'],
            $data['hora_des'],
            $data['tipo_mov'],
            $data['pto_destino_cod'],
            $data['guia'],
            $data['planta'],
            $data['clientes'],
            $data['embarque'],
            date('Y-m-d H:i:s'),
            $data['sps'],
            $data['dus'],
            $data['if_termografo'],
            $data['patente'],
            date('Y-m-d H:i:s')
        ]);
        echo json_encode($nuevo);
    } else if ($_GET['type'] == 'update_enca') {
        $data = $_POST['data_enca'];

        $query_enca_update = "UPDATE dba.despafrigoen SET
        plde_codigo = ?, clie_codigo = ?, defe_fecdes = ?, defe_cantar = ?, defe_tiposa = ?, puer_codigo = ?, defe_guides = ?, defe_cancaj = ?, defe_horade = ?,
        defe_canpal = ?, embq_codigo = ?, defe_patent = ?, defe_fecact = ?, defe_horact = ?, tran_fechat = ?, defe_nrosps = ?, defe_ctlter = ?, defe_fecdig = ?
        WHERE defe_numero = ?";

        $stmt_enca = odbc_prepare($connnect, $query_enca_update);
        $result = odbc_execute($stmt_enca, [
            $data['planta'],
            $data['clientes'],
            $data['fecha_des'],
            $_POST['globalCounter'],
            $data['tipo_mov'],
            $data['pto_destino_cod'],
            $data['guia'],
            $_POST['totCajas'],
            $data['hora_des'],
            $_POST['globalCounter'],
            $data['embarque'],
            $data['patente'],
            date('Y-m-d'),
            date('H:i:s'),
            date('Y-m-d H:i:s'),
            $data['sps'],
            $data['if_termografo'],
            date('Y-m-d H:i:s'),
            $data['nro_despacho']
        ]);
    }
}
