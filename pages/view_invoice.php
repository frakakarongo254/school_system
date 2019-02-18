<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
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
                

                ?>
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
                if(isset($_GET['id'])){
  $invoiveId =$_GET['id'];
  include('config.php');
    $result_array = array();

  //$result=mysqli_query($conn,"select * from `invoice_item` where `invoice_id`='".$invoiveId."' and school_ID='$school_ID' ");


 if ($result->num_rows > 0) {
   while($rowss = $result->fetch_assoc()) {
     $ClientName=$row['product_name'];
     $d=strtotime("today");
          $todaysdate = date("d/m/Y", $d);
     
   }
 }
    ?>
  <table class="table">
 <thead>
 <tr>
 <th colspan="6"><b><?php echo $school_row['school_Name']."<br>". $school_row['address_1'] ."<br>". $school_row['phone']."<br>".$school_row['email']."<br>".$school_row['school_website']";?></b></th>
 <th></th>
 
 <th style="margin-right:100px"><?php echo $ClientName."<br> Receipt #: ".$transactionCode ."<br> Date: " . $todaysdate ;?></th>
 </tr>
 <td><ul class="nav nav-pills nav-stacked">
        <li><a href="#"><i class="fa  fa-institution"></i><b><?php echo $school_row['school_Name']?></b></a></li>
        <li><a href="#"><i class="fa fa-bookmark-o"></i> Po. Box <?php echo $school_row['address_1']?></a></li>
        <li><a href="#"><i class="fa fa-phone"></i> <?php echo $school_row['phone']?></a></li>
        <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $school_row['email']?></a></li>
        <li><a href="#"><i class="fa fa-globe"></i> <?php echo $school_row['school_website']?></a></li>
      </ul></td>
 </thead>
 </table>
  <table class="table">
 <thead>
 <tr>
 <th>Date to pick</th>
 <th>Item</th>
 <th>Quantity</th>
 <th>Price</th>
 <th>Total</th>
 </tr>
 </thead>
 <tbody>
          
        <?php
        $tot=0;
        while($rows = $result->fetch_assoc()) {
          $vat=$rows["vat"];
          $dueAmount=$rows["due_amount"];
          $Balance=$rows["balance_amount"];
          $paidAmount=$rows["paid_amount"];
        $customer_name=$rows["customer_name"];
        $grand_total=$rows["grand_total"];
        $discount=$rows["discount"];
        $pick_date=$rows["pick_date"];
    echo '<form method="POST" action="createorder.php" role="form" name="form1" id="form1s"><tr>
     <td>'.$rows["pick_date"] .'</td><td>'
      .$rows["item"].
       '</td>
       
       <td>'.$rows["quantity"].'</td>
       <td>'.$rows["price"].'</td>
       
       <td>'.$rows["total"] ;
       // delete and edit category button
     echo"</td>
      
     
    </tr>
    
    </form>";
    
    //array_push($result_array, $row);
    
 $tot+=$rows['total'];
 

    }
  ?>
    <tr>
       
         
         
     
        
         <td rowspan="7" colspan="2"></td>    
         <td rowspan="" colspan=""><b>Sub total</b></td>    
         <td><b>Ksh  <?php echo $tot;?></b></td>    
         
    </tr>
    <tr>
    
         
     
         <td ><b>Tax</b></td>   
         <td><b>Ksh  <?php echo $vat;?></b></td>    
          
    </tr>
    <tr>
    
     
         <td ><b>Discount</b></td>    
         <td><b>Ksh  <?php echo $discount;?></b></td>   
          
    </tr>
    <tr>
    
         
     
         <td ><b>Grand Total</b></td>   
         <td><b>Ksh  <?php echo $grand_total;?></b></td>    
  
    </tr>
    <tr>
    
         
     
         <td ><b>Paid Amount</b></td>   
         <td><b>Ksh  <?php echo $paidAmount;?></b></td>   
  
    </tr>
    <tr>
    
         
     
         <td ><b>Due Amount</b></td>    
         <td><b>Ksh  <?php echo $dueAmount;?></b></td>    
  
    </tr>
    <tr>
    
         
     
         <td ><b>Balance Amount</b></td>    
         <td><b>Ksh   <?php echo  $Balance;?></b></td>    
  
    </tr>
    
    </tbody>
    
</table>
    <?php
} else {
    //echo  json_encode("No Match"); 
}
  
}else{
  echo"not yet";
}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
      </div>
    <!--- add zone Modal -->
      <div class="modal fade" id="modal-addZone">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Zone</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="zone.php" method="POST">
            <div class="row">   
              <label for="nationality">Zone Name:</label>
              <div class=" col-md-12 input-group input-group-">
                
                <input type="text" name="zone_name" class="form-control" placeholder="Zone Name" required>
              </div>
              <br>
            </div>
             <div class="row">   
              <label for="nationality">One Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" class="form-control" name="oneWayCharge">
                
              </div>
              
            </div>
           <br>
            <div class="row">   
              <label for="nationality">Two Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" class="form-control" name="twoWayCharge">
                
              </div>
              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addZoneBtn" class="btn btn-primary">Add Zone</button>
              </div>
              </div>
             </form>
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
         <!-- delete zone  Modal-->
    <div class="modal  fade" id="delete_zone_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete this Class?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteZone(id,name){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete<b style="font-size:20px"> ' + name + '  </b>from the system?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="class.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteZoneFromSystem(this.id)">Delete</button></form></div>';
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

    <!-- edit zone Modal-->
    <div class="modal  fade" id="edit_zone_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Zone</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editZone(id){ 
                
                  if(id !=''){
                    var details= '&zone_id='+ id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_zone.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("classMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("classMessage").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="classMessage"></div>

        </div>
          </div>
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
