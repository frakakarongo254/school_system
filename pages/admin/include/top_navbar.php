 <header class="main-header">

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
    <a href="dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo $logo;?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $logo;?></span>
    </a>
    
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
              
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 notifications</li>
              
                <!-- inner menu: contains the actual data -->
               
              <li class="footer"><a href="#">View all</a></li>
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
                 <?php echo $_SESSION['login_user_fname'] .  " - "  .$_SESSION['login_user_role'];?> 
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-secondary btn-flat"><i class="fa fa-fw fa-user"></i>Profile</a>
                </div>
                <div class="pull-right">
                 <!-- Find logout Modal from footer file from include folder -->
                  <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Sign out</a>
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



    </nav>
  </header>