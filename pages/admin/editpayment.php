 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
  $school_ID=$_SESSION['login_user_school_ID'];
 $get_payment_ID="";
 if (isset($_POST['payment_id'])) {
   # code...
 $get_payment_ID=$_POST['payment_id'];
 }

 $sql022 = mysqli_query($conn,"select * from `payment` where  payment_ID='".$get_payment_ID."' and `school_ID` = '".$school_ID."' ");
 $row022 = mysqli_fetch_array($sql022 ,MYSQLI_ASSOC);
 $invoiceID=$row022['invoice_ID'];
 $amount_paid= $row022['amount_paid'];
 $payment_date=$row022['payment_date'];
 $payment_remarks=$row022['remarks'];
 $payment_slip_no=$row022['slip_no'];
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='".$invoiceID."' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
 $invoice_student_id=$row02['student_ID'];
 $invoice_amt_paid=$row02['amount_paid'];
 $invoice_balance=0.00;
 $inv_Bal=$invoice_amount - $invoice_amt_paid;
 if ($inv_Bal <0) {
   # code...
  $invoice_balance=0.00;
 }else{
  $invoice_balance=$inv_Bal;
 }

  #get student details
$sql03 = mysqli_query($conn,"select * from `student` where  student_ID='".$invoice_student_id."' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
 



echo '<form  action="transaction.php" method="POST">
           <div class="row">
           
           <div class="col-md-6">
            
              <lable><b class="pull-center">NAME:</b><lable>
              <input type="hidden"name="invoice_id" value="'.$invoice_ID.'" >
              <input type="hidden"name="student_id" value="'.$studentId.'" >
               <input type="hidden"name="payment_id" value="'. $get_payment_ID.'" >
              <input type="text" name="student_name"  class="form-control"   placeholder="title" value="'.$studentName.'" readonly>
            
            </div>
            <div class="col-md-6 ">
            <lable><b>ADM NO</b></lable>
              <input type="text" name="edit_event_location"  class="form-control"  value="'.$row03['registration_No'].'" placeholder="location" readonly>
            </div>
          </div>
           <br>
            <div class="row">
            <div class="col-md-6 ">
            <lable><b>TOTAL AMOUNT</b></lable>

               <input type="text" name="total_amount"  id="datepicker" class="form-control"  value="'.$school_row['currency'] ." ".formatCurrency($row02['amount']).'" placeholder="total amount" readonly>
            </div>
           <div class="col-md-6">
              <lable><b>BALANCE:</b></lable>
              <input type="hidden"name="amount_balance" value="'.$invoice_balance.'" >

              <input type="text" name="balance"  value="'.$school_row['currency'] .   " " .formatCurrency($invoice_balance).'"  class="form-control"  placeholder="Ending time" readonly>
            </div>
            </div>
          </div>
          <br>
          
           
          
          <br>
          <div class="row">
           
           <div class="col-md-6">
           <lable><b>AMOUNT PAID:</b></lable>
              <input type="number" name="amount_paid"    class="form-control" value="'.$amount_paid.'" placeholder="Amount Paid" step="0.00" min="0" >
            </div>
             <div class="col-md-6 ">
             <lable><b class="pull-center">SLIP NO:</b></lable>
              <input type="text" name="slip_no"    class="form-control" value="'.$payment_slip_no.'" placeholder="SLIP NO" >
             </div>
          </div>
          </div>
          <br>
           <div class="row">
            <div class="col-md-6 ">
            <lable><b class="pull-center">Date of Payment:</b></lable>
            <input type="date" name="payment_date"    class="form-control" value="'.$payment_date.'" placeholder="payment date" >
            </div>
           <div class="col-md-6">
           <lable><b class="pull-center">Remarks:</b></lable>
               <textarea class="form-control" name="payment_remarks">'.$payment_remarks.'</textarea>
            </div>
          </div>
          </div>
          <br>
          
          <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="paymentBtn" class="btn btn-primary">Save</button>
              </div>
              </div>
             </form>';

           
?>
 
