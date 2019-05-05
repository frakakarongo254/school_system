<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
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
          Success! Staff added  successfully.
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
       if(isset($_POST['addStaffBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];

        #add staff Details
      $staff_no=$_POST['staff_no'];
      $staff_name=$_POST['staff_name'];
      $staff_role=$_POST['staff_role'];
      $staff_nationality=$_POST['staff_nationality'];
      $staff_phone=$_POST['staff_phone'];
      $staff_email=$_POST['staff_email'];
      $staff_gender=$_POST['staff_gender'];
         # check image
       if(isset($_FILES['staff_photo']['name']) and !empty($_FILES['staff_photo']['name'])){
           $file=$_FILES['staff_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["staff_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
             $staff_photo = addslashes(file_get_contents($_FILES['staff_photo']['tmp_name']));
            $staff_insert_query=mysqli_query($conn,"insert into `staff` (school_ID, 
          full_Name,staff_No,gender,email,phone,nationality,role,photo) 
          values('$school_ID','$staff_name','$staff_no','$staff_gender','$staff_email','$staff_phone','$staff_nationality','$staff_role','$staff_photo') ");
        if($staff_insert_query){
          
           echo '<script> window.location="staff.php?insert=True" </script>';
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
            $staff_insert_query=mysqli_query($conn,"insert into `staff` (school_ID, 
          full_Name,staff_No,gender,email,phone,nationality,role) 
          values('$school_ID','$staff_name','$staff_no','$staff_gender','$staff_email','$staff_phone','$staff_nationality','$staff_role') ");
        if($staff_insert_query){
          
           echo '<script> window.location="staff.php?insert=True" </script>';
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
      #edit staff
       if(isset($_POST['editStaffBtn'])){
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
      $edit_staff_ID=$_POST['edit_staff_ID'];
      $edit_staff_no=$_POST['edit_staff_no'];
      $edit_staff_name=$_POST['edit_staff_name'];
      $edit_staff_role=$_POST['edit_staff_role'];
      $edit_staff_nationality=$_POST['edit_staff_nationality'];
      $edit_staff_phone=$_POST['edit_staff_phone'];
      $edit_staff_email=$_POST['edit_staff_email'];
      $edit_staff_gender=$_POST['edit_staff_gender'];
        # check image   
       if(isset($_FILES['edit_staff_photo']['name']) and !empty($_FILES['edit_staff_photo']['name'])){
           $file=$_FILES['edit_staff_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["edit_staff_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
            $edit_staff_photo = addslashes(file_get_contents($_FILES['edit_staff_photo']['tmp_name']));
              $result_query=mysqli_query($conn,"update `staff` SET full_Name= '".$edit_staff_name."',email= '".$edit_staff_email."',phone= '".$edit_staff_phone."',nationality= '".$edit_staff_nationality."',gender= '".$edit_staff_gender."',role= '".$edit_staff_role."',staff_No= '".$edit_staff_no."',photo= '".$edit_staff_photo."' where `staff_ID`='".$edit_staff_ID."' and `school_ID`='".$school_ID."' ");
        if($result_query){
          echo '<script> window.location="staff.php?update=True" </script>';
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
            $result_query=mysqli_query($conn,"update `staff` SET full_Name= '".$edit_staff_name."',email= '".$edit_staff_email."',phone= '".$edit_staff_phone."',nationality= '".$edit_staff_nationality."',gender= '".$edit_staff_gender."',role= '".$edit_staff_role."',staff_No= '".$edit_staff_no."' where `staff_ID`='".$edit_staff_ID."' and `school_ID`='".$school_ID."' ");
        if($result_query){
          
           echo '<script> window.location="staff.php?update=True" </script>';
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

      #link parent with student 
      if(isset($_POST['linkStudentBtn'])){
        $school_ID = $_SESSION['login_user_school_ID'];
        $link_student_ID= $_POST['link_studentID'];
        $link_parentID=$_POST['link_parentID'];
        $relation =$_POST['relation'];
        $link_insert_query=mysqli_query($conn,"insert into `parent_relation` ( parent_ID,school_ID,student_ID,relation) 
          values('$link_parentID','$school_ID','$link_student_ID','$relation') ");
        if($link_insert_query){
           echo '<script> window.location="parent.php?link=True" </script>';
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
              <div class="col-md-8"><b><h3>Staffs</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" data-toggle="modal" data-target="#modal-addParent"><i class="fa fa-plus"></i><b> New Teacher</b></a></div>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
               
     
     
       
       
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from staff where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $staff_ID= $row1['staff_ID'];
                   $img;
                   if($row1['photo'] !=''){
                    $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                    }
                  echo" <tr>
                           <td>
                             ".$img."
                           </td>
                            <td>".$row1['full_Name']."</td>
                            <td>".$row1['email']." </td>
                             <td>".$row1['phone']."</td> 
                            <td>".$row1['gender']."</td>
                            <td>".$row1['role']."</td>
                             
                            <td>";
                           echo'  <a href="view_staff.php?id='.$staff_ID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span></button></a>
                             <button type="button"  class="btn btn-info btn-flat" id="'.$staff_ID.'" onclick="editStaffDetails(this.id)" data-toggle="modal" data-target="#modal-editStaff"><span class="glyphicon glyphicon-pencil"></span></button>
                             <button type="button" id="'.$row1['staff_ID'].'" class="btn btn-danger btn-flat" value="'.$row1['full_Name'].'" onclick="deleteStaff(this.id,this.value)" data-toggle="modal"  data-target="#delete_staff_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                            
                           </td>
                         </tr>';
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
    <!--- add teacher Modal -->
      <div class="modal fade" id="modal-addParent">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header btn-secondary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>New Staff</b></h4>
              </div>
               <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="staff.php" method="POST" enctype="multipart/form-data">
        
            <div class="form-group">   
              <label for="nationality">Full Name:</label>
                <input type="text" class="form-control" name="staff_name" placeholder="First Middle Last">  
            </div>
            <div class="form-group">   
              <label for="nationality">Staff No:</label>
                <input type="text" class="form-control" name="staff_no" placeholder="Staff No">  
            </div>
             <div class="form-group">
                <label>Role</label>
                <select class="form-control select2" name="staff_role" style="width: 100%;">
                 
                  <option value="">Role</option>
                  <option value="Admin">Admin</option>
                  <option value="Teacher">Teacher</option>
                  <option value="Staff">Staff</option>
                  
                </select>
              </div>
             <div class="form-group">   
              <label for="nationality">Nationality:</label>
                 <select class="form-control select2" name="staff_nationality" style="width: 100%;">
                  <?php  include("include/nationality.php");?>
                 </select>
            </div>
            
             <div class="form-group">
                <label>Gender</label>
                <select class="form-control select2"  name="staff_gender" style="width: 100%;">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                 
                </select>
              </div>
              <div class="form-group">   
              <label for="nationality">Phone:</label>  

                  <input type="tel" class="form-control" name="staff_phone" >
            </div>
            <div class="form-group">   
              <label for="nationality">Email:</label>
                <input type="email" class="form-control" name="staff_email" placeholder="Email">  
            </div>
             <div class="form-group">   
              <label for="nationality">Photo:</label>
                <input type="file" class="form-control" name="staff_photo" placeholder="photo">  
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addStaffBtn" class="btn btn-primary">Add Staff</button>
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
         <!--Edit staff model-->
         
      <div class="modal fade" id="modal-editStaff">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Staff</h4>
              </div>
              <div class="modal-body">
                <script >
                function editStaffDetails(staff_ID){
               
                var updiv = document.getElementById("editMessage"); //document.getElementById("highodds-details");
                //alert(id);
                var details= '&staff_ID='+ staff_ID;
                $.ajax({
                type: "POST",
                url: "edit_staff.php",
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
        <!--end of edit staff modal-->
       
         <!-- delete staff  Modal-->
    <div class="modal  fade" id="delete_staff_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Staff?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteStaff(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteStaffFromSystem(this.id)">Delete</button></form></div>';
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
  function deleteStaffFromSystem(staff_ID){
   
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&staff_id='+ staff_ID;
  $.ajax({
  type: "POST",
  url: "delete_staff.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="staff.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
