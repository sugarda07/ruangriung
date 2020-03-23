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
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="hasil_data_table">
					<tr>
						<th>Pertanyaan</th>
						<th>pilihan1</th>
						<th>pilihan2</th>
						<th>pilihan3</th>
						<th>pilihan4</th>
						<th>pilihan5</th>
						<th>Jawaban</th>
						<th>Kunci</th>
						<th>Hasil</th>
						<th>Nilai</th>
					</tr>
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
							$hasil_soal = '<h4 class="badge badge-dark">Belum di Isi</h4>';
						}

						if($row['nilai'] > '0')
						{
							$hasil_soal = '<h4 class="badge badge-success">Benar</h4>';
						}

						if($row['nilai'] < '0')
						{
							$hasil_soal = '<h4 class="badge badge-danger">Salah</h4>';
						}

						echo '
						<tr>
							<td>'.$row['soal_teks'].'</td>
						';

						foreach($sub_result as $sub_row)
						{
							echo '<td>'.$sub_row['pilihan_teks'].'</td>';

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
						<td>'.$jawaban_user.'</td>
						<td>'.$kunci_jawaban.'</td>
						<td>'.$hasil_soal.'</td>
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
					?>
					<tr>
						<td colspan="9" align="right">Total Nilai</td>
						<td align="center"><?php echo $row["total_nilai"]; ?></td>
					</tr>
					<?php	
					}

					?>
			</table>
		</div>
	</div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>
