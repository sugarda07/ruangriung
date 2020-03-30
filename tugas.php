<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');


?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" id="data_tugas" style="padding-left: 0px; padding-right: 0px;">

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

    load_data_tugas();

    function load_data_tugas()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'load_data_tugas', page:'tugas'},
            success:function(data)
            {
                $('#data_tugas').html(data);
            }
        });
    }

    $(document).on('click', '.tombol_view_tugas', function(){
        var topik_id = $(this).data('topik_id');
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'tampil_tugas', topik_id:topik_id, page:'materi'},
            success:function(data){
                $('#view_list_materi'+topik_id).html(data);
            }
        })        
    });
});
</script>