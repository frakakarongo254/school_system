<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
 
}

$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];

$get_emailID="";
if(isset($_GET['id'])){
  $get_emailID =$_GET['id'];
  #mark email as read
   $update_email_read_status=mysqli_query($conn,"update `email` SET status= '1' where `email_ID`='".$get_emailID."' and recipient='".$login_parent_email."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
} else{
  header('location: ../../index.php');
}


?>

<?php include("include/header.php")?>

<body class="hold-transition skin-cadetblue layout-top-nav">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
  //include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding-left: 50px;padding-right: 50px;background-color:   whitesmoke;">
    <!-- Content Header (Page header) -->
     <div class="container">
 
    <section class="content-header">
      <h1>
         <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>
       
        <li class="active">Email</li>
      </ol>
       
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
               $emil_sql = mysqli_query($conn,"select * from `email` where `email_ID` = '".$get_emailID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $email_row = mysqli_fetch_array($emil_sql,MYSQLI_ASSOC);
              $e_date=$email_row['date_sent'];
              $newDate = date("d-m-Y H:m:s", strtotime($e_date));
              ?>
               <h3 class="text-centre box-title">Subject: <b><?php echo $email_row['email_subject'];?> </b></h3><span class="pull-right"><?php echo $newDate;?>  </span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php echo "<b style='font-size:18px'>From:</b> <b>". $email_row['sender']."</b>";?>
               <div class="direct-text">
                   <?php
                   
                  
                    echo $email_row['message'];
                   ?>
                  </div>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
        <!-- delete email  Modal-->
    <div class="modal  fade" id="delete_email_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this Email</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteEmail(email_id){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete thie email from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger pull-left" name="deletebuttonFunc" id="'+ email_id +'" type="submit" data-dismiss="modal" onclick="deleteEmailFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
      </div>
    </div>
     </div>
    </section>
    <!-- /.content -->
  </div>
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
