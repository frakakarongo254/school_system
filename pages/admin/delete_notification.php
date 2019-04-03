<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$notification_id = $_POST['notification_id'];
 
		$delete_query=mysqli_query($conn,"DELETE FROM notification WHERE `notification_ID`='".$notification_id."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	echo 'success';
	
	}else {
    echo  'failed'; 
}


?>