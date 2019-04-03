 <header class="main-header">

    <a href="dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"></span>
    </a>
    
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      
      <div class="container">
       

       <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            
            <li><a href="profile.php"><i class="fa fa-gear"></i> Setting</a></li>
            <li >
              <a href="attendance.php" > <i class="fa fa-calendar"></i> Attendance </a>
              
            </li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="hidden" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form>
        </div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
              <span class="label label-success"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"></li>
              <li>
                <!-- inner menu: contains the actual data -->
              
              </li>
              <li class="footer"><a href="#"></a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <span class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"></li>
              
                <!-- inner menu: contains the actual data -->
               
              <li class="footer"><a href="#"></a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <span class="label label-danger"></span>
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
              $user_img='<img src="../../dist/img/avatar.png" class="user-image" alt="User Image">';
              // img circle class
              $user_img_circle='<img src="../../dist/img/avatar.png" class="img-circle" alt="User Image">';
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
                 <?php echo $_SESSION['login_user_fname'] .  " - Lecturer" ?> 
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a class="nav-link" data-toggle="modal" data-target="#logout">
            <i class="fa fa-fw fa-sign-out"></i>Sign out</a>
                </div>
                <div class="pull-">
                
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

</div>

    </nav>
  </header>