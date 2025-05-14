<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$connection = $conection->connectToServ();
$despachos = $functions->getEncaDespachoByCliente($_GET['cliente']);
$data = odbc_exec($connection, $despachos);
while ($row = odbc_fetch_array($data)) {
    $row = array_map('utf8_decode', $row);
?>
    <tr>
        <td><input class="form-check-input" name="despachos_search" type="radio"></td>
        <td id="nro_despacho_search"><?= $row['defe_numero']; ?></td>
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
?>