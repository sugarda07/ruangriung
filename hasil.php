<?php

//enroll_exam.php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$ujian_id = $exam->Get_ujian_id($_GET['code']);

$nama_ujian = $exam->Get_nama_ujian($_GET["code"]);

$nama_mapel = $exam->Get_nama_mapel($_GET["code"]);

$tanggal_ujian = $exam->Get_tanggal_ujian($_GET["code"]);

$exam->query = "
SELECT * FROM soal 
INNER JOIN jawaban 
ON jawaban.jawaban_soal_id = soal.soal_id 
WHERE soal.soal_ujian_id = '".$ujian_id."' 
AND jawaban.jawaban_user_id = '".$_SESSION["user_id"]."'
";

$result = $exam->query_result();

?>
<div class="row">
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-8">Hasil Quiz <?php echo $nama_ujian; ?></div>
			<div class="col-md-4" align="right">
				<a href="pdf_exam_result.php?code=<?php echo $_GET["code"]; ?>" class="btn btn-danger btn-sm" target="_blank">Download PDF</a>
			</div>
		</div>
	</div>
	
	<?php
	$total_mark = 0;
	$no = 1;

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

		if($row['nilai'] == '-0')
		{
			$hasil_soal = '<span class="badge badge-danger">Salah</span>';
		}

		echo '
		<div class="card-body">
		<h5 class="card-title text-justify" style="margin-bottom: 3px;">'.$row['soal_teks'].'</h5>
		<div class="row">
		';

		$count = 1;
		foreach($sub_result as $sub_row)
		{	
			$is_checked= '';

			if($exam->Get_jawaban_user($row['soal_id'], $_SESSION['user_id']) == $count)
			{
				$is_checked = '<input type="radio" id="no_'.$count.'" class="custom-control-input" aria-invalid="false" checked>';
			}
			else
			{
				$is_checked = '<input type="radio" id="no_'.$count.'" class="custom-control-input" aria-invalid="false" disabled>';
			}

			echo '
			
                <div class="col-12" style="padding: 7px;">
					<fieldset class="controls">
                        <div class="custom-control custom-radio">
                            '.$is_checked.'
                            <label class="custom-control-label" style="font-family: Poppins; text-align: justify; font-size: 15px;" for="no_'.$count.'">'.$sub_row["pilihan_teks"].'</label>
                        </div>
                    	<div class="help-block"></div>
                    </fieldset>
                </div>
            
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
		</div>
		<p class="card-text text-justify" style="margin-bottom: 0px;">Kunci Jawaban: <b>'.$kunci_jawaban.'</b></p>
		<p class="card-text text-justify" style="margin-bottom: 0px;">Hasil: '.$hasil_soal.' Nilai: '.$row["nilai"].'</p>
		</div>
		<hr style="margin-bottom: 3px; margin-top: 3px;">
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
		$jumlah_soal = $exam->jumlah_soal($ujian_id);

		$jumlah_benar = $row["total_nilai"];

		$jumlah_salah = $jumlah_soal - $jumlah_benar;

		$nilai = $jumlah_benar * 100 / $jumlah_soal;

		echo '
		<div class="card-footer">
			<h5 class="card-text text-justify" style="margin-bottom: 0px;">Benar: '.$jumlah_benar.' - Salah: '.$jumlah_salah.'</h5>
			<h3 class="pull-right"><span class="badge badge-success">Nilai: '.number_format($nilai, 2).'</span></h3>
		</div>
		';
	}

	?>

		
	<br><br>
</div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>
