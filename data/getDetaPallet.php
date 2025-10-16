<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();
$folio = $_GET['folio'];
$conexion = $conn->connectToServ();
if (isset($_GET['type'])) {
    $queryEnca = $functions->getDetaPalletGranel($folio);
    $result = odbc_exec($conexion, $queryEnca);
    $row_edit = [];
    while ($row = odbc_fetch_array($result)) {
        $row = array_map('utf8_decode', $row);
?>
        <tr>
            <td><?= $row['emba_codigo']; ?></td>
            <td><?= $row['vari_codrot']; ?></td>
            <td><?= $row['pafr_calrot']; ?></td>
            <td><?= $row['prod_codrot']; ?></td>
            <td><?= $row['pafr_copack']; ?></td>
            <td><?= date("d/m/Y", strtotime($row['pafr_fecemb'])); ?></td>
            <td><?= $row['pafr_huert1']; ?></td>
            <td><?= $row['pafr_cuart1']; ?></td>
            <td><?= $row['pafr_ccajas']; ?></td>
        </tr>
    <?php }
} else {
    $queryEnca = $functions->getDetaPallet($folio);
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
<?php }
}

odbc_close($conexion);
?>