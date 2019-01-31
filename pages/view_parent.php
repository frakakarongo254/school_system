<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$get_parentID =$_GET['id'];
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
      <h1>
        Parent
       
      </h1>
     
     
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
         <div class="col-md-12 ">
          <?php
          $user_ID=$_SESSION['login_user_ID'];
            $ses_sql = mysqli_query($conn,"select * from `parents` where `parent_ID` = '".$get_parentID."' ");
              $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
              $row['first_Name'];
               $image;
             if($row['photo'] !=''){
              $image = '<img class=" profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"  height="40px" width="40px" alt="User profile picture"/>';
            }else{
                $image = "<img class=' profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' alt='User profile picture'>";
              }
          ?>
          <!-- Profile Image -->
          <div class="box box-primary ">
            <div class="box-body box-profile">

              <div class="row">
                <div class="col-md-6 ">\
                  <div class="pull-right">
                   <?php echo $image;?>

              <h3 class="profile-username text-center"><?php echo $row['first_Name'] ." ". $row['last_Name'];?></h3>
            </div>
                </div>
                <div class="col-md-6">
                  <table>
                  <tr>
                    <td><b>Phone:</b></td>
                    <td><?php echo $row['cell_Mobile_Phone']?></td>
                  </tr>
                  <tr>
                    <td><b>Email:</b></td>
                    <td><?php echo $row['email']?></td>
                  </tr>
                  <tr>
                    <td><b>Gender:</b></td>
                    <td><?php echo $row['gender_MFU']?></td>
                  </tr>
                 </table>
                </div>
              </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <h3><b>Children</b></h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Reg No</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['student_RegNo'];
                   #get student details
                   $query3 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && registration_No='$student_regNoID'")or
                   die(mysqli_error());
                   while ($row2=mysqli_fetch_array($query3)){
                    $img;
                   if($row2['photo'] !=''){
                    $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row2['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                    }
                    echo" <tr>
                           <td>
                            ".$img."
                           </td>
                            <td>".$row2['first_Name']." ". $row2['last_Name']."</td>
                            <td>".$row2['registration_No']." </td>
                            <td>".$row2['gender_MFU']."</td>
                            <td>Action</td>  
                            <td>";
                           echo'  <button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span></button>
                             <button type="button"  class="btn btn-info btn-flat" onclick="editStudentDetails()"><span class="glyphicon glyphicon-pencil"></span></button>
                             <button type="button" id="'.$row2['registration_No'].'" class="btn btn-danger btn-flat" value="'.$row2['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                           </td>
                         </tr>';

                   }
                  
                    }
                  ?>
               
                 </tbody>
                <tfoot>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    <!--- add student Modal -->
      <div class="modal fade" id="modal-addStudent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Admission</h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active col-md-5"><a href="#tab_1" data-toggle="tab"><b>Student</b></a></li>
                    <li  class="col-md-5"><a href="#tab_2" data-toggle="tab"><b>Parent/Guardian Details</b></a></li>
                    
                  </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <h3><b style="text-decoration: underline;">Student </b><hr class=""></h3>
              <form method="POST">
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
              <br>
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Nickname :</label>
                </div>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="student_nickname"  class="form-control"   placeholder="Nickname" required>
                </div>
              </div>
              <br>
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
              <br>
               <div class="row">
               
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Date Of Birth :</label>
                </div>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-birthday"></i></span>
                  <input type="date" name="student_dateOfBirth" class="form-control" placeholder="" required>
                </div>
                
              </div>
              <br>
              <br>
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Admission Date :</label>
                </div>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="student_admission_date" class="form-control" placeholder="" required>
                </div>
                
              </div>
              <br>
              <br>
               <div class="row">
                <div class="form-group col-md- mb-3">
                  <label for="nationality">Profile Photo :</label>
                              
               <input type="file"  class="form-control" name="student_profile_photo" required>
                </div>
                
              </div>
           
            
              <br>
              <br>
               <div class="row">
                <div class="form-group col-md- mb-3">
                  <label for="nationality">Healthy comment :</label>
                              
                 <textarea class="form-control" name="healthyComment" placeholder="Healthy comment" required></textarea>
                </div>
                
              </div>
           

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <h3><b style="text-decoration: underline;">Parent/Guardian </b><hr class=""></h3>
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
              <br>
               <div class="row">
                 <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Gender :</label>
                </div>
                <div class=" col-md- input-group input-group-">
                  <div class="form-group">
                  <label>
                    <input type="radio" name="parent_gender" class=" flat-red"  value="Male" checked>
                    <label>Male</label>
                  </label>
                  <label>
                    <input type="radio" name="parent_gender" class=" flat-red" value="Female">
                    <label>Female</label>
                  </label>
                
                </div>
                </div>
              </div>
              <br>
              <br>
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Email :</label>
              </div>
              <div class=" col-md- input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="parent_email" class="form-control" placeholder="" required>
              </div>
              
            </div>
            <br>
            <br>
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Phone :</label>
              </div>
              <div class=" col-md- input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="tel" name="parent_phone" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            <br>
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Address :</label>
              </div>
              <div class=" col-md- input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" name="parent_address" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            <br>
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Profession :</label>
              </div>
              <div class=" col-md- input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
                <input type="text" class="form-control" name="parent_profession" placeholder="Profession" required="">
              </div>    
            </div>
            <br>
            <br>
             <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Profile Photo :</label>
              </div>
              <div class=" col-md- input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="file" name="parent_profile_photo" class="form-control" placeholder="" value="Photo" required> 
              </div>    
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancle</button>
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Save changes</button>
              </div>
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
 window.location="children.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  

  }


  });
  }
</script>
</body>
</html>
