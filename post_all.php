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
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#orang" role="tab" style="padding-left: 15px; padding-right: 15px;"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Orang</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#post_gallery" role="tab" style="padding-left: 15px; padding-right: 15px;"><span class="hidden-sm-up"><i class="ti-gallery"></i></span> <span class="hidden-xs-down">Gallery</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="orang" role="tabpanel">                                    
                                    <div class="card" style="margin-bottom: 5px;">
                                        <div class="card-body" style="padding: 9px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="cari_kontak" id="cari_kontak" placeholder="Cari">
                                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body" style="padding: 5px;">
                                            <div class="message-box" id="dynamic_kontak">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="post_gallery" role="tabpanel">
                                    <div class="p-20" style="padding: 0px;">
                                        <div class="gallery-section">
                                            <div class="inner-width">
                                                <div class="gallery" id="post_all_gallery">

                                                </div>
                                                <div id="load_data_message" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
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

<style type="text/css">
    .ui-autocomplete-row
    {
        padding:8px;
        background-color: #ffffff;
        border-bottom:1px solid #ece3e3;
        font-weight:bold;
    }
    .ui-autocomplete-row:hover
    {
        background-color: #000000;
    }
</style>

<script>
$(document).ready(function(){ 
    var limit = 15;
    var start = 0;
    var action = 'inactive';
    function post_all_gallery(limit, start)
    {
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit:limit, start:start, action:'post_all_gallery', page:'post_all'},
            cache:false,
            success:function(data)
            {
                $('#post_all_gallery').append(data);
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
        post_all_gallery(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#post_all_gallery").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
            post_all_gallery(limit, start);
            }, 1000);
        }
    });

    var limit_kontak = 10;
    var start_kontak = 0;
    var action_kontak = 'inactive';
    function cari_kontak_list(limit_kontak, start_kontak)
    {
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{limit_kontak:limit_kontak, start_kontak:start_kontak, action:'cari_kontak', page:'post_all'},
            cache:false,
            success:function(data)
            {
                $('#dynamic_kontak').append(data);
                if(data == '')
                {
                    $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
                    action_kontak = 'active';
                }
                else
                {
                    $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
                    action_kontak = "inactive";
                }
            }
        });
    }

    if(action_kontak == 'inactive')
    {
        action_kontak = 'active';
        cari_kontak_list(limit_kontak, start_kontak);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#dynamic_kontak").height() && action_kontak == 'inactive')
        {
            action_kontak = 'active';
            start_kontak = start_kontak + limit_kontak;
            setTimeout(function(){
            cari_kontak_list(limit_kontak, start_kontak);
            }, 1000);
        }
    });

    $('#cari_kontak').autocomplete({
        source: "cari_kontak.php",
        minLength: 1,
        select: function(event, ui)
        {
            $('#cari_kontak').val(ui.item.value);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };
    
});
</script>