<?php require('include/session.php');
$school_ID = $_SESSION['login_user_school_ID'];
$login_parent_ID=$_SESSION['login_user_ID'];
 $query3 = mysqli_query($conn,"select parent_relation.student_ID from parent_relation where school_ID = '".$school_ID."' && parent_ID='".$login_parent_ID."'");
 $events = array();
 foreach ($query3 as $que) {
 	$stdID=$que['student_ID'];
$query_event = mysqli_query($conn,"select * from event where school_ID = '".$school_ID."' and event_for='All' || event_for='Parent' || student_ID='".$stdID."' ")or
die(mysqli_error());

foreach ($query_event as $row_event) {
    $events[] = array (
        'title' => $row_event['event_title'],
        'start' => date('Y-m-d H:i:s', strtotime($row_event['event_startDate'])),
        'end' => date('Y-m-d H:i:s', strtotime($row_event['event_endDate'])),
        'backgroundColor'=>$row_event['event_color'], //yellow
        'borderColor'    => $row_event['event_color'] //yellow
    );

}

}

echo json_encode($events);
?>