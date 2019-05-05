<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $printFromDate="";
 $printFromTo="";
 $printFromDate=$_POST['printFromDate'];
  $printFromTo=$_POST['printToDate'];
 if (isset($_POST['from']) and isset($_POST['to']) ) {
    $printFromDate=$_POST['printFromDate'];
  $printFromTo=$_POST['printToDate'];
 }
 

  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="150px" width="150px" />';
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload='window.print();window.open(url, "_blank");'>
<div class="wrapper">
  <!-- Main content -->

<?php echo' <section class="invoice">
      <!-- title row -->
      <div class="row">
       
        
          
        <div class="col-md-12">
          <table class="table">
            <tr>
              <td>'. $logo .'</td>
              <td> <address>
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
      <div class="row">
         <div class="col-xs-12">
           <b style="">Payment List From  ' . $printFromDate. '  To ' . $printFromTo .'</b>
         </div>
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            
            <th>Invoice Ref</th>
            <th>Receipt No </th>
            <th>Date</th>
            <th>Name</th>
            <th>Remark</th>
            <th>Amount</th>
            
            
          </tr>
          </thead>
          <tbody>';?>
             <?php
             
             $query2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' ORDER BY payment_date DESC")or
             die(mysqli_error());
             $total_amount=0.00;
             while ($row2=mysqli_fetch_array($query2)){
              $total_amount= $total_amount + $row2['amount_paid']  ;
             $invoiceID= $row2['invoice_ID'];
             $paymentID= $row2['payment_ID'];
              $invoive_date= $row2['payment_date'];
              $studentid= $row2['student_ID'];
              $slipNo= $row2['slip_no'];
             $newDate = date("d-m-Y", strtotime($invoive_date));
              $total_amount=0.00;
              $query3 = mysqli_query($conn,"select * from invoice where invoice_ID='$invoiceID' and school_ID = '$school_ID' ");
            
             while ($row3=mysqli_fetch_array($query3)){
              $invoice_ref=$row3['reff_no'];
            $query4 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
            
             while ($row4=mysqli_fetch_array($query4)){
              $name=$row4['first_Name']." ".$row4['last_Name'];
              $reg=$row4['registration_No'];
              echo' <tr>
                 <td> '.$invoice_ref.'</td>';

                echo " <td> ".$slipNo."</td>
                        <td>".$newDate."</td>
                       <td>".$reg ." ".$name."</td>
                      <td>".$row2['remarks']." </td>
                      <td>".$row2['amount_paid']."</td>
                      ";
                       
                        
                    
                     echo' 
                      
                  </tr>';

             
            }
              }
            }
            
         
         echo ' </tbody>
          
        </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

      
     
    </section>';?>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
