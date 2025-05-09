<?php
include '../model/connections.php';
include '../model/functions.php';

$conection = new Connections();
$functions = new Functions();
$connection = $conection->connectToServ();
$despachos = $functions->getEncaEmbarque($_POST['cliente']);
$data = odbc_exec($connection, $despachos);
?>
<table class="table table-bordered table-hover" id="despacho">

    <thead>
        <tr>
            <th>Embarque</th>
            <th>Cliente</th>
            <th>Recibidor</th>
            <th>Nave</th>
            <th>Pto. Origen</th>
            <th>Pto. Destino</th>
            <th>Embarcador</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = odbc_fetch_array($data)) {
            $row = array_map('utf8_decode', $row);
        ?>
            <tr>
                <td><?= $row['embq_codigo']; ?></td>
                <td><?= $functions->getNombreCliente($connection, $row['clie_codigo']); ?></td>
                <td><?php if ($row['reci_codigo'] != 1500) {
                        echo $functions->getNombreRecibidor($connection, $row['reci_codigo']);
                    } else {
                        echo $functions->getNombreRecibidor($connection, $row['embq_fitosa']);
                    } ?></td>
                <td><?= $row['embq_nomnav']; ?></td>
                <td><?= $functions->getNombrePuertos($connection, $row['embq_ptoori']); ?></td>
                <td><?= $functions->getNombrePuertos($connection, $row['embq_descar']); ?></td>
                <td><?= $functions->getNombreEmbarcador($connection, $row['embc_codigo']); ?></td>


            </tr>
        <?php

        }
        ?>
    </tbody>
</table>
<script>
    $('#despacho').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        responsive: true,
        autoWidth: false,
        ordering: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
    });
</script>