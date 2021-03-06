<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_student_ID="";
 if (isset($_POST['student_id'])) {
   # code...
  $get_student_ID=$_POST['student_id'];
 }elseif (isset($_GET['student_id'])) {
   # code...
  $get_student_ID=$_GET['student_id'];
 }

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID='".$get_student_ID."' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$studentRegNo=$row03['registration_No'];
$class_ID=$row03['class_ID'];


   $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."' and class.class_ID='".$class_ID."'");
               
  foreach ($query_c as $class_n) {
                  
  $class_name=  $class_n['level_name'] .' '.$class_n['stream_name'] ;
  }
 



  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class=" img-responsive " src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="150" width="150px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='150px' width='150px'>";
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
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

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
  <?php echo '<section class="invoice">
   <div class="row">
       
        
          
        <div class="col-md-12">
        
       
          <table class=" " border="0px" style="border:0px;" >
         <tr>
         <td><span class="pull-left">'. $logo .'</span></td>
         </tr>
            <tr>
            
              <td><br><address id="address" style="">
            <strong>'. strtoupper($school_row['school_Name']) .'</strong><br>
            Po. Box ' .$school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '. $school_row['email'].'<br>
            Website:'. $school_row['school_website'].'
          </address></td>
            </tr>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="">
           
          <strong> STUDENT STATEMENT</strong>
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
               <td>'. $studentName .'</td>
               <td>Print Date:</td>
               <td><small class=""> '. date("d-m-Y ").'</small></td>
             </tr>
              <tr>
               <td>STUDENT NO :</td>
               <td>'. $studentRegNo.'</td>
               <td>CLASS :</td>
               <td>'. $class_name.'</td>
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
                               ';
                              $result = mysqli_query($conn,"select * from statement where school_ID = '$school_ID' && student_ID='$get_student_ID'")or
                               die(mysqli_error());
                        $total_Debit=0.00;
                        $total_Credit=0.00;
                        $total_balance=0.00;
                        while($rows = $result->fetch_assoc()) {
                        $total_Debit= $total_Debit + $rows["Debit"];
                        $total_Credit=$total_Credit + $rows["Credit"];
                        $total_balance= $total_Debit - $total_Credit;
                        if ($total_balance < 0) {
                          # code...
                           $total_balance=  $total_Credit - $total_Debit;
                        }
                        $date_created= $rows['date_created'];
                        $newDate = date("d-m-Y", strtotime($date_created));
                       
                        echo '<tr>
                       
                        <td> '.$newDate.'</td>
                        <td> '.$rows["description"].'</td>
                        <td> '.$rows["ref_no"].'</td>
                        <td align="right"> '.$school_row['currency'] .  ' ' .formatCurrency($rows["Debit"]).'</td>
                        <td align="aright"> '.$school_row['currency'] .   ' ' .formatCurrency($rows["Credit"]).'</td>
                        </tr>';
                        }    

                        echo'
                        <tr>
                        <hr>
                        <td colspan="3"><b><b></td>
                         <td align="right"><b>'.$school_row['currency'] .   '<b> ' .formatCurrency($total_Debit).'</b></td>
                         <td align="right">'.$school_row['currency'] .   '<b> ' .formatCurrency($total_Credit).'</b></td>
                         
                        </tr>
                       
                        

                              
                           
                             </tbody>
                            
                          </table>
                        <div class="row clearfix" style="margin-top:20px">
                        <div class="pull-right col-md-3">
                          <table class="table">
                              <tr>
                <th style="width:50%">Balance</th>
                <td > <b>'.$school_row['currency'] .   '<b> ' .formatCurrency($total_balance).'</b></td>
              </tr>
             
             
                          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    

      <!-- this row will not appear when printing -->
     
    </section>';?>;
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
