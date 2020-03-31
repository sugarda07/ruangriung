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
				<button type="button" id="<?php echo $exam->Get_ujian_id($_GET["code"]); ?>" class="btn btn-info btn-sm upload_soal">Upload Soal</button>
				<button type="button" id="<?php echo $exam->Get_ujian_id($_GET["code"]); ?>" class="btn btn-info btn-sm add_soal">Tambah Soal</button>
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

<div class="modal" id="uploadModal">
  	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
  			<!-- Modal Header -->
    		<div class="modal-header">
      			<h4 class="modal-title" id="upload_modal_title"></h4>
      			<button type="button" class="close" data-dismiss="modal">&times;</button>
    		</div>

    		<!-- Modal body -->
    		<div class="modal-body">
    			<form  method="post" enctype="multipart/form-data" action="import.php">  
					<div class="col-md-3">  
						<label>Add More Data</label>  
					</div>  
					<div class="col-md-4">  
						<input type="file" name="filesoal" style="margin-top:15px;" />  
					</div>  
					<div class="col-md-5"> 
						<input type="text" name="soal_ujian_id" id="hidden_soal_ujian_id" />
						<input type="submit" name="upload" id="upload" value="Import" style="margin-top:10px;" class="btn btn-info" />  
					</div>  
					<div style="clear:both"></div>  
                </form>
    		</div> 

        	<!-- Modal footer -->
        	<div class="modal-footer">
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

	$(document).on('click', '.upload_soal', function(){
		$('#uploadModal').modal('show');
		$('#message_operation').html('');
		ujian_id = $(this).attr('id');
		$('#hidden_soal_ujian_id').val(ujian_id);
	});

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
				$('#soal_button_action').val('Edit');
				$('#hidden_action').val('Edit');
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

	$('#upload_form').on('submit', function(event){
		event.preventDefault();


			$.ajax({
				url:"import.php",
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

						dataTable.ajax.reload();
						$('#uploadModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);

					$('#button_action').val($('#hidden_action').val());
				}
			});
	});
 

});

</script>

<?php

include('footer.php');

?>