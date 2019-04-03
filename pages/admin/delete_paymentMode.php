<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$paymentMode_id = $_POST['paymentMode_id'];
 
		$delete_query=mysqli_query($conn,"DELETE FROM payment_mode WHERE `paymentMode_ID`='".$paymentMode_id."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	echo 'success';
	
	}else {
    echo  'failed'; 
}


?>