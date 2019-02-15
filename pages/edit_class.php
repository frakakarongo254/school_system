 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $class_id = $_POST['class_id'];
  $school_ID =$_SESSION['login_user_school_ID'];
  $query_class_details = mysqli_query($conn,"select * from `class` where `class_ID` = '".$class_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_class = mysqli_fetch_array( $query_class_details,MYSQLI_ASSOC);
   #get teacher name
  $teacherId=$rows_class['teacher_ID'];
  $teacher_Name = mysqli_query($conn,"select full_Name from staff where school_ID = '$school_ID' and staff_ID='$teacherId' ");
  $teacher_Name_row = mysqli_fetch_array($teacher_Name,MYSQLI_ASSOC);
   #get level name
  $levelId=$rows_class['level_ID'];
  $level_Name = mysqli_query($conn,"select level_name from carricula_level where school_ID = '$school_ID' and carricula_level_ID='$levelId' ");
  $level_Name_row = mysqli_fetch_array($level_Name,MYSQLI_ASSOC);
   #get stream name
  $streamId=$rows_class['stream_ID'];
  $stream_Name = mysqli_query($conn,"select stream_name from stream where school_ID = '$school_ID' and stream_ID='$streamId' ");
 $stream_Name_row = mysqli_fetch_array($stream_Name,MYSQLI_ASSOC);

echo '<form  action="class.php" method="POST">
          <input type="hidden" name="edit_class_id" value="'.$class_id.'">
            <div class="form-group">
              <label>Year</label>
            <select class="form-control select2" name="edit_class_year" style="width: 100%;" required>>
            <option value="'.$rows_class['year'].'">'.$rows_class['year'].'</option>
                ';
                  $year = date('Y');
                  $min = $year - 60;
                  $max = $year;
                  for( $i=$max; $i>=$min; $i-- ) {
                    echo '<option value='.$i.'>'.$i.'</option>';
                  }
                
            echo'  </select>
            </div>
              <div class="form-group">
                <label>Level</label>
              <select class="form-control select2" name="edit_class_level_id" style="width: 100%;" required>
                    <option value="'.$levelId.'">'.$level_Name_row['level_name'].'</option>
                  ';
                 $query_level2= mysqli_query($conn,"select * from carricula_level where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($level2_rows=mysqli_fetch_array($query_level2)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$level2_rows['carricula_level_ID'].'">'.$level2_rows['level_name'].'</option>';
                   }
                
             echo'    </select>
               </div>
               <div class="form-group">
                <label>Stream</label>
              <select class="form-control select2" name="edit_class_stream_id" style="width: 100%;" required>
                    <option value="'.$streamId.'">'.$stream_Name_row['stream_name'].'</option>';
                  
                 $query_stream2= mysqli_query($conn,"select * from stream where school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($stream2_rows=mysqli_fetch_array($query_stream2)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$stream2_rows['stream_ID'].'">'.$stream2_rows['stream_name'].'</option>';
                   }
                echo'
                 </select>
               </div>
                <div class="form-group">
                <label>Teacher</label>
              <select class="form-control select2" name="edit_class_teacher_id" style="width: 100%;" required>
                    <option value="'.$teacherId.'">'.$teacher_Name_row['full_Name'].'</option>';
                  
                 $query_staff_Teacher= mysqli_query($conn,"select * from staff where role='Teacher' and school_ID = '".$_SESSION['login_user_school_ID']."'")or
                   die(mysqli_error());
                   while ($teacher_rows=mysqli_fetch_array($query_staff_Teacher)){
                    //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$teacher_rows['staff_ID'].'">'.$teacher_rows['full_Name'].'</option>';
                   }
                
                echo' </select>
               </div>
           <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editClassBtn" class="btn btn-primary">Edit Class</button>
              </div>
              </div>
             </form>';
?>
 
