<?php
include ('koneksi.php');
include ('function.php');
session_start();

if(isset($_POST['proses']))
{
  $output = '';
  if($_POST['proses'] == 'view_posting')
  {
    $query = "
    SELECT * FROM postingan 
    INNER JOIN user ON user.user_id = postingan.user_id 
    WHERE postingan.post_id = '".$_POST["post_id"]."' 
    GROUP BY postingan.post_id 
    ORDER BY postingan.post_id DESC

    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if($total_row > 0)
    {
      foreach($result as $row)
      {
        $profile_image = '';
        $post_gambar ='';
        $post_video ='';
        $konten_konten = $row["post_konten"];
        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
        $string = convertToLink($string);
        if($row['profile_image'] != 'user.png')
        {
          if($row['post_gambar'] !='')
          {       
            $post_gambar = '
            <div class="col-md-5 col-xs-12">
              <a class="image-popup-vertical-fit" href="data/posting/images/'.$row["post_gambar"].'">
                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
              </a>
            </div>
            <div class="col-md-7 col-xs-12"> <p style="margin-bottom: 5px; margin-top: 5px;"> '.$string.' </p> </div>
            ';
          }
          else
          {           
            $post_gambar = '
            <div class="col-md-7 col-xs-12"> <p style="margin-bottom: 5px;"> '.$string.' </p> </div>
            ';
          }

          $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
            if($user_last_activity > $current_timestamp)
            {
                $profile_image = '
                <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />
                <span class="profile-status online pull-right"></span>';
            }
            else
            {
                $profile_image = '
                <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />';
            }

          $profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
        }
        else
        {
          if($row['post_gambar'] !='')
          {       
            $post_gambar = '
            <div class="col-md-5 col-xs-12">
              <a class="image-popup-vertical-fit" href="data/posting/images/'.$row["post_gambar"].'">
                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
              </a>
            </div>
            <div class="col-md-7 col-xs-12"> <p style="margin-bottom: 5px; margin-top: 5px;"> '.$string.' </p> </div>
            ';
          }
          else
          {           
            $post_gambar = '
            <div class="col-md-7 col-xs-12"> <p style="margin-bottom: 5px;"> '.$string.' </p> </div>
            ';
          }

          $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
            if($user_last_activity > $current_timestamp)
            {
                $profile_image = '
                <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
                <span class="profile-status online pull-right"></span>';
            }
            else
            {
                $profile_image = '
                <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
            }
            
          $profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
        }

        $like_button = '';
        if(!is_user_has_already_like_content($connect, $_SESSION["user_id"], $row["post_id"]))
          {
            $like_button = '
            <button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
            ';
          }
          else
          {
            $like_button = '
            <button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
            ';
          }

        $output .= '
                        <div class="sl-item">
                            <div class="sl-left"> '.$profile_image.' </div>
                            <div class="sl-right">
                                <div> <a href="view_profil.php?data='.$row['user_id'].'" class="link">'.$row["nama_depan"].' '.strip_tags($row["nama_belakang"]).'</a>
                                  <p style="margin-bottom: 5px;"><span class="sl-date">'.tgl_ago($row["post_tgl"]).'</span></p>
                                    <div class="m-t-20 row" style="margin-top: 5px;">
                                      '.$post_gambar.'
                                    </div>
                                    <div class="like-comm m-t-20" style="margin-top: 10px;">
                                      '.$like_button.'
                                      <button type="button" class="btn btn-link post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="fa fa-comments-o" style="font-size: 18px;"></i> '.count_comment($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
                                      <button type="button" class="btn btn-link"> <i class="fa fa-retweet" style="font-size: 18px;"></i> </button>
                                      <!-- /.<p><span class="sl-date">suka</span></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
<div id="comment_form'.$row["post_id"].'" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
        <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
            <div class="modal-header" style="padding-bottom: 5px;">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.$row["nama_depan"].' '.strip_tags($row["nama_belakang"]).'  <small class="m-b-10 text-muted">'.count_comment($connect, $row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            
            <div class="modal-body" style="position: relative; padding: 0px; overflow-y: scroll; height: 100%; background-color: aliceblue;">
              <div class="comment-widgets" id="old_comment'.$row["post_id"].'" style="margin-bottom: 100px;">

                </div>
            </div>
            <form action="javascript:void(0)" method="post">
                <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left;">
                    <textarea class="form-control" type="text" name="comment" id="comment'.$row["post_id"].'" rows="2" placeholder="Tulis komentarmu ..."  style="border-radius: 9px;"></textarea>
                    <button type="submit" name="submit_comment" class="btn btn-info waves-effect waves-light submit_comment"><i class="mdi mdi-send"> </i></button>
                </div>
            </form>
        </div>
    </div>
</div>
                    <hr>
        ';
      }
    }
    else
    {
      $output = '';
    }
    echo $output; 
  }



  if($_POST["proses"] == "like")
  {
    $query = "
    SELECT * FROM like_post 
    WHERE post_id = '".$_POST["post_id"]."' 
    AND user_id = '".$_SESSION["user_id"]."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();

    $total_row = $statement->rowCount();

    if($total_row > 0)
    {
      $insert_query = "
      DELETE FROM like_post 
      WHERE user_id=".$_SESSION["user_id"]." AND post_id=".$_POST["post_id"]."
      ";

      $statement = $connect->prepare($insert_query);

      $statement->execute();

      echo 'Unlike';
    }
    else
    {
      $insert_query = "
      INSERT INTO like_post 
      (user_id, post_id) 
      VALUES ('".$_SESSION["user_id"]."', '".$_POST["post_id"]."')
      ";

      $statement = $connect->prepare($insert_query);

      $statement->execute();

      $notification_query = "
      SELECT user_id, post_konten FROM postingan 
      WHERE post_id = '".$_POST["post_id"]."'
      ";
      $statement = $connect->prepare($notification_query);

      $statement->execute();

      $notification_result = $statement->fetchAll();

      foreach($notification_result as $notification_row)
      {
        
          $notification_text = 'Menyukai ';
          $data = array(
            ':notification_receiver_id' =>  $notification_row['user_id'],
            ':notif_sender_id'      =>  $_SESSION["user_id"],
            ':notif_post_id'      =>  $_POST["post_id"],
            ':notification_text'    =>  $notification_text,
            ':read_notification'    =>  'no',
            ':notif_time'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
            ':notif_update'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
          );

          $insert_query = "
          INSERT INTO pemberitahuan 
            (notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
            VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
          ";
          $statement = $connect->prepare($insert_query);
          $statement->execute($data);
        
      }
    }
  }


  if($_POST["proses"] == 'submit_comment')
  {
    $data = array(
      ':post_id'    =>  $_POST["post_id"],
      ':user_id'    =>  $_SESSION["user_id"],
      ':comment'    =>  strip_tags($_POST["comment"]),
      ':timestamp'  =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
    );
    $query = "
    INSERT INTO komentar 
    (post_id, user_id, comment, timestamp) 
    VALUES (:post_id, :user_id, :comment, :timestamp)
    ";
    $statement = $connect->prepare($query);
    $statement->execute($data);   

    $notification_query = "
    SELECT user_id, post_konten FROM postingan 
    WHERE post_id = '".$_POST["post_id"]."'
    ";
    $statement = $connect->prepare($notification_query);

    $statement->execute();

    $notification_result = $statement->fetchAll();

    foreach($notification_result as $notification_row)
    {
      
        $notification_text = 'Mengomentari ';
        $data = array(
            ':notification_receiver_id' =>  $notification_row['user_id'],
            ':notif_sender_id'      =>  $_SESSION["user_id"],
            ':notif_post_id'      =>  $_POST["post_id"],
            ':notification_text'    =>  $notification_text,
            ':read_notification'    =>  'no',
            ':notif_time'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
            ':notif_update'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
          );

          $insert_query = "
          INSERT INTO pemberitahuan 
            (notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
            VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
          ";
        $statement = $connect->prepare($insert_query);
        $statement->execute($data);      
    }
  }


  if($_POST["proses"] == "fetch_comment")
  {
    $query = "
    SELECT * FROM komentar 
    INNER JOIN user 
    ON user.user_id = komentar.user_id 
    WHERE post_id = '".$_POST["post_id"]."' 
    ORDER BY comment_id ASC
    ";
    $statement = $connect->prepare($query);
    $output = '';
    if($statement->execute())
    {
      $result = $statement->fetchAll();
      foreach($result as $row)
      {
        $profile_image = '';
        if($row['profile_image'] != 'user.png')
        {
          $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" width="50">';
        }
        else
        {
          $profile_image = '<span class="round" style="width: 35px; height: 35px; line-height: 35px;">'.substr($row["nama_depan"], 0,1).'</span>';
        }
        $output .= '
            <div class="d-flex no-block comment-row border-top" style="padding-top: 5px; padding-bottom: 0px;">
              <div class="p-2"><span class="round">'.$profile_image.'</span></div>
              <div class="comment-text active w-100" style="padding-left: 15px; padding-bottom: 8px; line-height: 1;">
                  <h5 class="font-medium" style="margin-bottom: 3px;">'.strip_tags($row["comment"]).'</h5>
                  <p class="m-b-10 text-muted" style="margin-bottom: 2px;">'.$row["nama_depan"].' '.strip_tags($row["nama_belakang"]).'</p>
                  <div class="comment-footer">
                      <span class="text-muted pull-right"><small>'.tgl_ago($row["timestamp"]).'</small></span>
                  </div>
              </div>
          </div>
        ';
      }
    }
    echo $output;
  }



  if($_POST["proses"] == "view_profil")
  {
    $query_profil = "
    SELECT * FROM user 
    INNER JOIN kelas ON kelas.kelas_id=user.kelas
    INNER JOIN sekolah ON sekolah.sekolah_id=kelas.sekolah_id
    WHERE user.user_id = '".$_POST["user_id"]."' OR username = '".$_POST["user_id"]."'
    ";

    $statement = $connect->prepare($query_profil);
    $statement->execute();
    $result = $statement->fetchAll();
    $output ='';
    foreach($result as $row)
    {
        if($row['user_id'] != $_SESSION['user_id'])
        {
          $fotoprofil = '';
          if($row['profile_image'] != '')
          {
            $fotoprofil = '<img src="data/akun/profil/'.$row['profile_image'].'" class="img-circle" width="200">';
          }
          else
          {
            $fotoprofil = '<img src="data/akun/profil/user.png" class="img-circle" width="200">';
          }
            $output .= '
            <div class="card-body">
                <center class="m-t-30"> '.$fotoprofil.'
                    <h4 class="card-title m-t-10">'.$row['nama_depan'].' '.strip_tags($row["nama_belakang"]).'</h4>
                    <h6 class="card-subtitle">'.$row['kelas'].'</h6>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4">
                          <font class="font-medium">'.count_pengikut($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link tombol_pengikut">Pengikut</a></p>
                        </div>
                        <div class="col-4">
                          <font class="font-medium">'.count_postingan($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link">Posting</a></p>
                        </div>
                        <div class="col-4">
                          <font class="font-medium">'.count_mengikuti($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link tombol_mengikuti">Mengikuti</a></p>
                        </div>
                    </div>
                    <div class="row text-center">
                      <div class="col-12">
                        '.make_follow_button_profil($connect, $_POST["user_id"], $_SESSION["user_id"]).'
                      </div>
                    </div>
                </center>
            </div>
            <div>
                <hr>
            </div>
            <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
            
            </div>
            ';
        }
        else
        {
          $fotoprofil = '';
          if($row['profile_image'] != '')
          {
            $fotoprofil = '<img src="data/akun/profil/'.$row['profile_image'].'" class="img-circle" width="200">';
          }
          else
          {
            $fotoprofil = '<img src="data/akun/profil/user.png" class="img-circle" width="200">';
          }
          $gender = '';
          if($row['jenis_kelamin'] == 'L')
          { 
            $gender = '
                      <option label="Pilih Jenis Kelamin"></option>
                      <option value="L" selected>Laki-Laki</option>
                      <option value="P">Perempuan</option>
                      '; 
          }
          else if($row['jenis_kelamin'] == 'P')
          { 
            $gender = '
                      <option label="Pilih Jenis Kelamin"></option>
                      <option value="L">Laki-Laki</option>
                      <option value="P" selected>Perempuan</option>
                      '; 
          }
          else
          {
            $gender = '
                      <option label="Pilih Jenis Kelamin"></option>
                      <option value="L">Laki-Laki</option>
                      <option value="P">Perempuan</option>
                      '; 
          }
          $sekolah = '';
      if($row['sekolah'] == 'SMK AL-HIKMAH TAROGONG KALER')
      { 
        $sekolah = '
                  <option label="Pilih Sekolah"></option>
                  <option selected>SMK AL-HIKMAH TAROGONG KALER</option>
                  <option>SMK ASSHIDDIQIYAH GARUT</option>
                  <option>SMK IKA KARTIKA GARUT</option>
                  '; 
      }
      else if($row['sekolah'] == 'SMK ASSHIDDIQIYAH GARUT')
      { 
        $sekolah = '
                  <option label="Pilih Sekolah"></option>
                  <option>SMK AL-HIKMAH TAROGONG KALER</option>
                  <option selected>SMK ASSHIDDIQIYAH GARUT</option>
                  <option>SMK IKA KARTIKA GARUT</option>
                  '; 
      }
      else if($row['sekolah'] == 'SMK IKA KARTIKA GARUT')
      {
        $sekolah = '
                  <option label="Pilih Sekolah"></option>
                  <option>SMK AL-HIKMAH TAROGONG KALER</option>
                  <option>SMK ASSHIDDIQIYAH GARUT</option>
                  <option selected>SMK IKA KARTIKA GARUT</option>
                  '; 
      }
      else
      {
        $sekolah = '
                  <option label="Pilih Sekolah"></option>
                  <option>SMK AL-HIKMAH TAROGONG KALER</option>
                  <option>SMK ASSHIDDIQIYAH GARUT</option>
                  <option>SMK IKA KARTIKA GARUT</option>
                  '; 
      }
      $kelas = '';
      if($row['kelas'] == '10 BDP-1')
      { 
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option selected>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '10 BDP-2')
      { 
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option selected>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '10 TKJ')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option selected>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '10 OTKP')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option selected>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '11 BDP')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option selected>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '11 OTKP')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option selected>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '11 TKJ')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option selected>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '12 BDP')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option selected>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '12 OTKP')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option selected>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
      else if($row['kelas'] == '12 TKJ')
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option selected>12 TKJ</option>
                  '; 
      }
      else
      {
        $kelas = '
                  <option label="Pilih Kelas"></option>
                  <option>10 BDP-1</option>
                  <option>10 BDP-2</option>
                  <option>10 OTKP</option>
                  <option>10 TKJ</option>
                  <option>11 BDP</option>
                  <option>11 OTKP</option>
                  <option>11 TKJ</option>
                  <option>12 BDP</option>
                  <option>12 OTKP</option>
                  <option>12 TKJ</option>
                  '; 
      }
          $output .= '
          <div class="card-body">
                <center class="m-t-30"> '.$fotoprofil.'
                    <h4 class="card-title m-t-10">'.$row['nama_depan'].' '.strip_tags($row["nama_belakang"]).'</h4>
                    <h6 class="card-subtitle">'.$row['sekolah_nama'].'</h6>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4">
                          <font class="font-medium">'.count_pengikut($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link tombol_pengikut">Pengikut</a></p>
                        </div>
                        <div class="col-4">
                          <font class="font-medium">'.count_postingan($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link">Posting</a></p>
                        </div>
                        <div class="col-4">
                          <font class="font-medium">'.count_mengikuti($connect, $row["user_id"]).'</font>
                          <p><a href="javascript:void(0)" class="link tombol_mengikuti">Mengikuti</a></p>
                        </div>
                    </div>
                    <div class="row text-center">
                      <div class="col-12">
                          <button type="button" class="btn waves-effect waves-light btn-block btn-info edit_profilModal">Edit</button>
                      </div>
                    </div>
                </center>
            </div>
            <div>
                <hr>
            </div>
            <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
                <div class="map-box">
                    '.strip_tags($row["alamat"]).'
                </div>
            </div>
<div id="edit_profilModal" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
        <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" style="padding-left: 25px;">Edit Profil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
                      
              <div class="modal-body" style="position: relative; overflow-y: scroll; height: 100%;">
              <form id="form_view_edit_profil" method="post" class="form-material m-t-10" enctype="multipart/form-data">  
                  <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" name="nama_depan" id="nama_depan" value="'.strip_tags($row["nama_depan"]).'" class="form-control" placeholder="Nama Depan">
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" name="nama_belakang" id="nama_belakang" value="'.strip_tags($row["nama_belakang"]).'" class="form-control" placeholder="Nama Belakang">
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                      <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" value="'.strip_tags($row["jenis_kelamin"]).'">                    
                          '.$gender.'
                      </select>
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" name="tmp_lahir" id="tmp_lahir" value="'.strip_tags($row["tmp_lahir"]).'" class="form-control" placeholder="Tempat Lahir">
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" name="tgl_lahir" id="tgl_lahir" value="'.$row["tgl_lahir"].'" class="form-control" placeholder="Tanggal Lahir">
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" name="no_hp" id="no_hp" value="'.strip_tags($row["no_hp"]).'" class="form-control" placeholder="Nomor Handphone">
                  </div>
                  <div class="form-group" style="margin-bottom: 15px;">
                    <textarea name="alamat" id="alamat" row="5" class="form-control" placeholder="Copy lokasi dari Google Map">'.strip_tags($row["alamat"]).'</textarea>
                  </div>
                  <br><br><br>           
              <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left;">
                <input type="hidden" name="proses" value="proses_edit_profil"/>
                  <button type="submit" id="tombol_edit_profil" name="tombol_edit_profil" class="btn btn-info btn-block waves-effect waves-light">Simpan</button>
              </div>
            </form>           
          </div>               
        </div>
    </div>
</div>


<div id="sekolahModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Sekolah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>        
        <form method="post" id="form_data_sekolah" enctype="multipart/form-data" class="form-material m-t-10">
          <div class="modal-body">
            <div class="form-group" style="margin-bottom: 15px;">
            <label style="margin-bottom: 0px;">Nama Sekolah</label>
                <select class="form-control" name="kelas" id="kelas"> 
                  <option label="Pilih Kelas">--Pilih Kelas--</option>
                    '.get_kelas($connect).'
                </select>
            </div>
          </div>        
          <div class="modal-footer">
          <input type="hidden" name="proses" value="proses_data_sekolah"/>
              <button type="submit" id="tombol_data_sekolah" name="tombol_data_sekolah" class="btn btn-info waves-effect pull-right">Simpan</button>
          </div>
        </form>
      </div>         
    </div>
</div>





<div id="akunModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <form method="post" id="form_data_akun" enctype="multipart/form-data" class="form-material m-t-10">
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Username</label>
                  <input type="username" name="username" id="username" readonly value="'.strip_tags($row["username"]).'" class="form-control" placeholder="Username">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Email</label>
                  <input type="email" name="email" id="email" readonly value="'.strip_tags($row["email"]).'" class="form-control" placeholder="ataya1st@gmail.com">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Password</label>
                  <input type="password" name="password" id="password" readonly value="'.strip_tags($row["password"]).'" class="form-control" placeholder="Password">
                </div>
                <hr>
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Password Baru</label>
                  <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="Password Baru">
                </div>        
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Konfirmasi Password Baru</label>
                  <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control" placeholder="Konfirmasi Password Baru">
                </div>       
                <div class="modal-footer">
                <input type="hidden" name="proses" value="proses_data_akun"/>
                    <button type="submit" id="tombol_data_akun" name="tombol_data_akun" class="btn btn-info waves-effect">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>


        <script>
          $("#tgl_lahir").bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        </script>
          ';
        }                
    }
    echo $output;
  }



  if($_POST['proses'] == 'follow')
  {
    $query = "
    INSERT INTO follow 
    (sender_id, receiver_id) 
    VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."')
    ";
    $statement = $connect->prepare($query);
    if($statement->execute())
    {
      $sub_query = "
      UPDATE user SET follower_number = follower_number + 1 WHERE user_id = '".$_POST["sender_id"]."'
      ";
      $statement = $connect->prepare($sub_query);
      $statement->execute();  

      $sub_query2 = "
      UPDATE user SET following_number = following_number + 1 WHERE user_id = '".$_SESSION["user_id"]."'
      ";
      $statement = $connect->prepare($sub_query2);
      $statement->execute();

      $notification_text = 'mulai mengikuti Anda.';
      $data = array(
            ':notification_receiver_id' =>  $notification_row['user_id'],
            ':notif_sender_id'      =>  $_SESSION["user_id"],
            ':notif_post_id'      =>  $_POST["post_id"],
            ':notification_text'    =>  $notification_text,
            ':read_notification'    =>  'no',
            ':notif_time'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
            ':notif_update'       =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
          );

          $insert_query = "
          INSERT INTO pemberitahuan 
            (notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
            VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
          ";

      $statement = $connect->prepare($insert_query);
      $statement->execute($data);    
    }
  }

  if($_POST['proses'] == 'unfollow')
  {
    $query = "
    DELETE FROM follow 
    WHERE sender_id = '".$_POST["sender_id"]."' 
    AND receiver_id = '".$_SESSION["user_id"]."'
    ";
    $statement = $connect->prepare($query);
    if($statement->execute())
    {
      $sub_query = "
      UPDATE user 
      SET follower_number = follower_number - 1 
      WHERE user_id = '".$_POST["sender_id"]."'
      ";
      $statement = $connect->prepare($sub_query);
      $statement->execute();

      $sub_query2 = "
      UPDATE user SET following_number = following_number - 1 WHERE user_id = '".$_SESSION["user_id"]."'
      ";
      $statement = $connect->prepare($sub_query2);
      $statement->execute();

    }
  }


  if($_POST['proses'] == 'view_profil_posting')
  {
    $query = "
    SELECT * FROM postingan 
    INNER JOIN user ON user.user_id = postingan.user_id 
    WHERE user.user_id = '".$_POST["user_id"]."' 
    GROUP BY postingan.post_id 
    ORDER BY postingan.post_id DESC
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if($total_row > 0)
    {
     foreach($result as $row)
      {
        $profile_image = '';
        $post_gambar ='';
        $post_video ='';
        $konten_konten = $row["post_konten"];
        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
        $string = convertToLink($string); 
        if($row['profile_image'] != 'user.png')
        {
          if($row['post_gambar'] !='')
          {       
            $post_gambar = '
                        <div class="col-md-5 col-xs-12">
                    <a href="view_posting.php?data='.$row['post_id'].'">
                      <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
                    </a>
                  </div>
                  <div class="col-md-7 col-xs-12">
                    <p style="margin-bottom: 5px;"> 
                      <a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
                    </p>
                  </div>
                ';
          }
          else
          {           
            $post_gambar = '
            <div class="col-md-7 col-xs-12">
                    <p style="margin-bottom: 5px; color: black;"> 
                      <a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
                    </p>
                  </div>
            ';
          }

          $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
            if($user_last_activity > $current_timestamp)
            {
                $profile_image = '
                <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />
                <span class="profile-status online pull-right"></span>';
            }
            else
            {
                $profile_image = '
                <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />';
            }

          $profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
        }
        else
        {
          if($row['post_gambar'] !='')
          {       
            $post_gambar = '
            <div class="col-md-5 col-xs-12">
                    <a href="view_posting.php?data='.$row['post_id'].'">
                      <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
                    </a>
                  </div>
                  <div class="col-md-7 col-xs-12">
                    <p style="margin-bottom: 5px; color: black;"> 
                      <a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
                    </p>
                  </div>                      
              ';
          }
          else
          {           
            $post_gambar = '
            <div class="col-md-7 col-xs-12">
                    <p style="margin-bottom: 5px; color: black;"> 
                      <a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
                    </p>
                  </div>
            ';
          }

          $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
            if($user_last_activity > $current_timestamp)
            {
                $profile_image = '
                <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
                <span class="profile-status online pull-right"></span>';
            }
            else
            {
                $profile_image = '
                <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
            }
            
          $profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
        }

        $like_button = '';
        if(!is_user_has_already_like_content($connect, $_SESSION["user_id"], $row["post_id"]))
          {
            $like_button = '
            <button type="button" class="btn btn-secondary like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 15px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
            ';
          }
          else
          {
            $like_button = '
            <button type="button" class="btn btn-secondary like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 15px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
            ';
          }

        $output .= '
                        <div class="sl-item">
                            <div class="sl-left"> '.$profile_image.' </div>
                            <div class="sl-right">
                                <div> <a href="view_posting.php?data='.$row['post_id'].'" class="link">'.$row["nama_depan"].' '.strip_tags($row["nama_belakang"]).'</a>
                                  <p style="margin-bottom: 5px;"><span class="sl-date">'.tgl_ago($row["post_tgl"]).'</span></p>
                                    <div class="m-t-20 row" style="margin-top: 5px;">
                                      '.$post_gambar.'
                                    </div>
                                    <div class="like-comm m-t-20" style="margin-top: 10px;">
                                      '.$like_button.'
                                      <button type="button" class="btn btn-secondary post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="ti-comments" style="font-size: 15px;"></i> '.count_comment($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
                                      <button type="button" class="btn btn-secondary"> <i class="fa fa-retweet" style="font-size: 15px;"></i> </button>
                                      <!-- /.<p><span class="sl-date">suka</span></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
<div id="comment_form'.$row["post_id"].'" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
        <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
            <div class="modal-header" style="padding-bottom: 5px;">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.$row["nama_depan"].' <small class="m-b-10 text-muted">'.count_comment($connect, $row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            
            <div class="modal-body" style="position: relative; padding: 0px; overflow-y: scroll; height: 100%; background-color: aliceblue;">
              <div class="comment-widgets" id="old_comment'.$row["post_id"].'" style="margin-bottom: 100px;">

                </div>
            </div>
            <form action="javascript:void(0)" method="post">
                <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left;">
                    <textarea class="form-control" type="text" name="comment" id="comment'.$row["post_id"].'" rows="2" placeholder="Tulis komentarmu ..."  style="border-radius: 9px;"></textarea>
                    <button type="submit" name="submit_comment" class="btn btn-info waves-effect waves-light submit_comment"><i class="mdi mdi-send"> </i></button>
                </div>
            </form>
        </div>
    </div>
</div>
                    <hr>
        ';
      }
    }
    else
    {
      $output = '';
    }
    echo $output; 
  }


  if($_POST['proses'] == 'proses_edit_profil')
  {
    $data = array(
      ':nama_depan'     =>  $_POST["nama_depan"],
      ':nama_belakang'  =>  $_POST["nama_belakang"],
      ':jenis_kelamin'  =>  $_POST["jenis_kelamin"],
      ':tmp_lahir'      =>  $_POST["tmp_lahir"],
      ':tgl_lahir'      =>  $_POST["tgl_lahir"],
      ':no_hp'          =>  $_POST["no_hp"],
      ':sekolah'        =>  $_POST["sekolah"],
      ':kelas'          =>  $_POST["kelas"],
      ':alamat'         =>  $_POST["alamat"],
      ':user_id'        =>  $_SESSION["user_id"]
    );

  $query = '
  UPDATE user SET nama_depan = :nama_depan, nama_belakang = :nama_belakang, jenis_kelamin = :jenis_kelamin, tmp_lahir = :tmp_lahir, tgl_lahir = :tgl_lahir, no_hp = :no_hp, sekolah = :sekolah, alamat = :alamat, kelas = :kelas WHERE user_id = :user_id
  ';
   
    $statement = $connect->prepare($query);
    $statement->execute($data);
  }


  if($_POST['proses'] == 'pengaturan')
  {
    if($_POST["user_id"] != $_SESSION["user_id"])
    {
      echo '';
    }
    else
    {
      echo '
      <li class="nav-item dropdown u-pro">
        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.Get_profile_image($connect, $_SESSION["user_id"]).' <span class="hidden-md-down"> '.Get_nama_user($connect, $_SESSION["user_id"]).' &nbsp;<i class="fa fa-angle-down"></i></span> </a>
        <div class="dropdown-menu dropdown-menu-right animated flipInY">
            <a href="javascript:void(0)" class="dropdown-item" style="padding-top: 0px; padding-bottom: 0px;"><i class="ti-user"></i><label for="upload_fotoprofil">&nbsp; Ganti Foto Profil </label></a>
            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-image"></i>&nbsp; Ganti Background</a>
            <a href="javascript:void(0)" class="dropdown-item tombol_sekolahModal"><i class="mdi mdi-projector-screen"></i>&nbsp; Sekolah</a>
            <a href="javascript:void(0)" class="dropdown-item akunModal"><i class="mdi mdi-account-key"></i>&nbsp; Pengaturan Akun</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
        </div>
    </li>
    ';
    }
  }



  if($_POST['proses'] == 'proses_data_sekolah')
  {
    $data = array(
      ':kelas'          =>  $_POST["kelas"],
      ':user_id'        =>  $_SESSION["user_id"]
    );
    $query = '
    UPDATE user SET kelas = :kelas WHERE user_id = :user_id
    ';     
    $statement = $connect->prepare($query);
    $statement->execute($data);
  }

  if($_POST['proses'] == 'pengikut')
  {
        $query = "
        SELECT * FROM user 
        INNER JOIN follow 
        ON follow.receiver_id = user.user_id 
        WHERE follow.sender_id = '".$_POST["user_id"]."'
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
          $profile_image = '';
          if($row['profile_image'] != 'user.png')
          {
            $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle">';
          }
          else
          {
            $profile_image = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["nama_depan"], 0,1).'</span>';
          }
          $tombol = '';
          if($row["user_id"] != $_SESSION["user_id"])
          {
            $output .= '
          <a href="javascript:void(0)">
              <div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
              <div class="mail-contnet" style="width: 80%;">
                  <h5>'.$row["nama_depan"].' <span class="time pull-right">'.make_follow_button_list($connect, $row["user_id"], $_SESSION["user_id"]).'</span></h5>
                  <span class="mail-desc">
                    '.$row["sekolah"].'
                  </span>                 
              </div>
          </a>';
          }
          else
          {
            $output .= '
          <a href="javascript:void(0)">
              <div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
              <div class="mail-contnet" style="width: 80%;">
                  <h5>'.$row["nama_depan"].' <span class="time pull-right"> </span></h5>
                  <span class="mail-desc">
                    '.$row["sekolah"].'
                  </span>                 
              </div>
          </a>';
          }
          
        }
        echo $output;
  }


  if($_POST['proses'] == 'mengikuti')
  {
        $query = "
        SELECT * FROM user 
        INNER JOIN follow 
        ON follow.sender_id = user.user_id 
        WHERE follow.receiver_id = '".$_POST["user_id"]."'
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
          $profile_image = '';
          if($row['profile_image'] != 'user.png')
          {
            $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle">';
          }
          else
          {
            $profile_image = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["nama_depan"], 0,1).'</span>';
          }
          $tombol = '';
          if($row["user_id"] != $_SESSION["user_id"])
          {
            $output .= '
          <a href="javascript:void(0)">
              <div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
              <div class="mail-contnet" style="width: 80%;">
                  <h5>'.$row["nama_depan"].' <span class="time pull-right">'.make_follow_button_list($connect, $row["user_id"], $_SESSION["user_id"]).'</span></h5>
                  <span class="mail-desc">
                    '.$row["sekolah"].'
                  </span>                 
              </div>
          </a>';
          }
          else
          {
            $output .= '
          <a href="javascript:void(0)">
              <div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
              <div class="mail-contnet" style="width: 80%;">
                  <h5>'.$row["nama_depan"].' <span class="time pull-right"> </span></h5>
                  <span class="mail-desc">
                    '.$row["sekolah"].'
                  </span>                 
              </div>
          </a>';
          }
          
        }
        echo $output;
  }






  if($_POST['proses'] == 'proses_data_akun')
  {





  }



}
?>