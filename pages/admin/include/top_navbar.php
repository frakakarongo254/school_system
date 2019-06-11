 <header class="main-header">

    <!-- Logo --><?php
      $school_data_sql = mysqli_query($conn,"select * from `school` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");

      $school_row = mysqli_fetch_array($school_data_sql,MYSQLI_ASSOC);
      $school_row['school_Name'];
      $logo;
      if($school_row['logo_image'] !=''){
      $logo = '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $school_row['logo_image'] ).'"  height="50px" width="50px" />';
      }else{
        $logo = "<img class='img-circle' src='../../dist/img/avatar.png' class='img-circle' alt='User Image' height='50px' width='50px'>";
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
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="text-decoration: none;color: #fff">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;color: #fff">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">
                 <?php 
                      $emailSignature_sql = mysqli_query($conn,"select * from `email_setting` where `school_ID` = '".$_SESSION['login_user_school_ID']."' ");
                    $senderemail_row = mysqli_fetch_array($emailSignature_sql,MYSQLI_ASSOC);
                   
                    $school_email=$senderemail_row['sender_email'];

               $query_inbox= mysqli_query($conn,"select * from `email` where `school_ID` ='".$_SESSION['login_user_school_ID']."' and recipient='$school_email' and status='0'");
                $query_inbox_row=mysqli_num_rows ( $query_inbox );
                echo $query_inbox_row ;
                ?> 
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php  echo $query_inbox_row;?> unread messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
              
              </li>
              <li class="footer"><a href="email_inbox.php">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;color: #fff">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">
                <?php
                $school_ID=$_SESSION['login_user_school_ID'];
                $Today=date('y:m:d');
                $NewDate=Date('y:m:d', strtotime("+3 days"));
                $event_q = mysqli_query($conn,"select * from event where date(event_startDate) between date('$Today') and date('$NewDate') and school_ID = '$school_ID' ORDER BY event_startDate DESC");
                $query_inbox_row=mysqli_num_rows ($event_q);
                echo $query_inbox_row ;

               ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php  echo $query_inbox_row ?> notifications</li>
              <li class="header"><b>Upcoming events in  a week time</b></li>
              <li>

                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php
               $event_q2 = mysqli_query($conn,"select * from event where date(event_startDate) between date('$Today') and date('$NewDate') and school_ID = '$school_ID' ORDER BY event_startDate DESC");
               while ($event_row=mysqli_fetch_array($event_q2)){
                  echo '<li>
                    <a href="#">
                      <i class="fa fa-calendar"></i> '.$event_row['event_startDate'].' '.$event_row['event_title'].'
                    </a>
                  </li>';
               }
              ?>
                  
                  
                 

                 
                </ul>
              </li>
              
                <!-- inner menu: contains the actual data -->
               
              <li class="footer"><a href="event.php">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
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
                    <li><a href="profile.php"><i class="fa fa-user"></i><b> Profile</b></a></li>
                   
                    <li class="divider"></li>
                    <li><a href="include/logout.php"><i class="fa fa-sign-out"></i><b>Logout</b></a></li>
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