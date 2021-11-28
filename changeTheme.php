<?php
    require_once 'dbConfig.php';
	session_start();
	if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
	$email=$_SESSION['User_Logged_In'];
    $sql="SELECT userTheme FROM theme WHERE email='$email'";
	if($result = mysqli_query($conn,$sql))
    {
		$row = mysqli_fetch_assoc($result);
		$userTheme=$row["userTheme"];
        if($userTheme=='dark')
        {
            $sql ="UPDATE theme SET userTheme='light' WHERE email='$email'";
            if(mysqli_query($conn,$sql))
                echo "<script>alert('Theme changed to Light.');parent.location.reload();</script>";
            else
                echo "<script>alert('Theme not changed.');location.href='setting.php';</script>";
        }
        if($userTheme=='light')
        {
            $sql ="UPDATE theme SET userTheme='dark' WHERE email='$email'";
            if(mysqli_query($conn,$sql))
                echo "<script>alert('Theme changed to Dark.');parent.location.reload();</script>";
            else
                echo "<script>alert('Theme not changed.');location.href='setting.php';</script>";
        }
	}
	else
		echo "Some Error Occurred in fetching details<script>parent.location.href='logout.php';</script>";
?>