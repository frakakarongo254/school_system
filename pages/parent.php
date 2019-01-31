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
      <h1>
        Parents
       
      </h1>
     
      <ol class="breadcrumb">
       
        <li class=""><a class="btn btn-success btn-sm" href="login.html" data-toggle="modal" data-target="#modal-addStudent" style="color: #fff"><i class="fa fa-plus"></i> <b>New Parent</b></a></li>
      </ol>
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! parent added  successfully.
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
       if(isset($_POST['save_admissionBtn'])){
        $parent_profile_photo = addslashes(file_get_contents($_FILES['parent_profile_photo']['tmp_name']));
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];

        # parent/Guardian Details
        $parent_first_name=$_POST['parent_first_name'];
        $parent_last_name=$_POST['parent_last_name'];
        $parent_email=$_POST['parent_email'];
        $parent_phone=$_POST['parent_phone'];
        $parent_address=$_POST['parent_address'];
        $parent_profession=$_POST['parent_profession'];
        $parent_gender=$_POST['parent_gender'];
        #generate parent ID based on phone
        $rand = substr(number_format(time() * rand(),0,'',''),0,10);
        $parent_ID= md5($rand);

       
        $sudent_insert_query=mysqli_query($conn,"insert into `parents` ( parent_ID,school_ID, 
          first_Name,last_Name,address,cell_Mobile_Phone,email,gender_MFU,profession,photo) 
          values('$parent_ID','$school_ID','$parent_first_name','$parent_last_name','$parent_address','
          $parent_phone','$parent_email','$parent_gender','$parent_profession','$parent_profile_photo') ");

        
        if($sudent_insert_query){
           echo '<script> window.location="parent.php?insert=True" </script>';
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

      #link parent with student 
      if(isset($_POST['linkStudentBtn'])){
        $school_ID = $_SESSION['login_user_school_ID'];
        $link_student_RegNo= $_POST['link_studentID'];
        $link_parentID=$_POST['link_parentID'];
        $relation =$_POST['relation'];
        $link_insert_query=mysqli_query($conn,"insert into `parent_relation` ( parent_ID,school_ID,student_RegNo,relation) 
          values('$link_parentID','$school_ID','$link_student_RegNo','$relation') ");
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
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from parents where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $parentID= $row1['parent_ID'];
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
                            <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                            <td>".$row1['email']." </td>
                             <td>".$row1['cell_Mobile_Phone']."</td> 
                            <td>".$row1['gender_MFU']."</td>
                             
                            <td>";
                           echo'  <a href="view_parent.php?id='.$parentID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span></button></a>
                             <button type="button"  class="btn btn-info btn-flat" onclick="editStudentDetails()"><span class="glyphicon glyphicon-pencil"></span></button>
                             <button type="button" id="'.$row1['parent_ID'].'" class="btn btn-danger btn-flat" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                             <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#link_student_Modal" id="'.$row1['parent_ID'].'" onclick=showLinkparentID(this.id) ><a href="#"> Link Student</a></button>
                           </td>
                         </tr>';
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
                
                <input type="text" class="form-control" id="searchStudent" name="searchStudent" placeholder="Enter Student Reg No" required="">
                 <input type="hidden" class="form-control" id="parentIDVal" name="parentIDVal" placeholder="Sudent Reg No" required="">
                <span class="input-group-addon"><button type="button" class="btn btn-success" onclick="searchStudentFunc()"><i class="fa fa-search"></i>Search</button></span>
              </div>
              </form>  
            <script >
             function showLinkparentID(link_parentID){
              
              document.getElementById("parentIDVal").value=link_parentID;
             }
               function searchStudentFunc(){ 
                var RegNo = document.getElementById("searchStudent").value;
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
 window.location="student.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
