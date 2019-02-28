<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$invoice_item_ID = $_POST['invoice_item_id'];

 $item_sql = mysqli_query($conn,"select * from `invoice_item` where `invoice_item_ID` = '".$invoice_item_ID."' and `school_ID` = '".$school_ID."' ");
$item_row = mysqli_fetch_array($item_sql,MYSQLI_ASSOC);
 $item_total=$item_row['amount'];
 $invoice_ID=$item_row['invoice_id'];
 #get details from invoice
$sql2 = mysqli_query($conn,"select amount from `invoice` where `invoice_ID` = '".$invoice_ID."' and `school_ID` = '".$school_ID."' ");
$row021= mysqli_fetch_array($sql2,MYSQLI_ASSOC);
 $tot=$row021['amount'];
$newInvoice_amount= $tot - $item_total;
 if ($newInvoice_amount <= 0) {
 	$newInvoice_amount=0.00;
 }
#update invoice amount
 $update_invoice_query=mysqli_query($conn,"update `invoice` SET amount= '".$newInvoice_amount."' where `invoice_ID`='".$invoice_ID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

if ($update_invoice_query) {
		$delete_query=mysqli_query($conn,"DELETE FROM invoice_item WHERE `invoice_item_ID`='".$invoice_item_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	if ($newInvoice_amount == 0.00) {
		$de_query=mysqli_query($conn,"DELETE FROM invoice WHERE `invoice_ID`='".$invoice_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
		if($de_query){
		echo 'success';

		}else {
		echo  'failed'.mysqli_error($conn); 
		}

	}
	
}
}
	


?>