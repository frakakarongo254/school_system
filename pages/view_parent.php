<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$get_parentID='';
if(isset($_GET['id'])){
  $get_parentID =$_GET['id'];
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
        <b>Parent</b>
       
      </h1>
     <?php
     if(isset($_GET['id']) and isset($_GET['unlink'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have unlink the student  successfully.
          </div>';   
        }
        ?>
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
                <div class="col-md-6 ">
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
            
            
            <!-- /.box-header -->
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Children</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Emails</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Bills</a></li>
                   
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                         <table id="example3" class="table table-bordered table-striped">
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
                             $student_ID= $row1['student_ID'];
                             #get student details
                             $query3 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$student_ID'")or
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
                                     echo'   <a class="btn btn-success btn-flat" href="view_student.php?id='.$row2['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span></a>
                                       <button type="button" id="'.$row2['student_ID'].'" class="btn btn-danger btn-flat" value="'.$row1['parent_ID'].'" onclick="delinkStudent(this.id,this.value)" data-toggle="modal"  data-target="#delink_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <div class="tab-pane " id="tab_2">
                      <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Send on</th>
                            <
                          </tr>
                          </thead>
                          <tbody>
                             
                         
                           </tbody>
                          <tfoot>
                          <tr>
                           
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane " id="tab_3">
                    </div>

                  </div>
                </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
       
         <!-- unlink student  Modal-->
    <div class="modal  fade" id="delink_student_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Unlink this student?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function delinkStudent(student_id,parent_ID){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to unlink this student from  parent/Guardian?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="'+parent_ID+'" id="'+ student_id +'" type="submit" data-dismiss="modal" onclick="delinkStudentFromParent(this.id,this.name)">Delete</button></form></div>';
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
  function delinkStudentFromParent(student_ID,parent_ID){
    //alert(parent_ID);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&student_ID='+ student_ID;
  $.ajax({
  type: "POST",
  url: "unlink_student_parent.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location='view_parent.php?id='+parent_ID+'&unlink=True' 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  

  }


  });
  }
</script>
</body>
</html>
