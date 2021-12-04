<?php
    session_start();
    if(isset($_SESSION['User_Logged_In']))
    {
        session_destroy();
        if(isset($_SESSION['name']))
        {
            session_destroy();
            echo "<script>parent.location.href='index.php';</script>";
        }
        else
            echo "<script>parent.location.href='index.php';</script>";
    }
    else
    {
        echo "<script>parent.location.href='index.php';</script>";
    }
?>