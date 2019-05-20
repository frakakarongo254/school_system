<?php require('include/config.php');
$school_ID = $_SESSION['login_user_school_ID'];
$reportGraph = array();
$balance=0.00;
$total_amount_paid=0.00;
 $amt_invoiced=0.00;
$que2 = mysqli_query($conn,"select * from payment where school_ID = '".$school_ID."' ")or
          die(mysqli_error());
                         
           while ($row_p=mysqli_fetch_array($que2)){
                             
        $total_amount_paid=  $total_amount_paid + $row_p['amount_paid'];
         }

$query44 = mysqli_query($conn,"select * from invoice where school_ID = '".$school_ID."' ")or
          die(mysqli_error());
                              
           while ($row33=mysqli_fetch_array($query44)){
           $amt_invoiced= $amt_invoiced + $row33['amount'];
                                     //$total=$total + $amt;
           }         
 
 $balance = $amt_invoiced - $total_amount_paid;

  if ($balance < 0) {
    # code...
     $balance =0.00;
  }

 

 $reportGraph = array(
  array("label"=> "Payment", "y"=> $total_amount_paid),
  array("label"=> "Invoice", "y"=> $amt_invoiced),
  array("label"=> "Balance", "y"=> $balance),
 
);
//echo json_encode($reportGraph);
//echo json_encode($reportGraph, JSON_NUMERIC_CHECK)

?>