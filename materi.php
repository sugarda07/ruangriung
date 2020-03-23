<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');


?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                            <div class="card-body" id="data_mapel" style="padding: 9px;">

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

    load_data_mapel();

    function load_data_mapel()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'load_data_mapel', page:'materi'},
            success:function(data)
            {
                $('#data_mapel').html(data);
            }
        });
    }

    $(document).on('click', '.tombol_view_materi', function(){
        var mapel_id = $(this).data('mapel_id');
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'tampil_materi', mapel_id:mapel_id, page:'materi'},
            success:function(data){
                $('#view_list_materi'+mapel_id).html(data);
            }
        })        
    });
});
</script>