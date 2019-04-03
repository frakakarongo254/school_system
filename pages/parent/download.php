<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
//include("include/header.php");
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav" onload="javascript:window.print()">
<div class="wrapper">

  <header class="main-header">
   
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
     

    
       <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php
               if (isset($_GET['from_date']) and isset($_GET['class'])and isset($_GET['status']) and isset($_GET['subject'])) {
                $from_Date=$_GET['from_date'];
                $to_Date=$_GET['to_date'];
                  $status_type=$_GET['status'];
                  $attendance_class_id=$_GET['class'];
                  $subjectID=$_GET['subject'];
                  $student_id=$_SESSION['login_user_ID'] ;
                  #subject
                  $subject_name;
                  if ($subjectID !='All') {
                    $sql01 = mysqli_query($conn,"select * from `subject` where `subject_ID` = '".$subjectID."' ");
                    $sub_row = mysqli_fetch_array( $sql01,MYSQLI_ASSOC);
                    $subject_name=$sub_row['name'];
                  }else{
                    $subject_name='All';
                  }
                   
              #class
                  $sql = mysqli_query($conn,"select * from `class` where `class_ID` = '".$attendance_class_id."' ");
              $clas_row = mysqli_fetch_array( $sql,MYSQLI_ASSOC);
              echo '<div style="font-size:20px;font-weight:20;text-align:center">Attendance list <br>Class:<b>'.$clas_row['name'].' </b><br>From: <b>'.$from_Date.' </b>  To:  <b>  '.$to_Date.' </b></br>Unit :<b>'.$subject_name.'</b></div><br><br>';
               ?>
                  
      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Unit Name</th>
                  <th>Date</th>
                   <th>Status</th>
                  
                </tr>
                </thead>
                <tbody>
               <?php
               
                $x=0;
                  if($subjectID !="All"){
                  if ($status_type !="All") {
                   
                   $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id' and subject_ID='$subjectID' and student_ID='$student_id'  and status='$status_type' and DATE(date_time) BETWEEN '". $from_Date ."' AND '".$to_Date."' ")or
                   die(mysqli_error());
                   if($attendance_query){
                    
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                    $query = mysqli_query($conn,"select * from subject where subject_ID='".$attendance_row['subject_ID']."'    ");
                    while ($student_row=mysqli_fetch_array( $query)){
                      $x++;
                      $date= $attendance_row['date_time'];
                      $attendanceDate = date("d-m-Y", strtotime($date));
                      echo"<tr>
                       <td>".$x."</td>
                       <td> ".$student_row['name']."</td>
                       <td> ".$attendanceDate."</td>
                        <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }
                 
                  }
                }
                  }else{
                     $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id' and subject_ID='$subjectID' and student_ID='$student_id' and DATE(date_time) BETWEEN '". $from_Date ."' AND '".$to_Date."'   ")or
                   die(mysqli_error());
                   if($attendance_query){
                    
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                    $query = mysqli_query($conn,"select * from subject where subject_ID='".$attendance_row['subject_ID']."'    ");
                    while ($student_row=mysqli_fetch_array( $query)){
                     $date= $attendance_row['date_time'];
                      $attendanceDate = date("d-m-Y", strtotime($date));
                      echo"<tr>
                       <td>".$x."</td>
                       <td> ".$student_row['name']."</td>
                       <td> ".$attendanceDate."</td>
                        <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }
                 
                  }
                }
                  }
                }else{
                  if ($status_type !="All") {
                   
                   $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id'  and status='$status_type' and student_ID='$student_id' and DATE(date_time) BETWEEN '". $from_Date ."' AND '".$to_Date."'  ")or
                   die(mysqli_error());
                   if($attendance_query){
                    
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                    $query = mysqli_query($conn,"select * from subject where subject_ID='".$attendance_row['subject_ID']."'   ");
                    while ($student_row=mysqli_fetch_array( $query)){
                      $x++;
                      $date= $attendance_row['date_time'];
                      $attendanceDate = date("d-m-Y", strtotime($date));
                      echo"<tr>
                       <td>".$x."</td>
                       <td> ".$student_row['name']."</td>
                       <td> ".$attendanceDate."</td>
                        <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }
                 
                  }
                }
                  }else{
                     $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id' and student_ID='$student_id'  and DATE(date_time) BETWEEN '". $from_Date ."' AND '".$to_Date."'  ")or
                   die(mysqli_error());
                   if($attendance_query){
                    
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                    $query = mysqli_query($conn,"select * from subject where subject_ID='".$attendance_row['subject_ID']."'   ");
                    while ($student_row=mysqli_fetch_array( $query)){
                      $x++;
                     $date= $attendance_row['date_time'];
                      $attendanceDate = date("d-m-Y", strtotime($date));
                      echo"<tr>
                       <td>".$x."</td>
                       <td> ".$student_row['name']."</td>
                       <td> ".$attendanceDate."</td>
                        <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }

                 
                  }
                }
                  }
                }
                
               ?>
     
       </tbody>
               
             </table>

    <?php }?>
      
       
         
     
    </section>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        
      </div>
      
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
