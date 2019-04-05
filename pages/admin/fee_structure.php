<?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
  #get school Id from current session school id
$school_ID = $_SESSION['login_user_school_ID'];
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
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section>
      <?php
      if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Vote head added  successfully.
          </div>';   
        }
        if(isset($_GET['invoice'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          You have invoiced  successfully.
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
        ?>
    </section>


    <!-- Main content -->
    <div></div>
    <section class="content box box-primary">
      <!-- Small boxes (Stat box) -->
      <div class="row bg-#fff">
        
         <div class="col-md-2 box-primary ">
        <span class="fa fa-gear"></span><b class="color-primary" >  Fee Structure</b>
           <ul class="nav nav-pills nav-stacked">
                <li><a href="vote_head.php"><i class="fa fa-arrow-circle-right"></i> Vote Head</a></li>
                <li><a href="fee_structure.php"><i class="fa fa-arrow-circle-right"></i>Fee Structure</a></li>
                  <li><a href="paymentMode.php"><i class="fa fa-arrow-circle-right"></i>Payment Mode</a></li>
              </ul>
         </div>
       
         <div class="col-md-10  ">
          <?php
          #Add fee structure
          if (isset($_POST['add_feeStructure'])) {
           
            $vote_head_id=$_POST['$vote_head_ID'];
             $vote_head_amount=$_POST['vote_head_amount'];
           
           #check if such carricula already exist
            $votehead_data_sql = mysqli_query($conn,"select * from `fees_structure` where `vote_head_ID` = '".$vote_head_id."' and `school_ID` = '".$school_ID."' ");
            $votehead_row=mysqli_num_rows ( $votehead_data_sql);
            if ($votehead_row !=0) {
              echo' <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true">
              &times;
              </button>
              Such Vote head already exist.
              </div>'; 
            }else{

             $votehead_insert_query=mysqli_query($conn,"insert into `fees_structure` (school_ID, vote_head_ID,amount
          ) 
          values('$school_ID','$vote_head_id','$vote_head_amount') ");
              if($votehead_insert_query){
               
              echo '<script> window.location="fee_structure.php?insert=true" </script>';
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
          }

       
      #invoice all student
          if (isset($_POST['InvoiceAllStudent'])) {
            $dueDate= date('Y/m/d H:i:s');
           $rand = substr(number_format(time() * rand(),0,'',''),0,10);
         echo $Ref="INV-".$rand;
            $query2 = mysqli_query($conn,"select student_ID from student where school_ID = '$school_ID'")or
                   die(mysqli_error());
                  $std_ID=array();
                  $stdID=array();
              while($row_event = mysqli_fetch_array($query2))
              {
                
                 $std_ID[] = $row_event['student_ID'];
                    
              }
               $std_ID = $std_ID;
              echo $stdID = implode(", ", $std_ID);
               //echo $stdID = var_dump($stdID);
          $summury='School Fees';
          $quantity=1;
          
          for($i = 0; $i<count($std_ID); $i++)  
          {  
          $que=mysqli_query($conn,"INSERT INTO invoice 
          SET   
          student_ID = '{$std_ID[$i]}',  
          amount = '{$_POST['total_amount']}',  
          invoice_date = '{ $dueDate}',  
          due_date = '{$dueDate}',
          balance = '{$_POST['total_amount']}',
          summury = '{$summury}',
          reff_no = '{$Ref}',
          school_ID = '{$school_ID}'");
          }
          if($que){

          $id=mysqli_insert_id($conn);  
          for($i = 0; $i<count($_POST['vote_head_id']); $i++)  
          {  
          $query1=mysqli_query($conn,"INSERT INTO invoice_item  
          SET   
          invoice_id = '{$id}',  
          vote_head_ID = '{$_POST['vote_head_id'][$i]}',  
          quantity = '{$quantity}', 
          ref_no = '{$Ref}', 
          price = '{$_POST['head_amount'][$i]}',  
          amount = '{$_POST['head_amount'][$i]}',
          student_ID = '{$std_ID[$i]}',
          school_ID = '{$school_ID}'"); 

         // echo '<script> window.location="fee_structure.php?invoice=True" </script>'; 
          }
          if ($query1) {
             # code...
           // echo "<script> alert('You have successfully invoiced the student') </script>";
            echo '<script> window.location="fee_structure.php?invoice=True" </script>';
           } else{
            echo "not".mysqli_error($conn);
           }
      }else{
        echo "failed".mysqli_error($conn);
      }
    }
          ?>
         
          <!-- Profile Image -->
          <div class="box box-secondary col-md-">
            <div class="box-body box-profile col-md-">
              <div class="row">
                <div class="col-md-9">
                  <form role="form" method="POST" action="fee_structure.php">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <select class="form-control " name='$vote_head_ID' style="width: 100%;" required>
                    <option value="">--Select item--</option>
                  <?php
                 $query_votehead= mysqli_query($conn,"select * from vote_head where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($votehead_rows=mysqli_fetch_array($query_votehead)){

                  echo'  <option value="'.$votehead_rows['vote_head_ID'].'">'.$votehead_rows['name'].'</option>';
                   }
                 
                   
                ?>
                 </select>
               </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" name="vote_head_amount" class="form-control">
                        </div> 
                  
                      </div>
                      <div class="col-md-4">
                         <button type="submit" class="btn btn-primary " href="#"  name="add_feeStructure"><i class="fa fa-plus"></i><b> Add </b></button>
                      </div>
                    </div>
                
                </form>
                </div>
                <div class="col-md-3 ">
               
              </div>
              
             </div>
             
                 <div class="row">
                   <div class="col-md-12">
                    <form  method="POST" action="fee_structure.php">
                      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Vote head</th>
                   <th>Amount</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                 
                   <?php
                    $query2 = mysqli_query($conn,"select * from fees_structure where  school_ID = '$school_ID' ")or
                             die(mysqli_error());
                             $total_amount=0.00;
                             while ($row2=mysqli_fetch_array($query2)){

                             $fee_structure_ID= $row2['fee_structure_ID'];
                              $vote_headID= $row2['vote_head_ID'];
                               $fee_item_amount= $row2['amount'];
                               $total_amount=$total_amount + $row2['amount'];
                              $query3 = mysqli_query($conn,"select * from vote_head where vote_head_ID='$vote_headID' and school_ID = '$school_ID' ")or
                             die(mysqli_error());
                             while ($votehead_row=mysqli_fetch_array($query3)){
                                 echo" <tr>
                          
                            <td><input type='hidden' name='vote_head_id[]' value='".$vote_headID."'>".$votehead_row['name']."</td>
                             <td><input type='hidden' name='head_amount[]' value='".$fee_item_amount."'>".$fee_item_amount."</td>
                            
                            <td>";
                            
                           echo'   

                             <button type="button" id="'. $fee_structure_ID.'" class="btn btn-danger btn-flat" value="'.$votehead_row['name'].'" onclick="deleteFeeItemFromSystem(this.id,this.value)" ><span class="glyphicon glyphicon-trash"></span>   Delete</button>
                           </td>
                         </tr>';
                             }
                           }
                 
                  
                  
                    
                  ?>
               
                 </tbody>
                <tfoot>
                <tr>
                   <th colspan="3">
                    <input type="hidden" name="total_amount" value="<?php echo $total_amount;?>">
                    <button type="submit" class="btn btn-primary pull-" href="#" data-toggle="modal" data-target="#modal-InvoiceAllStudents" name="InvoiceAllStudent"><i class="fa fa-plus"></i><b> INVOICE ALL STUDENTS</b></button>
                   </th>
                  
                </tr>
                </tfoot>
              </table>
            </form>
                   </div>
                   
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    
   <div class="modal fade" id="modal-InvoiceAllStudents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Invoice All Students?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Are you sure you want to in voice all student</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary pull-left" href="login.html">Invoice</a>
          </div>
        </div>
      </div>
    </div>

      
   

    
      
       
         
     
    </section>
    <!-- /.content -->
    <div class="row">
       <!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
    </div>
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>


</div>
</section>
  <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
<!-- ./wrapper -->

<!-- include script-->
<?php include("include/script.php")?>
<script >
  function deleteFeeItemFromSystem(fee_item_id){
 // alert(fee_item_id);
  var details= '&item_id='+ fee_item_id;
  $.ajax({
  type: "POST",
  url: "delete_feeStructure_item.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="fee_structure.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>
</body>
</html>
