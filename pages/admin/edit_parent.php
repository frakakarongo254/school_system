 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $parent_ID = $_POST['parent_ID'];
  $query_parent_details = mysqli_query($conn,"select * from `parents` where `parent_ID` = '".$parent_ID."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_parents = mysqli_fetch_array( $query_parent_details,MYSQLI_ASSOC);
   
echo '  <form id="fileinfo" name="fileinfo" action="parent.php" method="POST" enctype="multipart/form-data">
                <div class="row">
              <div class=" col-md-6 mb-3">
                <div class="form-group has-feedback input-group-lg">
                      <label>First Name :</label>
               <div class=" col-md- input-group input-group-">
                <input type="text" name="edit_parent_first_name"  class="form-control" value="'.$rows_parents['first_Name'].'"   placeholder="First Name" required>
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
              </div>
              </div>
              <div class=" col-md-6 mb-3">
               <div class="form-group has-feedback input-group-">
                      <label>Last Name :</label>
               <div class=" col-md- input-group input-group">              
                <input type="text" name="edit_parent_last_name"  class="form-control"  value="'.$rows_parents['last_Name'].'" placeholder="Last Name" required>
                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
              </div>
              </div>            
            </div>
              <br>
              <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Gender:</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-gender"></i></span>
                
                <select name="edit_parent_gender" class="form-control">
                  <option value="'.$rows_parents['gender_MFU'].'">'.$rows_parents['gender_MFU'].'</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              
            </div>
            <br>
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Email :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" value="'.$rows_parents['email'].'" name="edit_parent_email" class="form-control" placeholder="" required>
              </div>
              
            </div>
            <br>
           
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="phone">Phone :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="tel" value="'.$rows_parents['cell_Mobile_Phone'].'" name="edit_parent_phone" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="address">Address :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" value="'.$rows_parents['address'].'" name="edit_parent_address" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
             <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Nationality :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                <input type="text" value="'.$rows_parents['nationality'].'" name="edit_parent_nationality" class="form-control" placeholder="" required>
              </div>    
            </div>
            <br>
            
            <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Profession :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
                <input type="text" class="form-control" value="'.$rows_parents['profession'].'" name="edit_parent_profession" placeholder="Profession" required="">
              </div>    
            </div>
            <br>
            
             <div class="row">   
              <div class="form-group  col-md-3 mb-3">
                <label for="nationality">Profile Photo :</label>
              </div>
              <div class=" col-md-5 input-group input-group-">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="file" name="edit_parent_profile_photo" class="form-control" placeholder="" > 
              </div>    
            </div>
            <div class="row">
              <div class="col-md-12">
                 <input type="hidden" name="edit_parent_ID" value="'.$rows_parents['parent_ID'].'">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="edit_parentBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
          
              <!-- /.tab-pane -->
              </form>';
?>
 
