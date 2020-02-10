<div class="content-wrapper" style="padding-top: 58px; padding-bottom: 58px;">
    <div class="container" style="padding-left: 0px; padding-right: 0px;">
      	<div class="col-md-6" style="margin-right: -5px; margin-left: -5px;">
      		<div class="box box-primary">
	            <div class="box-header with-border">
	              <div class="has-feedback">
	                  <input type="search" id="cari_teman" name="cari_teman" class="form-control input-sm" placeholder="Cari" aria-label="Search" autocomplete="off">
	                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
	                </div>
	            </div>
	            <div class="box-body" style="padding-left: 20px; padding-right: 20px;">
	              <ul class="contacts-list" id="load_notif">

	              </ul>
	            </div>
	          </div>
      	</div>
    </div>
</div>

<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.js"></script>
<script>
  $(document).ready(function(){
      
    $('#cari_teman').autocomplete({
      source: "media/cari_teman.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_teman').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>