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
    foreach ($_POST['attendance_status'] as $id => $attendance_status)
    {
        $roll_no = $_POST['roll_no'][$id];
        $student_name = $_POST['student_name'][$id];
        $date_created = date('Y-m-d H:i:s');
        $date_modified = date('Y-m-d H:i:s');
        $attendance=mysqli_query($conn,"insert into `attendance` (student_id, student_name, date_entered, date_modified, status
          ) 
          values('$roll_no', '$student_name', '$date_created', '$date_modified', '$attendance_status') ");
       
    }
     
    if ($attendance) {
      echo  $msg = "Attendance has been added successfully";
       echo '<script> window.location="attendance.php?insert=True" </script>';
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
                 $query_c= mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($crows=mysqli_fetch_array($query_c)){

                    $query_level= mysqli_query($conn,"select * from carricula_level where carricula_level_ID = '".$crows['level_ID']."' and school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($class_rows=mysqli_fetch_array($query_level)){
                          //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$crows['class_ID'].'">'.$class_rows['level_name'].''.$crows['name'].'</option>';
                   }
                 
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
                   $diff= $duration->format("%H:%I:%S");
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

                  <a class="btn btn-info badge" href="edit_students.php?id='.$attend_id.'"> <span class="glyphicon glyphicon-pencil"></span></a>

                  <button type="button" id="'.$row1['registration_No'].'" class="btn btn-danger badge" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
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
                   $diff= $duration->format("%H:%I:%S");
              // encryption function 

              
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

                  <a class="btn btn-info badge" href="edit_students.php?id='.$attend_id.'"> <span class="glyphicon glyphicon-pencil"></span></a>

                  <button type="button" id="'.$attend_id.'" class="btn btn-danger badge" value="'.$attend_id.'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
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
  function deleteParentFromSystem(parent_ID){
   
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&parent_ID='+ parent_ID;
  $.ajax({
  type: "POST",
  url: "delete_parent.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="parent.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
