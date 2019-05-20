<?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
?>

<?php include("include/header.php")?>

<body class="hold-transition skin-cadetblue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
  include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    


    <!-- Main content -->
    <div></div>
    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
          <h3><a href="report.php"><span class="fa fa-bar-chart"></span>  <b class="color-primary" >  Reports</b></a></h3>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="payment_report.php"><i class="fa fa-arrow-circle-right"></i> Payment</a></li>
                <li><a href="invoice_report.php"><i class="fa fa-arrow-circle-right"></i> Invoices</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
         
          <?php
           $school_ID=$_SESSION['login_user_school_ID'];
            $school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");
              
              $school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
              $school_row['school_Name'];
               $logo;
                   if($school_row['logo_image'] !=''){
                    $logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
                  }else{
                      $logo = "<img class='profile-user-img img-responsive img-circle' src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
                    }
          ?>
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-12">
                  <br>
                  <br>
                  <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                </div>
             </div>
             
             
             
             <div class="row">
                <div class="col-md-12">
                  
                  
                   
                   <br>
                   hfj
                 <canvas id="bar-chart" width="800" height="450">gdggd kihiko</canvas>
                </div>
             </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         <!-- upload Log Modal-->
    
      
     <!-- edit stream Modal-->
   
   

      
       
         
     
    </section>
    <!-- /.content -->
    <div class="row">
       <!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
    </div>
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>


</div>
</section>
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

<!-- include script-->

<?php include("json_report.php");?>
<script >
  function deleteStreamFromSystem(stream_id){
  alert(stream_id);
  var details= '&stream_id='+ stream_id;
  $.ajax({
  type: "POST",
  url: "delete_stream.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="school_profile.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>
<script >
 // Bar chart
 window.onload = function () {
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});
}
</script>

<script>


window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2", // "light1", "light2", "dark1", "dark2"
  title: {
    text: "Payment, Invoice and Balance gragh"
  },
  axisY: {
    title:'<?php echo "Amount in ".$school_row["currency"] ; ?>',
    includeZero: false
  },
  data: [{
    type: "column",
    dataPoints: <?php echo json_encode($reportGraph, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<?php include("include/script.php")?>
<script src="../../bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../../bower_components/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../../bower_components/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="../../bower_components/Flot/jquery.flot.categories.js"></script>
</body>
</html>
