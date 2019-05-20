<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 //$school_ID = $_SESSION['login_user_school_ID'];
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];

 $school_ID=$_SESSION['login_user_school_ID'];
 $get_invoice_ID="";
 if (isset($_GET['invoice'])) {
   # code...
  $get_invoice_ID=$_GET['invoice'];
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

 
?>

<?php include("include/header.php")?>

<body class="hold-transition skin-cadetblue layout-top-nav">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
 // include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:  whitesmoke;">
    <!-- Content Header (Page header) -->
     <div class="container">
   
 
    <section class="content-header">
      <h1>
         <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>
       
        <li class="active">Invoices</li>
      </ol>
       
      </h1>
    
    </section>
    <!-- Main content -->
   
    <!-- /.content -->
     <section class="invoice">
      <div class="row">
        <div class="col-md-12">
      <!-- title row -->
      <?php
          $content ='';
$content .='<center><div style="border:1px solid green;width:720px;padding:0px 10px 0px 10px;background-color:;" frame="" class="pull-center" >';
 $content .= '
<table align="center" border="0" cellpadding="0" cellspacing="0" width="710px" style="border-collapse: collapse;table-layout:fixed;border:;padding-left:15px;" >
  <tr>
  <td colspan="2"></td>
      <td colspan="" style="height:50px;text-align:"><b style="font-weight:bold;font-size: 24px;">INVOICE</b></td>
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
         Payment is due ';
        $date1 = new DateTime($invoice_due_date);
        $date3=date('d-m-Y');
        $date2 = new DateTime($date3);
        if ($date2>$date1) {
          # code...
       $content .= ' by '.$date1->diff($date2)->format("%d") . "  days";
        }else{
         $content .= ' within '.$date1->diff($date2)->format("%d") ." days";
        }
    //$content .= $date1->diff($date2)->format("%d");
      
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
$content .= '</div></center';
echo '<div id="tabDiv">' .$content.'</div>';
        ?>
      </div>
    </div>
<div class="row no-print">
        <div class="col-xs-12">
          <br>
          <a href="#"  class="btn btn-default" id="<?php echo $get_invoice_ID?>" onclick="createPDF()" ><i class="fa fa-print" ></i> Print</a>
         
       
        </div>
      </div>
    </section>
  </div>
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
<script>
  function createPDF() {
 
       var sTable = document.getElementById('tabDiv').innerHTML;
        //var sTable = <?php //echo $content ?>;
        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 0px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;;}";
        style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head>');
        win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
        win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');

        win.document.close();   // CLOSE THE CURRENT WINDOW.

        win.print();    // PRINT THE CONTENTS.
    }

</script>
<!-- page script -->
<script >

  //delete invoice item function
  function  deleteInvoice_item(invoice_item_id){
   // alert(invoice_item_id);
  //var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&invoice_item_id='+invoice_item_id;
  $.ajax({
  type: "POST",
  url: "delete_invoice_item.php",
  data: details,
  cache: false,
  success: function(data) {
    window.location='view_invoice.php?invoice=<?php echo $get_invoice_ID?>' ;
   
  

  }


  });
  }
</script>
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

</script>

<script >
 $(document).ready(function(){
    var i=1;
    $("#add_row").click(function(){b=i-1;
        $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++; 
    });
    $("#delete_row").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        }
        calc();
    });
    
    $('#tab_logic tbody').on('keyup change',function(){
        calc();
    });
    $('#tax').on('keyup change',function(){
        calc_total();
    });
    

});

function calc()
{
    $('#tab_logic tbody tr').each(function(i, element) {
        var html = $(this).html();
        if(html!='')
        {
            var qty = $(this).find('.qty').val();
            var price = $(this).find('.price').val();
            $(this).find('.total').val(qty*price);
            
            calc_total();
        }
    });
}

function calc_total()
{
    total=0;
    $('.total').each(function() {
        total += parseInt($(this).val());
    });
    $('#sub_total').val(total.toFixed(2));
    tax_sum=total/100*$('#tax').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>
</body>
</html>
