<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_student_ID="";
 if (isset($_GET['student_id'])) {
   # code...
  $get_student_ID=$_GET['student_id'];
 }

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID='$get_student_ID' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$studentRegNo=$row03['registration_No'];
$class_ID=$row03['class_ID'];

 $sql003 = mysqli_query($conn,"select * from `class` where  class_ID='$class_ID' and `school_ID` = '".$school_ID."' ");
  $row003 = mysqli_fetch_array($sql003 ,MYSQLI_ASSOC);
  $class_name=$row003['name'];



  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
}

 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student | Statement</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
   <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="text-center">
            <i class="pull-"><?php echo $logo ?></i>
            <strong><?php echo $school_row['school_Name']?></strong><br>
           STUDENT STATEMENT
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <hr>
      <div class="row invoice-info">
        <div class="col-xs-12">
           <table style="width: 100%">
             <tr>
               <td>NAME :</td>
               <td><?php echo $studentName;?></td>
               <td>Print Date:</td>
               <td><small class=""> <?php echo date('d-m-Y ')?></small></td>
             </tr>
              <tr>
               <td>STUDENT NO :</td>
               <td><?php echo $studentRegNo?></td>
               <td>CLASS :</td>
               <td><?php echo $class_name?></td>
             </tr>
           </table>
           
        </div>
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
            <table id="table11" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Date</th>
                              <th>Description</th>
                              <th>Reference</th>
                              <th>Debit</th>
                              <th>Credit</th>
                              
                              
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                              $result = mysqli_query($conn,"select * from statement where school_ID = '$school_ID' && student_ID='$get_student_ID'")or
                               die(mysqli_error());
                        $total_Debit=0.00;
                        $total_Credit=0.00;
                        $total_balance=0.00;
                        while($rows = $result->fetch_assoc()) {
                        $total_Debit= $total_Debit + $rows["Debit"];
                        $total_Credit=$total_Credit + $rows["Credit"];
                        $total_balance=$total_Credit + $total_Debit;
                        $date_created= $rows['date_created'];
                        $newDate = date("d-m-Y", strtotime($date_created));
                       
                        echo '<tr>
                       
                        <td> '.$newDate.'</td>
                        <td> '.$rows["description"].'</td>
                        <td> '.$rows["ref_no"].'</td>
                        <td> '.$rows["Debit"].'</td>
                        <td> '.$rows["Credit"].'</td>
                        </tr>';
                        }    

                        echo'
                        <tr>
                        <hr>
                        <td colspan="3"><b><b></td>
                         <td><b>'.$total_Debit.'.00</b></td>
                         <td><b>'.$total_Credit.'.00</b></td>
                         
                        </tr>
                       
                        '

                              ?>
                           
                             </tbody>
                            
                          </table>
                        <div class="row clearfix" style="margin-top:20px">
                        <div class="pull-right col-md-3">
                          <table class="table">
                              <tr>
                <th style="width:50%">Balance</th>
                <td><?php echo'<b>'. $total_balance.'.00 </b>';?></td>
              </tr>
             
             
                          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    

      <!-- this row will not appear when printing -->
     
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
