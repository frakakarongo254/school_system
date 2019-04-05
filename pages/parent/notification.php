<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
#get school Id from current session school id
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];
 $school_ID =$_SESSION['login_user_school_ID'];
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

                             
                              $notf_query = mysqli_query($conn,"select * from notification where school_ID = '$school_ID' and recipient_ID='$login_parent_ID' ");
                             while ($notf_row=mysqli_fetch_array($notf_query)){
                              $notification_id=$notf_row['notification_ID'];
                              $date=$notf_row['notification_date'];
                                 $newDate = date("d-m-Y", strtotime( $date));
                              echo '<tr>
                                     
                                   <td>'.$notf_row['notification_message'].'</td>
                                   
                                   <td>'.$newDate.'</td>
                                   <td><a href="view_notification.php?id='.$notification_id.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span>  View</button></a></a></td>
                                  
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
