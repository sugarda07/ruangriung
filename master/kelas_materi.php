<?php

//kelasmateri.php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="materi.php">Materi</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Kelas Materi</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Kelas Materi</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="<?php echo $_GET["code"]; ?>" class="btn btn-info btn-sm add_kelas_materi">Tambah Kelas</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="kelas_materi_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Tingkat</th>
						<th>Kelas</th>
						<th>Jurusan</th>
						<th>Sekolah</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="kelasmateriModal">
  	<div class="modal-dialog">
    	<form method="post" id="kelasmateri_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="kelasmateri_modal_title"></h4>
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
	        		<input type="hidden" name="kelasmateri_id" id="kelasmateri_id" />
	          		<input type="hidden" name="code" id="hidden_materi_id" />
	          		<input type="hidden" name="page" value="kelasmateri" />
	          		<input type="hidden" name="action" id="hidden_action" value="add_kelasmateri" />
	          		<input type="submit" name="kelasmateri_button_action" id="kelasmateri_button_action" class="btn btn-success btn-sm" value="Add" />
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
      			<button type="button" name="kelasmateri_button" id="kelasmateri_button" class="btn btn-primary btn-sm">OK</button>
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<script>

$(document).ready(function(){
	
	var code = "<?php echo $_GET["code"]; ?>";

	var dataTable = $('#kelas_materi_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'ambil_kelas_materi', page:'kelasmateri', code:code}
		},
		"columnDefs":[
			{
				"targets" :[4],
				"orderable":false,
			}
		],
	});

	function reset_kelasmateri_form()
	{
		$('#kelasmateri_modal_title').text('Tambah Materi');
		$('#kelasmateri_button_action').val('Add');
		$('#kelasmateri_form')[0].reset();
		$('#kelasmateri_form').parsley().reset();
	}

	$(document).on('click', '.add_kelas_materi', function(){
		reset_kelasmateri_form();
		$('#kelasmateriModal').modal('show');
		$('#message_operation').html('');
		materi_id = $(this).attr('id');
		$('#hidden_materi_id').val(materi_id);
	});

	$('#kelasmateri_form').parsley();

	$('#kelasmateri_form').on('submit', function(event){
		event.preventDefault();

		$('#kelas_id').attr('required', 'required');

		if($('#kelasmateri_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#kelasmateri_button_action').attr('disabled', 'disabled');

					$('#kelasmateri_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_kelasmateri_form();
						dataTable.ajax.reload();
						$('#kelasmateriModal').modal('hide');
					}

					$('#kelasmateri_button_action').attr('disabled', false);

					$('#kelasmateri_button_action').val($('#hidden_action').val());
				}
			});
		}
	});

	$(document).on('click', '.delete_kelasmateri', function(){
		kelasmateri_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#kelasmateri_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{kelasmateri_id:kelasmateri_id, action:'delete_kelasmateri', page:'kelasmateri'},
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

<?php

include('footer.php');

?>