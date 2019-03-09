<?php ob_start(); ?>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="">
  

    <title>Create your Note</title>


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
        <a class="navbar-brand" href="#">Oingo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
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
            
            <button class="btn btn-outline-success btn-sm btn-block" onclick=signout() >sign out</button>
          </div>
          
      </nav>
    </div>
    

    <div class="container" style="margin-top:50px;">
    <div class="card">
        <h5 class="card-header">Create your new note</h5>
            <form class="card-body" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">

                <div class="form-group">
                  <textarea class="form-control" name="ncontent" rows="6" required="" oninvalid="setCustomValidity('please input your username')" oninput="setCustomValidity('')"></textarea>
                </div>

                <div class="form-inline form-group" id="tag" >
                  <div class="form-group mb-2">
                    <label for="date">Tag:</label>
                    <input class="form-control" type="text" name="tag1" placeholder="#tag1">
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <input class="form-control" type="text" name="tag2" placeholder="#tag2">
                  </div>
                  
                </div>
                <div class="form-inline form-group">
                  <div class="form-group mb-2">
                      <label for="date">Radius:</label>
                      <input type="text" name="nradius" class="form-control" placeholder="radius:m"  >
                  </div>                
                  </div> 
               
                <div class="form-group">
                  <label for="select">Limit_View</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="limit_view" value="0">
                    <label class="form-check-label" for="inlineRadio1">public</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="limit_view" value="1">
                    <label class="form-check-label" for="inlineRadio2">friends</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="limit_view"  value="2" >
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
                    <select class="form-control" id="repeat_type" name="repeat_type">
                      <option id="day" value="1">day</option>
                      <option id="week" value="2">week</option>
                      <option id="month" value="3">month</option>
                    </select>
                  </div>

                  <div class="form-group mx-sm-3 mb-2" style="display: none" id="repeat_week">
                    <label for="date">Repeat_week</label>
                    <select class="form-control" name="nrepeat_week"> 
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
                    <input type="text"  class="form-control" placeholder="Date:1-30" name="nrepeat_month" >
                  </div>
                  
                </div>

                <div class="form-inline form-group" id="no_repeat_time">
                <div class="form-group mb-2">
                    <label for="date">Start date</label>
                    <input class="form-control" type="date" name="nstartdate">
                  </div>
            
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">Start time</label>
                    <input class="form-control" type="time" name="nstarttime">
                  </div>
                  
                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End date</label>
                    <input class="form-control" type="date" name="nenddate">
                  </div>

                  <div class="form-group mx-sm-3 mb-2">
                    <label for="date">End time</label>
                    <input class="form-control" type="time" name="nendtime">
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
                    <button class="btn btn-primary" type="submit">Post</button>
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <input class="form-check-input" type="checkbox" name="iscomment" value="1">
                    <label class="form-check-label" for="inlineCheckbox1">comment</label>
                  </div>
                  
                  
                </div>
                

            </form>
           
        </div>
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
      $tag1='';
      $tag2='';
      $username=$_COOKIE['user'];
      $ncontent=$_POST['ncontent'];

      $sql_curtime='Select * from latest_action where uid='.$_COOKIE['uid'];
      $curtime=$conn->query($sql_curtime)->fetch_assoc()['atime'];
      $curlatitude=$conn->query($sql_curtime)->fetch_assoc()['alatitude'];
      $curlongitude=$conn->query($sql_curtime)->fetch_assoc()['alongitude'];

      //获取要插入的note的nid
      $sql_max_nid="select max(nid) from note;";
      $nid=$conn->query($sql_max_nid)->fetch_assoc()['max(nid)']+1;
      //设置radius
      if($_POST['nradius']==''){
        $nradius=-1;
      }else{
        $nradius=$_POST['nradius'];
      }
      //设置limit_view
      if(!isset($_POST['limit_view'])){
        $limit_view=0;
      }else{
        $limit_view=$_POST['limit_view'];
      }
      //设置iscomment
      $schedule_select=$_POST['schedule_select'];
      if(!isset($_POST['iscomment'])){
        $iscomment=0;
      }else{
        $iscomment=$_POST['iscomment'];
      }
      #获取tag
      if($_POST['tag1']!='' and strpos($_POST['tag1'],'#') !==false){
        $tag1=$_POST['tag1'];
        
      }else if ($_POST['tag1']!=''){
        $error=2;
      }
      if($_POST['tag2']!='' and strpos($_POST['tag2'],'#') !==false){
        $tag1=$_POST['tag2'];
      }else if ($_POST['tag2']!=''){
        $error=2;
      }
      


      //判断是否有repeat
      if($schedule_select=="no_schedule"){
        $nrepeat_type=0;
        if($_POST['nstartdate']==""){
          if($_POST['nstarttime']==""){
            $nstart_time="1971-01-01 00:00:00";
          }else{
            $error=1;
          }
        }else{
          if($_POST['nstarttime']==""){
            $nstart_time=$_POST['nstartdate']." 00:00:00";
          }else{
            $nstart_time=$_POST['nstartdate']." ".$_POST['nstarttime'].":00";
          }
        }

        
        if($_POST['nenddate']==""){
          if($_POST['nendtime']==""){
            $nend_time="2100-01-01 23:59:59";
          }else{
            $error=1;
          }
        }else{
          if($_POST['nendtime']==""){
            $nend_time=$_POST['nenddate']." 23:59:59";
          }else{
            $nend_time=$_POST['nenddate']." ".$_POST['nendtime'].":00";
          }
        }

        if(strtotime($nstart_time)>strtotime($nend_time)){
          $error=1;
        }

        if($error==0){
          $sql_lock="LOCK TABLES note write";
          $conn->query($sql_lock);
          $sql = 'INSERT INTO note (nid,ncontent, uid, nlongitude, nlatitude, nradius, is_comment, ntime, nstart_time, nend_time, nrepeat_type, limit_view) VALUES
          ('.$nid.',"'.$ncontent.'",'.$_COOKIE['uid'].','.$curlongitude.', '.$curlatitude.', '.$nradius.','.$iscomment.',"'.$curtime.'","'.$nstart_time.'","'.$nend_time.'",0,'.$limit_view.')';
          
          if ($conn->query($sql) === TRUE) {
            if($tag1!=''){
              $sql_tag1='INSERT INTO n_tag VALUES('.$nid.',"'.$tag1.'")';
              if ($conn->query($sql_tag1) !== TRUE) {
                echo "Error: " . $sql_tag1 . "<br>" . $conn->error;
                $error=2;
                $sql_delete="DELETE FROM note WHERE nid='.$nid.'";
                $conn->query($sql_delete);

              }
            }
            if($tag2!=''){
              $sql_tag2='INSERT INTO n_tag VALUES('.$nid.',"'.$tag2.'")';
              if ($conn->query($sql_tag2) !== TRUE) {
                $error=2;
                echo "Error: " . $sql_tag2 . "<br>" . $conn->error;
                $sql_delete="DELETE FROM note WHERE nid='.$nid.'";
                $conn->query($sql_delete);
              }
            }
           
            if($error==0){
              $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
              header("Location: http://localhost/test/home.php");

            }
            else {
              echo $conn->error;
              $sql_unlock="UNLOCK TABLES";
              $conn->query($sql_unlock);
            }
          }else{
            echo $conn->error;
            $sql_unlock="UNLOCK TABLES";
            $conn->query($sql_unlock);
          } 
          
  
        }
        else if ($error==1){
          echo "<p  style='color:red;'>Invalid Datetime</p>";
        }
        else{
          echo "<p  style='color:red;'>Tag must contain '#'</p>";
        }
      }
      else{
        $nrepeat_date=0;
        $nrepeat_type= $_POST['repeat_type'];

        if($_POST['startdate']==""){
          $nstart_date="1971-01-01 ";
        }else{
          $nstart_date=$_POST['startdate'];
        }

        if($_POST['enddate']==""){
          $nend_date="2100-01-01 23:59:59";
        }else{
          $nend_date=$_POST['enddate']." 23:59:59";
        }

        if(strtotime($nstart_date)>strtotime($nend_date)){
          $error=1;
        }
        if($_POST['starttime']==""){
          $nstart_time="2018-01-01 00:00:00";
        }else{
          $nstart_time="2018-01-01 ".$_POST['starttime'];
        }
        if($_POST['endtime']==""){
          $nend_time="2018-01-01 23:59:59";
        }else{
          $nend_time="2018-01-01 ".$_POST['endtime'];
        }

        if($nrepeat_type==2){
          $nrepeat_date=$_POST["nrepeat_week"];
        }
        else if($nrepeat_type==3){
          $nrepeat_date=$_POST["nrepeat_month"];
        }
        

        if($error==0){
          $sql_lock="LOCK TABLES note write";
          $conn->query($sql_lock);
          $sql = 'INSERT INTO note (nid,ncontent, uid, nlongitude, nlatitude, nradius, is_comment, ntime, nstart_time, nend_time, nrepeat_type, limit_view,nstart_date,nend_date,nrepeat_date) VALUES
        ('.$nid.',"'.$ncontent.'",'.$_COOKIE['uid'].','.$curlongitude.', '.$curlatitude.', '.$nradius.','.$iscomment.',"'.$curtime.'","'.$nstart_time.'","'.$nend_time.'",'.$nrepeat_type.','.$limit_view.',"'.$nstart_date.'","'.$nend_date.'",'.$nrepeat_date.')';
         
          if ($conn->query($sql) === TRUE) {
            if($tag1!=''){
              $sql_tag1='INSERT INTO n_tag VALUES('.$nid.',"'.$tag1.'")';
              if ($conn->query($sql_tag1) !== TRUE) {
                echo "Error: " . $sql_tag1 . "<br>" . $conn->error;
                $error=2;
                $sql_delete="DELETE FROM note WHERE nid='.$nid.'";
                $conn->query($sql_delete);

              }
            }
            if($tag2!=''){
              $sql_tag2='INSERT INTO n_tag VALUES('.$nid.',"'.$tag2.'")';
              if ($conn->query($sql_tag2) !== TRUE) {
                $error=2;
                echo "Error: " . $sql_tag2 . "<br>" . $conn->error;
                $sql_delete="DELETE FROM note WHERE nid='.$nid.'";
                $conn->query($sql_delete);
              }
            }
           
            if($error==0){
              $sql_unlock="UNLOCK TABLES";
                $conn->query($sql_unlock);
              header("Location: http://localhost/test/home.php");

            }
            else {
              echo $conn->error;
              $sql_unlock="UNLOCK TABLES";
              $conn->query($sql_unlock);
            }
          }else{
            echo $conn->error;
            $sql_unlock="UNLOCK TABLES";
            $conn->query($sql_unlock);
          } 
          
  
        }
        else if ($error==1){
          echo "<p  style='color:red;'>Invalid Datetime</p>";
        }
        else{
          echo "<p  style='color:red;'>Tag must contain '#'</p>";
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
</script>
  </body>
  
</html>
