<header class="main-header">
  <nav class="navbar navbar-static-top" style="background-color: #4e48da;">
    <div class="container">
      <div class="navbar-header" style="background-color: #4e48da;">
        <a href="#" class="navbar-brand"><b>Ruang</b>RIUNG</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
              <!-- Menu toggle button -->
              <a href="#" id="total_notif_chat" class="dropdown-toggle" data-toggle="dropdown">

              </a>
              <ul class="dropdown-menu" >
                <li class="header">Chat</li>
                <li>
                  <!-- inner menu: contains the messages -->
                  <ul class="menu"  id="load_notif_chat">
                    
                    <!-- end message -->
                  </ul>
                  <!-- /.menu -->
                </li>
                <li class="footer"><a href="pesan/chat.php">Klik disini untuk memulai</a></li>
              </ul>
            </li>
          <!-- /.messages-menu -->
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-bottom: 10px;">
              <!-- The user image in the navbar-->
              <?php echo Get_profile_image($connect, $_SESSION["user_id"]); ?>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $log['nama_depan']; ?></span>
            </a>
            <ul class="dropdown-menu" style="right: 0%">
              <!-- The user image in the menu -->
              <li class="user-header" style="background-color: #4e48da;">
                <?php echo Get_profile_image2($connect, $_SESSION["user_id"]); ?>

                <p>
                  <?php echo $log['nama_depan']; ?>
                  <small><?php echo $log['tmp_lahir']; ?>  <?php echo tgl_indo($log['tgl_lahir']); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#"><small><?php echo $log["follower_number"];?> Pengikut</small></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"><small><?php echo count_postingan($connect, $log["user_id"]); ?> Post</small></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"><small>Mengikuti <?php echo count_mengikuti($connect, $log["user_id"]); ?></small></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?page=profil" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>