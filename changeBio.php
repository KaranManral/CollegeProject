<?php
    require_once 'dbConfig.php';
	session_start();
	if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
	$email=$_SESSION['User_Logged_In'];
    $sql="SELECT Userpwd FROM profiles WHERE email='$email'";
	if($result = mysqli_query($conn,$sql))
    {
		$row = mysqli_fetch_assoc($result);
		$pwd=$row["Userpwd"];
	}
	else
		echo "Some Error Occurred in fetching details<script>parent.location.href='logout.php';</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Name</title>
    <style>
        #update_container{
            position:absolute;
            left:50%;
            top:50%;
            transform: translate(-50%,-50%);
            border: solid rgb(85,178,182) 0.2vw;
            border-radius: 10px;
            padding: 2vw;
            margin: 1vw;
        }
        #new_bio
        {
            width: 80%;
            border-radius:10px;
            border: solid rgb(85,178,182) 0.2vw;
            color: auto;
            padding: 0.6vw;
            margin: 1vw;
            resize: none;
            overflow-X: hidden;
            overflow-Y: scroll;
        }
        input[type="password"]
        {
            width: 80%;
            border-radius:10px;
            border: solid rgb(85,178,182) 0.2vw;
            color: auto;
            padding: 0.6vw;
            margin: 1vw;
        }
        input[type="submit"]{
            width: 40%;
            border: 0;
            background: none;
            display: block;
            margin: 1vw auto;
            text-align: center;
            border: 0.2vw solid #2ecc71;
            padding: 1vw 1vw;
            outline: none;
            color: #2ecc71;
            border-radius: 3vw;
            transition: 0.255;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="update_container">
        <center>
        <form action="" method="post">
        <textarea name="new_bio" id="new_bio" cols="50" rows="5" required placeholder="Write About Yourself"></textarea><br>
        <input type="password" name="c_pwd" id="c_pwd" placeholder="Enter Password" required><br>
        <input type="submit" name="Update" value="Update">
        </form>
        </center>
    </div>
</body>
</html>
<?php
    if(isset($_POST["Update"]))
    {
        $epwd=$_POST["c_pwd"];
        if($epwd==$pwd)
        {
            $sql =$conn->prepare("UPDATE profiles SET bio=? WHERE email='$email'");
            $sql->bind_param("s",$bio);
            $bio=$_POST['new_bio'];
            $sql->execute();
            if($sql)
                echo "<script>alert('About updated.');location.href='setting.php';</script>";
            else
                echo "<script>alert('About not updated.');location.href='setting.php';</script>";
        }
        else
        {
            echo "<script>alert('Incorrect Password. About not updated.');location.href='setting.php';</script>";
        }
    }
    $conn->close();
?>