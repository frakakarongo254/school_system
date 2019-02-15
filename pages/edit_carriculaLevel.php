 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $level_id = $_POST['level_id'];
  $query_level_details = mysqli_query($conn,"select * from `carricula_level` where `carricula_level_ID` = '".$level_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_level = mysqli_fetch_array( $query_level_details,MYSQLI_ASSOC);
echo '  <form  action="view_carricula.php" method="POST" >
           <input type="hidden" name="edit_level_id" value="'.$rows_level['carricula_level_ID'].'">
            <div class="form-group">   
              <label for="nationality">Level Number:</label>
                <input type="text" class="form-control" name="edit_level_number" placeholder="Level Number" value="'.$rows_level['level_number'].'">  
            </div>
            <div class="form-group">   
              <label for="nationality">Level Name:</label>
                <input type="text" class="form-control" name="edit_level_name" placeholder="Name Name" value="'.$rows_level['level_name'].'">  
            </div>
            <div class="form-group">   
              <label for="nationality">Abbreviation:</label>
                <input type="text" class="form-control" name="edit_level_abbreviation" placeholder="level Abbreviation" value="'.$rows_level['abbreviation'].'">  
            </div>
             
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editLevelBtn" class="btn btn-primary">Edit Level</button>
              </div>
              </div>
              

             </form>';
?>
 
