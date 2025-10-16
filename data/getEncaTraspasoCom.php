<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$connection = $conection->connectToServ();
if (isset($_GET['cliente'])) {
    $despachos = $functions->getEncaTraspasoByCliente($_GET['cliente']);
    $data = odbc_exec($connection, $despachos);
    while ($row = odbc_fetch_array($data)) {
        $row = array_map('utf8_decode', $row);
?>
        <tr>
            <td><button class="btn btn-primary btn-sm" onclick="loadTraspaso('<?= $row['mfge_numero']; ?>')" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-magnifying-glass"></i></button></td>
            <td><?= $row['mfge_numero']; ?></td>
            <td><?= date("d/m/Y", strtotime($row['mfge_fecmov'])); ?></td>
            <td><?= $functions->getNombreEspecie($connection, $row['espe_codigo']); ?></td>
            <td><?= $row['plde_codigo']; ?></td>
            <td><?= number_format($row['mfge_tpneto'], 2, ',', '.'); ?></td>
            <td><?= $row['mfge_totbul']; ?></td>
        </tr>
<?php
    }
} else if (isset($_GET['nro_desp'])) {
    $despacho = $_GET['nro_desp'];
    $enca_despacho = $functions->getEncaTraspasoByNumero($despacho);
    $data_despacho = odbc_exec($connection, $enca_despacho);
    $row = odbc_fetch_array($data_despacho);
    $row_edit = [
        'mfge_numero' => $row['mfge_numero'],
        'mfge_fecmov' => $row['mfge_fecmov'],
        'espe_codigo' => $row['espe_codigo'],
        'clie_codigo' => $row['clie_codigo'],
        'plde_codigo' => $row['plde_codigo'],
        'mfge_tpneto' => $row['mfge_tpneto'],
        'mfge_totbul' => $row['mfge_totbul'],
        'mfge_guisii' => $row['mfge_guisii'],
        'mfge_observ' => $row['mfge_observ'],
        'refg_horasa' => $row['refg_horasa']
    ];
    echo json_encode($row_edit);
}
odbc_close($connection);
