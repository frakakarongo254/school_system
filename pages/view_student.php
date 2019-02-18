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
                  <li class="active"><a href="#tab_1" data-toggle="tab">Student Classes</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Student Parents</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Documents</a></li>
                   <li><a href="#tab_4" data-toggle="tab">Student Statement</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Marks</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                            $ses_sql2 = mysqli_query($conn,"select * from `student` where `student_ID` = '".$student_ID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row2 = mysqli_fetch_array($ses_sql2,MYSQLI_ASSOC);
                          echo  $classid=$row2['class_ID'];
                              $class_sql2 = mysqli_query($conn,"select * from `class` where `class_ID` = '".$classid."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row3_class = mysqli_fetch_array($class_sql2 ,MYSQLI_ASSOC);

                               $levelId=$row3_class['level_ID'];
                                $streamid=$row3_class['stream_ID'];

                              $level_sql2 = mysqli_query($conn,"select * from `carricula_level` where `carricula_level_ID` = '".$levelId."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row4_level = mysqli_fetch_array($level_sql2 ,MYSQLI_ASSOC);
                             // $streamid=$row4_level['stream_ID'];

                             $stream_sql2 = mysqli_query($conn,"select * from `stream` where `stream_ID` = '".$streamid."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row4_stream = mysqli_fetch_array($stream_sql2 ,MYSQLI_ASSOC);
                               
                                echo" <tr>
                                       
                                        <td>".$row3_class['year']."</td>
                                        <td>".$row3_class['name']." </td>
                                         <td>".$row4_stream['stream_name']." </td>
                                        
                                          
                                        <td>";
                                       echo'   <a href="#"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  View</button></a>

                                        
                                       </td>
                                     </tr>';

                               
                              
                                
                              ?>
                           
                             </tbody>
                            <tfoot>
                            <tr>
                             <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
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
                      <div class="row">
              <div class="col-md-8"><b><h3>Documents</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" data-toggle="modal" data-target="#modal-addDocument"><i class="fa fa-plus"></i><b> New Document</b></a></div>
            </div>
                      <table id="example3" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>Document Title</th>
                              <th>Description</th>
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
                             <th>#</th>
                              <th>Document Title</th>
                              <th>Description</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
                    </div>
                    <div class="tab-pane" id="tab_4">
                         <table id="table11" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Date</th>
                              <th>Reference</th>
                              <th>Amount</th>
                              <th>Summary</th>
                              
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                               $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from invoice_student where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               while ($row2=mysqli_fetch_array($query2)){
                               $invoiveID= $row2['invoice_ID'];
                              // $parent_relation= $row1['relation'];
                               
                                echo" <tr>
                                       <td>".$row2['invoice_date']."</td>
                                       <td>".$row2['reff_no']."</td>
                                        <td>".$row2['amount']."</td>
                                        <td>".$row2['summury']." </td>
                                         
                                          
                                        <td>";
                                       echo'   <a href="#"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  View</button></a>

                                        
                                       </td>
                                     </tr>';

                               
                              
                                }
                              ?>
                           
                             </tbody>
                            
                          </table>
                    </div>
                </div>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   <!--- add document Modal -->
      <div class="modal fade" id="modal-addDocument">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Document</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="document.php" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>Title</label>
                 <input type="text" name="document_title" class="form-control" placeholder="Title" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea type="text" name="document_desc" class="form-control" placeholder="Description" maxlength="100"></textarea>
                
              </div>
              <div class="form-group">
                <label>Document</label>
                
                <input type="file" name="zone_name" class="form-control" placeholder="" required>
              </div>
           
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addDocumentBtn" class="btn btn-primary">Add Document</button>
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

  $(function () {
    $('#example3').DataTable()
    $('#example4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $(function () {
    $('#table1').DataTable()
    $('#table2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $(function () {
    $('#table11').DataTable()
    $('#table21').DataTable({
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
