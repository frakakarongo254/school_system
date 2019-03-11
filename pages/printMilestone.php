<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
 $school_ID=$_SESSION['login_user_school_ID'];
 $get_student_ID="";
 $get_milestone_ID="";
 if (isset($_GET['student_ID'])) {
   # code...
  $get_student_ID=$_GET['student_ID'];
  $get_milestone_ID=$_GET['milestone_ID'];
 }
 #get details form invoice
 $sql02 = mysqli_query($conn,"select * from `milestone` where  student_ID='$student_ID' and `school_ID` = '".$school_ID."' LIMIT 1 ");
 $row02 = mysqli_fetch_array($sql02 ,MYSQLI_ASSOC);
 $milestone_ID1=$row02['milestone_ID'];
 $milestone_title1=$row02['title'];
 $effective_date1=$row02['effective_date'];
 $anticipated_date1=$row02['anticipated_date'];
 $milestone_attempt_allowed1 =$row02['attempt_allowed'];
 $milestone_official_desc1=$row02['description'];
 $milestone_status1=$row02['status'];

  #get student details
  $sql03 = mysqli_query($conn,"select * from `student` where  student_ID=' $invoice_student_id' and `school_ID` = '".$school_ID."' ");
  $row03 = mysqli_fetch_array($sql03 ,MYSQLI_ASSOC);
 $studentName=$row03['first_Name'] ." ". $row03['last_Name'];
$studentId=$row03['student_ID'];
$studentRegNo=$row03['registration_No'];
$studentclass_id=$row03['class'];

#get class details
  $sql033 = mysqli_query($conn,"select * from `class` where  class_ID='$studentclass_id' and `school_ID` = '".$school_ID."'  LIMIT 1");
  $row033 = mysqli_fetch_array($sql033 ,MYSQLI_ASSOC);
 $class_name=$row033['name'] ;
  

 
$school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$school_ID."' ");

$school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
$school_row['school_Name'];
$logo;
if($school_row['logo_image'] !=''){
$logo = '<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="90" width="90px" />';
}else{
$logo = "<img class='profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='90px' width='90px'>";
}

 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $school_row['school_Name']?> | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
   <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="page-">
             <table class="table">
          <tr>

          <td class=""><label> Institution</label>     <?php echo $school_row['school_Name'];?></td>

          
          <td class=""><label> Class</label>         <?php echo $class_name;?></td>
         </tr>
          </table> 
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
    <div class="row invoice-info">
       <div class="row">
               <div class="col-xs-12">    
                     
                  <table class=" " style="width: 100%">
                    <tr  rowspan="1">
                      <td> <label>Effective Date:</label><br>
                        <?php echo $effective_date1?></td>
                      <td><label>Milestone title :</label><br>
                                        
                        <?php echo $milestone_title1?>
                      </td>
                      <td> <label>Official description :</label><br>
                      <?php echo $milestone_official_desc1?>
                    </td>
                  </tr>
                  <br>
                  <tr rowspan="1">
                    <td>
                      <label>Anticipated Date:</label><br>
                      <?php echo $anticipated_date1?>
                    </td>
                    <td><label>Attempt Allowed:</label><br>
                    <?php echo $milestone_attempt_allowed1?>
                     </td>
                     <td>
                       <label>Status :</label><br>
                       <?php  echo $milestone_status1 ?>
                     </td>
                    </tr>
                  </table>
                </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
            <th class=""> Milestone level </th>
            <th class=""> Description </th>
            <th class=""> Formal Description </th>
            </tr>
            </thead>
            <tbody>
         
 <?php


         $query2 = mysqli_query($conn,"select * from milestone_levels where milestone_ID='$get_milestone_ID' and school_ID = '$school_ID' ")or
         die(mysqli_error());
         while ($row2=mysqli_fetch_array($query2)){
         $milestone_level_ID= $row2['milestone_level_ID'];
         $milestoneID= $row2['milestone_ID'];
         

        echo'<tr >
          
          <td>'.$row2['milestone_level'].'
          
          </td>
          <td>'.$row2['description'].'
          
          </td>
          <td>'.$row2['formal_description'].'
         
          </td>
         
        
        </tr>';

         }


        ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

     
      <!-- /.row -->

      <!-- this row will not appear when printing -->
     
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
