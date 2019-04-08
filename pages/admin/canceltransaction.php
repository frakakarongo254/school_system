<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../ndex.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$payment_ID = $_POST['payment_id'];

#
 $sql022 = mysqli_query($conn,"select * from `payment` where  payment_ID='$payment_ID' and `school_ID` = '".$school_ID."' ");
 $row022 = mysqli_fetch_array($sql022 ,MYSQLI_ASSOC);
 $invoiceID=$row022['invoice_ID'];
 $amount_paid=$row022['amount_paid'];
 $slip_no=$row022['slip_no'];
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$invoiceID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 $invoice_amount=$row02['amount'];
  $invoice_balance=$row02['balance'];
$new_balance=$invoice_balance + $amount_paid;
$new_amount_paid=0.00;

 $update_invoice_query=mysqli_query($conn,"update `invoice` SET amount_paid= '".$new_amount_paid."',balance='".$new_balance."' where `invoice_ID`='".$invoice_ID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


if ($update_invoice_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	
 $delete_query=mysqli_query($conn,"DELETE FROM statement WHERE `ref_no`='".$slip_no."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");

$delete_query=mysqli_query($conn,"DELETE FROM payment WHERE `payment_ID`='".$payment_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
		if($delete_query){
		echo 'success';

		}else {
		echo  'failed'.mysqli_error($conn); 
		}

	
	
}else{
	echo "Failed".mysqli_error($conn);
}

	


?>