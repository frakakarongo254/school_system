<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
include("include/header.php");
include("include/fusioncharts.php");
$school_ID =$_SESSION['login_user_school_ID'];
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
  <?php include("include/header.php")?>
<body class="hold-transition skin-cadetblue sidebar-mini" style="background-color: ">
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
        
      </ol>
      <hr style="background-color: #000;font-style: 12px;">
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row" style="text-transform: uppercase;font-weight: bold;">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box ">
            <div class="inner bg-aqua text-center">
               <?php 
               $query_admins= mysqli_query($conn,"select * from `admin` where `school_ID` ='".$_SESSION['login_user_school_ID']."' ");
                 $query_admins_row=mysqli_num_rows (  $query_admins );
                  echo "<h3>".$query_admins_row.  "</h3>";
                ?> 
              <p>ADMIN</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box ">
            <div class="inner bg-green text-center">
             
               <?php 
               $query_staffs= mysqli_query($conn,"select * from `staff` where `school_ID` ='".$_SESSION['login_user_school_ID']."' ");
                $query_staffs_row=mysqli_num_rows ( $query_staffs );
                echo "<h3>".$query_staffs_row.  "</h3>";
                ?> 
              <p>Staffs</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="staff.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box ">
            <div class="inner bg-yellow text-center">
              
              <?php 
               $child_query= mysqli_query($conn,"select * from `student` where `school_ID` ='".$_SESSION['login_user_school_ID']."' ");
               $child_query_row=mysqli_num_rows ( $child_query );
               echo "<h3>".$child_query_row.  "</h3>";
                ?> 
              <p>Children</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="student.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box  bk-primary">
            <div class="inner bg-aqua text-center">
              
               <?php 
               $query_parent= mysqli_query($conn,"select * from `parents` where `school_ID` ='".$_SESSION['login_user_school_ID']."' ");
               $query_parent_row=mysqli_num_rows ( $query_parent );
               echo "<h3>".$query_parent_row.  "</h3>";
                ?> 
              <p>Parents</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="parent.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box  bk-primary">
            <div class="inner bg-aqua text-center">
              
               <?php 
                $amt_invoiced=0.00;
               $query44 = mysqli_query($conn,"select * from invoice where school_ID = '".$school_ID."' ")or
          die(mysqli_error());
                              
           while ($row33=mysqli_fetch_array($query44)){
           $amt_invoiced= $amt_invoiced + $row33['amount'];
                                     //$total=$total + $amt;
           }   
          
           echo"<h2> ".$school_row['currency'] . formatCurrency($amt_invoiced) ."</h2>";  
                ?> 
              <p style="text-transform: uppercase;font-weight: bold;">Invoice Value</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box  bk-primary">
            <div class="inner bg-green text-center">
              
               <?php 
               $balance=0.00;
$total_amount_paid=0.00;

$que2 = mysqli_query($conn,"select * from payment where school_ID = '".$school_ID."' ")or
          die(mysqli_error());
                         
           while ($row_p=mysqli_fetch_array($que2)){
                             
        $total_amount_paid=  $total_amount_paid + $row_p['amount_paid'];
         }

          echo"<h2> ".$school_row['currency'] . formatCurrency($total_amount_paid) ."</h2>";  
              
                ?> 
              <p>Amount Paid</p>
            </div>
            <div class="icon">
              <i class="ion ion-"></i>
            </div>
            <a href="report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
   <div class="row">
     <div class="col-md-7">
   
    <?php
          if(isset($_GET['send'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Email sent  successfully.
          </div>';   
        }
          if(isset($_POST['sendEmail']) and !empty($_POST['emailMessage'])){
        
         $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
          $senderemail=$senderemail_row['sender_signature'];
        
        $from=$senderemail_row['sender_email'];
        $fromName=$senderemail_row['sender_name'];
        $footer=$senderemail_row['sender_signature'];
        $to=$_POST['emailto'];
        $subject=$_POST['emailSubject'];
        $msg=$_POST['emailMessage'];
         $message=$msg ." <br>".  $senderemail;
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

//mail($to, $subject, $body, $headers);
        $datetime = date_create()->format('Y-m-d H:i:s');
        $send=mail($to,$subject,$message,$headers);
        if($send){
          echo "Email Sent successfully";
        
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,sender,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$from','$message','$datetime') ");

          echo '<script> window.location="dashboard.php?send=True" </script>';
        }else{
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! please try again.
          </div>';  
        }

        
      } 
                ?>
  <div class="box box-info collapsed-box">
            <div class="box-header with-border">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                <form action="dashboard.php" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="emailSubject" placeholder="Subject">
                </div>
                <div>
                  <textarea name="emailMessage" class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              
            
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default" id="sendEmail" name="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </form>
            </div>
            <!-- /.box-body -->
          </div>
 <!-- <div id="chart-2"> FusionCharts will render here--</div> -->
 
          <!-- /.box -->
     </div>
     <div class="col-md-5">
          <!-- upcoming Events -->
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Upcoming Events</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
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
            <!-- /.box-body -->
          </div>

         
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

<!-- ChartJS -->
<script src="../../bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>


<!-- FLOT CHARTS -->
<script src="../../bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../../bower_components/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../../bower_components/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="../../bower_components/Flot/jquery.flot.categories.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript">
  $(function () {

   var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Chrome'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'IE'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'FireFox'
      },
      {
        value    : 600,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Safari'
      },
      {
        value    : 300,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Opera'
      },
      {
        value    : 100,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Navigator'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);



    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      { label: 'Series2', data: 30, color: '#3c8dbc' },
      { label: 'Series3', data: 20, color: '#0073b7' },
      { label: 'Series4', data: 50, color: '#00c0ef' }
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */

  })

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
</sc

  });
</script>
</body>
</html>
