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
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have updated  successfully.
          </div>';   
        }
       if(isset($_POST['save_admissionBtn'])){
        
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
         $parent_nationality=$_POST['parent_nationality'];
         $parent_password=$_POST['parent_password'];
        #generate parent ID based on phone
        $rand = substr(number_format(time() * rand(),0,'',''),0,10);
        $parent_ID= md5($rand);
         # check image
       if(isset($_FILES['parent_profile_photo']['name']) and !empty($_FILES['parent_profile_photo']['name'])){
           $file=$_FILES['parent_profile_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["parent_profile_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
             $parent_profile_photo = addslashes(file_get_contents($_FILES['parent_profile_photo']['tmp_name']));
            $parent_insert_query=mysqli_query($conn,"insert into `parents` ( parent_ID,school_ID, 
          first_Name,last_Name,address,cell_Mobile_Phone,email,gender_MFU,profession,photo,nationality,password) 
          values('$parent_ID','$school_ID','$parent_first_name','$parent_last_name','$parent_address','
          $parent_phone','$parent_email','$parent_gender','$parent_profession','$parent_profile_photo','$parent_nationality','$parent_password') ");
        if($parent_insert_query){
          
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
        }else{
            $parent_insert_query=mysqli_query($conn,"insert into `parents` ( parent_ID,school_ID, 
          first_Name,last_Name,address,cell_Mobile_Phone,email,gender_MFU,profession,nationality,password) 
          values('$parent_ID','$school_ID','$parent_first_name','$parent_last_name','$parent_address','
          $parent_phone','$parent_email','$parent_gender','$parent_profession','$parent_nationality','$parent_password') ");
        if($parent_insert_query){
          
           echo '<script> window.location="student.php?insert=True" </script>';
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
      #edit parent
       if(isset($_POST['edit_parentBtn'])){
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];

        # parent/Guardian Details
        $edit_parent_first_name=$_POST['edit_parent_first_name'];
        #hidden input from edit form
        $edit_parent_ID=$_POST['edit_parent_ID'];
        $edit_parent_last_name=$_POST['edit_parent_last_name'];
        $edit_parent_email=$_POST['edit_parent_email'];
        $edit_parent_phone=$_POST['edit_parent_phone'];
        $edit_parent_address=$_POST['edit_parent_address'];
        $edit_parent_profession=$_POST['edit_parent_profession'];
        $edit_parent_gender=$_POST['edit_parent_gender'];
        $edit_parent_nationality=$_POST['edit_parent_nationality'];
        $edit_parent_password=$_POST['edit_parent_password'];
        # check image
       if(isset($_FILES['edit_parent_profile_photo']['name']) and !empty($_FILES['edit_parent_profile_photo']['name'])){
           $file=$_FILES['edit_parent_profile_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["edit_parent_profile_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
          $edit_parent_profile_photo = addslashes(file_get_contents($_FILES['edit_parent_profile_photo']['tmp_name']));
          $result_query=mysqli_query($conn,"update `parents` SET first_Name= '".$edit_parent_first_name."',last_Name= '".$edit_parent_last_name."',email= '".$edit_parent_email."',address='".$edit_parent_address."',gender_MFU='".$edit_parent_gender."',profession='".$edit_parent_profession."',photo='".$edit_parent_profile_photo."',nationality='".$edit_parent_nationality."',password='". $edit_parent_password."' where `parent_ID`='".$edit_parent_ID."' and `school_ID`='".$school_ID."' ");
          if($result_query){
          echo '<script> window.location="parent.php?update=True" </script>';
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
            $result_query=mysqli_query($conn,"update `parents` SET first_Name= '".$edit_parent_first_name."',last_Name= '".$edit_parent_last_name."',email= '".$edit_parent_email."',address='".$edit_parent_address."',gender_MFU='".$edit_parent_gender."',profession='".$edit_parent_profession."',nationality='".$edit_parent_nationality."', password='". $edit_parent_password."' where `parent_ID`='".$edit_parent_ID."' and `school_ID`='".$school_ID."' ");
        if($result_query){
          
           echo '<script> window.location="parent.php?update=True" </script>';
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
              <div class="col-md-8"><b><h3>Parents</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" id="button1" data-toggle="modal" data-target="#modal-addParent"><i class="fa fa-plus"></i><b> New Parent</b></a></div>
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
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
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
                            $_SESSION['parent_ID'] = $parentID; #send this id to the view parent  page as a session to use there 
                           echo'  <a href="view_parent.php?id='.$parentID.'"><button type="button"  class="btn btn-success badge" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span></button></a>

                             <button type="button"  class="btn btn-info badge" id="'.$parentID.'" onclick="editParentDetails(this.id)" data-toggle="modal" data-target="#modal-editParent"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$row1['parent_ID'].'" class="btn btn-danger badge" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_parent_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                             <button type="button" class="btn btn-secondary " data-toggle="modal" data-target="#link_student_Modal" id="'.$row1['parent_ID'].'" onclick=showLinkparentID(this.id) ><a href="#"> Link Student</a></button>
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
              <div class="col-md-7 input-group input-group">
                        <label>Gender:</label>
                 <div class=" col-md- input-group input-group">              
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
                <label for="nationality">Email:</label>
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
                <label for="phone">Password :</label>
              </div>
              <div class=" col-md-7 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="Password" name="parent_password" class="form-control" placeholder="" required>
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
             
                <select class="form-control select2" name="parent_nationality" style="width: 100%;" required="">
                  <?php  include("include/nationality.php");?>
                 </select>
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
                <button type="submit" name="save_admissionBtn" class="btn btn-primary">Save parent</button>
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
