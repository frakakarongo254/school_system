<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$voteHead_id = $_POST['voteHead_id'];
 
		$delete_query=mysqli_query($conn,"DELETE FROM vote_head WHERE `vote_head_ID`='".$voteHead_id."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
	echo 'success';
	
	}else {
    echo  'failed'; 
}


?>