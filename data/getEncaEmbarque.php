<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$connection = $conection->connectToServ();
$despachos = $functions->getEncaEmbarqueByCliente($_GET['cliente']);
$data = odbc_exec($connection, $despachos);
while ($row = odbc_fetch_array($data)) {
    $row = array_map('utf8_decode', $row);
?>
    <tr>
        <td><input class="form-check-input" name="embarques_search" type="radio"></td>
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
?>