<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];
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
      <h1>
        
       
      </h1>
    
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Children</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Img</th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Gender</th>
                            <th>Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                             <?php
                             #get school Id from current session school id
                             $school_ID = $_SESSION['login_user_school_ID'];
                             $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
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
                                $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                              }
                              echo" <tr>
                                     <td>
                                      ".$img."
                                     </td>
                                      <td>".$row2['first_Name']." ". $row2['last_Name']."</td>
                                      <td>".$row2['registration_No']." </td>
                                      <td>".$row2['gender_MFU']."</td>  
                                      <td>";
                                     echo'   <a class="btn btn-success " href="view_children.php?id='.$row2['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span> view</a>
                                      
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
                            <th>Reg No</th>
                            
                            <th>Gender</th>
                            <th>Actions</th>
                          </tr>
                          </tfoot>
                        </table>
            </div>
            <!-- /.box-body -->
           
            
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
