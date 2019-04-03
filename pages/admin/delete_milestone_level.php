<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$milestone_level_id = $_POST['milestone_level_id'];



		$delete_query=mysqli_query($conn,"DELETE FROM milestone_levels WHERE `milestone_level_ID`='".$milestone_level_id."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	echo 'success';
	
}else {
echo  'failed'.mysqli_error($conn); 
}

	


?>