 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $stream_id = $_POST['stream_id'];
  $query_stream_details = mysqli_query($conn,"select * from `stream` where `stream_ID` = '".$stream_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_stream = mysqli_fetch_array( $query_stream_details,MYSQLI_ASSOC);
echo ' <form id="fileinfo" name="" action="school_profile.php" method="POST" >
            <input type="hidden" name="edit_stream_id" value="'.$rows_stream['stream_ID'].'">
            <div class="form-group">   
              <label for="nationality">Stream Name:</label>
                <input type="text" class="form-control" name="edit_stream_name" placeholder="Stream Name" value="'.$rows_stream['stream_name'].'">  
            </div>
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="editStreamBtn" href="#">Edit Stream</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>';
?>
 
