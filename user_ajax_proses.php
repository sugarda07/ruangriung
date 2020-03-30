<?php

//user_ajax_action.php

include('master/koneksi.php');

require_once('class/class.phpmailer.php');

$exam = new Koneksi;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM user 
			WHERE user_email = '".trim($_POST["user_email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email'];

			$user_username = md5(rand());

			$exam->data = array(
				':user_email'			=>	$receiver_email,
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_username'		=>	$user_username,
				':user_nama_depan'		=>	$_POST['user_nama_depan'],
				':user_nama_belakang'	=>	$_POST['user_nama_belakang'],
				':user_foto'			=>	'user.png',
				':user_timestamp'		=>	$current_datetime,
				':user_email_verified'	=>	'yes',
				':user_pwd'				=>	$_POST['user_password']
			);

			$exam->query = "
			INSERT INTO user
			(user_email, user_password, user_verfication_code, user_username, user_nama_depan, user_nama_belakang, user_foto, user_timestamp, user_email_verified, user_pwd)
			VALUES 
			(:user_email, :user_password, :user_verfication_code, :user_username, :user_nama_depan, :user_nama_belakang, :user_foto, :user_timestamp, :user_email_verified, :user_pwd)
			";

			$exam->execute_query();
			
			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':user_email'	=>	$_POST['user_email']
			);

			$exam->query = "
			SELECT * FROM user
			WHERE user_email = :user_email
			";

			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();

				foreach($result as $row)
				{
					if($row['user_email_verified'] == 'yes')
					{
						if(password_verify($_POST['user_password'], $row['user_password']))
						{
							$_SESSION['user_id'] 	= $row['user_id'];
		                    $_SESSION['user_email'] 	= $row['user_email'];
		                    $exam->query = "
		                    INSERT INTO login_details 
		                    (user_id) 
		                    VALUES ('".$row['user_id']."')
		                    ";
		                    $exam->execute_query();
		                    $_SESSION['login_details_id'] = $exam->execute_with_last_id();

							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'		=>	'Password Anda Salah'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Email belum di verifikasi'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'		=>	'Alamat email Anda salah'
				);
			}

			echo json_encode($output);
		}
	}

	if($_POST['page'] == "profile")
	{
		if($_POST['action'] == 'edit_ambil')
		{
			$exam->query = "
			SELECT * FROM user
			WHERE user_id = '".$_SESSION["user_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['user_nama_depan'] 		= $row['user_nama_depan'];

				$output['user_nama_belakang'] 	= $row['user_nama_belakang'];

				$output['user_jk'] 				= $row['user_jk'];

				$output['user_tmp_lahir'] 		= $row['user_tmp_lahir'];

				$output['user_tgl_lahir'] 		= $row['user_tgl_lahir'];

				$output['user_hp'] 				= $row['user_hp'];

				$output['user_kelas_id'] 		= $row['user_kelas_id'];

				$output['user_alamat'] 			= $row['user_alamat'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == "edit_profil")
		{
			$exam->data = array(
				':user_nama_depan'    	=>  $_POST["user_nama_depan"],
				':user_nama_belakang' 	=>  $_POST["user_nama_belakang"],
				':user_jk'  			=>  $_POST["user_jk"],
				':user_tmp_lahir'      	=>  $_POST["user_tmp_lahir"],
				':user_tgl_lahir'      	=>  $_POST["user_tgl_lahir"],
				':user_hp'          	=>  $_POST["user_hp"],
				':user_kelas_id'        =>  $_POST["user_kelas_id"],
				':user_alamat'         	=>  $_POST["user_alamat"],
				':user_id'        		=>  $_SESSION["user_id"]
			);

			$exam->query = '
			UPDATE user SET user_nama_depan = :user_nama_depan, user_nama_belakang = :user_nama_belakang, user_jk = :user_jk, user_tmp_lahir = :user_tmp_lahir, user_tgl_lahir = :user_tgl_lahir, user_hp = :user_hp, user_alamat = :user_alamat, user_kelas_id = :user_kelas_id WHERE user_id = :user_id
			';

			$exam->execute_query();

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'ambil_password')
		{
			$exam->query = "
			SELECT * FROM user
			WHERE user_id = '".$_SESSION["user_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['user_email'] 		= $row['user_email'];

				$output['user_password'] 	= $row['user_password'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'ganti_password')
		{
			$exam->data = array(
				':user_password'	=>	password_hash($_POST['user_password_baru'], PASSWORD_DEFAULT),
				':user_pwd'			=>	$_POST['user_password_baru'],
				':user_id'			=>	$_SESSION['user_id']
			);

			$exam->query = "
			UPDATE user 
			SET user_password = :user_password, user_pwd = :user_pwd
			WHERE user_id = :user_id
			";

			$exam->execute_query();

			session_destroy();

			$output = array(
				'success'		=>	'Password berhasil diganti'
			);

			echo json_encode($output);
		}
	}

	if($_POST["page"] == 'ujian')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN ujian ON ujian.ujian_id = kelasujian.kelasujian_ujian_id
			INNER JOIN user ON user.user_kelas_id = kelasujian.kelasujian_kelas_id
			WHERE user.user_id = '".$_SESSION['user_id']."' 
			AND (";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'ujian.ujian_judul LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR ujian.ujian_mapel LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY ujian.ujian_id DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN ujian ON ujian.ujian_id = kelasujian.kelasujian_ujian_id
			INNER JOIN user ON user.user_kelas_id = kelasujian.kelasujian_kelas_id
			WHERE user.user_id = '".$_SESSION['user_id']."' 
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row["ujian_judul"]);
				$sub_array[] = $row["ujian_mapel"];
				$sub_array[] = $row["ujian_tanggal"];
				$sub_array[] = $row["ujian_durasi"] .' Menit';
				$sub_array[] = $row["ujian_jumlah_soal"] .' Soal';

				$status = '';

				if($row['kelasujian_status'] == 'Menunggu')
				{
					$status = '<span class="badge badge-warning">Menunggu</span>';
				}

				if($row['kelasujian_status'] == 'Mulai')
				{
					$status = '<span class="badge badge-info">Mulai</span>';
				}

				if($row['kelasujian_status'] == 'Selesai')
				{
					$status = '<span class="badge badge-success">Selesai</span>';
				}

				$sub_array[] = $status;

				$status_ujian_user = '';

				$kerjakan = '';				

				if($row['kelasujian_status'] == 'Mulai')
				{
					if($exam->If_user_konfirmasi($row['ujian_id'], $_SESSION['user_id']))
					{
						$status_ujian_user = $exam->status_ujian_user($row['ujian_id'], $_SESSION['user_id']);

						if($status_ujian_user == 'Absen')
						{
							$kerjakan = '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm">Kerjakan</a>';
						}

						if($status_ujian_user == 'Sedang Mengerjakan')
						{
							$kerjakan = '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm">Kerjakan</a>';
						}

						if($status_ujian_user == 'Selesai')
						{
							$kerjakan = '<a href="hasil.php?code='.$row["ujian_code"].'" class="btn btn-success btn-sm">Lihat Hasil</a>';
						}
					}
					else
					{
						$kerjakan = '<button type="button" name="konfirmasi" id="konfirmasi" class="btn btn-warning btn-sm" data-ujian_id="'.$row['ujian_id'].'">Konfirmasi</button>';
					}
				}
				else
				{
					
				}
			
				$sub_array[] = $kerjakan;

				$data[] = $sub_array;
			}

			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == "load_data_ujian")
		{
			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN ujian ON ujian.ujian_id = kelasujian.kelasujian_ujian_id
			INNER JOIN mapel ON mapel.mapel_id = ujian.ujian_mapel
			INNER JOIN user ON user.user_kelas_id = kelasujian.kelasujian_kelas_id
			WHERE user.user_id = '".$_SESSION['user_id']."'
			ORDER BY kelasujian.kelasujian_id DESC
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				$status_ujian_user = '';

				$kerjakan = '';				

				if($row['kelasujian_status'] == 'Mulai')
				{
					if($exam->If_user_konfirmasi($row['ujian_id'], $_SESSION['user_id']))
					{
						$status_ujian_user = $exam->status_ujian_user($row['ujian_id'], $_SESSION['user_id']);

						if($status_ujian_user == 'Absen')
						{
							$kerjakan .= '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm pull-right">Kerjakan</a>';
						}

						if($status_ujian_user == 'Sedang Mengerjakan')
						{
							$kerjakan .= '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm pull-right">Kerjakan</a>';
						}

						if($status_ujian_user == 'Selesai')
						{
							$kerjakan .= '<a href="hasil.php?code='.$row["ujian_code"].'" class="btn btn-success btn-sm pull-right">Lihat Hasil</a>';
						}
					}
					else
					{
						$kerjakan .= '<button type="button" name="konfirmasi" id="konfirmasi" class="btn btn-warning btn-sm pull-right" data-ujian_id="'.$row['ujian_id'].'">Konfirmasi</button>';
					}
				}
				else
				{
					
				}

				$output	.= '
			    <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 3px;">'.$row['ujian_judul'].'</h4>
                        <p class="card-text" style="margin-bottom: 0px;">Nama Mapel: '.$row['mapel_nama'].'</p>
                        <p class="card-text" style="margin-bottom: 0px;"> Jumlah Soal: '.$exam->jumlah_soal($row['ujian_id']).' (Durasi '.$row['ujian_durasi'].' Menit)</p>
                        <p class="card-text" style="margin-bottom: 0px;">Info Soal: '.$row['ujian_info'].'</p>
                        <p class="card-text" style="margin-bottom: 5px;"><small class="text-muted">'.$row['ujian_tanggal'].' - Status: '.$row['kelasujian_status'].'</small></p>
                        '.$kerjakan.'
                    </div>
                </div>
			';
			}		
			echo $output;
		}

		if($_POST['action'] == 'konfirmasi')
		{
			$exam->data = array(
				':konfirmasi_user_id'	=>	$_SESSION['user_id'],
				':konfirmasi_ujian_id'	=>	$_POST['ujian_id']
			);

			$exam->query = "
			INSERT INTO user_konfirmasi 
			(konfirmasi_user_id, konfirmasi_ujian_id) 
			VALUES (:konfirmasi_user_id, :konfirmasi_ujian_id)
			";

			$exam->execute_query();


			$exam->query = "
			SELECT soal_id FROM soal 
			WHERE soal_ujian_id = '".$_POST['ujian_id']."'
			";
			$result = $exam->query_result();
			foreach($result as $row)
			{
				$exam->data = array(
					':jawaban_user_id'		=>	$_SESSION['user_id'],
					':jawaban_ujian_id'		=>	$_POST['ujian_id'],
					':jawaban_soal_id'		=>	$row['soal_id'],
					':jawaban_pilihan_user'	=>	'0',
					':nilai'				=>	'0'	
				);

				$exam->query = "
				INSERT INTO jawaban 
				(jawaban_user_id, jawaban_ujian_id, jawaban_soal_id, jawaban_pilihan_user, nilai) 
				VALUES (:jawaban_user_id, :jawaban_ujian_id, :jawaban_soal_id, :jawaban_pilihan_user, :nilai)
				";
				$exam->execute_query();
			}
		}
	}

	if($_POST['page'] == 'proses_ujian')
	{
		if($_POST['action'] == 'load_soal')
		{
			if($_POST['soal_id'] == '')
			{
				$exam->query = "
				SELECT * FROM soal 
				WHERE soal_ujian_id = '".$_POST["ujian_id"]."'
				ORDER BY soal_id ASC 
				LIMIT 1
				";
			}
			else
			{
				$exam->query = "
				SELECT * FROM soal 
				WHERE soal_id = '".$_POST["soal_id"]."' 
				";
			}

			$result = $exam->query_result();

			$output = '';

			foreach($result as $row)
			{
				$output .= '
				<h4>'.$row["soal_teks"].'</h4>
				<hr />
				<br />
				<div class="row">
				';

				$exam->query = "
				SELECT * FROM pilihan_soal
				WHERE pilihan_soal_id = '".$row['soal_id']."'
				";
				$sub_result = $exam->query_result();

				$count = 1;

				foreach($sub_result as $sub_row)
				{
					$is_checked= '';

					if($exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']) == $count)
					{
						$is_checked = 'checked';
					}

					$output .= '
					<div class="col-12" style="padding: 7px;">
						<fieldset class="controls">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="pilihan_1" id="no_'.$count.'" class="custom-control-input pilihan_jawaban" aria-invalid="false" data-soal_id="'.$row["soal_id"].'" data-id="'.$count.'"  '.$is_checked.'>
                                <label class="custom-control-label" for="no_'.$count.'">'.$sub_row["pilihan_teks"].'</label>
                            </div>
                        	<div class="help-block"></div>
                        </fieldset>
	                </div>
					';

					$count = $count + 1;
				}
				$output .= '
				</div>
				';
			}

			echo $output;
		}

		if($_POST['action'] == 'navigasi_arah')
		{
			$exam->query = "
			SELECT soal_id FROM soal 
			WHERE soal_id < '".$_POST['soal_id']."' 
			AND soal_ujian_id = '".$_POST["ujian_id"]."' 
			ORDER BY soal_id DESC 
			LIMIT 1";

			$previous_result = $exam->query_result();

			$previous_id = '';
			$next_id = '';
			$output = '';

			foreach($previous_result as $previous_row)
			{
				$previous_id = $previous_row['soal_id'];
			}

			$exam->query = "
			SELECT soal_id FROM soal 
			WHERE soal_id > '".$_POST['soal_id']."' 
			AND soal_ujian_id = '".$_POST["ujian_id"]."' 
			ORDER BY soal_id ASC 
			LIMIT 1";
				
			$next_result = $exam->query_result();

			foreach($next_result as $next_row)
			{
				$next_id = $next_row['soal_id'];
			}

			$if_previous_disable = '';
			$if_next_disable = '';

			if($previous_id == '')
			{
				$if_previous_disable = 'disabled';
			}
			
			if($next_id == '')
			{
				$if_next_disable = 'disabled';
			}

			$output .= '
	                <div class="col-4" style="padding: 5px">
	                    <button type="button" name="previous" class="btn btn-block btn-info previous" id="'.$previous_id.'" '.$if_previous_disable.'><i class="fa fa-angle-double-left"></i> Sebelumnya</button>
	                </div>
	                <div class="col-4" style="padding: 5px">
	                    
	                </div>
	                <div class="col-4" style="padding: 5px">
	                    <button type="button" name="next" class="btn btn-block btn-info next" id="'.$next_id.'" '.$if_next_disable.'>Selanjutnya <i class="fa fa-angle-double-right"></i></button>
	                </div>
	        ';
	        echo $output;
		}

		if($_POST['action'] == 'soal_navigation')
		{
			$exam->query = "
				SELECT soal_id FROM soal 
				WHERE soal_ujian_id = '".$_POST["ujian_id"]."' 
				ORDER BY soal_id ASC 
				";
			$result = $exam->query_result();
			$output = '
			<div class="row">
			';
			$count = 1;
			foreach($result as $row)	
			{
				$sudah_isi= '';
				$isi_jawab= '';

				if($exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']) != '0')
				{
					$sudah_isi = 'btn-info';

					$jawaban_user = $exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']);

					$jawaban_user_str = $exam->number_to_str($jawaban_user);

					$isi_jawab = '<span class="badge badge-success text-white">'.$jawaban_user_str.'</span>';
				}
				else
				{
					$sudah_isi = 'btn-default';
				}

				$output .= '
				<div class="col-4" style="padding-bottom: 10px; padding-top: 10px;">
                    <button type="button" class="btn waves-effect waves-light '.$sudah_isi.' btn-block navigasi_soal" data-soal_id="'.$row["soal_id"].'">'.$count.' '.$isi_jawab.'</button>
                </div>
				';
				$count = $count + 1;
			}
			$output .= '
				</div>
			';
			echo $output;
		}

		if($_POST['action'] == 'user_detail')
		{
			$exam->query = "
			SELECT * FROM user
			WHERE user_id = '".$_SESSION["user_id"]."'
			";

			$result = $exam->query_result();

			$output = '
			<div class="card">
				<div class="card-header">User Details</div>
				<div class="card-body">
					<div class="row">
			';

			foreach($result as $row)
			{
				$output .= '
				<div class="col-md-3">
					<img src="data/akun/profil/'.$row["user_foto"].'" class="img-fluid" />
				</div>
				<div class="col-md-9">
					<table class="table table-bordered">
						<tr>
							<th>Name</th>
							<td>'.$row["user_nama_depan"].'</td>
						</tr>
						<tr>
							<th>Email ID</th>
							<td>'.$row["user_email"].'</td>
						</tr>
					</table>
				</div>
				';
			}
			$output .= '</div></div></div>';
			echo $output;
		}

		if($_POST['action'] == 'jawaban')
		{
			$nilai_benar = $exam->Get_nilai_benar($_POST["ujian_id"]);

			$nilai_salah = $exam->Get_nilai_salah($_POST["ujian_id"]);

			$kunci_jawaban = $exam->Get_kunci_jawaban($_POST['soal_id']);

			$marks = 0;

			if($kunci_jawaban == $_POST['pilihan_jawaban'])
			{
				$marks = '+' . $nilai_benar;
			}
			else
			{
				$marks = '-' . $nilai_salah;
			}

			$exam->data = array(
				':jawaban_pilihan_user'	=>	$_POST['pilihan_jawaban'],
				':nilai'				=>	$marks
			);

			$exam->query = "
			UPDATE jawaban 
			SET jawaban_pilihan_user = :jawaban_pilihan_user, nilai = :nilai 
			WHERE jawaban_user_id = '".$_SESSION["user_id"]."' 
			AND jawaban_ujian_id = '".$_POST["ujian_id"]."' 
			AND jawaban_soal_id = '".$_POST["soal_id"]."'
			";
			$exam->execute_query();
		}

		if($_POST['action'] == 'konfirmasi_selesai')
		{
			$exam->data = array(
				':konfirmasi_user_id'	=>	$_SESSION['user_id'],
				':konfirmasi_ujian_id'	=>	$_POST["ujian_id"],
				':konfirmasi_status'	=>	'Selesai',
			);

			$exam->query = "
			UPDATE user_konfirmasi 
			SET konfirmasi_status = :konfirmasi_status
			WHERE konfirmasi_user_id = :konfirmasi_user_id 
			AND konfirmasi_ujian_id = :konfirmasi_ujian_id 
			";
			$exam->execute_query();
		}
	}

	if($_POST['page'] == 'hasil_ujian')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$ujian_id = $exam->Get_ujian_id($_POST['code']);

			$exam->query = "
			SELECT * FROM soal 
			INNER JOIN jawaban 
			ON jawaban.jawaban_soal_id = soal.soal_id 
			WHERE soal.soal_ujian_id = '".$ujian_id."' 
			AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."' 
			AND (";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'soal.soal_teks LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY soal.soal_id ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM soal 
			INNER JOIN jawaban 
			ON jawaban.jawaban_soal_id = soal.soal_id 
			WHERE soal.soal_ujian_id = '".$ujian_id."' 
			AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = html_entity_decode($row["soal_teks"]);

				$exam->query = "
				SELECT * 
				FROM pilihan_soal 
				WHERE pilihan_soal_id = '".$row["soal_id"]."'
				";
				$sub_result = $exam->query_result();
				foreach($sub_result as $sub_row)
				{
					$pilihan = $sub_row['pilihan_no'];
				}

				$sub_array[] = $pilihan;

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$sub_array[] = '';

				$data[] = $sub_array;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'index')
	{
		if($_POST['action'] == "load_postingan")
		{
			$mulai = $_POST["start"];
			$akhir = $_POST["limit"];
			$exam->query = "
			SELECT * FROM postingan 
			INNER JOIN user ON user.user_id = postingan.user_id 
			LEFT JOIN follow ON follow.sender_id = postingan.user_id 
			WHERE follow.receiver_id = '".$_SESSION["user_id"]."' OR postingan.user_id = '".$_SESSION["user_id"]."' 
			GROUP BY postingan.post_id 
			ORDER BY postingan.post_id DESC
			LIMIT ".$mulai.", ".$akhir."
			";
			$result = $exam->query_result();

			$total_row = $exam->total_row();

			$output = '';

			if($total_row > 0)
			{
				foreach($result as $row)
				{
					$foto_user = '';
					$postingan ='';
					$konten_konten = $row["post_konten"];
					$string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
					$string = $exam->convertToLink($string); 
					if($row['user_foto'] != 'user.png')
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
	                        <div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>
				        	';
						}					
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />';
					    }
					}
					else
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
							<div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>                      
				        ';
						}
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
					    }
					    
					}

					$like_button = '';
					if($exam->is_user_has_already_like_content($_SESSION["user_id"], $row["post_id"]))
				   	{
				    	$like_button = '
				    	<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i> '.$exam->count_total_post_like($row["post_id"]).'</button>&nbsp;&nbsp;
				    	';
				   	}
				   	else
				   	{
				   		$like_button = '
				   		<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i> '.$exam->count_total_post_like($row["post_id"]).'</button>&nbsp;&nbsp;
				   		';
				   	}

				   	$tampil_like = '';
					if($exam->count_total_post_like($row["post_id"]) == '0')
					{
						$tampil_like = '';
					}
					else
					{
						$tampil_like = ''.$exam->count_total_post_like($row["post_id"]).' suka';
					}

						$tampil_komen = '';
					if($exam->count_comment($row["post_id"]) == '0')
					{
						$tampil_komen = '';
					}
					else
					{
						$tampil_komen = ''.$exam->count_comment($row["post_id"]).' komentar';
					}

					$output .= '
	                        <div class="sl-item" style="margin-bottom: 5px;">
	                            <div class="sl-left"> '.$foto_user.' </div>
	                            <div class="sl-right">
	                                <div> <a href="view_posting.php?data='.$row['post_id'].'" class="link">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'</a>
	                                	<p style="margin-bottom: 5px;"><span class="sl-date">'.$exam->tgl_ago($row["post_tgl"]).'</span></p>
	                                    <div class="m-t-20 row" style="margin-top: 5px;">
	                                    	'.$postingan.'
	                                    </div>
	                                    <div class="like-comm m-t-20" style="margin-top: 5px;">
	                                    	<div class="row text-center justify-content-md-center" style="display:none;">
		                                        <div class="col-4">
		                                        	'.$like_button.'
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="fa fa-comments-o" style="font-size: 18px;"></i> '.$exam->count_comment($row["post_id"]).'</button>
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link"> <i class="fa fa-retweet" style="font-size: 18px;"></i> </button>
		                                        </div>
	                                      	</div>
	                                    	<p><span class="sl-date"><a href="view_posting.php?data='.$row['post_id'].'" class="link">'.$tampil_like.'  &nbsp;'.$tampil_komen.'</a></span></p>
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
							                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'  <small class="m-b-10 text-muted">'.$exam->count_comment($row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
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

		if($_POST['action'] == 'insert_posting_gambar')
		{
			if($_POST['upload_posting_gambar'] != '')
			{
				$post_gambar = $_POST['gambar'];
				$post_konten = nl2br($_POST["posting_gambar_konten"]);

				list($type, $post_gambar) = explode(';',$post_gambar);
				list(, $post_gambar) = explode(',',$post_gambar);

				$post_gambar = base64_decode($post_gambar);
				$image_name = date("Ymd") . '' . date("His", STRTOTIME(date('h:i:sa'))).'.jpg';
				file_put_contents('data/posting/images/'.$image_name, $post_gambar);
				$exam->data = array(
					':user_id'				=>	$_SESSION["user_id"],
					':post_konten'			=>	$post_konten,
					':post_gambar'			=>	$image_name,
					':post_code'			=>	md5(rand()),
					':post_tgl'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);
				$exam->query = "
				INSERT INTO postingan 
				(post_id, user_id, post_konten, post_gambar, post_code, post_tgl) 
				VALUES ('', :user_id, :post_konten, :post_gambar, :post_code, :post_tgl)
				";
				$exam->execute_query();
				
				$exam->query = "
				SELECT receiver_id FROM follow 
				WHERE sender_id = '".$_SESSION["user_id"]."'
				";
				
				$result = $exam->query_result();

				foreach($result as $notification_row)
				{
					$exam->query = "
					SELECT post_id FROM postingan
					WHERE user_id = '".$_SESSION["user_id"]."'
					";
					$result = $exam->query_result();
					foreach($result as $posting_row)
					{

					}

					$post_id = $exam->Get_post_id($posting_row["post_id"]);
			        $notification_text= 'membuat postingan baru';
					$notif_sender_id = $_SESSION["user_id"];

					$exam->data = array(
						':notification_receiver_id'	=>	$notification_row['receiver_id'],
						':notif_sender_id'			=>	$notif_sender_id,
						':notif_post_id'			=>	$post_id,
						':notification_text'		=>	$notification_text,
						':read_notification'		=>	'no',
						':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
						':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
					);

					$exam->query = "
					INSERT INTO pemberitahuan 
						(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
						VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
					";
					$exam->execute_query();
				}
			}
			else
			{
				$post_konten = nl2br($_POST["posting_gambar_konten"]);
				$exam->data = array(
						':user_id'				=>	$_SESSION["user_id"],
						':post_konten'			=>	$post_konten,
						':post_code'			=>	md5(rand()),
						':post_tgl'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
					);
				$exam->query = "
				INSERT INTO postingan 
				(post_id, user_id, post_konten, post_code, post_tgl) 
				VALUES ('', :user_id, :post_konten, :post_code, :post_tgl)
				";
				$exam->execute_query();

				$exam->query = "
				SELECT receiver_id FROM follow 
				WHERE sender_id = '".$_SESSION["user_id"]."'
				";
				
				$result = $exam->query_result();

				foreach($result as $notification_row)
				{
					$exam->query = "
					SELECT post_id FROM postingan
					WHERE user_id = '".$_SESSION["user_id"]."'
					";
					$result = $exam->query_result();
					foreach($result as $posting_row)
					{

					}

					$post_id = $exam->Get_post_id($posting_row["post_id"]);
			        $notification_text= 'membuat postingan baru';
					$notif_sender_id = $_SESSION["user_id"];

					$exam->data = array(
						':notification_receiver_id'	=>	$notification_row['receiver_id'],
						':notif_sender_id'			=>	$notif_sender_id,
						':notif_post_id'			=>	$post_id,
						':notification_text'		=>	$notification_text,
						':read_notification'		=>	'no',
						':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
						':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
					);

					$exam->query = "
					INSERT INTO pemberitahuan 
						(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
						VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
					";
					$exam->execute_query();
				}		
			}
		}
	}

	if($_POST['page'] == 'view_posting')
	{
		if($_POST['action'] == "load_postingan")
		{
			$exam->query = "
			SELECT * FROM postingan 
		    INNER JOIN user ON user.user_id = postingan.user_id 
		    WHERE postingan.post_id = '".$_POST["post_id"]."' 
		    GROUP BY postingan.post_id 
		    ORDER BY postingan.post_id DESC
			";
			$result = $exam->query_result();

			$total_row = $exam->total_row();

			$output = '';

			if($total_row > 0)
			{
				foreach($result as $row)
				{
					$foto_user = '';
					$postingan ='';
					$konten_konten = $row["post_konten"];
					$string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
					$string = $exam->convertToLink($string); 
					if($row['user_foto'] != 'user.png')
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
	                        <div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>
				        	';
						}					
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />';
					    }
					}
					else
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
							<div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>                      
				        ';
						}
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
					    }
					    
					}

					$like_button = '';
					if($exam->is_user_has_already_like_content($_SESSION["user_id"], $row["post_id"]))
				   	{
				    	$like_button = '
				   		<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i> </button>&nbsp;&nbsp;
				   		';				    	
				   	}
				   	else
				   	{
				   		$like_button = '
				    	<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i> </button>&nbsp;&nbsp;
				    	';
				   	}

				   	$tampil_like = '';
					if($exam->count_total_post_like($row["post_id"]) == '0')
					{
						$tampil_like = '';
					}
					else
					{
						$tampil_like = ''.$exam->count_total_post_like($row["post_id"]).' suka';
					}

						$tampil_komen = '';
					if($exam->count_comment($row["post_id"]) == '0')
					{
						$tampil_komen = '';
					}
					else
					{
						$tampil_komen = ''.$exam->count_comment($row["post_id"]).' komentar';
					}

					$output .= '
	                        <div class="sl-item" style="margin-bottom: 5px;">
	                            <div class="sl-left"> '.$foto_user.' </div>
	                            <div class="sl-right">
	                                <div> <a href="view_profil.php?data='.$row['user_verfication_code'].'" class="link">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'</a>
	                                	<p style="margin-bottom: 5px;"><span class="sl-date">'.$exam->tgl_ago($row["post_tgl"]).'</span></p>
	                                    <div class="m-t-20 row" style="margin-top: 5px;">
	                                    	'.$postingan.'
	                                    </div>
	                                    <div class="like-comm m-t-20" style="margin-top: 5px;">
	                                    	<div class="row text-center justify-content-md-center">
		                                        <div class="col-4">
		                                        	'.$like_button.'
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="fa fa-comments-o" style="font-size: 18px;"></i> </button>
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link"> <i class="fa fa-retweet" style="font-size: 18px;"></i> </button>
		                                        </div>
	                                      	</div>
	                                    	<p><span class="sl-date">'.$tampil_like.'&nbsp;&nbsp;'.$tampil_komen.'</span></p>
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
							                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'  <small class="m-b-10 text-muted">'.$exam->count_comment($row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
							                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
							            </div>
							            
							            <div class="modal-body" style="position: relative; padding: 0px; overflow-y: scroll; height: 100%; background-color: aliceblue;">
							            	<div class="comment-widgets" id="old_comment'.$row["post_id"].'" style="margin-bottom: 100px;">

							                </div>
							            </div>
							            <form action="javascript:void(0)" method="post">
							                <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left; padding: 8px;">
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

		if($_POST['action'] == 'like')
		{
			$exam->query = "
		    SELECT * FROM like_post 
		    WHERE post_id = '".$_POST["post_id"]."' 
		    AND user_id = '".$_SESSION["user_id"]."'
		    ";
		    $result = $exam->query_result();
			$total_row = $exam->total_row();
		    if($total_row > 0)
		    {
				$exam->query = "
				DELETE FROM like_post 
				WHERE user_id=".$_SESSION["user_id"]." AND post_id=".$_POST["post_id"]."
				";
				$exam->execute_query();
		    }
		    else
		    {
				$exam->query = "
				INSERT INTO like_post 
				(user_id, post_id) 
				VALUES ('".$_SESSION["user_id"]."', '".$_POST["post_id"]."')
				";
				$exam->execute_query();

				$exam->query = "
				SELECT user_id, post_konten FROM postingan 
				WHERE post_id = '".$_POST["post_id"]."'
				";
				$result = $exam->query_result();

				foreach($result as $notification_row)
				{
					$notification_text = 'Menyukai ';
					$exam->data = array(
						':notification_receiver_id' =>  $notification_row['user_id'],
						':notif_sender_id'      	=>  $_SESSION["user_id"],
						':notif_post_id'      		=>  $_POST["post_id"],
						':notification_text'    	=>  $notification_text,
						':read_notification'    	=>  'no',
						':notif_time'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
						':notif_update'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
					);

					$exam->query = "
					INSERT INTO pemberitahuan 
					(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
					VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
					";
					$exam->execute_query();
				}
		    }
		}

		if($_POST['action'] == 'fetch_comment')
		{
			$exam->query = "
			SELECT * FROM komentar 
			INNER JOIN user 
			ON user.user_id = komentar.user_id 
			WHERE post_id = '".$_POST["post_id"]."' 
			ORDER BY comment_id DESC
			";

			$result = $exam->query_result();
			
			$output = '';
			
			foreach($result as $row)
			{
				$user_foto = '';
				if($row['user_foto'] != 'user.png')
				{
					$user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" width="40">';
				}
				else
				{
					$user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				}
				$output .= '
				    <div class="d-flex no-block comment-row border-top" style="padding-top: 0px; padding-bottom: 0px;">
				      <div class="p-2">'.$user_foto.'</div>
				      <div class="comment-text active w-100" style="padding-left: 15px; padding-bottom: 5px; line-height: 1; padding-top: 5px;">
				          <h5 class="font-medium" style="margin-bottom: 3px;">'.strip_tags($row["comment"]).'</h5>
				          <p class="m-b-10 text-muted" style="margin-bottom: 2px;">'.$row["user_nama_depan"].' '.strip_tags($row["user_nama_belakang"]).'</p>
				          <div class="comment-footer">
				              <span class="text-muted pull-right"><small>'.$exam->tgl_ago($row["timestamp"]).'</small></span>
				          </div>
				      </div>
				  </div>
				';
			}
			echo $output;
		}

		if($_POST['action'] == 'submit_comment')
		{
			$exam->data = array(
				':post_id'    =>  $_POST["post_id"],
				':user_id'    =>  $_SESSION["user_id"],
				':comment'    =>  strip_tags($_POST["comment"]),
				':timestamp'  =>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
			);
			$exam->query = "
			INSERT INTO komentar 
			(post_id, user_id, comment, timestamp) 
			VALUES (:post_id, :user_id, :comment, :timestamp)
			";
			$exam->execute_query();  

			$exam->query = "
			SELECT user_id, post_konten FROM postingan 
			WHERE post_id = '".$_POST["post_id"]."'
			";
			
			$result = $exam->query_result();

			foreach($result as $notification_row)
			{
			  
			    $notification_text = 'Mengomentari ';
			    $exam->data = array(
					':notification_receiver_id' =>  $notification_row['user_id'],
					':notif_sender_id'      	=>  $_SESSION["user_id"],
					':notif_post_id'      		=>  $_POST["post_id"],
					':notification_text'    	=>  $notification_text,
					':read_notification'    	=>  'no',
					':notif_time'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
					':notif_update'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);

				$exam->query = "
				INSERT INTO pemberitahuan 
				(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
				VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
				";
			    $exam->execute_query();     
			}
		}
	}

	if($_POST['page'] == 'post_all')
	{
		if($_POST['action'] == "post_all_gallery")
		{
			$exam->query = "
	        SELECT * FROM postingan
	        JOIN user ON postingan.user_id = user.user_id
			WHERE postingan.user_id != '".$_SESSION["user_id"]."'
			ORDER BY postingan.post_id DESC
			LIMIT ".$_POST["start"].", ".$_POST["limit"]."
	        ";
	        $result = $exam->query_result();

	        foreach($result as $row)
	        {
	            if($row['post_gambar'] != '')
	            {
	                echo '
	            <a class="image" href="view_posting.php?data='.$row['post_id'].'">
	                <img class="img-responsive" alt="image" src="data/posting/images/'.$row['post_gambar'].'">
	            </a>
	            ';
	            }
	        }
		}

		if($_POST['action'] == "cari_kontak")
		{
			$mulai = $_POST["start_kontak"];
			$akhir = $_POST["limit_kontak"];
			$exam->query = "
			SELECT * FROM user WHERE user_id != ".$_SESSION['user_id']."
			ORDER BY rand()
			LIMIT ".$mulai.", ".$akhir."
			";

			$result = $exam->query_result();
			$total_data = $exam->total_row();

			$output = '
			<div class="card-body" style="padding: 5px;">
				<h5 class="card-title" style="padding-left: 10px;"> </h5>
					<div class="message-box">
			        	<div class="message-widget message-scroll">
			';

			if($total_data > 0)
			{
				foreach($result as $row)
				{
					if($row['user_foto'] != 'user.png')
				    {
				        $user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle">';
				    }
				    else
				    {
				        $user_foto = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				    }
			    	$kelas = '';
				    if($row['user_kelas_id'] == '0')
				    {
				      $kelas = '<em style="color: #d1d6da;">Nama Sekolah belum diatur</em>';
				    }
				    else
				    {
				      $kelas = ''.$exam->get_sekolah($row["user_id"]).'';
				    }

				    if($row['user_id'] != $_SESSION["user_id"])
				    {
				    $output .= '
			            <a href="view_profil.php?data='.$row['user_verfication_code'].'">
			              <div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
			              <div class="mail-contnet" style="width: 80%;">
			                <h5>'.$row["user_nama_depan"].' '.$row["user_nama_belakang"].'<span class="time pull-right"> </span></h5>
			                <span class="mail-desc">
			                '.$kelas.'
			                </span>                 
			              </div>
			            </a>
				    	';
			    	}
				}
			}
			else
			{
				$output .= '
				
				';
			}
			$output .= '
					</div>
			    </div>
			</div>
			';
			echo $output;
		}
	}

	if($_POST['page'] == 'materi')
	{
		if($_POST['action'] == "load_data_mapel")
		{
			$exam->query = "
			SELECT * FROM mapel
			INNER JOIN materi ON materi.materi_mapel_id = mapel.mapel_id
			INNER JOIN kelasmateri ON kelasmateri.kelasmateri_materi_id = materi.materi_id
			INNER JOIN user ON user.user_kelas_id = kelasmateri.kelasmateri_kelas_id
			WHERE user.user_id = '".$_SESSION['user_id']."'
			GROUP BY mapel.mapel_id
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				$output	.= '
			    <div id="accordion1" role="tablist" aria-multiselectable="true">
			        <div class="card m-b-0">
			            <div class="card-header" role="tab" id="headingOne1" style="padding-left: 10px;padding-right: 10px;">
			                <h5 class="mb-0">
			                <a class="link collapsed tombol_view_materi text-info" data-toggle="collapse" data-parent="#accordion1" href="#'.$row['mapel_id'].'" aria-expanded="false" aria-controls="collapseOne" data-mapel_id="'.$row['mapel_id'].'"><i class="fa fa-check-square-o"></i>  '.$row['mapel_nama'].' <span class="pull-right badge badge-info"><small class="">'.$exam->jumlah_materi_id($_SESSION['user_id'], $row['mapel_id']).'</small></span>
			                </a>
			              </h5>
			            </div>
			            <div id="'.$row['mapel_id'].'" class="collapse" role="tabpanel" aria-labelledby="headingOne1" style="">
			                <div class="card-body" id="view_list_materi'.$row['mapel_id'].'" style="padding-left: 5px;padding-right: 5px;padding-top: 5px;padding-bottom: 5px;">

			                </div>
			            </div>
			        </div>
			    </div>
			';
			}		
			echo $output;
		}

		if($_POST['action'] == "tampil_materi")
		{
			$exam->query = "
			SELECT * FROM materi
			INNER JOIN kelasmateri ON kelasmateri.kelasmateri_materi_id = materi.materi_id
			INNER JOIN user ON user.user_kelas_id = kelasmateri.kelasmateri_kelas_id
			WHERE  user.user_id = '".$_SESSION["user_id"]."' AND materi_mapel_id = '".$_POST["mapel_id"]."'
			GROUP BY materi_id
			";

			$result = $exam->query_result();

			$output ='<ul class="list-icons" style="padding-left: 25px;">';

			foreach($result as $row)
			{
				$output	.= '                
			    <li>
			        <a href="view_materi.php?data='.$row['materi_id'].'"><i class="fa fa-check text-info"></i> '.$row['materi_nama'].'</a>
			    </li>';
			}
			$output .= '</ul>';	
			echo $output;
		}

		if($_POST['action'] == "view_data_materi")
		{
			$exam->query = "
			SELECT * FROM materi
			JOIN user ON user.user_id = materi.materi_user_id
			WHERE materi_id = '".$_POST['materi_id']."'
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				$output	.= '
				<h4 class="card-title">'.$row['materi_nama'].'</h4>
				<h6 class="card-subtitle">'.$exam->tgl_ago($row['materi_tgl']).'  oleh:  '.$row['user_nama_depan'].' '.$row['user_nama_belakang'].'</h6>
				<p class="text-justify">'.$row['materi_data'].'</p>
				';
			}		
			echo $output;
		}
	}

	if($_POST['page'] == 'profil')
	{
		if($_POST['action'] == "view_profil")
		{
			$exam->query = "
		    SELECT * FROM user 
		    WHERE user.user_id = '".$_POST["user_id"]."'
		    ";

		    $result = $exam->query_result();

		    $output ='';
		    foreach($result as $row)
		    {
		    	if($row['user_kelas_id'] == '0')
		        {
		          $sekolah_nama = '<em style="color: #d1d6da;">Nama Sekolah belum diatur</em>';
		        }
		        else
		        {
		          $sekolah_nama = ''.$exam->get_sekolah($row["user_id"]).'';
		        }

		        if($row['user_id'] != $_SESSION['user_id'])
		        {
					$fotoprofil = '';
					if($row['user_foto'] != '')
					{
						$fotoprofil = '<img src="data/akun/profil/'.$row['user_foto'].'" class="img-circle" width="200">';
					}
					else
					{
						$fotoprofil = '<img src="data/akun/profil/user.png" class="img-circle" width="200">';
					}

		            $output .= '
		            <div class="card-body">
		                <center class="m-t-30"> '.$fotoprofil.'
		                    <h4 class="card-title m-t-10">'.strip_tags($row['user_nama_depan']).' '.strip_tags($row["user_nama_belakang"]).'</h4>
		                    <h6 class="card-subtitle">'.$sekolah_nama.'</h6>
		                    <div class="row text-center justify-content-md-center">
		                        <div class="col-4">
		                          <font class="font-medium">'.$exam->count_pengikut($row["user_id"]).'</font>
		                          <p><a href="javascript:void(0)" class="link tombol_pengikut">Pengikut</a></p>
		                        </div>
		                        <div class="col-4">
		                          <font class="font-medium">'.$exam->count_postingan($row["user_id"]).'</font>
		                          <p><a href="javascript:void(0)" class="link">Posting</a></p>
		                        </div>
		                        <div class="col-4">
		                          <font class="font-medium">'.$exam->count_mengikuti($row["user_id"]).'</font>
		                          <p><a href="javascript:void(0)" class="link tombol_mengikuti">Mengikuti</a></p>
		                        </div>
		                    </div>
		                    <div class="row text-center">
		                      <div class="col-12">
		                        '.$exam->make_follow_button_profil($_POST["user_id"], $_SESSION["user_id"]).'
		                      </div>
		                    </div>
		                </center>
		            </div>
		            ';
		        }
		        else
		        {
					$fotoprofil = '';
					if($row['user_foto'] != '')
					{
						$fotoprofil = '<img src="data/akun/profil/'.$row['user_foto'].'" class="img-circle" width="200">';
					}
					else
					{
						$fotoprofil = '<img src="data/akun/profil/user.png" class="img-circle" width="200">';
					}

	         
					$output .= '
					<div class="card-body">
					    <center class="m-t-30"> '.$fotoprofil.'
					        <h4 class="card-title m-t-10">'.$row['user_nama_depan'].' '.strip_tags($row["user_nama_belakang"]).'</h4>
					        <h6 class="card-subtitle">'.$sekolah_nama.'</h6>
					        <div class="row text-center justify-content-md-center">
					            <div class="col-4">
					              <font class="font-medium">'.$exam->count_pengikut($row["user_id"]).'</font>
					              <p><a href="javascript:void(0)" class="link tombol_pengikut">Pengikut</a></p>
					            </div>
					            <div class="col-4">
					              <font class="font-medium">'.$exam->count_postingan($row["user_id"]).'</font>
					              <p><a href="javascript:void(0)" class="link">Posting</a></p>
					            </div>
					            <div class="col-4">
					              <font class="font-medium">'.$exam->count_mengikuti($row["user_id"]).'</font>
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
					                    '.$exam->get_kelas().'
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
		          ';
		        }                
		    }
		    echo $output;
		}

		if($_POST['action'] == "follow")
		{
			$exam->query = "
		    INSERT INTO follow 
		    (sender_id, receiver_id) 
		    VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."')
		    ";
		    
		    if($exam->execute_query())
		    {
				$exam->query = "
				UPDATE user SET follower_number = follower_number + 1 WHERE user_id = '".$_POST["sender_id"]."'
				";
				$exam->execute_query(); 

				$exam->query = "
				UPDATE user SET following_number = following_number + 1 WHERE user_id = '".$_SESSION["user_id"]."'
				";
				$exam->execute_query(); 

				$notification_text = 'mulai mengikuti Anda.';
				$exam->data = array(
				    ':notification_receiver_id' =>  $notification_row['user_id'],
				    ':notif_sender_id'      	=>  $_SESSION["user_id"],
				    ':notif_post_id'      		=>  $_POST["post_id"],
				    ':notification_text'    	=>  $notification_text,
				    ':read_notification'    	=>  'no',
				    ':notif_time'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
				    ':notif_update'       		=>  date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);

				$exam->query = "
				INSERT INTO pemberitahuan 
				(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
				VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
				";

				$exam->execute_query();     
		    }
		}

		if($_POST['action'] == "unfollow")
		{
			$exam->query = "
			DELETE FROM follow 
			WHERE sender_id = '".$_POST["sender_id"]."' 
			AND receiver_id = '".$_SESSION["user_id"]."'
			";

			if($exam->execute_query())
			{
				$exam->query = "
				UPDATE user 
				SET follower_number = follower_number - 1 
				WHERE user_id = '".$_POST["sender_id"]."'
				";
				$exam->execute_query();

				$exam->query = "
				UPDATE user SET following_number = following_number - 1 WHERE user_id = '".$_SESSION["user_id"]."'
				";
				$exam->execute_query();
			}
		}

		if($_POST['action'] == "pengikut")
		{
			$exam->query = "
	        SELECT * FROM user 
	        INNER JOIN follow 
	        ON follow.receiver_id = user.user_id 
	        WHERE follow.sender_id = '".$_POST["user_id"]."'
	        ";
	        $result = $exam->query_result();
	        $output = '';
	        foreach($result as $row)
	        {
				$user_foto = '';
				if($row['user_foto'] != 'user.png')
				{
					$user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle">';
				}
				else
				{
					$user_foto = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				}
				$tombol = '';
				if($row["user_id"] != $_SESSION["user_id"])
				{
					$output .= '
					<a href="javascript:void(0)">
						<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["user_nama_depan"].' <span class="time pull-right">'.$exam->make_follow_button_list($row["user_id"], $_SESSION["user_id"]).'</span></h5>
							<span class="mail-desc">
								'.$exam->get_sekolah($row["user_id"]).'
							</span>                 
						</div>
					</a>';
				}
				else
				{
					$output .= '
					<a href="javascript:void(0)">
						<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["user_nama_depan"].' <span class="time pull-right"> </span></h5>
							<span class="mail-desc">
								'.$exam->get_sekolah($row["user_id"]).'
							</span>                 
						</div>
					</a>';
				}
	          
	        }
	        echo $output;
		}

		if($_POST['action'] == "mengikuti")
		{
			$exam->query = "
	        SELECT * FROM user 
	        INNER JOIN follow 
	        ON follow.sender_id = user.user_id 
	        WHERE follow.receiver_id = '".$_POST["user_id"]."'
	        ";
	        $result = $exam->query_result();
	        $output = '';
	        foreach($result as $row)
	        {
				$user_foto = '';
				if($row['user_foto'] != 'user.png')
				{
					$user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle">';
				}
				else
				{
					$user_foto = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				}
				$tombol = '';
				if($row["user_id"] != $_SESSION["user_id"])
				{
					$output .= '
					<a href="javascript:void(0)">
						<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["user_nama_depan"].' <span class="time pull-right">'.$exam->make_follow_button_list($row["user_id"], $_SESSION["user_id"]).'</span></h5>
							<span class="mail-desc">
								'.$exam->get_sekolah($row["user_id"]).'
							</span>                 
						</div>
					</a>';
				}
				else
				{
					$output .= '
					<a href="javascript:void(0)">
						<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["user_nama_depan"].' <span class="time pull-right"> </span></h5>
							<span class="mail-desc">
								'.$exam->get_sekolah($row["user_id"]).'
							</span>                 
						</div>
					</a>';
				}
	          
	        }
	        echo $output;
		}

		if($_POST['action'] == "view_profil_posting")
		{
			$mulai = $_POST["start"];
			$akhir = $_POST["limit"];
			$exam->query = "
			SELECT * FROM postingan 
		    INNER JOIN user ON user.user_id = postingan.user_id 
		    WHERE user.user_id = '".$_POST["user_id"]."' 
		    GROUP BY postingan.post_id 
		    ORDER BY postingan.post_id DESC
			LIMIT ".$mulai.", ".$akhir."
			";
			$result = $exam->query_result();

			$total_row = $exam->total_row();

			$output = '';

			if($total_row > 0)
			{
				foreach($result as $row)
				{
					$foto_user = '';
					$postingan ='';
					$konten_konten = $row["post_konten"];
					$string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
					$string = $exam->convertToLink($string); 
					if($row['user_foto'] != 'user.png')
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
	                        <div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>
				        	';
						}					
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" />';
					    }
					}
					else
					{
						if($row['post_gambar'] !='')
						{				
							$postingan = '
							<div class="col-md-5 col-xs-12">
				              <a href="view_posting.php?data='.$row['post_id'].'">
				                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
				              </a>
				            </div>
				            <div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; margin-top: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
				            	</p>
				            </div>                      
				        ';
						}
						else
						{						
							$postingan = '
							<div class="col-md-7 col-xs-12">
				            	<p style="margin-bottom: 5px; color: black;"> 
				            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
				            	</p>
				            </div>
							';
						}

						$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
					    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					    $user_last_activity = $exam->fetch_user_last_activity($row["user_id"]);
					    if($user_last_activity > $current_timestamp)
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
					        <span class="profile-status online pull-right"></span>';
					    }
					    else
					    {
					        $foto_user = '
					        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
					    }
					    
					}

					$like_button = '';
					if($exam->is_user_has_already_like_content($_SESSION["user_id"], $row["post_id"]))
				   	{
				    	$like_button = '
				    	<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i> '.$exam->count_total_post_like($row["post_id"]).'</button>&nbsp;&nbsp;
				    	';
				   	}
				   	else
				   	{
				   		$like_button = '
				   		<button type="button" class="btn btn-link like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i> '.$exam->count_total_post_like($row["post_id"]).'</button>&nbsp;&nbsp;
				   		';
				   	}

				   	$tampil_like = '';
					if($exam->count_total_post_like($row["post_id"]) == '0')
					{
						$tampil_like = '';
					}
					else
					{
						$tampil_like = ''.$exam->count_total_post_like($row["post_id"]).' suka';
					}

						$tampil_komen = '';
					if($exam->count_comment($row["post_id"]) == '0')
					{
						$tampil_komen = '';
					}
					else
					{
						$tampil_komen = ''.$exam->count_comment($row["post_id"]).' komentar';
					}

					$output .= '
	                        <div class="sl-item" style="margin-bottom: 5px;">
	                            <div class="sl-left"> '.$foto_user.' </div>
	                            <div class="sl-right">
	                                <div> <a href="view_posting.php?data='.$row['post_id'].'" class="link">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'</a>
	                                	<p style="margin-bottom: 5px;"><span class="sl-date">'.$exam->tgl_ago($row["post_tgl"]).'</span></p>
	                                    <div class="m-t-20 row" style="margin-top: 5px;">
	                                    	'.$postingan.'
	                                    </div>
	                                    <div class="like-comm m-t-20" style="margin-top: 5px;">
	                                    	<div class="row text-center justify-content-md-center" style="display:none;">
		                                        <div class="col-4">
		                                        	'.$like_button.'
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="fa fa-comments-o" style="font-size: 18px;"></i> '.$exam->count_comment($row["post_id"]).'</button>
		                                        </div>
		                                        <div class="col-4">
		                                        	<button type="button" class="btn btn-link"> <i class="fa fa-retweet" style="font-size: 18px;"></i> </button>
		                                        </div>
	                                      	</div>
	                                    	<p><span class="sl-date"><a href="view_posting.php?data='.$row['post_id'].'" class="link">'.$tampil_like.'  &nbsp;'.$tampil_komen.'</a></span></p>
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
							                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.strip_tags($row["user_nama_depan"]).' '.strip_tags($row["user_nama_belakang"]).'  <small class="m-b-10 text-muted">'.$exam->count_comment($row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
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
	}

	if($_POST['page'] == 'pengaturan')
	{
		if($_POST['action'] == "gantifoto")
		{
			$image = $_POST['profil'];

			$exam->query = "SELECT user_foto FROM user WHERE user_id = '".$_SESSION["user_id"]."' ";
			$result = $exam->query_result();
			foreach($result as $row)
			{
				$nama_foto = $row["user_foto"];
			}

			if($nama_foto != 'user.png')
			{
				unlink("data/akun/profil/".$nama_foto);

				list($type, $image) = explode(';',$image);
				list(, $image) = explode(',',$image);

				$image = base64_decode($image);
				$image_name = uniqid().'.jpg';
				file_put_contents('data/akun/profil/'.$image_name, $image);

				$exam->query = "UPDATE user SET  user_foto = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

				$exam->execute_query();
			}
			else
			{
				list($type, $image) = explode(';',$image);
				list(, $image) = explode(',',$image);

				$image = base64_decode($image);
				$image_name = uniqid().'.jpg';
				file_put_contents('data/akun/profil/'.$image_name, $image);

				$exam->query = "UPDATE user SET  user_foto = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

				$exam->execute_query();
			}
		}

		if($_POST['action'] == 'load_total_notif')
		{
			$exam->query = "
			SELECT COUNT(notification_id) as total 
			FROM pemberitahuan 
			WHERE notification_receiver_id = '".$_SESSION["user_id"]."' 
			AND read_notification = 'no'
			";

			$result = $exam->query_result();
			
			$output ='';

			foreach($result as $row)
			{
				if($row["total"] > 0)
				{
					$output = '
					<i class="mdi mdi-bell-outline"></i>
						<div class="notify" id="total_notifikasi">
						<span class="heartbit"></span> <span class="point"></span>
					</div>';
				}
				else
				{
					$output = '
					<i class="mdi mdi-bell-outline"></i>';
				}
				echo $output;
			}
		}

		if($_POST['action'] == 'update_notification_status')
		{
			$exam->query = "
			UPDATE pemberitahuan 
			SET read_notification = 'yes' 
			WHERE notification_receiver_id = '".$_SESSION["user_id"]."'
			";

			$exam->execute_query();
		}

		if($_POST['action'] == 'load_pemberitahuan')
		{
			$exam->query = "
			SELECT * FROM pemberitahuan 
			INNER JOIN user ON user.user_id = pemberitahuan.notif_sender_id
			LEFT JOIN postingan ON post_id = pemberitahuan.notif_post_id
			WHERE notification_receiver_id = '".$_SESSION['user_id']."' 
			ORDER BY notification_id DESC
			";
			$result = $exam->query_result();

			$total_row = $exam->total_row();

			$output = '';

			if($total_row > 0)
			  {
			    foreach($result as $row)
			    {
			    	$konten_konten = $row["post_konten"];
				    $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
				    $user_foto = '';
				    if($row['user_foto'] != 'user.png')
				    {
				        $user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle">';
				    }
				    else
				    {
				        $user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				    }

				    if($row['notif_post_id'] != '0')
				    {
				    	$link = 'view_posting.php?data='.$row["notif_post_id"].'';
				    }
				    else
				    {
				    	$link = 'javascript:void(0)';
				    }

			    	$output	.= '
			    	<a href="'.$link.'">
                        <div class="user-img"> '.$user_foto.'</div>
                        <div class="mail-contnet">
                            <h5>'.strip_tags($row["user_nama_depan"]).'</h5> <span class="mail-desc">'.$row["notification_text"].' <b>'.$string.'</b></span> <span class="time">'.$exam->tgl_ago($row["notif_time"]).'</span> </div>
                    </a>
                    ';
			    }
			}
			echo $output;
		}
	}

	if($_POST['page'] == 'cari_posting')
	{
		if($_POST['action'] == "cari")
		{
			$mulai = $_POST["start"];
			$akhir = $_POST["limit"];
			$exam->query = "
			SELECT * FROM postingan 
			JOIN user ON user.user_id = postingan.user_id
			ORDER BY postingan.post_id DESC
			LIMIT ".$mulai.", ".$akhir."
			";

			$result = $exam->query_result();
			$total_data = $exam->total_row();

			$output = '
			<div class="card-body" style="padding: 10px;">
			    <ul class="search-listing">
			';

			if($total_data > 0)
			{
				foreach($result as $row)
				{
					$konten_konten = $row["post_konten"];
					$string = strip_tags($konten_konten, "<a><b><i><u><em><strong>");
					$string = $exam->convertToLink($string);
					$output .= '    
					    <li style="padding-top: 5px;padding-bottom: 5px;">
					        <h3><a href="view_posting.php?data='.$row['post_id'].'">'.$row["user_nama_depan"].' '.$row["user_nama_belakang"].'</a></h3>
					        <h6 class="search-links">'.$exam->tgl_ago($row["post_tgl"]).'</h6>
					        <p style="margin-bottom: 5px;">'.substr($string, 0,200).'</p>
					    </li>
					';
				}
			}
			else
			{
				$output .= '
				<tr>
					<td colspan="2" align="center">Data tidak ditemukan</td>
				</tr>
				';
			}
			$output .= '
			    </ul>
			</div>
			';
			echo $output;
		}
	}

	if($_POST['page'] == 'notif')
	{
		if($_POST['action'] == "load_notif")
		{
			$mulai = $_POST["start"];
			$akhir = $_POST["limit"];
			$exam->query = "
			SELECT * FROM pemberitahuan 
			INNER JOIN user ON user.user_id = pemberitahuan.notif_sender_id
			LEFT JOIN postingan ON post_id = pemberitahuan.notif_post_id
			WHERE notification_receiver_id = '".$_SESSION['user_id']."' 
			ORDER BY notification_id DESC
			LIMIT ".$mulai.", ".$akhir."
			";

			$result = $exam->query_result();

			$total_row = $exam->total_row();

			$output = '';

			if($total_row > 0)
			  {
			    foreach($result as $row)
			    {
			    	$konten_konten = $row["post_konten"];
			        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
				    $user_foto = '';
				    if($row['user_foto'] != 'user.png')
				    {
				        $user_foto = '<img src="data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle" style="width:40px; height:40px;">';
				    }
				    else
				    {
				        $user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
				    }
				    if($row['notif_post_id'] != '0')
				    {
				    	$link = 'view_posting.php?data='.$row["notif_post_id"].'';
				    }
				    else
				    {
				    	$link = 'javascript:void(0)';
				    }

				    if($row['user_id'] != $_SESSION["user_id"])
				    {
				    $output	.= '
				    	<a href="'.$link.'">
							<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
							<div class="mail-contnet" style="width: 80%;">
								<h5>'.strip_tags($row["user_nama_depan"]).' <span class="time pull-right">  </span></h5>
								<span class="mail-desc">
								'.$row["notification_text"].' '.$string.' <span class="time">'.$exam->tgl_ago($row["notif_time"]).'</span>
								</span>                 
							</div>
						</a>
				      ';
				    }
				    else
				    {
				    	$output	.= '
				    	<a href="'.$link.'">
							<div class="user-img" style="margin-bottom: 0px;"> '.$user_foto.' </div>
							<div class="mail-contnet" style="width: 80%;">
								<h5>'.strip_tags($row["user_nama_depan"]).' <span class="time pull-right"></span></h5>
								<span class="mail-desc">
								'.$row["notification_text"].' '.$string.' <span class="time">'.$exam->tgl_ago($row["notif_time"]).'</span>
								</span>                 
							</div>
						</a>
				      ';
				    }
			    }
			}
			echo $output;
		}

		if($_POST['action'] == "total_notif_chat")
		{
			$exam->query = "
			SELECT COUNT(chat_message_id) as total_chat
			FROM chat_message 
			WHERE from_user_id = from_user_id
			AND to_user_id = '".$_SESSION["user_id"]."'
			AND status = '1'
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				if($row["total_chat"] > 0)
				{
					$output = '
					<i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i>
						<div class="notify" id="notifikasi_chat" style="right: 4px; top: -16px;">
							<span class="heartbit"></span> <span class="point"></span>
						</div>
					';
				}
				else
				{
					$output = '
					<i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i>';
				}
				echo $output;
			}
		}
	}

	if($_POST['page'] == 'chat')
	{
		if($_POST['action'] == "list_chat")
		{
			$output='';
		 	$exam->query = "
		    SELECT * FROM user
		    WHERE user_id != '".$_SESSION["user_id"]."'
		    ";
		    $result = $exam->query_result();
		    $total_rows = $exam->total_row();
		 	if($total_rows > 0)
		 	{
		  		foreach($result as $row)
		    	{
		      		$user_foto = '';
		      		if($row['user_foto'] != 'user.png')
		      		{
		        		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		        		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		        		$user_last_activity = $exam->fetch_user_last_activity($row['user_id']);
		        		if($user_last_activity > $current_timestamp)
		        		{
		          			$user_foto = '
		          			<img src="../data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span>';
		        		}
		        		else
		        		{
		          			$user_foto = '<img src="../data/akun/profil/'.$row["user_foto"].'" alt="user" class="img-circle">';
		       			}        
		     		}
		      		else
		      		{
		        		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		        		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		        		$user_last_activity = $exam->fetch_user_last_activity($row['user_id']);
		        		if($user_last_activity > $current_timestamp)
		        		{
		          			$user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span> <span class="profile-status online pull-right"></span>';
		        		}
		        		else
		        		{
		          			$user_foto = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>';
		        		}
		      		}
		 
		      		$exam->query = "
		      		SELECT * FROM chat_message
		      		WHERE (from_user_id = '".$_SESSION["user_id"]."' 
		      		AND to_user_id = '".$row['user_id']."') 
		      		OR (from_user_id = '".$row['user_id']."' 
		      		AND to_user_id = '".$_SESSION["user_id"]."') 
		      		ORDER BY time_chat DESC
		      		LIMIT 1
		      		";
		      		$result_chat = $exam->query_result();
		      		foreach($result_chat as $data)
		      		{
		      			$chat_konten = '';		
	        			$chat_konten = $data["chat_konten"];
				        $string = strip_tags($chat_konten, "<a><b><i><u><em><strong>");
		        		if($data["from_user_id"] == $row['user_id'] )
		        		{ 
		          			$status_pesan = '';
		          			if($data["status"] == '0')
		          			{          
		            			$status_pesan = ''.substr($string, 0, 18).'';
		          			}
		          			if($data["status"] == '1')
		          			{          
		            			$status_pesan = ''.substr($string, 0, 18).'';
		          			}
		          			if($data["status"] == '2')
		          			{          
		            			$status_pesan = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
		          			}    
		        		}
		        		else
		        		{
		          			$status_pesan = '';
		          			if($data["status"] == '0')
		          			{          
		            			$status_pesan = '<span class="mdi mdi-check-all text-primary"></span> '.substr($string, 0, 18).'';
		          			}
		          			if($data["status"] == '1')
		          			{          
		            			$status_pesan = '<span class="mdi mdi-check"></span> '.substr($string, 0, 18).'';
		          			}
		          			if($data["status"] == '2')
		          			{          
		            			$status_pesan = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
		          			}
		        		}
		      			$output .= '

		      			<a href="javascript:void(0)" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['user_username'].'" data-foto="../data/akun/profil/'.$row['user_foto'].'" style="padding-bottom: 3px; padding-top: 10px;">
	                        <div class="user-img"> '.$user_foto.' </div>
	                        <div class="mail-contnet" style="width: 81%;">
	                            <h5>'.strip_tags($row["user_nama_depan"]).' <span class="time pull-right">'.$exam->tgl_ago($data["time_chat"]).'</span></h5>
	                            <span class="mail-desc">
	                            	'.$status_pesan.'  '.$exam->fetch_is_type_status($row['user_id']).'  <span class="time pull-right">'.$exam->count_unseen_message($row['user_id'], $_SESSION['user_id']).'</span>
	                            </span>
	                           
	                        </div>
	                    </a>
		      			';    
		    		}
		  		}
		    		echo $output;
		 	}
		 	else
		 	{
				$output = 'Nobody has share nothing';
		 	}
		}
	}

	if($_POST['page'] == 'tugas')
	{
		if($_POST['action'] == "load_data_tugas")
		{
			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN ujian ON ujian.ujian_id = kelasujian.kelasujian_ujian_id
			INNER JOIN mapel ON mapel.mapel_id = ujian.ujian_mapel
			INNER JOIN user ON user.user_kelas_id = kelasujian.kelasujian_kelas_id
			WHERE user.user_id = '".$_SESSION['user_id']."'
			ORDER BY kelasujian.kelasujian_id DESC
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				$status_ujian_user = '';

				$kerjakan = '';				

				if($row['kelasujian_status'] == 'Mulai')
				{
					if($exam->If_user_konfirmasi($row['ujian_id'], $_SESSION['user_id']))
					{
						$status_ujian_user = $exam->status_ujian_user($row['ujian_id'], $_SESSION['user_id']);

						if($status_ujian_user == 'Absen')
						{
							$kerjakan = '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm pull-right">Kerjakan</a>';
						}

						if($status_ujian_user == 'Sedang Mengerjakan')
						{
							$kerjakan = '<a href="tugas_proses.php?code='.$row["ujian_code"].'" class="btn btn-info btn-sm pull-right">Kerjakan</a>';
						}

						if($status_ujian_user == 'Selesai')
						{
							$kerjakan = '<a href="hasil.php?code='.$row["ujian_code"].'" class="btn btn-success btn-sm pull-right">Lihat Hasil</a>';
						}
					}
					else
					{
						$kerjakan = '<button type="button" name="konfirmasi" id="konfirmasi" class="btn btn-warning btn-sm pull-right" data-ujian_id="'.$row['ujian_id'].'">Konfirmasi</button>';
					}
				}
				else
				{
					
				}

				$output	.= '
			    <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 3px;">'.$row['ujian_judul'].'</h4>
                        <p class="card-text" style="margin-bottom: 0px;">Nama Mapel: '.$row['mapel_nama'].'</p>
                        <p class="card-text" style="margin-bottom: 0px;"> Jumlah Soal: '.$exam->jumlah_soal($row['ujian_id']).' (Durasi '.$row['ujian_durasi'].' Menit)</p>
                        <p class="card-text" style="margin-bottom: 0px;">Info Soal: '.$row['ujian_info'].'</p>
                        <p class="card-text" style="margin-bottom: 5px;"><small class="text-muted">'.$row['ujian_tanggal'].' - Status: '.$row['kelasujian_status'].'</small></p>
                        '.$kerjakan.'
                    </div>
                </div>
			';
			}		
			echo $output;
		}

		if($_POST['action'] == "tampil_tugas")
		{
			$exam->query = "
			SELECT * FROM materi
			INNER JOIN kelasmateri ON kelasmateri.kelasmateri_materi_id = materi.materi_id
			INNER JOIN user ON user.user_kelas_id = kelasmateri.kelasmateri_kelas_id
			WHERE  user.user_id = '".$_SESSION["user_id"]."' AND materi_mapel_id = '".$_POST["mapel_id"]."'
			GROUP BY materi_id
			";

			$result = $exam->query_result();

			$output ='<ul class="list-icons" style="padding-left: 25px;">';

			foreach($result as $row)
			{
				$output	.= '                
			    <li>
			        <a href="view_materi.php?data='.$row['materi_id'].'"><i class="fa fa-check text-info"></i> '.$row['materi_nama'].'</a>
			    </li>';
			}
			$output .= '</ul>';	
			echo $output;
		}

		if($_POST['action'] == "view_data_materi")
		{
			$exam->query = "
			SELECT * FROM materi
			JOIN user ON user.user_id = materi.materi_user_id
			WHERE materi_id = '".$_POST['materi_id']."'
			";

			$result = $exam->query_result();

			$output ='';

			foreach($result as $row)
			{
				$output	.= '
				<h4 class="card-title">'.$row['materi_nama'].'</h4>
				<h6 class="card-subtitle">'.$exam->tgl_ago($row['materi_tgl']).'  oleh:  '.$row['user_nama_depan'].' '.$row['user_nama_belakang'].'</h6>
				<p class="text-justify">'.$row['materi_data'].'</p>
				';
			}		
			echo $output;
		}
	}
	
}

?>