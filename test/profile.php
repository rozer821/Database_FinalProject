<?php ob_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Cover Template for Bootstrap</title>


    <link href="css/bootstrap.css" rel="stylesheet">


    
  </head>
  <?php

    if(!isset($_COOKIE['user'])){
      header("Location: http://localhost/test/signin.php");
    } 
    
    ?>

  <body class="bg-light">

    <div class="container">
      <div class="text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Your Profile</h2>
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
  

    
    $sql = $conn->prepare('SELECT  * FROM  user where uname=?');
    $sql->bind_param('s',$_COOKIE['user']);// 's' specifies the variable type => 'string'
    $sql->execute();
    $result = $sql->get_result();
    
    

    if ($result->num_rows == 0) {
      echo "<p  style='color:red;'>Wrong</p>";
        
    } 
    else {

      while($row = $result->fetch_assoc()) {
        
        
          echo '<div class="container">
          <form class="needs-validation" action="'.$_SERVER["PHP_SELF"].'" method="POST">';
          echo '<div class="mb-3">
          <label for="username">Username</label>
          <div class="input-group">
            <input type="text" class="form-control" value="'.$row["uname"].'"name="username" placeholder="Username" required="" oninvalid="setCustomValidity("please input username")">
          </div>
        </div>';
          echo '<div class="mb-3">
          <label for="username">password</label>
          <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="password" required="" oninvalid="setCustomValidity("please input username")">
          </div>
        </div>
        <div class="mb-3">
          <label for="username">new password</label>
          <div class="input-group">
            <input type="password" class="form-control" name="npassword" placeholder="new password" >
          </div>
        </div>

        <div class="mb-3">
          <label for="username">confirm your password</label>
          <div class="input-group">
            <input type="password" class="form-control" name="cpassword" placeholder="confirm your password" >
          </div>
        </div>

        <div class="mb-3">
          <label for="email">Email <span class="text-muted">(Optional)</span></label>
          <input type="email" class="form-control" name="email" value="'.$row["uemail"].'"placeholder="you@example.com" required="" oninvalid="setCustomValidity("please input email")" onclick="setCustomValidity("")"> 
        </div>';
        echo '<hr class="mb-4">
              <div class="row">
                <div class="col">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                </div>';
        echo '  <div class="col">
                  <button class="btn btn-primary btn-lg btn-block" onclick=backhome()>Back</button>
                </div>
              </div>';
        echo "</form>";
        echo "</div></div>";

      }
      
      
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if($_POST['npassword']!=$_POST['cpassword']){
        echo "<p  style='color:red;'>confirm password is not the same as password!</p>";
      }
      else{
        $username=$_POST['username'];
        $old_password=$_POST['password'];
        $new_password=$_POST['npassword'];
        $email=$_POST["email"];

      
        $sql_check_oldpwd = "SELECT  * FROM user  where uname="."'".$_COOKIE['user']."'";
        $result_check_oldpwd = $conn->query($sql);

        
        if($result_check_oldpwd->fetch_assoc()['upwd']!=$old_password) {
          echo "<p  style='color:red;'>Your password is wrong!</p>";
        }
        else{
          $sql_check_uname = "SELECT  * FROM user  where uname="."'".$username."'";

          $result_check_uname = $conn->query($sql_check_uname);
          if ($username!=$_COOKIE['user'] and $result_check_uname->num_rows > 0) {
            echo "<p  style='color:red;'>This username has been used!</p>";
              
          } 
          else {
            if($new_password==''){
              $sql_update="UPDATE user SET uname='".$username."',uemail='".$email."' Where uname='".$_COOKIE['user']."'";

            }else{
              $sql_update="UPDATE user SET uname='".$username."',upwd='".$new_password."',uemail='".$email."' Where uname='".$_COOKIE['user']."'";

            }
            
            $conn->query($sql_update);
            echo $conn->error;
            setcookie("user", "", -1);
            setcookie("user", $username, time()+3600);
            
            header("Location: http://localhost/test/home.php");
            // echo '<script language="javascript" type="text/javascript">' ;
            // echo 'window.location.href=“http://localhost:8080/test/home.php"';
            //echo $sql_update;
          }
        
        }

        
      }
    }
        
        
    $conn->close();
    ob_end_flush();
    
  


  ?>
    
  </body>
  <script>
    
      function backhome()
      { 
        
        window.location.href="home.php";
      }
</script>
</html>