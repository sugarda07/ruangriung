<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

include('header.php');

$exam->query = "
SELECT * FROM materi
WHERE materi_id = '".$_GET["data"]."'
";

?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                            <div class="card-body" id="view_data_materi" style="padding-bottom: 50px;">

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

    view_data_materi();

    function view_data_materi()
    {
        var materi_id = '<?php echo $_GET["data"];?>';
        $.ajax({
            url:'user_ajax_proses.php',
            method:"POST",
            data:{action:'view_data_materi', materi_id:materi_id, page:'materi'},
            success:function(data)
            {
              $('#view_data_materi').html(data);
            }
        })
    }

});
</script>