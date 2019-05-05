<?php @session_start();


    include("config.php");
   
   
   $user_check = $_SESSION['login_user'];
   if (isset($user_check)) {
     # code...
   
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

    $school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
     $school_row['school_Name'];
   
   #currency formatting
    function formatCurrency($num){

$formattedNum = number_format($num, 2);
return $formattedNum;
     }
   
   function velifyLogin(){
	if (isset($_SESSION['login_user_email']) && isset($_SESSION['login_user_school_ID'])) {
		return true;
	}else{
		return false;
	}
   
    
}

}else{
  header('location: ../../index.php');
}
?>
