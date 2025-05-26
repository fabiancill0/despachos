<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
if (isset($_GET['cliente'])) {
    $connection = $conection->connectToServ();
    $despachos = $functions->getEncaDespachoByCliente($_GET['cliente']);
    $data = odbc_exec($connection, $despachos);
    while ($row = odbc_fetch_array($data)) {
        $row = array_map('utf8_decode', $row);
?>
        <tr>
            <td><button class="btn btn-primary btn-sm" onclick="loadDespacho('<?= $row['defe_numero']; ?>')" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-magnifying-glass"></i></button></td>
            <td><?= $row['defe_numero']; ?></td>
            <td><?= date("d/m/Y", strtotime($row['defe_fecdes'])); ?></td>
            <td><?= $row['reci_codigo']; ?></td>
            <td><?= $row['defe_tiposa']; ?></td>
            <td><?= $row['puer_codigo']; ?></td>
            <td><?= $row['defe_plades']; ?></td>
            <td><?= $row['defe_guides']; ?></td>
            <td><?= $row['embq_codigo']; ?></td>
        </tr>
<?php
    }
} else if (isset($_GET['data'])) {
    $data = explode(';', $_GET['data']);
    $despacho = $data[0];
    $cliente = $data[1];
    $connection = $conection->connectToServ();
    $enca_despacho = $functions->getEncaDespachoByNumero($cliente, $despacho);
    $data_despacho = odbc_exec($connection, $enca_despacho);
    $row = odbc_fetch_array($data_despacho);
    $row_edit = [
        'defe_numero' => $row['defe_numero'],
        'nave_codigo' => $row['nave_codigo'],
        'embq_nomnav' => $row['embq_nomnav'],
        'clie_codigo' => $row['clie_codigo'],
        'defe_cancaj' => $row['defe_cancaj'],
        'defe_patent' => $row['defe_patent'],
        'defe_nrosps' => $row['defe_nrosps'],
        'plde_codigo' => $row['plde_codigo'],
        'defe_fecdes' => $row['defe_fecdes'],
        'defe_horade' => $row['defe_horade'],
        'reci_codigo' => $row['reci_codigo'],
        'reci_nombre' => $functions->getNombreRecibidor($connection, $row['reci_codigo']),
        'defe_tiposa' => $row['defe_tiposa'],
        'nomb_puerto' => $functions->getNombrePuertos($connection, $row['puer_codigo']),
        'puer_codigo' => $row['puer_codigo'],
        'defe_ctlter' => $row['defe_ctlter'],
        'defe_guides' => is_null($row['defe_guides']) ? '' : $row['defe_guides'],
        'embq_codigo' => $row['embq_codigo']
    ];
    echo json_encode($row_edit);
}
