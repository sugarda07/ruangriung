<?php

//pdf_exam_result.php

include("koneksi.php");

require_once('../class/pdf.php');

$exam = new Koneksi;

if(isset($_GET["code"]))
{
	$ujian_id = $exam->Get_ujian_id($_GET["code"]);

	$exam->query = "
	SELECT user.user_id, user.user_foto, user.user_nama_depan, sum(jawaban.nilai) as total_nilai 
	FROM jawaban  
	INNER JOIN user
	ON user.user_id = jawaban.jawaban_user_id 
	WHERE jawaban.jawaban_ujian_id = '$ujian_id' 
	GROUP BY jawaban.jawaban_user_id 
	ORDER BY total_nilai DESC
	";

	$result = $exam->query_result();

	$output = '
	<h2 align="center">Hasil Ujian</h2><br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<th>Peringkat</th>
			<th>Image</th>
			<th>Nama User</th>
			<th>Status</th>
			<th>Nilai</th>
		</tr>
	';

	$count = 1;

	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$count.'</td>
			<td><img src="../data/akun/profil/'.$row["user_foto"].'" width="75" /></td>
			<td>'.$row["user_nama_depan"].'</td>
			<td>'.$exam->status_ujian_user($ujian_id, $row["user_id"]).'</td>
			<td>'.$row["total_nilai"].'</td>
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