<header class="main-header">
  <nav class="navbar navbar-static-top" style="background-color: #4e48da;">
    <div class="container">
      <div class="navbar-custom-menu pull-left">
        <ul class="nav navbar-nav">
          <li><a href="javascript: history.go(-1)"><i class="fa fa-arrow-left"></i></a></li>
            <li class="user user-menu">
            <a href="#" style="padding-bottom: 10px; padding-top: 10px; padding-left: 5px;">
              <?php echo Get_profile_komen2($connect, $_SESSION["user_id"]); ?>
            </a>
            </li>
        </ul>
      </div>
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>

<div class="content-wrapper"  style="padding-top: 58px; padding-bottom: 58px; background-color: white;">
    <div class="container" style="padding-left: 0px; padding-right: 0px;">
        <div class="row" style="margin-right: -5px; margin-left: -5px;">
          <div class="box box-primary" style="margin-bottom: 0px; border-top-width: 0px;">
              <div class="box-header with-border">
                <div class="has-feedback">
                    <input type="search" id="cari_kontak" name="cari_kontak" class="form-control input-sm" placeholder="Cari" aria-label="Search" autocomplete="off">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                  </div>
              </div>
              <div class="box-body" style="padding-left: 20px; padding-right: 20px;">
                <ul class="contacts-list" id="chat_list">

                </ul>
              </div>
            </div>
        </div>
    </div>
</div>