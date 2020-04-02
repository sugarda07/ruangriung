<footer class="footer hidden-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; padding: 0px; margin-left: 0px;">
    <div class="row" style="margin-left: 0px; margin-right: 0px;">
        <div class="col-3" style="padding: 10px">
            <a href="index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="icon-home" style="font-size: 20px; color: #03a9f3;"></i></button></a>
        </div>
        <div class="col-3" style="padding: 10px">
            <a href="materi.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-search" style="font-size: 20px; color: #03a9f3;"></i></button></a>
        </div>
        <div class="col-3" style="padding: 10px">
            <a href="ujian_user.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-heart-o" style="font-size: 20px; color: #03a9f3;"></i></button></a>
        </div>
        <div class="col-3" style="padding: 10px">
            <a href="pesan/index.php" aria-haspopup="true" aria-expanded="false"><button type="button" class="btn btn-block btn-flat btn-link" id="total_notif_chat">
                
            </button></a>
        </div>
    </div>
</footer>

<script>
$(document).ready(function(){

    total_notif_chat();

    function total_notif_chat()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'total_notif_chat', page:'notif'},
            success:function(data)
            {
                $('#total_notif_chat').html(data);
            }
        });
    }
});
</script>