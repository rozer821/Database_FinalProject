<?php


// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
$servername = "127.0.0.1";
$username = "root";
$password = "961010";
$database = "project2";
// Opens a connection to a MySQL server
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 } 

$query = "SELECT * FROM note NATURAL JOIN `user`";
$query_action = 'SELECT * FROM latest_action WHERE uid = '. $_COOKIE['uid'].'';
$result = $conn->query($query);
$result_action = $conn->query($query_action);

header( "content-type: application/xml; charset=ISO-8859-15" );

// Iterate through the rows, adding XML nodes for each

if ($result->num_rows>0) {
 while ($row = $result->fetch_assoc()){
   // Add to XML document node

   $node = $dom->createElement("marker");
   $newnode = $parnode->appendChild($node);
   $newnode->setAttribute("nid", $row['nid']);
   $newnode->setAttribute("uid", $row['uid']);
   $newnode->setAttribute("ncontent", $row['ncontent']);
   $newnode->setAttribute("nlongitude", $row['nlongitude']);
   $newnode->setAttribute("nlatitude", $row['nlatitude']);
   $newnode->setAttribute("limit_view", $row['limit_view']);
   $newnode->setAttribute("uname",$row['uname']);
   $newnode->setAttribute("note_start_time",$row['nstart_time']);
   $newnode->setAttribute("note_end_time",$row['nend_time']);
   $newnode->setAttribute("nradius",$row['nradius']);
   $newnode->setAttribute("note_start_date",$row['nstart_date']);
   $newnode->setAttribute("note_end_date",$row['nend_date']);
   $newnode->setAttribute("repeat_date",$row['nrepeat_date']);
   $newnode->setAttribute("repeat_type",$row['nrepeat_type']);

 }
 if ($result_action->num_rows>0) {
   while ($row = $result_action->fetch_assoc()) {
      $newnode->setAttribute("longitude_action",$row['alongitude']);
      $newnode->setAttribute("latitude_action",$row['alatitude']);
      $newnode->setAttribute("current_time",$row['atime']);
   }
    
 }
}


$xmlfile = $dom->saveXML();
echo $xmlfile;


?>