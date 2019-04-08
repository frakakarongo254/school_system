<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
#get school Id from current session school id
 $school_ID = $_SESSION['login_user_school_ID'];
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
   $class_ID= $_POST['classID'];
    foreach ($_POST['attendance_status'] as $id => $attendance_status)
    {   
        $classID= $class_ID;
        $student_id = $_POST['studentID'][$id];
        $student_name = $_POST['student_name'][$id];
        $date_created = date('Y-m-d H:i:s');
        $date_modified = date('Y-m-d H:i:s');
        $school_ID = $_SESSION['login_user_school_ID'];
        $attendance=mysqli_query($conn,"insert into `attendance` (student_id, student_name,class_ID, date_entered, date_modified, status,school_ID
          ) 
          values('$student_id', '$student_name','$classID', '$date_created', '$date_modified', '$attendance_status','$school_ID') ");
       
    }
     
    if ($attendance) {
      echo  $msg = "Attendance has been added successfully";
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
              <form  method="POST" action="attendance.php">
              <div class="col-md-6">
                 <div class=" form-group">
                
                  <select class="form-control select2" name="attendance_class__id" style="width: 100%;" required>
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
              
              <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="searchAttendance">Search</button>
              </div>
             </form>
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
                  if (isset($_POST['searchAttendance'])) {
                   echo $classID=$_POST['attendance_class__id'];
                  
                     $query2 = mysqli_query($conn,"select * from student where class_ID =' $classID' and school_ID = '$school_ID'")or
                   die(mysqli_error());
                   $x=0;
                   while ($row1=mysqli_fetch_array($query2)){
                    $x ++;
                   $student_regNoID= $row1['registration_No'];
                  
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $fullName=$row1['first_Name']." ". $row1['last_Name'];

                  echo"  <input type='hidden' name='classID[]'' value='".$classID."' />
                  <tr>
                     
                   <td>".$row1['registration_No']." <input type='hidden' name='studentID[]'' value='".$row1['student_ID']."' /></td>
                  <td>".$img."</td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."<input type='hidden' name='student_name[]'' value='".$fullName."' /></td>";
                 
                echo' <td>
                    <label for="present4">
                        <input type="radio" id="present'.$x.'" name="attendance_status['.$x.']" value="Present"> Present
                    </label>
                    <label for="absent4">
                        <input type="radio" id="absent'.$x.'" name="attendance_status['.$x.']" value="Absent"> Absent
                    </label>
                </td>
                 
                  </tr>';
                    }
                    
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
