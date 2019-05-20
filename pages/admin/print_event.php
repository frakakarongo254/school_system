<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $start="";
 $to="";

$type=" ";

 if (isset($_GET['from']) and isset($_GET['to']) ) {
   # code...
  $start=$_GET['from'];
 $to=$_GET['to'];
 $type=$_GET['event_type'];

 }else{
 //"not set";

 }
 

 

  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="150px" width="150px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='150px' width='150px'>";
}

 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $school_row['school_Name']?> | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="../../css/body.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
 <section class="invoice">
      <!-- title row -->
      <div class="row">
       
        
          
        <div class="col-md-12">
          <table class="table ">
            <tr>
              
              <td><?php echo $logo ?> <address id="address">
            <strong> <?php echo  strtoupper($school_row['school_Name']) .'</strong><br>
            Po. Box ' .$school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '. $school_row['email'].'<br>
            Website:'. $school_row['school_website']?>
          </address></td>
            </tr>
          </table>
        </div>
        <!-- /.col -->
      </div>
     

      <!-- Table row -->
      <div class="row">
        <div class="col-md-12 table-responsive">
          
          <?php
              if ($type =="Birthday") {
        ?>
       
        <div id="" class="">
          <div style="font-size:20px;font-weight:800;text-transform:uppercase;text-align:center">Event list For Birthday <b>From: <?php echo date("d-m-Y", strtotime($start)) . "  To  " . date("d-m-Y", strtotime($to)) ?></b> </div>
         <table class="table table-striped">
            <thead>
                <tr>
                  <th> Title</th>
                  <th> Location</th>
                  <th> Date</th>
                  <th> Description</th>
                
                  
                </tr>
                </thead>
                <tbody>
            <?php
           
            $event_query = mysqli_query($conn,"select * from event where date(event_startDate) between date('$start') and date('$to') and school_ID = '".$school_ID."' and event_type='Birthday' ORDER BY event_startDate DESC")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            echo' <tr>

              <td >'.
             $event_row['event_title'].'
             </td>
            <td>'.$event_row["event_location"].'</td>
            <td>'.$event_startDate.'</td>
            
            <td>'.$event_row["event_description"].'</td>
           
                   
            </tr>';
            }
            ?>
          </tbody>
               
              </table>
            </div>
           
        <?php
         
       }else{
         ?>
        <div id="" class="">
          <div style="font-size:20px;font-weight:800;text-transform:uppercase;text-align:center">Event list <b>From: <?php echo date("d-m-Y", strtotime($start)) . "  To  " . date("d-m-Y", strtotime($to)) ?></b> </div>
         <table class="table table-striped">
            <thead>
                <tr>
                  <th >Title</th>
                  <th >Location</th>
                  <th >Starting Date</th>
                   <th>Starting Time</th>
                   <th>Ending Date</th>
                   <th>Ending Time</th>  
                  <th>Description</th>
                
                  
                </tr>
                </thead>
                <tbody>
            <?php
           
            $event_query = mysqli_query($conn,"select * from event where date(event_startDate) between date('$start') and date('$to') and school_ID = '".$school_ID."' ORDER BY event_startDate DESC")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            echo' <tr>

              <td >'.
             $event_row['event_title'].'
             </td>
            <td>'.$event_row["event_location"].'</td>
            <td>'.$event_startDate.'</td>
             <td>'.$event_starttime.'</td>
              <td>'.$event_endDate.'</td>
               <td>'.$endtime.'</td>
            <td>'.$event_row["event_description"].'</td>
           
                   
            </tr>';
            }
            ?>
          </tbody>
               
              </table>
            </div>
           
        
         

      <?php ;}
       ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

      
     
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
