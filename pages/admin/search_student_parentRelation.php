<?php include("include/session.php");
    if (!velifyLogin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../../index.php');
    }
    $RegNo = $_POST['RegNo'];
    $parentID = $_POST['linkParentID'];
    //$id = "1";
    $result_array = array();

    $query_studentData= mysqli_query($conn,"select * from `student` where `school_ID` ='".$_SESSION['login_user_school_ID']."' && `registration_No` LIKE '%$RegNo%' or `first_Name`LIKE '%$RegNo%' or `last_Name`LIKE '%$RegNo%' ");
    $query_search_row=mysqli_num_rows (  $query_studentData );
    if ($query_search_row !=0) {
    //$search_row = mysqli_fetch_array($query_studentData,MYSQLI_ASSOC);
    //	header("Refresh:0; url=http://localhost/hardware/user.php");
    while ($search_row=mysqli_fetch_array($query_studentData)){
    $img;
    if($search_row['photo'] !=''){
    $img = '<img src="data:image/jpeg;base64,'.base64_encode( $search_row['photo'] ).'"  height="40px" width="40px" />';
    }else{
    $img = "<img src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='40px' width='40px'>";
    }
    echo '
    <form method="POST" action="parent.php">
    <table class="table table-bordered table-striped">
    <tr class="col-md-12">
    <td>'.$img.'</td>
    <td>'.$search_row["first_Name"].' '.$search_row["last_Name"].'</td>
    <td>'.$search_row["registration_No"].'</td>
    <td><input type="text" class="form-control" name="relation" placeholder="Father,Mother, Guardian"></td>
    <td><input type="hidden" name="link_studentID" value="'.$search_row["student_ID"].'">
    <input type="hidden" name="link_parentID" value="'.$parentID.'"></td>
    <td><button class="btn btn-success" type="submit" name="linkStudentBtn">Link</button></td>
    </tr>
    </table> 
    </form><br>';
    }


    }else {
    echo' <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert"
    aria-hidden="true">
    &times;
    </button>
    Sorry! There is no student with such Reg No or Name
    </div>';   
    }


?>