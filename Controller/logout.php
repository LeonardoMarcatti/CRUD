<?php
    session_start();
    session_unset();
    header('location: ../View/crud.php');
    exit;
?>