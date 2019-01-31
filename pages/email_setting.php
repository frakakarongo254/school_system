<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
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
        <div class="col-md-6">

          <?php
          if(isset($_GET['update'])){
            echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Signature saved successfully.
          </div>';   
          }
           if(isset($_POST['saveSignature'])){
           $signature =$_POST['signature'];
           $school_ID = $_SESSION['login_user_school_ID'];
           #check if the is signature already in db
            $Signature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
            if(mysqli_num_rows (  $Signature_sql ) ==0){
            $signature_insert_query=mysqli_query($conn,"insert into `email_setting` (school_ID,sender_signature 
          ) values('$school_ID','$signature') ");
            if($signature_insert_query){
             echo"<script>window.location='email_setting.php?update=True'</script>";
           }else{
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! Something went wrong .Please try again.
          </div>';   
           }
        }else{
          #update
          $result_query=mysqli_query($conn,"update `email_setting` SET sender_signature= '".$signature."' where `school_ID`='".$_SESSION['login_user_school_ID']."' ");
          if($result_query){
           echo"<script>window.location='email_setting.php?update=True'</script>";
          }else{
           echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! Something went wrong .Please try again.
          </div>'; 
          }

        }
           
           }
          ?>
          <a href="email_compose.php" class="btn btn-primary btn-block margin-bottom">Signature</a>

          <div class="box box-solid">
            <div class="box-body padding-5">
             <?php 
             $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $signt_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
              echo $signt_row['sender_signature'];
              ?>
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_signature_Modal" id="" onclick="showLinkparentID(this.id)" > Update Signature</button>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
       
        </div>
        <!-- /.col -->
        <div class="col-md-6">
         <?php
          if(isset($_GET['updateSender'])){
            echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sender saved successfully.
          </div>';   
          }
           if(isset($_POST['saveEmailSender'])){
           $sender_name =$_POST['sender_name'];
           $sender_email =$_POST['sender_email'];
           $school_ID = $_SESSION['login_user_school_ID'];
           #check if the is signature already in db
            $emailsender_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
            if(mysqli_num_rows (  $emailsender_sql ) ==0){
            $sender_insert_query=mysqli_query($conn,"insert into `email_setting` (school_ID,sender_name,sender_email 
          ) values('$school_ID','$sender_name','$sender_email') ");
            if( $sender_insert_query){
             echo"<script>window.location='email_setting.php?updateSender=True'</script>";
           }else{
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! Something went wrong .Please try again.insert
          </div>';   
           }
        }else{
          #update
          $result_query=mysqli_query($conn,"update `email_setting` SET sender_name= '".$sender_name."' ,sender_email= '".$sender_email."' where `school_ID`='".$_SESSION['login_user_school_ID']."' ");
          if($result_query){
           echo"<script>window.location='email_setting.php?updateSender=True'</script>";
          }else{
           echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! Something went wrong .Please try again.update
          </div>'; 
          }

        }
           
           }
          ?>
          
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
             
               <h3 class="text-centre box-title"><b>Email Sender</b></h3>
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
               $send_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $send_row = mysqli_fetch_array($send_sql,MYSQLI_ASSOC);
             echo ' <b>Name:'.$send_row['sender_name'].'</b><br>';
             echo ' <b>Email:'.$send_row['sender_email'].'</b><br>';
              ?>
              
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_sender_Modal" id="" onclick="showLinkparentID(this.id)" > Update Sender</button>
            <!-- /.box-body -->
          </div>
       
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!--Update signature-->
       <div class="modal  fade" id="update_signature_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Signature</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="email_setting.php">
             
                    <textarea class="form-control" id="editor1" name="signature" rows="10" cols="80">
                <?php 
             $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $signt_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
              echo $signt_row['sender_signature'];
              ?>
                    </textarea>
              
              <div class="modal-footer">
            
            <button class="btn btn-primary pull-left" name="saveSignature" type="submit">Save Signature</button>
            <button class="btn btn-secondary pull-right" type="button" data-dismiss="modal">Cancel</button>
          </div>
            </form>  
        
        </div>
         
      </div>
    </div>
     </div>
       <!--Update Sender-->
       <div class="modal  fade" id="update_sender_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Email Sender</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body padding-5" style="text-align: center;">
            <form method="POST" action="email_setting.php">
             

             <div class=" col-md-10 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="sender_name" class="form-control" placeholder="Name" required>
              </div>
              <br>
              <div class=" col-md-10 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
                <input type="email" name="sender_email" class="form-control" placeholder="Email" required>
              </div>
              
              <div class="modal-footer">
            
            <button class="btn btn-primary pull-left" name="saveEmailSender" type="submit">Save Sender</button>
            <button class="btn btn-secondary pull-right" type="button" data-dismiss="modal">Cancel</button>
          </div>
            </form>  
        
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

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
