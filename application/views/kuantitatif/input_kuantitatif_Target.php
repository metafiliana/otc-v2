<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading">Update Kuantitatif Target</h3>
					<form class="form-horizontal" 
					action="<?php echo base_url()."kuantitatif/submit_target/";?>"
				 	method="post" id="formsignup" role="form" style="margin-top:10px;">
				 		<input type="hidden" value="<?php if($kuantitatif){echo $kuantitatif->id;}?>" name="id" id="id">
				 		<div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-3 control-label">Metric</label>
				 			<div class="col-sm-4">
							  <input type="text" class="form-control input" name="metric" id="metric" value="<?php echo $kuantitatif->metric ?>">
							</div><div style="clear:both"></div>
				 		</div>
				 		<div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-3 control-label">Last Target <?php echo $kuantitatif->target_year?></label>
				 			<label class="col-sm-9" style="padding-top:7px; margin-bottom:0px;"><?php echo $kuantitatif->target ?></label>
				 		</div>
						<div class="form-group">
							<label class="col-sm-3 control-label input">Update Target</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control input" placeholder="Target" name="target" id="target" value="">
							</div><div style="clear:both"></div>
						</div>
						<hr>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
</script>