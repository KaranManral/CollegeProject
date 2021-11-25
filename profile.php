<?php 
	require_once 'dbConfig.php';
	session_start();
	if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
	$table=$_SESSION['User_Logged_In'];
	$sql="SELECT Username,bio,photo,cover FROM `$table`";
	if($result = mysqli_query($conn,$sql))
    {
		$row = mysqli_fetch_assoc($result);
		$USER_NAME=$row["Username"];
		$USER_BIO=$row["bio"];
		$USER_PHOTO=$row["photo"];
		$USER_COVER=$row["cover"];
	}
	else
		echo "Some Error Occurred in fetching details";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<style type="text/css">
		#cover_container{
			width: 75%;
			height: 55vh;
			margin: 0 auto;
		}
		#profile{
			position: absolute;
			border: solid grey 3px;
			border-radius: 50%;
			left: 50%;
			transform: translateX(-50%);
			top: 28vh;
			width:172px;
			height:172px;
		}
		#cover{
			width: 100%;
			height: 100%;
			border-radius: 10px;
			border: solid grey 3px;
		}
		#name_container{
			max-width: 75%;
			min-height: 5vh;
			min-width: 5em;
			margin: 0 auto;
			color: #333;
		}
		#detail_container{
			width: 75%;
			height: auto;
			margin: 0 auto;
			border: solid grey 3px;
			border-radius: 10px;
			color: #333;
		}
		#detail_container p{
			padding: 2vw;
		}
		#detail_container h1{
			color: rgb(85,178,182);
			margin: 1.6vw;
		}
		hr{
			border: 0.2vw solid rgb(85,178,182);
			background: rgb(85,178,182);
  			border-radius: 6px;
			margin-left: 1.6vw;
			margin-right: 4.5vw;
		}
	</style>
</head>
<body>
	<div class="container">
		<div id="cover_container">
			<?php
				echo "<img src='data:image/jpeg;base64,".base64_encode($USER_COVER)."' id='cover'>";
				echo "<img src='data:image/jpeg;base64,".base64_encode($USER_PHOTO)."' id='profile'>";
			?>
		</div>
		<div id="name_container">
			<?php
			 if($USER_NAME!=null){
				echo "<center><h1 id='name' style='font-size:40px;'>$USER_NAME</h1></center>";
			}
			else{
				echo "<script>parent.location.href='logout.php';</script>";
			} ?>
		</div>
		<div id="detail_container">
			<h1>About</h1>
			<hr>
			<?php
				echo "<p>$USER_BIO</p>"
			?>
		</div>
	</div>
</body>
</html>
<?php
    $username = $_SESSION['User_Logged_In'];
    $sql = "SELECT theme FROM `$username`";
    if($result = mysqli_query($conn,$sql))
    {
        $row = mysqli_fetch_assoc($result);
        $THEME=$row["theme"];
        if($THEME=='dark')
        {
            echo '<script>
                let name_container=document.getElementById("name_container");
				let detail_container=document.getElementById("detail_container");
                name_container.style.color="whitesmoke";
				detail_container.style.color="whitesmoke";
            </script>';
        }
		if($THEME=='light')
        {
            echo '<script>
                let name_container=document.getElementById("name_container");
				let detail_container=document.getElementById("detail_container");
                name_container.style.color="#333";
				detail_container.style.color="#333";
            </script>';
        }
    }
    else
        echo "Some Error Occurred in fetching details";
?>