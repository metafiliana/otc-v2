<style>
    .pmo_header{
        margin-right:40px;
    }
    .pmo_header_active a{
        margin-right:40px;
        color: black;
    }
    .chart-4 {
      width: 25%;
      height: 300px;
    }
    .panel-default {
        margin: 25px;
    }
    .well {
        margin: 25px;
    }
    .bullet-red {
        color: red;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }
    .bullet-yellow {
        color: yellow;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }
    .bullet-green {
        color: green;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }

    .component_part_summary {
    background-color: white;
    border-radius: 10px;
    border: 1px solid #d3d3d3;
    padding: 10px 10px 0 10px;
    margin-bottom: 10px;
    overflow: auto;
    }

    .btn-danger{
      border-color:unset;
    }

    .buttons-pdf{
      float: left;
    }
</style>
<script type="text/javascript">
     //jstopdf
    function take(div) {
        $('#print-table').show();
        // First render all SVGs to canvases
        var svgElements= $("#"+div).find('svg');

        //replace all svgs with a temp canvas
        svgElements.each(function () {
         var canvas, xml;

         canvas = document.createElement("canvas");
         canvas.className = "screenShotTempCanvas";
         //convert SVG into a XML string
         xml = (new XMLSerializer()).serializeToString(this);

         // Removing the name space as IE throws an error
         xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');

         //draw the SVG onto a canvas
         canvg(canvas, xml);
         $(canvas).insertAfter(this);
         //hide the SVG element
         this.className = "tempHide";
         $(this).hide();
        });

        html2canvas($("#"+div), {
             allowTaint: true,
             onrendered: function (canvas) {
                 var myImage = canvas.toDataURL("image/pdf");
                 var tWindow = window.open("");
                 $(tWindow.document.body).html("<img id='Image' src=" + myImage + " style='width:100%;'></img>").ready(function () {
                     tWindow.focus();
                     tWindow.print();
                 });
             }
        });

        $('#print-table').hide();
      }
  setTimeout(function () {
       // jQuery('#orderFirst').trigger('click');
       $('#orderFirst').click();
       $('#orderFirst').click();
    }, 1000);
</script>
<div class="panel-body">
      <div class="component_part_summary" style="margin-top:10px;">
        <!-- search area -->
        <div class="row">
            <div class="col-md-3" style="margin-right:-50px;">
                <button class="btn btn-info-new btn-sm" disabled="disabled">Kuantitatif</button>
                <a href="<?php echo base_url()?>summary/listMilestone/"><button class="btn btn-default btn-sm btn-info-new">Milestone</button></a>
                <!-- <a href="<?php //echo base_url()?>summary/home/"><button class="btn btn-default btn-sm btn-info-new">Home</button></a> -->
                <?php 
                if ($is_admin){
                ?>
                <a href="<?php echo base_url()?>summary/generateSummary/"><button class="btn btn-info-new btn-sm btn-default">Update Summary</button></a>
                <?php 
                  }
                ?>
            </div>
            <div class="col-md-6">
              <?php echo form_open('summary/listKuantitatif', 'id="formSearch"'); ?>
              <div class="col-sm-10 form-group row">
                  <div>
                    <label class="control-label col-sm-1">User</label>
                    <div class="col-sm-3">
                      <?php
                          echo form_dropdown('user', getListUser(true), array(), 'class = "form-control"');
                      ?>
                    </div>
                  </div>
                  <div>
                    <label class="control-label col-sm-1">Month</label>
                    <div class="col-sm-3" style="margin-left:12px;">
                      <?php
                          echo form_dropdown('bulan', getMonth(true), $bulan_search ? $bulan_search : date('F'), 'class = "form-control"');
                      ?>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <?php
                        echo form_submit('', 'Find', 'class = "form-control btn btn-info-new-submit"');
                    ?>
                  </div>
              </div>
              <?php echo form_close(); ?>
            </div>
            <div class="col-md-3" style="margin-left:50px;">
              <div class="right_text">
                  <h3 style="color:#91aef9;">Summary Kuantitatif</h3>
              </div>
              <div>
                <h5 class="text-right">Last Updated: <?php echo $summary_info->date; ?></h5>
              </div>
                <!-- <button type="button" class="btn btn-danger">Print</button> -->
            </div><div style="clear:both;"></div>
        </div>
      </div><div style="clear:both;"></div>
      <div class="component_part_summary text-center">
          <button onclick="take('print-table')" class="btn btn-info-new btnPrintHide" style="float: left;">Print</button>
          <div class="row">
          <!-- data area -->
          <?php if (!empty($init_table)){ $nomor = 0; ?>
          <div class="col-md-12 table-content">
              <table class="display nowrap tableDatatables">
                  <thead>
                      <tr>
                          <th id="orderFirst" style="display: none;">No.</th>
                          <th>No.</th>
                          <th><?php echo getUserRole($table_title); ?></th>
                          <th>Milestone Bulan</th>
                          <th>Leading (YTD)</th>
                          <th>Lagging (YTD)</th>
                          <th>YTD</th>
                          <th>Milestone</th>
                          <th>Leading (FY)</th>
                          <th>Lagging (FY)</th>
                          <th>FY</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr class="sorting_disabled">
                          <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                          <th colspan="13" class="text-left"><strong>Final score menggunakan indikator lagging</strong></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                      </tr>
                      <?php
                            $i = 0;
                            $j = 1;
                            $total_monthly = 0;
                            $total_yearly = 0;
                            $total_milestone_monthly = 0;
                            $total_milestone_yearly = 0;
                            foreach ($init_table['type_1'] as $key => $value) {
                                // monthly
                                $final_monthly_score = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);
                                $final_monthly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                                $final_monthly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);

                                // yearly
                                $final_yearly_score = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);
                                $final_yearly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                                $final_yearly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);

                                $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                                $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                                $total_monthly = $total_monthly + (int)$final_monthly_score;
                                $total_yearly = $total_yearly + (int)$final_yearly_score;

                                $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                                $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                                echo "<tr>";
                                    echo "<td style='display: none;'>".$nomor."</td>";
                                    echo "<td class='text-left'>".$value->init_code."</td>";
                                    echo "<td class='text-left'>".$value->title."</td>";
                                    echo "<td>".$milestone_monthly." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$final_monthly_score_leading." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$final_monthly_score_lagging." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                    echo "<td>".$milestone_yearly." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$final_yearly_score_leading." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$final_yearly_score_lagging." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                                echo "</tr>";

                                $i++;
                                $nomor++;
                            }
                      ?>
                  </tbody>
                  <tfoot>
                    <tr class="sorting_disabled">
                        <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                        <td colspan="13" class="text-left"><strong>Final score menggunakan indikator leading</strong></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                    </tr>
                    <?php
                        foreach ($init_table['type_2'] as $key => $value) {
                            // monthly
                            $final_monthly_score = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                            $final_monthly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                            $final_monthly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);

                            // yearly
                            $final_yearly_score = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                            $final_yearly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                            $final_yearly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);

                            $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                            $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                            $total_monthly = $total_monthly + (int)$final_monthly_score;
                            $total_yearly = $total_yearly + (int)$final_yearly_score;

                            $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                            $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                            echo "<tr>";
                                echo "<td style='display: none;'>".$nomor."</td>";
                                echo "<td class='text-left'>".$value->init_code."</td>";
                                echo "<td class='text-left'>".$value->title."</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                echo "<td class = 'leading-month-".$key."'>".$final_monthly_score_leading." %</td>";
                                echo "<td class = 'lagging-month-".$key."'>".$final_monthly_score_lagging." %</td>";
                                echo "<td class = 'leading-month-".$key."'><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                echo "<td class = 'leading-year-".$key."'>".$final_yearly_score_leading." %</td>";
                                echo "<td class = 'lagging-year-".$key."'>".$final_yearly_score_lagging." %</td>";
                                echo "<td class = 'leading-year-".$key."'><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                            echo "</tr>";

                            $i++;
                            $nomor++;
                        }
                    ?>
                    <tr class="sorting_disabled">
                        <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                        <td colspan="13" class="text-left"><strong>Final score menggunakan indikator milestones</strong></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                    </tr>
                    <?php
                        foreach ($init_table['type_3'] as $key => $value) {
                            $final_monthly_score = $controller->countKuantitatif($value->id, 1);
                            $final_yearly_score = $controller->countKuantitatif($value->id, 2);

                            $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                            $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                            // $total_monthly = $total_monthly + (int)$final_monthly_score;
                            // $total_yearly = $total_yearly + (int)$final_yearly_score;
                            // $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                            // $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                            $total_milestone_monthly = $controller->getTotalMilestone($bulan_search, 1);
                            $total_milestone_yearly = $controller->getTotalMilestone($bulan_search, 2);
                            echo "<tr>";
                                echo "<td style='display: none;'>".$nomor."</td>";
                                echo "<td class='text-left'>".$value->init_code."</td>";
                                echo "<td class='text-left'>".$value->title."</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user)."</td>";
                                echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user)."</td>";
                                echo "<td><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2, false, $user)."</td>";
                                echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2, false, $user)."</td>";
                                echo "<td><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                            echo "</tr>";

                            $j++;
                            $nomor++;
                        }

                        // $total_milestone_monthly = round($total_milestone_monthly / ($i + $j));
                        $total_monthly = round($total_monthly / $i);

                        // $total_milestone_yearly = round($total_milestone_yearly / ($i + $j));
                        $total_yearly = round($total_yearly / $i);
                        echo '<tr>';
                          echo "<td style='display: none;'></td>";
                          echo "<td></td>";
                          echo '<td><strong>Overall ' . date('F Y', strtotime($bulan_search)) . ' (Actual vs Target)</strong></td>';
                          echo '<td>' . $total_milestone_monthly . ' %</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td><div class=circle style="background:'.warna($total_monthly).'"></div>' .$total_monthly. ' %</td>';
                          echo '<td>' . $total_milestone_yearly . ' %</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td><div class=circle style="background:'.warna($total_yearly).'"></div>' . $total_yearly . ' %</td>';
                        echo '</tr>';
                    ?>
                  </tfoot>
              </table>
          </div>
          <?php }else{ ?>
            <h3 class="text-center">Data Kosong</h3>
          <?php } ?>
        </div>
      </div><div style="clear:both;"></div>

      <div class="component_part_summary text-center" id="print-table" style="display: none;">
          <!-- <button onclick="take('print-table')" class="btn btn-info-new btnPrintHide" style="float: left;">Print</button> -->
          <div class="row">
          <!-- data area -->
          <?php if (!empty($init_table)){ $nomor = 0; ?>
          <div class="col-md-12 table-content">
              <table class="display nowrap tableDatatables1">
                  <thead>
                      <tr>
                          <th id="orderFirst" style="display: none;">No.</th>
                          <th>No.</th>
                          <th><?php echo getUserRole($table_title); ?></th>
                          <th>Milestone Bulan</th>
                          <th>Leading (YTD)</th>
                          <th>Lagging (YTD)</th>
                          <th>YTD</th>
                          <th>Milestone</th>
                          <th>Leading (FY)</th>
                          <th>Lagging (FY)</th>
                          <th>FY</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr class="sorting_disabled">
                          <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                          <th colspan="13" class="text-left"><strong>Final score menggunakan indikator lagging</strong></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                          <th style="display: none;"></th>
                      </tr>
                      <?php
                            $i = 0;
                            $j = 1;
                            $total_monthly = 0;
                            $total_yearly = 0;
                            $total_milestone_monthly = 0;
                            $total_milestone_yearly = 0;
                            foreach ($init_table['type_1'] as $key => $value) {
                                // monthly
                                $final_monthly_score = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);
                                $final_monthly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                                $final_monthly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);

                                // yearly
                                $final_yearly_score = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);
                                $final_yearly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                                $final_yearly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);

                                $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                                $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                                $total_monthly = $total_monthly + (int)$final_monthly_score;
                                $total_yearly = $total_yearly + (int)$final_yearly_score;

                                $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                                $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                                echo "<tr>";
                                    echo "<td style='display: none;'>".$nomor."</td>";
                                    echo "<td class='text-left'>".$value->init_code."</td>";
                                    echo "<td class='text-left'>".$value->title."</td>";
                                    echo "<td>".$milestone_monthly." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$final_monthly_score_leading." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$final_monthly_score_lagging." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                    echo "<td>".$milestone_yearly." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$final_yearly_score_leading." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$final_yearly_score_lagging." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                                echo "</tr>";

                                $i++;
                                $nomor++;
                            }
                      ?>
                  </tbody>
                  <tfoot>
                    <tr class="sorting_disabled">
                        <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                        <td colspan="13" class="text-left"><strong>Final score menggunakan indikator leading</strong></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                    </tr>
                    <?php
                        foreach ($init_table['type_2'] as $key => $value) {
                            // monthly
                            $final_monthly_score = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                            $final_monthly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 1, $bulan_search);
                            $final_monthly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 1, $bulan_search);

                            // yearly
                            $final_yearly_score = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                            $final_yearly_score_leading = $controller->getKuantitatifSummary($value->init_code, 'Leading', 2, $bulan_search);
                            $final_yearly_score_lagging = $controller->getKuantitatifSummary($value->init_code, 'Lagging', 2, $bulan_search);

                            $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                            $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                            $total_monthly = $total_monthly + (int)$final_monthly_score;
                            $total_yearly = $total_yearly + (int)$final_yearly_score;

                            $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                            $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                            echo "<tr>";
                                echo "<td style='display: none;'>".$nomor."</td>";
                                echo "<td class='text-left'>".$value->init_code."</td>";
                                echo "<td class='text-left'>".$value->title."</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                echo "<td class = 'leading-month-".$key."'>".$final_monthly_score_leading." %</td>";
                                echo "<td class = 'lagging-month-".$key."'>".$final_monthly_score_lagging." %</td>";
                                echo "<td class = 'leading-month-".$key."'><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                echo "<td class = 'leading-year-".$key."'>".$final_yearly_score_leading." %</td>";
                                echo "<td class = 'lagging-year-".$key."'>".$final_yearly_score_lagging." %</td>";
                                echo "<td class = 'leading-year-".$key."'><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                            echo "</tr>";

                            $i++;
                            $nomor++;
                        }
                    ?>
                    <tr class="sorting_disabled">
                        <th style="display: none;"><?php echo $nomor; $nomor++; ?></th>
                        <td colspan="13" class="text-left"><strong>Final score menggunakan indikator milestones</strong></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                    </tr>
                    <?php
                        foreach ($init_table['type_3'] as $key => $value) {
                            $final_monthly_score = $controller->countKuantitatif($value->id, 1);
                            $final_yearly_score = $controller->countKuantitatif($value->id, 2);

                            $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                            $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                            // $total_monthly = $total_monthly + (int)$final_monthly_score;
                            // $total_yearly = $total_yearly + (int)$final_yearly_score;
                            // $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                            // $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                            $total_milestone_monthly = $controller->getTotalMilestone($bulan_search, 1);
                            $total_milestone_yearly = $controller->getTotalMilestone($bulan_search, 2);
                            echo "<tr>";
                                echo "<td style='display: none;'>".$nomor."</td>";
                                echo "<td class='text-left'>".$value->init_code."</td>";
                                echo "<td class='text-left'>".$value->title."</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user)."</td>";
                                echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user)."</td>";
                                echo "<td><div class=circle style='background:".warna($final_monthly_score)."'></div>".$final_monthly_score." %</td>";
                                echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2, false, $user)."</td>";
                                echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2, false, $user)."</td>";
                                echo "<td><div class=circle style='background:".warna($final_yearly_score)."'></div>".$final_yearly_score." %</td>";
                            echo "</tr>";

                            $j++;
                            $nomor++;
                        }

                        // $total_milestone_monthly = round($total_milestone_monthly / ($i + $j));
                        $total_monthly = round($total_monthly / $i);

                        // $total_milestone_yearly = round($total_milestone_yearly / ($i + $j));
                        $total_yearly = round($total_yearly / $i);
                        echo '<tr>';
                          echo "<td style='display: none;'></td>";
                          echo "<td></td>";
                          echo '<td><strong>Overall ' . date('F Y', strtotime($bulan_search)) . ' (Actual vs Target)</strong></td>';
                          echo '<td>' . $total_milestone_monthly . ' %</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td><div class=circle style="background:'.warna($total_monthly).'"></div>' .$total_monthly. ' %</td>';
                          echo '<td>' . $total_milestone_yearly . ' %</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td><div class=circle style="background:'.warna($total_yearly).'"></div>' . $total_yearly . ' %</td>';
                        echo '</tr>';
                    ?>
                  </tfoot>
              </table>
          </div>
          <?php }else{ ?>
            <h3 class="text-center">Data Kosong</h3>
          <?php } ?>
        </div>
      </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.tableDatatables').DataTable( {
            paging: false,
            ordering: true,
            searching: false,
            scrollX: true,
            "scrollY": "500px",
            "scrollCollapse": true,
            fixedHeader: true,
            // dom: 'Bfrtip',
            // buttons: {
            //     buttons: [{
            //       extend: 'pdfHtml5',
            //       title: 'export-kuantitatif',
            //       orientation: 'landscape',
            //       exportOptions: {
            //         columns: ':not(.no-print)'
            //       },
            //       footer: true
            //     }],
            //     dom: {
            //       container: {
            //         className: ''
            //       },
            //       button: {
            //         className: 'btn btn-info-new btn-sm'
            //       }
            //     }
            //   }
        } );

        $('.tableDatatables1').DataTable( {
            paging: false,
            ordering: false,
            searching: false,
            scrollX: false
        } );

    } );
</script>
