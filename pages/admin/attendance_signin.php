<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
#get school Id from current session school id
 $school_ID = $_SESSION['login_user_school_ID'];
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
          Success! Attendance signed successfully.
          </div>';   
        }
        if(isset($_GET['link'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have linked  successfully.
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
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have updated  successfully.
          </div>';   
        }
       if(isset($_POST['saveAttendanceBtn']))
 {
   $class_ID= $_POST['classID'];
    foreach ($_POST['attendance_status'] as $id => $attendance_status)
    {   
        $classID= $class_ID;
       // $attendance_status = $_POST['attendance_status'][$id];
        if(isset($_POST['student_ID'][$id]) and isset($_POST['student_name'][$id])){
         $student_id = $_POST['student_ID'][$id];
        $student_name = $_POST['student_name'][$id];

        $date_created = date('Y-m-d H:i:s');
        $date_modified = date('Y-m-d H:i:s');
        $school_ID = $_SESSION['login_user_school_ID'];
        $attendance=mysqli_query($conn,"insert into `attendance` (student_id, student_name,class_ID, date_entered, date_modified, status,school_ID
          ) 
          values('$student_id', '$student_name','$class_ID', '$date_created', '$date_modified', '$attendance_status','$school_ID') ");
       }
    }
     
    if ($attendance) {
      //echo  $msg = "Attendance has been added successfully";
       echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Attendance has been signed successfully.
          </div>';   
      // echo '<script> window.location="attendance.php?insert=True" </script>';
    }else{
       echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Oops! Please try again.
          </div>';   
    }
}
 if(isset($_POST['submitSignIn'])){//to run PHP script on submit
  $query1='';
if(!empty($_POST['check'])){
// Loop to store and display values of individual checked checkbox.
foreach($_POST['check'] as $selected){
//echo $selected."</br>";
}
$signedBy=$_POST['signedBy'];
 $attendanceTime=$_POST['attendanceTime'];
$Date= date('Y/m/d');

for($i = 0; $i<count($_POST['check']); $i++)  
{  
 $studentID=$_POST['check'][$i]."</br>"; 
 $classId = $_POST['classId'][$i]."</br>";
$que = mysqli_query($conn,"select * from attendance where student_ID='".$_POST['check'][$i]."' and date_entered='".$Date."' and school_ID = '".$school_ID."' ")or
    die(mysqli_error());
    if (mysqli_num_rows($que) == 0) {
    $query1=mysqli_query($conn,"INSERT INTO attendance 
SET   
signed_in_by = '{$signedBy}',  
sign_in_time = '{$attendanceTime}',
student_ID = '{$_POST['check'][$i]}',  
class_ID = '{$_POST['classId'][$i]}',  
date_entered = '{$Date}',  
school_ID = '{$school_ID}'"); 
echo '<script> window.location="manage_attendance.php?insert=True" </script>';
    }else{
      
     
    }
                   

//echo '<script> window.location="createinvoice.php?invoice=True" </script>'; 
} 

}else{
	 echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         No student selected.
          </div>';   
}
}
    
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <div><b><h2>SIGN IN ATTENDANCE</h2></b></div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              
     <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-6">
       
        
       <form  method="POST" action="attendance_signin.php">
              <div class="col-md-6">
                 <div class=" form-group">
                
                  <select class="form-control select2" onchange="" name="attendance_class__id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                   <?php
                 $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['class_ID'].'">'.$row_value['level_name'].' '.$row_value['stream_name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
                </div>
              </div>
              
              <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="searchAttendance">Search</button>
              </div>
             </form>
             
       </div>

     </div>
     <div class="row">
      <form method="POST" action="attendance_signin.php">
      <div class="col-md-4">
         <br>
         <br>
         <br>
        <div class="form-group">
         
       
         <select class="form-control select2" onchange="" name="signedBy" style="width: 100%;" required>
                    <option value="">--Signed in By--</option>
                   <?php
                 $query_c= mysqli_query($conn,"select staff.full_Name as name,admin.first_name as admFName, admin.second_name as admSName from staff join admin on admin.school_ID=staff.school_ID where staff.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['name'].'">'.$row_value['name'].'</option>';
                    echo' <option value="'.$row_value['admFName'].' '.$row_value['admSName'].'">'.$row_value['admFName'].' '.$row_value['admSName'].' </option>';
                   }
                 
                   
                ?>
                 </select>
      
        </div>
        <div class="row">
          <div class="col-md-6">
        <div class="input-group date">
          <?php
          $currentTimeinSec = time(); 
          $currentDateTime = date('F d Y', $currentTimeinSec);
          $time =date("h:i:sa"); ?>
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" value="<?php echo $currentDateTime ?>" disabled>
                </div>
                </div>
                <div class="col-md-6">
             <div class="form-group">
                  

                  <div class="input-group">
                    <input type="text" name="attendanceTime" class="form-control timepicker" required>

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <br>
                
                </div>
              </div>
           <div class="form-group">
                   <button type="submit" name="submitSignIn" class="btn " id="button1">Signin</button>
                </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-4">
          
          </div>
          <div class="col-md-8">
            
          </div>
        </div>
        
        <div id="signInDiv">

           <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th> <label>
            <input type="checkbox" id="select_all" class="" style="width: 15px;height: 15px;background-color: red"> All
          </label></th>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Gender</th>
                 
                </tr>
                </thead>
                <tbody>

                <?php
                if(isset($_POST['searchAttendance'])){
                  $classID=$_POST['attendance_class__id'];
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and class_ID='".$classID."' ")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                   $status;
                   if($row1['status'] =='Admitted'){
                     $status='Active';
                  
                   }else{
                    $status=$row1['status'];
                   }
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                    // encryption function 
  
                  
                  //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  <td><input class='checkbox' type='checkbox' name='check[]' value='".$stdId."' style='width: 15px;height: 15px;'></td>
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'><a href='view_student.php?id=".$stdId."'>".$img."</a></td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$row1['registration_No']." </td>
                  <td>".$row1['gender_MFU']."</td>
                   
                  ";
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }else{
                    $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' ")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                   $status;
                   if($row1['status'] =='Admitted'){
                     $status='Active';
                  
                   }else{
                    $status=$row1['status'];
                   }
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                    // encryption function 
  
                  
                  //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  <td><input class='checkbox' type='checkbox' name='check[]' value='".$stdId."' style='width: 15px;height: 15px;'></td>
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'<a href='view_student.php?id=".$stdId."'>".$img."</a></td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$row1['registration_No']." </td>
                  <td>".$row1['gender_MFU']."</td>
                   
                  ";
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }
               ?>
              </tbody>
               
              </table>

        </div>
      </div>
     </form>
   </div>
    
       
        
         
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
       
         <!-- delete parent  Modal-->
    <div class="modal  fade" id="delete_parent_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this parent?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteStudent(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteParentFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
      </div>
    </div>
     </div>

    <!-- Link  student  with parent Modal-->
    <div class="modal  fade" id="link_student_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Link Student</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form >
             <div class=" col-md- input-group input-group-">
                
                <input type="text" class="form-control" id="searchStudent" onkeyup="searchStudentFunc(this.value)" name="searchStudent" placeholder="Enter Student Reg or Name" required="">
                 <input type="hidden" class="form-control" id="parentIDVal" name="parentIDVal" placeholder="Sudent Reg No" required="">
                <span class="input-group-addon"><button type="button" class="btn btn-success" onclick="searchStudentFunc()"><i class="fa fa-search"></i>Search</button></span>
              </div>
              </form>  
            <script >
             function showLinkparentID(link_parentID){
              
              document.getElementById("parentIDVal").value=link_parentID;
             }
               function searchStudentFunc(RegNo){ 
                //var RegNo = document.getElementById("searchStudent").value;
                var linkParentID = document.getElementById("parentIDVal").value;
                  if(RegNo !=''){
                    var details= '&RegNo='+ RegNo +'&linkParentID='+ linkParentID;

                    $.ajax({
                    type: "POST",
                    url: "search_student_parentRelation.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                    if(data=='success'){
                    document.getElementById("StudentMSG").innerHTML=data;
                    }else{
                    document.getElementById("StudentMSG").innerHTML=data;
                    }

                    }

                    });
                   
                  }else{
                   document.getElementById("StudentMSG").innerHTML=' You have Not entered anything to search';
                  }
                 
                
                }
            </script>
          
          <div id="StudentMSG"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
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
<script>
var select_all = document.getElementById("select_all"); //select all checkbox
var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
  for (i = 0; i < checkboxes.length; i++) { 
    checkboxes[i].checked = select_all.checked;
  }
});


for (var i = 0; i < checkboxes.length; i++) {
  checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
      select_all.checked = false;
    }
    //check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
      select_all.checked = true;
    }
  });
}
</script>
<script >
  function signinDetails(class_id) {
    //alert(class_id);
    //var info=document.getElementById("hiddenDiv").outerHTML;
   // alert(info);
    var details= '&class_id='+ class_id;
    $.ajax({
  type: "POST",
  url: "attendance_signin.php",
  data: details,
  cache: false,
  success: function(result) {
   // $("#checkAllboxDiv").html(data);
   // document.getElementById("checkAllboxDiv").innerHTML=info;
     $("#signInDiv").html(result);
  
  }

  });
};
</script>
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


</body>
</html>
