<?php ob_start(); ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">


        <title>Register</title>

        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    </head>
    

    <body class="bg-light">
        

        <div class="container">
            <div class="text-center">
                <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                <h2>Create Your New Account</h2>
            </div>
        </div>

        <div class="container">

      
            <form class="form-signin" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
               

                <div class="mb-3">
                    <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" required="" oninvalid="setCustomValidity('please input username')" >
                    
                </div>

                <div class="mb-3">
                    <label for="username">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required=""oninvalid="setCustomValidity('please input password')" >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Confirm Your Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Your Password" required=""oninvalid="setCustomValidity('please input password')" >
                    </div>
                </div>


                <div class="mb-3">
                    <label for="email">Email </label>
                    <input type="email" class="form-control" name="email" placeholder="you@example.com"  required="" oninvalid="setCustomValidity('please input email')" onclick="setCustomValidity('')">

                </div>

                <hr class="mb-4">
                
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Create</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary btn-lg btn-block" onclick=backsignin()>Back</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            //判断两次密码输入是否一致
            if($_POST['password']!=$_POST['cpassword']){
                echo "<p  style='color:red;'>confirm password is not the same as password!</p>";
            }else{

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
          
                $username=$_POST['username'];
                $password=$_POST['password'];
                $cpassword=$_POST['cpassword'];
                $email=$_POST['email'];

                //判断用户名是否存在
                
                $sql = "SELECT  * FROM user  where uname="."'".$username."'";
                $result = $conn->query($sql);
                if ($result->num_rows != 0) {
                    echo "<p  style='color:red;'>username has already been used!</p>";  
                } 
                else {
                    
                    $sql_max_uid="select max(uid) from user;";
                    $uid=$conn->query($sql_max_uid)->fetch_assoc()['max(uid)']+1;
                    
                    $sql_insert = $conn->prepare("INSERT INTO user(uid,uname,uemail,upwd) values(?,?,?,?)" );
                    $sql_insert->bind_param('isss',$uid,$username,$email,$password);
                    
                    //$sql_insert="INSERT INTO user(uid,uname,uemail,upwd) values(".$uid.",'".$username."','".$email."',".$password.")" ; 
                    
                    if($sql_insert->execute()==true){
                        $sql = $conn->prepare("select max(aid) from actions;");
                        $sql->execute();
                        $aid=$sql->get_result()->fetch_assoc()['max(aid)']+1;

                        $sql_insert_action = $conn->prepare("INSERT INTO actions(aid,uid,alatitude,alongitude,atime) values(?,?,40.694055,-73.986556,now())" );
                        echo $conn->error;
                        $sql_insert_action->bind_param('ii',$aid,$uid);
                        if($sql_insert_action->execute()==true){
                        
                            setcookie("user", "", -1);
                            setcookie("uid", "", -1);
                            setcookie("uid", $uid, time()+3600);
                            setcookie("user", $username, time()+3600);
                            
                            header("Location: http://localhost/test/home.php");
                        }
                        else{
                            echo $conn->error;
                        }
                    }
                    else{
                        echo $conn->error;
                    }

                    
                }
                
        
                $conn->close();
            }
            
            
        }
        ?>
    </body>
    <script>
    
    function backsignin()
    { 
      
      window.location.href="signin.php";
    }
</script>
</html>