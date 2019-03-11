 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $zone_id = $_POST['zone_id'];
  $query_zone_details = mysqli_query($conn,"select * from `zone` where `zone_ID` = '".$zone_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_zone = mysqli_fetch_array( $query_zone_details,MYSQLI_ASSOC);
echo ' <form  action="zone.php" method="POST">
            <div class="row">   
              <label for="nationality">Zone Name:</label>
              <div class=" col-md-12 input-group input-group-">
                
                <input type="text" name="edit_zone_name" value="'.$rows_zone['zone'].'" class="form-control" placeholder="Class Name" required>
                <input type="hidden" value="'.$rows_zone['zone_ID'].'" name="edit_zone_id">
              </div>
              <br>
            </div>
             <div class="row">   
              <label for="nationality">One Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" value="'.$rows_zone['oneWayCharge'].'" class="form-control" name="edit_oneWayCharge">
                
              </div>
              
            </div>
           <br>
            <div class="row">   
              <label for="nationality">Two Way Charge:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                <input type="text" value="'.$rows_zone['twoWayCharge'].'" class="form-control" name="edit_twoWayCharge">
                
              </div>
              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editZoneBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
             </form>';
?>
 
