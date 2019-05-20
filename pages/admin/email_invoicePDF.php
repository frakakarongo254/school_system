<?php include'include/session.php';
$school_ID=$_SESSION['login_user_school_ID'];
 $get_invoice_ID="";
 if (isset($_POST['invoice_id'])) {
   # code...
  $get_invoice_ID=$_POST['invoice_id'];
 }else if (isset($_GET['invoice_id'])) {
    $get_invoice_ID=$_GET['invoice_id'];
 }
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='".$get_invoice_ID."' and `school_ID` = '".$school_ID."' ");
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
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID='".$invoice_student_id."' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$studentRegNo=$row03['registration_No'];

#get parent details
  $sql033 = mysqli_query($conn,"select * from `parent_relation` where  student_ID='".$invoice_student_id."' and `school_ID` = '".$school_ID."'  LIMIT 1");
  $row033 = mysqli_fetch_array($sql033 ,MYSQLI_ASSOC);
 $parentID=$row033['parent_ID'] ;
  $sql034 = mysqli_query($conn,"select * from `parents` where  parent_ID='".$parentID."' and `school_ID` = '".$school_ID."' ");
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
$emaillogo ;
 $image_data=$school_row['logo_image'];
 $logo_image_name=$school_row['logo_image_name'];

if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';

$emaillogo = '<img class="profile-user-img img-responsive img-circle" src="'.$path.'pages/admin/images/'.$logo_image_name.'" class="em_img" alt="Logo" style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:700px;"  width="300" border="0" height="150" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
}

#sending email details
$emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
      $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
        $senderemail=$senderemail_row['sender_signature'];
      
      $fromEmail=$senderemail_row['sender_email'];
      $fromName=$senderemail_row['sender_name'];
      $footer=$senderemail_row['sender_signature'];

  $content ='';
$content .='<html><body style="padding:0 50px 0 50px;"><div style="border:1px solid green;width:720px;padding:0px 5px 0px 10px;background-color:#efefef" frame="" >';
 $content .= '
<table align="" border="0" cellpadding="0" cellspacing="0" width="710px" style="border-collapse: collapse;table-layout:fixed;border:;padding-left:15px;" >
  <tr>
      <td colspan="3" style="height:50px;text-align:right"><b style="font-weight:bold;font-size: 24px;">INVOICE</b></td>
    </tr>
 <tr>
  <td width="300" valign="top">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    <tr>
     <td>
      '. $logo .'
     </td>
    </tr>
    <tr>
     <td style="padding: 25px 0 0 0;">
      <address>
            <strong>'. $school_row['school_Name'].'</strong><br>
            Po. Box '. $school_row['address_1'].'<br>
            Phone: '. $school_row['phone'].'<br>
            Email: '.$school_row['email'].'<br>
            Website:'.$school_row['school_website'].'
          </address>
          <br>
     </td>
    </tr>
   </table>
  </td>
  <td style="font-size: 0; line-height: 0;" width="200" style="200px">
   &nbsp;
  </td>
  <td width="200" valign="top" style="text-align:;">
   <table border="0" cellpadding="0" cellspacing="0" width="100%" >
    <tr>
     <td style="padding: 15px 0px 0px 0px;">
      <p class="mb-none">
        <strong><span class="text-dark">Invoice No #:</span>
        <span class="value"> '.$invoice_reff.'</span></strong>
    </p>
     <p class="mb-none">
        <span class="text-dark">Invoice Date:</span>
        <span class="value"> '.date($invoice_date).'</span>
    </p>
    <p class="mb-none">
        <span class="text-dark">Due Date:</span>
        <span class="value">'.date($invoice_due_date).'</span>
    </p>
     </td>
    </tr>
    <tr>
     <td style="padding: 15px 0px 0px 0px;">
       <p class="h5 mb-xs text-dark text-semibold"><strong>Invoiced To:</strong></p>
      
          <address>
            '. $studentRegNo ." ". $studentName .'<br>
            
          
           
          </address>
          <br>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
 <td style="font-size: 0; line-height: 0;" width="100" style="" colspan="3">
   &nbsp;
   <br><br>
  </td>
 </tr>
 <tr >
 
   <td colspan="3"  width="900px" style="width:900px">
    <table border="0"  cellpadding="0" cellspacing="0"  border="" width="700px" style="700px" >
       
<col width="175">
<col width="175">
<col width="175">
<col width="175">
            <tr >
           
            <th style="text-align:left"> Item </th>
            <th style="text-align:left" > Qty </th>
            <th style="text-align:right" > Price </th>
              <th style="text-align:right">Subtotal</th>
            </tr>
            <tr><td colspan="4"><hr></td></tr>
            ';
           
        #get school Id from current session school id

        $query2 = mysqli_query($conn,"select * from invoice_item where invoice_id='".$get_invoice_ID."' and school_ID = '".$school_ID."' ")or
        die(mysqli_error());
        while ($row2=mysqli_fetch_array($query2)){
        $invoice_item_ID= $row2['invoice_item_ID'];
        $vote_head_ID= $row2['vote_head_ID'];
        $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='".$vote_head_ID."' and school_ID = '".$school_ID."' ")or
        die(mysqli_error());
        while ($row3=mysqli_fetch_array($query3)){
 $content .=' <tr >
               
                <td>'.$row3['name'].'
             

              
               </td>
                <td>'.$row2['quantity'].'</td>
                <td align="right">'.$school_row['currency'] . ' '.formatCurrency($row2['price']).'</td>
                <td align="right">'.$school_row['currency'] . ' '.formatCurrency($row2['amount']).'</td>  
                
             </tr>';

        }

        }
        
    $content .=   '  <tr>
          <td colspan="4" width="">
            <hr>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="right"><b>Grand Total</b></td>
          <td align="right">
            
              '. $school_row['currency'] .   ' <b> '  .formatCurrency($invoice_amount).'</b>
          </td>
        </tr>
           <tr>
              <td colspan="2"></td>
              <td colspan="2"><hr></td>
           </tr>
          </table>
   </td>
  
 </tr>
 <tr rowspan="3">
   <td colspan="" width="">
    <br>
    <br>
    <br>
    <br>
     
   </td>
 </tr>
 <tr>
   <td colspan="3">
     <table>
       <tr>
         <td colspan="" width="520">
           <b style="color: #FF5733">Terms & Conditions</b>
         </td>
         <td rowspan="2" align="center">
           <span style="font-size: 20;font-weight: 800px;color: #FF5733;font-style: bold;"><b>Thank you</b></span>
         </td>
       </tr>
       <tr>
         <td>
         Payment is due within ';
        $date1 = new DateTime($invoice_due_date);
        $date3=date('d-m-Y');
        $date2 = new DateTime($date3);
    if ($date2>$date1) {
          # code...
       $content .= ' by '.$date1->diff($date2)->format("%d") . "  days";
        }else{
         $content .= ' within '.$date1->diff($date2)->format("%d") ." days";
        }
      $content .= ' </td>
       </tr>
       <tr>
         <td>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
             You can make payment via 
           ';
           $query3 = mysqli_query($conn,"select * from payment_mode where school_ID = '$school_ID' ")or
        die(mysqli_error());
        $mode="";
        while ($row03=mysqli_fetch_array($query3)){
         $mode=$mode.','.$row03['mode_name'];
        }
       $content .=   $mode;
          
     $content .=    ' </p>
         </td>
       </tr>
       <tr>
         <td>
           
         </td>
       </tr>
     </table>
   </td>
 </tr>
</table>
';
$content .= '</div></body></html>';

 $content;
    



$body_content='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
<!--[if gte mso 9]><xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml><![endif]-->
<title>Christmas Email template</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
<meta name="format-detection" content="telephone=no">
<!--[if !mso]><!-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<!--<![endif]-->
<style type="text/css">
body {
  margin: 0 !important;
  padding: 0 !important;
  -webkit-text-size-adjust: 100% !important;
  -ms-text-size-adjust: 100% !important;
  -webkit-font-smoothing: antialiased !important;
}
img {
  border: 0 !important;
  outline: none !important;
}
.my-class {
  padding:35px 70px 30px;
   display:block;
    font-family:Arial, sans-serif; font-size:30px; 
    line-height:34px; 
    color:#000000;
     max-width:700px;
    width:300;
     border:0;
      height:150;
      padding:35px 70px 30px;
    background: url("data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'")no-repeat;
}
p {
  Margin: 0px !important;
  Padding: 0px !important;
}
table {
  border-collapse: collapse;
  mso-table-lspace: 0px;
  mso-table-rspace: 0px;
}
td, a, span {
  border-collapse: collapse;
  mso-line-height-rule: exactly;
}
.ExternalClass * {
  line-height: 100%;
}
.em_defaultlink a {
  color: inherit !important;
  text-decoration: none !important;
}
span.MsoHyperlink {
  mso-style-priority: 99;
  color: inherit;
}
span.MsoHyperlinkFollowed {
  mso-style-priority: 99;
  color: inherit;
}
 @media only screen and (min-width:481px) and (max-width:699px) {
.em_main_table {
  width: 100% !important;
}
.em_wrapper {
  width: 100% !important;
}
.em_hide {
  display: none !important;
}
.em_img {
  width: 100% !important;
  height: auto !important;
}
.em_h20 {
  height: 20px !important;
}
.em_padd {
  padding: 20px 10px !important;
}
}
@media screen and (max-width: 480px) {
.em_main_table {
  width: 100% !important;
}
.em_wrapper {
  width: 100% !important;
}
.em_hide {
  display: none !important;
}
.em_img {
  width: 100% !important;
  height: auto !important;
}
.em_h20 {
  height: 20px !important;
}
.em_padd {
  padding: 20px 10px !important;
}
.em_text1 {
  font-size: 16px !important;
  line-height: 24px !important;
}
u + .em_body .em_full_wrap {
  width: 100% !important;
  width: 100vw !important;
}
}
</style>
</head>

<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
<table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
  <tbody><tr>
    <td valign="top" align="center"><table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
        <!--Header section-->
        <tbody><tr>
          <td style="padding:15px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="font-family:"/Open Sans/", Arial, sans-serif; font-size:12px; line-height:15px; color:#0d1121;" valign="top" align="center"></td>
              </tr>
            </tbody></table></td>
        </tr>
        <!--//Header section--> 
        <!--Banner section-->
        <tr>
          <td valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="padding:35px 70px 30px;" class="em_padd  " valign="top" bgcolor="whitesmoke" align="center">
                '.$emaillogo.'

                </td>
              </tr>
            </tbody></table></td>
        </tr>
        <!--//Banner section--> 
        <!--Content Text Section-->
                 <tr>
          <td style="padding:35px 70px 30px;" class="em_padd" valign="top" bgcolor="whitesmoke" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody>
              <tr>
                <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>

              </tr>
              <tr>
                <td style="font-family:; font-size:18px; line-height:22px; color:#000000; letter-spacing:2px; padding-bottom:12px;" valign="top" align="">Dear <span style="text-transform: uppercase;">'.$parentName.'t</span></td>
              </tr>
              <tr>
                <td style="/font-family:"/Open Sans", Arial, sans-serif; font-size:16px; line-height:30px; color:#000;" valign="top" align="">
                This is a notice that an invoice for your child <strong>'. $studentRegNo ." ". $studentName .'</strong> has been generated on   ' .$invoice_date. '.
                For your convenience, a PDF copy of the invoice has been attached to this email.
              </td></tr>
              <tr>
                <td class="em_h20" style="font-size:0px; line-height:0px; height:25px;" height="25">&nbsp;
                  
                </td>

              </tr>
<tr>
                <td style="/font-family:"/Open Sans", Arial, sans-serif; font-size:18px; line-height:22px; color:#fbeb59; text-transform:uppercase; letter-spacing:2px; padding-bottom:12px;color: black" valign="top" align="">Best Regards,<br>'. $footer .'</td>
              </tr>
            </tbody></table></td>
        </tr>

        <!--//Content Text Section--> 
        <!--Footer Section-->
        <tr>
          <td style="padding:38px 30px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="padding-bottom:16px;" valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                  </tbody></table></td>
              </tr>
              <tr>
                <td style="/font-family:"/Open Sans", Arial, sans-serif; font-size:11px; line-height:18px; color:#999999;" valign="top" align="center"> <br>
                  Copyright © '. $fromName.', All rights reserved.<br>
                 </td>
              </tr>
            </tbody></table></td>
        </tr>
        <tr>
          <td class="em_hide" style="line-height:1px;min-width:700px;background-color:#ffffff;"><img alt="" src="images/spacer.gif" style="max-height:1px; min-height:1px; display:block; width:700px; min-width:700px;" width="700" border="0" height="1"></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
<div class="em_hide" style="white-space: nowrap; display: none; font-size:0px; line-height:0px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
</body></html>';
 $body_content;

     $mailto = $parentEmail;
      $mailfrom = $fromEmail;
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

        $message = $body_content;
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