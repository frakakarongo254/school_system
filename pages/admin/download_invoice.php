<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
 $get_invoice_ID="";
 if (isset($_GET['invoice'])) {
   # code...
  $get_invoice_ID=$_GET['invoice'];
 }
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$get_invoice_ID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
  $invoice_student_id=$row02['student_ID'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
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
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

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
       <?php

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
                <form method="POST" action="view_invoice.php?invoice=<?php echo $get_invoice_ID?>">
                <table class="table table-hover" id="">
               
                    <tr>
                      <td rowspan="" class="pull-left"> <?php echo $logo;?>
                       </td>
                       <td >
                           To: <?php echo $studentName ?>
                       </td>
                   </tr>
                   <tr>
                      <td>
                       <div class="row">
                         <div class="col-md-12">
                           <a ><i class="fa  fa-institution"></i><b><?php echo $school_row['school_Name']?></b></a>
                         </div>
                       </div>
                        <div class="row">
                         <div class="col-md-12">
                           <a><i class="fa fa-bookmark-o"></i> Po. Box <?php echo $school_row['address_1']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                           <a ><i class="fa fa-phone"></i> <?php echo $school_row['phone']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                          <a><i class="fa fa-envelope-o"></i> <?php echo $school_row['email']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                          <a> <i class="fa fa-globe"></i> <?php echo $school_row['school_website']?></a>
                         </div>
                       </div>

                     
                     </td>
                     <td>
                
                <div class=" col-md- input-group input-group-">
                  <label>Invoice Date     </label> 
                  <?php     echo  $invoice_date?>
                 
                </div>
                <br>
                <div class=" col-md- input-group input-group-">
                  <label>Due Date: </label>
                  <?php     echo $invoice_due_date ?>
                 
                </div>
                <br>
                <div class="form-group">
                  <label>Summury</label><br>
               
                  <?php echo $invoice_summury ?>
               
              </div>
                     </td>
                    </tr>
              </table>
          <table class="table table-bordered table-hover" id="tab_logic">
        <thead>
          
          <tr>
            <th class=" text-"> # </th>
            <th class="text-"> Item </th>
            <th class="text-"> Qty </th>
            <th class="text-"> Price </th>
            <th class="text-"> Total </th>
          </tr>
        </thead>
        <tbody>
           <?php
                            #get school Id from current session school id
                            
                             $query2 = mysqli_query($conn,"select * from invoice_item where invoice_id='$get_invoice_ID' and school_ID = '$school_ID' ")or
                             die(mysqli_error());
                             $x=0;
                             while ($row2=mysqli_fetch_array($query2)){
                              $x++;
                             $invoice_item_ID= $row2['invoice_item_ID'];
                             $vote_head_ID= $row2['vote_head_ID'];
                             $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='$vote_head_ID' and school_ID = '$school_ID' ")or
                             die(mysqli_error());
                             while ($row3=mysqli_fetch_array($query3)){
                             
                              echo' <tr>
                                       <td>'.$x.'</td>
                                      <td>'.$row3['name'].'</td>
                                      <td>'.$row2['quantity'].' </td>
                                      <td>'.$row2['price'].'</td>
                                      <td>'.$row2['amount'].'</td>  
                                      
                                     
                                   </tr>';

                             }
                            }
                              
                            ?>
                         
        
          <tr >
            <td class="" colspan="4"><div class="pull-right">Grand Total</div></td>
            <td class="" colspan="5"><div class="pull-"><?php echo $invoice_amount?></div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
 
        </div>
        <div class="col-md-2"></div>
      </div>
    
       
         

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
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
