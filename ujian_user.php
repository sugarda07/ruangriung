<?php

//enroll_exam.php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

?>

		<div class="row">
		    <div class="col-lg-8 col-xlg-9 col-md-7" id="data_ujian" style="padding-left: 0px; padding-right: 0px;">

		    </div>
		</div>
	</div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>

<script>

$(document).ready(function(){

	load_data_ujian();

    function load_data_ujian()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'load_data_ujian', page:'ujian'},
            success:function(data)
            {
                $('#data_ujian').html(data);
            }
        });
    }

    $(document).on('click', '#konfirmasi', function(){ 
		ujian_id = $(this).data('ujian_id');

		swal({
		title: "Konfirmasi",
		text: "",
		type: "warning",
		showCancelButton: true,
		cancleButtonText: "Batal",
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Konfirmasi",
		closeOnConfirm: false
		},
		function(){
			$.ajax({
			    url:"user_ajax_proses.php",
			    method:"POST",
			    data:{action:'konfirmasi', page:'ujian', ujian_id:ujian_id},
			    success: function(data){
			        swal({
			            title : "Konfirmasi",
			            text: "Berhasil",
			            type: "success",
			            timer: 5000
			        });
			    	load_data_ujian();
			    }
			});        
		});
	});

});

</script>