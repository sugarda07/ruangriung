<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');


?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                            <div class="card-body" style="padding: 9px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Cari">
                                    <div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                </div>
                            </div>                            
                        </div>
                        <div class="card" id="dynamic_content">

                        </div>
                        <div id="load_data_message" style="display: none;"></div>
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

    $('#search_box').keyup(function(){
        var kata = $('#search_box').val();
    });

    var limit = 15;
    var start = 0;
    var action = 'inactive';
    function cari_postingan(limit, start)
    {
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit:limit, start:start, action:'cari', page:'cari_posting'},
            cache:false,
            success:function(data)
            {
                $('#dynamic_content').append(data);
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
        var kata = $('#search_box').val();
        action = 'active';
        cari_postingan(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#dynamic_content").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
            cari_postingan(limit, start);
            }, 1000);
        }
    });
});
</script>