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
    <section class="content box box-primary" style="background-color: ;min-height: px;">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
           <h3><a href="report.php"><span class="fa fa-bar-chart"></span>  <b class="color-primary" >  Reports</b></a></h3>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="payment_report.php"><i class="fa fa-arrow-circle-right"></i> Payment</a></li>
                <li class=""><a href="invoice_report.php"><i class="fa fa-arrow-circle-right"></i> Invoices</a></li>
                <li class=""><a href="attendance_report.php"><i class="fa fa-arrow-circle-right"></i> Attendance</a></li>
                <li class="active"><a href="student_report.php"><i class="fa fa-arrow-circle-right"></i>Student Report</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
         
          <div class="row"> 
                 <div class="col-md-12 text-center" style="text-transform: uppercase;font-weight:800;font-size:24px;">
                   Student report
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
                 <label>Student</label>
                  <select class="form-control select2"  name="student_id" id="student_id" style="width: 100%;" required>
                    <option value="">--Select Student--</option>
                  
                   <?php
                 $query_c= mysqli_query($conn,"select student.* from student where student.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['student_ID'].'">'.$row_value['registration_No'].' '.$row_value['first_Name'].' '.$row_value['last_Name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
                </div>
               </div>
              <div class="col-md-6 pull-" style="text-align:">
                  <label>Include:</label>
                <div class="form-group">
                <label>
                  <input type="checkbox" class="flat-red" id="basicInfo" name="basicInfo" value="basicInfo" checked>
                  Basic Info
                </label>
                <label>
                  <input type="checkbox" class="flat-red" id="finance" name="finance" value="finance">
                  Finance
                </label>
                <label>
                  <input type="checkbox" class="flat-red" id="immunization" name="immunization" value="immunization">
                  Immunization
                </label>
                <label>
                  <input type="checkbox" class="flat-red" id="milestone" name="milestone" value="milestone">
                  Milestone
                </label>
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
 //include('include/settings-sidebar.php');
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
 //include('include/footer.php');
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
<script>
function myFunction() {
  var student_ID=document.getElementById('student_id').value;
  
  var basicInfo=document.getElementById('basicInfo');
 //alert(basicInfo);
 if ( basicInfo.checked == true) {
   basicInfo='yes';
 }else{
  basicInfo='no';
 }


 var immunization=document.getElementById('immunization');
 if ( immunization.checked == true) {
   immunization='yes';
 }else{
  immunization='no';
 }
   var milestone=document.getElementById('milestone');
   if ( milestone.checked == true) {
   milestone='yes';
 }else{
  milestone='no';
 }
    var finance=document.getElementById('finance');
  if ( finance.checked == true) {
   finance='yes';
 }else{
  finance='no';
 }

 if (student_ID !=='') {

var  win = window.open("print_student_report.php?student_id="+student_ID+"&basicInfo="+ basicInfo+"&milestone="+milestone+"&finance="+finance+"&immunization="+immunization , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=,left=,width=1000,height=5000");
   win.focus();
    //win.print();
    //win.close();
 }else{
  alert('You have not yet selected student');
 }
 
}
</script>
<?php include("include/script.php")?>

</body>
</html>
