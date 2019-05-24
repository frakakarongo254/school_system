<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
$school_ID=$_SESSION['login_user_school_ID'];
$student_ID="";
if(isset($_GET['id'])){
  $student_ID =$_GET['id'];
}
$login_parent_ID=$_SESSION['login_user_ID'];
$login_parent_email=$_SESSION['login_user_email'];

 #get mile stone details from db
$sql02 = mysqli_query($conn,"select * from `milestone` where  student_ID='$student_ID' and `school_ID` = '".$school_ID."' LIMIT 1 ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $milestone_ID1=$row02['milestone_ID'];
 $milestone_title1=$row02['title'];
 $effective_date1=$row02['effective_date'];
 $anticipated_date1=$row02['anticipated_date'];
 $milestone_attempt_allowed1 =$row02['attempt_allowed'];
 $milestone_official_desc1=$row02['description'];
 $milestone_status1=$row02['status'];
?>

<?php include("include/header.php")?>

<body class="hold-transition skin-cadetblue layout-top-nav">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
 // include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:  whitesmoke;">
    <div class="container">
    <!-- Content Header (Page header) -->
   
    <section class="content-header">
      <h1>
         <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>
       
        <li class="active">Student Details</li>
      </ol>
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content ">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
         <div class="col-md-12 ">
         
          <?php
          $user_ID=$_SESSION['login_user_ID'];
            $ses_sql = mysqli_query($conn,"select * from `student` where `student_ID` = '".$student_ID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
              $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
              $student_name=$row['first_Name'] ." ". $row['last_Name'];
              $student_RegNo=$row['registration_No'];
               $image;
             if($row['photo'] !=''){
              $image = '<img class=" profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"  height="40px" width="40px" alt="User profile picture"/>';
            }else{
                $image = "<img class=' profile-user-img img-responsive img-circle' src='../../dist/img/avatar.png' alt='User profile picture'>";
              }
          ?>
          <!-- Profile Image -->
          <section>
             
          </section>
          <div class="box box-primary " id="viewParentStdInfo">
            <div class="box-body box-profile">
              <div class="row">
                <div class="col-md-3 ">
                  <div class="pull-left">
                   
                   <?php echo $image;?>

              
            </div>
                </div>
                <div class="col-md-4 table-responsive">
                  <table>
                    <tr>
                    <td><span id="viewCss">Name:</span></td>
                    <td><h3 class="profile-username "><b><?php echo $row['first_Name'] ." ". $row['last_Name'];?></b></h3></td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Adm:</span></td>
                    <td><b><?php echo $row['registration_No']?></b></td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Gender:</span></td>
                    <td><b><?php echo $row['gender_MFU']?></b></td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Nationality:</span></td>
                    <td><b><?php echo $row['nationality']?></b></td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Date of Birth:</span></td>
                    <td><b><?php  $date=$row['date_of_Birth']; echo date("d-m-Y", strtotime($date))?></b></td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Admission Date:</span></td>
                    <td><b><?php $ad_date=$row['admission_date']; echo date("d-m-Y", strtotime($ad_date))?></b></td>
                  </tr>
                 </table>
                </div>
                <div class="col-md-4">
                  <table>
                    
                  <tr>
                    <td><span id="viewCss">Total invoiced:  </span></td>
                    <td align="right">


                      <?php
                       $query2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               $total_invoiced=0.00;
                               while ($row011=mysqli_fetch_array($query2)){
                                        $total_invoiced= $total_invoiced + $row011['amount'];
                               }
                             
                               echo  $school_row['currency'] . ' <b>  '.formatCurrency($total_invoiced).'</b>';
                               ?>

                    </td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Amount Paid:</span></td>
                    <td align="right">
                      <?php
                       $query2 = mysqli_query($conn,"select * from payment where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               $total_amount_paid=0.00;
                               while ($row011=mysqli_fetch_array($query2)){
                                         $total_amount_paid=  $total_amount_paid + $row011['amount_paid'];
                               }
                             
                               echo  $school_row['currency'] . ' <b>  '.formatCurrency($total_amount_paid).'</b>';
                               ?>
                    </td>
                  </tr>
                  <tr>
                    <td><span id="viewCss">Balance:</span></td>
                    <td align="right">
                    <?php  $bal= $total_invoiced - $total_amount_paid; 
                     echo  $school_row['currency'] . ' <b>  '.formatCurrency($bal).'</b>';

                      ?>
                    </td>
                  </tr>
                  
                 </table>
                </div>
              </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <h3><b></b></h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" id="tab">Student Classes</a></li>
                  
                  <li><a href="#tab_3" data-toggle="tab"  id="tab">Documents</a></li>
                   <li><a href="#tab_4" data-toggle="tab"  id="tab">Student Statement</a></li>
                    <li><a href="#tab_5" data-toggle="tab"  id="tab">Milestone</a></li>
                    <li><a href="#tab_6" data-toggle="tab"  id="tab">Attendance</a></li>
                       
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active " id="tab_1">
                      <div id="table-responsive">
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                             
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                            $ses_sql2 = mysqli_query($conn,"select * from `student` where `student_ID` = '".$student_ID."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row2 = mysqli_fetch_array($ses_sql2,MYSQLI_ASSOC);
                            $classid=$row2['class_ID'];
                              $class_sql2 = mysqli_query($conn,"select * from `class` where `class_ID` = '".$classid."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row3_class = mysqli_fetch_array($class_sql2 ,MYSQLI_ASSOC);

                               $levelId=$row3_class['level_ID'];
                                $streamid=$row3_class['stream_ID'];

                              $level_sql2 = mysqli_query($conn,"select * from `carricula_level` where `carricula_level_ID` = '".$levelId."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row4_level = mysqli_fetch_array($level_sql2 ,MYSQLI_ASSOC);
                             // $streamid=$row4_level['stream_ID'];

                             $stream_sql2 = mysqli_query($conn,"select * from `stream` where `stream_ID` = '".$streamid."' && `school_ID` = '".$_SESSION['login_user_school_ID']."'");
                            $row4_stream = mysqli_fetch_array($stream_sql2 ,MYSQLI_ASSOC);
                               
                                echo" <tr>
                                       
                                        <td>".$row3_class['year']."</td>
                                        <td>".$row3_class['name']." </td>
                                         <td>".$row4_stream['stream_name']." </td>
                                        
                                     </tr>";

                               
                              
                           ?>
                           
                             </tbody>
                            <tfoot>
                            <tr>
                             <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                             
                            </tr>
                            </tfoot>
                          </table>
                        </div>
                    </div>
                    
                     <div class="tab-pane " id="tab_3">
                      <div class="row">
              <div class="col-md-8"><b><h3>Documents</h3> </b></div>
              
            </div>
              <div class="table-responsive">
                      <table id="example3" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>Document Title</th>
                              <th>Description</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                              
                               #get school Id from current session school id
                               $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from document where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               $x=0;
                               while ($row1=mysqli_fetch_array($query2)){
                                
                                $x++;
                               $documentID= $row1['document_ID'];  
                              $document_name= $row1['file_name']; 
                                echo" <tr>
                                      <td>".$x."</td>
                                        <td>".$row1['title']."</td>
                                        <td>".$row1['description']." </td>
                                         
                                          
                                        <td>";
                                       echo'  
                                       <button type="button"  class="btn btn-info btn-xs" id="'.$documentID.'" onclick="editDocument(this.id)" data-toggle="modal" data-target="#modal-editDocument"><span class="glyphicon glyphicon-pencil"></span> Edit</button>

                                        <a href="#"><button type="button"  class="btn btn-xs btn-success btn-flat" id="'.$document_name.'" onclick="openDocument(this.id)" data-toggle="modal" data-target="#open_document_Modal"><span class= "glyphicon glyphicon-eye-open"> </span> view </button></a>

                                         <button type="button"  class="btn btn-xs btn-danger " id="'.$documentID.'" onclick="deleteDocument(this.id)" data-toggle="modal" data-target="#delete_document_Modal"><span class="glyphicon glyphicon-trash"></span> Delete</button>

                                        
                                       </td>
                                     </tr>';

                                }
                              ?>
                           
                             </tbody>
                            <tfoot>
                            <tr>
                             <th>#</th>
                              <th>Document Title</th>
                              <th>Description</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab_4">
                      <div class="col-md-8"><b><h3>Statement</h3> </b></div>
                      <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary button1" href="#" id="<?php echo  $student_ID;?>"onclick="printSatement(this.id)"  data-toggle="modal" data-target="#print_statement_Modal"><i class="fa fa-print"></i><b> Print Statement</b></a></div>
                      <div id="table-responsive">
                         <table id="table11" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                              <th>Date</th>
                              <th>Description</th>
                              <th>Reference</th>
                              <th>Debit</th>
                              <th>Credit</th>
                              
                              
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                              $result = mysqli_query($conn,"select * from statement where school_ID = '".$school_ID."' && student_ID='".$student_ID."'")or
                               die(mysqli_error());
                        $total_Debit=0.00;
                        $total_Credit=0.00;
                        $total_balance=0.00;
                        while($rows = $result->fetch_assoc()) {
                        $total_Debit= $total_Debit + $rows["Debit"];
                        $total_Credit=$total_Credit + $rows["Credit"];
                        $total_balance=$total_Debit - $total_Credit;
                        $date_created= $rows['date_created'];
                        $newDate = date("d-m-Y", strtotime($date_created));
                       
                        echo '<tr>
                       
                        <td> '.$newDate.'</td>
                        <td> '.$rows["description"].'</td>
                        <td> '.$rows["ref_no"].'</td>
                        <td align="right"> '.$school_row['currency'] . '   '.formatCurrency($rows["Debit"]).'</td>
                        <td align="right"> '.$school_row['currency'] . '   '.formatCurrency($rows["Credit"]).'</td>
                        </tr>';
                        }    

                        echo'
                        <tr>
                        <hr>
                        <td colspan="3"><b><b></td>
                         <td align="right"><b>'.$school_row['currency'] . '   '.formatCurrency($total_Debit).'</b></td>
                         <td align="right"><b>'.$school_row['currency'] . '   '.formatCurrency($total_Credit).'</b></td>
                         
                        </tr>
                       
                        '

                              ?>
                           
                             </tbody>
                            
                          </table>

                        <div class="row clearfix" style="margin-top:20px">
                        <div class="pull-right col-md-3">
                          <table class="table">
                              <tr>
                <th style="width:50%">Balance</th>
                <td><?php echo'<b>'.$school_row['currency'] . '   '.formatCurrency($total_balance).' </b>';?></td>
              </tr>
             
             
                          </table>
                        </div>
                        </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab_5">
                          
                         <div class="col-md- col-pull-right" style="text-align:right"><a class="btn btn-primary button1" href="#" id="<?php echo  $student_ID;?>"onclick="printSatement(this.id)"  data-toggle="modal" data-target="#print_statement_Modal"><i class="fa fa-print"></i><b> Print Statement</b></a></div>
                         <div id="milestone_print">
                          <div id="table-responsive">
                                <table id="table" class="table " style="width: 100%">
                                  <tr>
                                    <td><label>STUDENT NAME:</label>
                                      <?php echo  $student_name?>
                                    </td>
                                     <td><label>ADM NO:</label>
                                      <?php echo  $student_RegNo?>
                                    </td>
                                  </tr>
                                </table>

                                <table id="table1" class="table " style="width: 100%">
                                  <tr>
                                    <td>
                                       <label>Effective Date:</label><br>
                                      <?php echo $effective_date1?>
                                    </td>
                                   <td>
                                      <label>Milestone title :</label><br>
                                      <?php echo $milestone_title1?>
                                   </td>
                                   <td>
                                       <label>Official description :</label><br>
                                       <?php echo $milestone_official_desc1?>
                                   </td>
                                </tr>
                                <tr>
                                  <td>
                                     <label>Anticipated Date:</label><br>
                                     <?php echo $milestone_title1?>
                                  </td>
                                  <td>
                                    <label>Attempt Allowed:</label><br>
                                    <?php echo $milestone_attempt_allowed1?> 
                                  </td>
                                  <td>
                                     <label>Status :</label><br>
                                     <?php  echo $milestone_status1 ?>
                                  </td>
                                </tr>
                                </table>


                                <table class="table table-bordered " id="" style="width: 100%">
                                                  <thead>
                                                    <tr>
                                                      
                                                      <th class=""> Milestone level </th>
                                                      <th class=""> Description </th>
                                                      <th class=""> Formal Description </th>
                                                      
                                                    </tr>
                                                  </thead>
                                                    <tbody>
                                                        <?php
                                                     
                                                      
                                                       $query2 = mysqli_query($conn,"select * from milestone_levels where milestone_ID='$milestone_ID1' and school_ID = '$school_ID' ")or
                                                       die(mysqli_error());
                                                       while ($row2=mysqli_fetch_array($query2)){
                                                       $milestone_level_ID= $row2['milestone_level_ID'];
                                                       $milestoneID= $row2['milestone_ID'];
                                                       
                                                      
                                                   echo'<tr >
                                                        
                                                        <td>'.$row2['milestone_level'].'
                                                        
                                                        </td>
                                                        <td>
                                                        '.$row2['description'].'
                                                        
                                                        </td>
                                                        <td>
                                                        '.$row2['formal_description'].'
                                                        
                                                        </td>
                                                       
                                                    </tr>';

                                                       }
                                                      
                                                    
                                                      ?>
                                                    
                                                  </tbody>
                                                </table>  
                                              </div>

                            </div>
                            </div>
                             <div class="tab-pane " id="tab_6">
                               <div class="row">
               
              <form method="POST" action="view_children.php">
               <div class="col-md-3">
                  
               </div>
               <?php $currentTimeinSeconds = time(); 
          $currentDate = date('F d Y', $currentTimeinSeconds);
          $time =date("h:i:sa"); ?>
              <div class="col-md-3 pull-" style="text-align:">
                
                 <input type="text" name="attendance_date" class="form-control pull-right" id="datepicker" value="<?php echo $currentDate?>" >
              </div>
              <div class="col-md-3 col-" style="text-align:">
                <button class="btn btn-primary" id="button1" type="submit" name="searchAttendance" href="" ><i class="fa fa-filter"></i> filter Attendance</button>
              </div>
              <div class="col-md-3 col-" style="text-align:t">
                
                
              </div>
            </form>
            </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Sudent Name</th>
                  <th>Sign-in Time</th>
                  <th>Signed In By</th>
                  <th>Signed Out Time</th>
                   <th>Signed Out By</th>
                  <th>Attended time</th>
                  
                </tr>
                </thead>
                <tbody>
               <?php
                if (isset($_POST['searchAttendance'])) {
                   $school_ID = $_SESSION['login_user_school_ID'];
                  $attndDate=$_POST['attendance_date'];
                $attendanceDate= date("Y-m-d", strtotime($attndDate));
                 
                 // $attendance_class_id=$_POST['attendance_class_id'];
                 
               
                 
                   
                   $query22 = mysqli_query($conn,"select * from attendance where school_ID = '".$school_ID."'  and date_entered='".$attendanceDate."' and student_ID='".$student_ID."'  ")or
                   die(mysqli_error());
                    while ($row11=mysqli_fetch_array($query22)){
                     $student_id=$row11['student_ID'];
                      $attendance_ID=$row11['attendance_ID'];
                     $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and student_ID='".$student_id."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                  
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                    $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row11['sign_in_time'];
                 $time_out=$row11['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff= $duration->format("%H:%I:%S");
              // encryption function 

              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'><a href='view_student.php?id=".$stdId."'>".$img." ".$name."</a></td>
                  <td>".$row11['sign_in_time']."</td>
                  <td>".$row11['signed_in_by']." </td>
                  <td>".$row11['sign_out_time']."</td>
                   <td>".$row11['signed_out_by']."</td>
                   <td>".$diff."</td>
                    <td>";
             
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }
                  }else{
                    
                $attendanceDate= date("Y-m-d");
                    $query22 = mysqli_query($conn,"select * from attendance where school_ID = '".$school_ID."' and student_ID='".$student_ID."' ")or
                   die(mysqli_error());
                    while ($row11=mysqli_fetch_array($query22)){
                     $student_id=$row11['student_ID'];
                      $attendance_ID=$row11['attendance_ID'];
                     $query2 = mysqli_query($conn,"select * from student where school_ID = '".$school_ID."' and student_ID='".$student_id."'")or
                   die(mysqli_error());
                   while ($row1=mysqli_fetch_array($query2)){
                   $student_regNoID= $row1['registration_No'];
                   
                   $img;
                   if($row1['photo'] !=''){
                     $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row1['photo'] ).'"  height="40px" width="40px" />';
                  }else{
                      $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                      
                    }
                    $stdId=$row1['student_ID'];
                    $class_Id=$row1['class_ID'];
                   $name= $row1['first_Name']." ". $row1['last_Name'];
                   $time_in=$row11['sign_in_time'];
                 $time_out=$row11['sign_out_time'];

                   $startTime = new DateTime($time_in);
                   $endTime = new DateTime($time_out);
                   $duration = $startTime->diff($endTime); //$duration is a DateInterval object
                   $diff= $duration->format("%H:%I:%S");
              // encryption function 

              
                //$id =  base64_url_encode($stdId);
                  echo" <tr>
                  
                  <td><input type='hidden' value='".$class_Id."' name='classId[]'><a href='view_student.php?id=".$stdId."'>".$img." ".$name."</a></td>
                  <td>".$row11['sign_in_time']."</td>
                  <td>".$row11['signed_in_by']." </td>
                  <td>".$row11['sign_out_time']."</td>
                   <td>".$row11['signed_out_by']."</td>
                   <td>".$diff."</td>
                   
                  ";
                  
              #send student id as a session to the next page of view student

                   
                 echo' </tr>';
                    }
                  }
                
                  }
                
                
               ?>
     
       </tbody>
               
             </table>
       
       
                             </div>
                          </div>
                    </div>
                   
                </div>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
   <!--- add document Modal -->
 
   <!-- open document  Modal-->
    <div class="modal  fade" id="open_document_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Document</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
    <div id="dialog" style="display:">
    
</div> 
            <script >
          function openDocument(document_name){
            
            document.getElementById("dialog").innerHTML='<iframe src="document/'+document_name+'" style="width:100%;height:800px"></iframe>';
          }
  
            </script>
            <div id="documMsg"></div>
          
          

        </div>
          <div class="modal-footer">
           <div id="Msg"></div>
        </div>
      </div>
    </div>
     </div>


      <!-- open Print statement-->
    <div class="modal  fade" id="print_milestone_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Student Milestone</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
     <iframe id="printM" name="printM" style="width: 100%;height:600px;">

    </iframe>
            <script >
         function printMilestone(id) {
          var data=document.getElementById("milestone_print").outerHTML;
         
            var newWin = window.frames["printM"];
        newWin.document.write('<body onload="window.print()">'+data+'</body>');
        newWin.document.close();
         
        } 
  
            </script>
          
          
          

        </div>
          
      </div>
    </div>
     </div>

  <!-- open Print statement-->
    <div class="modal  fade" id="print_statement_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Print statement</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
     <iframe id="print_Statement" name="print_Statement" style="width: 100%;height: 600px;">

    </iframe>
            <script >
         function printSatement(id) {
         
         var details= '&student_id='+ id;
          $.ajax({
          type: "POST",
          url: "print_statement.php",
          data: details,
          cache: false,
          success: function(data) {

            //window.location='view_student.php?id=<?php// echo $student_ID ?>' ;
           
        var newWin = window.frames["print_Statement"];
        newWin.document.write('<body onload="window.print()">'+data+'</body>');
        newWin.document.close();

          }


          });
        } 
  
            </script>
          
          
          

        </div>
          
      </div>
    </div>
     </div>

    </section>
    <!-- /.content -->
  </div>
  </div>
  <!-- /.content-wrapper -->
<!--include footer-->
<?php
 include('include/footer.php');
 ?>
<!--include settings-sidebar-->
 
 <?php
 include('include/settings-sidebar.php');
 ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
  
<!-- ./wrapper -->


<!-- include script-->
<?php include("include/script.php")?>

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

  $(function () {
    $('#example3').DataTable()
    $('#example4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $(function () {
    $('#table1').DataTable()
    $('#table2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $(function () {
    $('#table11').DataTable()
    $('#table21').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>

</body>
</html>
