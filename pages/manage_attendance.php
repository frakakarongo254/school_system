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
    <!--- add parent Modal -->
      <div class="modal fade" id="modal-addParent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>New Parent</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
                   <form id="fileinfo" name="fileinfo" action="parent.php" method="POST" enctype="multipart/form-data">
                <div class="row">
              <div class=" col-md-6 mb-3">
                <div class="form-group has-feedback input-group-lg">
                      <label>First Name :</label>
               <div class=" col-md- input-group input-group-">
                <input type="text" name="parent_first_name"  class="form-control"   placeholder="First Name" required>
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
              </div>
              </div>
              <div class=" col-md-6 mb-3">
               <div class="form-group has-feedback input-group-">
                      <label>Last Name :</label>
               <div class=" col-md- input-group input-group">              
                <input type="text" name="parent_last_name"  class="form-control"   placeholder="Last Name" required>
                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
              </div>
              </div>            
            </div>
              <br>
              <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Gender:</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-gender"></i></span>
                
                <select name="parent_gender" class="form-control">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              
            </div>
               
              <br>
             
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Email :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="parent_email" class="form-control" placeholder="" required>
              </div>
              
            </div>
            <br>
           
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="phone">Phone :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="tel" name="parent_phone" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="address">Address :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" name="parent_address" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
              <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Nationality:</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                <input type="text" name="parent_nationality" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="profession">Profession :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
                <input type="text" class="form-control" name="parent_profession" placeholder="Profession" required="">
              </div>    
            </div>
            <br>
            
             <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Profile Photo :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="file" name="parent_profile_photo" class="form-control" placeholder="" value="Photo" required> 
              </div>    
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Add parent</button>
              </div>
              </div>
          
              <!-- /.tab-pane -->
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
         <!--Edit parent model-->
         
      <div class="modal fade" id="modal-editParent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Parent</h4>
              </div>
              <div class="modal-body">
                <script >
                function editParentDetails(parent_ID){
               
                var updiv = document.getElementById("editMessage"); //document.getElementById("highodds-details");
                //alert(id);
                var details= '&parent_ID='+ parent_ID;
                $.ajax({
                type: "POST",
                url: "edit_parent.php",
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
        <!--end of edit parent modal-->
       
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
