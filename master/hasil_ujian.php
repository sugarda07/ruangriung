<?php

include('header.php');

$nama_ujian = $exam->Get_nama_ujian($_GET["code"]);

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="ujian.php">Ujian List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Hasil Quiz</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title"><?php echo $nama_ujian; ?></h3>
			</div>
			<div class="col-md-3" align="right">
				<a href="pdf_exam_result.php?code=<?php echo $_GET['code']; ?>" class="btn btn-danger btn-sm" target="_blank">PDF</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="hasil_table">
				<thead>
					<tr>
						<th>Foto</th>
						<th>Nama User</th>
						<th>Kelas</th>
						<th>Status</th>
						<th>Hasil</th>
						<th>Nilai</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){

	var code = "<?php echo $_GET["code"];?>";

	var dataTable = $('#hasil_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_proses.php",
			type:"POST",
			data:{action:'ambil', page:'hasil_ujian', code:code}
		}
	});

});

</script>