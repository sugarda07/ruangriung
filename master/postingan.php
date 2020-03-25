<?php

//kelas.php

include('header.php');



?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Postingan User</h3>
			</div>
			<div class="col-md-3" align="right">
				
			</div>
		</div>
	</div>
	<div class="card-body">
	<span id="message_operation"></span>
		<div class="table-responsive">
			<table id="postingan_data_tabel" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Nama User</td>
						<th>Konten</td>
						<th>Tanggal</td>
						<th>Aksi</td>
					</tr>
				</thead>
			</table>
		</div>
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

	var dataTable = $('#postingan_data_tabel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url: "ajax_proses.php",
			method:"POST",
			data:{action:'ambil', page:'postingan'}
		},
		"columnDefs":[
			{
				"targets":[3],
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.delete_postingan', function(){
		post_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_proses.php",
			method:"POST",
			data:{post_id:post_id, action:'delete_postingan', page:'postingan'},
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