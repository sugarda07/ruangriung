<?php

include('../inc/koneksi.php');
session_start();

  $output='';
 $query = "
    SELECT * FROM user
    WHERE user_id != '".$_SESSION["user_id"]."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_rows= $statement->rowCount();
 if($total_rows > 0)
 {
  foreach($result as $row)
    {
      $profile_image = '';
      if($row['profile_image'] != '')
      {
        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
        if($user_last_activity > $current_timestamp)
        {
          $profile_image = '<img class="contacts-list-img img-bordered-sm" src="../images/profile_image/'.$row["profile_image"].'" alt="User Image">';
        }
        else
        {
          $profile_image = '<img class="contacts-list-img" src="../images/profile_image/'.$row['profile_image'].'" alt="User Image">';
        }        
      }
      else
      {
        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
        if($user_last_activity > $current_timestamp)
        {
          $profile_image = '<img class="contacts-list-img img-bordered-sm" src="../images/profile_image/user.png" alt="User Image">';
        }
        else
        {
          $profile_image = '<img class="contacts-list-img" src="../images/profile_image/user.png" alt="User Image">';
        }
      }
 
      $sub_query = "
      SELECT * FROM chat_message
      WHERE (from_user_id = '".$_SESSION["user_id"]."' 
      AND to_user_id = '".$row['user_id']."') 
      OR (from_user_id = '".$row['user_id']."' 
      AND to_user_id = '".$_SESSION["user_id"]."') 
      ORDER BY timestamp DESC
      LIMIT 1
      ";
      $statement = $connect->prepare($sub_query);
      $statement->execute();
      $result_chat = $statement->fetchAll();
      foreach($result_chat as $data)
      {
        if($data["from_user_id"] == $row['user_id'] )
        { 
          $status_pesan = '';
          if($data["status"] == '0')
          {          
            $status_pesan = ''.strip_tags(substr($data['chat_konten'], 0, 12)).'';
          }
          if($data["status"] == '1')
          {          
            $status_pesan = ''.strip_tags(substr($data['chat_konten'], 0, 12)).'';
          }
          if($data["status"] == '2')
          {          
            $status_pesan = '<small><span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em></small>';
          }    
        }
        else
        {
          $status_pesan = '';
          if($data["status"] == '0')
          {          
            $status_pesan = '<small><span class="fa fa-check-square-o text-primary"></span></small> '.strip_tags(substr($data['chat_konten'], 0, 12)).'';
          }
          if($data["status"] == '1')
          {          
            $status_pesan = '<small><span class="fa fa-check"></span></small> '.strip_tags(substr($data['chat_konten'], 0, 12)).'';
          }
          if($data["status"] == '2')
          {          
            $status_pesan = '<small><span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em></small>';
          }
        }

      $output .= '

            <li>
              <a href="#" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'" data-foto="../images/profile_image/'.$row['profile_image'].'">
                '.$profile_image.'
                <div class="contacts-list-info">
                      <span class="contacts-list-name" style="color: #230069;">
                        '.$row["nama_depan"].'
                        <small class="contacts-list-date pull-right" style="color: #687b8e;">'.tgl_ago2($data["timestamp"]).'</small>
                      </span>
                  <span class="contacts-list-msg" style="color: #818c97;">'.$status_pesan.' '.fetch_is_type_status($row['user_id'], $connect).'
                  <small class="contacts-list-date pull-right" style="color: #42ef0a;"><span>'.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).'</span></small>
                  </span>
                </div>
              </a>
            </li>
      ';    
    }
  }
    echo $output;
 }
 else
 {
  $output = 'Nobody has share nothing';
 }


?>