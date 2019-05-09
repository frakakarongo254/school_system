<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}

 $school_ID=$_SESSION['login_user_school_ID'];
 $get_invoice_ID="";
 $page="";
 if (isset($_GET['invoice_id'])) {
   # code...
  $get_invoice_ID=$_GET['invoice_id'];
 //$page=$_POST['page'];
 }
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$get_invoice_ID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
 $invoice_student_id=$row02['student_ID'];
  $invoice_balance=$row02['balance'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID='".$invoice_student_id."' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
 
#Generate automatic receipt number
 time();
$receipt_No = "REC-".substr(number_format(time() * rand(),0,'',''),0,5);
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
          Success! payment was  successfully.
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
        values('$student_id','$school_ID','$amount_paid','$slip_no','$payment_date','$payment_remarks') ");

             echo '<script> window.location="invoice.php?invoice_id='.$get_invoice_ID.'&insert=True" </script>';
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Payment</h3> </b></div>
              
            </div>
            
            <!-- /.box-header -->
            <div class="box-body" style="padding-left: 20px;padding-right: 20px">
          
         <form  action="payment.php?invoice_id=<?php echo $get_invoice_ID ;?>" method="POST">
           <div class="row">
           
           <div class="col-md-6">
            
              <lable><b class="pull-center">NAME:</b><lable>
              <input type="hidden"name="invoice_id" value="<?php echo $invoice_ID ?>" >
              <input type="hidden"name="student_id" value="<?php echo $studentId ?>" >
              <input type="text" name="student_name"  class="form-control"   placeholder="title" value="<?php echo $studentName ?>" readonly>
            
            </div>
            <div class="col-md-6 ">
            <lable><b>ADM NO</b></lable>
              <input type="text" name="edit_event_location"  class="form-control"  value="<?php echo $row03['registration_No'] ?>" placeholder="location" readonly>
            </div>
          </div>
           <br>
            <div class="row">
            <div class="col-md-6 ">
            <lable><b>TOTAL AMOUNT</b></lable>

               <input type="text" name="total_amount"  id="datepicker" class="form-control"  value="<?php echo $invoice_amount ?>" placeholder="total amount" readonly>
            </div>
           <div class="col-md-6">
              <lable><b>BALANCE:</b></lable>
              <input type="hidden"name="amount_balance" value="<?php echo $invoice_balance ?>" >

              <input type="text" name="balance"  value="<?php echo $invoice_balance ?>"  class="form-control"  placeholder="Ending time" readonly>
            </div>
            </div>
          
          <br>
          
           
          
          <br>
          <div class="row">
           
           <div class="col-md-6">
           <lable><b>AMOUNT PAID:</b></lable>
              <input type="number" name="amount_paid"    class="form-control"  placeholder="Amount Paid" step="0.00" min="0" >
            </div>
             <div class="col-md-6 ">
             <lable><b class="pull-center">SLIP NO:</b></lable>
              <input type="hidden" name="slip_no"  value="<?php echo $receipt_No ?>"  class="form-control"  placeholder="SLIP NO" >
              <input type="text" name="slip_no"  value="<?php echo $receipt_No ?>"  class="form-control"  placeholder="SLIP NO" readonly>
             </div>
          </div>
          <br>
          <br>
           <div class="row">
            <div class="col-md-6 ">
            <lable><b class="pull-center">Date of Payment:</b></lable>
            <input type="date" name="payment_date"    class="form-control"  placeholder="payment date" >
            </div>
           <div class="col-md-6">
           <lable><b class="pull-center">Payment Method:</b></lable>
               <select class="form-control select1" name="payment_Mode">';
             <?php  $query3 = mysqli_query($conn,"select * from payment_mode where  school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row3=mysqli_fetch_array($query3)){
           echo '<option value="'.$row3['mode_name'].'">'.$row3['mode_name'].'</option>';
        }
             ?></select>
            </div>
          </div>
          <br>
          <div class="row">
          <div class="col-md-6">
           <lable><b class="pull-center">Remarks:</b></lable>
               <textarea class="form-control" name="payment_remarks"></textarea>
            </div>
          </div>
          <br>
          
          <br>
            <div class="row">
              <div class="col-md-12">
               
                <button type="submit" name="paymentBtn" class="btn btn-primary">Save</button>
              </div>
              </div>
             </form>
             
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
  function deleteZoneFromSystem(zone_id){
  alert(zone_id);
  var details= '&zone_id='+ zone_id;
  $.ajax({
  type: "POST",
  url: "delete_zone.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="zone.php?delete=True" 
    }else{
      alert("OOp! Could not delete the Zone.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
