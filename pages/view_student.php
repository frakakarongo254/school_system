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

?>

<?php include("include/header.php")?>

<body class="hold-transition skin-blue sidebar-mini">
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="">
     <div class="row">
       
         <div class="col-md-12 ">
         
      <?php
      if(isset($_GET['insert'])){
       
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center><b>Success! ' .$_GET['insert'] . '  inserted  successfully.</b></center>
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center>Success! updated  successfully.</center>
          </div>';   
        }
        if(isset($_GET['delete'])){
          echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         <center> Success! Delete  successfully.</center>
          </div>';   
        }

    if (isset($_POST['addDocumentBtn'])) {
      $document_title=$_POST['document_title'];
      $document_desc=$_POST['document_desc'];
      $date_created = date('Y-m-d H:i:s');
      $file=$_FILES['documentfile']['name'];
      $path_parts = pathinfo($file);
      $extension= $path_parts['extension'];
      $folder_path = 'document/';
      $_FILES['documentfile']['type'];
      
   $filename = basename($_FILES['documentfile']['name']);
    #check if that document already exist

     $newname = $folder_path . $filename;

    if ($extension == "pdf")
    {
        if (move_uploaded_file($_FILES['documentfile']['tmp_name'], $newname))
        {

            $filesql = "INSERT INTO document (file_name,student_ID,school_ID,title,description,date_created) VALUES('$filename','$student_ID','$school_ID','$document_title','$document_desc','$date_created')";
            $fileresult = mysqli_query($conn,$filesql);
             if (isset($fileresult))
        {
           // echo 'Success';
            echo '<script> window.location="view_student.php?id='.$student_ID.'&insert=Document" </script>';

        } else
        {
            echo 'fail';

             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         <center> Oops! Something went wrong.Please try again.</center>
          </div>';   


        }
        }
        else
        {

           
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center>Upload Failed.</center>.
          </div>';   
        }

       
    }
    else
    {
       
        echo' <div class="alert alert-warning alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         <center> Document must be uploaded in PDF format.</center>
          </div>';   

    }

}
#edit document
if(isset($_POST['editDocumentBtn'])){

  #get school Id from current session school id
  $school_ID = $_SESSION['login_user_school_ID'];
  $edit_document_title=$_POST['edit_document_title'];
  $edit_document_id=$_POST['edit_document_id'];
  $edit_document_desc=$_POST['edit_document_desc'];
  
  if(isset($_FILES['edit_documentfile']['name'])){
   $file=$_FILES['edit_documentfile']['name'];
      $path_parts = pathinfo($file);
      $extension= $path_parts['extension'];
      $folder_path = 'document/';
   
      
   $filename = basename($_FILES['edit_documentfile']['name']);
    #check if that document already exist

     $newname = $folder_path . $filename;

    if ($extension == "pdf")
    {
        if (move_uploaded_file($_FILES['edit_documentfile']['tmp_name'], $newname))
        {

            $fileresult =mysqli_query($conn,"update `document` SET title= '".$edit_document_title."', description= '".$edit_document_desc."',file_name= '".$filename."' where `document_ID`='".$edit_document_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
            if ($fileresult)
        {
           // echo 'Success';
            echo '<script> window.location="view_student.php?id='.$student_ID.'&update=True" </script>';

        } else
        {
          
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center>Oops! Something went wrong.Please try again.</center>
          </div>';   


        }
        }
        else
        {

           
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         <center> Upload Failed.</center>
          </div>';   
        }

        
    }
    else
    {
       
        echo' <div class="alert alert-warning alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
         <center> Document must be uploaded in PDF format.</center>
          </div>';   

    }
  }else{

            $fileresult =mysqli_query($conn,"update `document` SET title= '".$edit_document_title."', description= '".$edit_document_desc."' where `document_ID`='".$edit_document_id."' && `school_ID`='".$_SESSION['login_user_school_ID']."' ");
            if ($fileresult)
        {
           // echo 'Success';
            echo '<script> window.location="view_student.php?id='.$student_ID.'&update=True" </script>';

        } else
        {
          
             echo' <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          <center>Oops! Something went wrong.Please try again.</center>
          </div>';   


        }
  }

}
          ?>
</div>
</div>
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
              $row['first_Name'];
               $image;
             if($row['photo'] !=''){
              $image = '<img class=" profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"  height="40px" width="40px" alt="User profile picture"/>';
            }else{
                $image = "<img class=' profile-user-img img-responsive img-circle' src='../dist/img/avatar.png' alt='User profile picture'>";
              }
          ?>
          <!-- Profile Image -->
          <div class="box box-primary ">
            <div class="box-body box-profile">
              <div class="row">
                <div class="col-md-6 ">
                 <b class="pull-left" style="font-size: 20px">Student</b>
                  <div class="pull-right">
                   <?php echo $image;?>

              <h3 class="profile-username text-center"><?php echo $row['first_Name'] ." ". $row['last_Name'];?></h3>
            </div>
                </div>
                <div class="col-md-6">
                  <table>
                  <tr>
                    <td><span style="font-size: 17px">Adm:</span></td>
                    <td><b><?php echo $row['registration_No']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Gender:</span></td>
                    <td><b><?php echo $row['gender_MFU']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Nationality:</span></td>
                    <td><b><?php echo $row['nationality']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Date of Birth:</span></td>
                    <td><b><?php echo $row['date_of_Birth']?></b></td>
                  </tr>
                  <tr>
                    <td><span>Admission Date:</span></td>
                    <td><b><?php echo $row['admission_date']?></b></td>
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
                  <li class="active"><a href="#tab_1" data-toggle="tab" style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Student Classes</a></li>
                  <li><a href="#tab_2" data-toggle="tab"  style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Student Parents</a></li>
                  <li><a href="#tab_3" data-toggle="tab"  style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Documents</a></li>
                   <li><a href="#tab_4" data-toggle="tab"  style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Student Statement</a></li>
                    <li><a href="#tab_5" data-toggle="tab"  style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Marks</a></li>
                       <li><a href="#tab_6" data-toggle="tab"  style="font-size:20px; font-weight: bold;font-family: "Times New Roman", Times, serif;">Notification</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                              <th>Actions</th>
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
                                        
                                          
                                        <td>";
                                       echo'  <a href="#"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  View</button></a>

                                        
                                       </td>
                                     </tr>';

                               
                              
                           ?>
                           
                             </tbody>
                            <tfoot>
                            <tr>
                             <th>Year</th>
                              <th>Class Name</th>
                              <th>Stream</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
                    </div>
                    <div class="tab-pane" id="tab_2">
                           <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Img</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Relation</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                               $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from parent_relation where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               while ($row1=mysqli_fetch_array($query2)){
                               $parentID= $row1['parent_ID'];
                               $parent_relation= $row1['relation'];
                               #get student details
                               $query3 = mysqli_query($conn,"select * from parents where school_ID = '$school_ID' && parent_ID='$parentID'")or
                               die(mysqli_error());
                               while ($row2=mysqli_fetch_array($query3)){
                                $img;
                               if($row2['photo'] !=''){
                                $img = '<img src="data:image/jpeg;base64,'.base64_encode( $row2['photo'] ).'"  height="40px" width="40px" />';
                              }else{
                                  $img = "<img src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
                                }
                                echo" <tr>
                                       <td>
                                        ".$img."
                                       </td>
                                        <td>".$row2['first_Name']." ". $row2['last_Name']."</td>
                                        <td>".$row2['cell_Mobile_Phone']." </td>
                                         <td>".$row2['email']." </td>
                                        <td>".$row2['gender_MFU']."</td>
                                        <td>". $parent_relation."</td>
                                          
                                        <td>";
                                       echo'   <a href="view_parent.php?id='.$parentID.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  View</button></a>

                                        
                                       </td>
                                     </tr>';

                               }
                              
                                }
                              ?>
                           
                             </tbody>
                            <tfoot>
                            <tr>
                             <th>Img</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Relation</th>
                              <th>Actions</th>
                            </tr>
                            </tfoot>
                          </table>
                    </div>

                     <div class="tab-pane" id="tab_3">
                      <div class="row">
              <div class="col-md-8"><b><h3>Documents</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="login.html" data-toggle="modal" data-target="#modal-addDocument"><i class="fa fa-plus"></i><b> New Document</b></a></div>
            </div>
                      <table id="example3" class="table table-bordered table-striped">
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
                                       <button type="button"  class="btn btn-info btn-flat" id="'.$documentID.'" onclick="editDocument(this.id)" data-toggle="modal" data-target="#modal-editDocument"><span class="glyphicon glyphicon-pencil"></span></button>

                                      

                                        <a href="document/'.$document_name.'"><button type="button"  class="btn btn-success btn-flat" onclick="viewStudentDetailes()"><span class= "glyphicon glyphicon-eye-open"> </span>  </button></a>

                                         <button type="button"  class="btn btn-danger btn-flat" id="'.$documentID.'" onclick="deleteDocument(this.id)" data-toggle="modal" data-target="#delete_document_Modal"><span class="glyphicon glyphicon-trash"></span></button>

                                        
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
                    <div class="tab-pane" id="tab_4">
                         <table id="table11" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Date</th>
                              <th>Invoiced</th>
                              <th>Paid</th>
                              <th>Balance</th>
                              
                              
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                               #get school Id from current session school id
                             /*  $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from invoice where school_ID = '$school_ID' && student_ID='$student_ID'")or
                               die(mysqli_error());
                               $total_amount=0.00;
                               while ($row2=mysqli_fetch_array($query2)){
                                $total_amount= $total_amount + $row2['amount']  ;
                               $invoiveID= $row2['invoice_ID'];
                                $invoive_date= $row2['invoice_date'];
                               $newDate = date("d-m-Y", strtotime($invoive_date));
                              // $parent_relation= $row1['relation'];
                               
                                echo" <tr>
                                       <td>".$newDate."</td>
                                       <td>".$row2['reff_no']."</td>
                                        <td>".$row2['amount']."</td>
                                        <td>".$row2['summury']." </td>";
                                         
                                          
                                      
                                      // echo' <td>  <a href="download_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" ><span class= "glyphicon glyphicon-print"> </span> Print  </button></a>

                                      //  <a href="view_invoice.php?invoice='.$invoiveID.'"><button type="button"  class="btn btn-success btn-flat" "><span class= "glyphicon glyphicon-eye-open"> </span>  </button></a>

                                       //  <button type="button"  class="btn btn-danger btn-flat" id="'.$invoiveID.'" onclick="deleteInvoice(this.id)" data-toggle="modal" data-target="#delete_invoice_Modal"><span class="glyphicon glyphicon-trash"></span></button>
                                     //  </td>
                                   echo'  </tr>';
                                     
                               
                              
                                }*/
                                                                                   
$result=mysqli_query($conn,"select i.invoice_ID,i.balance,i.invoice_date,i.amount,ifnull(sum(p.amount_paid),0) as paid,i.amount-ifnull(sum(amount),0) as due
from invoice i
left join payment p
on p.invoice_ID=i.invoice_ID
where i.student_ID='$student_ID'
group by i.invoice_ID
order by i.invoice_ID");
$total_invoiced=0.00;
$total_paid=0.00;
$total_balance=0.00;
while($rows = $result->fetch_assoc()) {
$total_invoiced=$total_invoiced + $rows["amount"];
$total_paid=$total_paid + $rows["paid"];
$total_balance=$total_balance + $rows["balance"];
$invoive_date= $rows['invoice_date'];
$newDate = date("d-m-Y", strtotime($invoive_date));
  $due;
  if ($rows["due"]< 0) {
    $due=0.00;
  }else{
    $due=$rows["due"];
  }
 echo '<tr>
 <td> '.$newDate.'</td>
 <td> '.$rows["amount"].'</td>
 <td> '.$rows["paid"].'</td>
 <td> '.$rows["balance"].'</td>
 </tr>';
}                        
echo'<tr>
  <td><b>TOTAL<b></td>
   <td><b>'.$total_invoiced.'</b></td>
   <td><b>'.$total_paid.'</b></td>
   <td><b>'.$total_balance.'</b></td>
<tr>'

                              ?>
                           
                             </tbody>
                            
                          </table>
                        <div class="row clearfix" style="margin-top:20px">
                        <div class="pull-right col-md-4">
                          <table>
                           
                          </table>
                        </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_5">
                      eewewrrre
                    </div>
                    <div class="tab-pane" id="tab_6">
                      bcaacnanc
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
      <div class="modal fade" id="modal-addDocument">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Document</b></h4>
              </div>
              <div class="modal-body">
                 <div class="nav-tabs-custom">
              <div class="tab-content">
               
              <!-- /.tab-pane -->
            <form  action="view_student.php?id=<?php echo $student_ID?>" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>Title</label>
                 <input type="text" name="document_title" class="form-control" placeholder="Title" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea type="text" name="document_desc" class="form-control" placeholder="Description" maxlength="100"></textarea>
                
              </div>
              <div class="form-group">
                <label>Document</label>
                <br>
                
                 <span class="btn btn-default btn-file">
                    Browse File<input name="documentfile" type="file" class="form-control" required>
                </span>
            <br/><br/>
              </div>
           
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="addDocumentBtn" class="btn btn-primary">Add Document</button>
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

           <!--Edit document model-->
         
      <div class="modal fade" id="modal-editDocument">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Document</h4>
              </div>
              <div class="modal-body">
                <script >
                function editDocument(document_ID){
               
                var updiv = document.getElementById("docMessage"); //document.getElementById("highodds-details");
                var student_id= <?php echo $_GET['id']?>;
                //alert(id);
                var details= '&document_id='+ document_ID+'&student_id='+student_id;
                $.ajax({
                type: "POST",
                url: "edit_document.php",
                data: details,
                cache: false,
                success: function(data) {
               
                document.getElementById("docMessage").innerHTML=data;
                 }
                });
                }
                </script>
                <div id="docMessage"></div>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
         <!-- delete document  Modal-->
    <div class="modal  fade" id="delete_document_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Document</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteDocument(document_id){
                  
                 document.getElementById("msg").innerHTML=' Are you sure you want to delete this document?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ document_id +'" type="submit" data-dismiss="modal" onclick="deleteDocumentFromSystem(this.id)">Delete</button></form></div>';
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

         <!-- delete Invoice  Modal-->
    <div class="modal  fade" id="delete_invoice_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Invoice</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <script >
               function deleteInvoice(invoice_id){
                  
                 document.getElementById("invoiceMsg").innerHTML=' Are you sure you want to delete this Invoice?'
                var updiv = document.getElementById("modalInvoiceMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="" id="'+ invoice_id +'" type="submit" data-dismiss="modal" onclick="deleteInvoiceFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="invoiceMsg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalInvoiceMsg"></div>
        </div>
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

<script >
  function deleteDocumentFromSystem(documentId){
    alert(documentId);
  var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&document_id='+ documentId;
  $.ajax({
  type: "POST",
  url: "delete_document.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
 window.location="view_student.php?id=<?php echo $student_ID?>&delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  }
  });
  }

  function deleteInvoiceFromSystem(invoice_id){
    //alert(invoice_id);
  //var updiv = document.getElementById("message"); //document.getElementById("highodds-details");
  //alert(id);
  var details= '&invoice_id='+ invoice_id;
  $.ajax({
  type: "POST",
  url: "delete_invoice.php",
  data: details,
  cache: false,
  success: function(data) {
    if(data=='success'){
      alert(data);
 window.location="view_student.php?id=<?php echo $student_ID?>&delete=True" 
    }else{
      alert(data);
      alert("OOp! Could not delete the student.Please try again!");
    }
  }
  });
  }
</script>
</body>
</html>
