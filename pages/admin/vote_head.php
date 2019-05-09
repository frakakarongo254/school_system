<?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
  #get school Id from current session school id
$school_ID = $_SESSION['login_user_school_ID'];
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
          Success! Vote head added  successfully.
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

    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
        <span class="fa fa-gear"></span><b class="color-primary" >  Fee Structure</b>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="vote_head.php"><i class="fa fa-arrow-circle-right"></i> Vote Head</a></li>
               
                  <li><a href="paymentMode.php"><i class="fa fa-arrow-circle-right"></i>Payment Mode</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <?php
          #Add school carricula
          if (isset($_POST['addVoteHeadBtn'])) {
           
            $vote_head_name=$_POST['vote_head_name'];
           
           #check if such carricula already exist
            $votehead_data_sql = mysqli_query($conn,"select * from `vote_head` where `name` = '".$vote_head_name."' and `school_ID` = '".$school_ID."' ");
            $votehead_row=mysqli_num_rows ( $votehead_data_sql);
            if ($votehead_row !=0) {
              echo' <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true">
              &times;
              </button>
              Such Vote head already exist.
              </div>'; 
            }else{

             $votehead_insert_query=mysqli_query($conn,"insert into `vote_head` (school_ID, name
          ) 
          values('$school_ID','$vote_head_name') ");
              if($votehead_insert_query){
              echo '<script> window.location="vote_head.php?insert=true" </script>';
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

        

          ?>
         
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-12  ">
                 <div class="" style="text-align: center;">
                  <a class="btn btn-primary pull-right" href="#" id="button1" data-toggle="modal" data-target="#modal-addCarrucula"><i class="fa fa-plus"></i><b> Add Vote Head</b></a>
                 
            </div>
              </div>
              
             </div>
             <br>
             
                 <div class="row">
                   <div class="col-md-12">
                      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Vote head</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                 
                   $head_query = mysqli_query($conn,"select * from vote_head where school_ID = '".$school_ID."'")or
                   die(mysqli_error());    
                     
                   while ($votehead_row=mysqli_fetch_array($head_query)){
                         $votehead_row_ID= $votehead_row['vote_head_ID']; 
                    echo" <tr>
                          
                            <td>".$votehead_row['name']."</td>
                            
                            <td>";
                            
                           echo'   

                             <button type="button" id="'.$votehead_row['vote_head_ID'].'" class="btn btn-danger badge" value="'.$votehead_row['name'].'" onclick="deleteVoteHead(this.id,this.value)" data-toggle="modal"  data-target="#delete_voteHead_Modal"><span class="glyphicon glyphicon-trash"></span>   </button>
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
    
        <!-- add school carricula-->
    <div class="modal fade" id="modal-addCarrucula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header btn-default">
            <center><h5 class="modal-title" id="exampleModalLabel "><i class="fa fa-plus"></i>   <b>  Vote Head</b></h5></center>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <form  action="vote_head.php" method="POST" enctype="multipart/form-data">
        
            
            <div class="form-group">   
              <label for="nationality">Vote Head:</label>
                <input type="text" class="form-control" name="vote_head_name" placeholder="eg. Boarding Fees, Exam Fees">  
            </div>
             
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addVoteHeadBtn" class="btn btn-primary">Add Vote Head</button>
              </div>
              </div>
              

             </form>
        </div>
      </div>
    </div>
      
        </div>

  
     <!-- delete carricula  Modal-->
    <div class="modal  fade" id="delete_voteHead_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
               function deleteVoteHead(voteHead_id,voteHead_name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + voteHead_name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ voteHead_id +'" type="submit" data-dismiss="modal" onclick="deleteVoteHeadFromSystem(this.id)">Delete</button></form></div>';
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
    </div
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>


</div>

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
  function deleteVoteHeadFromSystem(voteHead_id){
  //alert(voteHead_id);
  var details= '&voteHead_id='+ voteHead_id;
  $.ajax({
  type: "POST",
  url: "delete_voteHead.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="vote_head.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
