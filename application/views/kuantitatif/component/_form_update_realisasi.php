<?php
$user = $this->session->userdata('user');
$arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
?>
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
					action="<?php echo base_url()."kuantitatif/submit_kuantitatif_realisasi"; ?>"
				 	method="post" id="formsignup" role="form">
                  <div style="margin-top:20px">
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" id="month_number" name="month_number" value="<?php echo $month_number; ?>">
                        <h4>Metric: <?php if (isset($all_kuantitatif['kuantitatif']->metric)){ echo $all_kuantitatif['kuantitatif']->metric ; }?></h4>
                        <h4>Measurment: <?php if (isset($all_kuantitatif['kuantitatif']->measurment)){ echo $all_kuantitatif['kuantitatif']->measurment ; }?></h4>
                        <h4>Oleh: <?php echo $user['name'] ?></h4>
                  </div>
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
                              <input type="text" class="form-control" value="<?php if(isset($all_kuantitatif['kuantitatif']->$val2)){echo number_format($all_kuantitatif['kuantitatif']->$val2,0,",",".");} ?>" readonly />
                            </td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td>
                            Actual
                          </td>
                          <?php for ($i=0; $i <= $month_number-1 ; $i++) { ?>
                          <td>
                            <input type="number" class="form-control" id="<?= $arr_month[$i]; ?>" name="<?= $arr_month[$i]; ?>" value="<?php if(isset($all_kuantitatif['update']->$arr_month[$i])){echo $all_kuantitatif['update']->$arr_month[$i];} ?>" />
                          </td>
                          <?php } ?>
                        </tr>
                    </table>
                  </div>
                  </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                  </div>
					</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
