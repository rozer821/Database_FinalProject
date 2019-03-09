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
ob_start();


$from_whom = $_GET["from_whom"];
$to_whom=$_GET['to_whom'];
 
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
$sql_curtime='Select * from latest_action where uid='.$_COOKIE['uid'];
$curtime=$conn->query($sql_curtime)->fetch_assoc()['atime'];

$sql_lock="LOCK TABLES friend_request write";
$conn->query($sql_lock);
$sql1='Select * from friend_request where from_whom='.$from_whom.' and to_whom='.$to_whom.' and frstatus=1';
$result=$conn->query($sql1);
if ($result->num_rows == 0) {
    $sql='Insert into friend_request values('.$from_whom.','.$to_whom.',1,"'.$curtime.'")';
    if ($conn->query($sql) === TRUE) {
        echo 111;
        $sql_unlock="UNLOCK TABLES";
        $conn->query($sql_unlock);

    }else{
        echo $conn->error;
        $sql_unlock="UNLOCK TABLES";
        $conn->query($sql_unlock);
    }
    

}


echo $sql1;


$conn->close();
ob_end_flush();
?>
</body>
</html>