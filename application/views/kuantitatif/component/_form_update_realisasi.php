<?php
$user = $this->session->userdata('user');
$arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
?>

<div id="popup_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 95%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="text-align: center;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="form-signin-heading"><?= $title ?></h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo base_url()."kuantitatif/submit_kuantitatif_realisasi"; ?>" method="post" id="formsignup" role="form">
                  <div style="margin-top:15px; padding-left: 30px; padding-right: 30px;">
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" id="month_number" name="month_number" value="<?php echo $month_number; ?>">
                        <table class="table table-hover" style="margin-left: 50px; margin-right: 50px;">
                          <tbody>
                            <tr>
                              <td style="border: none;"><h5>Metric</h5></td><td  style="border: none;"><h5><b><?php if (isset($all_kuantitatif['kuantitatif']->metric)){ echo $all_kuantitatif['kuantitatif']->metric ; }?></h5></td>
                            </tr>
                            <tr>
                              <td style="border: none;"><h5>Measurment</h5></td><td style="border: none;"><h5><b><?php if (isset($all_kuantitatif['kuantitatif']->measurment)){ echo $all_kuantitatif['kuantitatif']->measurment ; }?></h5></td>
                            </tr>
                            <tr>
                            <td style="border: none;">
                              <h5>Type</h5></td><td style="border: none;"><h5><b><?php if (isset($all_kuantitatif['kuantitatif']->measurment)){ echo $all_kuantitatif['kuantitatif']->type ; }?></h5>
                            </td>
                            </tr>
                            <tr>
                              <td style="border: none;"><h5>Oleh</h5></td><td style="border: none;"><h5><b><?php echo $user['name'] ?></h5></td>
                            </tr>

                          </tbody>
                        </table>
                  </div>
                  <div class="row" style="margin:20px 0 20px 0;">
                    <table class="table">
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td colspan="12" style="vertical-align: middle; text-align: center; height: 40px;"><h4>Target</h4></td>
                      </tr>
                        <tr style="width: 100%;">
                        <?php foreach ($arr_month as $val2) { ?>
                          <td style="vertical-align: middle; width: 8%;">
                              <label><?= $val2 ?></label>
                              <input type="text" class="form-control" value="<?php if(isset($all_kuantitatif['kuantitatif']->$val2)){echo number_format($all_kuantitatif['kuantitatif']->$val2,0,",",".");} ?>" readonly />
                          </td>
                        <?php } ?>
                        </tr>

                        <tr>
                        <td colspan="12" style="vertical-align: middle; text-align: center; height: 40px;"><h4>Actual</h4></td>
                      </tr>
                        <tr style="width: 100%;">
                          <?php for ($i=0; $i <= $month_number-1 ; $i++) { ?>
                          <td style="vertical-align: middle; width: 8%;">
                            <input type="number" class="form-control" id="<?= $arr_month[$i]; ?>" name="<?= $arr_month[$i]; ?>" value="<?php if(isset($all_kuantitatif['update']->$arr_month[$i])){echo number_format($all_kuantitatif['update']->$arr_month[$i],0,',','');} ?>" />
                          </td>
                        <?php } ?>

                        </tr>

                      </tbody>

                    </table>
                  </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
            </form>
          </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
