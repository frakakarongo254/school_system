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
        $school_ID = $_SESSION['login_user_school_ID'];
        $attendance=mysqli_query($conn,"insert into `attendance` (student_id, student_name, date_entered, date_modified, status,school_ID
          ) 
          values('$roll_no', '$student_name', '$date_created', '$date_modified', '$attendance_status','$school_ID') ");
       
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
              <div class="col-md-8"><b><h3>Attendance</h3> </b></div>
              
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
               
     
     
       
       <form action="" method="post">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Attendance</th>
                  
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   $x=0;
                   while ($row1=mysqli_fetch_array($query2)){
                    $x++;
                   $student_regNoID= $row1['registration_No'];
                   $status;
                   if($row1['status'] =='Inactive'){
                     $status='<span class="btn btn-danger">Inctive</span>';
                   }elseif ($row1['status'] =='Active') {
                      $status='<span class="btn btn-success">Inctive</span>';
                   }else{
                    $status='<span class="btn btn-success">Active</span>';
                   }
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $fullName=$row1['first_Name']." ". $row1['last_Name'];
                  echo" <tr>
                   <td>".$row1['registration_No']." <input type='hidden' name='roll_no[]'' value='".$row1['registration_No']."' /></td>
                  <td>".$img."</td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."<input type='hidden' name='student_name[]'' value='".$fullName."' /></td>";
                 
                echo'  <td>
                    <label for="present4">
                        <input type="radio" id="present'.$x.'" name="attendance_status['.$x.']" value="Present"> Present
                    </label>
                    <label for="absent4">
                        <input type="radio" id="absent'.$x.'" name="attendance_status['.$x.']" value="Absent"> Absent
                    </label>
                </td>
                 
                  </tr>';
                    }
                  ?>
               
               
                 </tbody>
               
              </table>
              <button type="submit" class=" btn btn-primary" href="#" name="saveAttendanceBtn" ><i class="fa fa-"></i><b> Control Attendace</b></button>
            </form>
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
