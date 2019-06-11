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
    <section class="content box box-primary" style="background-color: ;min-height: 300px;">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
          <h3><a href="report.php"><span class="fa fa-bar-chart"></span>  <b class="color-primary" >  Reports</b></a></h3>
           <ul class="nav nav-pills nav-stacked">
                <li class=""><a href="payment_report.php"><i class="fa fa-arrow-circle-right"></i> Payment</a></li>
                <li><a href="invoice_report.php"><i class="fa fa-arrow-circle-right"></i> Invoices</a></li>
                  <li class="active"><a href="attendance_report.php"><i class="fa fa-arrow-circle-right"></i> Attendance</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <div class="row"> 
                 <div class="col-md-12 text-center" style="text-transform: uppercase;font-weight:800;font-size:24px;">
                  Attendance Report
                   <br>
                   
                 </div>
              </div>
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                 <form method="POST" action="">
               <div class="col-md-3">
                  <div class=" form-group">
                 <label>Class</label>
                  <select class="form-control select2" name="report_class_id" id="report_class_id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                    <option value="All">All</option>
                  <?php
                 $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['class_ID'].'">'.$row_value['level_name'].' '.$row_value['stream_name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
                </div>
               </div>
              <div class="col-md-3 pull-" style="text-align:">
                 <div class=" form-group">
               <label>From :</label>
                <input type="date" name="from_date" id="from_date" class="form-control" required>
              </div>
              </div>
              <div class="col-md-3" style="text-align:">
                 <div class=" form-group">
               <label>To :</label>
               <input type="date" name="to_date" id="to_date" class="form-control" required>
             </div>
              </div>
              <div class="col-md-3" style="text-align:">
                 <div class=" form-group">
                  <label><br></label><br>
                <button class="btn btn-primary" type="submit" id="button2" name="searchAttendance" href="" onclick="myFunction()" ><i class="fa "></i> GENERATE REPORT</button>
               
              </div>
              </div>
              
            </form>
             </div>
             
             
             
             <div class="row">
                <div class="col-md-12">
                  
                  
                   
                  
                </div>
             </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         <!-- upload Log Modal-->
   
         <!-- delete stream  Modal-->
   
<!-- /.row -->


      
       
         
     
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
<?php include("include/script.php")?>
<script>
function myFunction() {
  var from_date=document.getElementById('from_date').value;
  var to_date=document.getElementById('to_date').value;
  var class_id=document.getElementById('report_class_id').value;
  if (from_date =='' || to_date =='' || class_id =='' ) {
    alert("All fields are required");
  }else if(from_date =='' && to_date !=='' && class_id !==''  ){
    alert("Date From is required");
  }else if(to_date =='' && from_date !=='' && class_id !==''  ){
    alert("Date To is required");
  }else if (class_id =='' && from_date !=='' && to_date  !=='' ) {
    alert("Please Select class");
  }else if(from_date !=='' && to_date !=='' && class_id !==''){
    
    var WindowObject= window.open("print_attendance_list.php?from="+from_date+"&to="+to_date+"&class_id="+class_id , "", "toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=1000,height=500");
     WindowObject.focus();
    WindowObject.print();
    //WindowObject.close();
  }
  
 
}
</script>
</body>
</html>
