<?php require('include/session.php');
$school_ID = $_SESSION['login_user_school_ID'];


$events = array();

 $start='';
 $end='';
	
		$query=mysqli_query($conn,"SELECT event.event_title,event.event_type as tp,event.event_startDate,event.event_endDate,event.event_color,MONTH(event.event_startDate) as m,DAY(event.event_startDate) as d FROM event where school_ID = '".$school_ID."' ");
        foreach ($query as $ques) {
		if ($ques['tp']=='Birthday') {
			$yearBegin = date("Y");
    
     $srt = $yearBegin . "-" . $ques['m'] . "-" . $ques['d'];
     $start= date('Y-m-d H:i:s', strtotime( $srt));
    $ed= $yearBegin . "-" . $ques['m'] . "-" . $ques['d'];
    $end=date('Y-m-d H:i:s', strtotime($ed));
		}else{
	$start=date('Y-m-d H:i:s', strtotime($ques['event_startDate']));
	$end=date('Y-m-d H:i:s', strtotime($ques['event_endDate']));	
		}
		
    $events[] = array (
        'title' => $ques['event_title'],
        'start' => $start,
        'end' => $end,
        'backgroundColor'=>$ques['event_color'], //yellow
        'borderColor'    => $ques['event_color'] //yellow
    );
     
   }
	

echo json_encode($events);


?>