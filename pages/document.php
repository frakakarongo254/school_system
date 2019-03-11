<?php  include("include/session.php");
if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');
}
#get school Id from current session school id
  $school_ID = $_SESSION['login_user_school_ID'];
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
   
 <section class="content-header">
        
      <?php
    
        if(isset($_GET['insert'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Document added  successfully.
          </div>';   
        }
        if(isset($_GET['update'])){
          echo' <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert"
          aria-hidden="true">
          &times;
          </button>
          Success! Document updated  successfully.
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

            $filesql = "INSERT INTO document (file_name,student_ID,school_ID,title,description,date_created) VALUES('$filename','0','$school_ID','$document_title','$document_desc','$date_created')";
            $fileresult = mysqli_query($conn,$filesql);
             if (isset($fileresult))
        {
           // echo 'Success';
            echo '<script> window.location="document.php?insert=true" </script>';

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
            echo '<script> window.location="document.php?update=True" </script>';

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
            echo '<script> window.location="document.php?update=True" </script>';

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
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
             <div class="row">
              <div class="col-md-8"><b><h3>Document</h3> </b></div>
              <div class="col-md-4 col-pull-right" style="text-align:right"><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-addDocument"><i class="fa fa-plus"></i><b> New Document</b></a></div>
            </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>   
                   <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    #get school Id from current session school id
                               $school_ID = $_SESSION['login_user_school_ID'];
                               $query2 = mysqli_query($conn,"select * from document where school_ID = '$school_ID' and student_ID='0' ")or
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
                  <th>Title</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
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
            <form  action="document.php" method="POST" enctype="multipart/form-data">
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
             
                alert(document_ID);
                var details= '&document_id='+ document_ID ;
                $.ajax({
                type: "POST",
                url: "edit_school_document.php",
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
                  
                 document.getElementById("deleteMsg").innerHTML=' Are you sure you want to delete this document?'
                var updiv = document.getElementById("modalMsg"); //document.getElementById("highodds-details");
                updiv.innerHTML ='<form method="POST" action="brand"><div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-danger" name="deletebuttonFunc" id="'+ document_id +'" type="submit" data-dismiss="modal" onclick="deleteDocumentFromSystem(this.id)">Delete</button></form></div>';
                }
            </script>
          
          <div id="deleteMsg"></div>

        </div>
          <div class="modal-footer">
           <div id="modalMsg"></div>
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
 window.location="document.php?delete=True" 
    }else{
      alert("OOp! Could not delete the student.Please try again!");
    }
  }
  });
  }

</script>
</body>
</html>
