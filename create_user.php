<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once 'dbConfig.php';

    $img = addslashes(file_get_contents('res/person.png'));
    $cov = addslashes(file_get_contents('res/cover.png'));

if (isset($_POST["signup"])) {
    $id=$_POST["email"];

    $sql ="CREATE TABLE IF NOT EXISTS `$id`(Username VARCHAR(50) NOT NULL,email VARCHAR(100) NOT NULL,Userpwd VARCHAR(30) NOT NULL,age TINYINT UNSIGNED NOT NULL,phone VARCHAR(30) NOT NULL,bio MEDIUMTEXT NOT NULL,photo LONGBLOB NOT NULL,cover LONGBLOB NOT NULL,theme VARCHAR(6) NOT NULL DEFAULT 'light')";

    if ($conn->query($sql) === TRUE) 
    {
        $sqlt = "SELECT * from `$id`";
        if ($result = mysqli_query($conn, $sqlt)) 
        {
            $rowcount = mysqli_num_rows( $result );
            if($rowcount==0)
            {
                $sqls =$conn->prepare("INSERT INTO `$id` (Username,email,Userpwd,age,phone,bio,photo,cover) VALUES (?,?,?,?,?,?,'$img','$cov')"); 
                $sqls->bind_param("sssiss",$username,$id,$pwd,$age,$phn,$about);
                $username=$_POST['name'];
                $pwd=$_POST['pwd'];
                $age=$_POST['age'];
                $phn=$_POST['tel'];
                $about=$_POST['Bio'];
                $sqls->execute();
                if ($sqls||!$conn) 
                {
                    echo "<script>alert('Account Created Successfully, now Login to your Account.');parent.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('Error creating account, try again after some time.');parent.location.reload();</script>";
                    exit();
                }
            }
            else
            {
                echo "<script>alert('Account already created with this email.');parent.location.reload();</script>";
                exit();
            }
        }
        else
        {
            echo "<script>alert('Error creating account, try again after some time.');parent.location.reload();</script>";
            exit();
        }
    }
    else 
    {
        echo "<script>alert('Error creating account, try again after some time.');parent.location.reload();</script>";
        exit();
    }
}
  
  $conn->close();
?>