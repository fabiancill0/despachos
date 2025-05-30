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
        $data = explode(';', $_POST['palletList']);
        $folio = $data[0];
        $temp = explode('/', $data[1]);
        $temp1 = $temp[0] == '' ? null : $temp[0];
        $temp2 = $temp[1] == '' ? null : $temp[1];
        $termo = $data[2] == '' ? null : $data[1];
        $termoMarca = $data[3] == 0 ? null : $data[2];
        odbc_execute($stmt_deta, [$_POST['planta'], $ultimo['defe_numero'], $_POST['cliente'], $folio, $termo, $temp1, $temp2, '', '', date('Y-m-d H:i:s'), $termoMarca]);
    } else if ($_GET['type'] == 'enca') {
        $data = $_POST['data_enca'];

        $query_enca = "INSERT INTO dba.despafrigoen
(plde_codigo, defe_numero, clie_codigo, defe_fecdes, defe_cantar, defe_tiposa, puer_codigo, defe_guides, defe_cancaj,
defe_horade, defe_canpal, tran_codigo, tica_codigo, embq_codigo, defe_patent, defe_pataco, defe_chofer, defe_plasag,
defe_fecact, defe_horact, defe_tpcont, defe_nrcont, tran_fechat, defe_espmul, defe_especi, defe_chfrut, defe_celcho,
defe_nrosps, defe_ctlter, defe_fecdig) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $query_enca_tran = "INSERT INTO dba.despafrigoen
(defe_numero, defe_fecdes, defe_horade, defe_tiposa, puer_codigo, defe_guides, plde_codigo, clie_codigo, 
 embq_codigo, tran_fechat, defe_nrosps, defe_ctlter, defe_fecdig) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
            $data['if_termografo'],
            date('Y-m-d H:i:s')
        ]);

        echo json_encode($nuevo);
    }
}
