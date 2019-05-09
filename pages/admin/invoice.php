<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
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
        if(isset($_GET['invoice'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Invoice created successfuly.
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

         $randPay = substr(number_format(time() * rand(),0,'',''),0,11);
         $payment_ID=md5($randPay);
         $new_balance;
         if ($amount_paid >= $balance ) {
           $new_balance= 0.00;
         }else{
          $new_balance= $balance - $amount_paid;
         }

          $payment_query=mysqli_query($conn,"insert into `payment` (payment_ID,school_ID,student_ID,invoice_ID,amount_paid, slip_no,remarks,payment_date,payment_method
          ) 
          values('$payment_ID','$school_ID','$student_id','$invoice_id','$amount_paid','$slip_no','$payment_remarks','$payment_date','$payment_method') ");

        
        if($payment_query){
           $update_query=mysqli_query($conn,"update `invoice` SET amount_paid= '".$amount_paid."', balance= '".$new_balance."' where `invoice_ID`='".$invoice_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
           if ($update_query) {
             $que02=mysqli_query($conn,"insert into `statement` (student_ID,school_ID, Credit,ref_no,date_created,description) 
        values('$studentID','$school_ID','$amount_paid','$slip_no','$payment_date','$payment_remarks') ");

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
           <div class="box" style="padding-left: 10px;padding-right:10px">
            <br>
            
             <form action="invoice.php" method="POST">
          <div class="row">
           
              <div class="col-md-1"></div>
              <div class="col-md-3">
                <div class=" input-group input-group-">
              <span class="input-group-addon">FROM:   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="printFromDate"  id="" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
              <div class="col-md-3">
                <div class=" input-group input-group-">
              <span class="input-group-addon">TO:   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="printToDate"  class="form-control"   placeholder="Ending time" required>
            </div>
              </div>
              <div class="col-md-1 ">
              
              <button type="submit" name="printInvoiceBtn" class="btn btn-primary btn-" id="button2"><i class="fa fa-filter"></i> Filter</button>
            
                </div>
          
              <div class="col-md-2">
                <a class="btn btn-primary btn-sm " href="createinvoice.php" id="button3" ><i class="fa fa-plus"></i><b> New Invoice</b></a>
              </div>
              <div class="col-md-2"> <a class="btn btn-success btn-sm" href="" id="button2" data-toggle="modal" data-target="#modal-printInvoice"><i class="fa fa-print"></i><b> Print</b></a></div>
            </div>
          </form>
          <?php
            if (isset($_POST['printInvoiceBtn']) and isset($_POST['printFromDate']) and isset($_POST['printToDate']) ) {
               $printFromDate=$_POST['printFromDate'];
               $printFromTo=$_POST['printToDate'];
               ?>
               <div class="table-responsive">
                
               <table id="example2" class="table table-bordered table-striped">
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
                               
                               $query2 = mysqli_query($conn,"select * from invoice where  date(invoice_date) between date('$printFromDate') and date('$printFromTo')  and school_ID = '$school_ID' ORDER BY date('$printFromDate')  DESC ")or
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
                                   <td> <span class="hidden">'.$invoiveID.'</span>  <a href="view_invoice.php?invoice='.$invoiveID.'"> '.$row2['reff_no'].' </a></td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['summury']." </td>
                                        <td>".$school_row['currency'] .   "<b> " .formatCurrency($row2['amount'])."</b></td>
                                        <td>".$school_row['currency'] .   "<b> " .formatCurrency($row2['balance'])."</b></td>";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                          <a href="print_invoice.php?invoice_id='.$invoiveID.'" target="_blank" class="btn btn-primary badge"> <span class="glyphicon glyphicon-print"></span>Print </a>

                                           <a href="edit_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success badge" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span></button></a>

                                           <a href="payment.php?invoice_id='.$invoiveID.'"><button type="button"  class="btn btn-success badge" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span>Recieve Payment</button></a>

                                         
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              ?>
                           
                             </tbody>
                            
                          </table>
                        </div>

            <?php }else{
              ?>
           
               <table id="example2" class="table table-bordered table-striped">
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
                               
                               $query2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' ORDER BY id  DESC ")or
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
                                   <td> <span class="hidden">'.$invoiveID.'</span>  <a href="view_invoice.php?invoice='.$invoiveID.'"> '.$row2['reff_no'].' </a></td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['summury']." </td>
                                        <td>".$school_row['currency'] .   "<b> " .formatCurrency($row2['amount'])."</b></td>
                                        <td>".$school_row['currency'] .   "<b> " .formatCurrency($row2['balance'])."</b></td>";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                          <a href="print_invoice.php?invoice_id='.$invoiveID.'" target="_blank" class="btn btn-primary badge"> <span class="glyphicon glyphicon-print"></span>  Print </a>
                                          
                                           <a href="edit_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success badge" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span></button></a>

                                           <a href="payment.php?invoice_id='.$invoiveID.'"><button type="button"  class="btn btn-success badge" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span>Recieve Payment</button></a>

                                         
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              ?>
                           
                             </tbody>
                            
                          </table>
                         <?php ;}?>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  

       <div class="modal fade" id="modal-printInvoice">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Print Invoices</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="print_invoice_list.php" method="POST" target="_blank">
          
          
           
          <br>
           <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">FROM:   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="fromDate"  id="" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
          
          </div>
           
          <br>
           
          <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">TO:   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="toDate"  class="form-control"   placeholder="Ending time" required>
            </div>
          </div>
          
          </div>
          <br>
           
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="printEventBtn" class="btn btn-primary">Print</button>
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
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>


</body>
</html>
