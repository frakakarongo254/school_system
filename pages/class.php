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
        Class
       
      </h1>
     
      <ol class="breadcrumb">
       
        <li class=""><a class="btn btn-success btn-sm" href="login.html" data-toggle="modal" data-target="#modal-addStudent" style="color: #fff"><i class="fa fa-plus"></i> <b>Add Class</b></a></li>
      </ol>
        
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Class added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Class updated  successfully.
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
       if(isset($_POST['addClassBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
        $class_name=$_POST['class_name'];
       
        $class_insert_query=mysqli_query($conn,"insert into `class` (school_ID, class_name
          ) 
          values('$school_ID','$class_name') ");

        
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
      if(isset($_POST['EditClassBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
        $class_name=$_POST['edit_class_name'];
        $edit_class_id=$_POST['edit_class_id'];
        $update_class_query=mysqli_query($conn,"update `class` SET class_name= '".$class_name."' where `class_ID`='".$edit_class_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

        
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

      
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
             
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>   
                  <th>Class Name</th>
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
                  echo" <tr>
                          
                            <td>".$row4['class_name']."</td>
                            
                             
                            <td>";
                           echo'  
                             <button type="button"  class="btn btn-info btn-flat" id="'.$class_ID.'" onclick="editClassName(this.id)" data-toggle="modal"  data-target="#edit_class_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$row4['class_ID'].'" class="btn btn-danger btn-flat" value="'.$row4['class_name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_class_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                             
                           </td>
                         </tr>';
                    }
                  ?>
               
                 </tbody>
                <tfoot>
                 <tr>   
                  <th>Class Name</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
      </div>
    <!--- add student Modal -->
      <div class="modal fade" id="modal-addStudent">
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
            <div class="row">   
              <label for="nationality">Class Name:</label>
              <div class=" col-md-12 input-group input-group-">
                
                <input type="text" name="class_name" class="form-control" placeholder="Class Name" required>
              </div>
              
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
       
         <!-- delete student  Modal-->
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
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
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
</script>
</body>
</html>
