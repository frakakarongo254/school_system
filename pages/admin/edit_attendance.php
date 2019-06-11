 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');

}
include("include/header.php");

  $attendance_id = $_POST['attendance_id'];
  $query_attend_details = mysqli_query($conn,"select * from `attendance` where `attendance_ID` = '".$attendance_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_attend = mysqli_fetch_array( $query_attend_details,MYSQLI_ASSOC);
?><form  action="manage_attendance.php" method="POST">
            <div class="row">   
              <label for="attendance">Signed in by </label>
              <div class=" col-md-12 input-group input-group-">
                  <input type="hidden" name="edit_attendance_id" value="<?php echo $rows_attend['attendance_ID'];?>">
               
              <select class="form-control " onchange="" name="edit_signedInBy" style="width: 100%;" required>
                   <option value="<?php echo $rows_attend['signed_in_by'];?>"><?php echo $rows_attend['signed_in_by'];?></option>
                   <?php
                 $query_c= mysqli_query($conn,"select staff.full_Name as name,admin.first_name as admFName, admin.second_name as admSName from staff join admin on admin.school_ID=staff.school_ID where staff.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['name'].'">'.$row_value['name'].'</option>';
                    echo' <option value="'.$row_value['admFName'].' '.$row_value['admSName'].'">'.$row_value['admFName'].' '.$row_value['admSName'].' </option>';
                   }
                 
                   
                ?>
                 </select>

              
              </div>
              <br>
            </div>
            <div class="row">   
              <label for="attendance">Signed Out by </label>
              <div class=" col-md-12 input-group input-group-">
                

              <select class="form-control " onchange="" name="edit_signedOutBy" style="width: 100%;" required>
                   <option value="<?php echo $rows_attend['signed_out_by'];?>"><?php echo $rows_attend['signed_out_by'];?></option>
                   <?php
                 $query_c= mysqli_query($conn,"select staff.full_Name as name,admin.first_name as admFName, admin.second_name as admSName from staff join admin on admin.school_ID=staff.school_ID where staff.school_ID = '".$_SESSION['login_user_school_ID']."'");
                 
                   foreach ($query_c as $row_value) {
                    
                  echo'  <option value="'.$row_value['name'].'">'.$row_value['name'].'</option>';
                    echo' <option value="'.$row_value['admFName'].' '.$row_value['admSName'].'">'.$row_value['admFName'].' '.$row_value['admSName'].' </option>';
                   }
                 
                   
                ?>
                 </select>
                
              </div>
              <br>
            </div>
            <div class="row">   
              <label for="attendance">Date</label>
              <div class="input-group date">
              <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" value="<?php echo $rows_attend['date_entered'];?>" disabled>
                </div>
              <br>
            </div>
            <div class="row">   
              <label for="attendance">Sign in Time</label>
              <div class="form-group">
                  

                  <div class="input-group">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="edit_attendanceTimeIn" value="<?php echo $rows_attend['sign_in_time'];?>"  class="form-control timepicker" required>

                  </div>
                  <!-- /.input group -->
                </div>
              <br>
            </div>
            <div class="row">   
              <label for="attendance">Sign out Time</label>
              <div class="form-group">
                  

                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="edit_attendanceTimeOut" value="<?php echo $rows_attend['sign_out_time'];?>"  class="form-control timepicker" required>

                    
                  </div>
                  <!-- /.input group -->
                </div>
              <br>
            </div>
          
           
            <div class="row">
           <div class="form-group">
                   <button type="submit" name="submitEditAttendance" class="btn " id="button1">Save Changes</button>
                </div>
              </div>
             </form>

 
<!-- include script-->
<?php include("include/script.php");?>