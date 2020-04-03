<?php

//pdf_exam_result.php

include("koneksi.php");

require_once('../class/pdf.php');

$exam = new Koneksi;

if(isset($_GET["code"]))
{
	$ujian_id = $exam->Get_ujian_id($_GET["code"]);

	$nama_ujian = $exam->Get_nama_ujian($_GET["code"]);

	$nama_mapel = $exam->Get_nama_mapel($_GET["code"]);

	$tanggal_ujian = $exam->Get_tanggal_ujian($_GET["code"]);

	$exam->query = "
	SELECT user.user_id, user.user_foto, user.user_nama_depan, user.user_nama_belakang, user.user_kelas_id, sum(jawaban.nilai) as total_nilai 
	FROM jawaban  
	INNER JOIN user
	ON user.user_id = jawaban.jawaban_user_id 
	WHERE jawaban.jawaban_ujian_id = '$ujian_id' 
	GROUP BY jawaban.jawaban_user_id 
	ORDER BY total_nilai DESC
	";

	$result = $exam->query_result();

	$output = '
	<h4 align="center" style="margin: 0 px;">'.$nama_mapel.'</h4>
	<h2 align="center" style="margin: 3 px;">'.$nama_ujian.'</h2>
	<h6 align="center" style="margin-top: 0 px;">'.date('l, d F Y', strtotime($tanggal_ujian)).'</h6>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr style="background-color: #03a9f3;;">
			<th align="center">Rank</th>
			<th align="center">Foto</th>
			<th align="center">Nama User</th>
			<th align="center">Kelas</th>
			<th align="center">Status</th>
			<th align="center">Hasil</th>
			<th align="center">Nilai</th>
		</tr>
	';	

	$count = 1;

	foreach($result as $row)
	{
		$jumlah_soal = $exam->jumlah_soal($ujian_id);

		$jumlah_benar = $row["total_nilai"];

		$jumlah_salah = $jumlah_soal - $jumlah_benar;

		$nilai = $jumlah_benar * 100 / $jumlah_soal;

		$output .= '
		<tr>
			<td align="center" width="2%">'.$count.'</td>
			<td align="center"><img src="../data/akun/profil/'.$row["user_foto"].'" width="50" /></td>
			<td>'.$row["user_nama_depan"].' '.$row["user_nama_belakang"].'</td>
			<td>'.$exam->Get_nama_kelas($row["user_kelas_id"]).'</td>
			<td align="center">'.$exam->status_ujian_user($ujian_id, $row["user_id"]).'</td>
			<td align="center">B: '.$jumlah_benar.' - S: '.$jumlah_salah.'</td>
			<td align="center">'.number_format($nilai, 2).'</td>
		</tr>
		';

		$count = $count + 1;
	}

	$output .= '</table>';

	$pdf = new Pdf();

	$file_name = 'Exam Result.pdf';

	$pdf->loadHtml($output);

	$pdf->render();

	$pdf->stream($file_name, array("Attachment" => false));

	exit(0);
}

?>