 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');

}
include('include/header.php');
?>
<body>
<?php
  $session_id = $_POST['sessionID'];
  $school_ID =$_SESSION['login_user_school_ID'];
  $query_session_details = mysqli_query($conn,"select * from `session` where `session_ID` = '".$session_id ."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_session = mysqli_fetch_array( $query_session_details,MYSQLI_ASSOC);
   #get teacher name
  $carricula_Id=$rows_session['carricula_ID'];
  $carri_Name = mysqli_query($conn,"select name from carricula where school_ID = '$school_ID' and carricula_ID='$carricula_Id' ");
  $carri_Name_row = mysqli_fetch_array($carri_Name,MYSQLI_ASSOC);
   

echo '<form  action="class.php" method="POST">
             <input type="hidden" name="edit_session_id" value="'.$rows_session ['session_ID'].'">
              <div class="form-group">
               
              <select class="form-control " name="edit_session_carricula_id" style="width: 100%;" placeholder="Title eg Term, Session" required >
                    <option value="'.$carricula_Id.'">'.$carri_Name_row['name'].'</option>
                  ';
                 $query3= mysqli_query($conn,"select * from carricula where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($row3=mysqli_fetch_array($query3)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$row3['carricula_ID'].'">'.$row3['name'].'</option>';
                   }
              echo'
                 </select>
               </div>
               <div class="form-group">
                
              <select class="form-control " name="edit_session_title" style="width: 100%;" required>
                  <option value="'.$rows_session['session_title'].'">'.$rows_session['session_title'].'</option>
                  <option value="Tearm">Term</option>
                  <option value="Semester">Semester</option>
                   <option value="Trimester">Trimester</option>
                 </select>
               </div>
                <div class="form-group">
                
              <select class="form-control " name="edit_session_name" style="width: 100%;" required>
                <option value="'.$rows_session['session_name'].'">'.$rows_session['session_name'].'</option>
                 <option value="Term 1">Term 1</option>
                  <option value="Term 2">Term 2</option>
                  <option value="Term 3">Term 3</option>
                  <option value="Session 1">Session 1</option>
                  <option value="Session 2">Session 2</option>
                   <option value="Session 3">Session 3</option>
                 </select>
               </div>
               <div class="form-group">
                <label> Starting Date -Ending Date:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="edit_session_range" id="reservation2" value="'.$rows_session['session_range'].'">
                </div>
                <!-- /.input group -->
              </div>
               
               
           <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editSessionBtn" class="btn btn-primary">Save Changes</button>
              </div>
              </div>
             </form>';

             include('include/script.php');
?>
 </body>
 </html>
