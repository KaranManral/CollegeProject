<?php
    session_start();
    if(isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='main.php';</script>";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="res/icon_dark_small.ico">
    <title>Login</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: black;
            overflow: hidden;
        }
        #icon{
            width: 43%;
            height: 100vh;
            float: left;
            overflow: -moz-hidden-unscrollable;
            overflow: hidden;
        }
        #login{
            width: 57%;
            height: 100vh;
            float: right;
        }
        #logo{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 43%;
            height: 100%;
        }
    </style>
</head>
<body onresize="changeWidth()">
    <div id="contatiner">
        <div id="icon">
            <img src="res/xd.jfif" alt="Logo" id="logo">
        </div>
        <iframe src="login.html" frameborder="0" id="login" scrolling="no"></iframe>
    </div>
    <script>
        let fr=document.getElementById('login');
        let ic=document.getElementById('icon');
        
        function changeWidth() {
            if(window.innerWidth<=895)
            {
                fr.style.width="100%";
                ic.style.display="none";
            }
            else
            {
                fr.style.width="57%";
                ic.style.display="block";
            }   
        }
    </script>
</body>
</html>