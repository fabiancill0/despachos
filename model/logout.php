<?php
session_start();
if (isset($_POST['out'])) {
    if ($_POST['out'] == 0) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}
