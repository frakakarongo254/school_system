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
           <div class="box">
            <br>
          <div class="row">
              <div class="col-md-8"><b><h3>PAYMENT</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="createinvoice.php" ><i class="fa fa-plus"></i><b> New Invoice </b></a></div>
            </div>
            
               <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              
                              <th>Invoice Reff</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Remark</th>
                              <th>Amount</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               
                               $query2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' ")or
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
                                $query3 = mysqli_query($conn,"select * from invoice where invoice_ID='$invoiceID' and school_ID = '$school_ID' ");
                              
                               while ($row3=mysqli_fetch_array($query3)){
                                $invoice_ref=$row3['reff_no'];
                              $query4 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
                              
                               while ($row4=mysqli_fetch_array($query4)){
                                $name=$row4['first_Name']." ".$row4['last_Name'];
                                $reg=$row4['registration_No'];
                                echo' <tr>
                                   <td>   <a href="view_invoice.php?invoice='.$invoiceID.'"> '.$invoice_ref.' </a></td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row2['remarks']." </td>
                                        <td>".$row2['amount_paid']."</td>
                                        ";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                         <button type="button"  class="btn btn-success btn-flat" id="'.$paymentID.'" onclick="editpayment(this.id)" data-toggle="modal" data-target="#edit_payment_Modal"><span class="glyphicon glyphicon-pencil"></span></button>

                                         <button type="button"  class="btn btn-primary btn-flat" id="'.$paymentID.'" name="'. $slipNo.'" onclick="cancelTransaction(this.id,this.name)" data-toggle="modal" data-target="#cancel_transaction_Modal"><span class="glyphicon glyphicon-"></span>Cancel Transaction</button>
                                       </td>
                                    </tr>';

                               
                              }
                                }
                              }
                              ?>
                           
                             </tbody>
                            
                          </table>
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
      
      alert("OOp! Could not delete the student.Please try again!");
    }
  }
  });
  }
</script>
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
