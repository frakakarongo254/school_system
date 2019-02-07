 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $event_id = $_POST['event_id'];
  $query_event_details = mysqli_query($conn,"select * from `event` where `event_ID` = '".$event_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_event = mysqli_fetch_array( $query_event_details,MYSQLI_ASSOC);
echo '<form  action="event.php" method="POST">
           <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-info"></i></span>
              <input type="hidden"name="edit_event_id" value="'.$rows_event['event_ID'].'" >
              <input type="text" name="edit_event_title"  class="form-control"   placeholder="title" value="'.$rows_event['event_title'].'" required>
            </div>
          </div>
           <br>
            <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
              <input type="text" name="edit_event_location"  class="form-control"  value="'.$rows_event['event_location'].'" placeholder="location" required>
            </div>
          </div>
          <br>
           <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              <input type="date" name="edit_event_startime"  id="datepicker" class="form-control"  value="'.$rows_event['event_startime'].'" placeholder="Starting Time" required>
            </div>
          </div>
           
          <br>
           <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              <input type="date" name="edit_event_endtime"  value="'.$rows_event['event_endtime'].'"  class="form-control"  placeholder="Ending time" required>
            </div>
          </div>
          <br>
           <div class="row">
            <div class=" col-md-12 input-group input-group-">
              
              <textarea type="text" name="edit_event_description"  class="form-control"   placeholder="Description" required>'.$rows_event['event_description'].'</textarea>
            </div>
            <br>
          </div>
          <div class="input-group my-colorpicker2">
                  <input type="color" name="edit_event_color" value="'.$rows_event['event_color'].'" class="form-control my-colorpicker1">

                  <div class="input-group-addon">
                    <i></i>
                  </div>
                </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editEventBtn" class="btn btn-primary">Add Event</button>
              </div>
              </div>
             </form>';
?>
 
