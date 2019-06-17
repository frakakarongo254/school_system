<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
//$stdID=array();
 $string = $_POST['student_id'];
$str_arr = preg_split ("/\,/", $string);  

$delete_quer='';
$delete_query='';
  if (!empty($_POST['student_id'])) {
          # code...
       // for($i = 0; $i<count($_POST['check']); $i++)
     foreach ($str_arr as $i )  
     {  
  //echo $studentID=[$i];
  $delete_query=mysqli_query($conn,"DELETE FROM student WHERE `student_ID`='".$i."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
   $delete_quer=mysqli_query($conn,"DELETE FROM event WHERE `student_ID`='".$i."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
      }
      if ( $delete_quer and $delete_query ) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
echo 'success';

}else {
echo  'failed'; 
}
    }

		


?>