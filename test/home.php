<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      </style>
    <title>Home</title>

   
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
    
  
    //获取用户当前状态
    $sql_action = $conn->prepare('SELECT alatitude,alongitude,atime,DATE_FORMAT(atime,"%T"),DAYOFWEEK(atime),DAY(atime) FROM latest_action where uid= ?');
    $sql_action->bind_param('i',$_COOKIE['uid']);// 's' specifies the variable type => 'string'
    $sql_action->execute();
    $result_action = $sql_action->get_result();
    // $sql_action = 'SELECT alatitude,alongitude,atime,DATE_FORMAT(atime,"%T"),DAYOFWEEK(atime),DAY(atime) FROM latest_action where uid='.$_COOKIE['uid'];
    // $result_action = $conn->query($sql_action);

    if ($result_action->num_rows == 0) {
      echo "<p  style='color:red;'>There are no action in table actions.</p>";
    } 
    else {

      while($row = $result_action->fetch_assoc()) {
        
        $ualatitude= $row['alatitude'];
        $ualongitude= $row['alongitude'];
        $uatime= $row['atime'];
        $uhourminute=$row['DATE_FORMAT(atime,"%T")'];
        $uaweek=$row['DAYOFWEEK(atime)'];
        $uaday=$row['DAY(atime)'];
      }
    }
    //给定一个用户，输出它可以看到的所有note
    $sql_note='With note_friend as
    (
        Select *
        from note as n1
        Where n1.limit_view=0 or (n1.uid='.$_COOKIE['uid'].') or (n1.limit_view=1 and '.$_COOKIE['uid'].' in(
            (
                select uid1 
                From friend_relation 
                where friend_relation.uid2=n1.uid 
            )
            UNION
            (
                select uid2
                From friend_relation 
                where friend_relation.uid1 =n1.uid 
            )
        ))   
    ),note_final as(
        (
            Select *
            From  note_friend 
            Where nrepeat_type=0 and nstart_time<"'.$uatime.'" and nend_time>"'.$uatime.'" 
            AND (getdistance(nlatitude,nlongitude,'.$ualatitude.','.$ualongitude.')<nradius or nradius=-1)
        )
        UNION
        (
            Select *
            From  note_friend 
            Where nrepeat_type=1 and DATE_FORMAT(nstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(nend_time,"%T")>"'.$uhourminute.'" 
            AND (getdistance(nlatitude,nlongitude,'.$ualatitude.','.$ualongitude.')<nradius or nradius=-1)
        )
        UNION
        (
            Select *
            From  note_friend 
            Where nrepeat_type=2 and nrepeat_date='.$uaweek.' and DATE_FORMAT(nstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(nend_time,"%T")>"'.$uhourminute.'" 
            AND (getdistance(nlatitude,nlongitude,'.$ualatitude.','.$ualongitude.')<nradius or nradius=-1)
        )
        UNION
        (
            Select *
            From  note_friend 
            Where nrepeat_type=3 and nrepeat_date='.$uaday.' and DATE_FORMAT(nstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(nend_time,"%T")>"'.$uhourminute.'" 
            AND (getdistance(nlatitude,nlongitude,'.$ualatitude.','.$ualongitude.')<nradius or nradius=-1)
        )
    ),filter_used as (
       (
            Select * 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=0 and (f.fstatus=u1.ustatus or f.fstatus is NULL) and f.fstart_time<"'.$uatime.'" and f.fend_time>"'.$uatime.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select * 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=1 and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select * 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=2 and frepeat_date='.$uaweek.' and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select * 
            From filters as f natural join user as u1
            Where f.uid=5 AND frepeat_type=3 and frepeat_date='.$uaday.' and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL)or (f.fradius=-1))
       )
    ),ufriend(fuid) as(
        (
            select uid1 
            From friend_relation
            where friend_relation.uid2='.$_COOKIE['uid'].'
        )
        UNION
        (
            select uid2
            From friend_relation
            where friend_relation.uid1 = '.$_COOKIE['uid'].'
        )
    )
    (
      Select nid,ncontent, ntime, is_comment, nf0.uid
      From  (note_final as nf0, user as u) left join filter_used as f on f.uid=u.uid
      Where  u.uid= '.$_COOKIE['uid'].' and ((f.ftag in (Select ntag From n_tag Where nf0.nid=nid) and flimit_view=0) or (f.ftag is NULL) or ('.$_COOKIE['uid'].' not in (Select uid From filter_used)))
    )
    UNION
    (
        Select nid,ncontent, ntime, is_comment, nf1.uid
        From  (note_final as nf1, user as u) left join filter_used as f on f.uid=u.uid
        Where u.uid= '.$_COOKIE['uid'].' and ((f.ftag in (Select ntag From n_tag Where nf1.nid=nid) and flimit_view=1 and nf1.uid in (Select fuid from ufriend)) or (f.ftag is NULL) or ('.$_COOKIE['uid'].' not in (Select uid From filter_used)))
    )
    UNION
    (
        Select nid,ncontent, ntime,is_comment, nf2.uid
        From  (note_final as nf2, user as u) left join filter_used as f on f.uid=u.uid
        Where u.uid= '.$_COOKIE['uid'].' and ((f.ftag in (Select ntag From n_tag Where nf2.nid=nid) and flimit_view=2 and nf2.uid='.$_COOKIE['uid'].' ) or (f.ftag is NULL) or ('.$_COOKIE['uid'].' not in (Select uid From filter_used)))
    ) ';

    $result_note = $conn->query($sql_note);
   
   
    if ($result_note->num_rows == 0) {
      echo '<div  style="margin-top:30px;margin-left:30px;margin-right:30px">';
      echo '<div class="card flex-md-row mb-4 box-shadow h-md-250">';
      echo '<div class="card-body d-flex flex-column align-items-start">';
      echo '<p class="card-text mb-auto">There are no note available.</p>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo $conn->error;
        
    } 
    else {

      while($row = $result_note->fetch_assoc()) {
        //获取与该note绑定的所有tag
        $sqltag = $conn->prepare('SELECT  * FROM n_tag Where nid=?');
        $sqltag->bind_param('i',$row['nid']);// 's' specifies the variable type => 'string'
        $sqltag->execute();
        $resulttag = $sqltag->get_result();
        // $sqltag = "SELECT  * FROM n_tag Where nid=".$row['nid'];
        // $resulttag = $conn->query($sqltag);
        $tag='';
        if($resulttag->num_rows != 0){
          while($tagrow=$resulttag->fetch_assoc()){
            $tag=$tag.' '.$tagrow["ntag"];

          }
        }

        //根据uid获得note的作者
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
      

        echo '<div style="margin-top:30px;margin-left:30px;margin-right:30px">
                  <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                      <strong class="d-inline-block mb-2 text-primary">'.htmlspecialchars($writter,ENT_QUOTES, 'UTF-8').'</strong>
                      <div class="mb-1 text-muted">'.htmlspecialchars($row["ntime"],ENT_QUOTES, 'UTF-8').'</div>
                        <p class="card-text mb-auto">'.htmlspecialchars($row["ncontent"],ENT_QUOTES, 'UTF-8').'</p>
                        <p class="card-text mb-auto" style="color: #00BFFF">'.htmlspecialchars($tag,ENT_QUOTES, 'UTF-8').'</p>';
        if($row['is_comment']==1){
          echo            '<form action="comment.php" method="GET" style="margin-bottom:5px;margin-top:10px">
          <input type="text" name="nid" value='.htmlspecialchars($row["nid"],ENT_QUOTES, 'UTF-8').' style="display: none">
          <button class="btn btn-outline-primary btn-sm"  type="submit">comment('.htmlspecialchars($cnum,ENT_QUOTES, 'UTF-8').')</button>
        </form>';

        }else{
          echo  '<button class="btn btn-outline-secondary btn-sm"  type="submit" disabled>comment</button>';
        }
       
        echo          '</div>
                    </div>
                  </div>
                </div>';
       
        

      }
      
      
    }
    $conn->close();
    ob_end_flush();
  ?>
    
    <div class= 'container'id= "map"></div>
      <form class="card-body container" name = "myform" action="updateaction.php" method="POST" onsubmit="return test(this);"> 
        <div class="form-inline form-group" id="no_repeat_time">
                <div class="form-group mb-2">
                    <label for="date">Set date</label>
                    <input class="form-control" type="date" name="current_date" required>
                  </div>
            
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">Set time</label>
                    <input class="form-control" type="time" step="01" name="current_time" required>
                  </div>
                
        
                  <div class="form-group mb-2">
                    <button class="btn btn-primary" type="submit" onclick = sentValueToPHP()>Post</button>
                  </div>
          </div>
           <div id ="longitude" name="longitude1"></div>
           <div id ="latitude" name="latitude1"></div>
           <input type="hidden" name="extra" value="">
           <input type="hidden" name="extra1" value="" >

      </form>
    
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
      function sentValueToPHP(){
       
       document.myform.extra.value = lng;
       document.myform.extra1.value = lat;
   
       // alert(document.myform.extra1.value);
       // alert(lat);
     }
     function test(obj){
       if(document.myform.extra.value=="undefined"){
         alert("please choose a location");
         return false;
       };
         
       
     }
      
     
</script>
<script src="js/ini_map.js">


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=****************&callback=initMap"
    async defer></script>
  </body>
  
</html>
