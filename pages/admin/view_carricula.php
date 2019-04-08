<?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$carricula_id;
if(isset($_GET['id'])){
  $carricula_id =$_GET['id'];
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
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section>
      <?php
      if(isset($_GET['id']) and isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Level added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Level updated  successfully.
          </div>';   
        }
        if(isset($_GET['delete'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Level deleted  successfully.
          </div>';   
        }
        ?>
    </section>


    <!-- Main content -->
    <div></div>
    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
          <h3><span class="fa fa-gear"></span><b class="color-primary" >Setting</b></h3>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="school_profile.php"><i class="fa fa-arrow-circle-right"></i> School Details</a></li>
                <li><a href="school_carricula.php"><i class="fa fa-arrow-circle-right"></i> Curricula</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <?php
          #Add level
          if (isset($_POST['addLevelBtn'])) {
             #get school Id from current session school id
            $school_ID = $_SESSION['login_user_school_ID'];
            //$carricula_id=$_GET['id'];
            $level_name=$_POST['level_name'];
            $level_number =$_POST['level_number'];
            $level_abbreviation =$_POST['level_abbreviation'];
           #check if such carricula already exist
            $level_data_sql = mysqli_query($conn,"select * from `carricula_level` where `level_name` = '".$level_name."' and `carricula_ID` = '".$carricula_id."' and `school_ID` = '".$school_ID."' ");
            $level_row=mysqli_num_rows( $level_data_sql );
            if ( $level_row !=0) {
              echo $carricula_id;
              echo' <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true">
              &times;
              </button>
              Such Carricula already exist.
              </div>'; 
            }else{
              echo $carricula_id;

             $carricula_insert_query=mysqli_query($conn,"insert into `carricula_level` (school_ID,carricula_ID, level_name,level_number,abbreviation
          ) 
          values('$school_ID','$carricula_id','$level_name','$level_number','$level_abbreviation') ");
              if($carricula_insert_query){
                $carrId=$_GET['id'];
             // echo '<script> window.location="view_carricula.php?id="'.$carricula_id.'"&insert=True" </script>';
              echo '<script> window.location="view_carricula.php?id='.$carrId.'&insert=True" </script>';
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

            # edit Level
        if(isset($_POST['editLevelBtn'])){
        #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $edit_level_id=$_POST['edit_level_id'];
        $edit_level_name=$_POST['edit_level_name'];
        $edit_level_number=$_POST['edit_level_number'];
        $edit_level_abbreviation=$_POST['edit_level_abbreviation']; # from hidden input in edit form
        
        $update_level_query=mysqli_query($conn,"update `carricula_level` SET level_name= '".$edit_level_name."', level_number= '".$edit_level_number."',abbreviation= '".$edit_level_abbreviation."' where `carricula_level_ID`='".$edit_level_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


        if($update_level_query){
        echo '<script> window.location="view_carricula.php?id='.$carricula_id.'&update=True" </script>';
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
         
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-12  ">
                 <div class="" style="text-align: center;">
                  <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#modal-addLevel"><i class="fa fa-plus"></i><b> Add Level</b></a>
                 
            </div>
              </div>
              
             </div>
             
                 <div class="row">
                   <div class="col-md-12">
                      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Level</th>
                  <th>Abbreviation</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $carri_query = mysqli_query($conn,"select * from carricula_level where carricula_ID='$carricula_id' and school_ID = '$school_ID'")or
                   die(mysqli_error());    
                     
                   while ($carri_row=mysqli_fetch_array($carri_query)){
                         $carricula_ID= $carri_row['carricula_level_ID']; 
                    echo" <tr>
                          
                            <td>".$carri_row['level_number']."</td>
                            <td>".$carri_row['abbreviation']." </td> 
                            <td>".$carri_row['level_name']." </td> 
                            <td>";
                           echo'  
                             <button type="button" id="'.$carri_row['carricula_level_ID'].'" class="btn btn-primary btn-flat"  onclick="editLevel(this.id)" data-toggle="modal"  data-target="#edit_level_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$carri_row['carricula_level_ID'].'" class="btn btn-danger btn-flat" value="'.$carri_row['level_name'].'" onclick="deleteLevel(this.id,this.value)" data-toggle="modal"  data-target="#delete_level_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                           </td>
                         </tr>';

                   }
                  
                    
                  ?>
               
                 </tbody>
                <tfoot>
                <tr>
                  <th>Level</th>
                  <th>Abbreviation</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
                   </div>
                   
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    
        <!-- add school level-->
    <div class="modal fade" id="modal-addLevel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header btn-default">
            <center><h5 class="modal-title" id="exampleModalLabel "><i class="fa fa-plus"></i>   <b>  Level</b></h5></center>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <form  action="view_carricula.php?id=<?php echo $carricula_id ?>" method="POST" enctype="multipart/form-data">
        
            <div class="form-group">   
              <label for="nationality">Level Number:</label>
                <input type="text" class="form-control" name="level_number" placeholder="Level Number">  
            </div>
            <div class="form-group">   
              <label for="nationality">Level Name:</label>
                <input type="text" class="form-control" name="level_name" placeholder="Name Name">  
            </div>
            <div class="form-group">   
              <label for="nationality">Abbreviation:</label>
                <input type="text" class="form-control" name="level_abbreviation" placeholder="level Abbreviation">  
            </div>
             
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addLevelBtn" class="btn btn-primary">Add Level</button>
              </div>
              </div>
              

             </form>
        </div>
      </div>
    </div>
      
        </div>

         <!-- edit level Modal-->
    <div class="modal  fade" id="edit_level_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Level</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editLevel(level_id){ 
                   var carricula_id=<?php echo $carricula_id?>;
                  if(level_id !=''){
                    var details= '&level_id='+ level_id +'&carricula_id='+ carricula_id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_carriculaLevel.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                     
                      document.getElementById("editMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("editMessage").innerHTML=' Sorry! Please try again';
                  }
                 
                
                }
            </script>
          
          <div id="editMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>
     <!-- delete level  Modal-->
    <div class="modal  fade" id="delete_level_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Level</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteLevel(level_id,level_name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + level_name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ level_id +'" type="submit" data-dismiss="modal" onclick="deleteLevelFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
      </div>
    </div>
     </div
      </div>
      <!-- /.row -->

    
      
       
         
     
    </section>
    <!-- /.content -->
    <div class="row">
       <!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
    </div>
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>


</div>
</section>
  <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
<!-- ./wrapper -->

<!-- include script-->
<?php include("include/script.php")?>
<script >
  function deleteLevelFromSystem(level_id){
  var carricula_id=<?php echo $carricula_id?>;
  var details= '&level_id='+ level_id;
  $.ajax({
  type: "POST",
  url: "delete_carriculaLevel.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="view_carricula.php?id="+carricula_id+"&delete=True" 
    }else{
      alert("OOp! Could not delete .Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
