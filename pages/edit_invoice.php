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
 $invoice_due_date=$row02['due_date'];
 $invoice_date=$row02['invoice_date'];
 $invoice_summury=$row02['summury'];
 $invoice_amount_paid=$row02['amount_paid'];
  $invoice_student_id=$row02['student_ID'];
  $invoice_ref_no=$row02['reff_no'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
 
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
        
      <?php
    
        
         if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center><b>Success! Invoice updated successfuly.</b></center>
          </div>';   
        }
       
if(isset($_POST['save']))  
{  
  
  $rand = substr(number_format(time() * rand(),0,'',''),0,10);
  $Ref="INV-".$rand;
$summury=$_POST['summury'];  
$invoiceDate=$_POST['invoiceDate'];
$invoiceDate=$_POST['invoiceDate'];
//$date= $invoiceDate.format('MMMM D, YYYY');
$dueDate= date('Y/m/d H:i:s');//$_POST['dueDate'];  
$studentID=$invoice_student_id;
$total_amount=$_POST['total_amount'];
$new_balance;
 if ($invoice_amount_paid >= $total_amount ) {
   $new_balance= 0.00;
 }else{
  $new_balance= $total_amount - $invoice_amount_paid;
 }
    $delete_query=mysqli_query($conn,"DELETE FROM invoice_item WHERE `invoice_id`='".$get_invoice_ID."' and `school_ID`='".$_SESSION['login_user_school_ID']."'");
if ($delete_query) {
$que=mysqli_query($conn,"update `invoice` SET amount='".$total_amount."', balance= '".$new_balance."',student_ID='".$studentID."',invoice_date='".$invoiceDate."',due_date='".$dueDate."',summury='".$summury."' where `invoice_ID`='".$get_invoice_ID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
   
     
      if($que){

      $id=mysqli_insert_id($conn);  
      for($i = 0; $i<count($_POST['vote_head_id']); $i++){ 
        
      $query1=mysqli_query($conn,"INSERT INTO invoice_item  
      SET   
      invoice_id = '{$get_invoice_ID}',  
      vote_head_ID = '{$_POST['vote_head_id'][$i]}',  
      quantity = '{$_POST['qty'][$i]}',  
      price = '{$_POST['price'][$i]}',  
      amount = '{$_POST['total'][$i]}',
      school_ID = '{$school_ID}'"); 

   // echo '<script> window.location="edit_invoice.php?invoice='.$get_invoice_ID.'&update=true" </script>'; 
      } 
      if($query1){
        $que02=mysqli_query($conn,"update `statement` SET Debit='".$total_amount."' where `ref_no`='".$invoice_ref_no."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
  //echo $invoice_ref_no;
     // echo '<script> window.location="edit_invoice.php?invoice='.$get_invoice_ID.'&update=true" </script>'; 
      }

      }else{
      echo' <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert"
      aria-hidden="true">
      &times;
      </button>
      Sorry! Something went wrong.Please try again.
      </div>'; 
      } 



    

  
  
}else{
  echo "failed";
}


}   
      
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
           
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
                
                <?php

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
                <form method="POST" action="edit_invoice.php?invoice=<?php echo $get_invoice_ID?>">

                  <div class="row">
                    <div class="col-md-4">
                     
                      <div class="row">
                         <div class="col-md-12 ">
                          
                           <div class="pull-left"> <a ><i class="fa  pu"></i><b> <?php echo $logo?></b></a></div>
                         </div>
                       </div>
                      <div class="row">
                         <div class="col-md-12">
                           <a ><i class="fa  fa-institution"></i><b><?php echo $school_row['school_Name']?></b></a>
                         </div>
                       </div>
                        <div class="row">
                         <div class="col-md-12">
                           <a><i class="fa fa-bookmark-o"></i> Po. Box <?php echo $school_row['address_1']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                           <a ><i class="fa fa-phone"></i> <?php echo $school_row['phone']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                          <a><i class="fa fa-envelope-o"></i> <?php echo $school_row['email']?></a>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-12">
                          <a> <i class="fa fa-globe"></i> <?php echo $school_row['school_website']?></a>
                         </div>
                       </div>

                    </div>
                    <div class="col-md-2">
                      
                    </div>
                    <div class="col-md-5">
                      <b>To</b>:<br>
                           <select class="form-control select2" name="studentId" style="width: 100%;" disabled>
                    <option value="<?php echo $studentId ?>"><?php echo $studentName ?></option>
                  <?php
                 $query_c= mysqli_query($conn,"select * from student where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($crows=mysqli_fetch_array($query_c)){

                  echo'  <option value="'.$crows['student_ID'].'">'.$crows['first_Name'].' '.$crows['last_Name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
                    <br>
                   <b>Invoice Date:</b>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="invoiceDate" id="" value="<?php echo $invoice_date?>" class="form-control" placeholder="Invoice Date" required>
                </div>
                <br>
                <b>Due Date:</b>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="dueDate" id="" value="<?php echo $invoice_due_date ?>" class="form-control" placeholder="Due Date" required>
                </div>
                <br>
                <b>Summury:</b><br>
                <textarea class="form-control" rows="3" name="summury" maxlength="100" placeholder="Summury" required>
                  <?php echo $invoice_summury ?>
                </textarea>
                    </div>
                    
                  </div>
               
          <table class="table table-bordered table-hover" id="tab_logic">
        <thead>
          
          <tr>
            <th class="hidden text-center"> # </th>
            <th class="text-center"> Product </th>
            <th class="text-center"> Qty </th>
            <th class="text-center"> Price </th>
            <th class="text-center"> Total </th>
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
                              echo" <tr>
                                     
                                      <td><select class='form-control' name='vote_head_id[]' style='width: 100%;' required>";
                                   echo"   <option value='".$row3['vote_head_ID']."' selected='selected'>".$row3['name']."</option>";
                                      
                                      $query_votehead= mysqli_query($conn,"select * from vote_head where school_ID = '".$_SESSION['login_user_school_ID']."'");
                                      while ($votehead_rows=mysqli_fetch_array($query_votehead)){

                                      echo"  <option value='".$votehead_rows['vote_head_ID']."'>".$votehead_rows['name']."</option>";
                                      }


                                    
                                   echo'   </select></td>
                                      <td><input type="number" name="qty[]" placeholder="Enter Qty" class="form-control qty" value="'.$row2['quantity'].'" step="0" min="0"/> </td>
                                      <td><input type="number" name="price[]" value="'.$row2['price'].'" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/></td>
                                      <td><input type="number" name="total[]" placeholder="0.00" value="'.$row2['amount'].'" class="form-control total" readonly/></td>  
                                      <td>';
                                     echo'  
                                       <button type="button" id="'.$invoice_item_ID.'" class="btn btn-danger btn-flat"  onclick="deleteInvoice_item(this.id)" ><span class="glyphicon glyphicon-trash"></span></button>
                                     </td>
                                   </tr>';

                             }
                            
                          }
                            ?>
                         
          <tr id='addr0'>
            <td class="hidden">1</td>
            <td><select class="form-control " name='vote_head_id[]' style="width: 100%;" >
                    <option value="">--Select item--</option>
                  <?php

                 $query_votehead= mysqli_query($conn,"select * from vote_head where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($votehead_rows=mysqli_fetch_array($query_votehead)){

                  echo'  <option value="'.$votehead_rows['vote_head_ID'].'">'.$votehead_rows['name'].'</option>';
                   }
                 
                   
                ?>
                 </select></td>
            <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
            <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/></td>
            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
          </tr>
          <tr id='addr1'></tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="row clearfix" style="margin-top:20px">
    <div class="pull-right col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr class="hidden">
            <th class="text-center">Sub Total</th>
            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
          </tr>
          <tr class="hidden">
            <th class="text-center ">Tax</th>
            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                <input type="number" class="form-control" id="tax" placeholder="0">
                <div class="input-group-addon">%</div>
              </div></td>
          </tr>
          <tr class="hidden">
            <th class="text-center">Tax Amount</th>
            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
          <tr>
            <th class="text-center">Grand Total</th>
            <td class="text-center"><input type="number" name='total_amount' id="total_amount" value="<?php echo $invoice_amount?>" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
        </tbody>
      </table>
  
            </div>
            <!-- /.box-body -->

  <div class="row ">
    <div class="col-md-12">
    <div class="col-md-1">
       <button id="" class="btn btn-success pull-" name="save" required> Save</button>
     </form>
   </div>
   <div class="col-md-1">
      <button id="add_row" class="btn btn-default pull-">Add Row</button>
     </div>
     <div class="col-md-1">
      <button id='delete_row' class="pull- btn btn-">Delete Row</button>
    </div>
  </div>
  </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
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
    window.location='edit_invoice.php?invoice=<?php echo $get_invoice_ID?>' ;
   
  

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
