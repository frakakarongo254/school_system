<?php @session_start();


    include("config.php");
   
   
   $user_check = $_SESSION['login_user'];
   //$user_level = $_SESSION['login_user_level'];
   
   $ses_sql = mysqli_query($conn,"select * from `parents` where `email` = '".$user_check."' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   //get users details
   $_SESSION['login_user_fname'] = $row['first_Name'];
   $_SESSION['login_user_sname'] = $row['last_Name'];
   $_SESSION['login_user_fullName']= $row['first_Name'] .' '.$row['last_Name'];
   $_SESSION['login_user_school_ID']= $row['school_ID'];
   $_SESSION['login_user_email'] = $row['email'];
   $_SESSION['login_user_ID'] = $row['parent_ID'];
   $_SESSION['login_user_photo'] = $row['photo'];
  // $_SESSION['login_user_role'] = $row['role'];
   
   function velifyLogin(){
	if (isset($_SESSION['login_user_email']) && isset($_SESSION['login_user_school_ID'])) {
		return true;
	}else{
		return false;
	}
   
    
}
?>
