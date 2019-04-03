<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
 
}
$get_emailID="";
if(isset($_GET['id'])){
  $get_emailID =$_GET['id'];
} else{
  header('location: ../index.php');
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
        <div class="col-md-3">
          <a href="email_compose.php" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                  
                 <li><a href="email_inbox.php"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right">12</span></a></li>
                  <li><a href="email_compose.php"><i class="fa fa-pencil-square-o"></i> Compose</a></li>
                <li><a href="email_sent.php"><i class="fa fa-envelope-o"></i> Sent</a></li>
                
                <li><a href="email_setting.php"><i class="fa fa-gear"></i> Settings</a></li>
                
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
       
        </div>
        <!-- /.col -->
        <div class="col-md-9">
    
          <div class="col-md-12">
          
        <div class="box box-secondary box-solid">
            <div class="box-header with-border">
              
               <?php
               $emil_sql = mysqli_query($conn,"select * from `email` where `email_ID` = '".$get_emailID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $email_row = mysqli_fetch_array($emil_sql,MYSQLI_ASSOC);
              $e_date=$email_row['date_sent'];
              $newDate = date("d-m-Y H:m:s", strtotime($e_date));
              ?>
               <h3 class="text-centre box-title">Subject: <b><?php echo $email_row['email_subject'];?> </b></h3><span class="pull-right"><?php echo $newDate;?>  <a href="#" onclick="deleteEmail(id)" id="<?php echo $get_emailID; ?>" data-toggle="modal" data-target="#delete_email_Modal" style="color:red"><i class="fa fa-trash-o"></i> Delete</a></span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php echo "<b style='font-size:18px'>Sent To:</b> <b>". $email_row['recipient']."</b>";?>
               <div class="direct-chat-text">
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
            <h5 class="modal-title" id="exampleModalLabel">Delete this Class?</h5>
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
