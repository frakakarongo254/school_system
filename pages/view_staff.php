<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$get_staffID='';
if(isset($_GET['id'])){
  $get_staffID =$_GET['id'];
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
  
    <!-- Main content -->
    <section class="content " style="background-color: #fff">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
           <div class="col-md-2 box-primary ">
          <h3><span class="glyphicon glyphicon-list-alt"></span><b class="color-primary" >Saff Profile</b></h3>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="view_staff.php"><i class="fa fa-arrow-circle-right"></i> Staff Details</a></li>
                <li><a href="#"><i class="fa fa-arrow-circle-right"></i> Staff Classes</a></li>
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
            $updateImage_query=mysqli_query($conn,"update `apparatus` SET photo= '".$photo."' where  `apparatus_ID`='".$_SESSION['login_user_ID']."' and `school_ID`='".$_SESSION['login_user_school_ID']."' ");
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
            $staff_data_sql = mysqli_query($conn,"select * from `staff` where `staff_ID` = '".$get_staffID."' and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");

            $staff_row = mysqli_fetch_array($staff_data_sql,MYSQLI_ASSOC);
            //  $user_row['school_Name'];
            $staff_image;
            if($staff_row['photo'] !=''){
            $staff_image = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $staff_row['photo'] ).'"  height="90" width="90px" />';
            }else{
            $staff_image = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
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
                      <td rowspan="2"> <?php echo $staff_image;?>
             <h3 class="profile-username text-center"><a data-toggle="modal" data-target="#modal-editSchoolLogo"><span class="pull- badge bg-secondary"><i class="fa fa-image"></i> Change photo</span></a></h3></td>
                      <td><ul class="nav nav-pills nav-stacked">
                <li><a href="#"><i class="fa  fa-"></i><b><?php echo $staff_row['full_Name'] ;?></b></a></li>
                <li><a href="#"><i class="fa fa-bookmark-o"></i> <?php echo $staff_row['gender']?></a></li>
                <li><a href="#"><i class="fa fa-phone"></i> <?php echo $staff_row['phone']?></a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $staff_row['email']?></a></li>
                <li><a href="#"><i class="fa fa-flag"></i> <?php echo $staff_row['nationality']?></a></li>
              </ul></td>
                     
                    </tr>
              </table>
            </center>
            </div>
              </div>
              
             </div>
             
                 <div class="row">
                   <div class="col-md-12">
                       <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Reg No</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_ID= $row1['student_ID'];
                   #get student details
                   $query3 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$student_ID'")or
                   die(mysqli_error());
                   while ($row2=mysqli_fetch_array($query3)){
                    $img;
                   if($row2['photo'] !=''){
                    $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row2['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                    }
                    echo" <tr>
                           <td>
                            ".$img."
                           </td>
                            <td>".$row2['first_Name']." ". $row2['last_Name']."</td>
                            <td>".$row2['registration_No']." </td>
                            <td>".$row2['gender_MFU']."</td>
                            <td>Action</td>  
                            <td>";
                           echo'   <a class="btn btn-success btn-flat" href="view_student.php?id='.$row2['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span></a>
                             <button type="button" id="'.$row2['student_ID'].'" class="btn btn-danger btn-flat" value="'.$row1['parent_ID'].'" onclick="delinkStudent(this.id,this.value)" data-toggle="modal"  data-target="#delink_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                           </td>
                         </tr>';

                   }
                  
                    }
                  ?>
               
                 </tbody>
                <tfoot>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
                   </div>
                   
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!-- /.row -->
      
    
       
         <!-- unlink student  Modal-->
    
     
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
  function delinkStudentFromParent(student_ID,parent_ID){
    //alert(parent_ID);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&student_ID='+ student_ID;
  $.ajax({
  type: "POST",
  url: "unlink_student_parent.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location='view_parent.php?id='+parent_ID+'&unlink=True' 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  

  }


  });
  }
</script>
</body>
</html>
