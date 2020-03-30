<?php

//kelasquiz.php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="quiz.php">Quiz List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Kelas Quiz</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Kelas Quiz</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="<?php echo $_GET["code"]; ?>" class="btn btn-info btn-sm add_kelas_quiz">Tambah Kelas</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="kelas_quiz_data_table" class="table table-bordered table-striped table-hover">
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

<div class="modal" id="kelasquizModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="kelasquiz_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="kelasquiz_modal_title"></h4>
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
	        		<input type="hidden" name="kelasquiz_id" id="kelasquiz_id" />
	          		<input type="hidden" name="code" id="hidden_quiz_id" />
	          		<input type="hidden" name="page" value="kelasquiz" />
	          		<input type="hidden" name="action" id="hidden_action" value="add_kelasquiz" />
	          		<input type="submit" name="kelasquiz_button_action" id="kelasquiz_button_action" class="btn btn-success btn-sm" value="Add" />
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
      			<button type="button" name="kelasquiz_button" id="kelasquiz_button" class="btn btn-primary btn-sm">OK</button>
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
          			<select name="kelasquiz_status" id="kelasquiz_status" class="form-control input-lg">
						<option value="">Pilih Status</option>
						<option value="Menunggu">Menunggu</option>
						<option value="Mulai">Mulai</option>
						<option value="Selesai">Selesai</option>
					</select>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="kelasquiz_id" id="kelasquiz_id" />
	          		<input type="hidden" name="kelasquiz_id" id="hidden_status_kelasquiz" />
	          		<input type="hidden" name="page" value="kelasquiz" />
	          		<input type="hidden" name="action" id="hidden_action" value="status_kelasquiz" />
	          		<input type="submit" name="status_kelasquiz_button_action" id="status_kelasquiz_button_action" class="btn btn-success btn-sm" value="Add" />
	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>


<script>

$(document).ready(function(){
	
	var code = "<?php echo $_GET["code"]; ?>";

	var dataTable = $('#kelas_quiz_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'ambil_kelas', page:'kelasquiz', code:code}
		},
		"columnDefs":[
			{
				"targets" :[5],
				"orderable":false,
			}
		],
	});

	function reset_kelasquiz_form()
	{
		$('#kelasquiz_modal_title').text('Tambah');
		$('#kelasquiz_button_action').val('Add');
		$('#kelasquiz_form')[0].reset();
		$('#kelasquiz_form').parsley().reset();
	}

	$(document).on('click', '.add_kelas_quiz', function(){
		reset_kelasquiz_form();
		$('#kelasquizModal').modal('show');
		$('#message_operation').html('');
		quiz_id = $(this).attr('id');
		$('#hidden_quiz_id').val(quiz_id);
	});

	$('#kelasquiz_form').parsley();

	$('#kelasquiz_form').on('submit', function(event){
		event.preventDefault();

		$('#kelas_id').attr('required', 'required');

		if($('#kelasquiz_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#kelasquiz_button_action').attr('disabled', 'disabled');

					$('#kelasquiz_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_kelasquiz_form();
						dataTable.ajax.reload();
						$('#kelasquizModal').modal('hide');
					}

					$('#kelasquiz_button_action').attr('disabled', false);

					$('#kelasquiz_button_action').val($('#hidden_action').val());
				}
			});
		}
	});

	$(document).on('click', '.delete_kelasquiz', function(){
		kelasquiz_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#kelasquiz_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{kelasquiz_id:kelasquiz_id, action:'delete_kelasquiz', page:'kelasquiz'},
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
		kelasquiz_status = $(this).attr('id');
		$('#hidden_status_kelasquiz').val(kelasquiz_status);
	});

	$('#status_form').parsley();

	$('#status_form').on('submit', function(event){
		event.preventDefault();

		$('#kelasquiz_status').attr('required', 'required');

		if($('#status_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#status_kelasquiz_button_action').attr('disabled', 'disabled');

					$('#status_kelasquiz_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						dataTable.ajax.reload();
						$('#statusModal').modal('hide');
					}

					$('#status_kelasquiz_button_action').attr('disabled', false);

					$('#status_kelasquiz_button_action').val($('#hidden_action').val());
				}
			});
		}
	});



});

</script>

<?php

include('footer.php');

?>