 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $staff_ID = $_POST['staff_ID'];
  $query_staff_details = mysqli_query($conn,"select * from `staff` where `staff_ID` = '".$staff_ID."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_staff = mysqli_fetch_array( $query_staff_details,MYSQLI_ASSOC);
echo '  <form  action="staff.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_staff_ID" value="'.$rows_staff['staff_ID'].'">
            <div class="form-group">   
              <label for="nationality">Full Name:</label>
                <input type="text" class="form-control" name="edit_staff_name" placeholder="First Middle Last" value="'.$rows_staff['full_Name'].'">  
            </div>
            <div class="form-group">   
              <label for="nationality">Staff No:</label>
                <input type="text" class="form-control" name="edit_staff_no" placeholder="Staff No" value="'.$rows_staff['staff_No'].'">  
            </div>
             <div class="form-group">
                <label>Role</label>
                <select class="form-control select2" name="edit_staff_role" style="width: 100%;">
                  <option value="'.$rows_staff['role'].'" selected="selected">'.$rows_staff['role'].'</option>
                  <option value="">Role</option>
                  <option value="Admin">Admin</option>
                  <option value="Teacher">Teacher</option>
                  <option value="Staff">Staff</option>
                  
                </select>
              </div>
             <div class="form-group">   
              <label for="nationality">Nationality:</label>
                 <select class="form-control select2" name="edit_staff_nationality" style="width: 100%;">';
                 
                    include("include/nationality.php");

              echo ' <option value="'.$rows_staff['nationality'].'" selected="selected">'.$rows_staff['nationality'].'</option>
              </select>
            </div>
            
             <div class="form-group">
                <label>Gender</label>
                <select class="form-control select2"  name="edit_staff_gender" style="width: 100%;">
                <option value="'.$rows_staff['gender'].'" selected="selected">'.$rows_staff['gender'].'</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                 
                </select>
              </div>
              <div class="form-group">   
              <label for="nationality">Phone:</label>  

                  <input type="tel" class="form-control" name="edit_staff_phone"  value="'.$rows_staff['phone'].'">
            </div>
            <div class="form-group">   
              <label for="nationality">Email:</label>
                <input type="email" class="form-control" name="edit_staff_email" placeholder="Email" value="'.$rows_staff['email'].'">  
            </div>
             <div class="form-group">   
              <label for="nationality">Photo:</label>
                <input type="file" class="form-control" name="edit_staff_photo" placeholder="photo" >  
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editStaffBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
              

             </form>';
?>
 
