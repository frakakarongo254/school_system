<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$school_ID =$_SESSION['login_user_school_ID'];
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];
include("include/header.php");
include("include/fusioncharts.php");

?>
<head>
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
  <!-- Morris chart -->
  <link rel="stylesheet" href="../../bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <script type="text/javascript">
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
  theme: "light1", // "light2", "dark1", "dark2"
  animationEnabled: true, // change to true   
  title:{
    text: "STUDENTS POPULATION"
  },
  data: [
  {
    // Change type to "bar", "area", "spline", "pie","line",etc.
    type: "column",
    dataPoints: [
    
    ]
  }
  ]
});
chart.render();

}
</script>
  </head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php include("include/top_navbar.php");?>
<!--include sidebar after header-->
<?php include("include/sidebar.php");?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <p><b><h2>Total Invoice Value</h2></b></p>
               <?php
                      
                                $amt_invoiced=0.00;
                               $query21 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                             die(mysqli_error());
                             while ($row11=mysqli_fetch_array($query21)){
                             $student_Id = $row11['student_ID'];
                             $total=0.00;
                             $query33 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$student_Id'")or
                             die(mysqli_error());
                             while ($row22=mysqli_fetch_array($query33)){
                              $std_Id = $row22['student_ID'];
                              // $name= $row2['first_Name']." ".$row2['last_Name'];
                              $query44 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' && student_ID='$std_Id'")or
                             die(mysqli_error());
                             $std_name;
                             
                             while ($row33=mysqli_fetch_array($query44)){
                              $amt_invoiced= $amt_invoiced + $row33['amount'];
                                 //$total=$total + $amt;
                             }
                           }
                         }
                       echo  "<h1>Ksh ".$amt_invoiced.".00 </h1>";
                               ?>

             
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
             
                  <p><b><h2>Total Amount Paid</h2></b></p>

              <p>
                
                 <?php
                       
                            $total_amount_paid=0.00;
                            $amount_query = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                             die(mysqli_error());
                             while ($row_amount=mysqli_fetch_array($amount_query)){
                             $studentId = $row_amount['student_ID'];
                             
                             $que= mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$studentId'")or
                             die(mysqli_error());
                             while ($row_std=mysqli_fetch_array($que)){
                              $stdId = $row_std['student_ID'];
                              // $name= $row2['first_Name']." ".$row2['last_Name'];
                              $que2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' && student_ID='$stdId'")or
                             die(mysqli_error());
                             $std_name;
                             
                             while ($row_p=mysqli_fetch_array($que2)){
                             
                              $total_amount_paid=  $total_amount_paid + $row_p['amount_paid'];
                             }
                           }
                         }
                        echo  "<h1>Ksh ".$total_amount_paid.".00 </h1>";
                               ?>
              </p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <p><h2><b>Balance</b></h2>
                <?php echo '<h1>Ksh '. $tol=$amt_invoiced - $total_amount_paid.'.00</h1>';?>
            
            </div>
            <div class="icon">
              <i class="ion "></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
      </div>
      <!-- /.row -->
   <div class="row">
     <div class="col-md-7">
        
  
 <!-- <div id="chart-2"> FusionCharts will render here--</div> -->
 <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
                <?php
          
      if(isset($_GET['sent'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Email was sent  successfully.
          </div>';   
        }
      if(isset($_POST['sendEmail'])){
        $school_ID = $_SESSION['login_user_school_ID'];
        $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
      
         $to=$senderemail_row['sender_email'];
        #get sender and signature from email setting table
        $from=$_SESSION['login_user_email'];
        $fromName=$_SESSION['login_user_fullName'];
        $sender_ID=$_SESSION['login_user_ID'];
        //$footer=$senderemail_row['sender_signature'];
       
        $subject=$_POST['email_subject'];
        $message=$_POST['email_message'];

        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

//mail($to, $subject, $body, $headers);
        $datetime = date_create()->format('Y-m-d H:i:s');
        $send=mail($to,$subject,$message,$headers);
        if($send){
          echo "Email Sent successfully";
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,recipient_ID,sender,sender_ID,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$school_ID','$from','$sender_ID','$message','$datetime') ");
           echo '<script> window.location="email_compose.php?sent=True" </script>';
        }else{
           echo "Sorry! Email was not sent";
        }
      }   
                ?>
              <form action="dashboard.php" method="post">
               <?php $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);?>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" value="<?php echo $senderemail_row['sender_email']?>" placeholder="Email to:" readonly>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="emailSubject" placeholder="Subject">
                </div>
                <div>
                  <textarea name="emailMessage" class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default" id="sendEmail" name="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </form>
          </div>
          <!-- /.box -->
     </div>
     <div class="col-md-5">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">Upcoming Events</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Location</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
          
            $event_query = mysqli_query($conn,"select * from event where school_ID = '$school_ID' ORDER BY event_startDate ASC LIMIT 5")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            
            echo '<tr>
                    <td><a href="event.php">'.$event_startDate.'</a></td>
                    <td>'.
             $event_row['event_title'].'</td>
                   
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">'.$event_row["event_location"].'</div>
                    </td>
                  </tr>';
            }
            ?>


                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
             
              <a href="event.php" class="btn btn-sm btn-default btn-flat pull-right">View All Events</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
     </div>
   </div>
    
      <div class="row">
         <div class="col-lg-12">

<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="../graphs/assets/script/canvasjs.min.js"></script>
    </div>
      </div>
       
         
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<?php
 include('include/footer.php');
 ?>
<!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
  <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
<!-- ./wrapper -->

<?php //include("include/script.php")?>
<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../../bower_components/raphael/raphael.min.js"></script>
<script src="../../bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
