<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$school_ID =$_SESSION['login_user_school_ID'];
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];
include("include/header.php");
include("include/fusioncharts.php");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <?php include("include/top_navbar.php");?>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        
      </section>

      <!-- Main content -->
      <section class="content">
        
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Dashboard</h3>
          </div>
          <div class="box-body">
              <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                       <p><b><h2>Total Invoice Value</h2></b></p>
                       <?php
                              
                                        $amt_invoiced=0.00;
                                       $query21 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                                     die(mysqli_error());
                                     while ($row11=mysqli_fetch_array($query21)){
                                     $student_Id = $row11['student_ID'];
                                     $total=0.00;
                                     $query33 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$student_Id'")or
                                     die(mysqli_error());
                                     while ($row22=mysqli_fetch_array($query33)){
                                      $std_Id = $row22['student_ID'];
                                      // $name= $row2['first_Name']." ".$row2['last_Name'];
                                      $query44 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' && student_ID='$std_Id'")or
                                     die(mysqli_error());
                                     $std_name;
                                     
                                     while ($row33=mysqli_fetch_array($query44)){
                                      $amt_invoiced= $amt_invoiced + $row33['amount'];
                                         //$total=$total + $amt;
                                     }
                                   }
                                 }
                               echo  "<h1>Ksh ".$amt_invoiced.".00 </h1>";
                                       ?>

                     
                    </div>
                    <div class="icon">
                      <i class="ion ion-"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                     
                          <p><b><h2>Total Amount Paid</h2></b></p>

                      <p>
                        
                         <?php
                               
                                    $total_amount_paid=0.00;
                                    $amount_query = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                                     die(mysqli_error());
                                     while ($row_amount=mysqli_fetch_array($amount_query)){
                                     $studentId = $row_amount['student_ID'];
                                     
                                     $que= mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$studentId'")or
                                     die(mysqli_error());
                                     while ($row_std=mysqli_fetch_array($que)){
                                      $stdId = $row_std['student_ID'];
                                      // $name= $row2['first_Name']." ".$row2['last_Name'];
                                      $que2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' && student_ID='$stdId'")or
                                     die(mysqli_error());
                                     $std_name;
                                     
                                     while ($row_p=mysqli_fetch_array($que2)){
                                     
                                      $total_amount_paid=  $total_amount_paid + $row_p['amount_paid'];
                                     }
                                   }
                                 }
                                echo  "<h1>Ksh ".$total_amount_paid.".00 </h1>";
                                       ?>
                      </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                        <p><h2><b>Balance</b></h2>
                        <?php echo '<h1>Ksh '. $tol=$amt_invoiced - $total_amount_paid.'.00</h1>';?>
                    
                    </div>
                    <div class="icon">
                      <i class="ion "></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                
                <!-- ./col -->
              </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="row">
           <div class="col-md-6">
              <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
                <?php
          
      if(isset($_GET['sent'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Email was sent  successfully.
          </div>';   
        }
      if(isset($_POST['sendEmail'])){
        $school_ID = $_SESSION['login_user_school_ID'];
        $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
      
         $to=$senderemail_row['sender_email'];
        #get sender and signature from email setting table
        $from=$_SESSION['login_user_email'];
        $fromName=$_SESSION['login_user_fullName'];
        $sender_ID=$_SESSION['login_user_ID'];
        //$footer=$senderemail_row['sender_signature'];
       
        $subject=$_POST['emailSubject'];
        $message=$_POST['emailMessage'];

        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

//mail($to, $subject, $body, $headers);
        $datetime = date_create()->format('Y-m-d H:i:s');
        $send=1 ;//mail($to,$subject,$message,$headers);
        if($send){
          echo "Email Sent successfully";
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,recipient_ID,sender,sender_ID,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$school_ID','$from','$sender_ID','$message','$datetime') ");
           echo '<script> window.location="dashboard.php?sent=True" </script>';
        }else{
           echo "Sorry! Email was not sent";
        }
      }   
                ?>
              <form action="dashboard.php" method="post">
               <?php $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
              $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);?>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" value="<?php echo $senderemail_row['sender_email']?>" placeholder="Email to:" readonly>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="emailSubject" placeholder="Subject">
                </div>
                <div>
                  <textarea name="emailMessage" class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default" id="sendEmail" name="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </form>
          </div>
          <!-- /.box -->
           </div>
           <div class="col-md-6">
                 <div class="box box-info">
            <div class="box-header with-border">Upcoming Events</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Location</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
          
            $event_query = mysqli_query($conn,"select * from event where school_ID = '$school_ID' ORDER BY event_startDate ASC LIMIT 5")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            
            echo '<tr>
                    <td><a href="event.php">'.$event_startDate.'</a></td>
                    <td>'.
             $event_row['event_title'].'</td>
                   
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">'.$event_row["event_location"].'</div>
                    </td>
                  </tr>';
            }
            ?>


                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
             
              <a href="event.php" class="btn btn-sm btn-default btn-flat pull-right">View All Events</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
     </div>
           </div>
        </div>
      </section>
      <!-- /.content -->
      <section class="content" style="padding-left: 60px;padding-right: 60px;">
         <div class="box box-default">
          <div class="box-header with-border">
           
          </div>
          <div class="box-body">
                         <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#children_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Children</a></li>
                      <li><a href="#email_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Email</a></li>
                      <li><a href="#notification_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Notification</a></li>
                       <li><a href="#finance_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Finance</a></li>
                      <li class="pull-right"><a href="#" class="text-muted" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="children_tab">
                            <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>Img</th>
                                  <th>Name</th>
                                  <th>Reg No</th>
                                  <th>Gender</th>
                                  <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                   <?php
                                   #get school Id from current session school id
                                   $school_ID = $_SESSION['login_user_school_ID'];
                                   $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                                   die(mysqli_error());
                                   while ($row1=mysqli_fetch_array($query2)){
                                   $student_ID= $row1['student_ID'];
                                   #get student details
                                   $query3 = mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$student_ID'")or
                                   die(mysqli_error());
                                   while ($row2=mysqli_fetch_array($query3)){
                                    $img;
                                   if($row2['photo'] !=''){
                                    $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row2['photo'] ).'"  height="40px" width="40px" />';
                                  }else{
                                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                                    }
                                    echo" <tr>
                                           <td>
                                            ".$img."
                                           </td>
                                            <td>".$row2['first_Name']." ". $row2['last_Name']."</td>
                                            <td>".$row2['registration_No']." </td>
                                            <td>".$row2['gender_MFU']."</td>  
                                            <td>";
                                           echo'   <a class="btn btn-success " href="view_children.php?id='.$row2['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span> view</a>
                                            
                                           </td>
                                         </tr>';

                                   }
                                  
                                    }
                                  ?>
                               
                                 </tbody>
                                <tfoot>
                                <tr>
                                  <th>Img</th>
                                  <th>Name</th>
                                  <th>Reg No</th>
                                  
                                  <th>Gender</th>
                                  <th>Actions</th>
                                </tr>
                                </tfoot>
                              </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="email_tab">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#email_inbox_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Inbox</a></li>
                                <li><a href="#email_sent_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Sent</a></li>
                               
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="email_inbox_tab">
                                      <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                          <th>From</th>
                                          <th>Subject</th>               
                                          <th>Date</th>
                                          <th>View</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                           #get school Id from current session school id
                                           $school_ID = $_SESSION['login_user_school_ID'];
                                           $query2 = mysqli_query($conn,"select * from email where school_ID = '$school_ID' and recipient='$login_parent_email'");
                                           while ($row1=mysqli_fetch_array($query2)){
                                           $emailID = $row1['email_ID'];
                                            $date=$row1['date_sent'];
                                           $newDate= date("d-m-Y", strtotime($date));
                                           
                                          echo" <tr>
                                                  
                                                    <td>".$row1['sender']." </td>
                                                     <td>".$row1['email_subject']."</td> 
                                                    <td>". $newDate."</td>";
                                                  echo'  <td><a href="view_email.php?id='.$emailID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span></button></a></td>
                                                  
                                                 </tr>';
                                            }
                                          ?>
                                       
                                         </tbody>
                                        <tfoot>
                                        <tr>
                                          <th>From</th>
                                          <th>Subject</th>               
                                          <th>Date</th>
                                          <th>View</th>
                                        </tr>
                                        </tfoot>
                                      </table>
                                </div>
                                <div class="tab-pane " id="email_sent_tab">
                                          <table id="example1" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                <th>To</th>
                                                <th>Subject</th>               
                                                <th>Date</th>
                                                <th>View</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                 #get school Id from current session school id
                                                 $school_ID = $_SESSION['login_user_school_ID'];
                                                 $query2 = mysqli_query($conn,"select * from email where school_ID = '$school_ID' and sender='$login_parent_email' ORDER BY email_ID  ASC")or
                                                 die(mysqli_error());
                                                 while ($row1=mysqli_fetch_array($query2)){
                                                 $emailID = $row1['email_ID'];
                                                 $date=$row1['date_sent'];
                                                 $newDate = date("d-m-Y", strtotime($date));
                                                echo" <tr>
                                                         
                                                          <td>".$row1['recipient']." </td>
                                                           <td>".$row1['email_subject']."</td> 
                                                          <td>".$newDate."</td>";
                                                        echo'  <td><a href="view_email.php?id='.$emailID.'" class=" btn btn-success"><span class= "glyphicon glyphicon-eye-open"></span> View</a></td>
                                                        
                                                       </tr>';
                                                  }
                                                ?>
                                             
                                               </tbody>
                                              <tfoot>
                                              <tr>
                                                <th>To</th>
                                                <th>Subject</th>               
                                                <th>Date</th>
                                                <th>View</th>
                                              </tr>
                                              </tfoot>
                                          </table>
                                </div>
                              </div>
                            </div>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="notification_tab">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                   <th>Notification</th>
                                  
                                  <th>Date</th>
                                  <th>Action</th>
                                  
                                </tr>
                                </thead>
                                <tbody>
                                   <?php

                                   
                                    $notf_query = mysqli_query($conn,"select * from notification where school_ID = '$school_ID' and recipient_ID='$login_parent_ID' ");
                                   while ($notf_row=mysqli_fetch_array($notf_query)){
                                    $notification_id=$notf_row['notification_ID'];
                                    $date=$notf_row['notification_date'];
                                       $newDate = date("d-m-Y", strtotime( $date));
                                    echo '<tr>
                                           
                                         <td>'.$notf_row['notification_message'].'</td>
                                         
                                         <td>'.$newDate.'</td>
                                         <td><a href="view_notification.php?id='.$notification_id.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"></span>  View</button></a></a></td>
                                        
                                       </tr>';
                                     
                                   
                                   //echo $amt;
                                 }
                               // echo $total_bill;
                                
                                   ?>
                               
                                 </tbody>
                               
                              </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="finance_tab">
                        <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#invoice_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Invoices</a></li>
                                <li><a href="#payment_tab" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Payment</a></li>
                               
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="invoice_tab">
                                       <div class="col-md-8"><b><h3>INVOICES</h3> </b></div>
                                           <table id="example1" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                
                                                <th>Reference</th>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Summary</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                               
                                                
                                              </tr>
                                              </thead>
                                              <tbody>
                                                 <?php
                                                 
                                                 $query2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' ")or
                                                 die(mysqli_error());
                                                 $total_amount=0.00;
                                                 while ($row2=mysqli_fetch_array($query2)){
                                                  $total_amount= $total_amount + $row2['amount']  ;
                                                 $invoiveID= $row2['invoice_ID'];
                                                  $invoive_date= $row2['invoice_date'];
                                                  $studentid= $row2['student_ID'];
                                                 $newDate = date("d-m-Y", strtotime($invoive_date));
                                                  $total_amount=0.00;
                                                  $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                                               die(mysqli_error());
                                               while ($row11=mysqli_fetch_array($query2)){
                                               $studentid= $row11['student_ID'];
                                               
                                                $query3 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
                                                
                                                 while ($row3=mysqli_fetch_array($query3)){
                                                  $name=$row3['first_Name']." ".$row3['last_Name'];
                                                  $reg=$row3['registration_No'];
                                                  echo' <tr>
                                                     <td>   <a href="view_invoice.php?invoice='.$invoiveID.'"> '.$row2['reff_no'].' </a></td>';

                                                    echo " <td>".$newDate."</td>
                                                           <td>".$reg ." ".$name."</td>
                                                          <td>".$row2['summury']." </td>
                                                          <td>".$row2['amount']."</td>
                                                          <td>".$row2['balance']."</td>";
                                                         
                                                         echo' 
                                                            
                                                      </tr>';

                                                 
                                                }
                                                  }
                                                }
                                                ?>
                                             
                                               </tbody>
                                              
                                            </table>
                                     
                                </div>
                                <div class="tab-pane" id="payment_tab">
                                           <table id="example1" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                
                                                <th>Invoice Ref</th>
                                                <th>Receipt No </th>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Remark</th>
                                                <th>Amount</th>
                                                
                                                
                                              </tr>
                                              </thead>
                                              <tbody>
                                                 <?php
                                                  $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$login_parent_ID'")or
                                               die(mysqli_error());
                                               while ($row11=mysqli_fetch_array($query2)){
                                               $studentid= $row11['student_ID'];
                                                 $query2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' and student_ID='$studentid' ORDER BY payment_date DESC")or
                                                 die(mysqli_error());
                                                 $total_amount=0.00;
                                                 while ($row2=mysqli_fetch_array($query2)){
                                                  $total_amount= $total_amount + $row2['amount_paid']  ;
                                                 $invoiceID= $row2['invoice_ID'];
                                                 $paymentID= $row2['payment_ID'];
                                                  $invoive_date= $row2['payment_date'];
                                                  $studentid= $row2['student_ID'];
                                                  $slipNo= $row2['slip_no'];
                                                 $newDate = date("d-m-Y", strtotime($invoive_date));
                                                  $total_amount=0.00;
                                                  $query3 = mysqli_query($conn,"select * from invoice where invoice_ID='$invoiceID' and school_ID = '$school_ID' ");
                                                
                                                 while ($row3=mysqli_fetch_array($query3)){
                                                  $invoice_ref=$row3['reff_no'];
                                                $query4 = mysqli_query($conn,"select * from student where student_ID='$studentid' and school_ID = '$school_ID' ");
                                                
                                                 while ($row4=mysqli_fetch_array($query4)){
                                                  $name=$row4['first_Name']." ".$row4['last_Name'];
                                                  $reg=$row4['registration_No'];
                                                  echo' <tr>
                                                     <td>   <a href="view_invoice.php?invoice='.$invoiceID.'"> '.$invoice_ref.' </a></td>';

                                                    echo '<td><a  href="view_transaction.php?payment_ID='.$paymentID.'"   >'.$slipNo.'</a></td>';
                                                       echo   "  <td>".$newDate."</td>
                                                           <td>".$reg ." ".$name."</td>
                                                          <td>".$row2['remarks']." </td>
                                                          <td>".$row2['amount_paid']."</td>
                                                          ";
                                                         
                                                      echo '</tr>';

                                                 
                                                }
                                                  }
                                                }
                                              }
                                                ?>
                                             
                                               </tbody>
                                              
                                            </table>
                                </div>
                              </div>
                          </div>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
          </div>
        </div>
        
      </section>

    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <?php
 include('include/footer.php');
 ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
