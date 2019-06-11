<?php require('include/config.php');//require('include/session.php');
$school_ID = $_SESSION['login_user_school_ID'];
$reportGraph = array();
$balance=0.00;
$total_amount_paid=0.00;
 $amt_invoiced=0.00;
$que2 = mysqli_query($conn,"SELECT sum(case when gender_MFU = 'Male' then 1 else 0 end) males,
  sum(case when gender_MFU = 'Female' then 1 else 0 end) females,
  count(*) total
FROM  student where school_ID='".$school_ID."'" )or
          die(mysqli_error());
          foreach ($que2 as  $value) {
      
      $pieReportGraph = array(
  array("label"=> "Male", "y"=> $value['males']),
  array("label"=> "Female", "y"=> $value['females']),
  
 
);
            # code...
          }
                         
           

 

 
//echo json_encode($reportGraph);
//echo json_encode($pieReportGraph, JSON_NUMERIC_CHECK)

?>