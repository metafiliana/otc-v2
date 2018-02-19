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
        <div class="col-md-3" style="margin-right:-50px;">
          <a href="<?php echo base_url() ?>summary/listKuantitatif/"><button class="btn btn-info-new btn-sm btn-default">Kuantitatif</button></a>
          <button class="btn btn-sm btn-info-new" disabled="disabled">Milestone</button>
          <!-- <a href="<?php //echo base_url()?>summary/home/"><button class="btn btn-default btn-sm btn-info-new">Home</button></a> -->
          <?php 
            if ($is_admin) {
                ?>
          <a href="<?php echo base_url() ?>summary/generateSummary/"><button class="btn btn-info-new btn-sm btn-default">Update Summary</button></a>
          <?php 
        }
        ?>
        </div>
        <div class="col-md-2" style="float: right">
            <div class="right_text">
                <h3 style="color:#91aef9;">Summary Milestone</h3>
            </div>
            <div>
            <h5 class="text-right">Last Updated: <?php echo $summary_info->date; ?></h5>
            </div>
            <!-- <button type="button" class="btn btn-danger">Print</button> -->
        </div><div style="clear:both;"></div>
    </div>
    <div class="row"><hr></div>
    <div class="row">
        <div class="col-md-12">
            <?php echo form_open('summary/listMilestone', 'id="formSearch"'); ?>
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
                    <div class="col-sm-3">
                        <?php
                            echo form_dropdown('bulan', getMonth(), $bulan_search ? convertMonth($bulan_search, true) : date('m'), 'class = "form-control"');
                            ?>
                    </div>
                </div>
                <div>
                <label class="control-label col-sm-1">Year</label>
                <div class="col-sm-3">
                    <?php
                    echo form_dropdown('tahun', getRangeTahun(3, 2), $year_search ? $year_search : date('Y'), 'class = "form-control"');
                    ?>
                </div>
                </div>
            </div>
            <div class="col-sm-2">
                <?php
                echo form_submit('', 'Find', 'class = "form-control btn btn-info-new-submit"');
                ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
  </div><div style="clear:both;"></div>
  <div class="component_part">
      <div class="row">
      <!-- data area -->
        <div class="col-md-12 table-content">
            <table id="example" class="display nowrap">
                <thead>
                    <tr>
                        <th style="display: none;">No.</th>
                        <th>No.</th>
                        <th><?php echo getUserRole($table_title); ?></th>
                        <th>Complete</th>
                        <th>Future Start</th>
                        <th>On-Track</th>
                        <th>Issues</th>
                        <th>Not Started</th>
                        <th>Overdue</th>
                        <th>Flagged</th>
                        <th>Total Action</th>
                        <th>Completion Rate (YTD)</th>
                        <th>Completion Rate (FY)</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        if ($user === null){
                            $i = 1;
                            foreach ($init_table as $key => $value) {
                                $completed = $controller->getStatus($value->id, 1, false, false, $bulan_search);
                                // $issues = $controller->getStatus($value->id, 3, false, false, $bulan_search);
                                $overdue = $controller->getStatus($value->id, 3, false, 2, $bulan_search);
                                $not_started = $controller->getStatus($value->id, 0, false, 1, $bulan_search);
                                $flagged = $controller->getStatus($value->id, 0, false, 3, $bulan_search);
                                $issues = $overdue + $not_started + $flagged;
                                $total = $controller->getStatus($value->id, false, false, false, $bulan_search);
                                // $mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                                $mtd = $controller->getMtdMilestone($overdue, $completed, $value->id, $bulan_search);
                                $ytd = $controller->getYtdMilestone($value->id);
                                echo "<tr>";
                                    echo "<td style='display: none;'>".$i."</td>";
                                    echo "<td>".$value->init_code."</td>";
                                    echo "<td class='text-left'>".$value->title."</td>";
                                    echo "<td>".$completed."</td>"; // completed
                                    echo "<td>".$controller->getStatus($value->id, 0, true, false, $bulan_search)."</td>"; // future start
                                    echo "<td>".$controller->getStatus($value->id, 2, false, false, $bulan_search)."</td>"; // on track
                                    echo "<td>".$issues."</td>"; // issues
                                    echo "<td>".$not_started."</td>"; // not started
                                    echo "<td>".$overdue."</td>"; // overdue
                                    // $flagged = $issues - ($overdue + $not_started);
                                    echo "<td>".$flagged."</td>"; // flagged
                                    echo "<td>".$total."</td>"; //total
                                    echo "<td>".number_format($mtd)." %</td>"; // MTD
                                    echo "<td>".number_format($ytd)." %</td>"; // YTD
                                echo "</tr>";

                                $i++;
                            }
                        }else{
                            $i = 1;
                            foreach ($init_table as $key => $value) {
                                $completed = $controller->getStatus($value->initiative, 1, false, false, $bulan_search, $value->id);
                                // $issues = $controller->getStatus($value->initiative, 3, false, false, $bulan_search, $value->id);
                                $overdue = $controller->getStatus($value->initiative, 3, false, 2, $bulan_search, $value->id);
                                $not_started = $controller->getStatus($value->initiative, 3, false, 1, $bulan_search, $value->id);
                                $flagged = $controller->getStatus($value->initiative, 0, false, 3, $bulan_search);
                                $issues = $overdue + $not_started + $flagged;
                                $total = $controller->getStatus($value->initiative, false, false, false, $bulan_search, $value->id);
                                // $mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                                $mtd = $controller->getMtdMilestone($overdue, $completed, $value->initiative, $bulan_search);
                                $ytd = $controller->getYtdMilestone($value->initiative, $value->id);
                                echo "<tr>";
                                    echo "<td style='display: none;'>".$i."</td>";
                                    echo "<td>".$value->init_code."</td>";
                                    echo "<td class='text-left'>".$value->name."</td>";
                                    echo "<td>".$completed."</td>"; // completed
                                    echo "<td>".$controller->getStatus($value->initiative, 0, false, false, $bulan_search, $value->id)."</td>"; // future start
                                    echo "<td>".$controller->getStatus($value->initiative, 2, false, false, $bulan_search, $value->id)."</td>"; // on track
                                    echo "<td>".$issues."</td>"; // issues
                                    // $not_started = $overdue > 0 ? 0 : $not_started;
                                    echo "<td>".$not_started."</td>"; // not started
                                    echo "<td>".$overdue."</td>"; // overdue
                                    // $flagged = $issues - ($overdue + $not_started) < 0 ? 0 : $issues - ($overdue + $not_started);
                                    echo "<td>".$flagged."</td>"; // flagged
                                    echo "<td>".$total."</td>"; //total
                                    echo "<td>".number_format($mtd)." %</td>"; // MTD
                                    echo "<td>".number_format($ytd)." %</td>"; // YTD
                                echo "</tr>";

                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            paging: false,
            ordering: true,
            searching: false,
            scrollX: true,
            "scrollY": "500px",
            "scrollCollapse": true,
            fixedHeader: true,
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
            //       title: 'export-milestone',
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
        //
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
