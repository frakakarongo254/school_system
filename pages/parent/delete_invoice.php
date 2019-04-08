<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$invoice_ID = $_POST['invoice_id'];

#


$delete_query=mysqli_query($conn,"DELETE FROM invoice_item WHERE `invoice_id`='".$invoice_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	
		$de_query=mysqli_query($conn,"DELETE FROM invoice WHERE `invoice_ID`='".$invoice_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
		if($de_query){
		echo 'success';

		}else {
		echo  'failed'.mysqli_error($conn); 
		}

	
	
}else{
	echo "Failed".mysqli_error($conn);
}

	


?>