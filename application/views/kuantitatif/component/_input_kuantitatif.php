<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading"><?= $title ?></h3>
					<form class="form-horizontal"
					action="<?php echo base_url()."kuantitatif/submit_kuantitatif";?><?php if($kuan_id) echo '/'.$kuan_id;?>"
				 	method="post" id="formsignup" role="form" style="margin-top:10px;">
				 		<input type="hidden" value="<?php if($init_id){echo $init_id;}?>" name="init_id" id="init_id">
				 		<input type="hidden" value="<?php if($init_code){echo $init_code;}?>" name="init_code" id="init_code">
            <div class="form-group">
							<label class="col-sm-2 control-label">Type</label>
              <input type="radio" name="type" value="Leading" <?php if(isset($kuantitatif)){if($kuantitatif->type == "Leading"){echo "checked";}}?>> Leading<br>
              <input type="radio" name="type" value="Lagging" <?php if(isset($kuantitatif)){if($kuantitatif->type == "Lagging"){echo "checked";}}?>> Lagging<br>
						</div>
            <div class="form-group" style="margin-bottom:5px;">
				 			<label class="col-sm-2 control-label">Metric</label>
              <div class="col-sm-9">
				 			<input type="text" class="form-control" id="metric" name="metric" placeholder="Metric" value="<?php if (isset($kuantitatif->metric)){ echo $kuantitatif->metric; }?>">
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Measurment</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="measurment" name="measurment" placeholder="Measurment" value="<?php if (isset($kuantitatif->measurment)){ echo $kuantitatif->measurment; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Target</label>
                <div class="col-sm-9">
                <input type="number" class="form-control" id="target" name="target" placeholder="Target" value="<?php if (isset($kuantitatif->target)){ echo number_format($kuantitatif->target,0,",",""); }?>">
                </div>
            </div>
            <?php $arr_month=['January','February','March','April','May','June','July','August','September','October','November','December']; if(isset($kuantitatif)){ ?>
              <div class="row" style="margin:20px 0 20px 0;">
                <table>
                    <tr>
                      <td></td>
                      <?php foreach ($arr_month as $val) { ?>
                      <td>
                          <?= $val ?>
                      </td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td>
                        Target
                      </td>
                      <?php foreach ($arr_month as $val2) { ?>
                        <td>
                          <input type="number" class="form-control" name="target_<?= $val2 ?>" value="<?php if(isset($kuantitatif->$val2)){echo number_format($kuantitatif->$val2,0,",","");} ?>"/>
                        </td>
                      <?php } ?>
                    </tr>
                </table>
              </div>
            <?php } ?>
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
