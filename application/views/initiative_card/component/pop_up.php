<?php foreach ($detail as $init) {
?>
<div>
    <a href="#close" title="Close" class="close">X</a>
    <strong><h4 style="float: left; color: orange; padding: 10px;">Initiative <?php echo $init->init_code?></h4></strong><br><br>
    <h4 style="float: left; padding: 10px;"><?php echo $init->title?></h4><br>
    <p style="float: left; padding: 10px;"><?php echo $init->deskripsi?></p><br><br>
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
      <h5><strong>Realisasi per <?php echo $controller->get_bulan($init->id); ?> <?php echo date('Y')?> (YTD)</strong></h5><br>
      <table>
        <tr>
          <td>Milestone&nbsp;&nbsp;</td>
          <td>: <?php if ($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id)==0){
            echo 0;
          }
          else{
            echo number_format(($controller->get_count_action_complete($init->id)*100)/($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id)),2,",",".");
          }
          ?>%</td>
        </tr>
          <tr>
          <td>Leading&nbsp;&nbsp;</td>
          <td>: <?php if ($controller->get_count_leading($init->id, 'Leading')==0){
               echo 0;
            }
            else{
              echo (number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Leading')['month']*100)/$controller->get_count_leading($init->id, 'Leading'),'Leading'),2,",","."));
            }
              ?>%</td>

        </tr>
          <tr>
          <td>Lagging&nbsp;&nbsp;</td>
          <td>: <?php if($controller->get_count_leading($init->id, 'Lagging')==0){
            echo 0;
          }
          else{
            echo number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Lagging')['month']*100)/$controller->get_count_leading($init->id, 'Lagging'),'Lagging'),2,",",".");
          }
          ?>%</td>
        </tr>
        <tr>
          <td>Final Score&nbsp;&nbsp;:</td>
          <td><h2>&nbsp;
          <?php
          $p_lagging = $controller->get_count_leading($init->id, 'Lagging');
          $p_leading = $controller->get_count_leading($init->id, 'Leading');
          $p_milestone =($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id));
          //cek lagging
          if($p_lagging == 0){
            $lagging = 0;
          }
          else{
            $lagging = ($controller->get_tot_pertipe($init->id, 'Lagging')['month']*100)/($controller->get_count_leading($init->id, 'Lagging'));
          }
          //end cek lagging
          //cek leading
          if($p_leading == 0){
            $leading = 0;
          }
          else{
            $leading = ($controller->get_tot_pertipe($init->id, 'Leading')['month']*100)/$controller->get_count_leading($init->id, 'Leading');
          }
          //end cek leading
          //cek milestone
          if($p_milestone == 0){
            $milestone = 0;
          }
          else{
            $milestone = ($controller->get_count_action_complete($init->id)*100)/($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id));
          }
          //end cek milestone
          if ($lagging==0){
            if($leading==0){
              if($milestone==0){
                $final_m=0;
                echo $final_m;
              }
              else{
                $final_m = number_format(($controller->get_count_action_complete($init->id)*100)/($controller->get_count_action_complete($init->id)+$controller->get_count_action_overdue($init->id)),2,",",".");
                echo $final_m;
              }
            }
            else{
              $final_m = number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Leading')['month']*100)/$controller->get_count_leading($init->id, 'Leading'),'Leading'),2,",",".");
              echo $final_m;
            }
          }
          else{
            $final_m= number_format(maxscore((($controller->get_tot_pertipe($init->id, 'Lagging')['month']*100)/$controller->get_count_leading($init->id, 'Lagging')),'Lagging'),2,",",".");
            echo $final_m;
          }
          ?>%</h2></td>
          <td><div id="circle" style="background: <?php echo warna($final_m);?>; border: 3px solid <?php echo warnaborder($final_m);?>; "></div></td>
        </tr>
      </table><br>
    </div>
    <div class="col-sm-6" style="margin-bottom: 20px;">
      <h5><strong>Realisasi per <?php echo $controller->get_bulan($init->id); ?> <?php echo date('Y')?> (FY)</strong></h5><br>
      <table>
        <tr>
          <td>Milestone&nbsp;&nbsp;</td>
          <td>: <?php if($controller->get_count_action($init->id)==0){
            echo 0;
          }
          else{
            echo number_format(($controller->get_count_action_complete($init->id)*100)/$controller->get_count_action($init->id),2,",",".");
          }
          ?>%</td>
        </tr>
        <tr>
          <td>Leading&nbsp;&nbsp;</td>
          <td>: <?php if($controller->get_count_leading($init->id, 'Leading')==0){
            echo 0;
          }
          else{
            echo (number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Leading')['year']*100)/$controller->get_count_leading($init->id, 'Leading'),'Leading'),2,",","."));
          }
          ?>%</td>
        </tr>
        <tr>
          <td>Lagging&nbsp;&nbsp;</td>
          <td>: <?php if($controller->get_count_leading($init->id, 'Lagging')==0){
            echo 0;
          }
          else{
            echo (number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Lagging')['year']*100)/$controller->get_count_leading($init->id, 'Lagging'),'Lagging'),2,",","."));
          }
          ?>%</td>
        </tr>
        <tr>
          <td>Final Score&nbsp;&nbsp;:</td>
          <td><h2>&nbsp;
          <?php
          $p_lagging = $controller->get_count_leading($init->id, 'Lagging');
          $p_leading = $controller->get_count_leading($init->id, 'Leading');
          $p_milestone = $controller->get_count_action($init->id);
          //cek lagging
          if($p_lagging == 0){
            $lagging = 0;
          }
          else{
            $lagging = ($controller->get_tot_pertipe($init->id, 'Lagging')['year']*100)/($controller->get_count_leading($init->id, 'Lagging'));
          }
          //end cek lagging
          //cek leading
          if($p_leading == 0){
            $leading = 0;
          }
          else{
            $leading = ($controller->get_tot_pertipe($init->id, 'Leading')['year']*100)/$controller->get_count_leading($init->id, 'Leading');
          }
          //end cek leading
          //cek milestone
          if($p_milestone == 0){
            $milestone = 0;
          }
          else{
            $milestone = ($controller->get_count_action_complete($init->id)*100)/$controller->get_count_action($init->id);
          }
          //end cek milestone
          if ($lagging==0){
            if($leading==0){
              if($milestone==0){
                $final_y=0;
                echo $final_y;
              }
              else{
                $final_y = number_format(($controller->get_count_action_complete($init->id)*100)/$controller->get_count_action($init->id),2,",",".");
                echo $final_y;
              }
            }
            else{
              $final_y = number_format(maxscore(($controller->get_tot_pertipe($init->id, 'Leading')['year']*100)/$controller->get_count_leading($init->id, 'Leading'),'Leading'),2,",",".");
              echo $final_y;
            }
          }
          else{
            $final_y= number_format(maxscore((($controller->get_tot_pertipe($init->id, 'Lagging')['year']*100)/$controller->get_count_leading($init->id, 'Lagging')),'Lagging'),2,",",".");
            echo $final_y;
          }
          ?>%</h2></td>
          <td><div id="circle" style="background: <?php echo warna($final_y);?>; border: 3px solid <?php echo warnaborder($final_y);?>;"></div></td>
        </tr>
      </table><br>
    </div>                          
  </div>
<?php }?>