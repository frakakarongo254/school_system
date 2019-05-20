 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');

}
$school_ID = $_SESSION['login_user_school_ID'];
?>

<?php
//include("include/header.php");

  $student_id = $_POST['student_id'];
  $transport_query = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and student_ID='".$student_id."'")or die(mysqli_error());
   $rows_transport = mysqli_fetch_array( $transport_query ,MYSQLI_ASSOC);
   $transportType_type= $rows_transport['zone_transport_type'];
   $zone= $rows_transport['zone'];
   $charges='';
   if ($transportType_type=="oneWayCharge") {
     $zone_query = mysqli_query($conn,"select * from zone where school_ID = '".$school_ID."' and zone='".$zone."'")or die(mysqli_error());
   $rows_zone = mysqli_fetch_array( $zone_query ,MYSQLI_ASSOC);
     $charges=$rows_zone['oneWayCharge'];

   }elseif ($transportType_type=="twoWayCharge") {
     $zone_query = mysqli_query($conn,"select * from zone where school_ID = '".$school_ID."' and zone='".$zone."'")or die(mysqli_error());
   $rows_zone = mysqli_fetch_array( $zone_query ,MYSQLI_ASSOC);
     $charges=$rows_zone['twoWayCharge'];
   }else{
    $charges=0.00;
    $transportType_type ="None";
   }
   $zone_query = mysqli_query($conn,"select * from zone where school_ID = '".$school_ID."' and zone='".$zone."'")or die(mysqli_error());

   $query_vhead= mysqli_query($conn,"select * from vote_head where school_ID = '".$_SESSION['login_user_school_ID']."' and name='Transport' || name='transport'");
   $rows_z = mysqli_fetch_array(  $query_vhead ,MYSQLI_ASSOC);
   $num=mysqli_num_rows ( $query_vhead );
   $vote_head_id=$rows_z['vote_head_ID'];
   if($num >0){
 echo' 
            <td class="hidden">1</td>
            <td>
             <select class="form-control " name="vote_head_id[]"" style="width: 100%;" required>
                    <option value="'.$vote_head_id.'">Transport </option>';
                  
                 $query_votehead= mysqli_query($conn,"select * from vote_head where school_ID = '".$_SESSION['login_user_school_ID']."'");
                   while ($votehead_rows=mysqli_fetch_array($query_votehead)){

                  echo'  <option value="'.$votehead_rows['vote_head_ID'].'">'.$votehead_rows['name'].'</option>';
                   }
                 
                echo '
                
                 </select>
            </td>
            <td><input type="number" name="qty[]" placeholder="Enter Qty" class="form-control qty" value="1" step="0" min="0"/></td>
            <td> <div class=" col-md- input-group input-group-"> <span class="input-group-addon">'.$school_row['currency'].'  </span><input type="number" name="price[]"" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0" value="'.$charges.'"/></div></td>
            <td><div class=" col-md- input-group input-group-"> <span class="input-group-addon">'.$school_row['currency'].'  </span><input type="number" name="total[]" placeholder="0.00" value="'.$charges.'" class="form-control total" readonly/></div></td>
          ';
        }else{
          echo '<div style="font-weight:bold;">You have not yet set up Transport as Vote Head <a href="vote_head.php" style="text-decoration:none;font-weight:bold;">Set now</a><div>';
        }
//include('include/script.php');
?>
 
