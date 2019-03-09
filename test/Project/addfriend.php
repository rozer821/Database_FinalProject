<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Search</title>

    
    <link href="css/bootstrap.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  </head>


  <body>
    <?php

    if(!isset($_COOKIE['user'])){
      header("Location: http://localhost/test/signin.php");
    } 
    
    ?>
    <div>
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Oingo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="map.php">Map <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <div class="dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $_COOKIE["user"];?></a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="homepage.php">Homepage</a>
                  <a class="dropdown-item" href="#">Friends</a>
                  <a class="dropdown-item" href="filters.php">Filter</a>
                </div>
              </div>
            </li>
          </ul>
          

          <div class="form-inline my-2 my-md-0">
            
            <button class="btn btn-outline-success btn-sm btn-block" style="margin-right:20px" onclick=post()>create new post</button>
          </div>
          <div class="form-inline my-2 my-md-0">
            
            <button class="btn btn-outline-success btn-sm btn-block" onclick=signout() >sign out</button>
          </div>
          
      </nav>
    </div>
    <!-- 搜索好友 -->
    <div class="container">
    <form class="input-group mb-3 " style="margin-top:30px;" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        <input type="text" class="form-control" placeholder="username" name="uname">
        <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </div>
    </form>


    <?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "961010";
    $dbname = "project2";

    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("connection failed: " . $conn->connect_error);
    } 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $uname=$_POST['uname'];
        //找到所有符合条件的用户
        $sql='Select * from user where uname like "%'.$uname.'%"';
        $result= $conn->query($sql);
        if ($result->num_rows == 0) {  
            echo '<div class="d-flex justify-content-between align-items-center w-100" style="margin-top:30px;">
            <strong class="text-gray-dark">No result</strong>
            </div>';
            echo $conn->error;     
          } 
          else {
            while($row=$result->fetch_assoc()) {
              
                echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
                echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
                echo '<div class="card-body d-flex flex-column align-items-start">';
                echo '<div class="form-inline form-group"  id="show_status">
                        <div class="form-group ">
                            <strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($row['uname'],ENT_QUOTES, 'UTF-8').'</strong>
                        </div>';
                //判断搜索出的用户是不是好友，是不是用户自己
                $sql_if_friend='Select * from friend_relation where (uid1='.$row['uid'].' and uid2='.$_COOKIE['uid'].') or (uid1='.$_COOKIE['uid'].' and uid2='.$row['uid'].')'; 
                $result_if_friend= $conn->query($sql_if_friend);
                if($row['uname']==$_COOKIE['user']){
                    echo '<small class="form-group mx-sm-3 text-right ">
                            <p class="card-text mb-auto" style="color: #00BFFF">Yourself</p>
                        </small>';
                }else if ($result_if_friend->num_rows == 0) {
                    echo '<small class="form-group mx-sm-3 text-right ">
                            <button class="btn btn-outline-primary btn-sm" id='.htmlspecialchars($_COOKIE['uid'],ENT_QUOTES, 'UTF-8').' name='.htmlspecialchars($row['uid'],ENT_QUOTES, 'UTF-8').'  onclick=showSite(this.id,this.name)>add friend</button>
                        </small>'; 
                }  else{
                    echo '<small class="form-group mx-sm-3 text-right ">
                            <p class="card-text mb-auto" style="color: #00BFFF">Your friend</p>
                        </small>'; 
                }
                       
                echo '</div>';
                echo '<p class="card-text mb-auto" >E-mail:'.htmlspecialchars($row['uemail'],ENT_QUOTES, 'UTF-8').'</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              
      
            }
        }
        echo "</div>";
    }

    ?>
    
    <script>
    
      function signout()
      {
        document.cookie = "user" + '=;  expires=Thu, 01 Jan 1970 00:00:01 GMT;'
        document.cookie = "uid" + '=;  expires=Thu, 01 Jan 1970 00:00:01 GMT;'
        
        window.location.href="signin.php";
      }
      function post()
      { 
        
        window.location.href="post.php";
      }
      
      function showSite(from_whom,to_whom)
{
   
    if (from_whom=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    } 
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // IE6, IE5 浏览器执行代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","add_friend_request.php?from_whom="+from_whom+"&to_whom="+to_whom,true);
    xmlhttp.send();
    alert("Request has been send");
    window.location.href="friend.php";
    
}
</script>

<div id="txtHint" class ="container"></div>
  </body>
  
</html>
