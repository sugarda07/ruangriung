<?php

class Koneksi
{
	var $host;
	var $username;
	var $password;
	var $database;
	var $connect;
	var $home_page;
	var $query;
	var $data;
	var $statement;
	var $filedata;

	function __construct()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->host = 'localhost';
		//$this->username = 'root';
		//$this->password = '';
		//$this->database = 'ruangdigital2';
		$this->username = 'smkikaka_sugarda';
		$this->password = 'sugarda69753308';
		$this->database = 'smkikaka_ruangriung';

		$this->home_page = 'http://localhost/ruangdigital/';

		$this->connect = new PDO("mysql:host=$this->host; dbname=$this->database;charset=utf8mb4", "$this->username", "$this->password");

		session_start();
	}

	function execute_query()
	{
		$this->statement = $this->connect->prepare($this->query);
		$this->statement->execute($this->data);
	}

	function total_row()
	{
		$this->execute_query();
		return $this->statement->rowCount();
	}

	function send_email($receiver_email, $subject, $body)
	{
		$mail = new PHPMailer;

		$mail->IsSMTP();

		$mail->Host = 'smtp host';

		$mail->Port = '587';

		$mail->SMTPAuth = true;

		$mail->Username = '';

		$mail->Password = '';

		$mail->SMTPSecure = '';

		$mail->From = 'ataya1st@gmail.com';

		$mail->FromName = 'ataya1st@gmail.com';

		$mail->AddAddress($receiver_email, '');

		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();		
	}

	function redirect($page)
	{
		header('location:'.$page.'');
		exit;
	}

	function admin_session_private()
	{
		if(!isset($_SESSION['admin_id']))
		{
			$this->redirect('login.php');
		}
	}

	function admin_session_public()
	{
		if(isset($_SESSION['admin_id']))
		{
			$this->redirect('index.php');
		}
	}

	function query_result()
	{
		$this->execute_query();
		return $this->statement->fetchAll();
	}

	function clean_data($data)
	{
	 	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	function Get_topik_id($code)
	{
		$this->query = "
		SELECT topik_id FROM topik_quiz
		WHERE topik_code = '$code'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['topik_id'];
		}
	}

	function Get_ujian_id($code)
	{
		$this->query = "
		SELECT ujian_id FROM ujian
		WHERE ujian_code = '$code'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['ujian_id'];
		}
	}

	function  number_to_str($number)
	{
		$convertion = [1=>'a', 2 =>'b', 3=>'c', 4=>'d', 5=>'e'];
        $array_data = str_split($number);
        $new_data   = '';
        foreach ($array_data as  $value) {
            $new_data .= $convertion[$value]."";
        }
        return $new_data;
	}

	function str_to_number($string)
	{
		$convertion = ['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4, 'e'=>5];
        $string     = strtolower($string);
        $array_data = str_split($string);
        $new_data   = '';
        foreach ($array_data as  $value) {
            $new_data .= $convertion[$value]."";
        }
        return $new_data;
	}

	function kelasujian_list()
	{
		$this->query = "
		SELECT kelas_id, kelas_nama, kelas_jurusan, kelas_sekolah
		FROM kelas
		";
		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value="'.$row["kelas_id"].'">'.$row["kelas_nama"].' - '.$row["kelas_jurusan"].' - '.$row["kelas_sekolah"].'</option>';
		}
		return $output;
	}

	function Get_batas_soal($ujian_id)
	{
		$this->query = "
		SELECT ujian_jumlah_soal FROM ujian
		WHERE ujian_id = '$ujian_id'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['ujian_jumlah_soal'];
		}
	}

	function Get_jumlah_soal($ujian_id)
	{
		$this->query = "
		SELECT soal_id FROM soal
		WHERE soal_ujian_id = '$ujian_id'
		";

		return $this->total_row();
	}

	function Batas_jumlah_soal($ujian_id)
	{
		$batas_soal = $this->Get_batas_soal($ujian_id);

		$jumlah_soal = $this->Get_jumlah_soal($ujian_id);

		if($jumlah_soal >= $batas_soal)
		{
			return false;
		}
		return true;
	}

	function jumlah_materi_id($user_id, $materi_id)
	{
		$this->query = "
		SELECT * FROM materi
		INNER JOIN kelasmateri ON kelasmateri.kelasmateri_materi_id = materi.materi_id
		INNER JOIN user ON user.user_kelas_id = kelasmateri.kelasmateri_kelas_id
		WHERE  user.user_id = '$user_id' AND materi_mapel_id = '$materi_id'
		GROUP BY materi_id
		";

		return $this->total_row();
	}

	function jumlah_soal($ujian_id)
	{
		$this->query = "
		SELECT soal_id FROM soal
		WHERE soal_ujian_id = '$ujian_id'
		";

		return $this->total_row();
	}

	function jumlah_soal_quiz($topik_id)
	{
		$this->query = "
		SELECT pilgan_id FROM soal_pilihan_ganda
		WHERE pilgan_topik_id = '$topik_id'
		";

		return $this->total_row();
	}

	function jumlah_kelasmateri($materi_id)
	{
		$this->query = "
		SELECT kelasmateri_kelas_id FROM kelasmateri
		WHERE kelasmateri_materi_id = '$materi_id'
		";

		return $this->total_row();
	}

	function get_jumlah_siswa_kelas($kelas_id)
	{
		$this->query = "
		SELECT * FROM user
		INNER JOIN kelas ON kelas.kelas_id=user.user_kelas_id
		WHERE user.user_kelas_id = '$kelas_id'
		";

		return $this->total_row();
	}

	function execute_question_with_last_id()
	{
		$this->statement = $this->connect->prepare($this->query);

		$this->statement->execute($this->data);

		return $this->connect->lastInsertId();
	}

	function execute_with_last_id()
	{
		$this->statement = $this->connect->prepare($this->query);

		$this->statement->execute($this->data);

		return $this->connect->lastInsertId();
	}


	function Upload_file()
	{
		if(!empty($this->filedata['name']))
		{
			$extension = pathinfo($this->filedata['name'], PATHINFO_EXTENSION);

			$new_name = uniqid() . '.' . $extension;

			$_source_path = $this->filedata['tmp_name'];

			$target_path = 'data/akun/profil/' . $new_name;

			move_uploaded_file($_source_path, $target_path);

			return $new_name;
		}
	}

	function Upload_file_pilgan()
	{
		if(!empty($this->filedata['name']))
		{
			$extension = pathinfo($this->filedata['name'], PATHINFO_EXTENSION);

			$new_name = uniqid() . '.' . $extension;

			$_source_path = $this->filedata['tmp_name'];

			$target_path = 'dokumen/gambar/' . $new_name;

			move_uploaded_file($_source_path, $target_path);

			return $new_name;
		}
	}

	function user_session_private()
	{
		if(!isset($_SESSION['user_id']))
		{
			$this->redirect('login.php');
		}
	}

	function user_session_public()
	{
		if(isset($_SESSION['user_id']))
		{
			$this->redirect('index.php');
		}
	}

	function If_user_konfirmasi($ujian_id, $user_id)
	{
		$this->query = "
		SELECT * FROM user_konfirmasi
		WHERE konfirmasi_ujian_id = '$ujian_id' 
		AND konfirmasi_user_id = '$user_id'
		";
		if($this->total_row() > 0)
		{
			return true;
		}
		return false;
	}

	function Get_jawaban_user($soal_id, $user_id)
	{
		$this->query = "
		SELECT jawaban_pilihan_user FROM jawaban 
		WHERE jawaban_soal_id = '$soal_id' 
		AND jawaban_user_id = '$user_id'
		";
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["jawaban_pilihan_user"];
		}
	}

	function Get_nilai_benar($ujian_id)
	{
		$this->query = "
		SELECT nilai_benar FROM ujian
		WHERE ujian_id = '$ujian_id' 
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['nilai_benar'];
		}
	}

	function Get_nilai_salah($ujian_id)
	{
		$this->query = "
		SELECT nilai_salah FROM ujian
		WHERE ujian_id = '$ujian_id' 
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['nilai_salah'];
		}
	}

	function Get_kunci_jawaban($soal_id)
	{
		$this->query = "
		SELECT soal_kunci FROM soal
		WHERE soal_id = '$soal_id' 
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['soal_kunci'];
		}
	}

	function status_ujian_user($ujian_id, $user_id)
	{
		$this->query = "
		SELECT konfirmasi_status
		FROM user_konfirmasi
		WHERE konfirmasi_ujian_id = '$ujian_id' 
		AND konfirmasi_user_id = '$user_id'
		";
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["konfirmasi_status"];
		}
	}

	function Get_foto_status($user_id)
	{
		$this->query = "
		SELECT user_foto, user_nama_depan FROM user 
		WHERE user_id = '$user_id'
		";  
		$result = $this->query_result();
		$foto_profil = '';
		foreach($result as $row)
		{
			if($row["user_foto"] == 'user.png')
			{
				$foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';				
			}
			else
			{
				$foto_profil = '<img src="data/akun/profil/'.$row['user_foto'].'" alt="user" class="img-circle"/>';				
			}
			return $foto_profil;
		}
	}

	function Get_nama_user($user_id)
	{
		$this->query = "
		SELECT user_nama_depan FROM user 
		WHERE user_id = '$user_id'
		";  
		$result = $this->query_result();
		$foto_profil = '';
		foreach($result as $row)
		{
			return $row['user_nama_depan'];
		}
	}

	function convertToLink($string)  
	{    
		$string = preg_replace("/#+([a-zA-Z0-9_]+)/", '<a href="javascript:void(0)">$0</a>', $string); 
		$string = preg_replace("/@+([a-zA-Z0-9_]+)/", '<a href="javascript:void(0)" class="hover" id="$1">$0</a>', $string); 
		return $string;  
	}

	function fetch_user_last_activity($user_id)
	{
		$this->query = "
		SELECT * FROM login_details 
		WHERE user_id = '$user_id' 
		ORDER BY last_activity DESC 
		LIMIT 1
		";
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row['last_activity'];
		}
	}

	function is_user_has_already_like_content($user_id, $post_id)
	{
		$this->query = "
		SELECT * FROM like_post 
		WHERE post_id = '$post_id'
		AND user_id = '$user_id'
		";

		if($this->total_row() > 0)
		{
			return true;
		}
		return false;
	}

	function count_total_post_like($post_id)
	{
		$this->query = "
		SELECT * FROM like_post
		WHERE post_id = '$post_id'
		";
		
		return $this->total_row();
	}

	function count_comment($post_id)
	{
		$this->query = "
		SELECT * FROM komentar 
		WHERE post_id = '$post_id'
		";

		return $this->total_row();
	}

	function Get_post_id($post_id)
	{
		$this->query = "
		SELECT post_id FROM postingan 
		WHERE post_id = '$post_id'
		";  
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["post_id"];
		}
	}

	function Get_user_id($data)
	{
		$this->query = "
		SELECT user_id FROM user 
		WHERE user_verfication_code = '$data'
		";  
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["user_id"];
		}
	}

	function Get_code_user($user_id)
	{
		$this->query = "
		SELECT user_verfication_code FROM user 
		WHERE user_id = '$user_id'
		";  
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["user_verfication_code"];
		}
	}

	function get_sekolah($user_id)
	{
		$this->query = "
		SELECT * FROM kelas 
		INNER JOIN user ON user.user_kelas_id=kelas.kelas_id
		WHERE user.user_id = '$user_id'
		";
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["kelas_sekolah"];
		}
	}

	function make_follow_button_list($sender_id, $receiver_id)
	{
		$this->query = "
		SELECT * FROM follow 
		WHERE sender_id = '$sender_id' 
		AND receiver_id = '$receiver_id'
		";
		$result = $this->query_result();

		$output = '';
		if($this->total_row() > 0)
		{
			$output = '<button type="button" class="btn btn-link action_button disabled" name="follow_button" type="button" data-action="unfollow" data-sender_id="'.$sender_id.'">Diikuti</button>';
		}
		else
		{
			$output = '<button type="button" class="btn btn-info action_button disabled" name="follow_button" type="button" data-action="follow" data-sender_id="'.$sender_id.'">Ikuti</button>';
		}
		return $output;
	}

	function count_pengikut($user_id)
	{
		$this->query = "
		SELECT * FROM user 
		INNER JOIN follow 
		ON follow.receiver_id = user.user_id 
		WHERE follow.sender_id = '$user_id'
		";
		
		return $this->total_row();
	}

	function count_mengikuti($user_id)
	{
		$this->query = "
		SELECT * FROM user 
		INNER JOIN follow 
		ON follow.sender_id = user.user_id 
		WHERE follow.receiver_id = '$user_id'
		";
		
		return $this->total_row();
	}

	function count_postingan($user_id)
	{
		$this->query = "
		SELECT * FROM postingan
		WHERE user_id = '$user_id'
		";
		
		return $this->total_row();
	}

	function make_follow_button_profil($sender_id, $receiver_id)
	{
		$this->query = "
		SELECT * FROM follow 
		WHERE sender_id = '$sender_id' 
		AND receiver_id = '$receiver_id'
		";
		$result = $this->query_result();

		$total_row = $this->total_row();

		$output = '';

		if($total_row > 0)
		{
			$output = '<button type="button" name="follow_button" class="btn btn-secondary btn-block waves-effect waves-light action_button" data-action="unfollow" data-sender_id="'.$sender_id.'"> Diikuti</button>';
		}
		else
		{
			$output = '<button type="button" name="follow_button" class="btn btn-info btn-block waves-effect waves-light action_button" data-action="follow" data-sender_id="'.$sender_id.'"> Ikuti</button>';
		}
		return $output;
	}

	function get_kelas()
	{
		$this->query = "
		SELECT kelas_id, kelas_nama, kelas_jurusan, kelas_sekolah FROM kelas
		";
		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value="'.$row['kelas_id'].'">'.$row['kelas_sekolah'].' - '.$row['kelas_jurusan'].' - '.$row['kelas_nama'].'</option>';
		}
		return $output;
	}

	function mapel_list()
	{
		$this->query = "
		SELECT mapel_id, mapel_nama FROM mapel
		";
		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value="'.$row['mapel_id'].'">'.$row['mapel_nama'].'</option>';
		}
		return $output;
	}

	function get_nama_lengkap($user_id)
	{
		$this->query = "
		SELECT user_nama_depan, user_nama_belakang FROM user
		WHERE user_id = '$user_id'
		";
		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= ''.$row['user_nama_depan'].' '.$row['user_nama_belakang'].'';
		}
		return $output;
	}

	function fetch_is_type_status($user_id)
	{
		$this->query = "
		SELECT is_type FROM login_details 
		WHERE user_id = '$user_id' 
		ORDER BY last_activity DESC 
		LIMIT 1
		";  
		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			if($row["is_type"] == 'yes')
			{
			$output = '<span class="text-muted"><em> sedang mengetik...</em></span>';
			}
		}
		return $output;
	}

	function count_unseen_message($from_user_id, $to_user_id)
	{
		$this->query = "
		SELECT * FROM chat_message 
		WHERE from_user_id = '$from_user_id' 
		AND to_user_id = '$to_user_id' 
		AND status = '1'
		";
		$count = $this->total_row();
		$output = '';
		if($count > 0)
		{
			$output = '<span class="label label-success">'.$count.'</span>';
		}
		return $output;
	}


	function tgl_ago($timestamp)  
	{  
		$time_ago = strtotime($timestamp);  
		$current_time = time();  
		$time_difference = $current_time - $time_ago;  
		$seconds = $time_difference;  
		$minutes      = round($seconds / 60 );           // value 60 is seconds  
		$hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
		$days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
		$weeks          = round($seconds / 604800);          // 7*24*60*60;  
		$months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
		$years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
		if($seconds <= 60)  
		{  
			return "Baru saja";  
		}  
		else if($minutes <=60)  
		{  
			if($minutes==1)  
			{  
				return "1 menit yang lalu";  
			}  
			else  
			{  
				return "$minutes menit yang lalu";  
			}  
		}  
		else if($hours <=24)  
		{  
			if($hours==1)  
			{  
				return "1 jam yang lalu";  
			}  
			else  
			{  
				return "$hours jam yang lalu";  
			}  
		}  
		else if($days <= 7)  
		{  
			if($days==1)  
			{  
				return "kemarin";  
			}  
			else  
			{  
				return "$days hari yang lalu";  
			}  
		}  
		else  
		{
			return date('d F Y', strtotime($timestamp));
		}  
	}

	function tgl_indo($tgl)
	{
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;     
	}

	function getBulan($bln)
	{
		switch ($bln)
		{
			case 1: 
			  return "Januari";
			  break;
			case 2:
			  return "Februari";
			  break;
			case 3:
			  return "Maret";
			  break;
			case 4:
			  return "April";
			  break;
			case 5:
			  return "Mei";
			  break;
			case 6:
			  return "Juni";
			  break;
			case 7:
			  return "Juli";
			  break;
			case 8:
			  return "Agustus";
			  break;
			case 9:
			  return "September";
			  break;
			case 10:
			  return "Oktober";
			  break;
			case 11:
			  return "November";
			  break;
			case 12:
			  return "Desember";
			  break;
		}
	}

	function Get_user_foto_chat($user_id)
	{
		$this->query = "
		SELECT user_foto FROM user 
		WHERE user_id = '$user_id'
		";  
		$result = $this->query_result();
		foreach($result as $row)
		{
			return $row["user_foto"];
		}
	}

	function convertToLinkpesan($string)  
	{    
		$string = preg_replace("/#+([a-zA-Z0-9_]+)/", '<a href="javascript:void(0)" style="color:blue;">$0</a>', $string); 
		$string = preg_replace("/@+([a-zA-Z0-9_]+)/", '<a href="javascript:void(0)" class="hover" id="$1" style="color:blue;">$0</a>', $string); 
		return $string;  
	}

	function Get_foto($from_user_id, $to_user_id)
	{
		$this->query = "
		SELECT user_foto, user_nama_depan FROM user 
		WHERE user_id = '".$to_user_id."'
		";  
		$result = $this->query_result();
		$foto_profil = '';
		foreach($result as $row)
		{
			if($row["user_foto"] == 'user.png')
			{
				$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				$user_last_activity = $this->fetch_user_last_activity($to_user_id);
				if($user_last_activity > $current_timestamp)
				{
					$foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
					<span class="profile-status online pull-right"></span>
					<span class="username" style="color: white;">
					'.$row["user_nama_depan"].'
					</span>&nbsp;
					';
				}
				else
				{
					$foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
					<span class="username" style="color: white;">
					'.$row["user_nama_depan"].'
					</span>&nbsp;';
				}
			}
			else
			{
				$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				$user_last_activity = $this->fetch_user_last_activity($to_user_id);
				if($user_last_activity > $current_timestamp)
				{
					$foto_profil = '<img src="../data/akun/profil/'.$row['user_foto'].'" alt="user" class="img-circle"/>
					<span class="profile-status online pull-right"></span>
					<span class="username"  style="color: white;">
					'.$row["user_nama_depan"].'
					</span>&nbsp;';
				}
				else
				{
					$foto_profil = '<img src="../data/akun/profil/'.$row['user_foto'].'" alt="user" class="img-circle"/>
					<span class="username"  style="color: white;">
					'.$row["user_nama_depan"].'
					</span>&nbsp;';
				}
			}
			return $foto_profil;
		}
	}

	function fetch_user_chat_history($from_user_id, $to_user_id)
	{
		$this->query = "
		SELECT * FROM chat_message
		WHERE (from_user_id = '".$from_user_id."' 
		AND to_user_id = '".$to_user_id."') 
		OR (from_user_id = '".$to_user_id."' 
		AND to_user_id = '".$from_user_id."') 
		ORDER BY time_chat ASC 
		";

		$result = $this->query_result();
		$output = '';
		foreach($result as $row)
		{
			$user_name = '';
			$user_foto = '';
			$chat_message = '';
			$status_pesan = '';
			$chat_message = $row['chat_konten'];
			$string = strip_tags($chat_message, "<br><br/><br /><a><b><i><u><em><strong>");
			$string = $this->convertToLinkpesan($string);
			if($row["from_user_id"] == $from_user_id)
			{
				if($row["status"] == '2')
				{
					$chat_message = '<span class="fa fa-ban"></span><em>  Pesan ini telah dihapus</em>';
					$user_name = '';
					if($row["status"] == '0')
					{          
						$status_pesan = '<span class="mdi mdi-check-all"></span>';
					}
					if($row["status"] == '1')
					{          
						$status_pesan = '<span class="mdi mdi-check"></span>';
					}
				}
				else
				{
					$chat_message = '<a class="button remove_chat" id="'.$row['chat_message_id'].'">'.$string.'</a>';
					$user_name = '';
					if($row["status"] == '0')
					{          
						$status_pesan = '<span class="mdi mdi-check-all"></span>&nbsp;';
					}
					if($row["status"] == '1')
					{          
						$status_pesan = '<span class="mdi mdi-check"></span>&nbsp;';
					}
				}
				$li = 'class="odd"';
				$br = '<br>';
				$class = 'class="box bg-light-inverse"';
			}
			else
			{
				if($row["status"] == '2')
				{
					$chat_message = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
				}
				else
				{
					$chat_message = ''.$string.'';
				}
				$user_name = '<h5>'.$this->get_nama_lengkap($row['from_user_id']).'</h5>';
				$user_foto = $this->Get_user_foto_chat($row['from_user_id']);
				if($user_foto == 'user.png')
				{
					$user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($user_name, 0,1).'</span>';
				}
				else
				{
					$user_foto = '<div class="chat-img"><img src="../data/akun/profil/'.$user_foto.'" alt="user"></div>';
				}     
				$li = '';
				$br = '';
				$class = 'class="box bg-light-info"';
			}
			$output .= '
					<li '.$li.' style="margin-top: 5px;">
					<div class="chat-content" style="padding-left: 0px;">
					      <div '.$class.'> '.$chat_message.' &nbsp;&nbsp; '.$status_pesan.'</div>                          
					    '.$br.'
					</div>
					<div class="chat-time" style="margin-left: 0px; margin-bottom: 10px;">'.$this->tgl_ago($row['time_chat']).'</div>
					</li>
					';
		}
		$output .= '<br><br>';
		$this->query = "
		UPDATE chat_message 
		SET status = '0' 
		WHERE from_user_id = '".$to_user_id."' 
		AND to_user_id = '".$from_user_id."' 
		AND status = '1'
		";
		$this->execute_query();
		return $output;
	}
}

?>