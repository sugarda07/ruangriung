<?php

//enroll_exam.php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

?>

<br />
<div class="card">
	<div class="card-header">Online Exam</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="ujian_data_table">
				<thead>
					<tr>
						<th>Judul</th>
						<th>Nama Mapel</th>
						<th>Tanggal</th>
						<th>Durasi</th>
						<th>Jumlah Soal</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>

<script>

$(document).ready(function(){

	var dataTable = $('#ujian_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"user_ajax_proses.php",
			type:"POST",
			data:{action:'ambil', page:'ujian'}
		},
		"columnDefs":[
			{
				"targets":[5, 6],
				"orderable":false,
			},
		],
	});

	$(document).on('click', '#konfirmasi', function(){
		ujian_id = $('#konfirmasi').data('ujian_id');
		$.ajax({
			url:"user_ajax_proses.php",
			method:"POST",
			data:{action:'konfirmasi', page:'ujian', ujian_id:ujian_id},
			beforeSend:function()
			{
				$('#konfirmasi').attr('disabled', 'disabled');
				$('#konfirmasi').text('please wait');
			},
			success:function()
			{
				dataTable.ajax.reload();
			}
		});
	});

});

</script>