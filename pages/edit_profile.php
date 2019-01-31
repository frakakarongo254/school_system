<?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
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
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script type="text/javascript">
           function  checkPass(e){
            var pass1 = document.getElementById("currentPassword").value;
            var pass2 = document.getElementById("NewPassword").value;
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php
  include("include/header.php");

?>
<!--include sidebar after header-->
<?php
  include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
         <div class="col-md-12 ">
          <?php
          $user_ID=$_SESSION['login_user_ID'];
            $ses_sql = mysqli_query($conn,"select * from `apparatus` where `apparatus_ID` = '".$user_ID."' ");
              $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
              $row['first_name'];
          ?>
          <!-- Profile Image -->
          <div class="box box-primary ">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../dist/img/avatar.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $_SESSION['login_user_fullName'];?></h3>

              <p class="text-muted text-center"><?php echo $row['role'];?> Super Admin</p>
               <?php
               if(isset($_GET['insert'])){
                  echo' <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert"
                  aria-hidden="true">
                  &times;
                  </button>
                  Success! You have Saved Changes successfully.
                  </div>';   
                  }
                  #after saving password Message
                  if(isset($_GET['updatePassword'])){
                  echo' <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert"
                  aria-hidden="true">
                  &times;
                  </button>
                  Success! You have updated your password successfully.
                  </div>';   
                  }

                 if(isset($_POST['saveChanges'])){
                  $address2;
                  $login_session_user_ID= $_SESSION['login_user_ID'];
                  $fname=$_POST['FName'];
                  $sname=$_POST['SName'];
                  $email=$_POST['email'];
                  $phone=$_POST['phone'];
                  $gender=$_POST['gender'];
                  $address1=$_POST['address1'];
                  $nationality=$_POST['nationality'];
                  if($_POST['address2'] !==''){
                    $address2= $_POST['address2'];
                  }else{
                   $address2=" ";
                  }
                 $result=mysqli_query($conn,"update `apparatus` SET first_name= '".$fname."',second_name= '".$sname."',email= '".$email."',phone='".$phone."',gender='".$gender."',address_1='".$address1."',address_2='".$address2."',nationality='".$nationality."' where `apparatus_ID`='".$login_session_user_ID."' ");
                 if($result){
                    echo '<script> window.location="edit_profile.php?insert=True" </script>';
                 }else{
                 echo' <div class="alert alert-warning alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert"
                  aria-hidden="true">
                  &times;
                  </button>
                  Sorry! Something went wrong.Please try again.
                  </div>'; 
                 }
                 }

                 #save password changes
                 if(isset($_POST['changePassword'])){
                  $currentPassword=$_POST['currentPassword'];
                  $NewPassword=$_POST['NewPassword'];

                  # check the current password
                  $userID=$_SESSION['login_user_ID'];
                  $ses_sql = mysqli_query($conn,"select password from `apparatus` where `apparatus_ID` = '".$userID."' ");
                  $rows = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
                  #confirm current password
                  if( $currentPassword == $rows['password']){
                    $query=mysqli_query($conn,"update `apparatus` SET password='".$currentPassword ."'");
                    if($query){
                      echo '<script> window.location="edit_profile.php?updatePassword=True" </script>';
                    }else{
                      echo' <div class="alert alert-warning alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert"
                      aria-hidden="true">
                      &times;
                      </button>
                      Sorry! Something went wrong.Please try again.
                      </div>'; 
                    }

                  }else{
                    echo' <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert"
                      aria-hidden="true">
                      &times;
                      </button>
                      Sorry! Your Current password is invalid.
                      </div>'; 
                  }
                     

                 }
               ?>
             
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active col-md-5"><a href="#tab_1" data-toggle="tab"><b>GENORAL SETTING</b></a></li>
              <li  class="col-md-5"><a href="#tab_2" data-toggle="tab"><b>EDIT PASSWORD</b></a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <form  action="edit_profile.php" method="POST">
             
               <div class="form-group has-feedback">
                 <label>First Name:</label>
                <input type="text" name="FName" class="form-control" value="<?php echo $row['first_name'];?>" placeholder="First Name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                 <label>Second Name:</label>
                <input type="text" name="SName" class="form-control" value="<?php echo $row['second_name'];?>" placeholder="Second Name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                 <label>Email:</label>
                <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                 <label>Phone:</label>
                 <input type="text" name="phone" autocomplete="username"  value="<?php echo $row['phone'];?>" placeholder="Phone" class="form-control" data-inputmask='"mask": "(254) 999-999-999"' required  data-mask>
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
               <label>Gender</label>
                  <select class="form-control" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                    
                  </select>
                  <span class="fa fa fa-gender form-control-feedback"></span>
                </div>
              <div class="form-group has-feedback">
                 <label>Address 1:</label>
                 <input type="text" name="address1"   value="<?php echo $row['address_1'];?>" placeholder="address 1" class="form-control" required>
                <span class="fa fa fa-envelope-o form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                 <label>Address 2:</label>
                 <input type="text" name="address2"   value="<?php echo $row['address_2'];?>" placeholder="address 2" class="form-control" >
                <span class="fa fa fa-envelope-o form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                 <label>Nationality:</label>
                 <input type="text" name="nationality"   value="<?php echo $row['nationality'];?>" placeholder="Nationality" class="form-control" required>
                <span class="fa fa fa-flag form-control-feedback"></span>
              </div>
             
              <div class="row">
                
                <!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" name="saveChanges" class="btn btn-primary btn-block btn-flat">Save Changes</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <form method="POST" action="edit_profile.php">
                    <div class="form-group has-feedback">
                      <label>Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" class="form-control"  autocomplete="new-password" placeholder="Current Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div  id="confirmPasswordMessage"></div>
              <div class="form-group has-feedback">
                <label>New Password:</label>
                <input type="password" name="NewPassword" id="NewPassword"  class="form-control"  autocomplete="new-password" placeholder="New password" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              </div>
               <div class="row">
                
                <!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" name="changePassword" class="btn btn-primary btn-block btn-flat"> Save Password</button>
                </div>
                <!-- /.col -->
              </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              
            </div>
            <!-- /.tab-content -->
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      
        </div>
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

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="../bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
