<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
  $school_ID=$_SESSION['login_user_school_ID'];
 $get_payment_ID="";
 if (isset($_GET['payment_id'])) {
   # code...
 $get_payment_ID=$_GET['payment_id'];
 }

 $sql022 = mysqli_query($conn,"select * from `payment` where  payment_ID='$get_payment_ID' and `school_ID` = '".$school_ID."' ");
 $row022 = mysqli_fetch_array($sql022 ,MYSQLI_ASSOC);
 $invoiceID=$row022['invoice_ID'];
 $amount_paid=$row022['amount_paid'];
 $payment_date=$row022['payment_date'];
 $payment_remarks=$row022['remarks'];
 $payment_slip_no=$row022['slip_no'];
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$invoiceID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
  $invoice_student_id=$row02['student_ID'];
  $invoice_balance=$row02['balance'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
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
             echo '<script> window.location="edit_transaction.php?payment_id='.$get_payment_ID.'&insert=True" </script>';
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Edit Transaction</h3> </b></div>
              
            </div>
            
            <!-- /.box-header -->
            <div class="box-body" style="padding-left: 20px;padding-right: 20px">
          
        <form  action="edit_transaction.php?payment_id=<?php echo $get_payment_ID?>" method="POST">
           <div class="row">
           
           <div class="col-md-6">
            
              <lable><b class="pull-center">NAME:</b><lable>
              <input type="hidden"name="invoice_id" value="<?php echo $invoice_ID ?>" >
              <input type="hidden"name="student_id" value="<?php echo $studentId ?>" >
               <input type="hidden"name="payment_id" value="<?php echo  $get_payment_ID ?>" >
              <input type="text" name="student_name"  class="form-control"   placeholder="title" value="<?php echo $studentName ?>" readonly>
            
            </div>
            <div class="col-md-6 ">
            <lable><b>ADM NO</b></lable>
              <input type="text" name="edit_event_location"  class="form-control"  value="<?php echo $row03['registration_No'] ?>" placeholder="Adm" readonly>
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
          <div class="row">
           
           <div class="col-md-6">
           <lable><b>AMOUNT PAID:</b></lable>
              <input type="number" name="amount_paid"    class="form-control" value="<?php echo $amount_paid?>" placeholder="Amount Paid" step="0.00" min="0" >
            </div>
             <div class="col-md-6 ">
             <lable><b class="pull-center">SLIP NO:</b></lable>
              <input type="text" name="slip_no"    class="form-control" value="<?php echo $payment_slip_no ?>" placeholder="SLIP NO" >
             </div>
          </div>
         
          <br>
           <div class="row">
            <div class="col-md-6 ">
            <lable><b class="pull-center">Date of Payment:</b></lable>
            <input type="date" name="payment_date"    class="form-control" value="<?php echo $payment_date ?>" placeholder="payment date" >
            </div>
           <div class="col-md-6">
           <lable><b class="pull-center">Remarks:</b></lable>
               <textarea class="form-control" name="payment_remarks"><?php echo $payment_remarks?></textarea>
            </div>
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
