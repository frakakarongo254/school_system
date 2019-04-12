






<!-- Logo --><?php
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
      
        <div class="navbar-header">
          
          <a href="dashboard.php" class=" " style="padding-left: 20px"><?php echo $logo;?></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
<div class="container">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
           <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">
                 <?php 
               $query_message= mysqli_query($conn,"select * from `email` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient='".$_SESSION['login_user_email']."' and status='0'");
                $query_msg_row=mysqli_num_rows ( $query_message );
                echo $query_msg_row ;
                ?> 
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have  <?php echo $query_msg_row;?>  messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
              
              </li>
              <li class="footer"><a href="email_inbox.php">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">
                <?php 
               $query_notf= mysqli_query($conn,"select * from `notification` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient_ID='$login_parent_ID' and read_status='0'");
                $query_notf_row=mysqli_num_rows ( $query_notf );
                echo $query_notf_row ;
                ?> 
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have  <?php echo $query_notf_row ;?>   notifications</li>
              
                <!-- inner menu: contains the actual data -->
               
              <li class="footer"><a href="notification.php">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
          
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <?php
             $user_img;
             if( $_SESSION['login_user_photo'] !==''){
              $user_img='<img class="user-image" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['login_user_photo'] ).'"  height="90" width="90px" />';
              // img circle class
              $user_img_circle='<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['login_user_photo'] ).'"  height="90" width="90px" />';
             }else{
              $user_img='<img src="../dist/img/avatar.png" class="user-image" alt="User Image">';
              // img circle class
              $user_img_circle='<img src="../dist/img/avatar.png" class="img-circle" alt="User Image">';
             }
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php echo $user_img ;?>
              <span class="hidden-xs"><?php echo $_SESSION['login_user_fname'] ;?></span>
            </a>
            
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
               
                <?php echo $user_img_circle ;?>
                <p>
                 <?php echo $_SESSION['login_user_fname'] .  " - Parent " ;?> 
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-secondary btn-flat"><i class="fa fa-fw fa-user"></i><b>Profile</b></a>
                </div>
                <div class="pull-right">
                 <!-- Find logout Modal from footer file from include folder -->
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i><b>Sign out</b></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-"></i></a>
          </li>
        </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>