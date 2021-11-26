<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "profile";

    $conn=new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $db_selected=mysqli_select_db($conn,$dbname);
    if(!$db_selected)
    {
        $sql_query="CREATE DATABASE $dbname";
        if(mysqli_query($conn,$sql_query))
        {

        }
        else
            echo "Error creating database.".mysqli_error($conn);
    }
?>
