<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
  $login_parent_ID=$_SESSION['login_user_ID'];
 $get_payment_ID="";
 if (isset($_POST['payment_id'])) {
   # code...
  $get_payment_ID=$_POST['payment_id'];
 }
 #get details form invoice
 $sql022 = mysqli_query($conn,"select * from `payment` where  payment_ID='$get_payment_ID' and `school_ID` = '".$school_ID."' ");
 $row022 = mysqli_fetch_array($sql022 ,MYSQLI_ASSOC);
 $invoiceID=$row022['invoice_ID'];
 $amount_paid=$row022['amount_paid'];
 $payment_date=$row022['payment_date'];
 $payment_remarks=$row022['remarks'];
 $payment_slip_no=$row022['slip_no'];
 $payment_method=$row022['payment_method'];

 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$invoiceID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
  $invoice_student_id=$row02['student_ID'];
  $invoice_balance=$row02['balance'];
   $invoice_ref=$row02['reff_no'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$admNo=$row03['registration_No'];

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
 <?php echo  '<section class="invoice">
     

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
           <table  class="table "" style="width: 100%">
        <thead>
            <tr class="" >
           
            <th colspan="2">  <span class="pull-right">Date: '. date('d-m-Y ').'</span> </th>
            
            </tr>
            </thead>
        <tbody>
         <tr>
          <td >
          <div class="row">
          <div class="col-md-12">
          <span class="pull-left">'.$logo .'</span><br>
          </div>
          </div>
            <div class=row>
            <div class="col-md-12">
                From
          <address>
            <strong>'. $school_row['school_Name'].'</strong><br>
            Po. Box '. $school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '. $school_row['email'].'<br>
            Website:'. $school_row['school_website'].'
          </address>
           </div>
            </div>
           
          </td>
          <td class="pull-right">
            <div class="col-md-offset-">
             
              
            <b style="font-size: 30px;">RECEIPT</b><br>
          <b>Reference:</b> '. $payment_slip_no.'<br>
          <b>Invoice #</b>'.$invoice_ref .'<br>
          <br>
          <b>Issue Date::</b>'. $invoice_date .'<br>
          <br>
          <b>To:</b> <br>
          '. $studentName.'<br>
          Adm #  '. $admNo.'
        </div>
        </td>
        </tr>
      </tbody>
      </table>
       <table class="table table-striped" style="width:100%">
            <thead>
            <tr>
           
            <th> Particular </th>
            <th>Amount</th>
            </tr>
            </thead>
            <tbody>
           

      
         <tr>
               
                <td>Payment for Invoice ' .$invoice_ref. '
             

              
               </td>
               
                <td>'.$amount_paid.'</td>  
                
             </tr>

       
        
            </tbody>
          </table>
          <p class="lead">Payment Methods: <br>'. $payment_method.'</p>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

      <!-- this row will not appear when printing -->
     
    </section>';?>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
