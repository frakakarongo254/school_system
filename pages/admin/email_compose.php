<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}

$school_ID = $_SESSION['login_user_school_ID'];
#get sender and signature from email setting table
$emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
$senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);


$fromEmail=$senderemail_row['sender_email'];
$fromSenderName=$senderemail_row['sender_name'];
$footer=$senderemail_row['sender_signature'];
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
        if(isset($_GET['failed'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         Your contact request submission failed, please try again.
          </div>';   
        }
      if(isset($_POST['sendEmailD'])){
       
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


 $postData = $uploadedFile = $statusMsg = '';
$msgClass = 'errordiv';
if(isset($_POST['sendEmail'])){
    // Get the submitted form data
    $postData = $_POST;
     $to=$_POST['email_to'];
      $subject=$_POST['email_subject'];
      $message=$_POST['email_message'];
        $message1=$_POST['email_message'];
      $datetime = date_create()->format('Y-m-d H:i:s');
    // Check whether submitted data is not empty
    if(!empty($to)  && !empty($subject) && !empty($message)){
#insert details to db
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,sender,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$fromEmail',' $message1','$datetime') ");

        if ($sudent_insert_query) {
          # code...
        
        // Validate email
        if(filter_var($to, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter your valid email.';
        }else{
            $uploadStatus = 1;
            
            // Upload attachment file
            if(!empty($_FILES["attachment"]["name"])){
                
                // File path config
                $targetDir = "document/";
                $fileName = basename($_FILES["attachment"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                
                // Allow certain file formats
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
                if(in_array($fileType, $allowTypes)){
                    // Upload file to the server
                    if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){
                        $uploadedFile = $targetFilePath;
                    }else{
                        $uploadStatus = 0;
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }else{
                    $uploadStatus = 0;
                    $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                }
            }
            
            if($uploadStatus == 1){
                
                // Recipient
                 $toEmail = $_POST['email_to'];;

                // Sender
                $from = $fromEmail;
                $fromName = $fromSenderName;
                
                // Subject
                $emailSubject = $_POST['email_subject'];
                
                // Message 
                $htmlContent = '<html><body>'.$message.'</body></html>';
                
                // Header for sender info
                $headers = "From: $fromName"." <".$from.">";

                if(!empty($uploadedFile) && file_exists($uploadedFile)){
                    
                    // Boundary 
                    $semi_rand = md5(time()); 
                    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                    
                    // Headers for attachment 
                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                    
                    // Multipart boundary 
                    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                    "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
                    
                    // Preparing attachment
                    if(is_file($uploadedFile)){
                        $message .= "--{$mime_boundary}\n";
                        $fp =    @fopen($uploadedFile,"rb");
                        $data =  @fread($fp,filesize($uploadedFile));
                        @fclose($fp);
                        $data = chunk_split(base64_encode($data));
                        $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile)."\"\n" . 
                        "Content-Description: ".basename($uploadedFile)."\n" .
                        "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile)."\"; size=".filesize($uploadedFile).";\n" . 
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                    }
                    
                    $message .= "--{$mime_boundary}--";
                    $returnpath = "-f" . $to;
                   
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);
                    
                    // Delete attachment file from the server
                    @unlink($uploadedFile);
                }else{
                     // Set content-type header for sending HTML email
                    $headers .= "\r\n". "MIME-Version: 1.0";
                    $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
                    
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $htmlContent, $headers); 
                }
                
                // If mail sent
                if($mail and  $sudent_insert_query){
                    //$statusMsg = 'Your contact request has been submitted successfully !';
                    //$msgClass = 'succdiv';
                     echo '<script> window.location="email_compose.php?sent=True" </script>';
                    $postData = '';
                }else{
                   // $statusMsg = 'Your contact request submission failed, please try again.'
                     echo '<script> window.location="email_compose.php?failed=True" </script>';
                }
            }
        }
   }else{
    echo 'Sorry error occured';
   } 
 }else{
        $statusMsg = 'Please fill all the fields.';
    }
}
     ?>
      <?php if(!empty($statusMsg)){ ?>
            
            <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
        <p class="statusMsg <?php echo !empty($msgClass)?$msgClass:''; ?>"><?php echo $statusMsg; ?></p>
          </div>
          <?php } ?>
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
                      <!-- Display submission status -->
         
             <form method="POST" action="email_compose.php" enctype="multipart/form-data">
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
                    <textarea id="compose-textarea" class="textarea form-control"   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"name="email_message"></textarea>
                     
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
                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
               
              </div>
               <button type="submit" name="sendEmail" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
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
