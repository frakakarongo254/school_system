<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
 
}
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];

$get_notificationID="";
if(isset($_GET['id'])){
  $get_notificationID =$_GET['id'];
  #mark email as read
   $update_email_read_status=mysqli_query($conn,"update `notification` SET read_status= '1' where `notification_ID`='".$get_notificationID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
} else{
  header('location: ../../index.php');
}

?>

<?php include("include/header.php")?>

<body class="hold-transition skin-blue sidebar-mini">
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
 <section class="content-header">
      <h1>
        
       
      </h1>
    
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
    
          <div class="col-md-12">
          
        <div class="box box-secondary box-solid">
            <div class="box-header with-border">
              
               <?php
               $notf_sql = mysqli_query($conn,"select * from `notification` where `notification_ID` = '".$get_notificationID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $notf_row = mysqli_fetch_array($notf_sql,MYSQLI_ASSOC);
              $e_date=$notf_row['notification_date'];
              $newDate = date("d-m-Y H:m:s", strtotime($e_date));
              ?>
              <b>Notification</b>
               <span class="pull-right"><?php echo $newDate;?>  </span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               
               <div class="direct-chat-text">
                   <?php
                   
                  
                    echo $notf_row['notification_message'];
                   ?>
                  </div>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
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
  
<!-- ./wrapper -->


<!-- include script-->
<?php include("include/script.php")?>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>

<script >
  function deleteEmailFromSystem(email_ID){
   // alert(email_ID);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&email_id='+ email_ID;
  $.ajax({
  type: "POST",
  url: "delete_email.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="email_sent.php?delete=True" 
    }else{
      alert("OOp! Could not delete the.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
