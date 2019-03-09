<?php ob_start(); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nid = $_POST["nid"];
    
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
    $sql_lock="LOCK TABLES note write";
    $conn->query($sql_lock);
    $sql = 'Delete from  note Where nid ='.$nid;
    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/test/homepage.php");
        //Update friend_request Set frstatus= 1 Where from_whom =1 and to_whom=3
    }else{
        echo $conn->error;
        $sql_unlock="UNLOCK TABLES";
        $conn->query($sql_unlock);
    }




    $conn->close();
    ob_end_flush();
}

?>
