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
       $event_for=$rows_event["event_for"];
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
                </div>';
                if ($event_for =="Parent") {

               echo '<br>
              <div class="col-md-12 input-group ">
                <div class="row">
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red"  value="All" >
                    <label>ALL </label>
                  </label>
                  </div>
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Parent" checked>
                    <label>Parent</label>
                  </label>
                </div>
                <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Staff">
                    <label>Staff</label>
                  </label>
                </div>
                </div>
              </div>';
                }elseif ($event_for =="Staff") {
               echo '   <br>
              <div class="col-md-12 input-group ">
                <div class="row">
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red"  value="All">
                    <label>ALL </label>
                  </label>
                  </div>
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Parent">
                    <label>Parent</label>
                  </label>
                </div>
                <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Staff" checked>
                    <label>Staff</label>
                  </label>
                </div>
                </div>
              </div>';
                  
                }else{
                  echo '   <br>
              <div class="col-md-12 input-group ">
                <div class="row">
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red"  value="All" checked>
                    <label>ALL </label>
                  </label>
                  </div>
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Parent">
                    <label>Parent</label>
                  </label>
                </div>
                <div class="col-md-2">
                  <label >
                    <input type="radio" name="edit_event_for" class=" flat-red" value="Staff">
                    <label>Staff</label>
                  </label>
                </div>
                </div>
              </div>';
                }
            echo '
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editEventBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
             </form>';
             include("include/script.php");
             
?>
 <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="../../bower_components/moment/moment.js"></script>
<script src="../../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- bootstrap color picker -->
<script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="../../bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- CK Editor -->
<script src="../../bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../../dist/js/fusioncharts/fusioncharts.js"></script>