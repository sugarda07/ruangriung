<?php

//index.php

include('header.php');

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Beranda</h4>
                <h6 class="card-subtitle">List of ticket opend by customers</h6>
                <div class="row m-t-40">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><?php echo $exam->total_pengguna(); ?></h1>
                                <h6 class="text-white">Pengguna</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card">
                            <div class="box bg-primary text-center">
                                <h1 class="font-light text-white"><?php echo $exam->total_postingan(); ?></h1>
                                <h6 class="text-white">Postingan</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><?php echo $exam->total_materi(); ?></h1>
                                <h6 class="text-white">Materi</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card">
                            <div class="box bg-dark text-center">
                                <h1 class="font-light text-white"><?php echo $exam->total_quiz(); ?></h1>
                                <h6 class="text-white">Quiz</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
						<table id="tabel_pengguna_baru" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>ID #</th>
									<th></th>
									<th>Nama Pengguna</th>
									<th>Email</th>
									<th>Tanggal</th>
								</tr>
							</thead>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
	
	var dataTable = $('#tabel_pengguna_baru').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'pengguna_baru', page:'index'}
		},
		"columnDefs":[
			{
				"targets":[1],
				"orderable":false,
			},
		],
	});

});

</script>

<?php

include('footer.php');

?>