<?php
    require_once 'dbConfig.php';
    session_start();

    $username=$_POST['email_login'];
    $userpwd=$_POST['pwd_login'];

    function validate_email()
    {
        global $dbname,$conn,$username;
        $sql = "SHOW TABLES FROM $dbname";
        $result = mysqli_query($conn,$sql);

        if (!$result) {
            echo "DB Error, could not list tables\n";
            echo 'MySQL Error: ' . mysqli_error();
            return false;
        }

        while ($row = mysqli_fetch_row($result)) {
            if($row[0]==$username)
            {
                return true;
            }
        }
        return false;
        mysqli_free_result($result);
    }
    
    function validate_pwd()
    {
        global $dbname,$conn,$username,$userpwd;
        $sql = "SELECT Userpwd FROM `$username`";
        if($result = mysqli_query($conn,$sql))
        {
            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                if($row["Userpwd"]==$userpwd)
                    return true;
                else   
                    return false;
            } else 
            {
                return false;
            }
        }
        else
            return false;
    }

    if (isset($_POST["login"])) {
        if(validate_email())
        {
            if(validate_pwd())
            {
                $_SESSION['User_Logged_In']=$username;
                echo "<script>parent.location.href='main.php';</script>";
            }
            else
            {
                echo "<script>alert('INVALID PASSWORD');parent.location.reload();</script>";
            }
        }
        else
        {
            echo "<script>alert('INVALID EMAIL');parent.location.reload();</script>";
        }
    }
    $conn->close();
?>
