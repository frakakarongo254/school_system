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
          Success! Payment was successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Updated successfully.
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
       
       if (isset($_POST['paymentBtn'])) {
       $invoice_id=$_POST['invoice_id'];
         $student_id=$_POST['student_id'];
         $balance=$_POST['amount_balance'];
         $amount_paid=$_POST['amount_paid'];
         $slip_no=$_POST['slip_no'];
         $payment_date=$_POST['payment_date'];
         $payment_remarks=$_POST['payment_remarks'];
         $payment_method=$_POST['payment_Mode'];
         $new_balance;
         if ($amount_paid >= $balance ) {
           $new_balance= 0.00;
         }else{
          $new_balance= $balance - $amount_paid;
         }

          $payment_query=mysqli_query($conn,"insert into `payment` (school_ID,student_ID,invoice_ID,amount_paid, slip_no,remarks,payment_date,payment_method
          ) 
          values('$school_ID','$student_id','$invoice_id','$amount_paid','$slip_no','$payment_remarks','$payment_date','$payment_method') ");

        
        if($payment_query){
           $update_query=mysqli_query($conn,"update `invoice` SET amount_paid= '".$amount_paid."', balance= '".$new_balance."' where `invoice_ID`='".$invoice_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
           if ($update_query) {
             echo '<script> window.location="invoice.php?insert=True" </script>';
           }else{

         echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
           }
          
       }else{
        echo "Failed";
       }


      }
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
   
        <!-- Custom Tabs -->
           <div class="box" style="padding-left: 20px;padding-right:20px">
            <br>
          <div class="row">
              <div class="col-md-8"><b><h3>INVOICES</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="createinvoice.php" ><i class="fa fa-plus"></i><b> New Invoice </b></a></div>
            </div>
            
               <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              
                              <th>Reference</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Summary</th>
                              <th>Amount</th>
                              <th>Balance</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               
                               $query2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' ")or
                               die(mysqli_error());
                               $total_amount=0.00;
                               while ($row2=mysqli_fetch_array($query2)){
                                $total_amount= $total_amount + $row2['amount']  ;
                               $invoiveID= $row2['invoice_ID'];
                                $invoive_date= $row2['invoice_date'];
                                $studentid= $row2['student_ID'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                              $query3 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
                              
                               while ($row3=mysqli_fetch_array($query3)){
                                $name=$row3['first_Name']." ".$row3['last_Name'];
                                $reg=$row3['registration_No'];
                                echo' <tr>
                                   <td>   <a href="view_invoice.php?invoice='.$invoiveID.'"> '.$row2['reff_no'].' </a></td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['summury']." </td>
                                        <td>".$row2['amount']."</td>
                                        <td>".$row2['balance']."</td>";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                           <a href="edit_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span></button></a>

                                           <a href="payment.php?invoice_id='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span>Recieve Payment</button></a>

                                         
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              ?>
                           
                             </tbody>
                            
                          </table>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  

     
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


</body>
</html>
