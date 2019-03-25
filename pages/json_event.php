<?php require('include/session.php');
$school_ID = $_SESSION['login_user_school_ID'];
$query_event = mysqli_query($conn,"select * from event where school_ID = '$school_ID'")or
die(mysqli_error());
$events = array();
foreach ($query_event as $row_event) {
    $events[] = array (
        'title' => $row_event['event_title'],
        'start' => date('Y-m-d H:i:s', strtotime($row_event['event_startDate'])),
        'end' => date('Y-m-d H:i:s', strtotime($row_event['event_endDate'])),
        'backgroundColor'=>$row_event['event_color'], //yellow
        'borderColor'    => $row_event['event_color'] //yellow
    );

}

echo json_encode($events);

?>