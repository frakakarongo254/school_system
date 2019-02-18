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
        
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Zone added  successfully.
          </div>';   
        }
         if(isset($_GET['invoice'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Invoice created successfuly.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Zone updated  successfully.
          </div>';   
        }
        if(isset($_GET['delete'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have deleted  successfully.
          </div>';   
        }
       if(isset($_POST['addZoneBtn'])){
        
          #get school Id from current session school id
         $school_ID = $_SESSION['login_user_school_ID'];
        $zone_name=$_POST['zone_name'];
        $oneWayCharge=$_POST['oneWayCharge'];
        $twoWayCharge=$_POST['twoWayCharge'];
       
        $class_insert_query=mysqli_query($conn,"insert into `zone` (school_ID, zone,oneWayCharge,twoWayCharge
          ) 
          values('$school_ID','$zone_name','$oneWayCharge','$twoWayCharge') ");

        
        if($class_insert_query){
           echo '<script> window.location="zone.php?insert=True" </script>';
       }else{
       echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
       }
      }
        # edit zone
        if(isset($_POST['editZoneBtn'])){

        #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $edit_zone_name=$_POST['edit_zone_name'];
        $edit_zone_id=$_POST['edit_zone_id'];
        $edit_oneWayCharge=$_POST['edit_oneWayCharge'];
        $edit_twoWayCharge=$_POST['edit_twoWayCharge'];
        $update_zone_query=mysqli_query($conn,"update `zone` SET zone= '".$edit_zone_name."', oneWayCharge= '".$edit_oneWayCharge."',twoWayCharge= '".$edit_twoWayCharge."' where `zone_ID`='".$edit_zone_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");


        if($update_zone_query){
        echo '<script> window.location="zone.php?update=True" </script>';
        }else{
        echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
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
                
 if(isset($_POST['save']))  
{  
    echo "francis";
    $rand = substr(number_format(time() * rand(),0,'',''),0,10);
    $Ref="REF".$rand;
echo $summury=$_POST['summury'];  
echo $invoiceDate=$_POST['invoiceDate'];
echo $dueDate=$_POST['dueDate'];  
echo $studentID=$_POST['studentId'];
echo $total_amount=$_POST['total_amount'];

 $que=mysqli_query($conn,"insert into `invoice_student` (student_ID,school_ID, amount,invoice_date,due_date,summury,reff_no
          ) 
          values('$studentID','$school_ID','$total_amount','$invoiceDate','$dueDate','$summury','$Ref') ");

if($que){
    echo "yes";
}else{
    echo"not". mysqli_error($conn);
}
echo $id=mysqli_insert_id($conn);  
for($i = 0; $i<count($_POST['product']); $i++)  
{  
mysqli_query($conn,"INSERT INTO invoice_item  
SET   
invoice_id = '{$id}',  
product_name = '{$_POST['product'][$i]}',  
quantity = '{$_POST['qty'][$i]}',  
price = '{$_POST['price'][$i]}',  
amount = '{$_POST['total'][$i]}',
school_ID = '{$school_ID}'"); 

 //echo '<script> window.location="fee_structure.php?invoice=True" </script>'; 
}  

}   
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
                <form method="POST" action="fee_structure.php">
                <table class="table table-bordered table-hover" id="">
               
                    <tr>
                      <td rowspan="" class="pull-left"> <?php echo $logo;?>
                       </td>
                       <td >
                           To<select class="form-control select2" name="studentId" style="width: 100%;" required>
                    <option value="">--Select Student--</option>
                  <?php
                 $query_c= mysqli_query($conn,"select * from student where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($crows=mysqli_fetch_array($query_c)){

                  echo'  <option value="'.$crows['student_ID'].'">'.$crows['first_Name'].' '.$crows['last_Name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
                       </td>
                   </tr>
                   <tr>
                      <td><ul class="nav nav-pills nav-stacked">
                <li><a href="#"><i class="fa  fa-institution"></i><b><?php echo $school_row['school_Name']?></b></a></li>
                <li><a href="#"><i class="fa fa-bookmark-o"></i> Po. Box <?php echo $school_row['address_1']?></a></li>
                <li><a href="#"><i class="fa fa-phone"></i> <?php echo $school_row['phone']?></a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $school_row['email']?></a></li>
                <li><a href="#"><i class="fa fa-globe"></i> <?php echo $school_row['school_website']?></a></li>
              </ul></td>
                     <td>
                
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="invoiceDate" id="datepicker" class="form-control" placeholder="Invoice Date" required>
                </div>
                <br>
                <div class=" col-md- input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" name="dueDate" id="datepicker2" class="form-control" placeholder="Due Date" required>
                </div>
                <br>
                <textarea class="form-control" rows="3" name="summury" maxlength="100" placeholder="Summury"></textarea>
                     </td>
                    </tr>
              </table>
          <table class="table table-bordered table-hover" id="tab_logic">
        <thead>
          <tr>
            <th class="text-center"> # </th>
            <th class="text-center"> Product </th>
            <th class="text-center"> Qty </th>
            <th class="text-center"> Price </th>
            <th class="text-center"> Total </th>
          </tr>
        </thead>
        <tbody>
          <tr id='addr0'>
            <td>1</td>
            <td><input type="text" name='product[]'  placeholder='Enter Product Name' class="form-control"/></td>
            <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
            <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/></td>
            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
          </tr>
          <tr id='addr1'></tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row clearfix">
    <div class="col-md-12">
      <button id="add_row" class="btn btn-default pull-left">Add Row</button>
      <button id="" class="btn btn-default pull-left" name="save">Save</button>
      <button id='delete_row' class="pull-right btn btn-default">Delete Row</button>
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
            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
        </tbody>
      </table>
  </form>
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
