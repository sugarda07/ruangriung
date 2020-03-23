<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

?>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" style="margin-bottom: 65px;margin-top: 5px;">
                            <div class="card-body">
                                <div class="message-box">
                                    <div class="message-widget message-scroll" id="load_notif">

                                    </div>
                                </div>
                                <div id="load_data_message" style="display: none;"></div>
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
	var limit = 10;
    var start = 0;
    var action = 'inactive';
    function load_notif_list(limit, start)
    {
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit:limit, start:start, action:'load_notif', page:'notif'},
            cache:false,
            success:function(data)
            {
                $('#load_notif').append(data);
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
        load_notif_list(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#load_notif").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
            load_notif_list(limit, start);
            }, 1000);
        }
    });
});
</script>