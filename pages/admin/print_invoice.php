<?php  include("include/session.php");
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
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
}

 
?>

<body onload="window.print();" style="background-color:#efefef" >

  <!-- Main content -->
 <?php $content ='';
$content .='<div style="border:1px solid green;width:720px;padding:0px 10px 0px 10px;background-color:#efefef" frame="" >';
 $content .= '
<table align="" border="0" cellpadding="0" cellspacing="0" width="710px" style="border-collapse: collapse;table-layout:fixed;border:;padding-left:15px;" >
  <tr>
  <td colspan="2"></td>
      <td colspan="" style="height:50px;text-align:"><b style="font-weight:bold;font-size: 24px;">INVOICE</b></td>
    </tr>
 <tr>
  <td width="300" valign="top">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    <tr>
     <td style="padding: 25px 0 0 0;" style="text-align:left;">
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
            <tr><td colspan="4"><hr style="color:red;background-color:black;"></td></tr>
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
            <hr style="color:red;background-color:black;">
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
              <td colspan="2"><hr style="color:red;background-color:black;"></td>
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
         Payment is due';
      
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
            <p class="text-muted well well-sm " style="margin-top: 10px;">
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
$content .= '</div>';
 echo $content;
?>
  <!-- /.content -->

