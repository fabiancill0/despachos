<?php
session_start();
if (isset($_POST['out'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
