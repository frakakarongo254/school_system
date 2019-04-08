 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');

}
include("include/header.php");

  $event_id = $_POST['event_id'];
  $query_event_details = mysqli_query($conn,"select * from `event` where `event_ID` = '".$event_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_event = mysqli_fetch_array( $query_event_details,MYSQLI_ASSOC);
      $event_startDate=$rows_event["event_startDate"];
      //$event_startDate = date("d-m-Y", strtotime($start));
      $event_starttime = $rows_event["event_startime"];
      $event_endDate=$rows_event["event_endDate"];
      //$event_endDate = date("d-m-Y", strtotime($end));
      $event_endtime = $rows_event["event_startime"];
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
            <div class=" col-md-6">
            <div class=" input-group input-group-">
              <span class="input-group-addon">Start Date   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="edit_event_startDate"  id="" class="form-control"   placeholder="Starting Time" value="'.$event_startDate.'" required>
            </div>
          </div>
          <div class="col-md-6 ">
            <div class="input-group">
                <span class="input-group-addon">Start Time:   <i class="glyphicon glyphicon-time"></i></span>
                <input type="time" name="edit_event_startime"  id="" value="'.$event_starttime.'" class="form-control"   placeholder="Starting Time" required>
                
                
              </div>
            </div>
          </div>
          <br>
           
          <div class="row">
            <div class=" col-md-6">
            <div class=" input-group input-group-">
              <span class="input-group-addon">End Date   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="edit_event_endDate"  class="form-control" value="'.$event_endDate.'" placeholder="Ending time" required>
            </div>
          </div>
          <div class="col-md-6 ">
            <div class="input-group">
                <span class="input-group-addon">End Time:   <i class="glyphicon glyphicon-time"></i></span>
                <input type="time" name="edit_event_endtime"  id="" class="form-control"   placeholder="Starting Time" value="'.$event_endtime.'" required>
                
                
              </div>
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
                <button type="submit" name="editEventBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
             </form>';
             include("include/script.php");
?>
 
