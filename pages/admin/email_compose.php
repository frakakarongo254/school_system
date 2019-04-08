<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
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
        #get sender and signature from email setting table
         $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
        $folder_path = 'document/';
        $document="";

        $from=$senderemail_row['sender_email'];
        $fromName=$senderemail_row['sender_name'];
        $footer=$senderemail_row['sender_signature'];
        $to=$_POST['email_to'];
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
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,sender,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$from','$message','$datetime') ");

           echo '<script> window.location="email_compose.php?sent=True" </script>';
        }else{
           echo "Sorry! Email was not sent";
        }
      }   
     ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="email_inbox.php" class="btn btn-primary btn-block margin-bottom">Back to Sent</a>

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
                  <span class="label label-primary pull-right">
                      <?php 
                      $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
                    $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
                   
                    $school_email=$senderemail_row['sender_email'];

               $query_inbox= mysqli_query($conn,"select * from `email` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient='$school_email' and status='0'");
                $query_inbox_row=mysqli_num_rows ( $query_inbox );
                echo $query_inbox_row ;
                ?> 
                  </span></a></li>
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
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="email_compose.php">
              <div class="form-group">
                <input class="form-control" placeholder="To:" name="email_to" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Subject:" name="email_subject">
              </div>
              <?php
              $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $signt_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
               $signt_row['sender_signature'];
              ?>
              <div class="form-group">
                    <textarea id="compose-textarea" class="textarea form-control"   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"name="email_message">
                      
                    </textarea>
                     
              </div>
              <div class="form-group">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Attachment
                  <input type="file" name="attachment" class="form-control">
                </div>
                <p class="help-block">Max. 32MB</p>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                
                <button type="submit" name="sendEmail" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
            </div>
          </form>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
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
  function deleteStudentFromSystem(RegNo){
    alert(RegNo);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&RegNo='+ RegNo;
  $.ajax({
  type: "POST",
  url: "delete_student.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="student.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
