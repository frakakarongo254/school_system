 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $carricula_id = $_POST['carricula_id'];
  $query_carri_details = mysqli_query($conn,"select * from `carricula` where `carricula_ID` = '".$carricula_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_carri = mysqli_fetch_array( $query_carri_details,MYSQLI_ASSOC);
echo ' <form  action="school_carricula.php" method="POST" >
              <input type="hidden" name="edit_carricula_id" value="'.$rows_carri['carricula_ID'].'" >

            <div class="form-group">   
              <label for="nationality">Code:</label>
                <input type="text" class="form-control" name="edit_carricula_code" placeholder="Code" value="'.$rows_carri['code'].'">  
            </div>
            <div class="form-group">   
              <label for="nationality">Name:</label>
                <input type="text" class="form-control" name="edit_carricula_name" placeholder="Name" value="'.$rows_carri['name'].'">  
            </div>
             
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editCarruculaBtn" class="btn btn-primary">Edit Carricula</button>
              </div>
              </div>
              

             </form>';
?>
 
