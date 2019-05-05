<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_payment_ID="";
 if (isset($_GET['payment_ID'])) {
   # code...
  $get_payment_ID=$_GET['payment_ID'];
 }
 #get details form invoice
 $sql022 = mysqli_query($conn,"select * from `payment` where  payment_ID='$get_payment_ID' and `school_ID` = '".$school_ID."' ");
 $row022 = mysqli_fetch_array($sql022 ,MYSQLI_ASSOC);
 $invoiceID=$row022['invoice_ID'];
 $amount_paid=$row022['amount_paid'];
 $payment_date=$row022['payment_date'];
 $payment_remarks=$row022['remarks'];
 $payment_slip_no=$row022['slip_no'];
 $payment_method=$row022['payment_method'];

 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `invoice` where  invoice_ID='$invoiceID' and `school_ID` = '".$school_ID."' ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $invoice_ID=$row02['invoice_ID'];
 $invoice_amount=$row02['amount'];
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
  $invoice_student_id=$row02['student_ID'];
  $invoice_balance=$row02['balance'];
   $invoice_ref=$row02['reff_no'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$admNo=$row03['registration_No'];

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
      <h1>
         <ol class="breadcrumb">
        <li><a href="transaction.php"><i class="fa fa-money"></i> Payment </a></li>
       
        <li class="active"> Receipt</li>
      </ol>
       
      </h1>
    
    </section>
    <!-- Main content -->
   
    <!-- /.content -->
     <section class="invoice">
      <div id="block1">
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
        
        <!-- /.col -->
        <div class="col-sm-4 invoice-col pull-right">
          <b style="font-size: 30px;">RECEIPT</b><br>
          <b>Reference:</b> <?php echo $payment_slip_no;?><br>
          <b>Invoice #</b><?php echo $invoice_ref ?><br>
          <br>
          <b>Issue Date::</b><?php echo $invoice_date ?><br>
          <br>
          <b>To:</b> <br>
          <?php echo $studentName; ?><br>
          Adm # <?php echo $admNo;?>
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
           
            <th> Particular </th>
            <th>Amount</th>
            </tr>
            </thead>
            <tbody>
           <?php
        #get school Id from current session school id

      
        echo' <tr>
               
                <td>Payment for Invoice ' .$invoice_ref. '
             

              
               </td>
               
                <td>'.$amount_paid.'</td>  
                
             </tr>';

       
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
          <?php echo $payment_method;?>

          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
         

         
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</div>
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
         
         
          <a href="#" target="_blank" class="btn btn-default" id="<?php echo $get_payment_ID?>" onclick="printReceipt(this.id)" data-toggle="modal" data-target="#Print_receipt_Modal"><i class="fa fa-print" ></i> Print</a>
        
         <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>-->
        </div>
      </div>
    
     <!-- open Print statement-->
    <div class="modal  fade" id="Print_receipt_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Print Receipt</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
     <iframe id="printf" name="printf" style="width:100%;height: 600px;">

    </iframe>
            <script >
         function printReceipt(payment_id) {
               
        var details= '&payment_id='+payment_id;
        $.ajax({
        type: "POST",
        url: "print_receipt.php",
        data: details,
        cache: false,
        success: function(data) {
          
          var newWin = window.frames["printf"];
              newWin.document.write('<body onload="window.print()">'+data+'</body>');
              newWin.document.close();
        
        }


  });
}
            </script>
          
          
          

        </div>
          
      </div>
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
