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
            <a href="<?php echo base_url()?>summary/listKuantitatif/"><button class="btn btn-info-new btn-sm btn-default">Summary</button></a>
            <button class="btn btn-sm btn-info-new" disabled="disabled">Milestone</button>
        </div>
        <div class="col-md-8">
          <?php echo form_open('summary/listMilestone', 'id="formSearch"'); ?>
          <div class="col-sm-6 form-group row">
              <div class="col-sm">
                <label class="control-label col-sm-1">User</label>
                <div class="col-sm-3">
                  <?php
                      echo form_dropdown('user', array(0 => '- All -', 1 => 'CO-PMO', 3 => 'PMO'), array(), 'class = "form-control"');
                  ?>
                </div>
              </div>
              <div class="col-sm">
                <label class="control-label col-sm-1">Month</label>
                <div class="col-sm-3" style="margin-left:12px;">
                  <?php
                      echo form_dropdown('bulan', getMonth(), !empty($bulan_search) ? $bulan_search : date('m'), 'class = "form-control"');
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
              <h3 style="color:#91aef9;">Summary Milestone</h3>
          </div>
            <!-- <button type="button" class="btn btn-danger">Print</button> -->
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
                        <th>Initiative Title</th>
                        <th>Complete</th>
                        <th>Future Start</th>
                        <th>On-Track</th>
                        <th>Issues</th>
                        <th>Not Started</th>
                        <th>Overdue</th>
                        <th>Flagged</th>
                        <th>Total Action</th>
                        <th>Completion Rate (MTD)</th>
                        <th>Completion Rate (YTD)</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        $i = '-';
                        foreach ($init_table as $key => $value) {
                            $completed = $controller->getStatus($value->id, 1, false, false, $bulan_search, $user);
                            $overdue = $controller->getStatus($value->id, false, false, false, $bulan_search, $user, true);
                            $flagged = $controller->getStatus($value->id, 3, false, true, $bulan_search, $user);
                            $total = $controller->getStatus($value->id, false, false, false, $bulan_search, $user);
                            $mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                            $ytd = $controller->getYtdMilestone($value->id, $user);
                            echo "<tr>";
                                echo "<td>".$value->init_code." ".$value->title."</td>";
                                echo "<td>".$completed."</td>"; // completed
                                echo "<td>".$controller->getStatus($value->id, 0, true, false, $bulan_search, $user)."</td>"; // future start
                                echo "<td>".$controller->getStatus($value->id, 2, false, false, $bulan_search, $user)."</td>"; // on track
                                echo "<td>".$controller->getStatus($value->id, 3, false, false, $bulan_search, $user)."</td>"; // issues
                                echo "<td>".$controller->getStatus($value->id, 0, false, false, $bulan_search, $user)."</td>"; // not started
                                echo "<td>".$overdue."</td>"; // flagged
                                echo "<td>".$flagged."</td>"; // flagged
                                echo "<td>".$total."</td>"; //total
                                echo "<td>".number_format($mtd)." %</td>"; // MTD
                                echo "<td>".number_format($ytd)." %</td>"; // YTD
                                // if () {
                                // echo "<td><i class='bullet-green'>&#8226</i></td>";
                                // }
                            echo "</tr>";
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
            searching: false,
            scrollX: true,
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
