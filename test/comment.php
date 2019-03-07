<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Note</title>

    
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  </head>


  <body>
    <?php

    if(!isset($_COOKIE['user'])){
      header("Location: http://localhost/test/signin.php");
    } 
    
    ?>
    <div>
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Oingo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="map.php">Map <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <div class="dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $_COOKIE["user"];?></a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="homepage.php">Homepage</a>
                  <a class="dropdown-item" href="friend.php">Friends</a>
                  <a class="dropdown-item" href="filters.php">Filter</a>
                </div>
              </div>
            </li>
          </ul>
          

          <div class="form-inline my-2 my-md-0">
            
            <button class="btn btn-outline-success btn-sm btn-block" style="margin-right:20px" onclick=post()>create new post</button>
          </div>
          <div class="form-inline my-2 my-md-0">
            
            <button class="btn btn-outline-success btn-sm btn-block" onclick=signout() >sign out</button>
          </div>
          
      </nav>
    </div>
    
    

    <?php
 
        
        $nid=$_GET['nid'];

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

        
        $sqltag = $conn->prepare('SELECT  * FROM n_tag Where nid= ?');
        $sqltag->bind_param('i',$nid);// 's' specifies the variable type => 'string'
        $sqltag->execute();
        $resulttag = $sqltag->get_result();
        if($resulttag->num_rows != 0){
          
          while($tagrow=$resulttag->fetch_assoc()){
            $tag=$tag.' '.$tagrow["ntag"];

          }
        }

        

        $sql_writter = $conn->prepare('SELECT  * FROM user as u, note as n Where u.uid=n.uid and n.nid= ?');
        $sql_writter->bind_param('i',$nid);// 's' specifies the variable type => 'string'
        $sql_writter->execute();
        $result_writter = $sql_writter->get_result();
        echo $conn->error;
        if($result_writter->num_rows != 0){
        
            $writter=$result_writter->fetch_assoc()["uname"];


        }

        
        $sql_note = $conn->prepare('Select * from note where nid= ?');
        $sql_note->bind_param('i',$nid);
        $sql_note->execute();
        $result_note = $sql_note->get_result();
        if($result_note->num_rows != 0){
        
            $note=$result_note->fetch_assoc();
        }

        echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
        echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
        echo '<div class="card-body d-flex flex-column align-items-start">';
        echo '<strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($writter,ENT_QUOTES, 'UTF-8').'</strong>';
        echo '<div class="mb-1 text-muted">'.htmlspecialchars($note["ntime"],ENT_QUOTES, 'UTF-8').'</div>';
        echo '<p class="card-text mb-auto">'.htmlspecialchars($note["ncontent"],ENT_QUOTES, 'UTF-8').'</p>';
        echo '<p class="card-text mb-auto" style="color: #00BFFF">'.htmlspecialchars($tag,ENT_QUOTES, 'UTF-8').'</p>';
        echo '<div  style="margin-bottom:5px;margin-top:10px">
              <input type="text" name="nid" value='.htmlspecialchars($nid,ENT_QUOTES, 'UTF-8').' style="display: none">
              <button class="btn btn-outline-primary btn-sm"  onclick=comment()>comment</button>
              </div>';
        echo '</div>';
        echo '</div>';
        


        echo '<h6 class="border-bottom border-gray pb-2 mb-0">Comment</h6>';

        $sql_comment = $conn->prepare('Select * from comment where nid= ?');
        $sql_comment->bind_param('i',$nid);
        $sql_comment->execute();
        $result_comment = $sql_comment->get_result();
        

        if ($result_comment->num_rows == 0) {
            echo '<div class="d-flex justify-content-between align-items-center w-100">
                   <strong class="text-gray-dark">There are no comment</strong>
                   </div>';
            
            echo $conn->error;
              
          } 
          else {
           $fid_list='';
            while($row = $result_comment->fetch_assoc()) {

               

                $sql_c_writter = $conn->prepare('select * from user where uid= ?');
                $sql_c_writter->bind_param('i',$row['uid']);
                $sql_c_writter->execute();
                $result_c_writter = $sql_c_writter->get_result();
                if($result_c_writter->num_rows != 0){
        
                    $c_writter=$result_c_writter->fetch_assoc()["uname"];
        
        
                }
                
                echo'<div class="media  pt-3">
                           <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                               <div class="d-flex justify-content-between align-items-center w-100">
                                   <strong class="text-gray-dark">'.htmlspecialchars($c_writter,ENT_QUOTES, 'UTF-8').'</strong>
                                   <button class="btn btn-outline-primary btn-sm" onclick=reply(this.name,this.id) name="'.htmlspecialchars($c_writter,ENT_QUOTES, 'UTF-8').'" id='.htmlspecialchars($row['cid'],ENT_QUOTES, 'UTF-8').'>reply</button>
                               </div>
                               <span class="d-block">'.htmlspecialchars($row['ctime'],ENT_QUOTES, 'UTF-8').'</span>
                               <p class="card-text mb-auto">';
                               
                if($row['reply_cid']!=Null) {

                    

                    $sql_reply = $conn->prepare('Select * from comment as c, user as u where u.uid=c.uid and cid= ?');
                    $sql_reply->bind_param('i',$row['reply_cid']);
                    $sql_reply->execute();
                    $result_reply = $sql_reply->get_result();
                    if($result_reply->num_rows != 0){
                    
                        $replyto=$result_reply->fetch_assoc()['uname'];
                    }
                    echo 'reply to '.$replyto.':  ';
                }
                            
                echo $row["ctext"].'</p>
                           </div>
                       </div>';
             
              
      
            }
            
            
          }
        
        echo '<form id="comment" action="sentcomment.php" method="POST">
          <div class="form-group" style="margin-top:30px;">
                <textarea class="form-control" name="ctext" rows="3" required="" placeholder="comment" oninvalid="setCustomValidity("please input your username")" oninput="setCustomValidity("")" maxlength=140></textarea>
                <input class="form-control" type="text" name="nid" style="display: none" value='.htmlspecialchars($nid,ENT_QUOTES, 'UTF-8').'>
                
             </div>';
        echo '<div class="row">
                <div class="col-sm" ></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm">
                  <button class="btn btn-lg btn-outline-primary btn-block" type="submit" >Comment</button>
                </div>
              </div></form>';


        
        echo '<form id="reply" style="display: none" action="reply.php" method="POST">
              <div class="form-group" style="margin-top:30px;">
                    <textarea class="form-control" id="replytext" name="replytext" rows="3" required="" placeholder="comment" oninvalid="setCustomValidity("please input your username")" oninput="setCustomValidity("")" maxlength=140></textarea>
                    <input class="form-control" type="text" name="nid" style="display: none" value='.htmlspecialchars($nid,ENT_QUOTES, 'UTF-8').'>
                    <input class="form-control" type="text" name="cid" style="display: none" id ="cid" value="no">
                 </div>';
        echo '<div class="row" >
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm">
                      <button class="btn btn-lg btn-outline-primary btn-block" type="submit" >Reply</button>
                    </div>
                  </div></form>';     








        echo '</div>';
        
        
        
    
   
  

      $conn->close();
    ob_end_flush();
  


  ?>
    
    
    <script>
    
      function signout()
      {
        document.cookie = "user" + '=;  expires=Thu, 01 Jan 1970 00:00:01 GMT;'
        document.cookie = "uid" + '=;  expires=Thu, 01 Jan 1970 00:00:01 GMT;'
        
        window.location.href="signin.php";
      }
      function comment()
      {
        document.getElementById("comment").style.display="";
        document.getElementById("reply").style.display="none";
      }
      function reply(name,cid)
      {
        document.getElementById("comment").style.display="none";
        document.getElementById("reply").style.display="";
        document.getElementById("replytext").placeholder="reply to: "+name;
        document.getElementById("cid").value=cid;
        
      }
      function post()
      { 
        
        window.location.href="post.php";
      }
      
</script>
  </body>
  
</html>
