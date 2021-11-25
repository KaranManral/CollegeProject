<?php
    require_once 'dbConfig.php';
    session_start();
    if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MainPage</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class="navigation" onmouseover="showOptions(this)" onmouseout="hideOptions(this)">
        <ul>
            <li class="list active">
                <a href="home.php" target="main" class="theme_change">
                    <span class="icon"><ion-icon name="home"></ion-icon></span>
                    <span class="title">Home</span>
                </a>
            </li>
            <li class="list">
                <a href="profile.php" target="main" class="theme_change">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <span class="title">Profile</span>
                </a>
            </li>
            <li class="list">
                <a href="#" target="main" class="theme_change">
                    <span class="icon"><ion-icon name="chatbubbles"></ion-icon></span>
                    <span class="title">Messages</span>
                </a>
            </li>
            <li class="list">
                <a href="#" target="main" class="theme_change">
                    <span class="icon"><ion-icon name="settings"></ion-icon></span>
                    <span class="title">Setting</span>
                </a>
            </li>
            <li class="list">
                <a href="logout.php" target="_self" class="theme_change">
                    <span class="icon"><ion-icon name="log-out"></ion-icon></span>
                    <span class="title">Sign Out</span>
                </a>
            </li>
        </ul>
    </div>
    <div>
        <iframe src="home.php" name="main" id="main"></iframe>
    </div>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script>

        function showOptions(e) {
            const list=document.getElementsByClassName('title');
            document.getElementById('main').style.width="78.8%";
            e.style.width="250px";
            for(let i=0;i<list.length;i++)
                list[i].style.display="block";
            document.getElementById('main').style.left="280px";
        }
        function hideOptions(e){
            const list=document.getElementsByClassName('title');
            document.getElementById('main').style.width="92%";
            e.style.width="70px";
            for(let i=0;i<list.length;i++)
                list[i].style.display="none";
            document.getElementById('main').style.left="100px";
        }
    </script>
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
                let Body=document.getElementsByTagName("body");
                let nav=document.getElementsByClassName("navigation");
                let Main=document.getElementById("main");
                let tc=document.getElementsByClassName("theme_change");
                for(let i=0;i<tc.length;i++)
                    tc[i].style.color="rgb(85,178,182)";
                let temp_active=document.getElementsByClassName("list active")[0];
                temp_active.style.background="rgb(85,178,182)";
                temp_active.children[0].style.color="#fff";
                let list = document.querySelectorAll(".list");
                for(let i=0; i<list.length; i++){
                    list[i].onclick = function(){
                        let j=0;
                        while(j<list.length){
                            list[j].className = "list";
                            list[j].style.background="#333";
                            let temp=list[j].children;
                            temp[0].style.color="rgb(85,178,182)";
                            j++;
                        }
                        list[i].className = "list active";
                        list[i].style.background="rgb(85,178,182)";
                        let temp=list[i].children;
                        temp[0].style.color="#fff";
                    }
                }
                Body[0].style.backgroundImage="url(res/background.png)";
                Body[0].style.backgroundRepeat="no-repeat";
                Body[0].style.backgroundSize="cover";
                nav[0].style.background="#333";
                nav[0].style.borderLeft="solid #333";
                Main.style.backgroundColor="rgb(43, 40, 69)";
            </script>';
        }
        if($THEME=='light')
        {
            echo '<script>
                let Body=document.getElementsByTagName("body");
                let nav=document.getElementsByClassName("navigation");
                let Main=document.getElementById("main");
                let tc=document.getElementsByClassName("theme_change");
                for(let i=0;i<tc.length;i++)
                    tc[i].style.color="#fff";
                let temp_active=document.getElementsByClassName("list active")[0];
                temp_active.style.background="#fff";
                temp_active.children[0].style.color="#333";
                let list = document.querySelectorAll(".list");
                for(let i=0; i<list.length; i++){
                    list[i].onclick = function(){
                        let j=0;
                        while(j<list.length){
                            list[j].className = "list";
                            list[j].style.background="#f545d8";
                            let temp=list[j].children;
                            temp[0].style.color="#fff";
                            j++;
                        }
                        list[i].className = "list active";
                        list[i].style.background="#fff";
                        let temp=list[i].children;
                        temp[0].style.color="#333";
                    }
                }
                Body[0].style.background="#fff";
                nav[0].style.background="#f545d8";
                nav[0].style.borderLeft="solid #f545d8";
                Main.style.backgroundColor="white";
            </script>';
        }
    }
    else
        echo "Some Error Occurred in fetching details";
?>