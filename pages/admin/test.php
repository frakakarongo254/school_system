<?php require_once("include/config.php"); 
if(isset($_POST["Export"])){
     echo "yes";
  //   $filename = "members_" . date('Y-m-d') . ".csv";
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('first_Name','last_Name','nickname',
          'registration_No','school_ID'));  
      $queryz = "SELECT id,first_Name,last_Name,nickname,
          registration_No,school_ID from student ORDER BY id DESC";  
      $resultz = mysqli_query($conn, $queryz);  
      while($rowz = mysqli_fetch_assoc($resultz))  
      {  
      
    
           fputcsv($output, $rowz);  
      }  
      fclose($output);  
      //return ob_get_clean();
       
      //move back to beginning of file
    exit();
 } 

 ?>
 <form action="" method="POST">
                  <button type="submit" class="btn" name="Export">Export Sample</button>
                </form>