<?php
    require_once 'dbConfig.php';
    session_start();
    if(!isset($_SESSION['User']))
        echo "<script>parent.location.href='404.html';</script>";
?>