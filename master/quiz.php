<?php

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
			<table id="quiz_data_tabel" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Judul</th>
						<th>Mapel</th>
						<th>Tanggal Quiz</th>
						<th>Waktu</th>
						<th>Bank Soal</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="formquizModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="quiz_form">
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
	                			<input type="text" name="topik_judul" id="topik_judul" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Mata Pelajaran <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	              				<select name="topik_mapel_id" id="topik_mapel_id" class="form-control">
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
              				<label class="col-md-4 text-right">Tanggal Quiz <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="topik_tgl" id="topik_tgl" class="form-control" readonly />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Duration <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="topik_waktu_soal" id="topik_waktu_soal" class="form-control">
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
              				<label class="col-md-4 text-right">Info Quiz <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="topik_info" id="topik_info" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Status Quiz <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="topik_status" id="topik_status" class="form-control">
	                				<option value="">Select</option>
	                				<option value="aktif"> Aktif </option>
	                				<option value="tidak aktif"> Tidak Aktif</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="topik_id" id="topik_id" />

	        		<input type="hidden" name="page" value="quiz" />

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

<script>
$(document).ready(function(){
	
	var dataTable = $('#quiz_data_tabel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'ambil_quiz', page:'quiz'}
		},
		"columnDefs":[
			{
				"targets":[5],
				"orderable":false,
			},
		],
	});

	function reset_form()
	{
		$('#modal_title').text('Tambah Data Quiz');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#quiz_form')[0].reset();
		$('#quiz_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formquizModal').modal('show');
		$('#message_operation').html('');
	});

	var date = new Date();

	date.setDate(date.getDate());

	$('#topik_tgl').datetimepicker({
		startDate :date,
		format: 'yyyy-mm-dd hh:ii',
		autoclose:true
	});

	$('#quiz_form').parsley();

	$('#quiz_form').on('submit', function(event){
		event.preventDefault();

		$('#topik_judul').attr('required', 'required');

		$('#topik_mapel_id').attr('required', 'required');

		$('#topik_tgl').attr('required', 'required');

		$('#topik_waktu_soal').attr('required', 'required');

		if($('#quiz_form').parsley().validate())
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

						$('#formquizModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);

					$('#button_action').val($('#action').val());
				}
			});
		}
	});

	var topik_id = '';

	$(document).on('click', '.edit', function(){
		topik_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambil', topik_id:topik_id, page:'quiz'},
			dataType:"json",
			success:function(data)
			{
				$('#topik_judul').val(data.topik_judul);

				$('#topik_mapel_id').val(data.topik_mapel_id);

				$('#topik_tgl').val(data.topik_tgl);

				$('#topik_waktu_soal').val(data.topik_waktu_soal);

				$('#topik_info').val(data.topik_info);

				$('#topik_status').val(data.topik_status);

				$('#topik_id').val(topik_id);

				$('#modal_title').text('Edit Data Quiz');

				$('#button_action').val('Edit');

				$('#action').val('Edit_quiz');

				$('#formquizModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		topik_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{topik_id:topik_id, action:'delete', page:'quiz'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});


});
</script>