 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $RegNo = $_POST['RegNo'];
  $query_details = mysqli_query($conn,"select * from `student` where `registration_No` = '".$RegNo."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_details = mysqli_fetch_array($query_details,MYSQLI_ASSOC);
echo '<form method="POST" action="student.php">
      <div class="row">
        <div class="form-group  col-md-2 mb-3">
          <label for="">Reg No :</label>
        </div>
        <div class=" col-md-3 input-group input-group-">
          
          <input type="text" name="edit_RegNo"  class="form-control"  value="'.$_POST['RegNo'].'" placeholder="Nickname" disabled>
          <input type="hidden" name="edit_student_RegNo"  class="form-control"  value="'.$_POST['RegNo'].'" placeholder="Nickname" >
        </div>
      </div>
      <br>
      <div class="row">
        <div class=" col-md-6 mb-3">
          <div class="form-group has-feedback input-group-lg">
                <label>First Name :</label>
         <div class=" col-md- input-group input-group-">
          <input type="text" name="edit_student_first_name"  class="form-control" value="'.$rows_details['first_Name'].'"  placeholder="First Name" required>
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
        </div>
        </div>
        </div>
        <div class=" col-md-6 mb-3">
         <div class="form-group has-feedback input-group-">
                <label>Last Name :</label>
         <div class=" col-md- input-group input-group">              
          <input type="text" name="edit_student_last_name"  class="form-control"  value="'.$rows_details['last_Name'].'"placeholder="Last Name" required>
           <span class="input-group-addon"><i class="fa fa-user"></i></span>
        </div>
        </div>
        </div>            
      </div>
      <br>
      
      <div class="row">
        <div class="form-group  col-md-3 mb-3">
          <label for="nationality">Nickname :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
          <input type="text" name="edit_student_nickname"  class="form-control"  value="'.$rows_details['nickname'].'" placeholder="Nickname" required>
        </div>
      </div>
      <br>
     
       <div class="row">
         <div class="form-group  col-md-3 mb-3">
          <label for="nationality">Gender :</label>
        </div>
        <div class=" col-md- input-group input-group-">
          <div class="form-group">
          <label>
            <input type="radio" name="edit_student_gender" class=" flat-red"  value="Male" checked>
            <label>Male</label>
          </label>
          <label>
            <input type="radio" name="edit_student_gender" class=" flat-red" value="Female">
            <label>Female</label>
          </label>
        
        </div>
        </div>
      </div>
      <br>
      
       <div class="row">
       
        <div class="form-group  col-md-3 mb-3">
          <label for="nationality">Date Of Birth :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          <span class="input-group-addon"><i class="fa fa-birthday"></i></span>
          <input type="date" name="edit_student_dateOfBirth" value="'.$rows_details['date_of_Birth'].'" class="form-control" placeholder="" required>
        </div>
        
      </div>
      <br>
      
       <div class="row">
        <div class="form-group  col-md-3 mb-3">
          <label for="nationality">Admission Date :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          <input type="date" name="edit_student_admission_date" class="form-control" value="'.$rows_details['admission_date'].'" placeholder="" required>
        </div>
        
      </div>
      <br>
        <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Zone :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-map"></i></span>
                <select name="edit_student_zone" class="form-control">';
                
                 $query_zone = mysqli_query($conn,"select * from zone where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($zone_rows=mysqli_fetch_array($query_zone)){
                    $student_regNoID= $zone_rows['class_name'];
                  echo'  <option value="'.$zone_rows['zone'].'">'.$zone_rows['zone'].'</option>';
                   }
                   echo '
              

              </select>
                
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="zone">Transport Type:</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-bus"></i></span>
              <select name="edit_zoneChargeType" class="form-control">
               <option value="None">None</option>
               <option value="oneWayCharge">One Way</option>
               <option value="twoWayCharge">Two Way</option>
              </select>
                </div>
              </div>
              <br>
               <div class="row">
                <div class="form-group  col-md-3 mb-3">
                  <label for="nationality">Class :</label>
                </div>
                <div class=" col-md-7 input-group input-group-">
                  <span class="input-group-addon"><i class="fa fa-o"></i></span>
                <select name="edit_student_class" class="form-control">';
                
                 $qer = mysqli_query($conn,"select * from class where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($rows1=mysqli_fetch_array($qer)){
                    $student_regNoID= $rows1['class_name'];
                  echo'  <option value="'.$rows1['class_name'].'">'.$rows1['class_name'].'</option>';
                   }
                   
              
           echo'   </select>
                
                </div>
                
              </div>
       <div class="row">
         <div class="form-group  col-md-3 mb-3">
          <label for="nationality">Profile Photo :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
          <input type="file"  class="form-control" name="edit_student_profile_photo" required>
        </div>
       
        
      </div>
   
    
      <br>
     
       <div class="row">
        <div class="form-group  col-md-3 mb-3">
         <label for="nationality">Healthy comment :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          <textarea class="form-control" name="edit_healthyComment" placeholder="Healthy comment" value="'.$rows_details['other_Details'].'"required></textarea>
        </div>
       
      </div>
      <br>
      <div class="row">
        <div class="form-group  col-md-3 mb-3">
         <label for="nationality">Status :</label>
        </div>
        <div class=" col-md-7 input-group input-group-">
          
          <select class="form-control" name="status" >
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
       
      </div>
       <div class="row">
      <div class="col-md-12">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
        <button type="submit" name="editStudentBtn" class="btn btn-primary">Save Changes</button>
      </div>
      </div>
     
   </form>';
?>
 
