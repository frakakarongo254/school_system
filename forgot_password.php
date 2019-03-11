<?php @ob_start(); include('config.php');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="dist/img/login-logo.png" class="img-circle" alt="User Image"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Forgoten Password</p>
     <?php
     if(isset($_POST['forgotPassword']) and !empty($_POST['email']) ){
       $email = mysqli_real_escape_string($conn,$_POST['email']);
       $query=mysqli_query($conn,"select * FROM `admin` where  `email`='".$email."'");
         if($query->num_rows > 0){
          while($row = $query->fetch_assoc()){
            $email=$row['email'];
             $user_ID= $row['admin_ID'];
            $school_ID= $row['school_ID'];
           echo $newPassword=substr(number_format(time() * rand(),0,'',''),0,10);
         
           $update_password_query=mysqli_query($conn,"update `admin` SET password= '".$newPassword."' where `admin_ID`='".$user_ID."' && `school_ID`='".$school_ID."' ");

           if( $update_password_query){
            $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$school_ID."' ");
                $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
            $from=$senderemail_row['sender_email'];
            $fromName=$senderemail_row['sender_name'];
            $footer=$senderemail_row['sender_signature'];
            $to=$email;
            $subject="Forgoten Password";
            $message='Your new Login details are ' ."\r\n". 'Email:'. $email . "\r\n".'Password:'. $newPassword;

            $headers =  'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

            //mail($to, $subject, $body, $headers);
            $datetime = date_create()->format('Y-m-d H:i:s');
            $send=mail($to,$subject,$message,$headers);
            if ($send) {
              echo' <div class="alert alert-primary alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Please check your email.We have sent you an email with a new password which you can change later.
          </div>';  
            }else{
               echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Oops! something went wrong .Please try again.
          </div>';
            }

           }
          }

         }else{
          echo' <div class="alert alert-warning alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          The email you entered does not exist.
          </div>';  
         }
       }
     ?>
    <form action="forgot_password.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Please Enter your Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
     
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="forgotPassword" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
    <!-- /.social-auth-links -->

   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
