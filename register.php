<?php
 include('config.php');
?>
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
  <script >
    
// add event listener to table

     function  checkPass(e){
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            var det = document.getElementById("confirmPasswordMessage");
             
            if(pass1 !=pass2){

                det.innerHTML="<b style='color:red;'>Password Mismatch...</b>"    
            }
            else{

              det.innerHTML="<b style='color:green;'>passwords correct</b>"    
            }
        }

  </script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><a href="index.php"></a></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Create an Account</p>
     <?php
     if(isset($_GET['insert'])){
    echo' <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert"
    aria-hidden="true">
    &times;
    </button>You have registered  successfully.
    </div>';   
    } 
      if(isset($_POST['registerBtn'])){
      $schoolAddress=" ";
      $FName= $_POST['FName'];
      $SName= $_POST['SName'];
      $email= $_POST['email'];
      $phone= $_POST['phone'];
      $pass1= $_POST['pass1'];
      $pass2= $_POST['pass2'];
      #school details
      $schoolName= $_POST['schoolName'];
      $schoolPhone= $_POST['schoolPhone'];
      $schoolEmail= $_POST['schoolEmail'];
      if(isset($_POST['schoolAddress'])){
      $schoolAddress= $_POST['schoolAddress'];
       }else{
        $schoolAddress=" ";
       }
      $registrationDate = date_create()->format('Y-m-d');
       $authentication_key = substr(number_format(time() * rand(),0,'',''),0,10);
      $datetime = date_create()->format('Y-m-d H:i:s');
       $school_ID= md5($authentication_key);
      if($pass1 == $pass2){
         $query=mysqli_query($conn,"select * FROM `admin` where  `email`='".$email."'");
         if($query->num_rows == 0){
          $query=mysqli_query($conn,"insert into `admin` (school_ID, first_name, second_name,email,password,registration_Date,phone,role,authentication_key) values('$school_ID',
      '$FName','$SName','$email','$pass1','$registrationDate','$phone','Super Admin','$authentication_key')");mysqli_query($conn,"insert into `school` (school_ID, school_Name,registration_Date,phone,address_1,email) values('$school_ID',
      '$schoolName','$registrationDate','$schoolPhone','$schoolAddress','$schoolEmail')");
      if($query){
       
        echo "insered";

        $message = "Your Activation Code is ".$authentication_key."";
        $to=$email;
        $subject="Activation Code For Talkerscode.com";
        $from = 'info@myschool.com';
        $body='Your Activation Code is '.$authentication_key.' Please Click On This  <a href="verification.php?email='.$email.'&code='.$authentication_key.'"> link </a> to activate  your account.';
        $headers = "From:".$from;
        $send=0 ;//mail($to,$subject,$body,$headers);
        if($send ==0){
       // echo "An Activation Code Is Sent To You Check You Emails";
         echo '<script> window.location="register.php?insert=True" </script>';
      }
      }else{
        echo' <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">
            &times;
            </button>
            Please try again.
            </div>';
        
      }
         }else{
            echo' <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">
            &times;
            </button>
            That email is alredy registered.
            </div>';
         }
     
      

      

      }else{
        echo "Password Mismatch";
      }
      
    }
    
 
     ?>
     <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active col-md-5"><a href="#tab_1" data-toggle="tab"><b>Personal</b></a></li>
          <li  class="col-md-5"><a href="#tab_2" data-toggle="tab"><b>Institution</b></a></li>
          
        </ul>
        <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
              <form  action="register.php" method="POST">
                
                 <div class="form-group has-feedback">
                  <input type="text" name="FName" class="form-control" placeholder="First Name">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="text" name="SName" class="form-control" placeholder="Second Name" required>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <select class="form-control" name="gender" required="">
                    <option>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                 
                </div>
                <div class="form-group has-feedback">
                 
                 <select class="form-control select2" name="nationality" style="width: 100%;">
                  <?php  include("pages/include/nationality.php");?>
                 </select>
                </div>
                <div class="form-group has-feedback">
                  <input type="email" name="email" class="form-control" placeholder="Email">
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                   <input type="text" name="phone" autocomplete="username" placeholder="Phone" class="form-control" data-inputmask='"mask": "(254) 999-999-999"' data-mask>
                  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" name="pass1" id="pass1" class="form-control"  autocomplete="new-password" placeholder="Password">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div  id="confirmPasswordMessage"></div>
                <div class="form-group has-feedback">
                  <input type="password" name="pass2" id="pass2" onkeyup="checkPass(this.value)" class="form-control"  autocomplete="new-password" placeholder="Retype password">
                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                

          </div><!--end of tab_1 -->

          <!--start  tab_2 -->
          <div class="tab-pane " id="tab_2">
            <div class="form-group has-feedback">
                  <input type="text" name="schoolName" class="form-control" placeholder="School Name" required>
                  <span class="glyphicon glyphicon-education form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="email" name="schoolEmail" class="form-control" placeholder="School Email" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="number" name="schoolPhone" min="0" class="form-control" placeholder="School Phone No" required>
                  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>
                 <div class="form-group has-feedback">
                  <input type="text" name="schoolAddress" class="form-control"  placeholder="School Address" >
                  <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-8">
                    <div class="checkbox icheck">
                      <label>
                        <input type="checkbox" name="agreeTerms"> I agree to the <a href="#">terms</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-4">
                    <button type="submit" name="registerBtn" class="btn btn-primary btn-block btn-flat">Register</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
          </div>
        </div>
    </div>
    
    <a href="index.php" class="text-center">I already have an Account</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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
