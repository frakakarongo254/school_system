 <?php include("include/session.php");
 if(isset($_POST['class_id'])){
       $class_ID=$_POST['class_id'];
    

    

 echo '

 <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Admin No</th>
                  <th>Gender</th>
                 
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>';
                
                   #get school Id from current session school id
                   $school_ID = $_SESSION['login_user_school_ID'];
                   $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and class_ID='".$class_ID."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                   $status;
                   if($row1['status'] =='Admitted'){
                     $status='Active';
                  
                   }else{
                    $status=$row1['status'];
                   }
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    // encryption function 
  
                  
                  //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  <td><input class='checkbox' type='checkbox' name='check[]'></td>
                  <td><a href='view_student.php?id=".$stdId."'>".$img."</a></td>
                  <td>".$row1['first_Name']." ". $row1['last_Name']."</td>
                  <td>".$row1['registration_No']." </td>
                  <td>".$row1['gender_MFU']."</td>
                   
                  <td>";
               $_SESSION['student_ID']=$row1['student_ID'];#send student id as a session to the next page of view student

                  echo'  <a class="btn btn-success badge " href="view_student.php?id='.$stdId.'"><span class= "glyphicon glyphicon-eye-open"></span></a>

                  <a class="btn btn-info badge" href="edit_students.php?id='.$row1['student_ID'].'"> <span class="glyphicon glyphicon-pencil"></span></a>

                  <button type="button" id="'.$row1['registration_No'].'" class="btn btn-danger badge" value="'.$row1['first_Name'].'" onclick="deleteStudent(this.id,this.value)" data-toggle="modal"  data-target="#delete_student_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                  </td>
                  </tr>';
                    }
                  
               
              echo'  </tbody>
               
              </table>
              ';
            
              }?>