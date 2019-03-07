<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>HomePage</title>

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

    //获取当前用户的信息
    $sql_info = "SELECT  * FROM user Where uid=".$_COOKIE['uid'];
    $result_info = $conn->query($sql_info);
    echo $conn->error;
    if($result_info->num_rows != 0){
        //显示用户信息卡片
        $rowinfo=$result_info->fetch_assoc();
        echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
        echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
        echo '<div class="card-body d-flex flex-column align-items-start">';
        echo '<div class="form-inline form-group" style="margin-top:10px" >
                <div class="form-group ">
                    <strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($_COOKIE['user'],ENT_QUOTES, 'UTF-8').'</strong>
                </div>
                <small class="form-group mx-sm-3 text-right ">
                    <a href="profile">edit</a>
                    
                </small>
                
            </div>';
        
        echo '<p class="card-text mb-auto" >E-mail:'.htmlspecialchars($rowinfo['uemail'],ENT_QUOTES, 'UTF-8').'</p>';
        //更改状态div。 当change按钮被点击时，第一个div被第二个替代
        echo '<div class="form-inline form-group" style="margin-top:10px" id="show_status">
                <div class="form-group ">
                    <p class="card-text mb-auto" >Status:  '.htmlspecialchars($rowinfo['ustatus'],ENT_QUOTES, 'UTF-8').'</p>
                </div>
                <div class="form-group mx-sm-3 ">
                    <button class="btn btn-outline-info btn-sm" type="submit" onclick=changestatus() >Change status</button>
                </div>
            </div>';
         echo '<form class="form-inline form-group" style="margin-top:10px;display: none" id="change_status" action="changestatus.php" method="POST">
                <div class="form-group ">
                    <label for="date">Status:</label>
                    <input class="form-control" type="text" id= "ustatus" size="10" name="ustatus" value="'.htmlspecialchars($rowinfo['ustatus'],ENT_QUOTES, 'UTF-8').'">
                </div>
                <div class="form-group mx-sm-3 ">
                    <button class="btn btn-outline-info btn-sm" type="submit">save</button>
                </div>
            </form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
  

    

    //显示用户自己写的所有note
    $sql_note='Select nid, ncontent, uid,nlatitude, nlongitude, nradius, is_comment, ntime, nstart_time, nend_time, nrepeat_type, limit_view, 
                DATE_FORMAT(nstart_time,"%T") as stime, DATE_FORMAT(nend_time,"%T") as etime, nstart_date,nend_date, nrepeat_date From note where uid='.$_COOKIE['uid'];
    $result_note = $conn->query($sql_note);
    echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">';
    echo '<div class="my-3 p-3 bg-white rounded box-shadow">
       <h6 class="border-bottom border-gray pb-2 mb-0">My Note</h6>';
   
    if ($result_note->num_rows == 0) {
        
        echo '<div class="card flex-md-row mb-4 box-shadow h-md-250" style="margin-top:30px">';
        echo '<div class="card-body d-flex flex-column align-items-start">';
        echo '<p class="card-text mb-auto">You are note post any note. Click here to post a new note.</p>';
        echo '<a href="post.php">Create a new note</a>';
        echo '</div>';
        echo '</div>';
        echo $conn->error;
        
    } 
    else {
      while($row = $result_note->fetch_assoc()) {
        //获取note下的所有tag
        $sqltag = $conn->prepare('SELECT  * FROM n_tag Where nid=?');
        $sqltag->bind_param('i',$row['nid']);// 's' specifies the variable type => 'string'
        $sqltag->execute();
        $resulttag = $sqltag->get_result();
        $tag='';
        if($resulttag->num_rows != 0){
          while($tagrow=$resulttag->fetch_assoc()){
            $tag=$tag.' '.$tagrow["ntag"];
          }
        }
        //获取作者
        $sql_writter = $conn->prepare('SELECT  * FROM user as u, note as n Where u.uid=n.uid and n.nid= ?');
        $sql_writter->bind_param('i',$row['nid']);// 's' specifies the variable type => 'string'
        $sql_writter->execute();
        $result_writter = $sql_writter->get_result();
        echo $conn->error;
        if($result_writter->num_rows != 0){
            $writter=$result_writter->fetch_assoc()["uname"];
        }
        //获取每个note下的评论数
        $sql_num = $conn->prepare('SELECT  count(*) FROM comment Where nid= ?');
        $sql_num->bind_param('i',$row['nid']);// 's' specifies the variable type => 'string'
        $sql_num->execute();
        $result_num = $sql_num->get_result();
        echo $conn->error;
        if($result_num->num_rows != 0){
            $cnum=$result_num->fetch_assoc()["count(*)"];
        }
        //不repeat时，显示基本信息
        if($row['nrepeat_type']==0){
          echo '<div class="card flex-md-row mb-4 box-shadow h-md-250" style="margin-top:30px">';
          echo '<div class="card-body d-flex flex-column align-items-start">';
          echo '<strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($writter,ENT_QUOTES, 'UTF-8').'</strong>';
          echo '<div class="mb-1 text-muted">'.htmlspecialchars($row["ntime"],ENT_QUOTES, 'UTF-8').'</div>';
          echo '<p class="card-text mb-auto">'.htmlspecialchars($row["ncontent"],ENT_QUOTES, 'UTF-8').'</p>';
          echo '<p class="card-text mb-auto" style="color: #00BFFF">'.htmlspecialchars($tag,ENT_QUOTES, 'UTF-8').'</p>';
          echo '<span class="d-block text-muted">location:('.htmlspecialchars($row['nlatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['nlongitude'],ENT_QUOTES, 'UTF-8').')</span>
                <span class="d-block text-muted">radius: '.htmlspecialchars($row['nradius'],ENT_QUOTES, 'UTF-8').'</span>
                <span class="d-block text-muted">time:'.htmlspecialchars($row['nstart_time'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['nend_time'],ENT_QUOTES, 'UTF-8').'</span>';
          echo '<div class="form-inline form-group">';
          if($row['is_comment']==1){
            echo            '<form action="comment.php" method="GET" style="margin-bottom:5px;margin-top:10px">
                  <input type="text" name="nid" value='.htmlspecialchars($row["nid"],ENT_QUOTES, 'UTF-8').' style="display: none">
                  <button class="btn btn-outline-primary btn-sm"  type="submit">comment('.htmlspecialchars($cnum,ENT_QUOTES, 'UTF-8').')</button>
                </form>';
        
            }else{
              echo   '<button class="btn btn-outline-secondary btn-sm"   disabled>comment</button>';
             
            }
          echo '<form class="form-group mx-sm-3" action="delete_note.php" method="POST">
                  <input class="form-control" type="text" name="nid" style="display: none" value='.htmlspecialchars($row["nid"],ENT_QUOTES, 'UTF-8').'>
                  <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
                </form></div>';
          echo '</div>';
          echo '</div>';

        }//repeat时，除了显示基本信息，显示schedule
        else{
          echo '<div class="card flex-md-row mb-4 box-shadow h-md-250" style="margin-top:30px">';
          echo '<div class="card-body d-flex flex-column align-items-start">';
          echo '<strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($writter,ENT_QUOTES, 'UTF-8').'</strong>';
          echo '<div class="mb-1 text-muted">'.htmlspecialchars($row["ntime"],ENT_QUOTES, 'UTF-8').'</div>';
          echo '<p class="card-text mb-auto">'.htmlspecialchars($row["ncontent"],ENT_QUOTES, 'UTF-8').'</p>';
          echo '<p class="card-text mb-auto" style="color: #00BFFF">'.htmlspecialchars($tag,ENT_QUOTES, 'UTF-8').'</p>';
          echo '<span class="d-block text-muted">location:('.htmlspecialchars($row['nlatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['nlongitude'],ENT_QUOTES, 'UTF-8').')</span>';
          echo '<span class="d-block text-muted">radius: '.htmlspecialchars($row['nradius'],ENT_QUOTES, 'UTF-8').'</span>';
          if($row['nrepeat_type']==1){
            echo '<span class="d-block text-muted">repeat_type: Day</span>';
          }
          else if($row['nrepeat_type']==2){
            $week=array("","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
            echo '<span class="d-block text-muted">repeat_type: Every '. htmlspecialchars($week[$row['nrepeat_date']],ENT_QUOTES, 'UTF-8').' </span>';
          }else if($row['nrepeat_type']==3){
            echo '<span class="d-block text-muted">repeat_type: NO.'.htmlspecialchars($row['nrepeat_date'],ENT_QUOTES, 'UTF-8').' day in each month</span>';
          }

          echo '<span class="d-block text-muted">avaliable date:'.htmlspecialchars($row['nstart_date'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['nend_date'],ENT_QUOTES, 'UTF-8').'</span>';
          echo '<span class="d-block text-muted">time:'.htmlspecialchars($row['stime'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['etime'],ENT_QUOTES, 'UTF-8').'</span>';

          echo '<div class="form-inline form-group">';
          if($row['is_comment']==1){
            echo   '<form action="comment.php" method="GET" style="margin-bottom:5px;margin-top:10px">
                  <input type="text" name="nid" value='.htmlspecialchars($row["nid"],ENT_QUOTES, 'UTF-8').' style="display: none">
                  <button class="btn btn-outline-primary btn-sm"  type="submit">comment('.htmlspecialchars($cnum,ENT_QUOTES, 'UTF-8').')</button>
                </form>';
        
            }else{
              echo   '<button class="btn btn-outline-secondary btn-sm"   disabled>comment</button>';
             
            }
          echo '<form class="form-group mx-sm-3" action="delete_note.php" method="POST">
          <input class="form-control" type="text" name="nid" style="display: none" value='.htmlspecialchars($row["nid"],ENT_QUOTES, 'UTF-8').'>
          <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
        </form></div>';
          echo '</div>';
          echo '</div>';
        }
      }

    }
    echo '</div>';
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
      function post()
      { 
        
        window.location.href="post.php";
      }
      function changestatus()
      {
        document.getElementById("show_status").style.display="none";
        document.getElementById("change_status").style.display="";
      }

</script>
<div id="txtHint" class ="container"></div>
  </body>
  
</html>
