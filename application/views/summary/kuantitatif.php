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
</style>
<div class="panel-body">
      <div class="component_part_summary" style="margin-top:10px;">
        <!-- search area -->
        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-info-new btn-sm" disabled="disabled">Kuantitatif</button>
                <a href="<?php echo base_url()?>summary/listMilestone/"><button class="btn btn-default btn-sm btn-info-new">Milestone</button></a>
            </div>
            <div class="col-md-8">
              <?php echo form_open('summary/listKuantitatif', 'id="formSearch"'); ?>
              <div class="col-sm-6 form-group row">
                  <div class="col-sm">
                    <label class="control-label col-sm-1">User</label>
                    <div class="col-sm-3">
                      <?php
                          echo form_dropdown('user', getListUser(true), array(), 'class = "form-control"');
                      ?>
                    </div>
                  </div>
                  <div class="col-sm">
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
            <div class="col-md-2">
              <div class="right_text">
                  <h3 style="color:#91aef9;">Summary Kuantitatif</h3>
              </div>
                <!-- <button type="button" class="btn btn-danger">Print</button> -->
            </div>
        </div>
      </div><div style="clear:both;"></div>
      <div class="component_part">
          <div class="row">
          <!-- data area -->
          <?php if (!empty($init_table)){ ?>
          <div class="col-md-12 table-content">
              <table id="example" class="display nowrap">
                  <thead>
                      <tr>
                          <th><?php echo getUserRole($table_title); ?></th>
                          <th>Milestone Bulan</th>
                          <th>Leading (MTD)</th>
                          <th>Lagging (MTD)</th>
                          <th>Final Monthly</th>
                          <th></th>
                          <th>Milestone</th>
                          <th>Leading (YTD)</th>
                          <th>Lagging (YTD)</th>
                          <th>Final Year End</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td colspan="11" class=""><strong>Final score menggunakan indikator lagging</strong></td>
                          <td style="display: none;"></td>
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
                            $i = 1;
                            $total_monthly = 0;
                            $total_yearly = 0;
                            $total_milestone_monthly = 0;
                            $total_milestone_yearly = 0;
                            foreach ($init_table['type_1'] as $key => $value) {
                                $final_monthly_score = $controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user);
                                $final_yearly_score = $controller->getLeadingLagging($value->init_code, 'Lagging', 2);

                                $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                                $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                                $total_monthly = $total_monthly + (int)$final_monthly_score;
                                $total_yearly = $total_yearly + (int)$final_yearly_score;

                                $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                                $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                                echo "<tr>";
                                    echo "<td>".$value->init_code." ".$value->title."</td>";
                                    echo "<td>".$milestone_monthly." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user)." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user)." %</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$final_monthly_score." %</td>";
                                    echo "<td>";
                                    echo indikatorWarna($final_monthly_score);
                                    echo "</td>";
                                    echo "<td>".$milestone_yearly." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2)." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2)." %</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$final_yearly_score." %</td>";
                                    echo "<td>";
                                    echo indikatorWarna($final_yearly_score);
                                    echo "</td>";
                                echo "</tr>";

                                $i++;
                            }
                      ?>

                      <tr>
                          <td colspan="11" class=""><strong>Final score menggunakan indikator leading</strong></td>
                          <td style="display: none;"></td>
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
                              $final_monthly_score = $controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user);
                              $final_yearly_score = $controller->getLeadingLagging($value->init_code, 'Leading', 2, false, $user);

                              $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                              $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                              $total_monthly = $total_monthly + (int)$final_monthly_score;
                              $total_yearly = $total_yearly + (int)$final_yearly_score;

                              $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                              $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                              echo "<tr>";
                                  echo "<td>".$value->init_code." ".$value->title."</td>";
                                  echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                  echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user)." %</td>";
                                  echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user)." %</td>";
                                  echo "<td class = 'leading-month-".$key."'>".$final_monthly_score." %</td>";
                                  echo "<td>";
                                  echo indikatorWarna($final_monthly_score);
                                  echo "</td>";
                                  echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                  echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2, false, $user)." %</td>";
                                  echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2, false, $user)." %</td>";
                                  echo "<td class = 'leading-year-".$key."'>".$final_yearly_score." %</td>";
                                  echo "<td>";
                                  echo indikatorWarna($final_yearly_score);
                                  echo "</td>";
                              echo "</tr>";

                              $i++;
                          }
                      ?>

                      <tr>
                          <td colspan="11" class=""><strong>Final score menggunakan indikator milestones</strong></td>
                          <td style="display: none;"></td>
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
                              $final_yearly_score = $controller->countKuantitatif($value->id, 1);

                              $milestone_monthly = $controller->countKuantitatif($value->id, 1);
                              $milestone_yearly = $controller->countKuantitatif($value->id, 2);

                              $total_monthly = $total_monthly + (int)$final_monthly_score;
                              $total_yearly = $total_yearly + (int)$final_yearly_score;
                              $total_milestone_monthly = $total_milestone_monthly + (int)$milestone_monthly;
                              $total_milestone_yearly = $total_milestone_yearly + (int)$milestone_yearly;

                              echo "<tr>";
                                  echo "<td>".$value->init_code." ".$value->title."</td>";
                                  echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                  echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search, $user)."</td>";
                                  echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search, $user)."</td>";
                                  echo "<td>".$final_monthly_score." %</td>";
                                  echo "<td>";
                                  echo indikatorWarna($final_monthly_score);
                                  echo "</td>";
                                  echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                  echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2, false, $user)."</td>";
                                  echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2, false, $user)."</td>";
                                  echo "<td>".$final_yearly_score." %</td>";
                                  echo "<td>";
                                  echo indikatorWarna($final_yearly_score);
                                  echo "</td>";
                              echo "</tr>";

                              $i++;
                          }

                          $total_milestone_monthly = number_format($total_milestone_monthly / $i);
                          $total_monthly = number_format($total_monthly / $i);
                          $total_milestone_yearly = number_format($total_milestone_yearly / $i);
                          $total_yearly = number_format($total_yearly / $i);
                          echo '<tr>';
                              echo '<td class=""><strong>Overall ' . date('F Y') . ' (Actual vs Target)</strong></td>';
                              echo '<td>' . $total_milestone_monthly . ' %</td>';
                              echo '<td></td>';
                              echo '<td></td>';
                              echo '<td>' . $total_monthly . ' %</td>';
                              echo '<td>' . indikatorWarna($total_monthly) . '</td>';
                              echo '<td>' . $total_milestone_yearly . ' %</td>';
                              echo '<td></td>';
                              echo '<td></td>';
                              echo '<td>' . $total_yearly . ' %</td>';
                              echo '<td>' . indikatorWarna($total_yearly) . '</td>';
                          echo '</tr>';
                      ?>
                  </tbody>
              </table>
          </div>
          <?php } ?>
          <h3 class="text-center">Data Kosong</h3>
        </div>
      </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            paging: false,
            searching: false,
            scrollX: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: {
                buttons: [{
                  extend: 'pdfHtml5',
                  title: 'export-kuantitatif',
                  orientation: 'landscape',
                  exportOptions: {
                    columns: ':not(.no-print)'
                  },
                  footer: true
                }],
                dom: {
                  container: {
                    className: ''
                  },
                  button: {
                    className: 'btn btn-info-new btn-sm'
                  }
                }
              }
            // buttons: {
            //     buttons: [{
            //       extend: 'pdf',
            //       text: '<i class="fa fa-file-pdf-o"></i> Print',
            //       title: 'export-kuantitatif',
            //       orientation: 'landscape',
            //       exportOptions: {
            //         columns: ':not(.no-print)'
            //       },
            //       footer: true
            //     }],
            //     dom: {
            //       container: {
            //         className: 'dt-buttons'
            //       },
            //       button: {
            //         className: 'btn btn-default'
            //       }
            //     }
            //   }
            // "ajax": '../ajax/data/arrays.txt'
        } );

        // $('#formSearch').submit(function(e){
        //     e.preventDefault();
        //     var url = $(this).attr("action"); // the script where you handle the form input.

        //     $.ajax({
        //            type: "POST",
        //            url: url,
        //            data: $("#formSearch").serialize(), // serializes the form's elements.
        //            success: function(data)
        //            {
        //                 if (data.message == 'success') {
        //                     alert(data.data); // show response from the php script.
        //                 }
        //            }
        //         });
        // });
    } );
</script>
