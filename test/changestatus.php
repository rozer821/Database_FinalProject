<?php ob_start(); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $ustatus = $_POST["ustatus"];
    
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


  $sql = 'Update user Set ustatus="'.$ustatus.'" Where uid='.$_COOKIE['uid'];
  $sql_lock="LOCK TABLES user write";
  $conn->query($sql_lock);
  if ($conn->query($sql) === TRUE) {
    $sql_unlock="UNLOCK TABLES";
    $conn->query($sql_unlock);
    header("Location: http://localhost/test/homepage.php");

  }else{
      echo $conn->error;
      $sql_unlock="UNLOCK TABLES";
      $conn->query($sql_unlock);
  }



  $conn->close();
}

ob_end_flush();
?>

