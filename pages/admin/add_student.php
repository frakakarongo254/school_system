<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
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
        
        $student_nickname="";
        $healthyComment="";
         
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
  
        $student_first_name=$_POST['student_first_name'];
        $student_last_name=$_POST['student_last_name'];
       $student_regNo=$_POST['student_regNo'];
       
        $student_dateOfBirth=$_POST['student_dateOfBirth'];
        $student_admission_date=$_POST['student_admission_date'];
        $student_gender=$_POST['student_gender'];
        $student_nationality=$_POST['student_nationality'];
        $student_status=$_POST['student_status'];
        $healthyComment=$_POST['healthyComment'];
        $Student_zone=$_POST['student_zone'];
        $zoneChargeType=$_POST['zoneChargeType'];
        $student_class_id=$_POST['student_Class_Id'];
        $meal_plan=$_POST['meal_plan'];

        $randstd = substr(number_format(time() * rand(),0,'',''),0,10);
        $student_ID=md5($randstd);
        $eventTitle=$student_first_name ." ".$student_last_name . " Birthday";
       
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
             $sudent_insert_query=mysqli_query($conn,"insert into `student` (student_ID,first_Name,last_Name,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,photo,nationality,zone,zone_transport_type,class_ID,status,meal_plan) values('$student_ID','$student_first_name','$student_last_name','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_profile_photo','$student_nationality','$Student_zone','$zoneChargeType','$student_class_id','$student_status','$meal_plan') ");

             
        if($sudent_insert_query){
        $student_id=$student_ID;
        $event_insert_query=mysqli_query($conn,"insert into `event` (school_ID,student_ID ,event_title,event_location,event_startDate,event_startime,event_endDate,event_endtime,event_description,event_color,event_type
          ) 
          values('$school_ID','$student_id','$eventTitle','School','$student_dateOfBirth','12:00am','$student_dateOfBirth','12:00pm','Student Birthday','#000000','Birthday') ");
            if ($event_insert_query) {
            
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
           $sudent_insert_query=mysqli_query($conn,"insert into `student` (student_ID,first_Name,last_Name,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,nationality,zone,zone_transport_type,class_ID,status,meal_plan) values('$student_ID','$student_first_name','$student_last_name','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_nationality','$Student_zone','$zoneChargeType','$student_class_id','$student_status','$meal_plan') ");
        if($sudent_insert_query){
        
          $student_id=$student_ID;
        $event_insert_query=mysqli_query($conn,"insert into `event` (school_ID,student_ID ,event_title,event_location,event_startDate,event_startime,event_endDate,event_endtime,event_description,event_color,event_type
          ) 
          values('$school_ID','$student_id','$eventTitle','School','$student_dateOfBirth','12:00am','$student_dateOfBirth','12:00pm','Student Birthday','#000000','Birthday') ");
            if ($event_insert_query) {
            
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
 
        
       
       <div class="row">
         <div class="col-md-2">
          <ul class="nav nav-tabs pull-right">
              <li class=""><a href="student.php"  style="font-size:20px; font-weight: bold;font-family:;text-transform: uppercase; "Times New Roman", Times, serif;"> Student </a></li>
              
              
            </ul>
         </div>
         <div class="col-md-3">
            <ul class="nav nav-tabs">
              <li class=""><a href="add_student.php"  style="font-size:20px; font-weight: bold;font-family: ;text-transform: uppercase;color: #000000"Times New Roman", Times, serif;">Add Student </a></li>
              
              
            </ul>
         </div>
       </div>
     
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
     
    
        <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            
            <div class="tab-content">
              
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_1">
               <form id="fileinfo" name="fileinfo" action="add_student.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <?php
                   $student_regNo='';
                    $get_last_RegNo_query= mysqli_query($conn,"select count(id) as d from `student` where `school_ID` ='".$school_ID."'");

               $get_last_RegNo = mysqli_fetch_array($get_last_RegNo_query,MYSQLI_ASSOC);
            $get_last_RegNo['d'];
       //$get_last_RegNo=mysqli_num_rows ( $get_last_RegNo_query );
       $lastRegNo = $get_last_RegNo['d'] + 1;
       #make sure the new reg no does not exist from the database
      
        if($lastRegNo < 9){
          $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/00'.$lastRegNo;
       }elseif ($lastRegNo < 99) {
         $datetime = date_create()->format('Y');
         $student_regNo= $datetime.'/0'.$lastRegNo;
       }elseif ($lastRegNo > 99) {
         $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/'.$lastRegNo;
       }
          $get_query= mysqli_query($conn,"select registration_No from `student` where `registration_No`='".$student_regNo."' and `school_ID` ='".$school_ID."' ");


                  ?>
                <div class=" col-md-4 mb-3">
                  
                   <label>Adm No:
                 ( <input type="checkbox" class=""  id="autoGenerate" onchange="autoGenerateFun(this.value)" name="autoGenerate" value="<?php echo$student_regNo?>"  style="width: 15px;height: 15px;background-color: red"checked>
                auto Generate)
                </label>
                  <div class="form-group has-feedback input-group-lg">
                       
                 <div class=" col-md- input-group input-group-">
                  

                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <div id="regNoDiv">
                  <input type="text" name="student_regNo"  class="form-control" value="<?php echo $student_regNo ?>"   placeholder="Adm No" readonly>
                  <input type="hidden" name="student_regNo"  class="form-control" value="<?php echo $student_regNo ?>"   placeholder="Adm No" >
                   </div>
                  
                 
                </div>
                </div>
                </div>
                <div class=" col-md-4 mb-3">
                  <div class="form-group has-feedback input-group-lg">
                        <label>First Name :</label>
                 <div class=" col-md- input-group input-group-">
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="student_first_name"  class="form-control"   placeholder="First Name" required>
                 
                </div>
                </div>
                </div>
                <div class=" col-md-4 mb-3">
                 <div class="form-group has-feedback input-group-">
                        <label>Last Name :</label>
                 <div class=" col-md- input-group input-group"> 
                 <span class="input-group-addon"><i class="fa fa-user"></i></span>             
                  <input type="text" name="student_last_name"  class="form-control"   placeholder="Last Name" required>
                   
                </div>
                </div>
                </div>  
                       
              </div>
              <br>
              
             
             
               <div class="row">
                <div class="col-md-4">
                 
                <div class="form-group has-feedback input-group-">
                        <label>Gender:</label>
                 <div class=" col-md- input-group input-group">              
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
              <div class="col-md-4">
                 
                <div class="form-group has-feedback input-group-">
                        <label>Date Of Birth :</label>
                 <div class=" col-md- input-group input-group">              
                 <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                  <input type="date" name="student_dateOfBirth" class="form-control" placeholder="" required>
                </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group has-feedback input-group-">
                        <label>Admission Date:</label>
                 <div class=" col-md- input-group input-group">              
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="student_admission_date" class="form-control" placeholder="" required>
                </div>
                </div>
                
              </div>
            </div>
            
              <div class="row">
                <div class="col-md-4">
                   <div class="form-group">
                        <label>Nationality:</label>
                            
                  <select class="form-control select2" name="student_nationality" style="width: 100%;">
                  <?php  include("include/nationality.php");?>
                 </select>
                
                </div>
                
                </div>
                 <div class="col-md-4">
                  <div class="form-group">
                     
                    <label>Status:</label>
                     
                 <select class="form-control select2" name="student_status" style="width: 100%">
                   <option value="Admitted">Admitted</option>
                   <option value="Toured">Toured</option>
                   <option value="Interested">Interested</option>
                   <option value="Waitlisted">Waitlisted</option>
                  
                 </select>         
                 
                
                </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group ">
                        <label>Class:</label>
                              
                 <select class="form-control select2" name="student_Class_Id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                  <?php
                 $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                      # code...
                   
                   
                          //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$row_value['class_ID'].'">'.$row_value['level_name'].' '.$row_value['stream_name'].'</option>';
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
                <select name="student_zone" class="form-control select2" style="width: 100%;">
                <?php
                 $query_zone = mysqli_query($conn,"select * from zone where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($zone_rows=mysqli_fetch_array($query_zone)){
                    $student_regNoID= $zone_rows['class_name'];
                  echo'  <option value="'.$zone_rows['zone'].'">'.$zone_rows['zone'].'</option>';
                   }
                ?>
              </select>
                </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group">
                <label>Transport Type:</label>
                <select name="zoneChargeType" class="form-control select2" style="width: 100%;">
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
                 <textarea class="form-control" rows="" name="healthyComment" placeholder="Healthy comment" ></textarea>
                </div>
                  </div>
                </div>
                <div class="col-md-4">
                  
                </div>
                
              </div>
            
              
               <div class="row">
                <div class="col-md-4">
                   <div class="form-group has-feedback input-group-">
                        <label>Meal Plan:</label>
                 <div class=" col-md-12 input-group input-group">              
                 <select class="form-control select2" name="meal_plan" style="width: 100%;">
                   <option value="Special">Special</option>
                   <option value="Normal">Normal</option>
                 </select>
                </div>
                  </div>
                </div>
                
               <div class="col-md-2">
                <label for="nationality">Profile Photo :</label>
                 <div style="border: ;height: 100px;width: 100px;">
                   <img id="blah" alt="your image" src="../../dist/img/user.jpg" width="100" height="100" />
                 </div>
                 <br>
                  <span class="btn btn-default btn-file">
                    Browse Picture<input name="student_profile_photo" type="file" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                </span>
               </div>
                
              </div>
            <br>
            
              <div class="row">
              <div class="col-md-9">
                <button type="reset" class="btn btn-danger pull-right" data-dismiss="modal">Reset</button>
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Save Student</button>
              </div>
              </div>
             </form>
             
              
              </div>
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
function autoGenerateFun(regNo){

   var autoGenerate=document.getElementById('autoGenerate');
  if ( autoGenerate.checked == true) {
   
   $('#regNoDiv').html('<input type="text" name="student_regNo"  class="form-control" value="'+regNo+'"   placeholder="Adm No" readonly> <input type="hidden" name="student_regNo"  class="form-control" value="'+regNo+'"   placeholder="Adm No" >');
 }else{

   $('#regNoDiv').html('<input type="text" name="student_regNo"  class="form-control" value=""   placeholder="Adm No" >');
 }
}
</script>

</body>
</html>
