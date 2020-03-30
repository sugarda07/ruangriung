<?php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="quiz.php">Quiz List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Daftar Soal</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Daftar Soal</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_soal" class="btn btn-info btn-sm">Tambah Soal</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="daftar_soal_data_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Soal</th>
						<th>Pilihan</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="soalModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="soal_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="soal_modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<div class="form-group">
          				<label>Soal <span class="text-danger">*</span></label>
                		<textarea  type="text" name="pilgan_pertanyaan" id="pilgan_pertanyaan" rows="2" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>A <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilgan_a" id="pilgan_a" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>B <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilgan_b" id="pilgan_b" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>C <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilgan_c" id="pilgan_c" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>D <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilgan_d" id="pilgan_d" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
              			<label>E <span class="text-danger">*</span></label>
	                	<textarea  type="text" name="pilgan_e" id="pilgan_e" class="form-control"></textarea>
          			</div>
          			<div class="form-group">
          				<label>Kunci <span class="text-danger">*</span></label>
            			<select name="pilgan_kunci" id="pilgan_kunci" class="form-control">
            				<option value="">Select</option>
            				<option value="A">Pilihan A</option>
            				<option value="B">Pilihan B</option>
            				<option value="C">Pilihan C</option>
            				<option value="D">Pilihan D</option>
            				<option value="E">Pilihan E</option>
            			</select>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="soal_id" id="soal_id" />
	          		<input type="hidden" name="topik_id" id="topik_id" value="<?php echo $_GET["code"]; ?>" />
	          		<input type="hidden" name="page" value="daftar_soal" />
	          		<input type="hidden" name="action" id="hidden_action" value="tambah" />
	          		<input type="submit" name="soal_button_action" id="soal_button_action" class="btn btn-success btn-sm" value="Add" />
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
	
	var code = "<?php echo $_GET["code"]; ?>";

	var dataTable = $('#daftar_soal_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'daftar_soal', code:code}
		},
		"columnDefs":[
			{
				"targets" :[2],
				"orderable":false,
			}
		],
	});

	$('#soal_form').parsley();

	$('#soal_form').on('submit', function(event){
		event.preventDefault();

		$('#pilgan_pertanyaan').attr('required', 'required');

		$('#pilgan_a').attr('required', 'required');

		$('#pilgan_b').attr('required', 'required');

		$('#pilgan_c').attr('required', 'required');

		$('#pilgan_d').attr('required', 'required');

		$('#pilgan_e').attr('required', 'required');

		$('#pilgan_kunci').attr('required', 'required');

		if($('#soal_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_proses.php",
				method:"POST",
				data:new FormData(this),
		        dataType:"json",
		        contentType:false,
		        cache:false,
		        processData:false,
		        beforeSend:function(){
					$('#soal_button_action').attr('disabled', 'disabled');

					$('#soal_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						reset_form();
						dataTable.ajax.reload();
						$('#soalModal').modal('hide');
					}

					$('#soal_button_action').attr('disabled', false);

					$('#soal_button_action').val($('#hidden_action').val());
				}
			});
		}
	});

	function reset_form()
	{
		$('#modal_title').text('Tambah Data Soal');
		$('#soal_button_action').val('Add');
		$('#action').val('tambah');
		$('#soal_form')[0].reset();
		$('#soal_form').parsley().reset();
	}

	$('#add_soal').click(function(){
		reset_form();
		$('#soalModal').modal('show');
		$('#message_operation').html('');
	});

	var pilgan_id = '';

	$(document).on('click', '.edit', function(){
		pilgan_id = $(this).attr('id');
		reset_form();
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambil', pilgan_id:pilgan_id, page:'daftar_soal'},
			dataType:"json",
			success:function(data)
			{
				$('#pilgan_pertanyaan').val(data.pilgan_pertanyaan);
				$('#pilgan_a').val(data.pilgan_a);
				$('#pilgan_b').val(data.pilgan_b);
				$('#pilgan_c').val(data.pilgan_c);
				$('#pilgan_d').val(data.pilgan_d);
				$('#pilgan_e').val(data.pilgan_e);
				$('#pilgan_kunci').val(data.pilgan_kunci);
				$('#pilgan_id').val(pilgan_id);
				$('#soal_button_action').val('Edit');
				$('#action').val('Edit');
				$('#modal_title').text('Edit Detail Soal');
				$('#soalModal').modal('show');
			}
		})
	});


	$(document).on('click', '.delete', function(){
		pilgan_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{pilgan_id:pilgan_id, action:'delete', page:'daftar_soal'},
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