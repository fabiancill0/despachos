<?php
include '../model/connections.php';
include '../model/functions.php';
$conection = new Connections();
$functions = new Functions();
$connection = $conection->connectToServ();
if (isset($_GET['cliente'])) {

    $despachos = $functions->getEncaEmbarqueByCliente($_GET['cliente']);
    $data = odbc_exec($connection, $despachos);
    while ($row = odbc_fetch_array($data)) {
        $row = array_map('utf8_decode', $row);
?>
        <tr>
            <td><button class="btn btn-primary btn-sm" onclick="loadEmbarque('<?= $row['embq_codigo']; ?>')" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-magnifying-glass"></i></button></td>
            <td><?= $row['embq_codigo']; ?></td>
            <td><?= $row['reci_codigo']; ?></td>
            <td><?= $row['oper_codigo']; ?></td>
            <td><?= $row['embq_nomnav']; ?></td>
            <td><?= date("d/m/Y", strtotime($row['embq_fzarpe'])); ?></td>
            <td><?= $row['embc_codigo']; ?></td>
            <td><?= $row['embq_ptoori']; ?></td>
            <td><?= $row['dest_codigo']; ?></td>
            <td><?= $row['embq_descar']; ?></td>
            <td><?= $row['embq_tipova']; ?></td>
        </tr>
<?php
    }
} else if (isset($_GET['data'])) {
    $data = explode(';', $_GET['data']);
    $embarque = $data[0];
    $cliente = $data[1];
    $enca_embarque = $functions->getEncaEmbarqueByCod($embarque, $cliente);
    $data_embarque = odbc_exec($connection, $enca_embarque);
    $row = odbc_fetch_array($data_embarque);
    $row_edit = [
        'embq_codigo' => $row['embq_codigo'],
        'reci_codigo' => $row['reci_codigo'],
        'reci_nombre' => $functions->getNombreRecibidor($connection, $row['reci_codigo']),
        'nave_codigo' => $row['nave_codigo'],
        'embq_nomnav' => $row['embq_nomnav'],
        'embq_descar' => $row['embq_descar'],
        'nomb_puerto' => $functions->getNombrePuertos($connection, $row['embq_descar']),
        'embq_numdus' => is_null($row['embq_numdus']) ? '0' : $row['embq_numdus']
    ];
    echo json_encode($row_edit);
}
odbc_close($connection);
?>