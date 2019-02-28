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
          Success! Student added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Updated successfully.
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
       // $student_profile_photo = addslashes(file_get_contents($_FILES['student_profile_photo']['tmp_name']));
        
        
         
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
  
        $student_first_name=$_POST['student_first_name'];
        $student_last_name=$_POST['student_last_name'];
        $student_nickname=$_POST['student_nickname'];
        $student_regNo;
        $student_dateOfBirth=$_POST['student_dateOfBirth'];
        $student_admission_date=$_POST['student_admission_date'];
        $student_gender=$_POST['student_gender'];
        $student_class=$_POST['student_class'];
        $healthyComment=$_POST['healthyComment'];
        $Student_zone=$_POST['student_zone'];
        $zoneChargeType=$_POST['zoneChargeType'];
        #generate student Reg no based on the last regno from the database 
       $get_last_RegNo_query= mysqli_query($conn,"select * from `student` where `school_ID` ='".$school_ID."'");
       $get_last_RegNo=mysqli_num_rows ( $get_last_RegNo_query );
       $lastRegNo = $get_last_RegNo + 1;
       #make sure the new reg no does not exist from the database
      
        if($lastRegNo < 9){
          $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/000'.$lastRegNo;
       }elseif ($lastRegNo < 99) {
         $datetime = date_create()->format('Y');
         $student_regNo= $datetime.'/00'.$lastRegNo;
       }elseif ($lastRegNo > 99) {
         $datetime = date_create()->format('Y');
          $student_regNo= $datetime.'/0'.$lastRegNo;
       }

        # check image
       if(isset($_FILES['student_profile_photo']['name']) and !empty($_FILES['student_profile_photo']['name'])){
         echo  $file=$_FILES['student_profile_photo']['name'];
             $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

          if ($_FILES["student_profile_photo"]["size"] > 500000) {
          echo "<script>alert('Sorry, your file is too large.')</script>";
          $uploadOk = 0;
          }
          elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
          && $extension != "gif" ) {
          echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
          $uploadOk = 0;
          }else{
            $student_profile_photo = addslashes(file_get_contents($_FILES['student_profile_photo']['tmp_name']));
             $sudent_insert_query=mysqli_query($conn,"insert into `student` (first_Name,last_Name,nickname,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,photo,class,zone,zone_transport_type) values('$student_first_name','$student_last_name','$student_nickname','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_profile_photo','$student_class','$Student_zone','$zoneChargeType') ");
        if($sudent_insert_query){
          
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
        }else{
           $sudent_insert_query=mysqli_query($conn,"insert into `student` (first_Name,last_Name,nickname,
          registration_No,school_ID,admission_date,date_of_Birth,other_Details,gender_MFU,class,zone,zone_transport_type) values('$student_first_name','$student_last_name','$student_nickname','$student_regNo','$school_ID','$student_admission_date', '$student_dateOfBirth','$healthyComment',
          '$student_gender','$student_class','$Student_zone','$zoneChargeType') ");
        if($sudent_insert_query){
          
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



      #edit student details
      if(isset($_POST['editStudentBtn'])){
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];

        $edit_student_first_name=$_POST['edit_student_first_name'];
        $edit_student_last_name=$_POST['edit_student_last_name'];
        $edit_student_nickname=$_POST['edit_student_nickname'];
        $edit_student_regNo=$_POST['edit_student_RegNo'];
        $edit_student_dateOfBirth=$_POST['edit_student_dateOfBirth'];
        $edit_student_admission_date=$_POST['edit_student_admission_date'];
        $edit_student_gender=$_POST['edit_student_gender'];
        $edit_healthyComment=$_POST['edit_healthyComment'];
        $edit_status=$_POST['status'];
       $edit_Student_zone=$_POST['edit_student_zone'];
        $edit_zoneChargeType=$_POST['edit_zoneChargeType'];
       
        $result_query=mysqli_query($conn,"update `student` SET first_Name= '".$edit_student_first_name."',last_Name= '".$edit_student_last_name."',nickname= '".$edit_student_nickname."',date_of_Birth='".$edit_student_dateOfBirth."',gender_MFU='".$edit_student_gender."',other_Details='".$edit_healthyComment."',admission_date='".$edit_student_admission_date."',status='".$edit_status."',zone='".$edit_Student_zone."',zone_transport_type='".$edit_zoneChargeType."' where `registration_No`='".$edit_student_regNo."' and `school_ID`='".$school_ID."' ");

        if($result_query){
           echo '<script> window.location="student.php?update=True" </script>';
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
            <div class="box">
            <div class="box-header">
             <div class="row">
              <form  method="POST" action="fee.php">
              <div class="col-md-3">
                 <div class=" form-group">
                
                  
                  <select class="form-control select2" onchange="checkSubject(this.value)" name="attendance_class__id"  id="attendance_class__id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                  <?php
                 $query_c= mysqli_query($conn,"select * from class ");
                   while ($crows=mysqli_fetch_array($query_c)){

                          //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$crows['class_ID'].'">'.$crows['name'].'</option>';
                   
                 
                   }
                ?>
                 </select>
                </div>
              </div>
             
              
              <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="searchAttendance"><i class="fa fa-search"></i> Search</button>
              </div>
             </form>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
        <!-- Custom Tabs -->
          
         
            
                 <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Fees</th>
                  <th>Balance</th>
                  <th>Class</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                  echo $student_id= $row1['student_ID'];
                   $student_class_id= $row1['class_ID'];
                   #Select fees details of the student
                   $query3 = mysqli_query($conn,"select * from invoice where  student_ID='$student_id' and school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row2=mysqli_fetch_array($query3)){
                    $invoiceID =$row2['invoice_ID'];
                    $invoice_amount =$row2['amount'];
                    $invoice_balance =$row2['balance'];

                    #select class name of the student
                    $qr2 = mysqli_query($conn,"select name from class where  class_ID='$student_class_id' and school_ID = '$school_ID'");
                     $class_row = mysqli_fetch_array($qr2,MYSQLI_ASSOC);
                     $class_name = $class_row['name'];


                 
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                  echo" <tr>
                  <td>".$img."</td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$invoice_amount." </td>
                  <td>". $invoice_balance."</td>  
                  <td>".$class_name."</td>
                  <td>";
             
                  echo'  <a class="btn btn-success btn-flat" href="view_student.php?id='.$row1['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span></a>

                  <a class="btn btn-info" href="edit_students.php?id='.$row1['student_ID'].'"> <span class="glyphicon glyphicon-pencil"></span></a>

                  <button type="button" id="'.$row1['registration_No'].'" class="btn btn-danger btn-flat" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
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
                  <th>Fees</th>
                  <th>Balance</th>
                  <th>Class</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
              
         
       </div>

        <!--Edit student model-->
         
      <div class="modal fade" id="modal-editStudent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Student</h4>
              </div>
              <div class="modal-body">
                <script >
                function editStudentDetails(RegNo){
               
                var updiv = document.getElementById("editMessage"); //document.getElementById("highodds-details");
                //alert(id);
                var details= '&RegNo='+ RegNo;
                $.ajax({
                type: "POST",
                url: "edit_student.php",
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
        <!--end of edit student modal-->
       
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
  function editStudentDetails(RegNo){
               
                var updiv = document.getElementById("editMessage"); //document.getElementById("highodds-details");
                //alert(id);
                var details= '&RegNo='+ RegNo;
                $.ajax({
                type: "POST",
                url: "edit_student.php",
                data: details,
                cache: false,
                success: function(data) {
               
                document.getElementById("editMessage").innerHTML=data;
                 }
                });
                }
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
