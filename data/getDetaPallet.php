<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
$queryEnca = "SELECT emba_codigo,
vari_codigo,
pafr_varrot,
pafr_calibr,
pafr_calrot,
prod_codigo,
pafr_prdrot,
pafr_copack,
pafr_fecemb,
PAFR_HUERT1,
PAFR_CUART1,
sum(pafr_ccajas) as pafr_ccajas FROM DBA.palletfruta WHERE paen_numero = $folio group by emba_codigo,
vari_codigo,
pafr_varrot,
pafr_calibr,
pafr_calrot,
prod_codigo,
pafr_prdrot,
pafr_copack,
pafr_fecemb,
PAFR_HUERT1,
PAFR_CUART1";
$result = odbc_exec($conexion, $queryEnca);
$row_edit = [];
while ($row = odbc_fetch_array($result)) {
    $row = array_map('utf8_decode', $row);
?>
    <tr>
        <td><?= $row['emba_codigo']; ?></td>
        <td><?= $row['pafr_varrot']; ?></td>
        <td><?= $row['pafr_calrot']; ?></td>
        <td><?= $row['pafr_prdrot']; ?></td>
        <td><?= $row['pafr_copack']; ?></td>
        <td><?= date("d/m/Y", strtotime($row['pafr_fecemb'])); ?></td>
        <td><?= $row['PAFR_HUERT1']; ?></td>
        <td><?= $row['PAFR_CUART1']; ?></td>
        <td><?= $row['pafr_ccajas']; ?></td>
    </tr>
<?php } ?>