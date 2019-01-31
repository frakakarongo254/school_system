 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $class_id = $_POST['class_id'];
  $query_class_details = mysqli_query($conn,"select * from `class` where `class_ID` = '".$class_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_class = mysqli_fetch_array( $query_class_details,MYSQLI_ASSOC);
echo '<form  action="class.php" method="POST">
            <div class="row">   
              <label for="nationality">Class Name:</label>
              <div class=" col-md-12 input-group input-group-">
                
                <input type="text" name="edit_class_name" value="'.$rows_class['class_name'].'" class="form-control" placeholder="Class Name" required>
                <input type="hidden" name="edit_class_id" value="'.$rows_class['class_ID'].'">
              </div>
              
            </div>
           <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="EditClassBtn" class="btn btn-primary">Edit Class</button>
              </div>
              </div>
             </form>';
?>
 
