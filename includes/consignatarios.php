<?php
include '../model/connections.php';
include '../model/functions.php';

$functions = new Functions();
$conn = new Connections();

$connnect = $conn->connectToServ();
$functions->getConsignatarios($connnect);
