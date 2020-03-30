<?php

//enroll_exam.php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$ujian_id = $exam->Get_ujian_id($_GET['code']);

$exam->query = "
SELECT * FROM soal 
INNER JOIN jawaban 
ON jawaban.jawaban_soal_id = soal.soal_id 
WHERE soal.soal_ujian_id = '".$ujian_id."' 
AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."'
";

$result = $exam->query_result();

?>

<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-8">Hasil Ujian</div>
			<div class="col-md-4" align="right">
				<a href="pdf_exam_result.php?code=<?php echo $_GET["code"]; ?>" class="btn btn-danger btn-sm" target="_blank">PDF</a>
			</div>
		</div>
	</div>
	
	<?php
	$total_mark = 0;

	foreach($result as $row)
	{
		$exam->query = "
		SELECT * 
		FROM pilihan_soal 
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

		

		echo '
		<div class="card-body">
		<h4 class="card-title" style="margin-bottom: 3px;"> '.$row['soal_teks'].'</h4>
		';

		$count = 1;
		foreach($sub_result as $sub_row)
		{	

			echo '<p class="card-text" style="margin-bottom: 0px;">'.$count.' '.$sub_row['pilihan_teks'].'</p>';

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
		echo '
		<p class="card-text" style="margin-bottom: 0px;">Jawaban Anda: '.$jawaban_user.'</p>
		<p class="card-text" style="margin-bottom: 0px;">Kunci Jawaban: '.$kunci_jawaban.'</p>
		<p class="card-text" style="margin-bottom: 0px;">Hasil: '.$hasil_soal.'</p>
		<p class="card-text" style="margin-bottom: 0px;">Nilai: '.$row["nilai"].'</p>
		</div>
		';
	}

	?>
	
</div>
<?php include('footer.php');?>
</div>
</body>
</html>
