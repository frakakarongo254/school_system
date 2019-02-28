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
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    


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
          if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Stream added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Stream updated  successfully.
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
          #Edit school Details
          if (isset($_POST['saveSchoolDetails'])) {
            $schoolName =$_POST['school_name'];
            $school_email =$_POST['school_email'];
            $school_phone =$_POST['school_phone'];
            $school_website =$_POST['school_website'];
            $school_address =$_POST['school_address'];
            $school_moto =$_POST['school_moto'];
            
            $insertDdetails_query=mysqli_query($conn,"update `school` SET school_Name= '".$schoolName."',email= '".$school_email."',phone= '".$school_phone."',school_website= '".$school_website."',address_1= '".$school_address."',school_moto= '".$school_moto."' where  `school_ID`='".$_SESSION['login_user_school_ID']."' ");
              if($insertDdetails_query){
              echo '<script> window.location="school_profile.php?update=true" </script>';
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

            # check image
            if(isset($_POST['uploadLogoBtn'])){
            if(isset($_FILES['school_logo']['name']) and !empty($_FILES['school_logo']['name'])){
            $file=$_FILES['school_logo']['name'];
            $path_parts = pathinfo($file);
            $extension= $path_parts['extension'];

            if ($_FILES["school_logo"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.')</script>";
            $uploadOk = 0;
            }
            elseif($extension != "jpg" && $extension != "png" && $extension != "jpeg"
            && $extension != "gif" ) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
            $uploadOk = 0;
            }else{
            $school_logo = addslashes(file_get_contents($_FILES['school_logo']['tmp_name']));
            $result_query=mysqli_query($conn,"update `school` SET logo_image= '".$school_logo."' where  `school_ID`='".$_SESSION['login_user_school_ID']."' ");
            if($result_query){
            echo '<script> window.location="school_profile.php?link=True" </script>';
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
            echo '<script> alert("You must select an image") </script>';
            }
            }

            # add stream
            if (isset($_POST['addStreamBtn'])) {
            $streamName =$_POST['stream_name'];
            $class_insert_query=mysqli_query($conn,"insert into `stream` (school_ID, stream_name
            ) 
            values('".$_SESSION['login_user_school_ID']."','$streamName') ");


            if($class_insert_query){
            echo '<script> window.location="school_profile.php?insert=True" </script>';
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

            # edit stream
        if(isset($_POST['editStreamBtn'])){
        #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $edit_stream_name=$_POST['edit_stream_name'];
        $edit_stream_id=$_POST['edit_stream_id'];
        
        $update_stream_query=mysqli_query($conn,"update `stream` SET stream_name= '".$edit_stream_name."' where `stream_ID`='".$edit_stream_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


        if($update_stream_query){
        echo '<script> window.location="school_profile.php?update=True" </script>';
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
          <?php
           $school_ID=$_SESSION['login_user_school_ID'];
            $school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");
              
              $school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
              $school_row['school_Name'];
               $logo;
                   if($school_row['logo_image'] !=''){
                    $logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
                  }else{
                      $logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
                    }
          ?>
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-6  ">
                 <div class="" style="text-align: center;">
                 
                  <center>
              <table>
               
                    <tr>
                      <td rowspan="2"> <?php echo $logo;?>
             <h3 class="profile-username text-center"><a data-toggle="modal" data-target="#modal-editSchoolLogo"><span class="pull- badge bg-secondary">Change Logo</span></a></h3></td>
                      <td><ul class="nav nav-pills nav-stacked">
                <li><a href="#"><i class="fa  fa-institution"></i><b><?php echo $school_row['school_Name']?></b></a></li>
                <li><a href="#"><i class="fa fa-bookmark-o"></i> Po. Box <?php echo $school_row['address_1']?></a></li>
                <li><a href="#"><i class="fa fa-phone"></i> <?php echo $school_row['phone']?></a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $school_row['email']?></a></li>
                <li><a href="#"><i class="fa fa-globe"></i> <?php echo $school_row['school_website']?></a></li>
              </ul></td>
                     
                    </tr>
              </table>
            </center>
            </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                 <h3>MOTO:</h3>
                 <?php echo $school_row['school_moto']?>
                </div>
                <div class="row">
                  <h3> Registration Date</h3>
                <?php echo $school_row['registration_Date']?>
                </div>
               </div>
               <div class="col-md-3">
                 <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#modal-editSchoolDetails"><i class="fa fa-pencil"></i><b> Edit Details</b></a>
               </div>
             </div>
             
             
             
             <div class="row">
                <div class="col-md-12">
                   <h3>Stream:</h3>
                   <th><a class="btn btn-success pull-right btn-sm" href="#" data-toggle="modal" data-target="#modal-addStream"><i class="fa fa-plus"></i><b> Add Stream</b></a></th>
                 <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>   
                  <th>Stream Name</th>
                  <th>Actions</th>
                  
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query4 = mysqli_query($conn,"select * from stream where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   while ($row4=mysqli_fetch_array($query4)){
                   $stream_ID=$row4['stream_ID'];
                  echo" <tr>
                          
                            <td>".$row4['stream_name']."</td>
                           
                            <td colspan='2'>";
                           echo'  
                             <button type="button"  class="btn btn-info btn-flat" id="'.$stream_ID.'" onclick="editStream(this.id)" data-toggle="modal"  data-target="#edit_stream_Modal"><span class="glyphicon glyphicon-pencil">  Edit</span></button>

                             <button type="button" id="'.$row4['stream_ID'].'" class="btn btn-danger btn-flat" value="'.$row4['stream_name'].'" onclick="deleteStream(this.id,this.value)" data-toggle="modal"  data-target="#delete_stream_Modal"><span class="glyphicon glyphicon-trash"></span>  Remove</button>
                             
                           </td>
                         </tr>';
                    }
                  ?>
               
                 </tbody>
                
              </table>
                </div>
             </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         <!-- upload Log Modal-->
    <div class="modal fade" id="modal-editSchoolLogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Logo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="school_profile.php" method="POST" enctype="multipart/form-data">
           <input type="file" name="school_logo" class="form-control" value="upload">
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="uploadLogoBtn" href="#">Upload</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
        <!-- edit school details-->
    <div class="modal fade" id="modal-editSchoolDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="school_profile.php" method="POST" enctype="multipart/form-data">

         <div class="form-group">
                <label>School Name:</label>
               
                  <input type="text" class="form-control pull-right"  name="school_name" value="<?php echo $school_row['school_Name']?>">
                
                <!-- /.input group -->
            </div>
             <div class="form-group">
                <label>Phone:</label>
                
                  <input type="text" class="form-control pull-right" name="school_phone" value="<?php echo $school_row['phone']?>">
                
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Address:</label>
               
                  <input type="text" class="form-control pull-right" name="school_address" value="<?php echo $school_row['address_1']?>">
             
                <!-- /.input group -->
            </div>
             <div class="form-group">
                <label>Email:</label>
                
                  <input type="text" class="form-control pull-right" name="school_email" value="<?php echo $school_row['email']?>">
                
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Web:</label>
               
                  <input type="text" class="form-control pull-right" name="school_website" value="<?php echo $school_row['school_website']?>">
                
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>MOTO:</label>
               
                  <textarea type="text" class="form-control " name="school_moto"><?php echo $school_row['school_moto']?></textarea>  
              
                <!-- /.input group -->
            </div>
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="saveSchoolDetails" href="#">Save</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
      <!--Add Stream-->
         <div class="modal fade" id="modal-addStream" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Stream</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="school_profile.php" method="POST" >
            <div class="form-group">   
              <label for="nationality">Stream Name:</label>
                <input type="text" class="form-control" name="stream_name" placeholder="Stream Name">  
            </div>
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="addStreamBtn" href="#">Add Stream</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
     <!-- edit stream Modal-->
    <div class="modal  fade" id="edit_stream_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Stream</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editStream(stream_id){ 
                
                  if(stream_id !=''){
                    var details= '&stream_id='+ stream_id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_stream.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("editStreamMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("editStreamMessage").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="editStreamMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>
         <!-- delete stream  Modal-->
    <div class="modal  fade" id="delete_stream_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
               function deleteStream(stream_id,stream_name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + stream_name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ stream_id +'" type="submit" data-dismiss="modal" onclick="deleteStreamFromSystem(this.id)">Delete</button></form></div>';
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
  </div>
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
  function deleteStreamFromSystem(stream_id){
  alert(stream_id);
  var details= '&stream_id='+ stream_id;
  $.ajax({
  type: "POST",
  url: "delete_stream.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="school_profile.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
