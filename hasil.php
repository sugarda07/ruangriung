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
			<div class="col-md-8">Hasil Quiz</div>
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
		<h6 class="card-title text-justify" style="margin-bottom: 3px;"> '.$row['soal_teks'].'</h6>
		<ul class="list-icons">
		';

		$count = 1;
		foreach($sub_result as $sub_row)
		{	
			$is_checked= '';

			if($exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']) == $count)
			{
				$is_checked = '<i class="fa fa-check-square-o text-success"></i>';
			}
			else
			{
				$is_checked = '<i class="fa fa-times text-danger"></i>';
			}

			echo '
			
                <li style="margin: 0px;"><a href="javascript:void(0)" class="text-justify">'.$is_checked.' '.$sub_row["pilihan_teks"].'</a></li>
            
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
		echo '
		</ul>
		<p class="card-text" style="margin-bottom: 0px;">Kunci Jawaban: <b>'.$kunci_jawaban.'</b></p>
		<p class="card-text" style="margin-bottom: 0px;">Hasil: '.$hasil_soal.' Nilai: '.$row["nilai"].'</p>
		</div>
		<hr style="margin-bottom: 3px; margin-top: 3px;">
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
		echo '
		<div class="card-footer">
			<h3 class="pull-right"><span class="badge badge-success">Total Nilai: '.$row["total_nilai"].'</span></h3>
		</div>
		';
	}

	?>

		
	<br><br>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>
