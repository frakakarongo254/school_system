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
        if(isset($_GET['update'])){
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
       if(isset($_POST['save_admissionBtn'])){
       // $student_profile_photo = addslashes(file_get_contents($_FILES['student_profile_photo']['tmp_name']));
        
        
         
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
  
        $student_first_name=$_POST['student_first_name'];
        $student_last_name=$_POST['student_last_name'];
        $student_nickname=$_POST['student_nickname'];
        $student_regNo;
        $student_dateOfBirth=$_POST['student_dateOfBirth'];
        $student_admission_date=$_POST['student_admission_date'];
        $student_gender=$_POST['student_gender'];
        $student_nationality=$_POST['student_nationality'];
        $healthyComment=$_POST['healthyComment'];
        $Student_zone=$_POST['student_zone'];
        $zoneChargeType=$_POST['zoneChargeType'];
        $student_class_id=$_POST['student_class_id'];
        #generate student Reg no based on the last regno from the database 
       $get_last_RegNo_query= mysqli_query($conn,"select * from `student` where `school_ID` ='".$school_ID."'");
       $get_last_RegNo=mysqli_num_rows ( $get_last_RegNo_query );
       $lastRegNo = $get_last_RegNo + 1;
       #make sure the new reg no does not exist from the database
      
        if($lastRegNo < 9){
          $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/000'.$lastRegNo;
       }elseif ($lastRegNo < 99) {
         $datetime = date_create()->format('Y');
         $student_regNo= $datetime.'/00'.$lastRegNo;
       }elseif ($lastRegNo > 99) {
         $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/0'.$lastRegNo;
       }

        # check image
       if(isset($_FILES['student_profile_photo']['name']) and !empty($_FILES['student_profile_photo']['name'])){
           $file=$_FILES['student_profile_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["student_profile_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
            $student_profile_photo = addslashes(file_get_contents($_FILES['student_profile_photo']['tmp_name']));
             $sudent_insert_query=mysqli_query($conn,"insert into `student` (first_Name,last_Name,nickname,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,photo,nationality,zone,zone_transport_type,class_ID) values('$student_first_name','$student_last_name','$student_nickname','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_profile_photo','$student_nationality','$Student_zone','$zoneChargeType','$student_class_id') ");
        if($sudent_insert_query){
          
           echo '<script> window.location="add_student.php?insert=True" </script>';
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
           $sudent_insert_query=mysqli_query($conn,"insert into `student` (first_Name,last_Name,nickname,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,nationality,zone,zone_transport_type,class_ID) values('$student_first_name','$student_last_name','$student_nickname','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_nationality','$Student_zone','$zoneChargeType','$student_class_id') ");
        if($sudent_insert_query){
          
           echo '<script> window.location="add_student.php?insert=True" </script>';
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
              <li><a href="#tab_2" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Other Details</a></li>
            </ul>
            <div class="tab-content">
              
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_1">
               <form id="fileinfo" name="fileinfo" action="add_student.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class=" col-md-6 mb-3">
                  <div class="form-group has-feedback input-group-lg">
                        <label>First Name :</label>
                 <div class=" col-md- input-group input-group-">
                  <input type="text" name="student_first_name"  class="form-control"   placeholder="First Name" required>
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                </div>
                </div>
                <div class=" col-md-6 mb-3">
                 <div class="form-group has-feedback input-group-">
                        <label>Last Name :</label>
                 <div class=" col-md- input-group input-group">              
                  <input type="text" name="student_last_name"  class="form-control"   placeholder="Last Name" required>
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                </div>
                </div>            
              </div>
              <br>
              
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Nickname :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="student_nickname"  class="form-control"   placeholder="Nickname" required>
                </div>
              </div>
              <br>
             
               <div class="row">
                 <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Gender :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <div class="form-group">
                  <label>
                    <input type="radio" name="student_gender" class=" flat-red"  value="Male" checked>
                    <label>Male</label>
                  </label>
                  <label>
                    <input type="radio" name="student_gender" class=" flat-red" value="Female">
                    <label>Female</label>
                  </label>
                
                </div>
                </div>
              </div>
              <br>
              
               <div class="row">
               
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Date Of Birth :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                  <input type="date" name="student_dateOfBirth" class="form-control" placeholder="" required>
                </div>
                
              </div>
              <br>
              
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Admission Date :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="student_admission_date" class="form-control" placeholder="" required>
                </div>
                <br>
              </div>

              <br>
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Nationality:</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <select class="form-control select2" name="student_nationality" style="width: 100%;">
                  <?php  include("include/nationality.php");?>
                 </select>
                </div>
                <br>
              </div>
              
              <br>
              
               <div class="row">
                 <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Profile Photo :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="file"  class="form-control" name="student_profile_photo" >
                </div>
               
                
              </div>
           
            
              <br>
             
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                 <label for="nationality">Healthy comment :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <textarea class="form-control" name="healthyComment" placeholder="Healthy comment" required></textarea>
                </div>
               
              </div>
              
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane " id="tab_2">
                
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Class:</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <select class="form-control select2" name="student_class_id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                  <?php
                 $query_class= mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($class_rows=mysqli_fetch_array($query_class)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$class_rows['class_ID'].'">'.$class_rows['class_name'].'</option>';
                   }
                ?>
                 </select>
                </div>
                <br>
              </div>
              <br>
                 <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Zone :</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-map"></i></span>
                <select name="student_zone" class="form-control">
                <?php
                 $query_zone = mysqli_query($conn,"select * from zone where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($zone_rows=mysqli_fetch_array($query_zone)){
                    $student_regNoID= $zone_rows['class_name'];
                  echo'  <option value="'.$zone_rows['zone'].'">'.$zone_rows['zone'].'</option>';
                   }
                ?>
              </select>
                
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="zone">Transport Type:</label>
                </div>
                <div class=" col-md-5 input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-bus"></i></span>
              <select name="zoneChargeType" class="form-control">
               <option value="None">None</option>
               <option value="oneWayCharge">One Way</option>
               <option value="twoWayCharge">Two Way</option>
              </select>
                </div>
              </div>
              <br>
               
               <div class="row">
              <div class="col-md-9">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Add Student</button>
              </div>
              </div>
             
              </form>
              </div>
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
    <!--- add student Modal -->
      <div class="modal fade" id="modal-addStudent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Student</h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
                
              <div class="tab-content">
              <form id="fileinfo" name="fileinfo" action="student.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class=" col-md-6 mb-3">
                  <div class="form-group has-feedback input-group-lg">
                        <label>First Name :</label>
                 <div class=" col-md- input-group input-group-">
                  <input type="text" name="student_first_name"  class="form-control"   placeholder="First Name" required>
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                </div>
                </div>
                <div class=" col-md-6 mb-3">
                 <div class="form-group has-feedback input-group-">
                        <label>Last Name :</label>
                 <div class=" col-md- input-group input-group">              
                  <input type="text" name="student_last_name"  class="form-control"   placeholder="Last Name" required>
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
                </div>
                </div>            
              </div>
              <br>
              
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Nickname :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="student_nickname"  class="form-control"   placeholder="Nickname" required>
                </div>
              </div>
              <br>
             
               <div class="row">
                 <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Gender :</label>
                </div>
                <div class=" col-md- input-group input-group-">
                  <div class="form-group">
                  <label>
                    <input type="radio" name="student_gender" class=" flat-red"  value="Male" checked>
                    <label>Male</label>
                  </label>
                  <label>
                    <input type="radio" name="student_gender" class=" flat-red" value="Female">
                    <label>Female</label>
                  </label>
                
                </div>
                </div>
              </div>
              <br>
              
               <div class="row">
               
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Date Of Birth :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                  <input type="date" name="student_dateOfBirth" class="form-control" placeholder="" required>
                </div>
                
              </div>
              <br>
              
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Admission Date :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="student_admission_date" class="form-control" placeholder="" required>
                </div>
                <br>
              </div>
              
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Zone :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-map"></i></span>
                <select name="student_zone" class="form-control">
                <?php
                 $query_zone = mysqli_query($conn,"select * from zone where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($zone_rows=mysqli_fetch_array($query_zone)){
                    $student_regNoID= $zone_rows['class_name'];
                  echo'  <option value="'.$zone_rows['zone'].'">'.$zone_rows['zone'].'</option>';
                   }
                ?>
              </select>
                
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="zone">Transport Type:</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-bus"></i></span>
              <select name="zoneChargeType" class="form-control">
               <option value="None">None</option>
               <option value="oneWayCharge">One Way</option>
               <option value="twoWayCharge">Two Way</option>
              </select>
                </div>
              </div>
              <br>
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Class :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-o"></i></span>
                <select name="student_class" class="form-control">
                <?php
                 $qer = mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($rows1=mysqli_fetch_array($qer)){
                    $student_regNoID= $rows1['class_name'];
                  echo'  <option value="'.$rows1['class_name'].'">'.$rows1['class_name'].'</option>';
                   }
                ?>
              </select>
                
                </div>
                
              </div>
              <br>
              
               <div class="row">
                 <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Profile Photo :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="file"  class="form-control" name="student_profile_photo" >
                </div>
               
                
              </div>
           
            
              <br>
             
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                 <label for="nationality">Healthy comment :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <textarea class="form-control" name="healthyComment" placeholder="Healthy comment" required></textarea>
                </div>
               
              </div>
               <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Add Student</button>
              </div>
              </div>
             
              </form>
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!--Edit student model-->
         
      <div class="modal fade" id="modal-editStudent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Student</h4>
              </div>
              <div class="modal-body">
                <script >
                function editStudentDetails(RegNo){
               
                var updiv = document.getElementById("editMessage"); //document.getElementById("highodds-details");
                //alert(id);
                var details= '&RegNo='+ RegNo;
                $.ajax({
                type: "POST",
                url: "edit_student.php",
                data: details,
                cache: false,
                success: function(data) {
               
                document.getElementById("editMessage").innerHTML=data;
                 }
                });
                }
                </script>
                <div id="editMessage"></div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--end of edit student modal-->
       
         <!-- delete student  Modal-->
    <div class="modal  fade" id="delete_student_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this student?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteStudent(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteStudentFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
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
