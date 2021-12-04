<?php
    require_once 'dbConfig.php';
    session_start();

    $username=$_POST['email_login'];
    $userpwd=$_POST['pwd_login'];

    function validate_email()
    {
        global $conn,$username;
        $sql = "SELECT email from profiles";
        if ($result = mysqli_query($conn, $sql)) 
        {
            while($row = mysqli_fetch_assoc($result))
            {
                if($row["email"]==$username)
                    return true;
            }
            return false;
            mysqli_free_result($result);
        }
        else
        {
            echo "<script>alert('Error signing in to your account, try again later.');</script>";
            return false;
        }        
    }
    
    function validate_pwd()
    {
        global $conn,$username,$userpwd;
        $sql = "SELECT Userpwd FROM profiles WHERE email='$username'";
        if($result = mysqli_query($conn,$sql))
        {
            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                if($row["Userpwd"]==$userpwd)
                    return true;
                else   
                    return false;
            } 
            else 
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
                echo "<script>alert('INVALID PASSWORD');parent.location.href='index.php';</script>";
            }
        }
        else
        {
            echo "<script>alert('INVALID EMAIL');parent.location.href='index.php';</script>";
        }
    }
    $conn->close();
?>