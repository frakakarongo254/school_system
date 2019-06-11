 <?php
    //include("session.php");

      $school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");

      $school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
      $school_row['school_Name'];
      $logo;
      if($school_row['logo_image'] !=''){
      $logo = '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="50px" width="50px" />';
      }else{
        $logo = "<img class='img-circle' src='../dist/img/avatar.png' class='img-circle' alt='User Image' height='50px' width='50px'>";
      }?>
 <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
       
    <?php $school_row['school_Name'];?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-header">
       
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
             <li><span class="logo-mini"><?php echo $logo;?></span></li>
            <li><a href="dashboard.php"><b style="font-size: 24px;color: #fff"><?php echo $school_row['school_Name']?></b></a></li>
          
          </ul>
         
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o" style="color: white;"></i>
                <span class="label label-success">
                  <?php 
                  $Parent_email=   $_SESSION['login_user_email'];

               $query_inbox= mysqli_query($conn,"select * from `email` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient='$Parent_email' and status='0'");
                $query_inbox_row=mysqli_num_rows ( $query_inbox );
                echo $query_inbox_row ;
                ?> 

                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have   <?php  echo $query_inbox_row ;?> messages</li>
                <li>
                  <!-- inner menu: contains the messages -->
                  
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- /.messages-menu -->

            
           
           
             <li class="dropdown user user-menu" style="text-decoration:;color:">
            <?php
             $user_img;
             if( $_SESSION['login_user_photo'] !==''){
              $user_img='<img class="user-image" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['login_user_photo'] ).'"  height="90" width="90px" />';
              // img circle class
              $user_img_circle='<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['login_user_photo'] ).'"  height="90" width="90px" />';
             }else{
              $user_img='<img src="../../dist/img/avatar.png" class="user-image" alt="User Image">';
              // img circle class
              $user_img_circle='<img src="../../dist/img/avatar.png" class="img-circle" alt="User Image">';
             }
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: ;color:#fff ">
              <?php echo $user_img ;?>
              <span class="hidden-xs"><?php echo $_SESSION['login_user_fullName'] ;?></span>
            </a>
            
             <ul class="dropdown-menu" role="menu">
                   <li><a href="#"><b><?php
                     echo $_SESSION['login_user'];
                    ?></b></a></li>
                    
                   
                    <li class="divider"></li>
                    <li><a href="include/logout.php"><i class="fa fa-sign-out"></i><b>Logout</b></a></li>
                  </ul>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>