<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$foto_status = $exam->Get_foto_status($_SESSION["user_id"]);

?>

			<div class="row d-flex justify-content-center">
			    <!-- Column -->
			    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
			        <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
			            <div class="card-body" style="padding: 5px;">
			                <div class="message-box">
			                    <div class="message-widget message-scroll">
			                        <!-- Message -->
			                        <a href="javascript:void(0)">
			                            <div class="user-img"  style="margin-bottom: 0px;"><?php echo $foto_status; ?>                                                
			                            </div>
			                            <div class="mail-contnet"  style="width: 80%;">
			                                <span class="mail-desc">
			                                    <button class="btn btn-block btn-rounded btn-secondary tombol_upload_posting_gambar">Tuliskan sesuatu disini...</button>
			                                </span>
			                            </div>
			                        </a>
			                    </div>
			                </div>
			            </div>
			        </div>                        
			    </div>

			    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
			        <div class="card">
			            <!-- Nav tabs -->
			            <div class="card-body" style="padding: 5px;">
			                <div class="profiletimeline" id="postingan_list">
			                    
			                </div>
			            </div>
			            <div id="load_data_message" style="display: none;"></div>
			        </div>
			    </div>
			    <!-- Column -->
			</div>
		</div>
	</div>

    <?php include('footer.php');?>

</div>

<div id="posting_gambar_modal" class="modal modal-fullscreen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border:none;">
        <div class="modal-header">
            <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
            <h4 class="modal-title" style="padding-left: 25px;">Postingan Baru</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form method="post" id="posting_gambar_form">
            <div class="modal-body" style="background-color: rgba(4, 1, 49, 0.84);">
                
                <div id="tampil_posting_gambar" style="display:none;"></div>
                <input type="file" name="upload_posting_gambar" id="upload_posting_gambar" accept=".jpg, .png"  style="display: none;"/> 
                
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="button" style="padding-top: 0px; padding-bottom: 0px;"><label for="upload_posting_gambar" style="margin-bottom: 0px;"><i class="fa fa-camera" style="font-size:18px;"></i></label></a>
                <textarea class="form-control mention" type="text" rows="3" name="posting_gambar_konten" id="posting_gambar_konten" placeholder="Tulis sesuatu ..."  style="border-radius: 9px;"></textarea>
                <button type="submit" name="share_post_gambar" id="share_post_gambar" class="btn btn-info waves-effect waves-light crop_posting_gambar">Post </button>
            </div>
        </form>
      </div>         
    </div>
</div>
</body>
</html>

<script>
$(function () {
    $('textarea.mention').mentionsInput({
        onDataRequest:function (mode, query, callback) {
            $.getJSON('get_user_json.php', function(responseData) {
            responseData = _.filter(responseData, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
            callback.call(this, responseData);
            });
        }
    });
});
</script>

<script>
$(document).ready(function(){ 

    $(document).on('click', '.tombol_upload_posting_gambar', function(){
        $('#posting_gambar_modal').modal('show');
    });

    $crop_posting_gambar = $('#tampil_posting_gambar').croppie({
    	enableExif: true,
	    viewport: {
	        width:300,
	        height:300,
	        type:'square' //circle
	    },
	    boundary:{
	        width:'300',
	        height:'300'
	    }    
    });

    $('#upload_posting_gambar').on('change', function(){
    	var reader = new FileReader();
        reader.onload = function (event) {
            $crop_posting_gambar.croppie('bind', {
            url: event.target.result
            }).then(function(){
            console.log('jQuery bind complete');
            });
        }
    	reader.readAsDataURL(this.files[0]);
        $('#tampil_posting_gambar').slideToggle('slow');
    });

    $('.crop_posting_gambar').click(function(event){
    	$crop_posting_gambar.croppie('result', {
	        type: 'canvas',
	        size: 'viewport'
    	}).then(function(response, posting_gambar_konten, upload_posting_gambar){
	        var posting_gambar_konten = $('#posting_gambar_konten').val();
	        var upload_posting_gambar = $('#upload_posting_gambar').val();
	        $.ajax({
	            url:'user_ajax_proses.php',
	            method:'POST',
	            data:{"gambar":response, action:'insert_posting_gambar', page:'index', posting_gambar_konten:posting_gambar_konten, upload_posting_gambar:upload_posting_gambar},
	            beforeSend:function()
	            {
	            $('#share_post_gambar').attr('disabled', 'disabled');  
	            },
	            success:function(data){
	                $('#posting_gambar_modal').modal('hide');
	                $('#posting_gambar_form')[0].reset();
	                $('#posting_gambar_konten').val('');
	                $('#upload_posting_gambar').val('');
	                $("textarea.mention").mentionsInput('reset');
	                window.location.href="index.php";
	            }
	        })
	    });
    });

    var limit = 5;
    var start = 0;
    var action = 'inactive';
    function postingan_post(limit, start)
    {
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit:limit, start:start, action:'load_postingan', page:'index'},
            cache:false,
            success:function(data)
            {
                $('#postingan_list').append(data);
                if(data == '')
                {
                    $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
                    action = 'active';
                }
                else
                {
                    $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
                    action = "inactive";
                }
            }
        });
    }
    if(action == 'inactive')
    {
        action = 'active';
        postingan_post(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#postingan_list").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
            postingan_post(limit, start);
            }, 1000);
        }
    });

    

});
</script>