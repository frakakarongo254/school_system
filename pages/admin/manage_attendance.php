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
          Success! Attendance updated  successfully.
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
          echo' <div class="alert alert-success alert-dismissable ">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have updated  successfully.
          </div>';   
        }
       
 
 if (isset($_POST['submitEditAttendance'])) {
   # code...

   $edit_attendance_ID=$_POST['edit_attendance_id'];
$edit_signedInBy=$_POST['edit_signedInBy'];
  $edit_signedOutBy=$_POST['edit_signedOutBy'];
  $edit_attendanceTimeIn=$_POST['edit_attendanceTimeIn'];
  $edit_attendanceTimeOut=$_POST['edit_attendanceTimeOut'];

   $update_attend_query=mysqli_query($conn,"update `attendance` SET signed_in_by= '".$edit_signedInBy."', signed_out_by= '".$edit_signedOutBy."',sign_in_time= '".$edit_attendanceTimeIn."',sign_out_time= '".$edit_attendanceTimeOut."' where `attendance_ID`='".$edit_attendance_ID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

     if($update_attend_query){
        echo '<script> window.location="manage_attendance.php?update=True" </script>';
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
    
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
               
              <form method="POST" action="manage_attendance.php">
               <div class="col-md-3">
                  <div class=" form-group">
                 
                  <select class="form-control select2" name="attendance_class_id" style="width: 100%;" required>
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
               <?php $currentTimeinSeconds = time(); 
          $currentDate = date('F d Y', $currentTimeinSeconds);
          $time =date("h:i:sa"); ?>
              <div class="col-md-3 pull-" style="text-align:">
                
                 <input type="text" name="attendance_date" class="form-control pull-right" id="datepicker" value="<?php echo $currentDate?>" >
              </div>
              <div class="col-md-3 col-" style="text-align:">
                <button class="btn btn-primary" id="button1" type="submit" name="searchAttendance" href="" ><i class="fa fa-filter"></i> filter Attendance</button>
              </div>
              <div class="col-md-3 col-" style="text-align:t">
                
                <a class="btn btn-primary" href="#" id="buttonClass" data-toggle="modal" data-target="#signin"><i class="fa fa-plus"></i><b> Sign In Attendance</b></a>
              </div>
            </form>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Sudent Name</th>
                  <th>Sign-in Time</th>
                  <th>Signed In By</th>
                  <th>Signed Out Time</th>
                   <th>Signed Out By</th>
                  <th>Attended time</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
               <?php
                if (isset($_POST['searchAttendance'])) {
                   $school_ID = $_SESSION['login_user_school_ID'];
                  $attndDate=$_POST['attendance_date'];
                $attendanceDate= date("Y-m-d", strtotime($attndDate));
                 
                  $attendance_class_id=$_POST['attendance_class_id'];
                 
               
                 
                   
                   $query22 = mysqli_query($conn,"select * from attendance where school_ID = '".$school_ID."' and class_ID='".$attendance_class_id."' and date_entered='".$attendanceDate."'  ")or
                   die(mysqli_error());
                    while ($row11=mysqli_fetch_array($query22)){
                     $student_id=$row11['student_ID'];
                      $attendance_ID=$row11['attendance_ID'];
                     $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and student_ID='".$student_id."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                  
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                    $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row11['sign_in_time'];
                 $time_out=$row11['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff='';
                   if ($time_out !=='') {
                      $diff= $duration->format("%H:%I:%S");
                   }else{
                    $diff=' ';
                   }
              // encryption function 

              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'><a href='view_student.php?id=".$stdId."'>".$img." ".$name."</a></td>
                  <td>".$row11['sign_in_time']."</td>
                  <td>".$row11['signed_in_by']." </td>
                  <td>".$row11['sign_out_time']."</td>
                   <td>".$row11['signed_out_by']."</td>
                   <td>".$diff."</td>
                    <td>";
               $attend_id=$row11['attendance_ID'];#send student id as a session to the next page of view student

                  echo' 

                  <button type="button" id="'.$attend_id.'" class="btn btn-primary badge"  onclick="editAttendance(this.id)" data-toggle="modal"  data-target="#edit_attendance_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                  <button type="button" id="'.$attend_id.'" class="btn btn-danger badge"  onclick="deleteAttendance(this.id)" data-toggle="modal"  data-target="#delete_attendance_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                  </td>
                  ';
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }
                  }else{
                    
                $attendanceDate= date("Y-m-d");
                    $query22 = mysqli_query($conn,"select * from attendance where school_ID = '".$school_ID."' and date_entered='".$attendanceDate."' ")or
                   die(mysqli_error());
                    while ($row11=mysqli_fetch_array($query22)){
                     $student_id=$row11['student_ID'];
                      $attendance_ID=$row11['attendance_ID'];
                     $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and student_ID='".$student_id."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                   
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                   $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row11['sign_in_time'];
                 $time_out=$row11['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff='';
                   if ($time_out !=='') {
                      $diff= $duration->format("%H:%I:%S");
                   }else{
                    $diff=' ';
                   }
              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'><a href='view_student.php?id=".$stdId."'>".$img." ".$name."</a></td>
                  <td>".$row11['sign_in_time']."</td>
                  <td>".$row11['signed_in_by']." </td>
                  <td>".$row11['sign_out_time']."</td>
                   <td>".$row11['signed_out_by']."</td>
                   <td>".$diff."</td>
                   
                  ";
                   $attend_id=$row11['attendance_ID'];#send student id as a session to the next page of view student

                  echo'<td> 

                 
                   <button type="button" id="'.$attend_id.'" class="btn btn-primary badge" onclick="editAttendance(this.id)" data-toggle="modal"  data-target="#edit_attendance_Modal"><span class="glyphicon glyphicon-pencil"></span></button>
                  <button type="button" id="'.$attend_id.'" class="btn btn-danger badge" onclick="deleteAttendance(this.id)" data-toggle="modal"  data-target="#delete_attendance_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                  </td>
                  ';
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }
                
                  }
                
                
               ?>
     
       </tbody>
               
             </table>
       
       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
        
        <!--end of edit parent modal-->
       
        

    
    </section>
    <!-- /.content -->
     <div class="modal  fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b></b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body text-center">
             <div class="row">
                 
               <div class="col-md-12">
                <form method="POST" action="attendance.php">
                <a href="attendance_signin.php" name="sign_in" class="btn btn-primary pull-center" id="button1">SIGN IN ATTENDANCE</a> 
              </form>
               </div>
             </div>
             <br>
             <br>
             <div class="row">
               <div class="col-md-12">
                <form method="POST" action="attendance.php">
                 <a href="attendance_signout.php" id="button1" name="sign_out" class="btn btn-primary ">SIGN OUT ATTENDANCE</a>
               </form>
               </div>
            </div>
        </div>
      </div>
    </div>
     </div>
     <!--edit attendance-->
<div class="modal  fade" id="edit_attendance_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content modal-sm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit </b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editAttendance(attendance_id){ 
                
                  if(attendance_id !=''){
                    var details= '&attendance_id='+ attendance_id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_attendance.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("attendMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("attendMessage").innerHTML=' You have Not Yet selected an item';
                  }
                 
                
                }
            </script>
          
          <div id="attendMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
  </div>

      <!-- delete attendace  Modal-->
    <div class="modal  fade" id="delete_attendance_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteAttendance(attendance_id){
                
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete this from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="manage_attendance.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ attendance_id +'" type="submit" data-dismiss="modal" onclick="deleteAttendanceFromSystem(this.id)">Delete</button></form></div>';
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
  function deleteAttendanceFromSystem(attendance_ID){
   
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&attendance_ID='+attendance_ID;
  $.ajax({
  type: "POST",
  url: "delete_attendance.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="manage_attendance.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>


</body>
</html>
