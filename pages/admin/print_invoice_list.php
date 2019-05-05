<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $printFromDate="";
 $printFromTo="";
 if (isset($_POST['fromDate']) and isset($_POST['toDate']) ) {
   $printFromDate=$_POST['fromDate'];
   $printFromTo=$_POST['toDate'];
 }else{
  header('location: invoice.php');
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
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
 <section class="invoice">
      <!-- title row -->
      <div class="row">
       
        
          
        <div class="col-md-12">
          <table class="table">
            <tr>
              <td><?php echo $logo ?></td>
              <td> <address>
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
         <div class="col-xs-12">
           <p style="font-size: 20px;font-family: Arial, Helvetica, sans-serif; "> Invoice list From <b><?php echo $printFromDate?></b> To <b><?php echo $printFromTo ?></b></p>
         </div>
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
          <th>Reference</th>
          <th>Date</th>
          <th>Name</th>
          <th>Summary</th>
          <th>Amount</th>
         
          </tr>
            </thead>
            <tbody>
           <?php
        #get school Id from current session school id

        $query2 = mysqli_query($conn,"select * from invoice where  date(invoice_date) between date('$printFromDate') and date('$printFromTo')  and school_ID = '$school_ID' ORDER BY date('$printFromDate')  DESC ")or
                               die(mysqli_error());
                               $total_amount=0.00;
                               while ($row2=mysqli_fetch_array($query2)){
                                $total_amount= $total_amount + $row2['amount']  ;
                               $invoiveID= $row2['invoice_ID'];
                                $invoive_date= $row2['invoice_date'];
                                $studentid= $row2['student_ID'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                              $query3 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
                              
                               while ($row3=mysqli_fetch_array($query3)){
                                $name=$row3['first_Name']." ".$row3['last_Name'];
                                $reg=$row3['registration_No'];
                                echo' <tr>
                                   <td>  '.$row2['reff_no'].'</td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['summury']." </td>
                                        <td>".$row2['amount']."</td>
                                        ";
                                         
                                          
                                      
                                       echo' 
                                          
                                    </tr>';

                               
                              }
                                }

        echo '
            </tbody>
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
