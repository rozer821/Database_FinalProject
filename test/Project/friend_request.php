<?php ob_start(); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $friend_action = $_POST["friend_action"];
    $from_whom=$_POST['from_whom'];
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
    
    if($friend_action=='0'){
        $sql_lock="LOCK TABLES friend_request write";
        $conn->query($sql_lock);
        $sql = 'Delete from  friend_request Where from_whom ='.$from_whom.' and to_whom='.$_COOKIE['uid'];
        if ($conn->query($sql) === TRUE) {
            $sql_unlock="UNLOCK TABLES";
            $conn->query($sql_unlock);
            header("Location: http://localhost/test/friend.php");
            //Update friend_request Set frstatus= 1 Where from_whom =1 and to_whom=3
        }else{
            echo $conn->error;
        }

    }else if($friend_action=='2'){
        $sql_lock="LOCK TABLES friend_request write";
        $conn->query($sql_lock);
        $sql = 'Update friend_request Set frstatus= 2 Where from_whom ='.$from_whom.' and to_whom='.$_COOKIE['uid'];
        if ($conn->query($sql) === TRUE) {
            $sql_unlock="UNLOCK TABLES";
            $conn->query($sql_unlock);

            $sql_lock="LOCK TABLES friend_relation write";
            $conn->query($sql_lock);

            $sql='Insert into friend_relation values('.$from_whom.','.$_COOKIE['uid'].')';
            $conn->query($sql);

            $sql_unlock="UNLOCK TABLES";
            $conn->query($sql_unlock);
            
            echo $conn->error;
            header("Location: http://localhost/test/friend.php");


        }else{
            echo $conn->error;
        }

    }




    $conn->close();
    
}

?>
