<?php

//ujian.php

include('header.php');



?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Data Quiz Online</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_button" class="btn btn-info btn-sm">Tambah</button>
			</div>
		</div>
	</div>
	<div class="card-body">
	<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="ujian_data_tabel" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Judul</th>
						<th>Durasi</th>
						<th>Tanggal Quiz</th>
						<th>Bank Soal</th>
						<th>Hasil</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="formModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="ujian_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Judul Quiz <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="ujian_judul" id="ujian_judul" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Mata Pelajaran <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="ujian_mapel" id="ujian_mapel" class="form-control">
		            				<option value="">Pilih Mapel</option>
		            				<?php
									echo $exam->mapel_list();
									?>
		            			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Info <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="ujian_info" id="ujian_info" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Tanggal Quiz <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="ujian_tanggal" id="ujian_tanggal" class="form-control" readonly />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Duration <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="ujian_durasi" id="ujian_durasi" class="form-control">
	                				<option value="">Select</option>
	                				<option value="5">5 Menit</option>
	                				<option value="30">30 Menit</option>
	                				<option value="60">1 Jam</option>
	                				<option value="120">2 Jam</option>
	                				<option value="180">3 Jam</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Nilai Benar <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="nilai_benar" id="nilai_benar" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Nilai Salah <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="nilai_salah" id="nilai_salah" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Status Soal <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="ujian_status" id="ujian_status" class="form-control">
	                				<option value="">Select</option>
	                				<option value="Menunggu"> Menunggu </option>
	                				<option value="Mulai"> Mulai</option>
	                				<option value="Selesai"> Selesai</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="ujian_id" id="ujian_id" />

	        		<input type="hidden" name="page" value="ujian" />

	        		<input type="hidden" name="action" id="action" value="Add" />

	        		<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />

	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>

<div class="modal" id="deleteModal">
  	<div class="modal-dialog">
    	<div class="modal-content">

      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">Delete Confirmation</h4>
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>

      		<!-- Modal body -->
      		<div class="modal-body">
        		<h3 align="center">Are you sure you want to remove this?</h3>
      		</div>

      		<!-- Modal footer -->
      		<div class="modal-footer">
      			<button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal" id="soalModal">
  	<div class="modal-dialog modal-lg">
    	<form class="form-horizontal m-t-40" method="post" id="soal_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="soal_modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<div class="form-group">
          				<label>Pertanyaan <span class="text-danger">*</span></label>
                		<textarea name="soal_teks" id="soal_teks" rows="2" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>A <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilihan_teks_1" id="pilihan_teks_1" rows="1" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>B <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilihan_teks_2" id="pilihan_teks_2" rows="1" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>C <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilihan_teks_3" id="pilihan_teks_3" rows="1" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>D <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilihan_teks_4" id="pilihan_teks_4" rows="1" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>E <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilihan_teks_5" id="pilihan_teks_5" rows="1" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
          				<label>Kunci <span class="text-danger">*</span></label>
            			<select name="soal_kunci" id="soal_kunci" class="form-control">
            				<option value="">Select</option>
            				<option value="1">Pilihan A</option>
            				<option value="2">Pilihan B</option>
            				<option value="3">Pilihan C</option>
            				<option value="4">Pilihan D</option>
            				<option value="5">Pilihan E</option>
            			</select>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="soal_id" id="soal_id" />

	        		<input type="hidden" name="ujian_id" id="hidden_ujian_id" />

	        		<input type="hidden" name="page" value="soal" />

	        		<input type="hidden" name="action" id="hidden_action" value="Add" />

	        		<input type="submit" name="soal_button_action" id="soal_button_action" class="btn btn-success btn-sm" value="Add" />

	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>

<script>

$(document).ready(function(){
	
	var dataTable = $('#ujian_data_tabel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'ujian'}
		},
		"columnDefs":[
			{
				"targets":[3, 4, 5],
				"orderable":false,
			},
		],
	});

	function reset_form()
	{
		$('#modal_title').text('Tambah Data Ujian');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#ujian_form')[0].reset();
		$('#ujian_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});

	var date = new Date();

	date.setDate(date.getDate());

	$('#ujian_tanggal').datetimepicker({
		startDate :date,
		format: 'yyyy-mm-dd hh:ii',
		autoclose:true
	});

	$('#ujian_form').parsley();

	$('#ujian_form').on('submit', function(event){
		event.preventDefault();

		$('#ujian_judul').attr('required', 'required');

		$('#ujian_mapel').attr('required', 'required');

		$('#ujian_tanggal').attr('required', 'required');

		$('#ujian_durasi').attr('required', 'required');

		$('#nilai_benar').attr('required', 'required');

		$('#nilai_salah').attr('required', 'required');

		$('#ujian_status').attr('required', 'required');

		$('#ujian_info').attr('required', 'required');

		if($('#ujian_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#button_action').attr('disabled', 'disabled');
					$('#button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();

						dataTable.ajax.reload();

						$('#formModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);

					$('#button_action').val($('#action').val());
				}
			});
		}
	});

	var ujian_id = '';

	$(document).on('click', '.edit', function(){
		ujian_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambil', ujian_id:ujian_id, page:'ujian'},
			dataType:"json",
			success:function(data)
			{
				$('#ujian_judul').val(data.ujian_judul);

				$('#ujian_mapel').val(data.ujian_mapel);

				$('#ujian_tanggal').val(data.ujian_tanggal);

				$('#ujian_durasi').val(data.ujian_durasi);

				$('#nilai_benar').val(data.nilai_benar);

				$('#nilai_salah').val(data.nilai_salah);

				$('#ujian_info').val(data.ujian_info);

				$('#ujian_status').val(data.ujian_status);

				$('#ujian_id').val(ujian_id);

				$('#modal_title').text('Edit Data Ujian');

				$('#button_action').val('Edit');

				$('#action').val('Edit');

				$('#formModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		ujian_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{ujian_id:ujian_id, action:'delete', page:'ujian'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});

	function reset_soal_form()
	{
		$('#soal_modal_title').text('Tambah');
		$('#soal_button_action').val('Add');
		$('#hidden_action').val('Add');
		$('#soal_form')[0].reset();
		$('#soal_form').parsley().reset();
	}

	$(document).on('click', '.add_soal', function(){
		reset_soal_form();
		$('#soalModal').modal('show');
		$('#message_operation').html('');
		ujian_id = $(this).attr('id');
		$('#hidden_ujian_id').val(ujian_id);
	});

	$('#soal_form').parsley();

	$('#soal_form').on('submit', function(event){
		event.preventDefault();

		$('#soal_teks').attr('required', 'required');

		$('#soal_pilihan_1').attr('required', 'required');

		$('#soal_pilihan_2').attr('required', 'required');

		$('#soal_pilihan_3').attr('required', 'required');

		$('#soal_pilihan_4').attr('required', 'required');

		$('#soal_pilihan_5').attr('required', 'required');

		$('#soal_kunci').attr('required', 'required');

		if($('#soal_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#soal_button_action').attr('disabled', 'disabled');

					$('#soal_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_soal_form();
						dataTable.ajax.reload();
						$('#soalModal').modal('hide');
					}

					$('#soal_button_action').attr('disabled', false);

					$('#soal_button_action').val($('#hidden_action').val());
				}
			});
		}
	});




});

</script>

<?php

include('footer.php');

?>