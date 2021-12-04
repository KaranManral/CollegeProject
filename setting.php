<?php
    require_once 'dbConfig.php';
    session_start();
    if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
    $email = $_SESSION['User_Logged_In'];
    $sql = "SELECT Username,age,bio,phone,photo,cover FROM profiles WHERE email='$email'";
    if($result = mysqli_query($conn,$sql))
    {
        $row = mysqli_fetch_assoc($result);
		$username=$row["Username"];
        $age=$row["age"];
		$bio=$row["bio"];
        $phone=$row["phone"];
		$prof=$row["photo"];
		$cov=$row["cover"];
        $sql = "SELECT userTheme FROM theme WHERE email='$email'";
        if($result = mysqli_query($conn,$sql))
        {
            $row = mysqli_fetch_assoc($result);
            $userTheme=$row["userTheme"];
        }
        else
        {
            echo "Some Error Occurred in fetching details<script>parent.location.href='logout.php';</script>";    
        }
    }
    else
    {
        echo "Some Error Occurred in fetching details<script>parent.location.href='logout.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body{
            width: 80%;
            margin: 0 auto;
        }
        div{
            cursor: pointer;
            margin-bottom: 1vh;
        }
        #emailContainer
        {
            cursor: not-allowed;
        }
        #ageContainer
        {
            cursor: not-allowed;
        }
        hr{
            background-color: lightgray;
            color: lightgray;
            border: 0.5px solid;
            border-radius: 3px;
        }
        .end{
            background-color: darkgray;
            color: darkgray;
            border: 1.5px solid;
            border-radius: 3px;
        }
        table{
            width: 90%;
            margin: 0 auto;
        }
        th{
            width: 30%;
            border-bottom: solid lightgray 0.5px;
        }
        h4{
            margin-left:4vw;
        }
    </style>
</head>
<body>
    <h1>General Account Settings</h1>
    <hr class="end">
    <div id="nameContainer" onclick="location.href='changeName.php'">
        <?php echo "<table><tr><th>Name</th><th>$username</th><th><a href='changeName.php'>Edit</a></th></tr></table>";?>
    </div>
    
    <div id="emailContainer">
        <?php echo "<table><tr><th>Email</th><th>$email</th><th></th></tr></table>";?>
    </div>
    
    <div id="ageContainer">
        <?php echo "<table><tr><th>Age</th><th>$age</th><th></th></tr></table>";?>
    </div>
    <div id="phoneContainer" onclick="location.href='changePhone.php'">
        <?php echo "<table><tr><th>Phone Number</th><th>$phone</th><th><a href='changePhone.php'>Edit</a></th></tr></table>";?>
    </div>
    <div id="bioContainer" onclick="location.href='changeBio.php'">
        <?php 
        $temp=explode(" ",$bio,4);
        $temp1="";
        for($i=0;$i<sizeof($temp)-1;$i++)
            $temp1.=$temp[$i]." ";
        echo "<table><tr><th>About</th><th>$temp1....</th><th><a href='changeBio.php'>Edit</a></th></tr></table>";?>
    </div>

    <div id="profileContainer" onclick="location.href='changeProfile.php'">
        <?php echo "<table><tr><th>Profile Photo</th><th><img src='data:image/jpeg;base64,".base64_encode($prof)."' alt='Profile Photo' width='100' height='100'></th><th><a href='changeProfile.php'>Edit</a></th></tr></table>";?>
    </div>
    
    <div id="coverContainer" onclick="location.href='changeCover.php'">
        <?php echo "<table><tr><th>Cover Photo</th><th><img src='data:image/jpeg;base64,".base64_encode($cov)."' alt='Cover Photo' width='200' height='100'></th><th><a href='changeCover.php'>Edit</a></th></tr></table>";?>
    </div>
    <h1>Login/Security Settings</h1>
    <hr class="end">
    <div id="pwdContainer" onclick="location.href='changePassword.php'">
        <?php echo "<table><tr><th>Password</th><th>********</th><th><a href='changePassword.php'>Edit</a></th></tr></table>";?>
    </div>
    
    <div id="deleteAccount" onclick="location.href='deleteAccount.php'">
        <?php echo "<table><tr><th>Delete/Close Account</th><th></th><th><a href='deleteAccount.php'>Delete</a></th></tr></table>";?>
    </div>
    <h1>Display Setting</h1>
    <hr class="end">
    <div id="themeContainer" onclick="location.href='changeTheme.php'">
        <?php echo "<table><tr><th>Theme</th><th>$userTheme</th><th><a href='changeTheme.php'>Change</a></th></tr></table>";?>
    </div>
    <h1>Help</h1>
    <hr class="end">
    <div id="help">
        <h4>Write us at: <a href="mailto:keshavandteam@gmail.com">keshavandteam@gmail.com</a></h4>
        <h4>Call us at: +91 8318413202</h4>
        <h4>Discord: <a href="https://discord.gg/UuRCVS9h" target="_blank" rel="external">https://discord.gg/UuRCVS9h</a></h4>
    </div>
</body>
</html>
<?php
    if($userTheme=='dark')
        echo "<script>  let Body=document.getElementsByTagName('body')[0];
                        let hr=document.getElementsByClassName('end');
                        let a=document.getElementsByTagName('a');
                        Body.style.color='whitesmoke';
                        for(let i=0;i<hr.length;i++)
                        {
                            hr[i].style.color='rgb(85,178,182)';
                        }
                        for(let i=0;i<a.length;i++)
                        {
                            a[i].style.color='rgb(85,178,182)';
                        }
            </script>";
    if($userTheme=='light')
        echo "<script>  let Body=document.getElementsByTagName('body')[0];
                        let hr=document.getElementsByClassName('end');
                        let a=document.getElementsByTagName('a');
                        Body.style.color='black';
                        for(let i=0;i<hr.length;i++)
                        {
                            hr[i].style.color='darkgray';
                        }
                        for(let i=0;i<a.length;i++)
                        {
                            a[i].style.color='blue';
                        }
            </script>";                
    $conn->close();
?>