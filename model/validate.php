<?php
require_once 'connections.php';
$conn = new Connections;

$user = $_POST['username'];
$pass = $_POST['password'];

/*$conexion = $conn->connectToServ();
$query = "SELECT * FROM dba.usersde WHERE usrs_usrnam = ? AND usrs_psword = ?";

$users_validate = odbc_prepare($conexion, $query);
session_start();
$result = odbc_execute($users_validate, [$user, $pass]);
if ($row = odbc_fetch_array($users_validate)) {
    if ($row['usrs_activo'] == 0) {
        $_SESSION['statusLogin'] = 1;
        header('Location: ../login.php');
        exit();
    } else if ($row['usrs_access'] == 0) {
        $_SESSION['statusLogin'] = 2;
        header('Location: ../login.php');
        exit();
    } else {
        $_SESSION['login_type'] = $row['usrs_access'];
        $_SESSION['login_active'] = $row['usrs_activo'];
        $row = array_map("utf8_encode", $row);
        $_SESSION['user'] = $row['usrs_nombre'] . ' ' . $row['usrs_apelli'];
        header('Location: ../main.php');*/
session_start();
$_SESSION['login_type'] = 1;
$_SESSION['login_active'] = 1;
//$row = array_map("utf8_encode", $row);
$_SESSION['user'] = 'Fabian Carrasco';
header('Location: ../main.php');
    //}
/*} else {
    $_SESSION['statusLogin'] = 0;
    header('Location: ../login.php');
    exit();*/
//}
//odbc_close($conexion);
