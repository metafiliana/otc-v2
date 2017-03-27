<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading">Update Kuantitatif</h3>
					<form class="form-horizontal" 
					action="<?php echo base_url()."kuantitatif/submit_kuantitatif_update/";?>"
				 	method="post" id="formsignup" role="form">
				 		<input type="hidden" value="<?php if($kuantitatif){echo $kuantitatif->id;}?>" name="id" id="id">
				 		<input type="hidden" value="<?php if($kuantitatif){echo $kuantitatif->target_year;}?>" name="year" id="year">
				 		<div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-3 control-label">Metric</label>
				 			<label class="col-sm-9" style="padding-top:7px; margin-bottom:0px;"><?php echo $kuantitatif->metric ?></label>
				 		</div>
				 		<div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-3 control-label">Target <?php echo $kuantitatif->target_year?></label>
				 			<label class="col-sm-9" style="padding-top:7px; margin-bottom:0px;"><?php echo $kuantitatif->target ?></label>
				 		</div>
				 		<?php if($update) {?>
				 		<div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-3 control-label">Last Realisasi (<?php echo date('F',mktime(0,0,0, $update->month,10));?>)</label>
				 			<label class="col-sm-9" style="padding-top:7px; margin-bottom:0px;"><?php echo $update->amount ?></label>
				 		</div>
				 		<?php } ?>
				 		<div class="form-group">
							<label class="col-sm-3 control-label">Bulan</label>
							<div class="col-sm-5">
								<select class="form-control" name="month" id="month">
									<option value="1">Januari</option>
									<option value="2">Februari</option>
									<option value="3">Maret</option>
									<option value="4">April</option>
									<option value="5">Mei</option>
									<option value="6">Juni</option>
									<option value="7">Juli</option>
									<option value="8">Agustus</option>
									<option value="9">September</option>
									<option value="10">Oktober</option>
									<option value="11">November</option>
									<option value="12">Desember</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label input">Jumlah</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control input" placeholder="Jumlah" name="amount" id="amount" value="">
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