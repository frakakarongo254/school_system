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
        if(isset($_GET['cancel'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have canceled transaction  successfully.
          </div>';   
        }
       
       if (isset($_POST['paymentBtn'])) {
        $payment_id=$_POST['payment_id'];
         $invoice_id=$_POST['invoice_id'];
         $student_id=$_POST['student_id'];
         $balance=$_POST['amount_balance'];
         $amount_paid=$_POST['amount_paid'];
         $slip_no=$_POST['slip_no'];
         $payment_date=$_POST['payment_date'];
         $payment_remarks=$_POST['payment_remarks'];
         $new_balance;
         if ($amount_paid >= $balance ) {
           $new_balance= 0.00;
         }else{
          $new_balance= $balance - $amount_paid;
         }

         
           $update_payment_query=mysqli_query($conn,"update `payment` SET amount_paid= '".$amount_paid."', slip_no= '".$slip_no."',remarks='".$payment_remarks."',payment_date='".$payment_date."' where `payment_ID`='".$payment_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

        
        if($update_payment_query){
           $update_query=mysqli_query($conn,"update `invoice` SET amount_paid= '".$amount_paid."', balance= '".$new_balance."' where `invoice_ID`='".$invoice_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
           if ($update_query) {
            //echo '<script>confirm("Print receipt")</script>';
             echo '<script> window.location="transaction.php?insert=True" </script>';
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
      
    </section>
    <!-- Main content -->
    <section class="content">
   
        <!-- Custom Tabs -->
           <div class="box" style="padding-right: 20px;padding-left: 20px">
            <br>
             <form action="transaction.php" method="POST">
          <div class="row">
           
              <div class="col-md-3"><b style="text-transform: uppercase;color:#27AE60;font-size: 24px;"><strong>payment</strong> </b></div>
              <div class="col-md-3">
                <div class=" input-group input-group-">
              <span class="input-group-addon">FROM:   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="fromDate"  id="" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
              <div class="col-md-3">
                <div class=" input-group input-group-">
              <span class="input-group-addon">TO:   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="toDate"  class="form-control"   placeholder="Ending time" required>
            </div>
              </div>
              <div class="col-md-1 ">
              
              <button type="submit" name="printPaymentBtn" class="btn btn-primary btn-sm" id="button3"><i class="fa fa-filter"></i> Filter</button>
            
                </div>
          
              <div class="col-md-2">
                
              </div>
             
            </div>
          </form>
         <?php
              if (isset($_POST['printPaymentBtn']) and isset($_POST['fromDate']) and isset($_POST['toDate']) ) {
               $printFromDate=$_POST['fromDate'];
               $printFromTo=$_POST['toDate'];

               ?>
                <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              
                              <th>Invoice Ref</th>
                              <th>Receipt No </th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Remark</th>
                              <th>Amount</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               
                               $query2 = mysqli_query($conn,"select * from payment where date(payment_date) between date('$printFromDate') and date('$printFromTo')  and school_ID = '".$school_ID."' ORDER BY date('$printFromDate')  DESC")or
                               die(mysqli_error());
                               $total_amount=0.00;
                               while ($row2=mysqli_fetch_array($query2)){
                                $total_amount= $total_amount + $row2['amount_paid']  ;
                               $invoiceID= $row2['invoice_ID'];
                               $paymentID= $row2['payment_ID'];
                                $invoive_date= $row2['payment_date'];
                                $studentid= $row2['student_ID'];
                                $slipNo= $row2['slip_no'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                                $query3 = mysqli_query($conn,"select * from invoice where invoice_ID='".$invoiceID."' and school_ID = '".$school_ID."' ");
                              
                               while ($row3=mysqli_fetch_array($query3)){
                                $invoice_ref=$row3['reff_no'];
                              $query4 = mysqli_query($conn,"select * from student where student_ID='".$studentid."' and school_ID = '".$school_ID."' ");
                              
                               while ($row4=mysqli_fetch_array($query4)){
                                $name=$row4['first_Name']." ".$row4['last_Name'];
                                $reg=$row4['registration_No'];
                                echo' <tr>
                                   <td>   <a href="view_invoice.php?invoice='.$invoiceID.'"> '.$invoice_ref.' </a></td>';

                                  echo " <td> ".$slipNo."</td>
                                          <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['remarks']." </td>
                                       <td align='right'>".$school_row['currency'] .   "<b> " .formatCurrency($row2['amount_paid'])."</b></td>
                                        ";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                          <a href="#"  class="btn btn-primary badge" id="'.$paymentID.'" onclick="printTransactionFun(this.id)"> <span class="glyphicon glyphicon-print"></span>Print </a>
                                         <button type="button"  class="btn btn-success badge" id="'.$paymentID.'" onclick="editpayment(this.id)" data-toggle="modal" data-target="#edit_payment_Modal"><span class="glyphicon glyphicon-pencil"></span></button>
                                            
                                           <a  href="view_transaction.php?payment_ID='.$paymentID.'"  class="btn btn-success badge" id="'.$paymentID.'" onclick="editpayment(this.id)" ><span class="glyphicon glyphicon-eye-open"></span></a>

                                         <button type="button"  class="btn btn-primary badge" id="'.$paymentID.'" name="'. $slipNo.'" onclick="cancelTransaction(this.id,this.name)" data-toggle="modal" data-target="#cancel_transaction_Modal"><span class="glyphicon glyphicon-"></span>Cancel Transaction</button>
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              }
                              ?>
                           
                             </tbody>
                            
                          </table>
               <?php

             } else {
              ?>
              <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              
                              <th>Invoice Ref</th>
                              <th>Receipt No </th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Remark</th>
                              <th>Amount</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               
                               $query2 = mysqli_query($conn,"select * from payment where school_ID = '".$school_ID."' ORDER BY id DESC")or
                               die(mysqli_error());
                               $total_amount=0.00;
                               while ($row2=mysqli_fetch_array($query2)){
                                $total_amount= $total_amount + $row2['amount_paid']  ;
                               $invoiceID= $row2['invoice_ID'];
                               $paymentID= $row2['payment_ID'];
                                $invoive_date= $row2['payment_date'];
                                $studentid= $row2['student_ID'];
                                $slipNo= $row2['slip_no'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                                $query3 = mysqli_query($conn,"select * from invoice where invoice_ID='".$invoiceID."' and school_ID = '$school_ID' ");
                              
                               while ($row3=mysqli_fetch_array($query3)){
                                $invoice_ref=$row3['reff_no'];
                              $query4 = mysqli_query($conn,"select * from student where student_ID='".$studentid."' and school_ID = '".$school_ID."' ");
                              
                               while ($row4=mysqli_fetch_array($query4)){
                                $name=$row4['first_Name']." ".$row4['last_Name'];
                                $reg=$row4['registration_No'];
                                echo' <tr>
                                   <td>   <a href="view_invoice.php?invoice='.$invoiceID.'"> '.$invoice_ref.' </a></td>';

                                  echo " <td> ".$slipNo."</td>
                                          <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['remarks']." </td>
                                        <td align='right'>".$school_row['currency'] .   "<b> " .formatCurrency($row2['amount_paid'])."</b></td>
                                        ";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                           <a href="#"  class="btn btn-primary badge" id="'.$paymentID.'" onclick="printTransactionFun(this.id)"> <span class="glyphicon glyphicon-print"></span>Print </a>

                                         <button type="button"  class="btn btn-success badge" id="'.$paymentID.'" onclick="editpayment(this.id)" data-toggle="modal" data-target="#edit_payment_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                                           <a  href="view_transaction.php?payment_ID='.$paymentID.'"  class="btn btn-success badge" id="'.$paymentID.'" onclick="editpayment(this.id)" ><span class="glyphicon glyphicon-eye-open"></span></a>

                                         <button type="button"  class="btn btn-primary badge" id="'.$paymentID.'" name="'. $slipNo.'" onclick="cancelTransaction(this.id,this.name)" data-toggle="modal" data-target="#cancel_transaction_Modal"><span class="glyphicon glyphicon-"></span>Cancel Transaction</button>
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              }
                              ?>
                           
                             </tbody>
                            
                          </table>


            <?php ;}
         ?>
            
               
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  

       
           <!-- delete Invoice  Modal-->
    <div class="modal  fade" id="edit_payment_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>PAYMENT </b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editpayment(payment_id){ 
               // alert(invoice_id);
                  if(payment_id !=''){
                    var details= '&payment_id='+ payment_id ;
                    $.ajax({
                    type: "POST",
                    url: "editpayment.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      //alert(data)
                      document.getElementById("Message").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("Message").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="Message"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>
    <!-- #cancel transaction -->
     <div class="modal  fade" id="cancel_transaction_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cancel Transaction</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function cancelTransaction(payment_id,payment_slip_no){
                 
                 document.getElementById("msg").innerHTML=' Are you sure you want to cancel this transaction with slip no <b style="font-size:20px"> ' + payment_slip_no + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
               
                    updiv.innerHTML ='<form method="POST" action=""><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">No</button><button class="btn btn-danger pull-left" name="deletebuttonFunc" id="'+ payment_id +'" type="submit" data-dismiss="modal" onclick="cancelTransactionFromSystem(this.id)">Yes</button></form></div>';
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

     <div class="modal fade" id="modal-printInvoice">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Print Payment List</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="print_payment_list.php" method="POST" target="_blank">
          
          
           
          <br>
           <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">FROM:   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="printFromDate"  id="printFromDate" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
          
          </div>
           
          <br>
           
          <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">TO:   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="printToDate" id="printToDate" class="form-control"   placeholder="Ending time" required>
            </div>
          </div>
          
          </div>
          <br>
           
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="printTransactionBtn"  class="btn btn-primary">Print</button>
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
<script type="text/javascript">
 function cancelTransactionFromSystem(payment_id){
  
   
  var details= '&payment_id='+ payment_id;
  $.ajax({
  type: "POST",
  url: "canceltransaction.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
     
 window.location="transaction.php?cancel=True" 
    }else{
      
      alert("OOp! Could not delete.Please try again!");
    }
  }
  });
  }



  //<!--priny payment list -->
  
</script>
 <script>
function printTransactionFun(transaction_id) {

    
     window.open("print_receipt.php?payment_id="+transaction_id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=,left=,width=1000,height=1000");
  
  
 
}
</script>
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
