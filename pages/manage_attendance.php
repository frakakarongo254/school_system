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
              <div class="col-md-3 pull-" style="text-align:">
                <input type="date" name="attendance_date" class="form-control" required>
              </div>
              <div class="col-md-3 col-" style="text-align:">
                <select class="form-control" name="status_type" >
                  <option value="All">All</option>
                  <option value="Present">Present</option>
                  <option value="Absent">Absent</option>
                </select>
              </div>
              <div class="col-md-3 col-" style="text-align:t">
                <button class="btn btn-primary" type="submit" name="searchAttendance" href="" ><i class="fa fa-eye"></i> Veiw Attendance</button>
              </div>
            </form>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
               <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th># Adm No</th>
                  <th>Sudent Name</th>
                  <th>Date</th>
                  <th>Attendance Status</th>
                  
                  
                </tr>
                </thead>
                <tbody>
               <?php
                if (isset($_POST['searchAttendance'])) {
                   $school_ID = $_SESSION['login_user_school_ID'];
                  $attendanceDate=$_POST['attendance_date'];
                  $status_type=$_POST['status_type'];
                  $attendance_class_id=$_POST['attendance_class_id'];
                 
               $query = mysqli_query($conn,"select * from student where student_ID='$attendance_class_id'  and school_ID='$school_ID ' ");
                  if ($status_type !="All") {
                   
                   $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id' and status='$status_type' and DATE(date_entered)='$attendanceDate' and school_ID='$school_ID ' ")or
                   die(mysqli_error());
                   if($attendance_query){
                    
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                    $query = mysqli_query($conn,"select * from student where student_ID='".$attendance_row['student_id']."'  and school_ID='$school_ID ' ");
                    while ($student_row=mysqli_fetch_array( $query)){
                      echo"<tr>
                       <td>".$student_row['registration_No']."</td>
                       <td> ".$attendance_row['student_name']."</td>
                       <td> ".$attendance_row['date_entered']."</td>
                       <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }
                 
                  }
                }else{
                  echo 'failed 1';
                }
                  }else{
                    $attendance_query = mysqli_query($conn,"select * from attendance where class_ID='$attendance_class_id' and DATE(date_entered)='$attendanceDate' and school_ID='$school_ID'")or
                   die(mysqli_error());
                   if($attendance_query){
                   while ($attendance_row=mysqli_fetch_array($attendance_query)){
                 $query = mysqli_query($conn,"select * from student where student_ID='".$attendance_row['student_id']."'  and school_ID='$school_ID ' ");
                    while ($student_row=mysqli_fetch_array( $query)){
                      echo"<tr>
                       <td>".$student_row['registration_No']."</td>
                       <td> ".$attendance_row['student_name']."</td>
                       <td> ".$attendance_row['date_entered']."</td>
                       <td> ".$attendance_row['status']."</td>
                    </tr>";
                    }
                   
                  }
                }else{
                  echo "Failed";
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
