<table style="margin-left: 50px;width: 90%; margin-top: 50px;">
<?php
  foreach($initiative3 as $init){
?>
  <tr>
    <td style="width:5%"><?php echo $init->init_code?></td>
    <td style="width: 95%"><a href="#openModal<?php echo $init->id?>"><?php echo $init->title?></a></td>
  </tr>
<?php }?>

                   
</table>

<?php
  foreach($initiative3 as $init){
?>
<div id="openModal<?php echo $init->id?>" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <h4 style="float: left; color: orange;">Initiative <?php echo $init->init_code?></h4><br>
    <h4 style="float: left;"><?php echo $init->title?></h4><br>
    <p style="float: left;"><?php echo $init->deskripsi?></p><br><br>
    <div class="col-sm-12" style="margin-bottom: 20px;">
      <div class="col-sm-6">
        <table>
          <tr>
            <td>Direktur Sponsor&nbsp;&nbsp;</td>
            <td>: <?php echo $controller->get_CoPMO_name($init->init_code, 4);?></td>
          </tr>
            <tr>
            <td>PMO Head&nbsp;&nbsp;</td>
            <td>: <?php echo $controller->get_CoPMO_name($init->init_code, 3);?></td>
          </tr>
            <tr>
            <td>Co PMO Head&nbsp;&nbsp;</td>
            <td>: <?php echo $controller->get_CoPMO_name($init->init_code, 1);?></td>
          </tr>
        </table><br>
      </div>
      <div class="col-sm-6">
        <h5>Action</h5><br>
        
        <h3><?php echo $controller->get_count_action($init->id);?></h3>
     
      <div style="vertical-align: middle;">
        
      </div>
      <div style="vertical-align: middle;">
        
      </div>
   
      </div>

    </div>
    <div class="col-sm-6" style="margin-bottom: 20px;">
      <h5><strong>Realisasi per Juni 2017 (MTD)</strong></h5><br>
      <table>
        <tr>
          <td>Milestone&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_count_action_complete($init->id)*100)/($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id)),2,",","."); ?>%</td>
        </tr>
          <tr>
          <td>Leading&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_tot_pertipe($init->id, 'Leading')['month']*100)/$controller->get_count_leading($init->id, 'Leading'),2,",","."); ?>%</td>

        </tr>
          <tr>
          <td>Lagging&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_tot_pertipe($init->id, 'Lagging')['month']*100)/$controller->get_count_leading($init->id, 'Lagging'),2,",","."); ?>%</td>
        </tr>
        <tr>
          <td>Final Score&nbsp;&nbsp;:</td>
          <td><h2>&nbsp;<?= number_format(($controller->get_tot_pertipe($init->id, 'Lagging')['month']*100)/$controller->get_count_leading($init->id, 'Lagging'),2,",","."); ?>%</h2></td>
          <td><div id="circle" style="background: red;"></div></td>
        </tr>
      </table><br>
    </div>
    <div class="col-sm-6" style="margin-bottom: 20px;">
      <h5><strong>Realisasi per Juni 2017 (YTD)</strong></h5><br>
      <table>
        <tr>
          <td>Milestone&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_count_action_complete($init->id)*100)/$controller->get_count_action($init->id),2,",","."); ?>%</td>
        </tr>
        <tr>
          <td>Leading&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_tot_pertipe($init->id, 'Leading')['year']*100)/$controller->get_count_leading($init->id, 'Leading'),2,",","."); ?>%</td>
        </tr>
        <tr>
          <td>Lagging&nbsp;&nbsp;</td>
          <td>: <?= number_format(($controller->get_tot_pertipe($init->id, 'Lagging')['year']*100)/$controller->get_count_leading($init->id, 'Lagging'),2,",","."); ?>%</td>
        </tr>
        <tr>
          <td>Final Score&nbsp;&nbsp;:</td>
          <td><h2>&nbsp;<?= number_format(($controller->get_tot_pertipe($init->id, 'Lagging')['year']*100)/$controller->get_count_leading($init->id, 'Lagging'),2,",","."); ?>%</h2></td>
          <td><div id="circle" style="background: red;"></div></td>
        </tr>
      </table><br>
    </div>                          
  </div>
</div>
<?php }?> 