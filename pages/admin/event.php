<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../index.php');
}
 #get school Id from current session school id
 $school_ID = $_SESSION['login_user_school_ID'];

if(isset($_POST["Export"])){
     //echo "yes";
    // $filename = "members_" . date('Y-m-d') . ".csv";
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Title','Location','Starting Date','Starting Time','Ending Date','Ending Time','Event Type','Description','Event For'));  
      $queryz = "SELECT event_title,event_location,event_startDate,event_startime,event_endDate,event_endtime,
      event_type,event_description,event_for from event where school_ID='".$school_ID."' ORDER BY event_ID DESC LIMIT 1" ;  
      $resultz = mysqli_query($conn, $queryz);  
      
      while($rowz = mysqli_fetch_assoc($resultz))  
      {  
         
           fputcsv($output, $rowz);  
      }  
      fclose($output);  
      //return ob_get_clean();
    exit();
 }  
?>
<?php


 if(isset($_POST["importBtn"])){
    
    $filename=$_FILES["importFile"]["tmp_name"];    


     if($_FILES["importFile"]["size"] > 0)
     {
        $file = fopen($filename, "r");
        $count = 0;
         $x=0;
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {

             $count++; 
            if($count>1)
            { 
                
            
            $x++;
              $randstd = substr(number_format(time() * rand(),0,'',''),0,10 + $x);
              $event_ID=md5($randstd);
              $title = mysqli_real_escape_string($conn,$getData[0]);
              $location = mysqli_real_escape_string($conn,$getData[1]);
              $startDate = mysqli_real_escape_string($conn,$getData[2]);
              $startTime = mysqli_real_escape_string($conn,$getData[3]);
              $endDate = mysqli_real_escape_string($conn,$getData[4]);
              $endTime = mysqli_real_escape_string($conn,$getData[5]);
               $Type = mysqli_real_escape_string($conn,$getData[6]);
              $Desc = mysqli_real_escape_string($conn,$getData[7]);
              $eventFor = mysqli_real_escape_string($conn,$getData[8]);
            

               $color = '#000000';
               $eventStart_date= date("Y-m-d", strtotime($startDate));
              $eventEnd_date= date("Y-m-d", strtotime($endDate));

                        
             $sql = "INSERT into event (school_ID, event_title,event_location,event_startDate,event_startime,event_endDate,event_endtime,event_description,event_color,event_for,event_type
          ) 
                   values ('".$school_ID."','".$title."','".$location."','".$eventStart_date."','".$startTime."','".$eventEnd_date."','".$endTime."','".$Desc."','".$color."','".$eventFor."','".$Type."')";
                   $result = mysqli_query($conn, $sql);


        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"event.php\"
              </script>"; 
              //mysql_error()  
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"event.php\"
          </script>";
        }
           }
         }
      
           fclose($file); 
     }
  }  


 ?>

<?php include("include/header.php")?>

<body class="hold-transition skin-cadetblue sidebar-mini">
<div class="wrapper">
<!--include header-->

<?php
  include("include/top_navbar.php");

?>
<!--include sidebar after header-->
<?php
  include("include/sidebar.php");

?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding-left:30px;padding-right:30px;">
    <!-- Content Header (Page header) -->
   
 <section class="content-header">
      
        
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Event added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Event updated  successfully.
          </div>';   
        }
        if(isset($_GET['event'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Event was sent  successfully.
          </div>';   
        }
        if(isset($_GET['delete'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! You have deleted  successfully.
          </div>';   
        }
        //Add event
       if(isset($_POST['addEventBtn'])){
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $event_title=$_POST['event_title'];
        $event_location=$_POST['event_location'];
        $event_startDate=$_POST['event_startDate'];
        $event_startime=$_POST['event_startime'];
        $event_endDate=$_POST['event_endDate'];
        $event_endtime=$_POST['event_endtime'];
        $event_description=$_POST['event_description'];
        $event_color=$_POST['event_color'];
        $event_for=$_POST['event_for'];
        $event_insert_query=mysqli_query($conn,"insert into `event` (school_ID, event_title,event_location,event_startDate,event_startime,event_endDate,event_endtime,event_description,event_color,event_for,event_type
          ) 
          values('$school_ID','$event_title','$event_location','$event_startDate','$event_startime','$event_endDate','$event_endtime','$event_description','$event_color','$event_for','Normal') ");
        if($event_insert_query){
           echo '<script> window.location="event.php?insert=True" </script>';
          
       }else{
       echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
       }
      }
      
      #Edit event
       if(isset($_POST['editEventBtn'])){
          #get school Id from current session school id
        $school_ID = $_SESSION['login_user_school_ID'];
        $edit_event_ID=$_POST['edit_event_id'];
        $edit_event_title=$_POST['edit_event_title'];
        $edit_event_location=$_POST['edit_event_location'];
        $edit_event_startime=$_POST['edit_event_startime'];
        $edit_event_startDate=$_POST['edit_event_startDate'];
        $edit_event_endDate=$_POST['edit_event_endDate'];
         $edit_event_endtime=$_POST['edit_event_endtime'];
        $edit_event_description=$_POST['edit_event_description'];
        $edit_event_color=$_POST['edit_event_color'];
        $edit_event_for=$_POST['edit_event_for'];

        $update_udate_query=mysqli_query($conn,"update `event` SET event_title= '".$edit_event_title."', event_location= '".$edit_event_location."',event_startDate='".$edit_event_startDate."',event_startime= '".$edit_event_startime."',event_endDate='".$edit_event_endDate."',event_endtime= '".$edit_event_endtime."' ,event_description= '".$edit_event_description."',event_color= '".$edit_event_color."',event_for='".$edit_event_for."' where `event_ID`='".$edit_event_ID."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");

        if($update_udate_query){
           echo '<script> window.location="event.php?update=True" </script>';
          
       }else{
       echo' <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">
        &times;
        </button>
        Sorry! Something went wrong.Please try again.
        </div>'; 
       }
      }
      #print event
      if (isset($_POST['printEventBtn'])) {
        $start=$_POST['printFromDate'];
       $to= $_POST['printToDate'];
       $type=$_POST['print_event_type'];
       if ($type =="Birthday") {
        ?>
        <div id="printEventDiv" class="hidden">
          <div style="font-size: 20px;">Event list for the period starting <b>From: <?php echo date("d-m-Y", strtotime($start)) . "  To  " . date("d-m-Y", strtotime($to)) ?></b> </div>
         <table id="example134" class=" " style="width:100%">
            <thead>
                <tr>
                  <th class="pull-left">Title</th>
                  <th class="pull-left">Location</th>
                  <th class="pull-left">Date</th>
                  <th class="pull-left">Description</th>
                
                  
                </tr>
                </thead>
                <tbody>
            <?php
           
            $event_query = mysqli_query($conn,"select * from event where date(event_startDate) between date('$start') and date('$to') and school_ID = '$school_ID' and event_type='Birthday' ORDER BY event_startDate DESC")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            echo' <tr>

              <td >'.
             $event_row['event_title'].'
             </td>
            <td>'.$event_row["event_location"].'</td>
            <td>'.$event_startDate.'</td>
            
            <td>'.$event_row["event_description"].'</td>
           
                   
            </tr>';
            }
            ?>
          </tbody>
               
              </table>
            </div>
            <script type="text/javascript">
              $( "#print_event_modal" ).on('shown', function(){
    alert("I want this to appear after the modal has opened!");
});
            </script>
        <?php
         
       }else{
         ?>
        <div id="printEventDiv" class="hidden">
          <div>Even<div style="font-size: 20px;">Event list for the period starting <b>From: <?php echo date("d-m-Y", strtotime($start)) . "  To  " . date("d-m-Y", strtotime($to)) ?></b> </div>
         <table id="example134" class=" " style="width:100%">
            <thead>
                <tr>
                  <th class="pull-left">Title</th>
                  <th class="pull-left">Location</th>
                  <th class="pull-left">Starting Date</th>
                   <th class="pull-left">Starting Time</th>
                   <th class="pull-left">Ending Date</th>
                   <th class="pull-left">Ending Time</th>  
                  <th class="pull-left">Description</th>
                
                  
                </tr>
                </thead>
                <tbody>
            <?php
           
            $event_query = mysqli_query($conn,"select * from event where date(event_startDate) between date('$start') and date('$to') and school_ID = '$school_ID' ORDER BY event_startDate DESC")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            echo' <tr>

              <td >'.
             $event_row['event_title'].'
             </td>
            <td>'.$event_row["event_location"].'</td>
            <td>'.$event_startDate.'</td>
             <td>'.$event_starttime.'</td>
              <td>'.$event_endDate.'</td>
               <td>'.$endtime.'</td>
            <td>'.$event_row["event_description"].'</td>
           
                   
            </tr>';
            }
            ?>
          </tbody>
               
              </table>
            </div>
            <script type="text/javascript">
              $( "#print_event_modal" ).on('shown', function(){
    //alert("I want this to appear after the modal has opened!");
});
            </script>
        <?php
         

       }
      }
      ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row ">
        
        <div class="col-md-12" style="">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-6 col-xs-12">
                
              </div>
               <div class="col-md-2 col-xs-12">
                
                <form action="" method="POST">
                  <button type="submit" class="btn" id="button1" style="color:#fff" name="Export" onclick="">Export</button>

                </form>
              </div>
              <div class="col-md-2 col-xs-12">
                
                <button href="#" class="btn" id="button1" style="color:#fff" data-toggle="modal" data-target="#modal-importStudent">Import</button>
              </div>
              <div class="col-md-2 col-xs-12" style=""><a class="btn btn-primary pull-" href="login.html" id="button1" data-toggle="modal" data-target="#modal-addEvent"><i class="fa fa-plus"></i><b> New Event</b></a></div>
            </div>
            </div>
            
            
            <!-- /.box-header -->
            <div class="box-body">
              
                <div id="calendar">calender</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      
      </div>
      <div class="row ">
          <div class="col-md-12 "  style="">
           
         <div class="box box-default collapsed-box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b>View Events</b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
              
              <div class="col-md-12 pull- " style=""><a class="btn btn-primary pull-right" href="" id="button1" data-toggle="modal" data-target="#modal-printEvent"><i class="fa fa-print"></i><b> Print Event</b></a></div>
            </div>
            <br>
              <table id="example2" class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                  <th>Title</th>
                  <th>Location</th>
                  <th>Starting Date</th>
          <th>Starting  time</th>
                  <th>Ending Date </th>
          <th>Ending time</th>
                  <th>Description</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
            <?php
          
            $event_query = mysqli_query($conn,"select * from event where school_ID = '$school_ID' ORDER BY date(event_startDate) DESC")or
            die(mysqli_error());
            while ($event_row=mysqli_fetch_array($event_query)){
             $eventID=$event_row['event_ID'];
             $start=$event_row["event_startDate"];
              $event_startDate = date("d-m-Y", strtotime($start));
              $event_starttime = $event_row['event_startime'];
              $end=$event_row["event_endDate"];
              $event_endDate= date("d-m-Y", strtotime($end));
              $endtime=$event_row["event_endtime"];
            echo' <tr>

              <td ><span class="hidden">'.date("Y/m/d", strtotime($start)).'</span>'.
             $event_row['event_title'].'
             </td>
            <td>'.$event_row["event_location"].'</td>
            <td>'.$event_startDate.'</td>
      <td>'.$event_starttime.'</td>
            <td>'.$event_endDate.'</td>
       <td>'.$endtime.'</td>
            <td>'.$event_row["event_description"].'</td>
            <td>
            <a data-toggle="modal" data-target="#view_event_Modal" href="#" id="'.$eventID.'" onclick="sendEventFunc(this.id)"><span class="pull- badge bg-success btn-success"><i class="fa fa-envelope-open"></i> </span></a>
            <a data-toggle="modal" data-target="#edit_event_Modal" href="#" id="'.$eventID.'" onclick="editEventFunc(this.id)"><span class="pull- badge bg-secondary"><i class="fa fa-pencil"></i> </span></a>
            <a data-toggle="modal" data-target="#delete_event_Modal" href="#" id="'.$eventID.'" onclick="deleteEventFunc(this.id)"><span class="pull- badge bg-danger btn-danger"><i class="fa fa-trash"></i> </span></a>
            </td>
                   
            </tr>';
            }
            ?>
          </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		 </div>
     
	 </div>
    <!--- add Event Modal -->
      <div class="modal fade" id="modal-addEvent">
          <div class="modal-dialog modal-md">
            <div class="modal-content" style="border-radius: 10px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Event</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="event.php" method="POST">
           <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-info"></i></span>
              <input type="text" name="event_title"  class="form-control"   placeholder="title" required>
            </div>
          </div>
           <br>
            <div class="row">
            <div class=" col-md- input-group input-group-">
              <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
              <input type="text" name="event_location"  class="form-control"   placeholder="location" required>
            </div>
          </div>
          <br>
           <div class="row">
            <div class=" col-md-6">
            <div class=" input-group input-group-">
              <span class="input-group-addon">Start Date   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="event_startDate"  id="" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
          <div class="col-md-6 ">
            <div class="input-group">
                <span class="input-group-addon">Start Time:   <i class="glyphicon glyphicon-time"></i></span>
                <input type="time" name="event_startime"  id="" class="form-control"   placeholder="Starting Time" required>
                
                
              </div>
            </div>
          </div>
           
          <br>
           
          <div class="row">
            <div class=" col-md-6">
            <div class=" input-group input-group-">
              <span class="input-group-addon">End Date   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="event_endDate"  class="form-control"   placeholder="Ending time" required>
            </div>
          </div>
          <div class="col-md-6 ">
            <div class="input-group">
                <span class="input-group-addon">End Time:   <i class="glyphicon glyphicon-time"></i></span>
                <input type="time" name="event_endtime"  id="" class="form-control"   placeholder="Starting Time" required>
                
                
              </div>
            </div>
          </div>
          <br>
           <div class="row">
            <div class=" col-md-12 input-group input-group-">
              
              <textarea type="text" name="event_description"  class="form-control"   placeholder="Description" required></textarea>
            </div>
            <br>
          </div>
          <div class="input-group my-colorpicker2">
                  <input type="color" name="event_color" class="form-control my-colorpicker1">

                  <div class="input-group-addon">
                    <i></i>
                  </div>
              </div>
               <br>
              <div class="col-md-12 input-group ">
                <div class="row">
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="event_for" class=" flat-red"  value="All" checked>
                    <label>ALL </label>
                  </label>
                  </div>
                  <div class="col-md-2">
                  <label >
                    <input type="radio" name="event_for" class=" flat-red" value="Parent">
                    <label>Parent</label>
                  </label>
                </div>
                <div class="col-md-2">
                  <label >
                    <input type="radio" name="event_for" class=" flat-red" value="Staff">
                    <label>Staff</label>
                  </label>
                </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addEventBtn" class="btn btn-primary">Add Event</button>
              </div>
              </div>
             </form>
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal fade" id="modal-printEvent">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Print Event</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="" method="POST">
          
           <br>
           
          <br>
           <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">FROM:   <i class="glyphicon glyphicon-calendar"></i></span>
              <input type="date" name="printFromDate"  id="printFromDate" class="form-control"   placeholder="Starting Time" required>
            </div>
          </div>
          
          </div>
           
          <br>
           
          <div class="row">
            <div class=" col-md-12">
            <div class=" input-group input-group-">
              <span class="input-group-addon">TO:   <i class="glyphicon glyphicon-calendar"></i></span>
             <input type="date" name="printToDate" id="printToDate"  class="form-control"   placeholder="Ending time" required>
            </div>
          </div>
          
          </div>
          <br>
           <div class="row">
            <div class=" col-md-12 ">
              <div class="form-group has-feedback input-group-">
                  
                 <div class=" col-md- input-group input-group">              
                 <label>
                    <input type="radio" name="print_event_type" id="print_event_type" class=" flat-red"  value="All" checked>
                    ALL Events
                  </label>
                  &nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="print_event_type" id="print_event_type" class=" flat-red" value="Birthday">
                    Birthday Events
                  </label>
                </div>
                </div>
                
            </div>
            <br>
          </div>
         
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="printEventB" class="btn btn-primary" onclick="myFunction()">Print</button>
              </div>
              </div>
             </form>
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
         <!-- delete event  Modal-->
    <div class="modal  fade" id="delete_event_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Event?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteEventFunc(id){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete this event'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="event.php"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="deleteEventFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="msg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
        </div>
      </div>
    </div>
     </div>

    <!-- edit Event Modal-->
    <div class="modal  fade" id="edit_event_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Edit Event</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               
            <script >
             
               function editEventFunc(id){ 
                 //alert(id);
                  if(id !=''){
                    var details= '&event_id='+ id ;
                    $.ajax({
                    type: "POST",
                    url: "edit_event.php",
                    data: details,
                    cache: false,
                    success: function(data) {
                      document.getElementById("eventMessage").innerHTML=data;
                   

                    }

                    });
                   
                  }else{
                   document.getElementById("eventMessage").innerHTML=' You have Not Yet selected a Class';
                  }
                 
                
                }
            </script>
          
          <div id="eventMessage"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>

     <!-- view Event Modal-->
    <div class="modal  fade" id="view_event_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Email Event</b></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="nav-tabs-custom">
              <div class="tab-content">
               <div id="eventmsg"></div>
            <script >
             
               function sendEventFunc(id){ 
                 //alert(id);
                   document.getElementById("eventmsg").innerHTML=' Are you sure you want to Email this event to parents'
                var updiv = document.getElementById("eventfoot"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="event.php"><div class="modal-footer"><button class="btn btn-primary pull-left" name="deletebuttonFunc" id="'+ id +'" type="submit" data-dismiss="modal" onclick="emailEventToParent(this.id)">Email to Parent</button><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button></form></div>';
                
                
                
                }
            </script>
          
          <div id="eventfoot"></div>

        </div>
          </div>
        </div>
      </div>
    </div>
     </div>
      <div class="modal  fade" id="print_event_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Print Events</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
     <iframe id="printM" name="printM" style="width: 100%;height:600px;">

    </iframe>
            <script >
        
          var data=document.getElementById("printEventDiv").outerHTML;
         
            var newWin = window.frames["printM"];
        newWin.document.write('<body onload="window.print()">'+data+'</body>');
        newWin.document.close();
         
         
  
            </script>
          
          
          

        </div>
          
      </div>
    </div>
     </div>
      <!-- Import event-->
        <div class="modal fade" id="modal-importStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload CSV file</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
         <form id="fileinfo" name="" action="event.php" method="POST" enctype="multipart/form-data">
           <input type="file" name="importFile" class="form-control" value="upload">
         
        </div>
          <div class="modal-footer">
            <button type="submit" class="pull-left btn btn-primary" name="importBtn" href="#">Upload</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            
          </div>
        </form>
        </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
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
  <script>
function myFunction() {
var event_type;
  var from_date=document.getElementById('printFromDate').value;
  var to_date=document.getElementById('printToDate').value;
  var event_type=document.getElementById('print_event_type').value;
  var radios=document.getElementsByName('print_event_type');

  for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
        // do whatever you want with the checked radio
       // alert(radios[i].value);
event_type=radios[i].value;
        // only one radio can be logically checked, don't check the rest
        break;
    }
}
 // alert(event_type);
  if (from_date =='' || to_date =='' || event_type =='' ) {
    alert("All fields are required");
  }else if(from_date =='' && to_date !=='' && event_type !==''  ){
    alert("Date From is required");
  }else if(to_date =='' && from_date !=='' && event_type !==''  ){
    alert("Date To is required");
  }else if (event_type =='' && from_date !=='' && to_date  !=='' ) {
    alert("Please Select class");
  }else if(from_date !=='' && to_date !=='' && event_type !==''){
    
     window.open("print_event.php?from="+from_date+"&to="+ to_date+"&event_type="+event_type , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=,left=,width=1000,height=1000");
  }
  
 
}
</script>
<!-- ./wrapper -->


<!-- include script-->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="../../bower_components/moment/moment.js"></script>
<script src="../../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- bootstrap color picker -->
<script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="../../bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- CK Editor -->
<script src="../../bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../../dist/js/fusioncharts/fusioncharts.js"></script>


<!-- FastClick -->
<!-- include script-->
<?php //include("include/script.php")?>
<!-- page script -->

<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    :'./json_event.php',
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>

<script >
  // Email events to parents
  function emailEventToParent(event_id){
 // alert(event_id);
  var details= '&event_id='+ event_id;
  $.ajax({
  type: "POST",
  url: "email_event_to_parent.php",
  data: details,
  cache: false,
  success: function(data) {
    alert(data);
    if(data=='success'){
 window.location="event.php?event=True" 
    }else{
      alert("OOp! Could not send Email.Please try again!");
    }
  
  }

  });
  }

  // Delete event
  function deleteEventFromSystem(event_id){
  //alert(id);
  var details= '&event_id='+ event_id;
  $.ajax({
  type: "POST",
  url: "delete_event.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="event.php?delete=True" 
    }else{
      alert("OOp! Could not delete.Please try again!");
    }
  
  }

  });
  }
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>
<?php //include("include/script.php");?>
</body>
</html>
