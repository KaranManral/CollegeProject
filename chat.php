<?php
    require_once 'dbConfig.php';
    session_start();
    if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
    $email=$_SESSION['User_Logged_In'];
    $sql="SELECT Username,photo FROM profiles WHERE email='$email'";
    if($result=mysqli_query($conn,$sql))
    {
        $row = mysqli_fetch_assoc($result);
        $username=$row["Username"];
        $photo=$row["photo"];
    }
    else
        echo "Error fetching details.";
        
    if(!isset($_SESSION['name'])){
        $_SESSION['name']=$username;
    }
    else
    {
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message</title>
        <style>
        #chatbox {
            text-align: left;
            margin: 0 auto;

            padding: 10px;
            
            border: 1px solid #a7a7a7;
            overflow: auto;
            border-radius: 8px;
            border-bottom: 4px solid #a7a7a7;
            flex: 1;
            width: 89%;
            height: 78vh;
            overflow-Y: auto;
            overflow-x: hidden;
            border: 1px solid #ff9800;
        } 
        #formContainer{
            justify-content: center;
            display: flex;
            margin-top: 2.5vh;
        }
        #submitmsg{
            margin-left: 1vw;
            padding: 7.5px 13px;
            height: 50px;
            width: 50px;
            border-radius: 50%;
            color: white;
            background-color: #2ecc71;
            border: solid #2ecc71 1px;
            font-size: 30px;
            cursor: pointer;
        }
        #usermsg{
            padding: 7.5px 13px;
            border-radius: 40px;
            border: 1px solid #ff9800;
            text-align: left;
            width: 82%;
            height: 5vh;
            background-color: transparent;
        }
        #msgcontainer{
            display: flex;
        }
        #icon{
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }
        .txtarea{
            background-color: transparent;
            color: #2ecc71;
        }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="chatbox">
                <?php
                    if(file_exists("log.php") && filesize("log.php") > 0){
                        $contents = file_get_contents("log.php");          
                        echo $contents."</div>";
                    }
                    else
                    {
                        $myfile = fopen("log.php", "a");
                        $tm="<?php include_once 'requirement.php' ?>";
                        file_put_contents("log.php", $tm, FILE_APPEND | LOCK_EX);
                    }
                }
                ?>           
            </div>
            <form name="message" action="" method="post">
                <div id="formContainer">
                <input name="usermsg" type="text" id="usermsg" autocomplete="no">
                <input name="submitmsg" type="submit" name="submit" id="submitmsg" value="&#9654;">
                </div>
            </form>
        </div>
        <script>
            document.getElementById('chatbox').scrollTop = document.getElementById('chatbox').scrollHeight;
            let tempo=0;
            setInterval(function ()
            {
                let rawFile = new XMLHttpRequest();
                rawFile.open("GET", "log.php", true);
                rawFile.onreadystatechange=function(){
                    if(tempo<(rawFile.responseText).length)
                    {
                        document.getElementById('chatbox').innerHTML=rawFile.responseText;
                        document.getElementById('chatbox').scrollTop = document.getElementById('chatbox').scrollHeight;
                        tempo=(rawFile.responseText).length;
                    }
                }
                rawFile.send(null);
            },2500);
        </script>
    </body>
</html>
<?php
    $sql = "SELECT userTheme FROM theme WHERE email='$email'";
    if($result = mysqli_query($conn,$sql))
    {
        $row = mysqli_fetch_assoc($result);
        $THEME=$row["userTheme"];
        if($THEME=='dark')
        {
            echo '<script>
                let Body=document.getElementsByTagName("body")[0];
                let usermsg=document.getElementById("usermsg");
                Body.style.color="whitesmoke";
                usermsg.style.color="whitesmoke";
            </script>';
        }
        if($THEME=='light')
        {
            echo '<script>
                let Body=document.getElementsByTagName("body")[0];
                let usermsg=document.getElementById("usermsg");
                Body.style.color="#333";
                usermsg.style.color="#333";
            </script>';
        }
    }
    else
        echo "Some Error Occurred in fetching details";
?>
<?php
if(isset($_SESSION['name'])&&isset($_POST['submitmsg'])){
    $text = $_POST['usermsg'];
    date_default_timezone_set('UTC');
    $text_message = "<div id='msgContainer'><img src='data:image/jpeg;base64,".base64_encode($photo)."' id='icon' title=$username></span> <b class='user-name'>".$_SESSION['name']."</b>  <span class='chat-time'>".date("g:i A")." , ".date_default_timezone_get()."</div><div><br><textarea class='txtarea' cols='136' rows='auto' readonly style='border:hidden;overflow: hidden;resize: none;max-height: 600px;min-height: 30px;font-family: sans-serif;font-size: 16.5px;'>&emsp;".stripslashes(htmlspecialchars($text))."</textarea></div>";
    file_put_contents("log.php", $text_message, FILE_APPEND | LOCK_EX);
}
?>