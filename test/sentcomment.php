<?php
ob_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
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

    $ctext=$_POST['ctext'];
    $nid=$_POST['nid'];
    $sql_max_cid="select max(cid) from comment;";
    $cid=$conn->query($sql_max_cid)->fetch_assoc()['max(cid)']+1;

    $sql_curtime='Select * from latest_action where uid='.$_COOKIE['uid'];
    $curtime=$conn->query($sql_curtime)->fetch_assoc()['atime'];

    $sql='Insert into comment(cid,uid,ctext,nid,ctime) values('.$cid.', '.$_COOKIE['uid'].',"'.$ctext.'",'.$nid.',"'.$curtime.'")';
    $sql_lock="LOCK TABLES comment write";
    $conn->query($sql_lock);
    if ($conn->query($sql) === TRUE) {
        $sql_unlock="UNLOCK TABLES";
        $conn->query($sql_unlock);

        header("Location: http://localhost/test/comment.php?nid=".$nid);


    }else{
        echo $conn->error;
        $sql_unlock="UNLOCK TABLES";
        $conn->query($sql_unlock);
    }
    $conn->close();
    ob_end_flush();
} 
?>