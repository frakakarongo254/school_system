<?php // error_reporting(0); 
 require_once("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 #get school Id from current session school id
  $school_ID = $_SESSION['login_user_school_ID'];
if(isset($_POST["Export"])){
     //echo "yes";
    // $filename = "members_" . date('Y-m-d') . ".csv";
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('registration_No','first_Name','last_Name','gender_MFU','nationality','zone','zone_transport_type','status','class_ID','admission_date','date_of_Birth','other_Details','meal_plan'));  
      $queryz = "SELECT registration_No,first_Name,last_Name,gender_MFU,nationality,zone,zone_transport_type,status,class_ID,admission_date,date_of_Birth,other_Details,meal_plan from student where school_ID='".$school_ID."' ORDER BY id ASC";  
      $resultz = mysqli_query($conn, $queryz);  
      
      while($rowz = mysqli_fetch_assoc($resultz))  
      {  
         
           fputcsv($output, $rowz);  
      }  
      fclose($output);  
      //return ob_get_clean();
    exit();
 }  
?>
<?php


 if(isset($_POST["importBtn"])){
    
    $filename=$_FILES["importFile"]["tmp_name"];    


     if($_FILES["importFile"]["size"] > 0)
     {
        $file = fopen($filename, "r");
        $count = 0;
         $x=0;
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {

             $count++; 
            if($count>1)
            { 
                
            
            $x++;
              $randstd = substr(number_format(time() * rand(),0,'',''),0,10 + $x);
              $student_ID=md5($randstd);
              $registration_No = mysqli_real_escape_string($conn,$getData[0]);
              $first_Name = mysqli_real_escape_string($conn,$getData[1]);
              $last_Name = mysqli_real_escape_string($conn,$getData[2]);
              $gender_MFU = mysqli_real_escape_string($conn,$getData[3]);
              $nationality = mysqli_real_escape_string($conn,$getData[4]);
              $zone = mysqli_real_escape_string($conn,$getData[5]);
              $zone_transport_type = mysqli_real_escape_string($conn,$getData[6]);
              $status = mysqli_real_escape_string($conn,$getData[7]);
              $class_ID = mysqli_real_escape_string($conn,$getData[8]);
              $adm_date = mysqli_real_escape_string($conn,$getData[9]);
               $admission_date= date("Y-m-d", strtotime($adm_date));
              
              $date_Birth = mysqli_real_escape_string($conn,$getData[10]);
               $date_of_Birth = date("Y-m-d", strtotime($date_Birth));
              $other_Details = mysqli_real_escape_string($conn,$getData[11]);
              $meal_plan = mysqli_real_escape_string($conn,$getData[12]);
                        
             $sql = "INSERT into student (student_ID,school_ID,registration_No,first_Name,last_Name,gender_MFU,nationality,zone,zone_transport_type,status,class_ID,admission_date,date_of_Birth,other_Details,meal_plan) 
                   values ('".$student_ID."','".$school_ID."','".$registration_No."','".$first_Name."','".$last_Name."','".$gender_MFU."','".$nationality."','".$zone."','".$zone_transport_type."','". $status."','".$class_ID."','".$admission_date."','". $date_of_Birth."','".$other_Details."','".$meal_plan."')";
                   $result = mysqli_query($conn, $sql);


        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"student.php\"
              </script>"; 
              //mysql_error()  
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"student.php\"
          </script>";
        }
           }
         }
      
           fclose($file); 
     }
  }  


 ?>

<?php require_once("include/header.php")?>

<body class="hold-transition skin-cadetblue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php
  require_once("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
  require_once("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
 <section class="content-header">
     <?php
      #delete All student
      if (isset($_POST['deleteAllbutton'])) {
        # code...
        echo "kihiko";
        if (!empty($_POST['check'])) {
          # code...
        
    for($i = 0; $i<count($_POST['check']); $i++)  
     {  
      echo $studentID=$_POST['check'][$i];
      }
        }
       
        
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
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
   
        <!-- Custom Tabs -->
          <div class="nav-tabs-custom" style="padding-right: 20px;padding-left: 20px">
           <div class="row">
              <div class="col-md-4"><b style="text-transform: uppercase;color:#27AE60"><h3><strong>Students</strong> </h3> </b></div>
              <div class="col-md-2">
               
                <div id="deleteAll" style="display:none">
                <br>
                
                  <button type="submit" class="btn" id="button1" style="color:#fff;background-color:#D02E0B;" data-toggle="modal" data-target="#modal-deleteCheckedStudent">Delete</button>

                
              </div>
              </div>
              <div class="col-md-2">
                <br>
                <form action="" method="POST">
                  <button type="submit" class="btn" id="button1" style="color:#fff" name="Export" onclick="">Export</button>

                </form>
              </div>
              <div class="col-md-2">
                <br>
                <button href="#" class="btn" id="button2" style="color:#fff" data-toggle="modal" data-target="#modal-importStudent">Import</button>
              </div>
              <div class="col-md-2 col-pull-right" style="text-align:right">
                <br>
                <a class="btn btn-primary btn-bg" id="button1" href="add_student.php" style="  "><i class="fa fa-plus"></i><b> New Student </b></a>
              
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr style="background-color: red;font-size: 20px;">
              </div>
            </div>
            
                 <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><label>
            <input type="checkbox" id="select_all" class="" onchange="deleteCheckbox()" style="width: 15px;height: 15px;background-color: red"> All
          </label></th>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Class Room</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                    $stdId=$row1['student_ID'];
                    $classId=$row1['class_ID'];

                    $select_class= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.school_ID = '".$_SESSION['login_user_school_ID']."' and class.class_ID='".$classId."'");
                    foreach ($select_class as $row3_class) {
                       $student_regNoID= $row1['registration_No'];
                   $status;
                   if($row1['status'] =='Admitted'){
                     $status='Active';
                  
                   }else{
                    $status=$row1['status'];
                   }
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/user.jpg' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                        
                           echo" <tr>
                  <td> <input class='checkbox' type='checkbox' id='check' name='check[]' value='".$stdId."' style='width: 15px;height: 15px;'></td>
                  <td><a href='view_student.php?id=".$stdId."'>".$img."</a></td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$row1['registration_No']."</td>
                  <td><a href='class_room.php?id=".$classId."'>".$row3_class['level_name']." ".$row3_class['stream_name']."</a></td>
                  <td>".$row1['gender_MFU']."</td>
                  <td>".$status."</td>  
                  <td>";
            

                  echo'  <a class="btn btn-success badge " href="view_student.php?id='.$stdId.'"><span class= "glyphicon glyphicon-eye-open"></span></a>

                  <a class="btn btn-info badge" href="edit_students.php?id='.$row1['student_ID'].'"> <span class="glyphicon glyphicon-pencil"></span></a>

                  <button type="button" id="'.$stdId.'" class="btn btn-danger badge" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                  </td>
                  </tr>';
                        }

                  
                 
                    }
                  ?>
               
                 </tbody>
               
              </table>
              
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  

      
       <!-- Import student-->
        <div class="modal fade" id="modal-importStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload CSV file</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="student.php" method="POST" enctype="multipart/form-data">
           <input type="file" name="importFile" class="form-control" value="upload">
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="importBtn" href="#">Upload</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
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
               function deleteStudent(student_id,student_name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + student_name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ student_id +'" type="submit" data-dismiss="modal" onclick="deleteStudentFromSystem(this.id)">Delete</button></form></div>';
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
     <div class="modal  fade" id="modal-deleteCheckedStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this student?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
           Are you sure you want to delete all selected student from the system?
           
          
          <div id="Allmsg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalAllMsg">
           <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger pull-left" name="deleteAllbutton" id="" type="submit"  onclick="deletefromSystem()">Delete</button>
           </div>
        </div>
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
<script src="../../js/toast/toast.js"></script>
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
 function exportSample(){
        var id='1';
      var details= '&Export='+ id;
      alert(details);
          $.ajax({
          type: "POST",
          url: "test.php",
          data: details,
          cache: false,
          success: function(data) {
         
          alert(data);
           }
          });
 }
</script>

<script >
 
  function deleteStudentFromSystem(student_ID){
    
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&student_id='+ student_ID;
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
<script>
var select_all = document.getElementById("select_all"); //select all checkbox
var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
  for (i = 0; i < checkboxes.length; i++) { 
    checkboxes[i].checked = select_all.checked;
  }
});


for (var i = 0; i < checkboxes.length; i++) {
  checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
      select_all.checked = false;
    }
    //check "select all" if all checkbox items are checked
    if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
      select_all.checked = true;
    }
  });
}
</script>
<script>
 function deleteCheckbox(){
  var select_all = document.getElementById("select_all");
  var delete_all = document.getElementById("deleteAll");
  if (select_all.checked ==true) {
  
    delete_all.style.display = "block";
  }else{
    
   
   delete_all.style.display = "none";
  }

 }
</script>
<script type="text/javascript">
  function deletefromSystem(){

    var selected_value = []; // initialize empty array 
    $("#check:checked").each(function(){
        selected_value.push($(this).val());
        
    });
   // document.getElementById("AllDiv").innerHTML= selected_value+'<br;
    var details= '&student_id='+ selected_value;
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
