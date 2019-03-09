<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Friend</title>


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

    //用bootstrap gird分块，左边为好友列表，右边为请求表
    echo '<div class="row">
    <div class="col-8">';
    //获取给定用户所有好友
   

    $sql_friend = $conn->prepare('Select * From user Where uid in (
      (
      select uid1
      From user,friend_relation
      where user.uid=friend_relation.uid2 and user.uname=? )
      UNION (
      select uid2
      From user,friend_relation
      where user.uid=friend_relation.uid1 and user.uname=?) )');

    $sql_friend->bind_param('ss',$_COOKIE['user'],$_COOKIE['user']);// 's' specifies the variable type => 'string'
    $sql_friend->execute();
    $result_friend = $sql_friend->get_result();
    echo $conn->error;
    echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
    echo '<div class="my-3 p-3 bg-white rounded box-shadow">
       <h6 class="border-bottom border-gray pb-2 mb-0">Friend</h6>';
    echo '<small class="d-block text-right mt-3">
            <a href="addfriend.php">Add new friend</a>
        </small>';
    
   
    if ($result_friend->num_rows == 0) {
        
      echo '<div class="d-flex justify-content-between align-items-center w-100" style="margin-top:30px;">
      <strong class="text-gray-dark">You have no friends now.</strong>
      </div>';
      echo $conn->error;        
    } 
    else {
      while($row_friend=$result_friend->fetch_assoc()) {
        echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
        echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
        echo '<div class="card-body d-flex flex-column align-items-start">';
        echo '<div class="form-inline form-group"  id="show_status">
                <div class="form-group ">
                    <strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($row_friend['uname'],ENT_QUOTES, 'UTF-8').'</strong>
                </div>
                <form class="form-group mx-sm-3" action="delete_friend.php" method="POST">
                <input class="form-control" type="text" name="uid" style="display: none" value='.htmlspecialchars($row_friend["uid"],ENT_QUOTES, 'UTF-8').'>
                <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
              </form>
            </div>';
        
        echo '<p class="card-text mb-auto" >E-mail:'.htmlspecialchars($row_friend['uemail'],ENT_QUOTES, 'UTF-8').'</p>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      
      
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
  

    

    //获取请求与你做好友的用户
    
    
    echo '<div class="col-4">';
    echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
    echo '<div class="my-3 p-3 bg-white rounded box-shadow">
       <h6 class="border-bottom border-gray pb-2 mb-0">Friend Request</h6>';
    
    $sql_re = $conn->prepare('Select * From friend_request,user where frstatus=1 and uid=from_whom and to_whom= ?');
    $sql_re->bind_param('i',$_COOKIE['uid']);// 's' specifies the variable type => 'string'
    $sql_re->execute();
    $result_re = $sql_re->get_result();
   
    if ($result_re->num_rows == 0) {
        
      echo '<div class="d-flex justify-content-between align-items-center w-100" style="margin-top:30px;">
      <strong class="text-gray-dark">There are no request</strong>
      </div>';
      echo $conn->error;
        
    } 
    else {
      while($row = $result_re->fetch_assoc()) {
        echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
        echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
        echo '<div class="card-body d-flex flex-column align-items-start">';

        echo '<div class="form-inline form-group"  >
                <div class="form-group ">
                    <strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($row['uname'],ENT_QUOTES, 'UTF-8').'</strong>
                </div>
                <form class="form-group mx-sm-3"  action="friend_request.php" method="POST">
                    <input class="form-control" type="text" name="friend_action" style="display: none" value=2 >
                    <input class="form-control" type="text" name="from_whom" style="display: none" value='.htmlspecialchars($row['uid'],ENT_QUOTES, 'UTF-8').' >
                    <button class="btn btn-outline-success btn-sm"  type="submit">Accept</button>
                </form>
                <form class="form-group "  action="friend_request.php" method="POST">
                    <input class="form-control" type="text" name="friend_action" style="display: none" value=0>
                    <input class="form-control" type="text" name="from_whom" style="display: none" value='.htmlspecialchars($row['uid'],ENT_QUOTES, 'UTF-8').' >
                    <button class="btn btn-outline-danger btn-sm"  type="submit">Refuse</button>
                </form>
                
            </div>';
        echo '<p class="card-text mb-auto" >E-mail:'.htmlspecialchars($row['uemail'],ENT_QUOTES, 'UTF-8').'</p>';
        echo '<p class="card-text mb-auto text-muted" >Request time:'.htmlspecialchars($row['ftime'],ENT_QUOTES, 'UTF-8').'</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        

      }
      
      
    }
    echo '</div>';
    echo '</div>';
    echo '</div></div>';


    

    $conn->close();
   
  


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
      
      
</script>
<div id="txtHint" class ="container"></div>
  </body>
  
</html>
