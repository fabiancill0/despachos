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
        $nro_pallet = $_POST['tot_pallets'];
        $planta = $_POST['planta'];
        $cliente = $_POST['cliente'];
        $despacho = $_POST['nro_despacho'];
        $cajas = $_POST['tot_cajas'];
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
        $result = odbc_execute($stmt_deta, [$planta, $despacho, $cliente, $folio, $termo, $temp1, $temp2, $lado, $nro_pallet, date('Y-m-d H:i:s'), $termoMarca]);
        $query_enca_update = "UPDATE dba.despafrigoen SET defe_cantar = ?, defe_cancaj = ?, defe_canpal = ?, defe_fecact = ?, defe_horact = ? WHERE defe_numero = ?";
        $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
        $result_update = odbc_execute($stmt_enca_update, [$nro_pallet, $cajas, $nro_pallet, date('Y-m-d'), date('H:i:s'), $despacho]);
        if ($result && $result_update) {
            echo json_encode(['status' => 'success', 'message' => 'Pallet agregado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al agregar el pallet.']);
        }
    } else if ($_GET['type'] == 'pallet_gran') {
        $query_deta = "INSERT INTO dba.despafrigode
        (plde_codigo, defe_numero, clie_codigo, paen_numero, defe_ladoes, defe_filaes, tran_fechat)
         VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt_deta = odbc_prepare($connnect, $query_deta);
        $nro_pallet = $_POST['tot_pallets'];
        $folio = $_POST['palletList'];
        if ($nro_pallet % 2 == 0) {
            $lado = 2;
        } else {
            $lado = 1;
        }
        $result = odbc_execute($stmt_deta, [$_POST['planta'], $_POST['nro_despacho'], $_POST['cliente'], $folio, $lado, $nro_pallet, date('Y-m-d H:i:s')]);

        $query_enca_update = "UPDATE dba.despafrigoen SET defe_cantar = ?, defe_cancaj = ?, defe_canpal = ?, defe_fecact = ?, defe_horact = ? WHERE defe_numero = ?";
        $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
        $result_update = odbc_execute($stmt_enca_update, [$nro_pallet, $_POST['tot_cajas'], $nro_pallet, date('Y-m-d'), date('H:i:s'), $_POST['nro_despacho']]);
        if ($result && $result_update) {
            echo json_encode(['status' => 'success', 'message' => 'Pallet agregado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al agregar el pallet.']);
        }
    } else if ($_GET['type'] == 'tarja') {
        $query_deta = "INSERT INTO dba.spro_movtofrutagrandeta_tarjas
        (plde_codigo, tpmv_codigo, mfge_numero, clie_codigo, mfgd_secuen, fgmb_nrotar, fgmb_canbul, lote_pltcod, lote_espcod, lote_codigo)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_deta = odbc_prepare($connnect, $query_deta);
        $info = explode(';', $_POST['info']);
        $lote_pltcod = $info[0];
        $lote_espcod = $info[1];
        $lote_codigo = $info[2];
        $nro_pallet = $_POST['totBultos'];
        $folio = $_POST['palletList'];
        $result = odbc_execute($stmt_deta, [$_POST['planta'], 36, $_POST['nro_despacho'], $_POST['cliente'], $nro_pallet, $folio, $_POST['bultos'], $lote_pltcod, $lote_espcod, $lote_codigo]);

        $query_enca_update = "UPDATE dba.spro_movtofrutagranenca SET mfge_totbul = ?
         WHERE mfge_numero = ? and clie_codigo = ? and plde_codigo = ? and tpmv_codigo = 36";
        $stmt_enca_update = odbc_prepare($connnect, $query_enca_update);
        $result_update = odbc_execute($stmt_enca_update, [$_POST['totBultos'], $_POST['nro_despacho'], $_POST['cliente'], $_POST['planta']]);
        if ($result && $result_update) {
            echo json_encode(['status' => 'success', 'message' => 'Tarja agregada correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al agregar la tarja.']);
        }
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
    } else if ($_GET['type'] == 'edit_pallet_gran') {
        $query_deta = "UPDATE dba.despafrigode SET 
         tran_fechat = ?
         WHERE plde_codigo = ? AND defe_numero = ? AND clie_codigo = ? AND paen_numero = ?";

        $stmt_deta = odbc_prepare($connnect, $query_deta);
        odbc_execute($stmt_deta, [date('Y-m-d H:i:s'), $_POST['planta'], $_POST['nro_despacho'], $_POST['cliente'], $_POST['folio']]);
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
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Encabezado de despacho creado correctamente.', 'nro_despacho' => $nuevo]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al crear el encabezado de despacho.']);
        }
    } else if ($_GET['type'] == 'enca_granel') {
        $data = $_POST['data_enca'];

        $query_enca_tran = "INSERT INTO dba.despafrigoen (defe_numero, defe_fecdes, defe_horade, defe_tiposa, defe_guides, plde_codigo, clie_codigo, 
        tran_fechat, defe_patent, defe_fecdig, tica_codigo, tran_codigo, clpr_rut, defe_chofer, defe_pataco) VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_enca = odbc_prepare($connnect, $query_enca_tran);
        $nuevo = $ultimo['defe_numero'] + 1;
        $result = odbc_execute($stmt_enca, [
            $nuevo,
            $data['fecha_des'],
            $data['hora_des'],
            $data['tipo_mov'],
            $data['guia'],
            $data['planta'],
            $data['clientes'],
            date('Y-m-d H:i:s'),
            $data['patente'],
            date('Y-m-d H:i:s'),
            $data['tipo_camion'],
            $data['trans'],
            $data['comprador'],
            $data['chofer'],
            $data['acoplado'],
        ]);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Encabezado de despacho creado correctamente.', 'nro_despacho' => $nuevo]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al crear el encabezado de despacho.']);
        }
    } else if ($_GET['type'] == 'enca_traspaso') {
        $data = $_POST['data_enca'];
        $ultimoTraspaso = odbc_fetch_array(odbc_exec($connnect, $functions->getUltimoTraspaso()));
        $query_enca_tran = "INSERT INTO dba.spro_movtofrutagranenca (clie_codigo, plde_codigo, tpmv_codigo, mfge_numero, espe_codigo, mfge_fecmov, mfge_estmov,
        mfge_guisii, mfge_observ, mfge_totbul, refg_horasa, mfge_comput) VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_enca = odbc_prepare($connnect, $query_enca_tran);
        $nuevo = $ultimoTraspaso['mfge_numero'] + 1;
        $result = odbc_execute($stmt_enca, [
            $data['clientes'],
            $data['planta'],
            36,
            $nuevo,
            $data['especie'],
            $data['fecha_des'],
            1,
            $data['guia'],
            $data['obs'],
            $data['tot_bultos'],
            $data['hora_des'],
            'PDA'
        ]);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Encabezado de movimiento creado correctamente.', 'nro_despacho' => $nuevo]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al crear el encabezado de movimiento.']);
        }
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
odbc_close($connnect);
