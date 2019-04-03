
<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
   header('location: ../../index.php');
}

?>
<!DOCTYPE html>
<html>
<?php include("include/header.php")?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
<?php
  include("include/top_navbar.php");

?>
  
 
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        
      </section>

      <!-- Main content -->
      <section class="content">
    <div class="row">
        <div class="col-md-12">
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
                 // $sname=$_POST['SName'];
                  $email=$_POST['email'];
                  $phone=$_POST['phone'];
                  $gender=$_POST['gender'];
                  //$address1=$_POST['address1'];
                  $nationality=$_POST['nationality'];
                 
                 $result=mysqli_query($conn,"update `student` SET name= '".$fname."',email= '".$email."',phone='".$phone."',gender='".$gender."',nationality='".$nationality."' where `student_ID`='".$login_session_user_ID."'  ");
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

                  $ses_sql = mysqli_query($conn,"select password from `student` where `student_ID` = '".$_SESSION['login_user_ID']."' ");
                  $rows = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
                  #confirm current password
                  if( $currentPassword == $rows['password']){
                    $query=mysqli_query($conn,"update `student` SET password='".$NewPassword ."' where `student_ID` = '".$_SESSION['login_user_ID']."' ");
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
          
        </div>
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
         
           <ul class="nav nav-pills nav-stacked">
                <li><a href="profile.php"><i class="fa fa-arrow-circle-right"></i> Profile Details</a></li>
                <li><a href="edit_profile.php"><i class="fa fa-arrow-circle-right"></i> Edit Profile</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <?php
         
            # check image
            if(isset($_POST['uploadImageBtn'])){
            if(isset($_FILES['user_image']['name']) and !empty($_FILES['user_image']['name'])){
            $file=$_FILES['user_image']['name'];
            $path_parts = pathinfo($file);
          echo  $extension= $path_parts['extension'];

            if ($_FILES["user_image"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.')</script>";
            }
            elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
            && $extension != "gif" ) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
            //$uploadOk = 0;
            }else{
            $photo = addslashes(file_get_contents($_FILES['user_image']['tmp_name']));
            $updateImage_query=mysqli_query($conn,"update `student` SET photo= '".$photo."' where  `student_ID`='".$_SESSION['login_user_ID']."' ");
            if($updateImage_query){
            echo '<script> window.location="profile.php?update=True" </script>';
            }else{
            echo' <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">
            &times;
            </button>
            Sorry! Something went wrong.Please try again.
            </div>'.mysql_error(); 
            }
            }
            }else{
            echo '<script> alert("You must select an image") </script>';
            }
            }
          ?>
          <?php
          // $school_ID=$_SESSION['login_user_school_ID'];
            $logedUser_data_sql = mysqli_query($conn,"select * from `student` where `student_ID` = '".$_SESSION['login_user_ID']."'  ");
              
              $user_row = mysqli_fetch_array($logedUser_data_sql,MYSQLI_ASSOC);
            
          ?>
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-12  ">
                  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active col-md-5"><a href="#tab_1" data-toggle="tab"><b>GENORAL SETTING</b></a></li>
              <li  class="col-md-5"><a href="#tab_2" data-toggle="tab"><b>EDIT PASSWORD</b></a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                    <form  action="edit_profile.php" method="POST">
                 <div class="row">
                   <div class="col-md-6 form-group has-feedback">
                     <label> Name:</label>
                    <input type="text" name="FName" class="form-control" value="<?php echo $user_row['name'];?>" placeholder="First Name" required>
                    
                  </div>
                </div>
                  
                  <div class="row">
                  <div class="col-md-6 form-group has-feedback">
                     <label>Email:</label>
                    <input type="email" name="email" value="<?php echo $user_row['email'];?>" class="form-control" placeholder="Email" required>
                    
                  </div>
                </div>
                  <div class="row">
                  <div class="col-md-6 form-group has-feedback">
                     <label>Phone:</label>
                     <input type="text" name="phone" autocomplete="username"  value="<?php echo $user_row['phone'];?>" placeholder="Phone" class="form-control" data-inputmask='"mask": "(254) 999-999-999"' required  data-mask>
                    
                  </div>
                </div>
                  <div class="row">
                  <div class="col-md-6 form-group has-feedback">
                   <label>Gender</label>
                      <select class="form-control" name="gender">
                        <option value="<?php echo $user_row['gender'];?>"><?php echo $user_row['gender'];?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                        
                      </select>
                      <span class="fa fa fa-gender form-control-feedback"></span>
                    </div>
                 </div>
                 <div class="row">
                  <div class="col-md-6 form-group has-feedback">
                     <label>Nationality:</label>
                     
                     <select class="form-control select2" name="nationality" style="width: 100%;">
                      <option  value="<?php echo $user_row['nationality'];?>" ><?php echo $user_row['nationality'];?></option>
                  <?php  include("include/nationality.php");?>
                 </select>
                  </div>
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
            <div class="row">
              <div class="col-md-6 form-group has-feedback">
                 <label>Current Password:</label>
                 <input type="password" name="currentPassword" id="currentPassword" class="form-control"  autocomplete="new-password" placeholder="Current Password" required>
                
              </div>
            </div>
            <div  id="confirmPasswordMessage"></div>
            <div class="row">
              <div class="col-md-6 form-group has-feedback">
                 <label>New Password:</label>
                <input type="password" name="NewPassword" id="NewPassword"  class="form-control"  autocomplete="new-password" placeholder="New password" required>
                
              </div>
              
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
              
             </div>
             
            </div>
            <!-- /.box-body -->
          </div>
        </div>
          <!-- /.box -->
         <!-- upload Log Modal-->
    <div class="modal fade" id="modal-editSchoolLogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Logo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="profile.php" method="POST" enctype="multipart/form-data">
           <input type="file" name="user_image" class="form-control" value="upload">
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="uploadImageBtn" href="#">Upload</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
        <!-- edit school details-->
    <div class="modal fade" id="modal-editSchoolDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="school_profile.php" method="POST" enctype="multipart/form-data">
         <div class="form-group">
                <label>School Name:</label>
                <div class="input-group ">
                  <input type="text" class="form-control pull-right"  name="school_name" value="<?php echo $school_row['school_Name']?>">
                </div>
                <!-- /.input group -->
            </div>
             <div class="form-group">
                <label>Phone:</label>
                <div class="input-group ">
                  <input type="text" class="form-control pull-right" name="school_phone" value="<?php echo $school_row['phone']?>">
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Address:</label>
                <div class="input-group ">
                  <input type="text" class="form-control pull-right" name="school_address" value="<?php echo $school_row['address_1']?>">
                </div>
                <!-- /.input group -->
            </div>
             <div class="form-group">
                <label>Email:</label>
                <div class="input-group ">
                  <input type="text" class="form-control pull-right" name="school_email" value="<?php echo $school_row['email']?>">
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Web:</label>
                <div class="input-group ">
                  <input type="text" class="form-control pull-right" name="school_website" value="<?php echo $school_row['school_website']?>">
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>MOTO:</label>
                <div class="input-group ">
                  <textarea type="text" class="form-control " name="school_moto"><?php echo $school_row['school_moto']?></textarea>  
                </div>
                <!-- /.input group -->
            </div>
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="saveSchoolDetails" href="#">Save</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
      
        </div>
      </div>
      <!-- /.row -->

       
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <?php
 include('include/footer.php');
 ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<?php include("include/script.php")?>
</body>
</html>

