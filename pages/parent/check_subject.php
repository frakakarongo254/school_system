<?php include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
   header('location: ../../index.php');
}
$class_id = $_POST['class_ID'];
 
$result01 = mysqli_query($conn,"select * from subject where class_ID ='$class_id ' ");
//$result01 = mysqli_query($conn, $query01); 

  while($row01 = $result01->fetch_array()) 
  {
  echo '<option value="'. $row01["subject_ID"].'">'. $row01["name"].'</option>';
  }


?>