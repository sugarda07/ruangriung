<?php

//pdf_exam_result.php

include('master/koneksi.php');

require_once('class/pdf.php');

$exam = new Koneksi;

if(isset($_GET["code"]))
{
	$ujian_id = $exam->Get_ujian_id($_GET['code']);

	$nama_ujian = $exam->Get_nama_ujian($_GET["code"]);

	$nama_mapel = $exam->Get_nama_mapel($_GET["code"]);

	$tanggal_ujian = $exam->Get_tanggal_ujian($_GET["code"]);

	$foto_status = $exam->Get_foto_user($_SESSION["user_id"]);

    $nama_user = $exam->Get_nama_lengkap($_SESSION["user_id"]);

    $jumlah_soal = $exam->jumlah_soal($ujian_id);

    $durasi_soal = $exam->durasi_soal($_GET['code']);

	$exam->query = "
	SELECT * FROM soal
	INNER JOIN jawaban ON jawaban.jawaban_soal_id = soal.soal_id 
	WHERE soal.soal_ujian_id = '$ujian_id' 
	AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."'
	";

	$result = $exam->query_result();

	$output = '
		<table width="100%" class="table table-bordered">
			<tbody>
				<tr>
					<td width="20%" align="center" rowspan="5">'.$foto_status.'</td>
					<td>Nama: <b>'.$nama_user.'</b>  '.$exam->get_nama_kelas_user($ujian_id, $_SESSION["user_id"]).'</td>
					<td width="20%" align="center" rowspan="1">Nilai</td>
				</tr>
				<tr>
					<td>Quiz: '.$nama_ujian.'</td>
					<td width="20%" align="center" rowspan="4" style="font-size: 30px;"><b>'.$exam->Get_nilai_user($_SESSION["user_id"], $ujian_id).'</b></td>
				</tr>
				<tr>
					<td>Mapel: '.$nama_mapel.'</td>
				</tr>
				<tr>
					<td>'.$jumlah_soal.' Soal, Durasi: '.$durasi_soal.' Menit</td>
				</tr>
				<tr>
					<td>Tanggal: '.date('l, d F Y', strtotime($tanggal_ujian)).'</td>
				</tr>
			</tbody>
		</table>
		<hr/>
	';

	$total_mark = 0;
	$no = 1;

	foreach($result as $row)
	{
		$exam->query = "
		SELECT * FROM pilihan_soal
		WHERE pilihan_soal_id = '".$row["soal_id"]."'
		";

		$sub_result = $exam->query_result();

		$jawaban_user = '';
		$kunci_jawaban = '';
		$hasil_soal = '';

		if($row['nilai'] == '0')
		{
			$hasil_soal = '<span class="badge badge-dark">Belum di Isi</span>';
		}

		if($row['nilai'] > '0')
		{
			$hasil_soal = '<span class="badge badge-success">Benar</span>';
		}

		if($row['nilai'] < '0')
		{
			$hasil_soal = '<span class="badge badge-danger">Salah</span>';
		}

		if($row['nilai'] == '-0')
		{
			$hasil_soal = '<span class="badge badge-danger">Salah</span>';
		}

		$output .= '
		<div class="card-body">
		<div class="row">
			'.$no.'.&nbsp; '.strip_tags($row['soal_teks'], "<br><br/><br /><a><b><i><u><em><strong><sub><span><p><div><h3> <img>").'
		</div>
		<div class="row">
		';
		$count = 1;
		foreach($sub_result as $sub_row)
		{
			$is_checked= '';

			if($exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']) == $count)
			{
				$is_checked = '<b>'.$sub_row["pilihan_teks"].'</b>';
			}
			else
			{
				$is_checked = $sub_row["pilihan_teks"];
			}

			$output .= '			
            <ol style="margin: 0px;">'.$exam->number_to_str($count).'.&nbsp; '.$is_checked.'</ol>
        
			';
			$count = $count + 1;

			if($sub_row["pilihan_no"] == $row['jawaban_pilihan_user'])
			{
				$jawaban_user = $sub_row['pilihan_teks'];
			}

			if($sub_row['pilihan_no'] == $row['soal_kunci'])
			{
				$kunci_jawaban = $sub_row['pilihan_teks'];
			}
		}
		$output .= '
		</div>
		<p class="card-text text-justify" style="margin: 0px;">Kunci Jawaban: <b>'.$kunci_jawaban.'</b></p>
		<p class="card-text text-justify" style="margin: 0px;">Hasil: '.$hasil_soal.' Nilai: '.$row["nilai"].'</p>
		</div>
		<div style="border-bottom:1px dashed #000000;"></div>
		<br/>
		';
		$no = $no + 1;
	}

	$exam->query = "
	SELECT SUM(nilai) as total_nilai FROM jawaban 
	WHERE jawaban_user_id = '".$_SESSION['user_id']."' 
	AND jawaban_ujian_id = '".$ujian_id."'
	";

	$marks_result = $exam->query_result();

	foreach($marks_result as $row)
	{
		$output .= '
		<div class="card-footer">
			<h3 class="pull-right"><span class="badge badge-success">Jumlah Soal: '.$jumlah_soal.'</span></h3>
			<h3 class="pull-right"><span class="badge badge-success">Benar: '.$row["total_nilai"].'</span></h3>
		</div>
		';
	}
	$output .= '';

	$pdf = new Pdf();

	$pdf->set_paper('A4','portrait');

	$file_name = 'Hasil Quiz.pdf';

	$pdf->loadHtml($output);

	$pdf->render();

	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}

?>