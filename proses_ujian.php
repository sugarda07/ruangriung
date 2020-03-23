<?php

//change_password.php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$ujian_id = '';
$ujian_status = '';
$durasi_akhir = '';

if(isset($_GET['code']))
{
	$ujian_id = $exam->Get_ujian_id($_GET["code"]);
	$exam->query = "
	SELECT ujian_status, ujian_tanggal, ujian_durasi FROM ujian 
	WHERE ujian_id = '$ujian_id'
	";

	$result = $exam->query_result();

	foreach($result as $row)
	{
		$ujian_status = $row['ujian_status'];
		$ujian_mulai = $row['ujian_tanggal'];
		$durasi = $row['ujian_durasi'] . ' minute';
		$ujian_akhir = strtotime($ujian_mulai . '+' . $durasi);

		$ujian_akhir = date('Y-m-d H:i:s', $ujian_akhir);
		$durasi_akhir = strtotime($ujian_akhir) - time();
	}
}
else
{
	header('location:enroll_exam.php');
}

?>
<br/>

			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">e_learning</div>
						<div class="card-body">
							<div id="single_question_area"></div>
						</div>
					</div>
					<br />
					<div id="question_navigation_area"></div>
				</div>
				<div class="col-md-4">
					<br />
					<div align="center">
						<div id="ujian_timer" data-timer="<?php echo $durasi_akhir; ?>" style="max-width:200px; width: 100%; height: 200px;"></div>
					</div>
					<br />
					<div id="user_details_area"></div>		
				</div>
			</div>

</body>

</html>
<script>

$(document).ready(function(){
	var code = "<?php echo $_GET["code"]; ?>";

	load_soal();
	soal_navigation();

	function load_soal(soal_id = '')
	{
		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{code:code, soal_id:soal_id, page:'proses_ujian', action:'load_soal'},
			success:function(data)
			{
				$('#single_question_area').html(data);
			}
		})
	}

	$(document).on('click', '.next', function(){
		var soal_id = $(this).attr('id');
		load_soal(soal_id);
	});

	$(document).on('click', '.previous', function(){
		var soal_id = $(this).attr('id');
		load_soal(soal_id);
	});

	function soal_navigation()
	{
		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{code:code, page:'proses_ujian', action:'soal_navigation'},
			success:function(data)
			{
				$('#question_navigation_area').html(data);
			}
		})
	}

	$(document).on('click', '.navigasi_soal', function(){
		var soal_id = $(this).data('soal_id');
		load_soal(soal_id);
	});

	load_user_details();

	function load_user_details()
	{
		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{page:'proses_ujian', action:'user_detail'},
			success:function(data)
			{
				$('#user_details_area').html(data);
			}
		})
	}

	$("#ujian_timer").TimeCircles({ 
		time:{
			Days:{
				show: false
			},
			Hours:{
				show: false
			}
		}
	});

	setInterval(function(){
		var remaining_second = $("#ujian_timer").TimeCircles().getTime();
		if(remaining_second < 1)
		{
			konfirmasi_selesai();
			window.location='ujian_user.php';
		}
	}, 1000);

	$(document).on('click', '.pilihan_jawaban', function(){
		var soal_id = $(this).data('soal_id');

		var pilihan_jawaban = $(this).data('id');

		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{soal_id:soal_id, pilihan_jawaban:pilihan_jawaban, code:code, page:'proses_ujian', action:'jawaban'},
			success:function(data)
			{

			}
		})
	});

	function konfirmasi_selesai()
	{
		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{page:'proses_ujian', code:code, action:'konfirmasi_selesai'},
			success:function(data)
			{
				
			}
		})
	}



});
</script>