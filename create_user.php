<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once 'dbConfig.php';

    $img = addslashes(file_get_contents('res/person.png'));
    $cov = addslashes(file_get_contents('res/cover.png'));

if (isset($_POST["signup"])) {

    $sql ="CREATE TABLE IF NOT EXISTS profiles(Username VARCHAR(50) NOT NULL,email VARCHAR(100) NOT NULL,Userpwd VARCHAR(30) NOT NULL,age TINYINT UNSIGNED NOT NULL,phone VARCHAR(30) NOT NULL,bio MEDIUMTEXT NOT NULL,photo LONGBLOB NOT NULL,cover LONGBLOB NOT NULL)";
    $id=$_POST["email"];
    if ($conn->query($sql) === TRUE) 
    {
        $sqlt = "SELECT email from profiles";
        if ($result = mysqli_query($conn, $sqlt)) 
        {
            $rowcount=0;
            while($row = mysqli_fetch_assoc($result))
            {
                if($row["email"]==$id)
                    $rowcount++;
            }

            if($rowcount==0)
            {
                $sqls =$conn->prepare("INSERT INTO profiles (Username,email,Userpwd,age,phone,bio,photo,cover) VALUES (?,?,?,?,?,?,'$img','$cov')"); 
                $sqls->bind_param("sssiss",$username,$id,$pwd,$age,$phn,$about);
                $fname=$_POST['fname'];
                $lname=$_POST['lname'];
                $username=$fname." ".$lname;
                $pwd=$_POST['pwd'];
                $age=$_POST['age'];
                $phn=$_POST['tel'];
                $about=$_POST['Bio'];
                $sqls->execute();
                if ($sqls) 
                {
                    $sql ="CREATE TABLE IF NOT EXISTS theme(email VARCHAR(100) NOT NULL,userTheme VARCHAR(6) NOT NULL)";
                    if ($conn->query($sql) === TRUE) 
                    {
                        $sql=$conn->prepare("INSERT INTO theme(email,userTheme) VALUES (?,?)");
                        $sql->bind_param("ss",$id,$th);
                        $th='dark';
                        $sql->execute();
                        if($sql)
                            echo "<script>alert('Account Created Successfully, now Login to your Account.');parent.location.href='index.php';</script>";
                        else
                            echo "<script>alert('Account Created, but problem in theme.');parent.location.href='index.php';</script>";
                    }
                    else
                        echo "<script>alert('Account Created, but problem in theme.');parent.location.href='index.php';</script>";
                } 
                else 
                {
                    echo "<script>alert('Error creating account, try again after some time.');parent.location.href='main.php';</script>";
                    exit();
                }
            }
            else
            {
                echo "<script>alert('Account already created with this email.Please Login or use another email.');parent.location.href='main.php';</script>";
                exit();
            }
        }
        else
        {
            echo "<script>alert('Error creating account, try again after some time.');parent.location.href='main.php';</script>";
            exit();
        }
    }
    else 
    {
        echo "<script>alert('Error creating account, try again after some time.');parent.location.href='main.php';</script>";
        exit();
    }
}
  
  $conn->close();
?>