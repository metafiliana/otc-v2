<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading"><?= $title ?></h3>
					<form class="form-horizontal"
					action="<?php echo base_url()."general/submit_form/kuan_legend";?>"
				 	method="post" id="formsignup" role="form">
                  <div style="margin-top:20px">
                    <div class="form-group">
            					<label class="col-sm-2 control-label input-sm">Initiative</label>
            					<div class="col-sm-9">
            					  <select class="form-control input-sm" name="status" id="status" onchange="change_metric(this.value)">
                        <option value=""></option>
                        <?php foreach ($arr_title as $arr) { ?>
                          <option value="<?= $arr->init_code?>"><?= $arr->init_code?>. <?= $arr->title?></option>
                        <?php } ?>
            					  </select>
            					</div><div style="clear:both"></div>
            				</div>
                    <div class="form-group" id="metric" hidden="true">
            					<label class="col-sm-2 control-label input-sm">Metric</label>
            					<div class="col-sm-9">
            					  <select class="form-control input-sm" name="metrics" id="metrics" onchange="">
                          <option value="">-- Select Metric --</option>
            					  </select>
            					</div><div style="clear:both"></div>
            				</div>
                    <hr>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                  </div>
					</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
function change_metric(init_code){
  $.ajax({
    type: "GET",
    url: config.base+"general/change_metric",
    data: {init_code:init_code},
    dataType: 'json',
    cache: false,
    success: function(resp){
      if(resp.status==1){
        $.each(resp.html, function(i, data) {
        $('#metrics').append("<option value='" + data.id + "'>"+ data.type + " - " + data.metric + "</option>");
        });
        $('#metric').show();
      }else{}
    }
  });
}
</script>
