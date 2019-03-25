 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}
include("include/header.php");

  $event_id = $_POST['event_id'];
  $query_event_details = mysqli_query($conn,"select * from `event` where `event_ID` = '".$event_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_event = mysqli_fetch_array( $query_event_details,MYSQLI_ASSOC);
     $title=$rows_event["event_title"];
     $location=$rows_event["event_location"];
      $start=$rows_event["event_startDate"];
      $event_startDate = date("d-m-Y", strtotime($start));
      $event_starttime = $rows_event["event_startime"];
      $event_endDate=$rows_event["event_endDate"];
      $end = date("d-m-Y", strtotime($end));
      $event_endtime = $rows_event["event_startime"];

      $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
          $senderemail=$senderemail_row['sender_signature'];
        //$recipient_ID=$get_parentID;
        $from=$senderemail_row['sender_email'];
        $fromName=$senderemail_row['sender_name'];
        $footer=$senderemail_row['sender_signature'];
        $to=$_POST['email_to'];
        $subject="Event Notification";
        $msg="Dear Parent<br> We wish to notify you about <b> " .$title. "</b >  event  that will start on ".  $event_startDate." ".$event_starttime . "to". $event_endDate ." ". $event_endtime. "at ". $location." <br> Kindly plan to attend.";
         $message=$msg ." <br>".  $senderemail;
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $send; 
     $query2 = mysqli_query($conn,"select email from parents where school_ID = '$school_ID'")or
                   die(mysqli_error());
                   $to=array();
                   while ($row1=mysqli_fetch_array($query2)){
                   $to= $row1['email'];
             $send =  mail($to, $subject, $body, $headers);
                 
                 }
                 echo $to;

        if ($send) {
          # code...
          echo "success";
        }else{
          echo "failed";
        }
include('include/script.php');
?>
 
