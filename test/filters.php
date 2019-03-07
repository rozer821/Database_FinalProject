<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Filter</title>

   
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
        //获取用户最新状态
        
        $sql_action = $conn->prepare('SELECT alatitude,alongitude,atime,DATE_FORMAT(atime,"%T"),DAYOFWEEK(atime),DAY(atime) FROM latest_action where uid= ?');
        $sql_action->bind_param('i',$_COOKIE['uid']);
        $sql_action->execute();
        $result_action = $sql_action->get_result();
        if ($result_action->num_rows == 0) {
            echo "<p  style='color:red;'>There are no note available.</p>";   
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
        //找到用户可用的filter
        $sql='(
            Select fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,
            DATE_FORMAT(fstart_time,"%T") as stime, DATE_FORMAT(fend_time,"%T") as etime, fstart_date,fend_date, frepeat_date 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=0 and (f.fstatus=u1.ustatus or f.fstatus is NULL) and f.fstart_time<"'.$uatime.'" and f.fend_time>"'.$uatime.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,
           DATE_FORMAT(fstart_time,"%T") as stime, DATE_FORMAT(fend_time,"%T") as etime, fstart_date,fend_date, frepeat_date 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=1 and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,
           DATE_FORMAT(fstart_time,"%T") as stime, DATE_FORMAT(fend_time,"%T") as etime, fstart_date,fend_date, frepeat_date 
            From filters as f natural join user as u1
            Where f.uid='.$_COOKIE['uid'].' AND frepeat_type=2 and frepeat_date='.$uaweek.' and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL) or (f.fradius=-1))
       )
       UNION
       (
           Select fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view ,
           DATE_FORMAT(fstart_time,"%T") as stime, DATE_FORMAT(fend_time,"%T") as etime, fstart_date,fend_date, frepeat_date 
            From filters as f natural join user as u1
            Where f.uid=5 AND frepeat_type=3 and frepeat_date='.$uaday.' and (f.fstatus=u1.ustatus or f.fstatus is NULL) and DATE_FORMAT(f.fstart_time,"%T")<"'.$uhourminute.'" and DATE_FORMAT(f.fend_time,"%T")>"'.$uhourminute.'" 
            AND ((getdistance(f.flatitude,f.flongitude,'.$ualatitude.','.$ualongitude.')<f.fradius) or (f.flatitude is NULL and flongitude is NULL)or (f.fradius=-1))
       )';
       $result = $conn->query($sql);
       echo '<div class="my-3 p-3 bg-white rounded box-shadow">
       <h6 class="border-bottom border-gray pb-2 mb-0">Available Filters</h6>';
       
   
       if ($result->num_rows == 0) {
         echo '<div class="d-flex justify-content-between align-items-center w-100">
                <strong class="text-gray-dark">There are no filter available</strong>
                </div>';
         
         echo $conn->error;
           
       } 
       else {
        $fid_list='';
         while($row = $result->fetch_assoc()) {
             $fid_list=$fid_list.$row["fid"];//记录用户可用的filter的fid
             //判断是否repeat
             if($row['frepeat_type']==0){
            
             echo'<div class="media text-muted pt-3">
                        <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1676c27560a%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1676c27560a%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2212.296875%22%20y%3D%2216.9%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <strong class="text-gray-dark">'.htmlspecialchars($row["fname"],ENT_QUOTES, 'UTF-8').'</strong>
                                <form action="delete_filter.php" method="POST">
                                  <input class="form-control" type="text" name="fid" style="display: none" value='.htmlspecialchars($row["fid"],ENT_QUOTES, 'UTF-8').'>
                                  <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
                                </form>
                            </div>
                            <span class="d-block">location:('.htmlspecialchars($row['flatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['flongitude'],ENT_QUOTES, 'UTF-8').')</span>
                            <span class="d-block">radius: '.htmlspecialchars($row['fradius'],ENT_QUOTES, 'UTF-8').'</span>
                            <span class="d-block">time:'.htmlspecialchars($row['fstart_time'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['fend_time'],ENT_QUOTES, 'UTF-8').'</span>
                            <span class="d-block">required_status:'.htmlspecialchars($row['fstatus'],ENT_QUOTES, 'UTF-8').'</span>
                            <span class="d-block">filter_tag:'.htmlspecialchars($row['ftag'],ENT_QUOTES, 'UTF-8').'</span>
                        </div>
                    </div>';
          
             }else{
              echo'<div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1676c27560a%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1676c27560a%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2212.296875%22%20y%3D%2216.9%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <strong class="text-gray-dark">'.htmlspecialchars($row["fname"],ENT_QUOTES, 'UTF-8').'</strong>
                            <form action="delete_filter.php" method="POST">
                                  <input class="form-control" type="text" name="fid" style="display: none" value='.htmlspecialchars($row["fid"],ENT_QUOTES, 'UTF-8').'>
                                  <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
                            </form>
                        </div>
                        <span class="d-block">location:('.htmlspecialchars($row['flatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['flongitude'],ENT_QUOTES, 'UTF-8').')</span>
                        <span class="d-block">radius: '.htmlspecialchars($row['fradius'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">required_status:'.htmlspecialchars($row['fstatus'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">filter_tag:'.htmlspecialchars($row['ftag'],ENT_QUOTES, 'UTF-8').'</span>';
               if($row['frepeat_type']==1){
                    echo '<span class="d-block text-muted">repeat_type: Day</span>';
                  }
                  else if($row['frepeat_type']==2){
                    $week=array("","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
                    echo '<span class="d-block text-muted">repeat_type: Every '. htmlspecialchars($week[$row['frepeat_date']],ENT_QUOTES, 'UTF-8').' </span>';
                  }else if($row['frepeat_type']==3){
                    echo '<span class="d-block text-muted">repeat_type: NO.'.htmlspecialchars($row['frepeat_date'],ENT_QUOTES, 'UTF-8').' day in each month</span>';
                  }

                  echo '<span class="d-block text-muted">avaliable date:'.htmlspecialchars($row['fstart_date'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['fend_date'],ENT_QUOTES, 'UTF-8').'</span>';
                  echo '<span class="d-block text-muted">time:'.htmlspecialchars($row['stime'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['etime'],ENT_QUOTES, 'UTF-8').'</span>';
                  
              echo '</div>
                </div>';

             }
   
         }
         
         
       }
       echo '<small class="d-block text-right mt-3">
                <a href="create_filter">Add new filter</a>
            </small></div>';

       echo '<div class="my-3 p-3 bg-white rounded box-shadow">
       <h6 class="border-bottom border-gray pb-2 mb-0">Inactive Filters</h6>';
       //找到用户所有的filter
       $sql_inactive='SELECT fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view ,
       DATE_FORMAT(fstart_time,"%T") as stime, DATE_FORMAT(fend_time,"%T") as etime, fstart_date,fend_date, frepeat_date
        FROM filters where uid='.$_COOKIE['uid'];
       $result_inactive = $conn->query($sql_inactive);

     
       
       if ($result_inactive->num_rows == 0) {
         echo '<div class="d-flex justify-content-between align-items-center w-100">
                <strong class="text-gray-dark">There are no filter inactive</strong>
            </div>';
         
         echo $conn->error;
           
       } 
       else {
        $num_inactive=0;  
        while($row = $result_inactive->fetch_assoc()) {
             if(strpos($fid_list, $row['fid'])===false){//判断当前filter的fid是否在可用fid中
                $num_inactive=1;
                if($row['frepeat_type']==0){
                echo'
                <div class="media text-muted pt-3">
                <img data-src="holder.js/32x32?theme=thumb&amp;bg=e83e8c&amp;fg=e83e8c&amp;size=1" alt="32x32" class="mr-2 rounded" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1676c27560d%20text%20%7B%20fill%3A%23e83e8c%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1676c27560d%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23e83e8c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2212.296875%22%20y%3D%2216.9%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 32px; height: 32px;">
                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <strong class="text-gray-dark">'.htmlspecialchars($row["fname"],ENT_QUOTES, 'UTF-8').'</strong>
                            <form action="delete_filter.php" method="POST">
                                  <input class="form-control" type="text" name="fid" style="display: none" value='.htmlspecialchars($row["fid"],ENT_QUOTES, 'UTF-8').'>
                                  <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
                            </form>
                        </div>
                        <span class="d-block">location:('.htmlspecialchars($row['flatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['flongitude'],ENT_QUOTES, 'UTF-8').')</span>
                        <span class="d-block">radius: '.htmlspecialchars($row['fradius'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">time:'.htmlspecialchars($row['fstart_time'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['fend_time'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">required_status:'.htmlspecialchars($row['fstatus'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">filter_tag:'.htmlspecialchars($row['ftag'],ENT_QUOTES, 'UTF-8').'</span>
                    </div>
                </div>';
                }else{
                  echo'
                <div class="media text-muted pt-3">
                <img data-src="holder.js/32x32?theme=thumb&amp;bg=e83e8c&amp;fg=e83e8c&amp;size=1" alt="32x32" class="mr-2 rounded" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1676c27560d%20text%20%7B%20fill%3A%23e83e8c%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1676c27560d%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23e83e8c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2212.296875%22%20y%3D%2216.9%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 32px; height: 32px;">
                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <strong class="text-gray-dark">'.htmlspecialchars($row["fname"],ENT_QUOTES, 'UTF-8').'</strong>
                            <form action="delete_filter.php" method="POST">
                                  <input class="form-control" type="text" name="fid" style="display: none" value='.htmlspecialchars($row["fid"],ENT_QUOTES, 'UTF-8').'>
                                  <button class="btn btn-lg btn-outline-danger btn-sm" type="submit" >delete</button>
                            </form>
                        </div>
                        <span class="d-block">location:('.htmlspecialchars($row['flatitude'],ENT_QUOTES, 'UTF-8').','.htmlspecialchars($row['flongitude'],ENT_QUOTES, 'UTF-8').')</span>
                        <span class="d-block">radius: '.htmlspecialchars($row['fradius'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">required_status:'.htmlspecialchars($row['fstatus'],ENT_QUOTES, 'UTF-8').'</span>
                        <span class="d-block">filter_tag:'.htmlspecialchars($row['ftag'],ENT_QUOTES, 'UTF-8').'</span>';


                   if($row['frepeat_type']==1){
                        echo '<span class="d-block text-muted">repeat_type: Day</span>';
                      }
                      else if($row['frepeat_type']==2){
                        $week=array("","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
                        echo '<span class="d-block text-muted">repeat_type: Every '.htmlspecialchars($week[$row['frepeat_date']],ENT_QUOTES, 'UTF-8').' </span>';
                      }else if($row['frepeat_type']==3){
                        echo '<span class="d-block text-muted">repeat_type: NO.'.htmlspecialchars($row['frepeat_date'],ENT_QUOTES, 'UTF-8').' day in each month</span>';
                      }

                      echo '<span class="d-block text-muted">avaliable date:'.htmlspecialchars($row['fstart_date'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['fend_date'],ENT_QUOTES, 'UTF-8').'</span>';
                      echo '<span class="d-block text-muted">time:'.htmlspecialchars($row['stime'],ENT_QUOTES, 'UTF-8').'---'.htmlspecialchars($row['etime'],ENT_QUOTES, 'UTF-8').'</span>';
                      
                        
                  echo  '</div></div>';
                }

             }
             
          
           
   
        }
        if($num_inactive==0){
            echo '<div class="d-flex justify-content-between align-items-center w-100">
            <strong class="text-gray-dark">There are no filter inactive</strong>
        </div>';
        }
    }
        echo "</div>";

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
</script>
  </body>
  
</html>

