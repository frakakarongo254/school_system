 <?php  include("include/session.php");

    if (!velifyLogin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../index.php');

}

  $document_id = $_POST['document_id'];
  $student_id = $_POST['student_id'];
  $query_doc_details = mysqli_query($conn,"select * from `document` where `document_ID` = '".$document_id."'  and `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
     $rows_doc = mysqli_fetch_array( $query_doc_details,MYSQLI_ASSOC);
echo ' <form  action="view_student.php?id='.$student_id.'" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_document_id" value="'.$rows_doc['document_ID'].'">
               <div class="form-group">
                <label>Title</label>
                 <input type="text" name="edit_document_title" class="form-control" value="'.$rows_doc['title'].'" placeholder="Title" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea type="text" name="edit_document_desc" class="form-control" placeholder="Description" maxlength="100">'.$rows_doc['description'].'</textarea>
                
              </div>
              <div class="form-group">
                <label>Document</label>
                <br>
                
                 <span class="btn btn-default btn-file">
                    Browse File<input name="edit_documentfile" type="file" class="form-control" required>
                </span>
            <br/><br/>
              </div>
           
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                <button type="submit" name="editDocumentBtn" class="btn btn-primary">Edit Document</button>
              </div>
              </div>
             </form>';
?>
 
