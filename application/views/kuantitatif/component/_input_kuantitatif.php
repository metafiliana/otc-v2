<div id="popup_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 80%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="text-align: center;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="form-signin-heading"><?= $title ?></h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"
          action="<?php echo base_url()."kuantitatif/submit_kuantitatif";?><?php if($kuan_id) echo '/'.$kuan_id;?>"
          method="post" id="formsignup" role="form" style="margin-top:10px;">
            <input type="hidden" value="<?php if($init_id){echo $init_id;}?>" name="init_id" id="init_id">
            <input type="hidden" value="<?php if($init_code){echo $init_code;}?>" name="init_code" id="init_code">
            <div class="form-group" style="margin-bottom:15px;">
              <label class="col-sm-2 control-label" style="margin-right: 10px;">Type</label>
              <div class="col-sm-9">
              <input type="radio" name="type" value="Leading" <?php if(isset($kuantitatif)){if($kuantitatif->type == "Leading"){echo "checked";}}?> style="margin-right: 10px; margin-top: 8px;"> Leading <span style="padding-left: 20px;"></span>
              <input type="radio" name="type" value="Lagging" <?php if(isset($kuantitatif)){if($kuantitatif->type == "Lagging"){echo "checked";}}?> style="margin-right: 10px;"> Lagging
              </div>
            </div>
            <div class="form-group" style="margin-bottom:15px;">
              <label class="col-sm-2 control-label">Metric</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" id="metric" name="metric" placeholder="Metric" value="<?php if (isset($kuantitatif->metric)){ echo $kuantitatif->metric; }?>">
              </div>
            </div>
            <div class="form-group" style="margin-bottom:15px;">
                <label class="col-sm-2 control-label">Measurment</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="measurment" name="measurment" placeholder="Measurment" value="<?php if (isset($kuantitatif->measurment)){ echo $kuantitatif->measurment; }?>">
                </div>
            </div>
            <div class="form-group" style="margin-bottom:30px;">
                <label class="col-sm-2 control-label">Target</label>
                <div class="col-sm-9">
                <input type="number" class="form-control" id="target" name="target" placeholder="Target" value="<?php if (isset($kuantitatif->target)){ echo number_format($kuantitatif->target,0,",",""); }?>">
                </div>
            </div>
            <div class="form-group" style="margin-bottom:30px;">
                <label class="col-sm-2 control-label">Baseline</label>
                <div class="col-sm-9">
                <input type="number" class="form-control" id="baseline" name="baseline" placeholder="Baseline" value="<?php if (isset($kuantitatif->baseline)){ echo number_format($kuantitatif->baseline,0,",",""); }?>">
                </div>
            </div>
                <table class="table">
                  <?php $arr_month=['January','February','March','April','May','June','July','August','September','October','November','December']; if(isset($kuantitatif)){ ?>
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                    <tbody>
                      <tr>
                        <td class="active" colspan="12" style="vertical-align: middle; text-align: center; height: 40px;"><h4>Target</h4></td>
                      </tr>
                      <tr style="width: 100%; padding-top: 20px;">
                        <?php foreach ($arr_month as $val2) { ?>
                          <td style="vertical-align: middle; width: 8%;">
                              <label><?= $val2 ?></label>
                              <input type="number" class="form-control" name="target_<?= $val2 ?>" value="<?php if(isset($kuantitatif->$val2)){echo number_format($kuantitatif->$val2,0,",","");} ?>"/>
                          </td>
                        <?php } ?>
                        </tr>

                    </tbody>

                </table>
            <?php } ?>
            <button class="btn btn-lg btn-primary btn-block" style="margin-top: 40px;" type="submit">Submit</button>
          </form>
          </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
