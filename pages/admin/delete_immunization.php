<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$immunization_id = $_POST['immunization_id'];



		$delete_query=mysqli_query($conn,"DELETE FROM immunization WHERE `immunization_ID`='".$immunization_id."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	echo 'success';
	
}else {
echo  'failed'.mysqli_error($conn); 
}

	


?>