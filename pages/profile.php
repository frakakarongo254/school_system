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
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    


    <!-- Main content -->
    
    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
          <h3><span class="fa fa-gear"></span><b class="color-primary" >Setting</b></h3>
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
            $extension= $path_parts['extension'];

            if ($_FILES["user_image"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.')</script>";
            }
            elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
            && $extension != "gif" ) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
            //$uploadOk = 0;
            }else{
            $photo = addslashes(file_get_contents($_FILES['user_image']['tmp_name']));
            $updateImage_query=mysqli_query($conn,"update `admin` SET photo= '".$photo."' where  `admin_ID`='".$_SESSION['login_user_ID']."' and `school_ID`='".$_SESSION['login_user_school_ID']."' ");
            if($updateImage_query){
            echo '<script> window.location="profile.php?update=True" </script>';
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
            }else{
            echo '<script> alert("You must select an image") </script>';
            }
            }
          ?>
          <?php
          // $school_ID=$_SESSION['login_user_school_ID'];
            $logedUser_data_sql = mysqli_query($conn,"select * from `admin` where `admin_ID` = '".$_SESSION['login_user_ID']."' and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              
              $user_row = mysqli_fetch_array($logedUser_data_sql,MYSQLI_ASSOC);
            //  $user_row['school_Name'];
               $user_image;
                   if($user_row['photo'] !=''){
                    $user_image = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $user_row['photo'] ).'"  height="90" width="90px" />';
                  }else{
                     $user_image = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
                    }
          ?>
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-12  ">
                 <div class="" style="text-align: center;">
                
                  <center>
              <table>
               
                    <tr>
                      <td rowspan="2"> <?php echo $user_image;?>
             <h3 class="profile-username text-center"><a data-toggle="modal" data-target="#modal-editSchoolLogo"><span class="pull- badge bg-secondary"><i class="fa fa-image"></i> Change photo</span></a></h3></td>
                      <td><ul class="nav nav-pills nav-stacked">
                <li><a href="#"><i class="fa  fa-"></i><b><?php echo $user_row['first_name'] . " " .$user_row['second_name']?></b></a></li>
                <li><a href="#"><i class="fa fa-bookmark-o"></i> <?php echo $user_row['gender']?></a></li>
                <li><a href="#"><i class="fa fa-phone"></i> <?php echo $user_row['phone']?></a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $user_row['email']?></a></li>
                <li><a href="#"><i class="fa fa-flag"></i> <?php echo $user_row['nationality']?></a></li>
              </ul></td>
                     
                    </tr>
              </table>
            </center>
            </div>
              </div>
              
             </div>
             
                 <div class="row">
                   <div class="col-md-6">
                     <h3>ROLE:</h3>
                     <?php echo $user_row['role']?>
                   </div>
                   <div class="col-md-6">
                    <h3> Registration Date</h3>
                    <?php echo $user_row['registration_Date']?>
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
  
      
        </div>
      
      <!-- /.row -->

    
      
       
         
     
    </section>
    <!-- /.content -->
   
<div class="row">
  <?php
  include('include/settings-sidebar.php');
  ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
</div>

<!--include settings-sidebar-->
 
 
   <!--include footer-->
<?php
 include('include/footer.php');
 ?>
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->





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

<!-- include script-->
<?php include("include/script.php")?>
</body>
</html>
