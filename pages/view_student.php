<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$student_ID="";
if(isset($_GET['id'])){
  $student_ID =$_GET['id'];
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
   

    <!-- Main content -->
    <section class="content ">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
         <div class="col-md-12 ">

          <?php
          $user_ID=$_SESSION['login_user_ID'];
            $ses_sql = mysqli_query($conn,"select * from `student` where `student_ID` = '".$student_ID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
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
                <div class="col-md-6 ">
                 <b class="pull-left" style="font-size: 20px">Student</b>
                  <div class="pull-right">
                   <?php echo $image;?>

              <h3 class="profile-username text-center"><?php echo $row['first_Name'] ." ". $row['last_Name'];?></h3>
            </div>
                </div>
                <div class="col-md-6">
                  <table>
                  <tr>
                    <td><span style="font-size: 17px">Adm:</span></td>
                    <td><b><?php echo $row['registration_No']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Gender:</span></td>
                    <td><b><?php echo $row['gender_MFU']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Nationality:</span></td>
                    <td><b><?php echo $row['nationality']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Date of Birth:</span></td>
                    <td><b><?php echo $row['date_of_Birth']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Admission Date:</span></td>
                    <td><b><?php echo $row['admission_date']?></b></td>
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
             <h3><b></b></h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Document</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Student Parents</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Marks</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                   hhjjj
                    </div>
                    <div class="tab-pane" id="tab_2">
                           <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Img</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Relation</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                               $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               while ($row1=mysqli_fetch_array($query2)){
                               $parentID= $row1['parent_ID'];
                               $parent_relation= $row1['relation'];
                               #get student details
                               $query3 = mysqli_query($conn,"select * from parents where school_ID = '$school_ID' && parent_ID='$parentID'")or
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
                                        <td>".$row2['cell_Mobile_Phone']." </td>
                                         <td>".$row2['email']." </td>
                                        <td>".$row2['gender_MFU']."</td>
                                        <td>". $parent_relation."</td>
                                          
                                        <td>";
                                       echo'   <a href="view_parent.php?id='.$parentID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  View</button></a>

                                        
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
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Relation</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
                    </div>
                     <div class="tab-pane" id="tab_3">
                      gggggg
                    </div>
                </div>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
       
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
