<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$data = $exam->Get_user_id($_GET["data"]);
?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" id="view_profil" style="margin-bottom: 5px;">

                        </div>
                        <div class="card">
                            <div class="card-body" style="padding: 9px;">
                                <div class="profiletimeline" id="view_profil_posting">

                                </div>
                            </div>
                            <div id="load_data_message" style="display: none;"></div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php');?>
    </div>
</body>
</html>

<div id="pengikutModal" class="modal modal-fullscreen" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" id="myLargeModalLabel" style="padding-left: 25px;">Pengikut</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            <div class="modal-body">
                <div class="message-box">
                  <div class="message-widget message-scroll" id="data_pengikut">
                    
                  </div>
              </div>
            </div>
            <div class="modal-footer" style="padding-top: 5px;padding-bottom: 5px;">
                © 2020 RuangDIGITAL by @sugarda3rd
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<div id="mengikutiModal" class="modal modal-fullscreen" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" id="myLargeModalLabel" style="padding-left: 25px;">Mengikuti</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            <div class="modal-body">
                <div class="message-box">
                  <div class="message-widget message-scroll" id="data_mengikuti">
                    
                  </div>
              </div>
            </div>
            <div class="modal-footer" style="padding-top: 5px;padding-bottom: 5px;">
                © 2020 RuangDIGITAL by @sugarda3rd
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<script>
$(document).ready(function(){ 

    view_profil();

    function view_profil()
    {
        var user_id = '<?php echo $data ;?>';
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{action:'view_profil', user_id:user_id, page:'profil'},
            success:function(data)
            {
                $('#view_profil').html(data);
            }
        })
    }

    var limit = 5;
    var start = 0;
    var action = 'inactive';
    function view_profil_posting(limit, start)
    {
        var user_id = '<?php echo $data ;?>';
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit:limit, start:start, user_id:user_id, action:'view_profil_posting', page:'profil'},
            cache:false,
            success:function(data)
            {
                $('#view_profil_posting').append(data);
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
        view_profil_posting(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#view_profil_posting").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
            view_profil_posting(limit, start);
            }, 1000);
        }
    });

    $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var action = $(this).data('action');
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{sender_id:sender_id, action:action, page:'profil'},
            success:function(data)
            {              
                view_profil();
                pengikut();
                mengikuti();
            }
        })
    });

    $(document).on('click', '.tombol_pengikut', function(){
        $('#pengikutModal').modal('show');
        pengikut();
    });

    pengikut();

    function pengikut()
    {
        var user_id = '<?php echo $data ;?>';
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'pengikut', user_id:user_id, page:'profil'},
            success:function(data)
            {
            $('#data_pengikut').html(data);
            }
        });
    }

    $(document).on('click', '.tombol_mengikuti', function(){              
        $('#mengikutiModal').modal('show');
        mengikuti();
    });

    mengikuti();

    function mengikuti()
    {
        var user_id = '<?php echo $data ;?>';
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'mengikuti', user_id:user_id, page:'profil'},
            success:function(data)
            {
                $('#data_mengikuti').html(data);
            }
        });
    }

    

});
</script>