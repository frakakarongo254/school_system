<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
$school_ID = $_SESSION['login_user_school_ID'];

$get_parentID='';
if(isset($_GET['id'])){
  $get_parentID =$_GET['id'];
}
#get parent detailss
$user_ID=$_SESSION['login_user_ID'];
$ses_sql = mysqli_query($conn,"select * from `parents` where `parent_ID` = '".$get_parentID."' ");
  $parent_row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
  $parent_row['first_Name'];
  $parent_email=$parent_row['email'];
  $parent_phone=$parent_row['cell_Mobile_Phone'];
   $image;
 if($parent_row['photo'] !=''){
  $image = '<img class=" profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $parent_row['photo'] ).'"  height="40px" width="40px" alt="User profile picture"/>';
}else{
    $image = "<img class=' profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' alt='User profile picture'>";
  }



?>

<?php include("include/header.php")?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
  include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
 <section class="content-header">
      <h1>
        <b>Parent</b>
       
      </h1>
     <?php
     if(isset($_GET['id']) and isset($_GET['unlink'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have unlink the student  successfully.
          </div>';   
        }
        if(isset($_GET['insert']) and $_GET['insert']=='email'  ){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Email was sent  successfully.
          </div>';   
        }
         if(isset($_GET['cancel'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have canceled transaction  successfully.
          </div>';   
        }

        if(isset($_POST['sendEmail'])){
        
         $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
          $senderemail=$senderemail_row['sender_signature'];
        $recipient_ID=$get_parentID;
        $from=$senderemail_row['sender_email'];
        $fromName=$senderemail_row['sender_name'];
        $footer=$senderemail_row['sender_signature'];
        $to=$_POST['email_to'];
        $subject=$_POST['email_subject'];
        $msg=$_POST['email_message'];
         $message=$msg ." <br>".  $senderemail;
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

//mail($to, $subject, $body, $headers);
        $datetime = date_create()->format('Y-m-d H:i:s');
        $send=mail($to,$subject,$message,$headers);
        if($send){
          //echo "Email Sent successfully";
          $sudent_insert_query=mysqli_query($conn,"insert into `email` ( school_ID,email_subject,recipient,recipient_ID,message,date_sent 
          ) 
          values('$school_ID','$subject','$to','$recipient_ID','$msg','$datetime') ");
        }else{
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Sorry! please try again.
          </div>';  
        }
        if($sudent_insert_query){
            echo '<script> window.location="view_parent.php?id='.$recipient_ID.'&insert=email" </script>';
        }
      }   

      #save Notification
      if(isset($_POST['saveNotication'])){
         $notification=$_POST['notificationMessage'];
         #get email sender settings
       $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` =
        '".$_SESSION['login_user_school_ID']."' ");
        $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
        $senderemail=$senderemail_row['sender_signature'];
        $from=$senderemail_row['sender_email'];
        $fromName=$senderemail_row['sender_name'];
        $footer=$senderemail_row['sender_signature'];
        $to= $parent_email;
        $subject="Notification";
        $msg=$notification;
        $message=$msg ." <br>".  $senderemail;
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: '.$fromName .' <'.$from.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
        $sendNotification;
  $datetime = date_create()->format('Y-m-d H:i:s');
         if (isset($_POST['natificationWithSMS']) and isset($_POST['natificationWithEmail']) ) {
          #send both emill and sms and save
          
          $notification_query=mysqli_query($conn,"insert into `notification` ( school_ID,recipient_email,recipient_ID,notification_message,notification_date 
          ) 
          values('$school_ID','$to','$get_parentID','$msg','$datetime') ");
           if ($notification_query) {
              echo '<script> window.location="view_parent.php?id='.$get_parentID.'&insert=Notification" </script>';
           }
         $sendNotification=mail($to,$subject,$message,$headers);
           
         }elseif (isset($_POST['natificationWithSMS']) and !isset($_POST['natificationWithEmail'])) {
           # send sms only and save
          //$sendNotification=mail($to,$subject,$message,$headers);
          $notification_query=mysqli_query($conn,"insert into `notification` ( school_ID,recipient_email,recipient_ID,notification_message,notification_date
          ) 
          values('$school_ID','$to','$get_parentID','$msg','$datetime') ");
           if ($notification_query) {
              echo '<script> window.location="view_parent.php?id='.$get_parentID.'&insert=Notification" </script>';
           }
         $sendNotification=mail($to,$subject,$message,$headers);
         }elseif (!isset($_POST['natificationWithSMS']) and isset($_POST['natificationWithEmail'])) {
           # send email only and save
           //$sendNotification=mail($to,$subject,$message,$headers);
            $notification_query=mysqli_query($conn,"insert into `notification` ( school_ID,recipient_email,recipient_ID,notification_message,notification_date 
          ) 
          values('$school_ID','$to','$get_parentID','$msg','$datetime') ");
           if ($notification_query) {
              echo '<script> window.location="view_parent.php?id='.$get_parentID.'&insert=Notification" </script>';
           }
           $sendNotification=mail($to,$subject,$message,$headers);
           
         }else{
           $notification_query=mysqli_query($conn,"insert into `notification` ( school_ID,recipient_email,recipient_ID,notification_message,notification_date 
          ) 
          values('$school_ID','$to','$get_parentID','$msg','$datetime') ");
           if ($notification_query) {
              echo '<script> window.location="view_parent.php?id='.$get_parentID.'&insert=Notification" </script>';
           }
         $sendNotification=mail($to,$subject,$message,$headers);

         }


      }
        ?>
      

    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
         <div class="col-md-12 ">
         
          <!-- Profile Image -->
          <div class="box box-primary ">
            <div class="box-body box-profile">
              <div class="row">
                <div class="col-md-3 ">
                  <div class="pull-left">
                   
                   <?php echo $image;?>

              
            </div>
                </div>
                <div class="col-md-4 table-responsive">
                  <table>
                    <tr>
                    <td><span style="font-size: 17px">Name:</span></td>
                    <td><h3 class="profile-username "><b><?php echo $parent_row['first_Name'] ." ". $parent_row['last_Name'];?></b></h3></td>
                  </tr>
                  <tr>
                    <td><span style="font-size: 17px">Email:</span></td>
                    <td><b><?php echo $parent_row['email']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Phone:</span></td>
                    <td><b><?php echo $parent_row['cell_Mobile_Phone']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Nationality:</span></td>
                    <td><b><?php echo $parent_row['nationality']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Gender:</span></td>
                    <td><b><?php echo $parent_row['gender_MFU']?></b></td>
                  </tr>
                  
                 </table>
                </div>
                <div class="col-md-5 table-responsive">
                  <table>
                    
                  <tr>
                    <td><span style="font-size: 17px">Total invoiced:</span></td>
                    <td>
                      <?php
                      
                                $amt_invoiced=0.00;
                               $query21 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
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
                       echo  $amt_invoiced;
                               ?>


                    </td>
                  </tr>
                  <tr>
                    <td><span>Amount Paid:</span></td>
                    <td>
                      <?php
                       
                            $total_amount_paid=0.00;
                            $amount_query = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
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
                       echo  $total_amount_paid;
                               ?>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Balance:</span></td>
                    <td>
                      <b>
                        <?php $total_balance=0.00; $tol=$amt_invoiced - $total_amount_paid;
                      if($tol <=0){
                      $total_balance =0.00;
                      }else{
                       $total_balance=$tol;
                      }
                      echo $total_balance;
                      ?></b>
                    </td>
                  </tr>
                  
                 </table>
                </div>
              </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            
            
            <!-- /.box-header -->
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Children</a></li>
                  <li><a href="#tab_2" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Emails</a></li>
                 
                  <li><a href="#tab_invoice" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Invoices</a></li>

                  <li><a href="#tab_payment" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Payment</a></li>

                   <li><a href="#tab_4" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Notification</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active table-responsive" id="tab_1">
                         <table id="example3" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Img</th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                             <?php
                             #get school Id from current session school id
                             $school_ID = $_SESSION['login_user_school_ID'];
                             $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
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
                                      <td>Action</td>  
                                      <td>";
                                     echo'   <a class="btn btn-success btn-flat" href="view_student.php?id='.$row2['student_ID'].'"><span class= "glyphicon glyphicon-eye-open"></span></a>
                                       <button type="button" id="'.$row2['student_ID'].'" class="btn btn-danger btn-flat" value="'.$row1['parent_ID'].'" onclick="delinkStudent(this.id,this.value)" data-toggle="modal"  data-target="#delink_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
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
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Actions</th>
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane table-responsive" id="tab_2">
                    <div class="row">
                    <div class="col-md-8"><b><h3>Emails</h3> </b></div>
                    <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" data-toggle="modal" data-target="#sendEmail_Modal"><i class="fa fa-plus"></i><b> New Email</b></a></div>
                    </div>
                      <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            
                            <th>Subject</th>
                            
                            <th>Sent on</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                              <?php
                            $query02 = mysqli_query($conn,"select * from email where school_ID = '$school_ID' && recipient_ID='$get_parentID' ORDER BY date(date_sent)")or
                               die(mysqli_error());
                               
                               while ($row0=mysqli_fetch_array($query02)){
                                $emailID=$row0['email_ID'];
                                $date=$row0['date_sent'];
                                  $datetime = date_create($date)->format('d-m-Y ');
                                      echo ' <tr>
                                      <td>'.$row0['email_subject'].'</td>
                                       <td>'. $datetime.'</td>
                                       <td><a href="view_email.php?id='.$emailID.'" class=" btn btn-success"><span class= "glyphicon glyphicon-eye-open"></span> View</a></td>
                                       </tr>';
                               }
                             
                               ?>
                         
                           </tbody>
                          <tfoot>
                          <tr>
                           
                          </tr>
                          </tfoot>
                        </table>
                    </div>
                    
                    <div class="tab-pane table-responsive" id="tab_invoice">
                        <div class="row">
                          <div class="col-md-8"><b><h3>Invoices</h3> </b></div>
                          
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Reference</th>
                              <th>Date</th>
                              <th>Student</th>
                              <th>Summary</th>
                              <th>Amount</th>
                              <th>Balance</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               
                                $total_amount_invoiced=0.00;
                            $amount_query = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
                             die(mysqli_error());
                             while ($row_amount=mysqli_fetch_array($amount_query)){
                             $studentId = $row_amount['student_ID'];
                             
                             $que= mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$studentId'")or
                             die(mysqli_error());
                             while ($row_std=mysqli_fetch_array($que)){
                               $name=$row_std['first_Name']." ".$row_std['last_Name'];
                                $reg=$row_std['registration_No'];
                              $stdId = $row_std['student_ID'];
                              // $name= $row2['first_Name']." ".$row2['last_Name'];
                              $que2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' && student_ID='$stdId'")or
                             die(mysqli_error());
                             $std_name;
                             
                             while ($row_in=mysqli_fetch_array($que2)){
                              $total_amount_invoiced= $total_amount_invoiced + $row_in['amount']  ;
                               $invoiveID= $row_in['invoice_ID'];
                                $invoive_date= $row_in['invoice_date'];
                                $studentid= $row_in['student_ID'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                              echo' <tr>
                                   <td>   <a href="view_invoice.php?invoice='.$invoiveID.'"> '.$row_in['reff_no'].' </a></td>';

                                  echo " <td>".$newDate."</td>
                                         <td>".$reg ." ".$name."</td>
                                        <td>".$row_in['summury']." </td>
                                        <td>".$row_in['amount']."</td>
                                        <td>".$row_in['balance']."</td>";
                                         
                                          
                                      
                                       echo' 
                                          <td>
                                           <a href="edit_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-pencil"></span></button></a>

                                           <a href="payment.php?invoice_id='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" "><span class= "glyphicon glyphicon-"></span>Recieve Payment</button></a>

                                       
                                       </td>
                                    </tr>';
                             }
                           }
                         }
                     
                               ?>
                           
                             </tbody>
                           
                          </table>
                    </div>
                    <div class="tab-pane table-responsive" id="tab_payment">
                        <div class="row">
                          <div class="col-md-8"><b><h3>Payment</h3> </b></div>
                          
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Receipt No </th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Remark</th>
                              <th>Amount</th>
                              <th>Action</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php

                                 
                               
                                $total_amount_paid=0.00;
                            $pay_query = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && parent_ID='$get_parentID'")or
                             die(mysqli_error());
                             while ($row_amount=mysqli_fetch_array($pay_query)){
                             $studentId = $row_amount['student_ID'];
                             
                             $query_std= mysqli_query($conn,"select * from student where school_ID = '$school_ID' && student_ID='$studentId'")or
                             die(mysqli_error());
                             while ($row_std=mysqli_fetch_array( $query_std)){
                               $name=$row_std['first_Name']." ".$row_std['last_Name'];
                                $reg=$row_std['registration_No'];
                              $std_Id = $row_std['student_ID'];
                              // $name= $row2['first_Name']." ".$row2['last_Name'];
                              $que02 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' && student_ID='$std_Id'")or
                             die(mysqli_error());
                             $std_name;
                             
                             while ($row2=mysqli_fetch_array($que02)){
                              $total_amount_paid= $total_amount_paid + $row2['amount_paid']  ;
                               $invoiceID= $row2['invoice_ID'];
                               $paymentID= $row2['payment_ID'];
                                $invoive_date= $row2['payment_date'];
                                $studentid= $row2['student_ID'];
                                $slipNo= $row2['slip_no'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                                $total_amount=0.00;
                                echo' <tr>
                                   <td>   <a href="view_transaction.php?payment_ID='.$paymentID.'"> '.$slipNo.' </a></td>';

                                  echo "
                                        <td>".$newDate."</td>
                                        <td>".$reg ." ".$name."</td>
                                        <td>".$row2['remarks']." </td>
                                        <td>".$row2['amount_paid']."</td>
                                        ";
                                       
                                       echo' 
                                          <td>
                                           <a  href="edit_transaction.php?payment_id='.$paymentID.'"  class="btn btn-success btn-flat" id="'.$paymentID.'" onclick="editpayment(this.id)" ><span class="glyphicon glyphicon-pencil">Edit</span></a>

                                        
                                          

                                         <button type="button"  class="btn btn-primary btn-flat" id="'.$paymentID.'" name="'. $slipNo.'" onclick="cancelTransaction(this.id,this.name)" data-toggle="modal" data-target="#cancel_transaction_Modal"><span class="glyphicon glyphicon-"></span>Cancel Transaction</button>
                                       </td>
                                    </tr>';
                             }
                           }
                         }
                            
                               ?>
                           
                             </tbody>
                           
                          </table>
                          
                    </div>
                    <div class="tab-pane table-responsive" id="tab_4">
                        <div class="row">
                          <div class="col-md-8"><b><h3>Notification</h3> </b></div>
                          <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" data-toggle="modal" data-target="#sendNotification_Modal">
                            <i class="fa fa-plus"></i><b> New Notification</b></a></div>
                        </div>
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

                                $notf_query = mysqli_query($conn,"select * from notification where school_ID = '$school_ID' && recipient_ID='$get_parentID'");
                               while ($notf_row=mysqli_fetch_array($notf_query)){
                                $notification_id=$notf_row['notification_ID'];
                                $date=$notf_row['notification_date'];
                                   $newDate = date("d-m-Y", strtotime( $date));
                                echo '<tr>
                                       
                                     <td>'.$notf_row['notification_message'].'</td>
                                     
                                     <td>'.$newDate.'</td>
                                    <td><a   href="#" id="'.$notification_id.'" onclick="deleteNotificationFromSystem(this.id)"><span class="pull- badge bg-danger btn-danger"><i class="fa fa-trash"></i> Delete <span> </a></td>
                                   </tr>';
                                 
                               
                               //echo $amt;
                             }
                           // echo $total_bill;
                            
                               ?>
                           
                             </tbody>
                           
                          </table>
                    </div>
                  </div>
                </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
       
         <!-- Send email to parent  Modal-->
    <div class="modal  fade" id="sendEmail_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Send Email </h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <form method="POST" action="view_parent.php?id=<?php echo $get_parentID?>">
              <div class="form-group">
                <input class="form-control" placeholder="To:" name="email_to"  value="<?php echo $parent_email ?>" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Subject:" name="email_subject">
              </div>
             
              <div class="form-group">
                    
                      <textarea class="form-control" id="editor1" name="email_message" rows="10" cols="80">
               
                    </textarea>
                     
              </div>
           
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
               <button type="reset" name="sendEmail" class="btn btn-danger "><i class="fa fa-"></i> Reset</button>
                
              </div>
              <button type="submit" name="sendEmail" class="btn btn-primary "><i class="fa fa-envelope-o"></i> Send</button>
             
            </div>
          </form>
         

        </div>
          
      </div>
    </div>
    <!--Notification-->
     <div class="modal  fade" id="sendNotification_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Send Notification </h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <form method="POST" action="view_parent.php?id=<?php echo $get_parentID?>">
             
              <div class="form-group">
                    
                      <textarea class="form-control" id="editor1" name="notificationMessage" rows="3" cols=""  >
               
                    </textarea>
                     
              </div>
               <div class="form-group">
                <label>
                  <input type="checkbox" name="natificationWithSMS" class="flat-red" checked>
                  SMS
                </label>
                <label>
                  <input type="checkbox" name="notificationWithEmail" class="flat-red">
                  Email
                </label>
                
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-md-3">
                  <button type="submit" name="saveNotication" class="btn btn-primary "><i class="fa fa-envelope-o"></i> Save</button>
                </div>
              <div class="col-md-2">
               <button type="reset"  class="btn btn-danger "><i class="fa fa-"></i>Clear </button>
                
              </div>
              
           
             </div>
            </div>
          </form>
         

        </div>
          
      </div>
    </div>


      <!-- delete Invoice  Modal-->
    <div class="modal  fade" id="payment_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>PAYMENT </b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function takepayment(invoice_id){ 
               alert(invoice_id);
               //page that initiate the payment
                var page='view_parent.php';
                  if(invoice_id !=''){
                    var details= '&invoice_id='+ invoice_id +'&page='+ page;
                    $.ajax({
                    type: "POST",
                    url: "takepayment.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      //alert(data)
                      document.getElementById("Message").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("Message").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="Message"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>

     <!-- #cancel transaction -->
     <div class="modal  fade" id="cancel_transaction_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cancel Transaction</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function cancelTransaction(payment_id,payment_slip_no){
                 
                 document.getElementById("msg").innerHTML=' Are you sure you want to cancel this transaction with slip no <b style="font-size:20px"> ' + payment_slip_no + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
               
                    updiv.innerHTML ='<form method="POST" action=""><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">No</button><button class="btn btn-danger pull-left" name="deletebuttonFunc" id="'+ payment_id +'" type="submit" data-dismiss="modal" onclick="cancelTransactionFromSystem(this.id)">Yes</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
      </div>
    </div>
     </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>
<!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
  
<!-- ./wrapper -->


<!-- include script-->
<?php include("include/script.php")?>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
   $(function () {
    $('#example3').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>
<script type="text/javascript">
 function cancelTransactionFromSystem(payment_id){
  var details= '&payment_id='+ payment_id;
  $.ajax({
  type: "POST",
  url: "canceltransaction.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
     
 window.location="view_parent.php?id=<?php echo $get_parentID?>&cancel=True" 
    }else{
      
      alert("OOp! Could not cancel the transaction.Please try again!");
    }
  }
  });
  }
</script>
<script >
  function delinkStudentFromParent(student_ID,parent_ID){
    //alert(parent_ID);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&student_ID='+ student_ID;
  $.ajax({
  type: "POST",
  url: "unlink_student_parent.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location='view_parent.php?id='+parent_ID+'&unlink=True' 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  

  }


  });
  }

   function deleteNotificationFromSystem(notification_id){
  alert(notification_id);
  var details= '&notification_id='+ notification_id;
  $.ajax({
  type: "POST",
  url: "delete_notification.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="notification.php?delete=True" 
    }else{
      alert("OOp! Could not delete the Zone.Please try again!");
    }
  
  }

  });
  }
</script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
