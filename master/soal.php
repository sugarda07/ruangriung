<?php

//soal.php

include('header.php');

?>
<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="ujian.php">Ujian List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Soal List</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Soal List</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_soal" class="btn btn-info btn-sm">Tambah Soal</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="soal_data_table" class="table table-bordered table-striped table-hover">
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
            			<div class="row">
              				<label class="col-md-4 text-right">Soal <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="soal_teks" id="soal_teks" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Pilihan 1 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="pilihan_teks_1" id="pilihan_teks_1" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Pilihan 2 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="pilihan_teks_2" id="pilihan_teks_2" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Pilihan 3 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="pilihan_teks_3" id="pilihan_teks_3" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Pilihan 4 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="pilihan_teks_4" id="pilihan_teks_4" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Pilihan 5 <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="pilihan_teks_5" id="pilihan_teks_5" autocomplete="off" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Kunci <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="soal_kunci" id="soal_kunci" class="form-control">
	                				<option value="">Select</option>
	                				<option value="1">Pilihan 1</option>
	                				<option value="2">Pilihan 2</option>
	                				<option value="3">Pilihan 3</option>
	                				<option value="4">Pilihan 4</option>
	                				<option value="5">Pilihan 5</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="soal_id" id="soal_id" />
	          		<input type="hidden" name="ujian_id" id="ujian_id" />
	          		<input type="hidden" name="page" value="soal" />
	          		<input type="hidden" name="action" id="hidden_action" value="Edit" />
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

	var dataTable = $('#soal_data_table').DataTable({
		"processing" :true,
		"serverSide" :true,
		"order" :[],
		"ajax" :{
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'soal', code:code}
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

	function reset_soal_form()
	{
		$('#soal_button_action').val('Edit');
		$('#soal_form')[0].reset();
		$('#soal_form').parsley().reset();
	}

	var soal_id = '';

	$(document).on('click', '.edit', function(){
		soal_id = $(this).attr('id');
		reset_soal_form();
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambil', soal_id:soal_id, page:'soal'},
			dataType:"json",
			success:function(data)
			{
				$('#soal_teks').val(data.soal_teks);
				$('#pilihan_teks_1').val(data.pilihan_teks_1);
				$('#pilihan_teks_2').val(data.pilihan_teks_2);
				$('#pilihan_teks_3').val(data.pilihan_teks_3);
				$('#pilihan_teks_4').val(data.pilihan_teks_4);
				$('#pilihan_teks_5').val(data.pilihan_teks_5);
				$('#soal_kunci').val(data.soal_kunci);
				$('#soal_id').val(soal_id);
				$('#soal_modal_title').text('Edit Detail Soal');
				$('#soalModal').modal('show');
			}
		})
	});


	$(document).on('click', '.delete', function(){
		soal_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{soal_id:soal_id, action:'delete', page:'soal'},
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