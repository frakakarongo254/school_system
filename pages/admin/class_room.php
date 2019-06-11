<?php // error_reporting(0); 
 require_once("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 #get school Id from current session school id
  $school_ID = $_SESSION['login_user_school_ID'];
  $getClass_ID="";
if(isset($_GET['id'])){
   $getClass_ID =$_GET['id'];
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
     
      
      
    </section>
    <!-- Main content -->
    <section class="content">
   
        <!-- Custom Tabs -->
          <div class="nav-tabs-custom" style="padding-right: 20px;padding-left: 20px">
           <div class="row">

              <div class="col-md-4"><b>
                <h3>
                 <?php
                 $query_c= mysqli_query($conn,"select class.*,carricula_level.carricula_level_ID,carricula_level.level_name,stream.stream_name from class join carricula_level on carricula_level.carricula_level_ID=class.level_ID join stream on stream.stream_ID=class.stream_ID where class.class_ID='".$getClass_ID."' and class.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <h3 >'.$row_value['level_name'].'  '.$row_value['stream_name'].'  '.$row_value['year'].'</h3>';
                   }
                 
                   
                ?>
              </h3> </b></div>
              <div class="col-md-2">
               
                
              </div>
              <div class="col-md-2">
                
              </div>
              <div class="col-md-2">
               
              </div>
              <div class="col-md-2 col-pull-right" style="text-align:right">
               
              
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
                 
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where class_ID='".$getClass_ID."' and school_ID = '".$school_ID."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
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
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    // encryption function 
  
                  
                  //$id =  base64_url_encode($stdId);
                  echo" <tr>
                 
                  <td><a href='view_student.php?id=".$stdId."'>".$img."</a></td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$row1['registration_No']."</td>
                  <td>".$row1['gender_MFU']."</td>
                  <td>".$status."</td>  
                  <td>";
               $_SESSION['student_ID']=$row1['student_ID'];#send student id as a session to the next page of view student

                  echo'  <a class="btn btn-success badge " href="view_student.php?id='.$stdId.'"><span class= "glyphicon glyphicon-eye-open"></span></a>

                  <a class="btn btn-info badge" href="edit_students.php?id='.$row1['student_ID'].'"> <span class="glyphicon glyphicon-pencil"></span></a>

                 
                  </td>
                  </tr>';
                    }
                  ?>
               
                 </tbody>
               
              </table>
              
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  

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
<script>
  function myFunction() {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
<script>
  function testFun(){
    alert('yes');
  var toast = new iqwerty.toast.Toast();
toast.setText('This is a basic toast message!')
.setDuration(5000)
.show();
  }
</script>
</body>
</html>
