<script>
history.pushState(null, document.title, location.href);
window.addEventListener('popstate', function (event)
{
  history.pushState(null, document.title, location.href);
});
</script>

<?php include("include/session.php");

if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
   header('location: ../../index.php');
}

?>
<!DOCTYPE html>
<html>
<?php include("include/header.php")?>


<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
<?php
  include("include/top_navbar.php");

?>
  
  <script type="text/javascript">
function checkSubject(class_ID){
var details= '&class_ID='+class_ID;
        
$.ajax({
type: "POST",
url: "check_subject.php",
data: details,
cache: false,
success: function(data) {
var sub='<select class="form-control select2"  name="attendance_subject__id"  id="attendance_subject__id" style="width: 100%;" required><option value="All" >All</option>'+ data +'</select>';
 
document.getElementById('subjectDIV').innerHTML=sub;
  //updiv.innerHTML=rsp;
}

});                              
}
</script>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <form  method="POST" action="attendance.php">
              <div class="col-md-3">
                 <div class=" form-group">
                
                  
                  <select class="form-control select2" onchange="checkSubject(this.value)" name="attendance_class__id"  id="attendance_class__id" style="width: 100%;" required>
                    <option value="">--Select class--</option>
                  <?php
                 $query_c= mysqli_query($conn,"select * from class ");
                   while ($crows=mysqli_fetch_array($query_c)){

                          //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$crows['class_ID'].'">'.$crows['name'].'</option>';
                   
                 
                   }
                ?>
                 </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                <div id="subjectDIV">
                  <select class="form-control select2" style="width: 100%;" required >
                    <option value="">--Select Unit---</option>

                  </select>
                </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="searchAttendance">Initiate Roll Call</button>
              </div>
             </form>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
          <?php     
     if (isset($_POST['searchAttendance'])) {
          $classID=$_POST['attendance_class__id'];
          $subjectID=$_POST['attendance_subject__id'];
           $date_created = date('Y-m-d H:i:s');
            $today = date('Y-m-d');
            
            $result021 = mysqli_query($conn,"select * from student where  class_ID='$classID'  ");
            //$result01 = mysqli_query($conn, $query01); 
           while ($row11=mysqli_fetch_array($result021)){
             $student_id=$row11['student_ID'];
              $class_id=$row11['class_ID'];
            $result022 = mysqli_query($conn,"select * from attendance where  class_ID='$class_id' and student_ID='$student_id' and subject_ID='$subjectID' and DATE(date_time)='$today' ");
             $count = mysqli_num_rows($result022);
            
           if (mysqli_num_rows($result022) ==0) {
            
             
             $class_id=$row11['class_ID'];
            $student_id=$row11['student_ID'];
            $student_name=$row11['name'];
            
              $date_created = date('Y-m-d H:i:s');
              $date_modified = date('Y-m-d H:i:s');
              //$school_ID = $_SESSION['login_user_school_ID'];
              $attendance1=mysqli_query($conn,"insert into `attendance` (student_ID,class_ID,subject_ID, date_time, status
              ) 
              values('$student_id','$class_id','$subjectID','$date_created', 'Absent') ")or
                   die(mysqli_error($conn));

              
            if($attendance1){
              echo '<script>alert("initiated")</script>';
            }else{

              echo '<script>alert("Failed")</script>';
            }
          
          
           }else{

             // echo '<script>alert("Already exist")</script>';
            }
           
          
          }
              
          ?>
     <div class="row">
       <div class="col-md-7">
         
       
       <h3>Roll call List</h3>
       <form action="" method="post">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Img</th>
                  <th>Adm No</th>
                  <th>Name</th>
                 
                  
                </tr>
                </thead>
                <tbody>
                  <?php
                  
                  
                     $query2 = mysqli_query($conn,"select * from student where class_ID =' $classID' ")or
                   die(mysqli_error());
                   $x=0;
                   $fp =array();
                   while ($row1=mysqli_fetch_array($query2)){
                    $x ++;
                   $student_regNoID= $row1['adm_no'];
                   #get fingerprint
                  $fp = $row1["name"];
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $fullName=$row1['name'];

                  echo"  <input type='hidden' name='classID[]'' value='".$classID."' />
                  <tr>
                     <td>".$x."</td>
                   
                  <td>".$img."</td>
                  <td>".$row1['adm_no']." <input type='hidden' name='studentID[]'' value='".$row1['student_ID']."' /></td>
                  <td>".$row1['name']."<input type='hidden' name='student_name[]'' value='".$fullName."' /></td>
                 
                
                  </tr>";
                    }
                    
                  
                   
                   
                  ?>
               
               
                 </tbody>
               
              </table>
              
            </form>
            </div>
       <div class="col-md-5"  >
                    <script language="javascript" type="text/javascript">
                      var fg;
                      function checkdbFingerprint(student_ID){
                          var details= '&student_ID='+ student_ID;
                          $.ajax({
                          type: "POST",
                          url: "check_fingerprint.php",
                          data: details,
                          cache: false,
                          success: function(data) {
                          if(data !='failed'){
                         // alert(data); 
                          fg=data;
                          }else{
                          alert("OOp! Could Something went wrong.Please try again!");
                          }

                          }

                          });
                      }

                            var quality = 60; //(1 to 100) (recommanded minimum 55)
                            var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )
                            var flag = 0;

                    // Function used to match fingerprint using jason object 

                    function Match() {
                                // var studentID = document.getElementById('studentID').value;
                                  var claID = document.getElementById('student_fingerprintID').value;
                                alert(claID);
                                if( claID !==""){
                                try {
                                 var studentID = document.getElementById('student_fingerprintID').value;
                                var classID = <?php echo json_encode($classID); ?>;
                                 var subjectID = <?php echo json_encode($subjectID); ?>;

                                  //fingerprint stored as isotemplate
                                  //alert(subjectID +'Subject');
                                   var isotemplate = fg;
                                    alert(isotemplate);
                                    var res = 'true';//MatchFinger(quality, timeout, isotemplate);

                                    if (res =='true') {
                                        if (res =='true') {
                                            alert("Finger matched");
                                            
                                            //variable flag used for authentication 
                                            
                                            flag=1;
                                            var details= '&student_ID='+ studentID +'&class_ID='+classID+'&subject_ID='+subjectID;
                                            $.ajax({
                                            type: "POST",
                                            url: "attendance_singing.php",
                                            data: details,
                                            cache: false,
                                            success: function(data) {
                                            if(data !='failed'){
                                             alert(data); 
                                            fg=data;
                                            }else{
                                              alert(data);
                                            alert("OOp! Could Something went wrong.Please try again!");
                                            }

                                            }

                                            });
                                        }
                                        else {
                                            if (res.data.ErrorCode != "0") {
                                                alert(res.data.ErrorDescription);
                                            }
                                            else {
                                                alert("Finger not matched");
                                            }
                                        }
                                    }
                                    else {
                                        alert(res.err);
                                    }
                                }
                                catch (e) {
                                    alert(e);
                                }
                                return false;
                              }else{
                                alert("select Student");
                              }

                            }

                    //function to redirect to next page upon fingerprint matching

                    function redirect(){

                        
                        if(flag){ 
                        window.location.assign("url"); 
                        }
                        else{
                          alert("Scan Your Finger");
                        }

                      return false;
                    }

                    </script>

               <form method = "post" name="myForm" action="#">
                    
                    <div class="hide">
                      <table>
                        <tr>
                          <td>
                              Base64Encoded ISO Image
                          </td>
                          <td>
                             <textarea id="txtIsoTemplate" style="width: 100%; height:50px;" class="form-control"> </textarea>
                          </td>
                        </tr>
                      </table>
                    </div>
                   
                    
                    <div class="finger_print padd fingerpadd">
                    <div class="row">
                     
                    <div class="col-md-12">
                      <center>
                    <figure>
                    <img src="https://www.larsonjewelers.com/Images/larson-jewelers-fingerprint-engraving-ring.png" alt="finger_print" width="100" height="100">
                    </figure>
                  </center>
                    </div>
                  </div>
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                      <button type="input" onclick="return Match()" class="btn btn-success padd" >start scanning</button>
                    </div>
                    <div class="col-md-8">
                      <select class="form-control select2" name="student_fingerprintID" id="student_fingerprintID" onchange="checkdbFingerprint(this.value)" style="width: 100%;" required>
                   <option value="">--Select Student--</option>
                  <?php
                 $query011= mysqli_query($conn,"select * from student where class_ID =' $classID' ");
                   while ($crow011=mysqli_fetch_array($query011)){

                          //$student_regNoID= $class_rows['class_name'];
                  echo'  <option value="'.$crow011['student_ID'].'">'.$crow011['adm_no'].' '.$crow011['name'].'</option>';
                   
                 
                   }
                ?>
                 </select>
               </div>
                    </div>
                    <br>
                    <br>
                    </div>
                    
                       <br>
                    
                    <div>
                     <!-- <button type="submit" onclick="return redirect()" class="btn btn-primary btn-lg  padd submit_buttom_padding btn-block" value="submit" name="submit">Submit</button>-->
                    </div>
                    

                    
               </form>
       </div>
     </div>
   <?php }?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   
       
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
       
      </div>
      <strong>Copyright &copy; 2019 </strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->


<!-- include script-->
<?php include("include/script.php")?>
</body>
</html>

