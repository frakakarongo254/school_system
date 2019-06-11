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
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section>
      <?php
      if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! carricula added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Carricula updated  successfully.
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
        ?>
    </section>


    <!-- Main content -->
    <div></div>
    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
          <h3><span class="fa fa-gear"></span>  <b class="color-primary" >  Setting</b></h3>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="school_profile.php"><i class="fa fa-arrow-circle-right"></i> School Details</a></li>
                <li><a href="school_carricula.php"><i class="fa fa-arrow-circle-right"></i> Curricula</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <?php
          #Add school carricula
          if (isset($_POST['addCarruculaBtn'])) {
             #get school Id from current session school id
            $school_ID = $_SESSION['login_user_school_ID'];
            $carricula_name=$_POST['carricula_name'];
            $carricula_code =$_POST['carricula_code'];
            $randCurr = substr(number_format(time() * rand(),0,'',''),0,10);
          $carricula_ID=md5( $randCurr);
           #check if such carricula already exist
            $carricula_data_sql = mysqli_query($conn,"select * from `carricula` where `code` = '".$carricula_code."' and `name` = '".$carricula_name."' and `school_ID` = '".$school_ID."' ");
            $carricula_row=mysqli_num_rows ( $carricula_data_sql );
            if ($carricula_row !=0) {
              echo' <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true">
              &times;
              </button>
              Such Carricula already exist.
              </div>'; 
            }else{

             $carricula_insert_query=mysqli_query($conn,"insert into `carricula` (carricula_ID,school_ID, name,code
          ) 
          values('$carricula_ID','$school_ID','$carricula_name','$carricula_code') ");
              if($carricula_insert_query){
              echo '<script> window.location="school_carricula.php?insert=true" </script>';
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

            # edit carricula
        if(isset($_POST['editCarruculaBtn'])){
        #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $edit_carricula_name=$_POST['edit_carricula_name'];
        $edit_carricula_code=$_POST['edit_carricula_code'];
        $edit_carricula_id=$_POST['edit_carricula_id']; # from hidden input in edit form
        
        $update_carri_query=mysqli_query($conn,"update `carricula` SET name= '".$edit_carricula_name."', code= '".$edit_carricula_code."' where `carricula_ID`='".$edit_carricula_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


        if($update_carri_query){
        echo '<script> window.location="school_carricula.php?update=True" </script>';
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
                  <a class="btn btn-primary pull-right" href="#" id="button1" data-toggle="modal" data-target="#modal-addCarrucula"><i class="fa fa-plus"></i><b> Add Carricula</b></a>
                 
            </div>
              </div>
              
             </div>
              <br>
                 <div class="row">
                   <div class="col-md-12">
                      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $carri_query = mysqli_query($conn,"select * from carricula where school_ID = '".$school_ID."'")or
                   die(mysqli_error());    
                     
                   while ($carri_row=mysqli_fetch_array($carri_query)){
                         $carricula_ID= $carri_row['carricula_ID']; 
                    echo" <tr>
                          
                            <td>".$carri_row['name']."</td>
                            <td>".$carri_row['code']." </td>  
                            <td>";
                            $_SESSION['carricula_ID'] = $carri_row['carricula_ID']; #send this id to the view carricula  page as a session
                           echo'   <a class="btn btn-success badge" href="view_carricula.php?id=',$carricula_ID,'"><span class= "glyphicon glyphicon-eye-open"></span></a>

                             <button type="button" id="'.$carri_row['carricula_ID'].'" class="btn btn-primary badge"  onclick="editCarricula(this.id)" data-toggle="modal"  data-target="#edit_carricula_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                             <button type="button" id="'.$carri_row['carricula_ID'].'" class="btn btn-danger badge" value="'.$carri_row['name'].'" onclick="deleteCarricula(this.id,this.value)" data-toggle="modal"  data-target="#delete_carricula_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                           </td>
                         </tr>';

                   }
                  
                    
                  ?>
               
                 </tbody>
                <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Code</th>
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
    
        <!-- add school carricula-->
    <div class="modal fade" id="modal-addCarrucula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header btn-default">
            <center><h5 class="modal-title" id="exampleModalLabel "><i class="fa fa-plus"></i>   <b>  Carrucula</b></h5></center>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <form  action="school_carricula.php" method="POST" enctype="multipart/form-data">
        
            <div class="form-group">   
              <label for="nationality">Code:</label>
                <input type="text" class="form-control" name="carricula_code" placeholder="Code">  
            </div>
            <div class="form-group">   
              <label for="nationality">Name:</label>
                <input type="text" class="form-control" name="carricula_name" placeholder="Name">  
            </div>
             
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addCarruculaBtn" class="btn btn-primary">Add Carricula</button>
              </div>
              </div>
              

             </form>
        </div>
      </div>
    </div>
      
        </div>

         <!-- edit carricula Modal-->
    <div class="modal  fade" id="edit_carricula_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Carricula</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editCarricula(carricula_id){ 
                  if(carricula_id !=''){
                    var details= '&carricula_id='+ carricula_id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_carricula.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                     
                      document.getElementById("editMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("editMessage").innerHTML=' You have Not Yet selected a Class';
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
     <!-- delete carricula  Modal-->
    <div class="modal  fade" id="delete_carricula_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Carricula</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteCarricula(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteCarriculaFromSystem(this.id)">Delete</button></form></div>';
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
  function deleteCarriculaFromSystem(carricula_id){
  alert(carricula_id);
  var details= '&carricula_id='+ carricula_id;
  $.ajax({
  type: "POST",
  url: "delete_carricula.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="school_carricula.php?delete=True" 
    }else{
      alert("OOp! Could not delete the Zone.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
