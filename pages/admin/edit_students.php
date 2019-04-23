<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
  $student_ID = '';
 if(isset($_GET['id'])){
 $student_ID =$_GET['id'];
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
      
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Student added  successfully.
          </div>';   
        }
        if(isset($_GET['update']) && isset($_GET['id'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Updated successfully.
          </div>';   
        }
        if(isset($_GET['delete'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have deleted  successfully.
          </div>';   
        }
    


      #edit student details
      if(isset($_POST['editStudentBtn'])){
        $edit_student_nickname="";
        $edit_healthyComment="";
          #get school Id from current session school id

         $school_ID = $_SESSION['login_user_school_ID'];

        $edit_student_first_name=$_POST['edit_student_first_name'];
        $edit_student_last_name=$_POST['edit_student_last_name'];
        $edit_student_nickname=$_POST['edit_student_nickname'];
        $edit_student_dateOfBirth=$_POST['edit_student_dateOfBirth'];
        $edit_student_admission_date=$_POST['edit_student_admission_date'];
        $edit_student_gender=$_POST['edit_student_gender'];
        $edit_healthyComment=$_POST['edit_healthyComment'];
        $edit_status=$_POST['edit_student_status'];
       $edit_Student_zone=$_POST['edit_student_zone'];
        $edit_zoneChargeType=$_POST['edit_zoneChargeType'];
       $edit_student_nationality=$_POST['edit_student_nationality'];
       $edit_student_class_id=$_POST['edit_student_class_id'];
       $eventTitle=$edit_student_first_name ." ". $edit_student_last_name . "  Birthday";
        # check image
       if(isset($_FILES['edit_student_profile_photo']['name']) and !empty($_FILES['edit_student_profile_photo']['name'])){
         echo  $file=$_FILES['edit_student_profile_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["edit_student_profile_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
            $edit_student_profile_photo = addslashes(file_get_contents($_FILES['edit_student_profile_photo']['tmp_name']));
              $result_query=mysqli_query($conn,"update `student` SET first_Name= '".$edit_student_first_name."',last_Name= '".$edit_student_last_name."',nickname= '".$edit_student_nickname."',date_of_Birth='".$edit_student_dateOfBirth."',gender_MFU='".$edit_student_gender."',other_Details='".$edit_healthyComment."',admission_date='".$edit_student_admission_date."',status='".$edit_status."',zone='".$edit_Student_zone."',zone_transport_type='".$edit_zoneChargeType."',nationality='".$edit_student_nationality."',class_ID='".$edit_student_class_id."',photo='".$edit_student_profile_photo."' where `student_ID`='".$student_ID."' and `school_ID`='".$school_ID."' ");
        if($result_query){
           $event_query=mysqli_query($conn,"update `event` SET event_title= '".$eventTitle."',event_startDate='".$edit_student_dateOfBirth."',event_endDate='". $edit_student_dateOfBirth."' where `student_ID`='".$student_ID."'  and `school_ID`='".$school_ID."'");
           if ($event_query) {
              echo '<script> window.location="edit_students.php?id='.$student_ID.'&update=True" </script>';
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
            $result_query=mysqli_query($conn,"update `student` SET first_Name= '".$edit_student_first_name."',last_Name= '".$edit_student_last_name."',nickname= '".$edit_student_nickname."',date_of_Birth='".$edit_student_dateOfBirth."',gender_MFU='".$edit_student_gender."',other_Details='".$edit_healthyComment."',admission_date='".$edit_student_admission_date."',status='".$edit_status."',zone='".$edit_Student_zone."',zone_transport_type='".$edit_zoneChargeType."',nationality='".$edit_student_nationality."',class_ID='".$edit_student_class_id."' where `student_ID`='".$student_ID."' and `school_ID`='".$school_ID."' ");
        if($result_query){
          
          $event_query=mysqli_query($conn,"update `event` SET event_title= '".$eventTitle."',event_startDate='". $edit_student_dateOfBirth."',event_endDate='". $edit_student_dateOfBirth."' where `student_ID`='".$student_ID."'  and `school_ID`='".$school_ID."'");
           if ($event_query) {
              echo '<script> window.location="edit_students.php?id='.$student_ID.'&update=True" </script>';
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
       echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
       }

        }
       
      }
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    
        <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Student Profile</a></li>
             
            </ul>
            <div class="tab-content">
              
              
                <?php
              $RegNo = $_GET['id'];
              $query_details = mysqli_query($conn,"select * from `student` where `student_ID` = '".$student_ID."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
                 $rows_details = mysqli_fetch_array($query_details,MYSQLI_ASSOC);
                 ?>
              
         
              <!-- /.tab-pane -->
             
               <form id="fileinfo" name="fileinfo" action="edit_students.php?id=<?php echo $student_ID?>" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class=" col-md-4 mb-3">
                  <div class="form-group has-feedback input-group-lg">
                        <label>First Name :</label>
                 <div class=" col-md- input-group input-group-">
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" value="<?php echo $rows_details['first_Name'];?>" name="edit_student_first_name"  class="form-control"   placeholder="First Name" required>
                 
                </div>
                </div>
                </div>
                <div class=" col-md-4 mb-3">
                 <div class="form-group has-feedback input-group-">
                        <label>Last Name :</label>
                 <div class=" col-md- input-group input-group"> 
                 <span class="input-group-addon"><i class="fa fa-user"></i></span>             
                   <input type="text" name="edit_student_last_name" value="<?php echo $rows_details['last_Name'];?>" class="form-control"   placeholder="Last Name" required>
                   
                </div>
                </div>
                </div>  
                <div class=" col-md-4 mb-3">
                 <div class="form-group has-feedback input-group-">
                        <label>Nickname :</label>
                 <div class=" col-md- input-group input-group">              
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                   <input type="text" value="<?php echo $rows_details['nickname'];?>" name="edit_student_nickname"  class="form-control"   placeholder="Nickname" >
                </div>
                </div>
                </div>           
              </div>
              <br>
              
             
             
               <div class="row">
                <div class="col-md-4">
                 
            <div class="form-group">
                        <label>Gender:</label>
                 <div class=" form-group">  
                 <?php if($rows_details['gender_MFU']=="Male"){
              echo'    <label>
                    <input type="radio" name="edit_student_gender" class=" flat-red"  value="Male" checked>
                    <label>Male</label>
                  </label>
                  <label>
                    <input type="radio" name="edit_student_gender" class=" flat-red" value="Female">
                    <label>Female</label>
                  </label>';
                 }else{
                echo' <label>
                    <input type="radio" name="edit_student_gender" class=" flat-red"  value="Male" >
                    <label>Male</label>
                  </label>
                  <label>
                    <input type="radio" name="edit_student_gender" class=" flat-red" value="Female" checked>
                    <label>Female</label>
                  </label>';
                 }?>            
                 
                </div>
                </div>

                </div>
                
              
              <div class="col-md-4">
                 
                <div class="form-group has-feedback input-group-">
                        <label>Date Of Birth :</label>
                 <div class=" col-md- input-group input-group">              
                 <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                   <input type="date" name="edit_student_dateOfBirth" value="<?php echo $rows_details['date_of_Birth'];?>" class="form-control" placeholder="" required>
                </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group has-feedback input-group-">
                        <label>Admission Date:</label>
                 <div class=" col-md- input-group input-group">              
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="edit_student_admission_date" value="<?php echo $rows_details['admission_date'];?>" class="form-control" placeholder="" required>
                </div>
                </div>
                
              </div>
            </div>
            
              <div class="row">
                <div class="col-md-4">
                   <div class="form-group">
                        <label>Nationality:</label>
                            
                  <select class="form-control select2" name="edit_student_nationality" style="width: 100%;">
                    <option value="<?php echo $rows_details['nationality'];?>" ><?php echo $rows_details['nationality'];?></option>
                  <?php  include("include/nationality.php");?>
                 </select>
                
                </div>
                
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                        <label>Status:</label>
                   
                 <div class="form-group">
                  <?php if($rows_details['status']=="Active"){
              echo'    <label>
                    <input type="radio" name="edit_student_status" class=" flat-red"  value="Active" checked>
                    <label>Active</label>
                  </label>
                  <label>
                    <input type="radio" name="edit_student_status" class=" flat-red" value="Inactive">
                    <label>Inactive</label>
                  </label>';
                 }else{
                echo' <label>
                    <input type="radio" name="edit_student_status" class=" flat-red"  value="Active" >
                    <label>Active</label>
                  </label>
                  <label>
                    <input type="radio" name="edit_student_status" class=" flat-red" value="Inactive" checked>
                    <label>Inactive</label>
                  </label>';
                 }?>            
                 </div>
                
                </div>
                

                </div>
                <div class="col-md-4">
                   <div class="form-group ">
                        <label>Class:</label>
                             
                <select class="form-control select2" name="edit_student_class_id" style="width: 100%;" required>
                   <?php
                    $select_class= mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."' and class_ID='".$rows_details['class_ID']."'")or
                   die(mysqli_error());
                   $row_selected = mysqli_fetch_array($select_class,MYSQLI_ASSOC);
                   echo' <option value="'.$row_selected['class_ID'].'">'.$row_selected['name'].'</option>';
                   ?>
                   
                  <?php
                 $query_class= mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($class_rows=mysqli_fetch_array($query_class)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$class_rows['class_ID'].'">'.$class_rows['name'].'</option>';
                   }
                ?>
                 </select>
                </div>
                
                </div>
                
              </div>
              
              <div class="row">
                 <div class="col-md-4">
                  <div class="form-group ">
                        <label>Zone:</label>
                   <select name="edit_student_zone" class="form-control">
                <?php
                 $query_zone = mysqli_query($conn,"select * from zone where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($zone_rows=mysqli_fetch_array($query_zone)){
                    $student_regNoID= $zone_rows['class_name'];
                  echo'  <option value="'.$rows_details['zone'].'">'.$rows_details['zone'].'</option>
                        <option value="'.$zone_rows['zone'].'">'.$zone_rows['zone'].'</option>';
                   }
                ?>
              </select>
                </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group">
                <label>Transport Type:</label>
                <select name="edit_zoneChargeType" class="form-control">
                <option value="<?php echo $rows_details['zone_transport_type'];?>"><?php echo $rows_details['zone_transport_type'];?></option>
               <option value="None">None</option>
               <option value="oneWayCharge">One Way</option>
               <option value="twoWayCharge">Two Way</option>
              </select>
              </div>
                </div>
               
                <div class="col-md-4">
                   <div class="form-group has-feedback input-group-">
                        <label>Comment:</label>
                 <div class=" col-md-12 input-group input-group">              
                 <textarea class="form-control" name="edit_healthyComment" placeholder="Healthy comment" ><?php echo $rows_details['other_Details'];?></textarea>
                </div>
                  </div>
                </div>
                
                
              </div>
              
               <div class="row">
                <div class="col-md-2">
                 <div class="form-group  col-md- mb-3">
                  <label for="nationality">Profile Photo :</label>
              

               </div>
             </div>
               <div class="col-md-2">
                 
                  <div style="border: ;height: 100px;width: 100px;">
                   
                     <?php echo '<img  id="blah" src="data:image/jpeg;base64,'.base64_encode( $rows_details['photo'] ).'"  height="100px" width="100px" />';?>
                 </div>
                 <br>
                  <span class="btn btn-default btn-file">
                    Browse Picture<input name="edit_student_profile_photo" type="file" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                </span>
               </div>
                
              </div>
            <br>
            
               <div class="row">
              <div class="col-md-9">
                
                <button type="submit" name="editStudentBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
             </form>
             
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->



























       
       
     
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
