<?php ob_start(); ?>
<!doctype html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Signin</title>

  
    <link href="css/cover.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    
  </head>

  <?php
        if(isset($_COOKIE['user'])){
            header("Location: http://localhost/test/home.php");
        } 
    
  ?>

  <body class="text-center" style="background:#f0f0f0" >
    
    <div class="container">
      <div class="card col-md-5 box-shadow col-center-block "style="margin-top:200px;">
      <div class=" col-md-8 col-center-block " style="padding-top:50px;padding-bottom:50px;background:#fff" >
        <div class="box-shadow">
          <form class="form-signin" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
            <img class="mb-4" src="asset/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h1 mb-3 font-weight-normal" >Oingo</h1>
            <input type="text" name="username" class="form-control" placeholder="Username"  required="" oninvalid="setCustomValidity('please input your username')" oninput="setCustomValidity('')">
            <input type="password" name="password" class="form-control" placeholder="Password" required="" oninvalid="setCustomValidity('please input your password')" oninput="setCustomValidity('')">
            <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top:30px;">Sign in</button>  
          </form>
          <a class="text-muted" href="register.php" >Create new account</a>
        </div>
         
      </div>
      </div>
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



      if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $username=$_POST['username'];
        $password=$_POST['password'];
       

        //$sql = "SELECT  * FROM user  where uname="."'".$username."' and upwd="."'".$password ."'";
        $sql = $conn->prepare('SELECT  * FROM user  where uname= ? and upwd= ? ');
        $sql->bind_param('ss',$username,$password);// 's' specifies the variable type => 'string'
        $sql->execute();
        $result = $sql->get_result();
        
        

        if ($result->num_rows == 0) {
          echo "<p  style='color:red;'>wrong username or password, please enter again</p>";
          //echo $sql;
        } 
        else {
          $uid=$result->fetch_assoc()["uid"];
          //设置cookie
          setcookie("uid", $uid, time()+3600);
          setcookie("user", $username, time()+3600);
          header("Location: http://localhost/test/home.php");

          
        }
        

        
      }
    $conn->close();


    ob_end_flush();

    ?>

  </body>
</html>
