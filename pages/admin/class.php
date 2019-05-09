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
          if ($_GET['insert']==1) {
            echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Section added  successfully.
          </div>'; 
          }else{
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Class added  successfully.
          </div>'; 
          }  
        }
        if(isset($_GET['update'])){
          if($_GET['update']==1){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Session updated  successfully.
          </div>';   
        }else{
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Class updated  successfully.
          </div>';   
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
        #Add class
       if(isset($_POST['addClassBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
        $class_level_id=$_POST['class_level_id'];
        $class_stream_id=$_POST['class_stream_id'];
        $class_year=$_POST['class_year'];
        $class_teacher_id=$_POST['class_teacher_id'];
       $className=$_POST['className'];
        $class_insert_query=mysqli_query($conn,"insert into `class` (school_ID,name, stream_ID,level_ID,teacher_ID,year
          ) 
          values('$school_ID','$className','$class_stream_id','$class_level_id','$class_teacher_id','$class_year') ");

        
        if($class_insert_query){
           echo '<script> window.location="class.php?insert=True" </script>';
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
      # edit class
      if(isset($_POST['editClassBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
         $edit_class_level_id=$_POST['edit_class_level_id'];
        $edit_class_stream_id=$_POST['edit_class_stream_id'];
        $edit_class_year=$_POST['edit_class_year'];
        $edit_class_teacher_id=$_POST['edit_class_teacher_id'];
        $edit_class_id=$_POST['edit_class_id'];
        $update_class_query=mysqli_query($conn,"update `class` SET level_ID= '".$edit_class_level_id."',year= '".$edit_class_year."',level_ID= '".$edit_class_level_id."',stream_ID= '".$edit_class_stream_id."',teacher_ID= '".$edit_class_teacher_id."' where `class_ID`='".$edit_class_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

        
        if($update_class_query){
           echo '<script> window.location="class.php?update=True" </script>';
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
 # Add session
      if(isset($_POST['addSessionBtn'])){
        
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $session_carricula_id=$_POST['session_carricula_id'];
        $session_title=$_POST['session_title'];
        $session_name=$_POST['session_name'];
        $session_range=$_POST['session_range'];
       
        $section_insert_query=mysqli_query($conn,"insert into `session` (school_ID, session_name,session_title,carricula_ID,session_range
          ) 
          values('$school_ID','$session_name','$session_title','$session_carricula_id','$session_range') ");

        
        if($section_insert_query){
           echo '<script> window.location="class.php?insert=1" </script>';
          
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
      # edit session
      if(isset($_POST['editSessionBtn'])){
        
          #get school Id from current session school id
       echo $school_ID = $_SESSION['login_user_school_ID'];
      echo  $edit_session_session_id=$_POST['edit_session_id'];
        $edit_session_carricula_id=$_POST['edit_session_carricula_id'];
        $edit_session_title=$_POST['edit_session_title'];
        $edit_session_name=$_POST['edit_session_name'];
        $edit_session_range=$_POST['edit_session_range'];
       
        $update_session_query=mysqli_query($conn,"update `session` SET session_title= '".$edit_session_title."',session_name= '".$edit_session_name."',session_range= '".$edit_session_range."',carricula_ID= '".$edit_session_carricula_id."' where `session_ID`='".$edit_session_session_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

        
        if($update_session_query){
           echo '<script> window.location="class.php?update=1" </script>';
         
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
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Classes </h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="#" id="buttonClass" data-toggle="modal" data-target="#modal-addClass"><i class="fa fa-plus"></i><b> New Class</b></a></div>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>   
                  <th>Name</th>
                  <th>Level</th>
                  <th>Stream</th>
                  <th>Year</th>
                  <th>Class Teacher</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query4 = mysqli_query($conn,"select * from class where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row4=mysqli_fetch_array($query4)){
                  $class_ID=$row4['class_ID'];
                  $levelID=$row4['level_ID'];
                  #get levelname
                    $levelName = mysqli_query($conn,"select level_name from carricula_level where school_ID = '$school_ID' and carricula_level_ID='$levelID' ");
                    $levelName_row = mysqli_fetch_array($levelName,MYSQLI_ASSOC);
                    #get teacher name
                    $teacherID=$row4['teacher_ID'];
                    $teacherName = mysqli_query($conn,"select full_Name from staff where school_ID = '$school_ID' and staff_ID='$teacherID' ");
                    $teacherName_row = mysqli_fetch_array($teacherName,MYSQLI_ASSOC);
                    #get stream name
                    $streamID=$row4['stream_ID'];
                    $streamName = mysqli_query($conn,"select stream_name from stream where school_ID = '$school_ID' and stream_ID='$streamID' ");
                    $streamName_row = mysqli_fetch_array($streamName,MYSQLI_ASSOC);
                  
                  
                   echo" <tr>
                          <td>".$row4['name']."</td>
                            <td>".$levelName_row['level_name']."</td>
                            <td>".$streamName_row['stream_name']."</td>
                            <td>".$row4['year']."</td>
                            <td>".$teacherName_row['full_Name']."</td>
                             
                            <td>";
                           echo'  
                             <button type="button"  class="btn btn-info badge" id="'.$class_ID.'" onclick="editClassName(this.id)" data-toggle="modal"  data-target="#edit_class_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$row4['class_ID'].'" class="btn btn-danger badge" value="'.$row4['level_ID'].'" onclick="deleteStudent(this.id)" data-toggle="modal"  data-target="#delete_class_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                             
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
       <div class="col-md-6">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Session </h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="#" id="buttonClass" data-toggle="modal" data-target="#modal-addSection"><i class="fa fa-plus"></i><b> New Session</b></a></div>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>   
                  <th> Session</th>
                  <th>Starting  -  Ending</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query4 = mysqli_query($conn,"select * from session where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row5=mysqli_fetch_array($query4)){
                   $session_ID=$row5['session_ID'];
                   #get teacher name
                    $carriculaID=$row5['carricula_ID'];
                    $carriculaName = mysqli_query($conn,"select code from carricula where school_ID = '$school_ID' and carricula_ID='$carriculaID' ");
                    $carric_row = mysqli_fetch_array($carriculaName,MYSQLI_ASSOC);
                  echo" <tr>
                          
                            <td>".$carric_row['code']."".$row5['session_name']."</td>
                            <td>".$row5['session_range']."</td>
                             
                            <td>";
                           echo'  
                             <button type="button"  class="btn btn-info badge" id="'.$session_ID.'" onclick="editSession(this.id)" data-toggle="modal"  data-target="#edit_session_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$row5['session_ID'].'" class="btn btn-danger badge" value="'.$row5['session_name'].'" onclick="deleteSession(this.id,this.value)" data-toggle="modal"  data-target="#delete_session_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                             
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
    
         <!--- add section Modal -->
      <div class="modal fade" id="modal-addSection">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times; </span></button>
                <h4 class="modal-title"><b>Add Session</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
             <form  action="class.php" method="POST">
            
              <div class="form-group">
               
              <select class="form-control select2" name="session_carricula_id" style="width: 100%;" placeholder="Title eg Term, Session" required >
                    <option value="">Select Curriculum</option>
                  <?php
                 $query3= mysqli_query($conn,"select * from carricula where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($row3=mysqli_fetch_array($query3)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$row3['carricula_ID'].'">'.$row3['name'].'</option>';
                   }
                ?>
                 </select>
               </div>
               <div class="form-group">
                
              <select class="form-control select2" name="session_title" style="width: 100%;" required>
                  <option value="">Title eg Term,Semester</option>
                  <option value="Tearm">Term</option>
                  <option value="Semester">Semester</option>
                   <option value="Trimester">Trimester</option>
                 </select>
               </div>
                <div class="form-group">
                
              <select class="form-control select2" name="session_name" style="width: 100%;" required>
                <option value="">Session</option>
                 <option value="Term 1">Term 1</option>
                  <option value="Term 2">Term 2</option>
                  <option value="Term 3">Term 3</option>
                  <option value="Session 1">Session 1</option>
                  <option value="Session 2">Session 2</option>
                   <option value="Session 3">Session 3</option>
                 </select>
               </div>
               <div class="form-group">
                <label> Starting Date -Ending Date:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="session_range" id="reservation">
                </div>
                <!-- /.input group -->
              </div>
               
               
           <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addSessionBtn" class="btn btn-primary">Add Session</button>
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
       
         <!-- delete class  Modal-->
    <div class="modal  fade" id="delete_class_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this Class?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteStudent(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete this class from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteClassFromSystem(this.id)">Delete</button></form></div>';
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
   <!-- delete session  Modal-->
    <div class="modal  fade" id="delete_session_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this session?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteSession(id,name){
                  alert(id);
                 document.getElementById("msg2").innerHTML=' Are you sure you want to delete this class from the system?'
                var updiv = document.getElementById("sessionMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteSessionFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg2"></div>

        </div>
          <div class="modal-footer">
           <div id="sessionMsg"></div>
        </div>
      </div>
    </div>
     </div>

    <!-- edit class Modal-->
    <div class="modal  fade" id="edit_class_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Class</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editClassName(id){ 
                
                  if(id !=''){
                    var details= '&class_id='+ id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_class.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("classMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("classMessage").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="classMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>

       <!-- edit Session Modal-->
    <div class="modal  fade" id="edit_session_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit session</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editSession(sessionID){ 
               // alert(sessionID);
                  if(sessionID !=''){
                    var details= '&sessionID='+ sessionID ;
                    $.ajax({
                    type: "POST",
                    url: "edit_session.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("sessionMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("sessionMessage").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="sessionMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>
     <!--- add class Modal -->
      <div class="modal fade" id="modal-addClass">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Class</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="class.php" method="POST">
            <div class="form-group">
              <label>Year:</label>
            <select class="form-control select2" name="class_year" style="width: 100%;" required>>
                <?php 
                  $year = date('Y');
                  $min = $year - 60;
                  $max = $year;
                  for( $i=$max; $i>=$min; $i-- ) {
                    echo '<option value='.$i.'>'.$i.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
                <label>Class Name:</label>
              <input type="test" name="className" class="form-control">
              <div class="form-group">
                <label>Level:</label>
              <select class="form-control select2" name="class_level_id" style="width: 100%;" required>
                    <option value="">--Select Level--</option>
                  <?php
                 $query_level2= mysqli_query($conn,"select * from carricula_level where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($level2_rows=mysqli_fetch_array($query_level2)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$level2_rows['carricula_level_ID'].'">'.$level2_rows['level_name'].'</option>';
                   }
                ?>
                 </select>
               </div>
               <div class="form-group">
                <label>Stream:</label>
              <select class="form-control select2" name="class_stream_id" style="width: 100%;" required>
                    <option value="">--Select Stream--</option>
                  <?php
                 $query_stream2= mysqli_query($conn,"select * from stream where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($stream2_rows=mysqli_fetch_array($query_stream2)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$stream2_rows['stream_ID'].'">'.$stream2_rows['stream_name'].'</option>';
                   }
                ?>
                 </select>
               </div>
                <div class="form-group">
                <label>Teacher:</label>
              <select class="form-control select2" name="class_teacher_id" style="width: 100%;" required>
                    <option value="">--Select Teacher--</option>
                  <?php
                 $query_staff_Teacher= mysqli_query($conn,"select * from staff where role='Teacher' and school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($teacher_rows=mysqli_fetch_array($query_staff_Teacher)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$teacher_rows['staff_ID'].'">'.$teacher_rows['full_Name'].'</option>';
                   }
                ?>
                 </select>
               </div>
           <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addClassBtn" class="btn btn-primary">Add Class</button>
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

var start = new Date().getFullYear();
var end = 1900;
var options = "";
for(var year =  end; year <=start; year++){
  options += "<option>"+ year +"</option>";
}
document.getElementById("year_time").innerHTML = options;

</script>

<script >
  function deleteClassFromSystem(class_id){
  //alert(id);
  var details= '&class_id='+ class_id;
  $.ajax({
  type: "POST",
  url: "delete_class.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="class.php?delete=True" 
    }else{
      alert("OOp! Could not delete the class.Please try again!");
    }
  
  }

  });
  }

  function deleteSessionFromSystem(session_id){
  //alert(session_id);
  var details= '&session_id='+ session_id;
  $.ajax({
  type: "POST",
  url: "delete_session.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="class.php?delete=True" 
    }else{
      alert("OOp! Could not delete the class.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
