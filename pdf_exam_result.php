<?php

//pdf_exam_result.php

include('master/koneksi.php');

require_once('class/pdf.php');

$exam = new Koneksi;

if(isset($_GET["code"]))
{
	$ujian_id = $exam->Get_ujian_id($_GET['code']);

	$exam->query = "
	SELECT * FROM soal
	INNER JOIN jawaban 
	ON jawaban.jawaban_soal_id = soal.soal_id 
	WHERE soal.soal_ujian_id = '$ujian_id' 
	AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."'
	";

	$result = $exam->query_result();

	$output = '
	<h3 align="center">Hasil Quiz</h3>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<th>Pertanyaan</th>
			<th>Jawaban Anda</th>
			<th>Kunci Jawaban</th>
			<th>Hasil</th>
			<th>Nilai</th>
		</tr>
	';

	$total_mark = 0;

	foreach($result as $row)
	{
		$exam->query = "
		SELECT * FROM pilihan_soal
		WHERE pilihan_soal_id = '".$row["soal_id"]."'
		";

		$sub_result = $exam->query_result();

		$user_answer = '';
		$orignal_answer = '';
		$question_result = '';

		if($row["nilai"] == '0')
		{
			$question_result = 'Belum di Isi';
		}

		if($row["nilai"] > '0')
		{
			$question_result = 'Benar';
		}

		if($row['nilai'] < '0')
		{
			$question_result = 'Salah';
		}

		if($row['nilai'] == '-0')
		{
			$question_result = 'Salah';
		}

		$output .= '
		<tr>
			<td>'.$row["soal_teks"].'</td>
		';

		foreach($sub_result as $sub_row)
		{
			if($sub_row["pilihan_no"] == $row["jawaban_pilihan_user"])
			{
				$user_answer = $sub_row["pilihan_teks"];
			}

			if($sub_row["pilihan_no"] == $row["soal_kunci"])
			{
				$orignal_answer = $sub_row["pilihan_teks"];
			}
		}
		$output .= '
			<td>'.$user_answer.'</td>
			<td>'.$orignal_answer.'</td>
			<td>'.$question_result.'</td>
			<td>'.$row["nilai"].'</td>
		</tr>
		';
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
		<tr>
			<td colspan="4" align="right">Total Nilai</td>
			<td align="right">'.$row["total_nilai"].'</td>
		</tr>
		';
	}
	$output .= '</table>';

	$pdf = new Pdf();

	$pdf->set_paper('letter','landscape');

	$file_name = 'Hasil Quiz.pdf';

	$pdf->loadHtml($output);

	$pdf->render();

	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}

?>