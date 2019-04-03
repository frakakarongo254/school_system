<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
#get school Id from current session school id
$school_ID = $_SESSION['login_user_school_ID'];
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
          Success! Zone added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Zone updated  successfully.
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
       if(isset($_POST['addZoneBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
        $zone_name=$_POST['zone_name'];
        $oneWayCharge=$_POST['oneWayCharge'];
        $twoWayCharge=$_POST['twoWayCharge'];
       
        $class_insert_query=mysqli_query($conn,"insert into `zone` (school_ID, zone,oneWayCharge,twoWayCharge
          ) 
          values('$school_ID','$zone_name','$oneWayCharge','$twoWayCharge') ");

        
        if($class_insert_query){
           echo '<script> window.location="zone.php?insert=True" </script>';
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
        # edit zone
        if(isset($_POST['editZoneBtn'])){

        
        $edit_zone_name=$_POST['edit_zone_name'];
        $edit_zone_id=$_POST['edit_zone_id'];
        $edit_oneWayCharge=$_POST['edit_oneWayCharge'];
        $edit_twoWayCharge=$_POST['edit_twoWayCharge'];
        $update_zone_query=mysqli_query($conn,"update `zone` SET zone= '".$edit_zone_name."', oneWayCharge= '".$edit_oneWayCharge."',twoWayCharge= '".$edit_twoWayCharge."' where `zone_ID`='".$edit_zone_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


        if($update_zone_query){
        echo '<script> window.location="zone.php?update=True" </script>';
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
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Notification</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"></div>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                             <th>Notification</th>
                            
                           
                            <th>Date</th>
                            <th>Action</th>
                            
                          </tr>
                          </thead>
                          <tbody>
                             <?php

                             
                              $notf_query = mysqli_query($conn,"select * from notification where school_ID = '$school_ID' ");
                             while ($notf_row=mysqli_fetch_array($notf_query)){
                              $notification_id=$notf_row['notification_ID'];
                              $date=$notf_row['notification_date'];
                                 $newDate = date("d-m-Y", strtotime( $date));
                              echo '<tr>
                                     
                                   <td>'.$notf_row['notification_message'].'</td>
                                   
                                   <td>'.$newDate.'</td>
                                   <td><a   href="#" id="'.$notification_id.'" onclick="deleteNotificationFromSystem(this.id)"><span class="pull- badge bg-danger btn-danger"><i class="fa fa-trash"></i> Delete <span> </a></td>
                                  
                                 </tr>';
                               
                             
                             //echo $amt;
                           }
                         // echo $total_bill;
                          
                             ?>
                         
                           </tbody>
                         
                        </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
      </div>
    <!--- add zone Modal -->
      <div class="modal fade" id="modal-addZone">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Zone</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="zone.php" method="POST">
            <div class="row">   
              <label for="nationality">Zone Name:</label>
              <div class=" col-md-12 input-group input-group-">
                
                <input type="text" name="zone_name" class="form-control" placeholder="Zone Name" required>
              </div>
              <br>
            </div>
             <div class="row">   
              <label for="nationality">One Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" class="form-control" name="oneWayCharge">
                
              </div>
              
            </div>
           <br>
            <div class="row">   
              <label for="nationality">Two Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" class="form-control" name="twoWayCharge">
                
              </div>
              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addZoneBtn" class="btn btn-primary">Add Zone</button>
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
       
         <!-- delete zone  Modal-->
    <div class="modal  fade" id="delete_zone_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
               function deleteZone(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteZoneFromSystem(this.id)">Delete</button></form></div>';
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

    <!-- edit zone Modal-->
    <div class="modal  fade" id="edit_zone_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Zone</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editZone(id){ 
                
                  if(id !=''){
                    var details= '&zone_id='+ id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_zone.php",
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
  function deleteNotificationFromSystem(notification_id){
  //alert(notification_id);
  var details= '&notification_id='+ notification_id;
  $.ajax({
  type: "POST",
  url: "delete_notification.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="notification.php?delete=True" 
    }else{
      alert("OOp! Could not delete the Zone.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
