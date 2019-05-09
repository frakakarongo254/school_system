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
      <h1>
        
       
      </h1>
    
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="email_compose.php" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="email_inbox.php"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right">
                     <?php 
                      $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
                    $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
                   
                    $school_email=$senderemail_row['sender_email'];

               $query_inbox= mysqli_query($conn,"select * from `email` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient='$school_email' and status='0'");
                $query_inbox_row=mysqli_num_rows ( $query_inbox );
                echo $query_inbox_row ;
                ?> 

                  </span></a></li>
                  <li><a href="email_compose.php"><i class="fa fa-pencil-square-o"></i> Compose</a></li>
                <li><a href="email_sent.php"><i class="fa fa-envelope-o"></i> Sent</a></li>
                
                <li><a href="email_setting.php"><i class="fa fa-gear"></i> Settings</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
       
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>From</th>
                  <th>Subject</th>               
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from email where school_ID = '$school_ID' and recipient='$school_email'  ORDER BY date_sent DESC")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $emailID = $row1['email_ID'];
                    $date=$row1['date_sent'];
                   $newDate= date("d-m-Y", strtotime($date));
                   $rowitem="";
                   if ($row1['status'] ==0) {
                     $rowitem="<b><tr>
                           <a href='vew_email.php?id=".$emailID."'>
                            <td><b>".$row1['sender']." </b></td>
                             <td><b>".$row1['email_subject']."</b></td> 
                            <td><span class='hidden'>".date("Y/m/d", strtotime($date))."</span><b>".$newDate."</b></td>
                            <td><a href='view_email.php?id=".$emailID."' ><button type='button'  class='btn btn-success badge' onclick='viewStudentDetailes()''><span class= 'glyphicon glyphicon-eye-open'></span></button></a></td></b>
                          
                         </tr>";
                   }else{
                    $rowitem="<tr>
                           <a href='vew_email.php?id=".$emailID."'>
                            <td>".$row1['sender']." </td>
                             <td>".$row1['email_subject']."</td> 
                            <td><span class='hidden'>".date("Y/m/d", strtotime($date))."</span>".$newDate."</td>
                            <td><a href='view_email.php?id=".$emailID."'><button type='button'  class='btn btn-success badge' onclick='viewStudentDetailes()''><span class= 'glyphicon glyphicon-eye-open'></span></button></a></td>
                              </tr>";

                   }
                   
                  echo  $rowitem;
                    }
                  ?>
               
                 </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
           
            
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>

<script >
  function deleteStudentFromSystem(RegNo){
    alert(RegNo);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&RegNo='+ RegNo;
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
