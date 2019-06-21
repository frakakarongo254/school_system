<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $printFromDate="";
 $printFromTo="";
$report_class_id="";
$class_Name="";

 if (isset($_GET['from']) and isset($_GET['to']) ) {
   # code...
 $printFromDate=$_GET['from'];
$printFromTo=$_GET['to'];
$report_class_id=$_GET['class_id'];
 }else{
//echo "not set";

 }
 #get class name
 if ($_GET['class_id'] !=="All") {
  $report_class_id=$_GET['class_id'];
 # code...

    $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."' and class.class_ID='".$report_class_id."'");
               
  foreach ($query_c as $class_n) {
                  
  $class_Name= 'For Class   '  . $class_n['level_name'] .' '.$class_n['stream_name'] ;
  }
          
 }else{
  $class_Name= "For All Classes";
 }

 

  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class=" img-responsive " src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="150px" width="150px" class="img-circle"/>';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='150px' width='150px'>";
}

 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $school_row['school_Name']?> | Invoice</title>
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

  <link rel="stylesheet" href="../../css/body.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="">
<div class="wrapper">
  <!-- Main content -->
 <section class="invoice">
      <!-- title row -->
      <div class="row">
       
        
          
        <div class="col-md-12">
          <table class="">
            <tr>
              <td><?php echo $logo ?></td>
            </tr>
            <tr>
             
              <td><address id="address" >
            <strong> <?php echo  strtoupper($school_row['school_Name']) .'</strong><br>
            Po. Box ' .$school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '. $school_row['email'].'<br>
            Website:'. $school_row['school_website']?>
          </address></td>
            </tr>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
         <div class="col-xs-12 ">
           
           <b style="font-size:20px;font-weight:800;text-transform:uppercase;text-align:center">Attendance Report From <?php  echo date("d-m-Y", strtotime($printFromDate)).   '    To    '  .date("d-m-Y", strtotime($printFromTo)).' '.  $class_Name;  ?></b>
           <br>
           <br>
         </div>
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Sudent Name</th>
                  <th>Class</th>
                   <th>Date</th>
                  <th>Sign-in Time</th>
                  <th>Signed In By</th>
                  <th>Signed Out Time</th>
                   <th>Signed Out By</th>
                  <th>Attended time</th>
                
                </tr>
                </thead>
                <tbody>
               <?php
                if ($report_class_id !=="All") {
                   
                  $query22 = mysqli_query($conn,"select attendance.*,student.first_Name, student.last_Name, student.registration_No,student.photo, class.class_ID as Cn from attendance join student on student.student_ID=attendance.student_ID join class on attendance.class_ID=class.class_ID where date(date_entered) between date('$printFromDate') and date('$printFromTo')  and attendance.school_ID = '".$school_ID."' and attendance.class_ID='".$report_class_id."' ORDER BY date(date_entered)  DESC ");

                   
                   while ($row1=mysqli_fetch_array($query22)){
                    $student_regNoID= $row1['registration_No'];
                     $class_Id=$row1['Cn'];
                   $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."' and class.class_ID='".$class_Id."'");
                 
                    while ($row_value=mysqli_fetch_array($query_c)){
                   
                   $class_room=$row_value['level_name'].' '.$row_value['stream_name'];
                  
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" class="img-circle"/>';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px' class='img-circle'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    //$class_Id=$row1['Cn'];
                    $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row1['sign_in_time'];
                 $time_out=$row1['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff='';
                   if ($time_out !=='') {
                      $diff= $duration->format("%H:%I:%S");
                   }else{
                    $diff=' ';
                   }
              // encryption function 

              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td>".$img." ".$name."</td>
                  <td>".$class_room."</td>
                  <td>".date("d-m-Y", strtotime($row1['date_entered']))."</td>
                  <td>".$row1['sign_in_time']."</td>
                  <td>".$row1['signed_in_by']." </td>
                  <td>".$row1['sign_out_time']."</td>
                   <td>".$row1['signed_out_by']."</td>
                   <td>".$diff."</td>
                    </tr>";
                    }
                  }
                  }else{
                    
                $query22 = mysqli_query($conn,"select attendance.*,student.first_Name, student.last_Name, student.registration_No,student.photo, class.class_ID as Cn from attendance join student on student.student_ID=attendance.student_ID join class on attendance.class_ID=class.class_ID where date(date_entered) between date('$printFromDate') and date('$printFromTo')  and attendance.school_ID = '".$school_ID."' ORDER BY date(date_entered)  DESC ");
                  
                   while ($row1=mysqli_fetch_array($query22)){
                   $student_regNoID= $row1['registration_No'];
                     $class_Id=$row1['Cn'];
                   $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."' and class.class_ID='".$class_Id."'");
                 
                    while ($row_value=mysqli_fetch_array($query_c)){
                   
                   $class_room=$row_value['level_name'].' '.$row_value['stream_name'];
                
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" class="img-circle"/>';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px' class='img-circle'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    
                    $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row1['sign_in_time'];
                 $time_out=$row1['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff='';
                   if ($time_out !=='') {
                      $diff= $duration->format("%H:%I:%S");
                   }else{
                    $diff=' ';
                   }
              // encryption function 

              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td>".$img." ".$name."</td>
                  <td>".$class_room."</td>
                   <td>".date("d-m-Y", strtotime($row1['date_entered']))."</td>
                  <td>".$row1['sign_in_time']."</td>
                  <td>".$row1['signed_in_by']." </td>
                  <td>".$row1['sign_out_time']."</td>
                   <td>".$row1['signed_out_by']."</td>
                   <td>".$diff."</td>
                    </tr>";
                    }
                  }
                  }
                
                
               ?>
     
       </tbody>
               
             </table>
       
       
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

      
     
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
