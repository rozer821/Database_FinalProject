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
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <title>Create_filter</title>
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
    <div class="container" style="margin-top:10px;">
    <div class="card">
        <h5 class="card-header">Create your new filter</h5>
            <form class="card-body" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">

                
                <div class="form-inline form-group" id="tag" >
                  <div class="form-group mb-2 ">
                    <label for="date">Filter name:</label>
                    <input type="text" class="form-control" name="fname" placeholder="filtername" required="" oninvalid="setCustomValidity('please input your username')" oninput="setCustomValidity('')">
                  </div>
                  <div class="form-group mb-2 mx-sm-3">
                    <label for="date">Filter tag:</label>
                    <input type="text" class="form-control" name="ftag" placeholder="filtertag">
                  </div>
                  <div class="form-group mb-2 ">
                    <label for="date">Filter Status:</label>
                    <input type="text" class="form-control" name="fstatus" placeholder="filterstatus">
                  </div>
                </div>
                              
                <div class="form-inline form-group" id="tag" >
                  <div class="form-group mb-2">
                    <label for="date">Latitude:</label>
                    <input class="form-control" id='latitude' type="text" name="flatitude" placeholder="Latitude">
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">Longitude:</label>
                    <input class="form-control" id='longitude' type="text" name="flongitude" placeholder="Longitude">
                  </div>
                  <div class="form-group">
                    <label for="date">Radius</label>
                    <input type="text" name="fradius" class="form-control" placeholder="radius:m"  >
                  </div>  
                </div>
               
                <div class="form-group">
                  <label for="select">Limit_View</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flimit_view" value="0">
                    <label class="form-check-label" for="inlineRadio1">public</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flimit_view" value="1">
                    <label class="form-check-label" for="inlineRadio2">friends</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flimit_view"  value="2" >
                    <label class="form-check-label" for="inlineRadio3">private</label>
                  </div>
                </div>
                <div class="form-inline form-group">
                  <div class="form-group mb-2">
                    <label for="exampleFormControlSelect1" >schedule</label>
                    <select class="form-control" id="schedule_select" name="schedule_select">
                      <option id="no_schedule" name="no_schedule" value="no_schedule" >no_schedule</option>
                      <option id="schedule"  name="schedule"value="schedule">schedule</option>
                    </select>
                  </div>
                  <div class="form-group mx-sm-3 mb-2" style="display: none" id="repeat" >
                    <select class="form-control" id="repeat_type" name="frepeat_type">
                      <option id="day" value="1">day</option>
                      <option id="week" value="2">week</option>
                      <option id="month" value="3">month</option>
                    </select>
                  </div>

                  <div class="form-group mx-sm-3 mb-2" style="display: none" id="repeat_week">
                    <label for="date">Repeat_week</label>
                    <select class="form-control" name="frepeat_week">
                      <option value="1">Sunday</option>
                      <option value="2">Monday</option>
                      <option value="3">Tuesday</option>
                      <option value="4">Wednesday</option>
                      <option value="5">Thursday</option>
                      <option value="6">Friday</option>
                      <option value="7">Saturday</option>
                    </select>
                  </div>

                  <div class="form-group mx-sm-3 mb-2" style="display: none" id="repeat_month">
                    <label for="date">Repeat_date</label>
                    <input type="text"  class="form-control" placeholder="Date:1-30" name="frepeat_month" >
                  </div>
                  
                </div>

                <div class="form-inline form-group" id="no_repeat_time">
                <div class="form-group mb-2">
                    <label for="date">Start date</label>
                    <input class="form-control" type="date" name="fstartdate">
                  </div>
            
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">Start time</label>
                    <input class="form-control" type="time" name="fstarttime">
                  </div>
                  
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End date</label>
                    <input class="form-control" type="date" name="fenddate">
                  </div>

                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End time</label>
                    <input class="form-control" type="time" name="fendtime">
                  </div>
                </div>

                <div class="form-inline form-group" id="repeat_time" style="display: none">
                  <div class="form-group mb-2">
                    <label for="date">Start date</label>
                    <input class="form-control" type="date" name="startdate">
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End date</label>
                    <input class="form-control" type="date" name="enddate">
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">Start time</label>
                    <input class="form-control" type="time" name="starttime">
                  </div>
                  
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End time</label>
                    <input class="form-control" type="time" name="endtime">
                  </div>
                </div>

                

                
  
                <div class="form-inline">
                  <div class="form-group mb-2">
                    <button class="btn btn-primary" type="submit">Create</button>
                  </div>
                  
                  
                  
                </div>
                

            </form>
              
        </div>
        <div id ="map" style='margin-top:10px;height:400px'></div> 
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

      //接受表单信息
      if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_COOKIE['user'])){
          header("Location: http://localhost/test/signin.php");
        } 

        $error=0;
        $ftag='';
        $username=$_COOKIE['user'];
        $fname=$_POST['fname'];

        
        //设置状态  
        if($_POST['fstatus']==''){
          $fstatus="NULL";
        }else{
          $fstatus=$_POST['fstatus'];
        }
        

        //获取要插入的filter的fid
        $sql_max_fid="select max(fid) from filters;";
        $fid=$conn->query($sql_max_fid)->fetch_assoc()['max(fid)']+1;

        //设置radius
        if($_POST['fradius']==''){
          $fradius=-1;
        }else{
          $fradius=$_POST['fradius'];
        }
        //设置limit_view
        if(!isset($_POST['flimit_view'])){
          $flimit_view=0;
        }else{
          $flimit_view=$_POST['flimit_view'];
        }
        //获取是否repeat
        $schedule_select=$_POST['schedule_select'];
        
        #获取tag
        if($_POST['ftag']!='' and strpos($_POST['ftag'],'#') !==false){
          $ftag=$_POST['ftag'];
          
        }else if ($_POST['ftag']!=''){
          $error=2;
        }
      
        //设置经纬度
        if($_POST['flatitude']==''){
          $flatitude="NULL";
        }else{
          $flatitude=$_POST['flatitude'];
        }
        if($_POST['flongitude']==''){
          $flongitude="NULL";
        }else{
          $flongitude=$_POST['flongitude'];
        }
        if(($flatitude=="NULL" and $flongitude!="NULL") or ($flatitude!="NULL" and $flongitude=="NULL")){
          $error=3;
        }


        //判断是否有repeat
        if($schedule_select=="no_schedule"){
          $nrepeat_type=0;
          if($_POST['fstartdate']==""){
            if($_POST['fstarttime']==""){
              $fstart_time="1971-01-01 00:00:00";
            }else{
              $error=1;
            }
          }else{
            if($_POST['fstarttime']==""){
              $fstart_time=$_POST['fstartdate']." 00:00:00";
            }else{
              $fstart_time=$_POST['fstartdate']." ".$_POST['nstarttime'].":00";
            }
          }

          
          if($_POST['fenddate']==""){
            if($_POST['fendtime']==""){
              $fend_time="2100-01-01 23:59:59";
            }else{
              $error=1;
            }
          }else{
            if($_POST['fendtime']==""){
              $fend_time=$_POST['fenddate']." 23:59:59";
            }else{
              $fend_time=$_POST['fenddate']." ".$_POST['fendtime'].":00";
            }
          }

          if(strtotime($nstart_time)>strtotime($nend_time)){
            $error=1;
          }

          if($error==0){
            $sql_lock="LOCK TABLES filters write";
            $conn->query($sql_lock);

            if($fstatus== "NULL" and $ftag==""){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',NULL,NUll,0,'.$flimit_view.')';
            }else if($fstatus== "NULL"){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',NULL,"'.$ftag.'",0,'.$flimit_view.')';
            }
            else if($ftag==""){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',"'.$fstatus.'",NULL,0,'.$flimit_view.')';
            }else{
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',"'.$fstatus.'","'.$ftag.'",0,'.$flimit_view.')';

            }
            
            
            if ($conn->query($sql) === TRUE) {
              
            
              if($error==0){
                $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
                
                header("Location: http://localhost/test/filters.php");
  
              }
              else {
                echo $conn->error;
                $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
              }
            }else {
              
              echo $conn->error;
              $sql_unlock="UNLOCK TABLES";
              $conn->query($sql_unlock);
            }
            
    
          }
          else if ($error==1){
            echo "<p  style='color:red;'>Invalid Datetime</p>";
          }else if ($error==2){
            echo "<p  style='color:red;'>Tag must contain '#'</p>";
          } else if ($error==3){
            echo "<p  style='color:red;'>Invalid location</p>";
          } 
        }
        else{
          //设置repeat-type date
          $frepeat_date=0;
          $frepeat_type= $_POST['frepeat_type'];
          if($nrepeat_type==2){
            $frepeat_date=$_POST["frepeat_week"];
          }
          else if($nrepeat_type==3){
            $frepeat_date=$_POST["frepeat_month"];
          }


          //设置startdate
          if($_POST['startdate']==""){
            $fstart_date="1971-01-01 ";
          }else{
            $fstart_date=$_POST['startdate'];
          }
          //设置enddate
          if($_POST['enddate']==""){
            $fend_date="2100-01-01";
          }else{
            $fend_date=$_POST['enddate'];
          }

          if(strtotime($fstart_date)>strtotime($fend_date)){
            $error=1;
          }

          //设置starttime
          if($_POST['starttime']==""){
            $fstart_time="2018-01-01 00:00:00";
          }else{
            $fstart_time="2018-01-01 ".$_POST['starttime'];
          }
          //设置endtime
          if($_POST['endtime']==""){
            $fend_time="2018-01-01 23:59:59";
          }else{
            $fend_time="2018-01-01 ".$_POST['endtime'];
          }


          
        
          if($error==0){
            $sql_lock="LOCK TABLES filters write";
            $conn->query($sql_lock);
            if($fstatus== "NULL" and $ftag==""){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,fstart_date,fend_date,frepeat_date) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',NULL,NUll,'.$frepeat_type.','.$flimit_view.',"'.$fstart_date.'","'.$fend_date.'",'.$frepeat_date.')';
            }else if($fstatus== "NULL"){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,fstart_date,fend_date,frepeat_date) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',NULL,"'.$ftag.'",'.$frepeat_type.','.$flimit_view.',"'.$fstart_date.'","'.$fend_date.'",'.$frepeat_date.')';
            }
            else if($ftag==""){
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,fstart_date,fend_date,frepeat_date) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',"'.$fstatus.'",NULL,'.$frepeat_type.','.$flimit_view.',"'.$fstart_date.'","'.$fend_date.'",'.$frepeat_date.')';
            }else{
              $sql='INSERT INTO filters(fid,uid, fname,fradius,fstart_time, fend_time,  flatitude,flongitude,fstatus,ftag,frepeat_type,flimit_view,fstart_date,fend_date,frepeat_date) VALUES
            ('.$fid.',"'.$_COOKIE['uid'].'","'.$fname.'",'.$fradius.',"'.$fstart_time.'","'.$fend_time.'",'.$flatitude.','.$flongitude.',"'.$fstatus.'","'.$ftag.'",'.$frepeat_type.','.$flimit_view.',"'.$fstart_date.'","'.$fend_date.'",'.$frepeat_date.')';

            }
            
            if ($conn->query($sql) === TRUE) {
              
            
              if($error==0){
                
                $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
                header("Location: http://localhost/test/filters.php");
  
              }
              else {
                echo $conn->error;
                $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
              }
            }else {
              echo $fid;
              echo $conn->error;
              $sql_unlock="UNLOCK TABLES";
              $conn->query($sql_unlock);
            }
            
    
          }
          else if ($error==1){
            echo "<p  style='color:red;'>Invalid Datetime</p>";
          }else if ($error==2){
            echo "<p  style='color:red;'>Tag must contain '#'</p>";
          } else if ($error==3){
            echo "<p  style='color:red;'>Invalid location</p>";
          } 
        }
        
        
        

        

        
      }
    

      
      

      $conn->close();
      ob_end_flush();
    


  ?>
    


    
    
    <script>
      $(document).ready(function(){
        $("#schedule_select").change(function(){
            var selected=$(this).children('option:selected').val()
            if(selected=="schedule"){
              document.getElementById("repeat").style.display="";
              document.getElementById("no_repeat_time").style.display="none";
              document.getElementById("repeat_time").style.display="";
            }else if(selected=="no_schedule"){
              document.getElementById("repeat").style.display="none";
              document.getElementById("no_repeat_time").style.display="";
              document.getElementById("repeat_time").style.display="none";
            }
        });
      }); 
      $(document).ready(function(){
        $("#repeat_type").change(function(){
            var selected=$(this).children('option:selected').val()
            
            if(selected==1){
              document.getElementById("repeat_week").style.display="none";
              document.getElementById("repeat_month").style.display="none";
            }else if(selected==2){
              document.getElementById("repeat_week").style.display="";
              document.getElementById("repeat_month").style.display="none";
            }else if(selected==3){
              document.getElementById("repeat_week").style.display="none";
              document.getElementById("repeat_month").style.display="";
            }
        });
      }); 

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
    

   
   
    
   <script src="js/ini_map_filter.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key=********&callback=initMap"
    async defer></script>
  </body>
  
</html>

