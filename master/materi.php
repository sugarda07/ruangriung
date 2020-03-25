<?php

//kelas.php

include('header.php');



?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Data Materi</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_materi" class="btn btn-info btn-sm">Tambah Materi</button>
			</div>
		</div>
	</div>
	<div class="card-body">
	<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="materi_data_tabel" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Nama Materi</td>
						<th>Data Materi</td>
						<th>Kelas Materi</td>
						<th>Tanggal</td>
						<th>Aksi</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="materiModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="materi_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body">
          			<div class="form-group">
          				<label>Nama Materi <span class="text-danger">*</span></label>
                		<input type="text" name="materi_nama" id="materi_nama" class="form-control" />
          			</div>
          			<div class="form-group">
              			<label>Mata Pelajaran <span class="text-danger">*</span></label>
            			<select name="materi_mapel_id" id="materi_mapel_id" class="form-control">
            				<option value="">Pilih Mapel</option>
            				<?php
							echo $exam->mapel_list();
							?>
            			</select>
          			</div>
          			<div class="form-group">
              			<label>Materi isi Materi<span class="text-danger">*</span></label>
	                	<textarea id="materi_data" name="materi_data"></textarea>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">

	        		<input type="hidden" name="page" value="materi" />

	        		<input type="hidden" name="action" id="action" value="Addmateri" />

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
	var dataTable = $('#materi_data_tabel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'materi'}
		},
		"columnDefs":[
			{
				"targets":[4],
				"orderable":false,
			},
		],
	});

	function reset_form()
	{
		$('#modal_title').text('Tambah Data Materi');
		$('#button_action').val('Add');
		$('#action').val('Addmateri');
		$('#materi_form')[0].reset();
		$('#materi_form').parsley().reset();
	}

	$('#add_materi').click(function(){
		reset_form();
		$('#materiModal').modal('show');
		$('#message_operation').html('');
	});

	if ($("#materi_data").length > 0) {
            tinymce.init({
                selector: "textarea#materi_data",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }


    $('#materi_form').parsley();

	$('#materi_form').on('submit', function(event){
		event.preventDefault();

		$('#materi_nama').attr('required', 'required');

		$('#materi_mapel_id').attr('required', 'required');

		$('#materi_data').attr('required', 'required');

		if($('#materi_form').parsley().validate())
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

						$('#materiModal').modal('hide');
					}

					$('#button_action').attr('disabled', false);

					$('#button_action').val($('#action').val());
				}
			});
		}
	});

	var materi_id = '';

	$(document).on('click', '.edit_materi', function(){
		materi_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambilmateri', materi_id:materi_id, page:'materi'},
			dataType:"json",
			success:function(data)
			{
				$('#materi_nama').val(data.materi_nama);

				$('#materi_mapel_id').val(data.materi_mapel_id);

				$('#materi_data').val(data.materi_data);

				$('#materi_id').val(materi_id);

				$('#modal_title').text('Edit Data Materi');

				$('#button_action').val('Edit');

				$('#action').val('Edit_materi');

				$('#materiModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete_materi', function(){
		materi_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{materi_id:materi_id, action:'delete_materi', page:'materi'},
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