<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    session_start();
    session_unset();
    header('location: ../View/crud.php');
    exit;
?>