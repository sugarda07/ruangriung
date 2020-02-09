<script>  

$(document).ready(function(){



  setInterval(function(){
    //postingan_post();
    load_total_notif();
    total_notif_chat();
  }, 5000);


  $('#form_postingan1').on('submit', function(event){
        event.preventDefault();

        if($('#postingan1').val() == '')
        {
           $('#opsi_postingan').modal('hide');
        }
        else
        {
          var form_data = $(this).serialize();
          $.ajax({
              url:"inc/proses.php",
              method:"POST",
              data:form_data,
              beforeSend:function()
              {
                  $('#tombol_postingan1').attr('disabled', 'disabled');  
              },
              success:function(data)
              {
                $('#opsi_postingan').modal('hide');
                $('#uploadvideoModal').modal('hide');
                $('#form_postingan1')[0].reset();
                postingan_post();
              }
          })
        }
    });

  $('#form_embed_video').on('submit', function(event){
        event.preventDefault();

        if($('#post_embed_video').val() == '')
        {
           
        }
        else
        {
          var form_data = $(this).serialize();
          $.ajax({
              url:"inc/proses.php",
              method:"POST",
              data:form_data,
              beforeSend:function()
              {
                  $('#tombol_post_embed').attr('disabled', 'disabled');  
              },
              success:function(data)
              {
                $('#opsi_postingan').modal('hide');
                $('#embed_videomodal').modal('hide');
                $('#form_embed_video')[0].reset();
                postingan_post();
              }
          })
        }
    });

  $('#fileupload_video').on('change', function(){
    $('#opsi_postingan').modal('hide');
    $('#uploadvideoModal').modal('show');
  });

  $('#form_posting_video').on('submit', function(event){
        event.preventDefault();

        if($('#fileupload_video').val() == '')
        {
            
        }
        else
        {
            $.ajax({
                url:"inc/proses.php",
                method:"POST",
                data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
                  dataType:"json",
                beforeSend:function()
                {
                    $('#tombol_post_video').attr('disabled', 'disabled');  
                },
                success:function(data)
                {
                  $('#uploadvideoModal').modal('hide');
                  $('#form_posting_video')[0].reset();
                  postingan_post();
                }
            })
        }
    });


	$posting_crop = $('#tampil_posting').croppie({
		enableExif: true,
		viewport: {
			width:300,
			height:300,
			type:'square' //circle
		},
		boundary:{
			width:'100%',
      height:'100%'
		},
    showZoomer: true,
    enableResize: true,
    enableOrientation: true,
    mouseWheelZoom: 'ctrl',
    enforceBoundary: false,
        customClass: 'square-image'
	});

	$('#upload_posting').on('change', function(){
		var reader = new FileReader();
		reader.onload = function (event) {
		$posting_crop.croppie('bind', {
		url: event.target.result
		}).then(function(){
			console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
    $('#opsi_postingan').modal('hide');
		$('#uploadimageModal').modal('show');
	});

	$('.posting_crop').click(function(){
		
			$posting_crop.croppie('result', {
				type: 'canvas',
				size: '30%'
			}).then(function(response, konten){
				var konten = $('#posting').val();
				$.ajax({
					url:'media/posting_post.php',
					method:'POST',
					data:{"image":response, konten:konten},
					beforeSend:function()
					{
					$('#tombol_post').attr('disabled', 'disabled');  
					},
					success:function(data){
					$('#form_posting_upload')[0].reset();
					$('#uploadimageModal').modal('hide');
					postingan_post();
					}
				})
			})
		
	});



  postingan_post();

  function postingan_post()
  {
     var proses = 'postingan_post';
     $.ajax({
          url:'inc/proses.php',
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#postingan_list').html(data);
          }
     })
  }

  posting_profil();
  function posting_profil()
  {
     var proses = 'posting_profil';
     $.ajax({
          url:'media/view_post_profil.php',
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
            $('#view_posting_profil_list').html(data);
          }
     });
  }

  load_notif_list();

  function load_notif_list()
  {
      var proses = 'load_notif';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#load_notif').html(data);
          }
      });
  }

  load_total_notif();

  function load_total_notif()
  {
      var proses = 'load_total_notif';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#total_notif').html(data);
          }
      });
  }

  $('#view_notification').click(function(){
        var proses = 'update_notification_status';
        $.ajax({
            url:"inc/proses.php",
            method:"post",
            data:{proses:proses},
            success:function(data)
            {
                $('#total_notification').remove();
            }
        })
    });

  pengikut();

  function pengikut()
  {
      var proses = 'pengikut';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#pengikut_list').html(data);
          }
      });
  }

  mengikuti();

  function mengikuti()
  {
      var proses = 'mengikuti';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#mengikuti_list').html(data);
          }
      });
  }

  $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var proses = $(this).data('proses');
        $.ajax({
            url:"inc/proses.php",
            method:"POST",
            data:{sender_id:sender_id, proses:proses},
            success:function(data)
            {
                postingan_post();
                posting_profil();
                pengikut();
                mengikuti();
            }
        })
    });

  var post_id;
  var user_id;

  $(document).on('click', '.post_comment', function(){
      post_id = $(this).attr('id');
      user_id = $(this).data('user_id');
      var proses = 'fetch_comment';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{post_id:post_id, user_id:user_id, proses:proses},
          success:function(data){
              $('#old_comment'+post_id).html(data);
              $('#comment_form'+post_id).slideToggle('slow');
          }
      })      
  });

  $(document).on('click', '.submit_comment', function(){
        var comment = $('#comment'+post_id).val();
        var proses = 'submit_comment';
        var receiver_id = user_id;
        if(comment != '')
        {
            $.ajax({
                url:"inc/proses.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment,proses:proses},
                success:function(data)
                {
                    $('#comment_form'+post_id).slideUp('slow');
                    postingan_post();
                    posting_profil();
                }
            })
        }
    });

  $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"inc/proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                postingan_post();
                posting_profil();
                load_total_notif();
            }
        })
    });


   $profil_crop = $('#tampil_gambar').croppie({
    enableExif: true,
    viewport: {
      width:300,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:'100%',
      height:'100%'
    }    
  });

  $('#upload_fotoprofil').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $profil_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#fotoprofil_modal').modal('show');
  });

  $('.crop_image').click(function(event){
    $profil_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:'media/profil_back_proses.php',
        type:'POST',
        data:{"profil":response},
        success:function(data){
          $('#fotoprofil_modal').modal('hide');
          load_fprofil();
        }
      })
    });
  });

  load_fprofil();

  function load_fprofil()
  {
    $.ajax({
      url:"media/load_fotoprofil.php",
      success:function(data)
      {
        $('#load_fotoprofil').html(data);
      }
    })
  }


   $image_crop = $('#tampil_gambar_back').croppie({
    enableExif: true,
    viewport: {
      width:330,
      height:120,
      type:'square' //circle
    },
    boundary:{
      width:'100%',
      height:'100%'
    }    
  });

  $('#upload_backround').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#backround_modal').modal('show');
  });

  $('.crop_backround').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:'media/profil_back_proses.php',
        type:'POST',
        data:{"image":response},
        success:function(data){
          $('#backround_modal').modal('hide');
          load_backround();
        }
      })
    });
  });

  load_backround();

  function load_backround()
  {
    $.ajax({
      url:"media/profil_back.php",
      success:function(data)
      {
        $('#backround_tampil').html(data);
      }
    })
  }

  $(document).on('click', '.view_post_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'view_posting_profil';
        $.ajax({
            url:"inc/proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
              $('#view_postmodal').modal('show');
              $('#view_posting_profil_list').html(data);
            }
        })
    });

  $(document).on('click', '.post_allbutton', function(){
        var post_id = $(this).data('post_id');
        var proses = 'view_posting_profil';
        $.ajax({
            url:"inc/proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
              $('#post_allmodal').modal('show');
              $('#posting_all_list').html(data);
            }
        })
    });


  function load_post_all()
  {
    var post_id = 'post_id';
     var proses = 'view_posting_profil';
     $.ajax({
          url:'inc/proses.php',
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#posting_all_list').html(data);
          }
     })
  }


  total_notif_chat();

  function total_notif_chat()
  {
      var proses = 'total_notif_chat';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#total_notif_chat').html(data);
          }
      });
  }


  load_notif_chat();

  function load_notif_chat()
  {
      var proses = 'load_notif_chat';
      $.ajax({
          url:"inc/proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#load_notif_chat').html(data);
          }
      });
  }



  
});  
</script>

