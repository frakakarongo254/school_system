<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_email="";
  $get_code="";
 if (isset($_GET['email'])) {
   # code...
  $get_email=$_GET['email'];
  $get_code=$_GET['code'];
 }
 #get details form invoice



 
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
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

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
          <div class="page-">
            <i class="pull-left"><?php echo $logo ?></i>
            <small class="pull-right">Date: <?php echo date('d-m-Y ')?></small>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?php echo $school_row['school_Name']?></strong><br>
            Po. Box <?php echo $school_row['address_1']?><br>
            Phone: <?php echo $school_row['phone']?><br>
            Email: <?php echo $school_row['email']?><br>
            Website:<?php echo $school_row['school_website']?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $studentRegNo ." ". $studentName?> </strong><br>
            
          Parent<br>
          <strong><?php echo $parentName;?></strong><br>
            Phone: <?php echo $parentPhone ?><br>
            Email: <?php echo $parentEmail ?><br>
           
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #<?php echo $invoice_reff ?></b><br>
          <br>
          <b>Invoice Date:</b><?php echo $invoice_date ?><br>
          
          <b>Account:</b> <?php echo $invoice_due_date ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
           
            <th> Product </th>
            <th > Qty </th>
            <th> Price </th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
           <?php
        #get school Id from current session school id

        $query2 = mysqli_query($conn,"select * from invoice_item where invoice_id='$get_invoice_ID' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row2=mysqli_fetch_array($query2)){
        $invoice_item_ID= $row2['invoice_item_ID'];
        $vote_head_ID= $row2['vote_head_ID'];
        $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='$vote_head_ID' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row3=mysqli_fetch_array($query3)){
        echo' <tr>
               
                <td>'.$row3['name'].'
             

              
               </td>
                <td>'.$row2['quantity'].'</td>
                <td>'.$row2['price'].'</td>
                <td>'.$row2['amount'].'</td>  
                
             </tr>';

        }

        }
        ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due <?php echo $invoice_due_date ?></p>

          <div class="table-responsive">
            <table class="table">
              
          
            <th class="" style="width:50%">Grand Total</th>
            <td class=""><?php echo $invoice_amount?></td>
          </tr>
            </table>
          </div>
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
