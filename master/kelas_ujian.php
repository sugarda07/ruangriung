<?php

//kelasujian.php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="ujian.php">Ujian List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Kelas Ujian</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Kelas Ujian</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="<?php echo $_GET["code"]; ?>" class="btn btn-info btn-sm add_kelas_ujian">Tambah Kelas Ujian</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="kelas_ujian_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Tingkat</th>
						<th>Kelas</th>
						<th>Jurusan</th>
						<th>Sekolah</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="kelasujianModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="kelasujian_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="kelasujian_modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<select name="kelas_id" id="kelas_id" class="form-control input-lg">
						<option value="">Pilih Kelas</option>
						<?php

						echo $exam->kelasujian_list();

						?>
					</select>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="kelasujian_id" id="kelasujian_id" />
	          		<input type="hidden" name="code" id="hidden_ujian_id" />
	          		<input type="hidden" name="page" value="kelasujian" />
	          		<input type="hidden" name="action" id="hidden_action" value="add_kelasujian" />
	          		<input type="submit" name="kelasujian_button_action" id="kelasujian_button_action" class="btn btn-success btn-sm" value="Add" />
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
      			<button type="button" name="kelasujian_button" id="kelasujian_button" class="btn btn-primary btn-sm">OK</button>
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal" id="statusModal">
  	<div class="modal-dialog">
    	<form method="post" id="status_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="status_modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<select name="kelasujian_status" id="kelasujian_status" class="form-control input-lg">
						<option value="">Pilih Status</option>
						<option value="Menunggu">Menunggu</option>
						<option value="Mulai">Mulai</option>
						<option value="Selesai">Selesai</option>
					</select>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="kelasujian_id" id="kelasujian_id" />
	          		<input type="hidden" name="kelasujian_id" id="hidden_status_kelasujian" />
	          		<input type="hidden" name="page" value="kelasujian" />
	          		<input type="hidden" name="action" id="hidden_action" value="status_kelasujian" />
	          		<input type="submit" name="status_kelasujian_button_action" id="status_kelasujian_button_action" class="btn btn-success btn-sm" value="Add" />
	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>


<script>

$(document).ready(function(){
	
	var code = "<?php echo $_GET["code"]; ?>";

	var dataTable = $('#kelas_ujian_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'ambil_kelas', page:'kelasujian', code:code}
		},
		"columnDefs":[
			{
				"targets" :[5],
				"orderable":false,
			}
		],
	});

	function reset_kelasujian_form()
	{
		$('#kelasujian_modal_title').text('Tambah');
		$('#kelasujian_button_action').val('Add');
		$('#kelasujian_form')[0].reset();
		$('#kelasujian_form').parsley().reset();
	}

	$(document).on('click', '.add_kelas_ujian', function(){
		reset_kelasujian_form();
		$('#kelasujianModal').modal('show');
		$('#message_operation').html('');
		ujian_id = $(this).attr('id');
		$('#hidden_ujian_id').val(ujian_id);
	});

	$('#kelasujian_form').parsley();

	$('#kelasujian_form').on('submit', function(event){
		event.preventDefault();

		$('#kelas_id').attr('required', 'required');

		if($('#kelasujian_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#kelasujian_button_action').attr('disabled', 'disabled');

					$('#kelasujian_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_kelasujian_form();
						dataTable.ajax.reload();
						$('#kelasujianModal').modal('hide');
					}

					$('#kelasujian_button_action').attr('disabled', false);

					$('#kelasujian_button_action').val($('#hidden_action').val());
				}
			});
		}
	});

	$(document).on('click', '.delete_kelasujian', function(){
		kelasujian_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#kelasujian_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{kelasujian_id:kelasujian_id, action:'delete_kelasujian', page:'kelasujian'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});


	$(document).on('click', '.edit_status', function(){
		$('#statusModal').modal('show');
		$('#message_operation').html('');
		kelasujian_status = $(this).attr('id');
		$('#hidden_status_kelasujian').val(kelasujian_status);
	});

	$('#status_form').parsley();

	$('#status_form').on('submit', function(event){
		event.preventDefault();

		$('#kelasujian_status').attr('required', 'required');

		if($('#status_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#status_kelasujian_button_action').attr('disabled', 'disabled');

					$('#status_kelasujian_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						dataTable.ajax.reload();
						$('#statusModal').modal('hide');
					}

					$('#status_kelasujian_button_action').attr('disabled', false);

					$('#status_kelasujian_button_action').val($('#hidden_action').val());
				}
			});
		}
	});



});

</script>

<?php

include('footer.php');

?>