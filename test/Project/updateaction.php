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
$date = $_POST['current_date'];
    
$time = $_POST['current_time'];
    
$atime = $date . ' '.$time ;
    
$alatitude= $_POST['extra1'];
    
$alongitude= $_POST['extra'];

$sql = $conn->prepare("select max(aid) from actions;");
$sql->execute();
$aid=$sql->get_result()->fetch_assoc()['max(aid)']+1;

$sql_action = $conn->prepare("INSERT INTO actions VALUES( ? , ? , ? , ? , ? )");
$sql_action->bind_param('iidds',$aid,$_COOKIE['uid'],$alongitude,$alatitude,$atime);// 's' specifies the variable type => 'string'



if ($sql_action->execute() === TRUE) {
    
    header("Location: http://localhost/test/home.php");
        //Update friend_request Set frstatus= 1 Where from_whom =1 and to_whom=3
}else{
    echo $conn->error;
    echo $aid.$_COOKIE['uid'].$alongitude.$alatitude.$atime;
}
?>