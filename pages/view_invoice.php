<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
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
      
    </section>
    <!-- Main content -->
   
    <!-- /.content -->
     <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="page-">
            <i class="pull-left"><?php echo $logo ?></i>
            <small class="pull-right">Date: <?php echo date('d-m-Y ')?></small>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?php echo $school_row['school_Name']?></strong><br>
            Po. Box <?php echo $school_row['address_1']?><br>
            Phone: <?php echo $school_row['phone']?><br>
            Email: <?php echo $school_row['email']?><br>
            Website:<?php echo $school_row['school_website']?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $studentRegNo ." ". $studentName?> </strong><br>
            
          Parent<br>
          <strong><?php echo $parentName;?></strong><br>
            Phone: <?php echo $parentPhone ?><br>
            Email: <?php echo $parentEmail ?><br>
           
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #<?php echo $invoice_reff ?></b><br>
          <br>
          <b>Invoice Date:</b><?php echo $invoice_date ?><br>
          
          <b>Account:</b> <?php  ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
           
            <th> Product </th>
            <th > Qty </th>
            <th> Price </th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
           <?php
        #get school Id from current session school id

        $query2 = mysqli_query($conn,"select * from invoice_item where invoice_id='$get_invoice_ID' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row2=mysqli_fetch_array($query2)){
        $invoice_item_ID= $row2['invoice_item_ID'];
        $vote_head_ID= $row2['vote_head_ID'];
        $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='$vote_head_ID' and school_ID = '$school_ID' ")or
        die(mysqli_error());
        while ($row3=mysqli_fetch_array($query3)){
        echo' <tr>
               
                <td>'.$row3['name'].'
             

              
               </td>
                <td>'.$row2['quantity'].'</td>
                <td>'.$row2['price'].'</td>
                <td>'.$row2['amount'].'</td>  
                
             </tr>';

        }

        }
        ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          

        <!--  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            
          </p>-->
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due <?php echo $invoice_due_date ?></p>

          <div class="table-responsive">
            <table class="table">
              
          
            <th class="" style="width:50%">Grand Total</th>
            <td class=""><?php echo $invoice_amount?></td>
          </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="print_invoice.php?invoice=<?php echo $get_invoice_ID?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
         <a href="invoice.php"> <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button></a>
         <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>-->
        </div>
      </div>
    </section>
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
