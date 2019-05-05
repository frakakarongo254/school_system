<?php  error_reporting(0);
 include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_invoice_ID="";
 if (isset($_POST['invoice_id'])) {
   # code...
  $get_invoice_ID=$_POST['invoice_id'];
 }else if (isset($_GET['invoice_id'])) {
    $get_invoice_ID=$_GET['invoice_id'];
 }
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$get_invoice_ID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_amount=$row02['amount'];
 $due_date=$row02['due_date'];
 $invoice_due_date = date("d-m-Y", strtotime($due_date));
 $inv_date=$row02['invoice_date'];
 $invoice_date=date("d-m-Y", strtotime($inv_date));
 $invoice_summury=$row02['summury'];
 $invoice_amount_paid=$row02['amount_paid'];
 $invoice_student_id=$row02['student_ID'];
 $invoice_reff=$row02['reff_no'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$studentRegNo=$row03['registration_No'];

#get parent details
  $sql033 = mysqli_query($conn,"select * from `parent_relation` where  student_ID='$invoice_student_id' and `school_ID` = '".$school_ID."'  LIMIT 1");
  $row033 = mysqli_fetch_array($sql033 ,MYSQLI_ASSOC);
 $parentID=$row033['parent_ID'] ;
  $sql034 = mysqli_query($conn,"select * from `parents` where  parent_ID='$parentID' and `school_ID` = '".$school_ID."' ");
  $row034 = mysqli_fetch_array($sql034 ,MYSQLI_ASSOC);
  $parentName=$row034['first_Name']." ".$row034['last_Name'];
  $parentPhone=$row034['cell_Mobile_Phone'];
  $parentEmail=$row034['email'];

  #get school details
$school_ID=$_SESSION['login_user_school_ID'];
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
}

 $conten='';
?>


    
   
<?php 


$content = '';

$content .=' <table class="table" style="width:100%">
      <tr>
        <td>
           <h1 class="pull-left">'. $logo .'</h1><br>
           
          <address>
            <strong>'. $school_row['school_Name'].'</strong><br>
            Po. Box ' .$school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '. $school_row['email'].'<br>
            Website:'. $school_row['school_website'].'
          </address>
        </td>
        <td>
          
           To
          <address>
            <strong>'. $studentRegNo .' '. $studentName .'</strong><br>
            
          Parent<br>
          <strong>'. $parentName.'</strong><br>
            Phone: '. $parentPhone .'<br>
            Email: '. $parentPhone .'<br>
           
          </address>
        </td>
        <td>
           <b>Invoice #'. $invoice_reff .'</b><br>
          <br>
          <b>Invoice Date:</b>'. $invoice_date .'<br>
        </td>
      </tr>
    </table>';

  $content .=  '<table class="table" style="width:100%">
            <thead>
            <tr>
           
            <th> Product </th>
            <th > Qty </th>
            <th> Price </th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>';?>
            <?php
          
        #get school Id from current session school id

        $query2 = mysqli_query($conn,"select * from invoice_item where ref_no='$invoice_reff' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row2=mysqli_fetch_array($query2)){
        $invoice_item_ID= $row2['invoice_item_ID'];
        $vote_head_ID= $row2['vote_head_ID'];
        $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='$vote_head_ID' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row3=mysqli_fetch_array($query3)){
   $content  .=  ' <tr>
               
                <td>'.$row3['name'].'
             

              
               </td>
                <td>'.$row2['quantity'].'</td>
                <td>'.$row2['price'].'</td>
                <td>'.$row2['amount'].'</td>  
                
             </tr>';

        }

        }
        
    $content .=' </tbody>
          </table>';
       
            ?>
           <?php 
           $query3 = mysqli_query($conn,"select * from payment_mode where school_ID = '$school_ID' ")or
        die(mysqli_error());
        $mode="";
        while ($row03=mysqli_fetch_array($query3)){
         $mode=$mode.' '.$row03['mode_name'].',';
        }
       $conten .=$mode;
        
        

        
             $content .=  ' <table class="table">
            
              <tr>
          
            <th >Grand Total</th>
            <td >'. $school_row['currency'] .   ' <b> '  .formatCurrency($invoice_amount).'</b></td>
          </tr>
          <tr>
            <td>Payment Methods<br>
            You can make payment via '.$mode.'
            </td>
            <td>Due Date:  '. $invoice_due_date .'</td>
            </tr>
            </table>
         ';

        echo $content ;

     echo $mailto = $parentEmail;
        echo $mailfrom = $school_row['email'];
        $mailsubject = "Invoice";
       



       
        /* you css */



         
        
        require_once('../../pdfgenerator/html2pdf/html2pdf.class.php');


        $html2pdf = new HTML2PDF('P', 'A4', 'fr');

        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->WriteHTML($content);


        $to = $mailto;
        $from = $mailfrom;
        $subject = $mailsubject;

        $message = "<p>Please see the attachment.</p>";
        $separator = md5(time());
        $eol = PHP_EOL;
        $filename = "pdf-invoice.pdf";
        $pdfdoc = $html2pdf->Output('', 'S');
        $attachment = chunk_split(base64_encode($pdfdoc));




        $headers = "From: " . $from . $eol;
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;

        $body = '';

        $body .= "Content-Transfer-Encoding: 7bit" . $eol;
        $body .= "This is a MIME encoded message." . $eol; //had one more .$eol


        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
        $body .= $message . $eol;


        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment" . $eol . $eol;
        $body .= $attachment . $eol;
        $body .= "--" . $separator . "--";

        if (mail($to, $subject, $body, $headers)) {

        echo   $msgsuccess = 'success';
        } else {

          echo  $msgerror = 'failed';
        }

 ?>

 