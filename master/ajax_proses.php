<?php

//ajax_action.php

include('koneksi.php');

require_once('../class/class.phpmailer.php');

$exam = new Koneksi;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM admin 
			WHERE admin_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$admin_verification_code = md5(rand());

			$receiver_email = $_POST['admin_email_address'];

			$exam->data = array(
				':admin_email_address'		=>	$receiver_email,
				':admin_password'			=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'	=>	$admin_verification_code,
				':admin_type'				=>	'sub_master', 
				':admin_created_on'			=>	$current_datetime,
				':email_verified'			=>	'yes'
			);

			$exam->query = "
			INSERT INTO admin
			(admin_email_address, admin_password, admin_verfication_code, admin_type, admin_created_on, email_verified) 
			VALUES 
			(:admin_email_address, :admin_password, :admin_verfication_code, :admin_type, :admin_created_on, :email_verified)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':admin_email_address'	=>	$_POST['admin_email_address']
			);

			$exam->query = "
			SELECT * FROM admin
			WHERE admin_email_address = :admin_email_address
			";

			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();

				foreach($result as $row)
				{
					if($row['email_verified'] == 'yes')
					{
						if(password_verify($_POST['admin_password'], $row['admin_password']))
						{
							$_SESSION['admin_id'] = $row['admin_id'];
							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'	=>	'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'		=>	'Wrong Email Address'
				);
			}
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'user')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM user
			WHERE ";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'user_email LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_nama_depan LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_jk LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_hp LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			
			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY user_id DESC ';
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
			SELECT * FROM user";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../data/akun/profil/'.$row["user_foto"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_nama_depan"];
				$sub_array[] = $row["user_email"];
				$sub_array[] = $row["user_jk"];
				$sub_array[] = $row["user_hp"];
				$is_email_verified = '';
				if($row["user_email_verified"] == 'yes')
				{
					$is_email_verified = '<label class="badge badge-success">Yes</label>';
				}
				else
				{
					$is_email_verified = '<label class="badge badge-danger">No</label>';	
				}
								
				$sub_array[] = $is_email_verified;
				$sub_array[] = '<button type="button" name="view_detail" class="btn btn-primary btn-sm details" id="'.$row["user_id"].'">View Details</button>';
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

		if($_POST['action'] == 'fetch_data')
		{
			$exam->query = "
			SELECT * FROM user
			WHERE user_id = '".$_POST["user_id"]."'
			";
			$result = $exam->query_result();
			$output = '';
			foreach($result as $row)
			{
				$is_email_verified = '';
				if($row["user_email_verified"] == 'yes')
				{
					$is_email_verified = '<label class="badge badge-success">Email Verified</label>';
				}
				else
				{
					$is_email_verified = '<label class="badge badge-danger">Email Not Verified</label>';	
				}

				$output .= '
				<div class="row">
					<div class="col-md-12">
						<div align="center">
							<img src="../data/akun/profil/'.$row["user_foto"].'" class="img-thumbnail" width="200" />
						</div>
						<br />
						<table class="table table-bordered">
							<tr>
								<th>Name</th>
								<td>'.$row["user_nama_depan"].'</td>
							</tr>
							<tr>
								<th>Gender</th>
								<td>'.$row["user_jk"].'</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>'.$row["user_alamat"].'</td>
							</tr>
							<tr>
								<th>Mobile No.</th>
								<td>'.$row["user_hp"].'</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>'.$row["user_email"].'</td>
							</tr>
							<tr>
								<th>Email Status</th>
								<td>'.$is_email_verified.'</td>
							</tr>
						</table>
					</div>
				</div>
				';
			}	
			echo $output;			
		}
	}

	if($_POST['page'] == 'ujian')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM ujian
			WHERE ujian_admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'ujian_judul LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR ujian_mapel LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR ujian_tanggal LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY ujian_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM ujian
			WHERE ujian_admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['ujian_judul']);

				$sub_array[] = $row['ujian_mapel'];

				$sub_array[] = $row['ujian_tanggal'];

				$soal_button = '';
				$edit_button = '';
				$delete_button = '';

				if($exam->Batas_jumlah_soal($row['ujian_id']))
				{
					$soal_button = '
					<button type="button" name="add_soal" class="btn btn-warning btn-sm add_soal" id="'.$row['ujian_id'].'">'.$exam->jumlah_soal($row['ujian_id']).' <small>Tambah Soal</small></button>
					';
				}
				else
				{
					$soal_button = '
					<a href="soal.php?code='.$row['ujian_code'].'" class="btn btn-info btn-sm">Lihat Soal</a>
					<a href="kelas_ujian.php?code='.$row['ujian_code'].'" class="btn btn-success btn-sm">Kelas</a>
					';
				}

				$hasil_ujian = '<a href="hasil_ujian.php?code='.$row['ujian_code'].'" class="btn btn-info btn-sm">Hasil Ujian</a>';

				$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['ujian_id'].'">Edit</button>';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['ujian_id'].'">Delete</button>';

				$sub_array[] = $soal_button;

				$sub_array[] = $edit_button . ' ' . $delete_button .' '.$hasil_ujian;			

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':ujian_admin_id'		=>	$_SESSION['admin_id'],
				':ujian_judul'			=>	$exam->clean_data($_POST['ujian_judul']),
				':ujian_mapel'			=>	$exam->clean_data($_POST['ujian_mapel']),
				':ujian_tanggal'		=>	$_POST['ujian_tanggal'] . ':00',
				':ujian_durasi'			=>	$_POST['ujian_durasi'],
				':ujian_jumlah_soal'	=>	$_POST['ujian_jumlah_soal'],
				':ujian_acak'			=>	$_POST['ujian_acak'],
				':ujian_code'			=>	md5(rand())
			);

			$exam->query = "
			INSERT INTO ujian
			(ujian_admin_id, ujian_judul, ujian_mapel, ujian_tanggal, ujian_durasi, ujian_jumlah_soal, ujian_acak, ujian_code) 
			VALUES (:ujian_admin_id, :ujian_judul, :ujian_mapel, :ujian_tanggal, :ujian_durasi, :ujian_jumlah_soal, :ujian_acak, :ujian_code)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'New Exam Details Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_ambil')
		{
			$exam->query = "
			SELECT * FROM ujian
			WHERE ujian_id = '".$_POST["ujian_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['ujian_judul'] = $row['ujian_judul'];

				$output['ujian_mapel'] = $row['ujian_mapel'];

				$output['ujian_tanggal'] = $row['ujian_tanggal'];

				$output['ujian_durasi'] = $row['ujian_durasi'];

				$output['ujian_jumlah_soal'] = $row['ujian_jumlah_soal'];

				$output['ujian_acak'] = $row['ujian_acak'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':ujian_judul'			=>	$exam->clean_data($_POST['ujian_judul']),
				':ujian_mapel'			=>	$exam->clean_data($_POST['ujian_mapel']),
				':ujian_tanggal'		=>	$_POST['ujian_tanggal'],
				':ujian_durasi'			=>	$_POST['ujian_durasi'],
				':ujian_jumlah_soal'	=>	$_POST['ujian_jumlah_soal'],
				':ujian_acak'			=>	$_POST['ujian_acak'],
				':ujian_id'				=>	$_POST['ujian_id']
			);

			$exam->query = "
			UPDATE ujian
			SET ujian_judul = :ujian_judul, ujian_mapel = :ujian_mapel, ujian_tanggal = :ujian_tanggal, ujian_durasi = :ujian_durasi, ujian_jumlah_soal = :ujian_jumlah_soal, ujian_acak = :ujian_acak  
			WHERE ujian_id = :ujian_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Exam Details has been changed'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':ujian_id'	=>	$_POST['ujian_id']
			);

			$exam->query = "
			DELETE FROM ujian
			WHERE ujian_id = :ujian_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}		
	}

	if($_POST['page'] == 'kelasujian')
	{
		if($_POST['action'] == 'ambil_kelas')
		{
			$output = array();
			$ujian_id = '';
			if(isset($_POST['code']))
			{
				$ujian_id = $exam->Get_ujian_id($_POST['code']);
			}
			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN kelas ON kelas.kelas_id = kelasujian.kelasujian_kelas_id
			WHERE kelasujian_ujian_id = '".$ujian_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'kelas_nama LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR kelas_jurusan LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR kelas_sekolah LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY kelasujian_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM kelasujian
			INNER JOIN kelas ON kelas.kelas_id = kelasujian.kelasujian_kelas_id
			WHERE kelasujian_ujian_id = '".$ujian_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row['kelas_tingkat'];

				$sub_array[] = $row['kelas_nama'];

				$sub_array[] = $row['kelas_jurusan'];

				$sub_array[] = $row['kelas_sekolah'];

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

				$delete_button = '';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete_kelasujian" id="'.$row['kelasujian_id'].'">Delete</button>';

				$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit_status" id="'.$row['kelasujian_id'].'">Status</button>';


				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'add_kelasujian')
		{
			$ujian_id = $exam->Get_ujian_id($_POST['code']);
			$exam->data = array(
				':kelasujian_kelas_id'		=>	$_POST['kelas_id'],
				':kelasujian_ujian_id'		=>  $ujian_id
			);

			$exam->query = "
			INSERT INTO kelasujian
			(kelasujian_kelas_id, kelasujian_ujian_id) 
			VALUES (:kelasujian_kelas_id, :kelasujian_ujian_id)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Kelas Ujian berhasil di tambahkan'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete_kelasujian')
		{
			$exam->data = array(
				':kelasujian_id'	=>	$_POST['kelasujian_id']
			);

			$exam->query = "
			DELETE FROM kelasujian
			WHERE kelasujian_id = :kelasujian_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Kelas Ujian berhasil di hapus'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'status_kelasujian')
		{
			$exam->data = array(
				':kelasujian_id'		=>	$_POST['kelasujian_id'],
				':kelasujian_status'	=>	$_POST['kelasujian_status']
			);

			$exam->query = "
			UPDATE kelasujian
			SET kelasujian_status = :kelasujian_status 
			WHERE kelasujian_id = :kelasujian_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Status Kelas diganti'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'soal')
	{
		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':soal_ujian_id'		=>	$_POST['ujian_id'],
				':soal_teks'			=>	$_POST['soal_teks'],
				':soal_kunci'			=>	$_POST['soal_kunci']
			);

			$exam->query = "
			INSERT INTO soal
			(soal_ujian_id, soal_teks, soal_kunci) 
			VALUES (:soal_ujian_id, :soal_teks, :soal_kunci)
			";

			$soal_id = $exam->execute_question_with_last_id($exam->data);

			for($count = 1; $count <= 5; $count++)
			{
				$exam->data = array(
					':pilihan_soal_id'	=>	$soal_id,
					':pilihan_no'		=>	$count,
					':pilihan_teks'		=>	$exam->clean_data($_POST['pilihan_teks_' . $count])
				);

				$exam->query = "
				INSERT INTO pilihan_soal 
				(pilihan_soal_id, pilihan_no, pilihan_teks) 
				VALUES (:pilihan_soal_id, :pilihan_no, :pilihan_teks)
				";

				$exam->execute_query($exam->data);
			}

			$output = array(
				'success'		=>	'Soal Berhasil ditambahkan'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'ambil')
		{
			$output = array();
			$ujian_id = '';
			if(isset($_POST['code']))
			{
				$ujian_id = $exam->Get_ujian_id($_POST['code']);
			}
			$exam->query = "
			SELECT * FROM soal 
			WHERE soal_ujian_id = '".$ujian_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'soal_teks LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY soal_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM soal 
			WHERE soal_ujian_id = '".$ujian_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row['soal_teks'];

				$sub_array[] = $row['soal_kunci'];

				$edit_button = '';
				$delete_button = '';

				$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['soal_id'].'">Edit</button>';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['soal_id'].'">Delete</button>';


				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_ambil')
		{
			$exam->query = "
			SELECT * FROM soal 
			WHERE soal_id = '".$_POST["soal_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['soal_teks'] = html_entity_decode($row['soal_teks']);

				$output['soal_kunci'] = $row['soal_kunci'];

				for($count = 1; $count <= 5; $count++)
				{
					$exam->query = "
					SELECT pilihan_teks FROM pilihan_soal 
					WHERE pilihan_soal_id = '".$_POST["soal_id"]."' 
					AND pilihan_no = '".$count."'
					";

					$sub_result = $exam->query_result();

					foreach($sub_result as $sub_row)
					{
						$output["pilihan_teks_" . $count] = html_entity_decode($sub_row["pilihan_teks"]);
					}
				}
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':soal_id'				=>	$_POST['soal_id'],
				':soal_teks'			=>	$_POST['soal_teks'],
				':soal_kunci'			=>	$_POST['soal_kunci']
			);

			$exam->query = "
			UPDATE soal 
			SET soal_teks = :soal_teks, soal_kunci = :soal_kunci
			WHERE soal_id = :soal_id
			";

			$exam->execute_query();

			for($count = 1; $count <= 5; $count++)
			{
				$exam->data = array(
					':pilihan_soal_id'	=>	$_POST['soal_id'],
					':pilihan_no'		=>	$count,
					':pilihan_teks'		=>	$_POST['pilihan_teks_' . $count]
				);

				$exam->query = "
				UPDATE pilihan_soal 
				SET pilihan_teks = :pilihan_teks 
				WHERE pilihan_soal_id = :pilihan_soal_id 
				AND pilihan_no = :pilihan_no
				";
				$exam->execute_query();
			}

			$output = array(
				'success'	=>	'Soal Berhasil di Perbaharui'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':soal_id'	=>	$_POST['soal_id']
			);

			$exam->query = "
			DELETE FROM soal
			WHERE soal_id = :soal_id
			";
			$exam->execute_query();

			$exam->data = array(
				':pilihan_soal_id'	=>	$_POST['soal_id']
			);

			$exam->query = "
			DELETE FROM pilihan_soal
			WHERE pilihan_soal_id = :pilihan_soal_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Soal telah di hapus'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'kelas')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM kelas
			WHERE ";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'kelas_tingkat LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR kelas_nama LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR kelas_jurusan LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			
			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY kelas_id DESC ';
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
			SELECT * FROM kelas";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row["kelas_tingkat"];
				$sub_array[] = $row["kelas_nama"];
				$sub_array[] = $row["kelas_jurusan"];

				$sub_array[] = '<a href="#" class="btn btn-info btn-sm lihat_daftar_siswa" name="lihat_daftar_siswa" id="'.$row['kelas_id'].'" data-kelas="'.$row['kelas_nama'].'"><i class="fa fa-users"></i>  '.$exam->get_jumlah_siswa_kelas($row['kelas_id']).' Lihat User</a>';

				$edit_button = '';
				$delete_button = '';

				$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['kelas_id'].'">Edit</button>';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['kelas_id'].'">Delete</button>';
				
				$sub_array[] = $edit_button . ' ' . $delete_button;
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

		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':kelas_tingkat'		=>	$_POST['kelas_tingkat'],
				':kelas_nama'			=>	$exam->clean_data($_POST['kelas_nama']),
				':kelas_jurusan'		=>	$_POST['kelas_jurusan'],
				':kelas_sekolah'		=>	$_POST['kelas_sekolah']
			);

			$exam->query = "
			INSERT INTO kelas
			(kelas_tingkat, kelas_nama, kelas_jurusan, kelas_sekolah) 
			VALUES (:kelas_tingkat, :kelas_nama, :kelas_jurusan, :kelas_sekolah)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Kelas Baru telah ditambahkan'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_ambil')
		{
			$exam->query = "
			SELECT * FROM kelas
			WHERE kelas_id = '".$_POST["kelas_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['kelas_tingkat'] 	= $row['kelas_tingkat'];

				$output['kelas_nama'] 		= $row['kelas_nama'];

				$output['kelas_jurusan'] 	= $row['kelas_jurusan'];

				$output['kelas_sekolah'] 	= $row['kelas_sekolah'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':kelas_tingkat'		=>	$_POST['kelas_tingkat'],
				':kelas_nama'			=>	$exam->clean_data($_POST['kelas_nama']),
				':kelas_jurusan'		=>	$_POST['kelas_jurusan'],
				':kelas_sekolah'		=>	$_POST['kelas_sekolah'],
				':kelas_id'				=>	$_POST['kelas_id']
			);

			$exam->query = "
			UPDATE kelas
			SET kelas_tingkat = :kelas_tingkat, kelas_nama = :kelas_nama, kelas_jurusan = :kelas_jurusan, kelas_sekolah = :kelas_sekolah  
			WHERE kelas_id = :kelas_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Kelas berhasil di perbaharui'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':kelas_id'	=>	$_POST['kelas_id']
			);

			$exam->query = "
			DELETE FROM kelas
			WHERE kelas_id = :kelas_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Kelas Berhasil di Hapus'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'lihat_daftar_siswa')
		{
			$exam->query = "
			SELECT * FROM user
			INNER JOIN kelas ON kelas.kelas_id=user.user_kelas_id
			WHERE user.user_kelas_id = '".$_POST["id"]."'
			";
			$result = $exam->query_result();

			$output = '<div class="table-responsive">
							<table id="daftar_siswa_tabel" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Email</th>
									</tr>
								</thead>';

			foreach($result as $row)
			{
				$output .= '
								<tr>
									<td>'.$row["user_nama_depan"].'</td>
									<td>'.$row["user_email"].'</td>
								</tr>';
			}
			$output .= '</table></div>
			<script>
			  $(function () {
			    $("#daftar_siswa_tabel").DataTable();
			  });
			</script>';

			echo $output;
		}
	}
	
	if($_POST['page'] == 'hasil_ujian')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();
			$ujian_id = $exam->Get_ujian_id($_POST["code"]);
			$exam->query = "
			SELECT user.user_id, user.user_foto, user.user_nama_depan, sum(jawaban.nilai) as total_nilai  
			FROM jawaban  
			INNER JOIN user 
			ON user.user_id = jawaban.jawaban_user_id 
			WHERE jawaban.jawaban_ujian_id = '$ujian_id' 
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user.user_nama_depan LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= '
			) 
			GROUP BY jawaban.jawaban_user_id 
			';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY total_nilai DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT 	user.user_foto, user.user_nama_depan, sum(jawaban.nilai) as total_nilai  
			FROM jawaban  
			INNER JOIN user 
			ON user.user_id = jawaban.jawaban_user_id 
			WHERE jawaban.jawaban_ujian_id = '$ujian_id' 
			GROUP BY jawaban.jawaban_user_id 
			ORDER BY total_nilai DESC
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../data/akun/profil/'.$row["user_foto"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_nama_depan"];
				$sub_array[] = $exam->status_ujian_user($ujian_id, $row["user_id"]);
				$sub_array[] = $row["total_nilai"];
				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'materi')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM materi
			WHERE ";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'materi.materi_nama LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			
			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY materi.materi_id DESC ';
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
			SELECT * FROM materi
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = substr($row["materi_nama"], 0, 100);
				$sub_array[] = strip_tags(substr($row["materi_data"], 0, 160));
				$sub_array[] = '<a href="kelas_materi.php?code='.$row['materi_id'].'" class="btn btn-success btn-sm">'.$exam->jumlah_kelasmateri($row['materi_id']).' Kelas</a>';
				$sub_array[] = $row["materi_tgl"];

				$edit_button = '';
				$delete_button = '';

				$edit_button = '<button type="button" name="edit_materi" class="btn btn-primary btn-sm edit_materi" id="'.$row['materi_id'].'">Edit</button>';

				$delete_button = '<button type="button" name="delete_materi" class="btn btn-danger btn-sm delete_materi" id="'.$row['materi_id'].'">Delete</button>';

				$sub_array[] = $edit_button . ' ' . $delete_button;
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

		if($_POST['action'] == 'Addmateri')
		{
			$exam->data = array(
				':materi_nama'		=>	$_POST['materi_nama'],
				':materi_mapel_id'	=>	$_POST['materi_mapel_id'],
				':materi_data'		=>	nl2br($_POST['materi_data']),
				':materi_user_id'	=>	$_SESSION['admin_id']
			);

			$exam->query = "
			INSERT INTO materi
			(materi_nama, materi_mapel_id, materi_data, materi_user_id) 
			VALUES (:materi_nama, :materi_mapel_id, :materi_data, :materi_user_id)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Materi Baru telah ditambahkan'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_ambilmateri')
		{
			$exam->query = "
			SELECT * FROM materi
			WHERE materi_id = '".$_POST["materi_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['materi_nama'] = $row['materi_nama'];

				$output['materi_mapel_id'] = $row['materi_mapel_id'];

				$output['materi_data'] = $row['materi_data'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit_materi')
		{
			$exam->data = array(
				':materi_nama'			=>	$_POST['materi_nama'],
				':materi_data'			=>	$_POST['materi_data']
			);

			$exam->query = "
			UPDATE materi
			SET materi_nama = :materi_nama, materi_data = :materi_data  
			WHERE materi_id = :materi_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Materi berhasil diperbaharui'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete_materi')
		{
			$exam->data = array(
				':materi_id'	=>	$_POST['materi_id']
			);

			$exam->query = "
			DELETE FROM materi
			WHERE materi_id = :materi_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Materi telah dihapus'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'kelasmateri')
	{
		if($_POST['action'] == 'ambil_kelas_materi')
		{
			$output = array();

			$materi_id = $_POST['code'];

			$exam->query = "
			SELECT * FROM kelasmateri
			INNER JOIN kelas ON kelas.kelas_id = kelasmateri.kelasmateri_kelas_id
			WHERE kelasmateri.kelasmateri_materi_id = ".$materi_id." 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'kelas.kelas_nama LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR kelas.kelas_jurusan LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR kelas.kelas_sekolah LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY kelasmateri.kelasmateri_materi_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM kelasmateri
			INNER JOIN kelas ON kelas.kelas_id = kelasmateri.kelasmateri_kelas_id
			WHERE kelasmateri.kelasmateri_materi_id = ".$materi_id."
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row['kelas_tingkat'];

				$sub_array[] = $row['kelas_nama'];

				$sub_array[] = $row['kelas_jurusan'];

				$sub_array[] = $row['kelas_sekolah'];

				$delete_button = '';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete_kelasmateri" id="'.$row['kelasmateri_id'].'">Delete</button>';

				$sub_array[] = $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'add_kelasmateri')
		{
			$exam->data = array(
				':kelasmateri_kelas_id'		=>	$_POST['kelas_id'],
				':kelasmateri_materi_id'	=>  $_POST['code']
			);

			$exam->query = "
			INSERT INTO kelasmateri
			(kelasmateri_kelas_id, kelasmateri_materi_id) 
			VALUES (:kelasmateri_kelas_id, :kelasmateri_materi_id)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Materi Kelas berhasil di tambahkan'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete_kelasmateri')
		{
			$exam->data = array(
				':kelasmateri_id'	=>	$_POST['kelasmateri_id']
			);

			$exam->query = "
			DELETE FROM kelasmateri
			WHERE kelasmateri_id = :kelasmateri_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Kelas Ujian berhasil di hapus'
			);

			echo json_encode($output);
		}		
	}

	if($_POST['page'] == 'postingan')
	{
		if($_POST['action'] == 'ambil')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM postingan
			JOIN user 
			WHERE user.user_id = postingan.user_id 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'postingan.post_konten LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user.user_nama_depan LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY postingan.post_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM postingan
			INNER JOIN user 
			WHERE user.user_id = postingan.user_id 
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$nama 	= '';
				$email 	= '';

				$nama = $row['user_nama_depan'];
				$email = $row['user_email'];

				$sub_array[] = $nama.'  '.$email;

				$sub_array[] = strip_tags($row['post_konten']);

				$sub_array[] = $row['post_tgl'];

				$delete_button = '';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete_postingan" id="'.$row['post_id'].'">Hapus</button>';

				$sub_array[] = $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}
		
		if($_POST['action'] == 'delete_postingan')
		{
			$exam->data = array(
				':post_id'	=>	$_POST['post_id']
			);

			$exam->query = "
			DELETE FROM postingan
			WHERE post_id = :post_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Postingan berhasil di hapus'
			);

			echo json_encode($output);
		}
	}

}

?>