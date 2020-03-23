<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                    	<div class="card" style="margin-bottom: 5px;margin-top: 5px;">
	                        <div class="card-body" style="padding: 5px;">
                              <div class="profiletimeline" id="view_posting">
                                    
                              </div>
	                        </div>
	                    </div>                        
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

	view_posting();

	function view_posting()
	{
		var post_id = '<?php echo $_GET["data"];?>';
		$.ajax({
			url:'user_ajax_proses.php',
			method:"POST",
			data:{action:'load_postingan', page:'view_posting', post_id:post_id},
			success:function(data)
			{
				$('#view_posting').html(data);
			}
		})
	}

	$(document).on('click', '.like_button', function(){
	    var post_id = $(this).data('post_id');
	    $.ajax({
	        url:"user_ajax_proses.php",
	        method:"POST",
	        data:{post_id:post_id, action:'like', page:'view_posting'},
	        success:function(data)
	        {
	            view_posting();
	        }
	    })
	});

	var post_id;
	var user_id;
	$(document).on('click', '.post_comment', function(){
	    post_id = $(this).attr('id');
	    user_id = $(this).data('user_id');
	    $.ajax({
	        url:"user_ajax_proses.php",
	        method:"POST",
	        data:{post_id:post_id, user_id:user_id, action:'fetch_comment', page:'view_posting'},
	        success:function(data){
	            $('#old_comment'+post_id).html(data);
	            $('#comment_form'+post_id).modal('show');
	        }
	    })      
	});


    $(document).on('click', '.submit_comment', function(){
        var comment = $('#comment'+post_id).val();
        var receiver_id = user_id;
        if(comment != '')
        {
            $.ajax({
                url:"user_ajax_proses.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment, action:'submit_comment', page:'view_posting'},
                success:function(data)
                {
                    $('#comment_form'+post_id).modal('hide');
                    view_posting();
                }
            })
        }
    });


});
</script>