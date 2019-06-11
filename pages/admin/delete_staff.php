<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}


 $string = $_POST['staff_id'];
$str_arr = preg_split ("/\,/", $string);  

$delete_query='';
  if (!empty($_POST['staff_id'])) {
          # code...
       // for($i = 0; $i<count($_POST['check']); $i++)
     foreach ($str_arr as $i )  
     {  
  //echo $studentID=[$i];
  $delete_query=mysqli_query($conn,"DELETE FROM staff WHERE `staff_ID`='".$i."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");

      }
      if ($delete_query) {
//	header("Refresh:0; url=http://localhost/hardware/user.php");
echo 'success';

}else {
echo  'failed'; 
}
    }


?>