<?php

//kelas.php

include('header.php');



?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Data Kelas</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_button" class="btn btn-info btn-sm">Tambah Kelas</button>
			</div>
		</div>
	</div>
	<div class="card-body">
	<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="kelas_data_tabel" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Nama Kelas</th>
						<th>Jurusan</th>
						<th>Sekolah</th>
						<th>Rombel</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="formModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="kelas_form">
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
              				<label class="col-md-4 text-right">Tingkat <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="kelas_tingkat" id="kelas_tingkat" class="form-control">
	                				<option value="">Select</option>
	                				<option value="10"> 10</option>
	                				<option value="11"> 11</option>
	                				<option value="12"> 12</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Nama Kelas <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="kelas_nama" id="kelas_nama" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Program Keahlian <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="kelas_jurusan" id="kelas_jurusan" class="form-control">
	                				<option value="">Select</option>
	                				<option value="BDP">BISNIS DARING DAN PEMASARAN</option>
	                				<option value="OTKP">OTOMATISASI DAN TATA KELOLA PERKANTORAN</option>
	                				<option value="TKJ">TEKNIK KOMPUTER DAN JARINGAN</option>
	                				<option value="RPL">REKAYASA PERANGKAT LUNAK</option>
	                				<option value="TSM">TEKNIK SEPEDA MOTOR</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Nama Sekolah <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<select name="kelas_sekolah" id="kelas_sekolah" class="form-control">
	                				<option value="">Select</option>
	                				<option value="SMK AL-HIKMAH TAROGONG KALER">SMK AL-HIKMAH TAROGONG KALER</option>
	                				<option value="SMK ASSHIDDIQIYAH GARUT">SMK ASSHIDDIQIYAH GARUT</option>
	                				<option value="SMK IKA KARTIKA">SMK IKA KARTIKA</option>
	                			</select>
	                		</div>
            			</div>
          			</div>
        		</div>

	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="kelas_id" id="kelas_id" />

	        		<input type="hidden" name="page" value="kelas" />

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

<div id="daftar_siswa_modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			    <h4 class="modal-title" id="judul_modal">Sekolah</h4>
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>        
			<div class="modal-body" id="daftar_siswa">
				
			</div>        
			<div class="modal-footer">
			    <button type="button" class="btn btn-info waves-effect pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>         
	</div>
</div>

<script>

$(document).ready(function(){
	
	var dataTable = $('#kelas_data_tabel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'kelas'}
		},
		"columnDefs":[
			{
				"targets":[3, 4],
				"orderable":false,
			},
		],
	});

	function reset_form()
	{
		$('#modal_title').text('Tambah Data Kelas');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#kelas_form')[0].reset();
		$('#kelas_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});

	$('#kelas_form').parsley();

	$('#kelas_form').on('submit', function(event){
		event.preventDefault();

		$('#kelas_tingkat').attr('required', 'required');

		$('#kelas_nama').attr('required', 'required');

		$('#kelas_jurusan').attr('required', 'required');

		$('#kelas_sekolah').attr('required', 'required');

		if($('#kelas_form').parsley().validate())
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

	var kelas_id = '';

	$(document).on('click', '.edit', function(){
		kelas_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{action:'edit_ambil', kelas_id:kelas_id, page:'kelas'},
			dataType:"json",
			success:function(data)
			{
				$('#kelas_tingkat').val(data.kelas_tingkat);

				$('#kelas_nama').val(data.kelas_nama);

				$('#kelas_jurusan').val(data.kelas_jurusan);

				$('#kelas_sekolah').val(data.kelas_sekolah);

				$('#kelas_id').val(kelas_id);

				$('#modal_title').text('Edit Data Kelas');

				$('#button_action').val('Edit');

				$('#action').val('Edit');

				$('#formModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		kelas_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{kelas_id:kelas_id, action:'delete', page:'kelas'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.lihat_daftar_siswa', function(){  
         var id = $(this).attr("id");
         var kelas = $(this).data('kelas');  
         if(id != '')  
         {  
            $.ajax({  
				url:"ajax_proses.php",  
				method:"POST",  
				data:{id:id, action:'lihat_daftar_siswa', page:'kelas'},  
				success:function(data){   
				  $('#daftar_siswa').html(data);
				  $('#judul_modal').text("Daftar Siswa "+kelas+"");
				  $('#daftar_siswa_modal').modal('show');  
				}  
            });  
        }            
    });

});

</script>

<?php

include('footer.php');

?>