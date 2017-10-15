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
</style>
<div class="component_part">
    <div class="panel-body">
        <div class="col-md-12">
            <!-- search area -->
            <div class="col-md-2">
                <div class="affix col-md-2" style="padding-right: 30px;">
                    <div class="col-sm-6 form-group">
                        <button class="btn btn-info" disabled="disabled">Summary</button>
                    </div>
                    <div class="col-sm-6 form-group">
                        <a href="<?php echo base_url()?>summary/listMilestone/"><button class="btn btn-default">Milestone</button></a>
                    </div>
                    <?php echo form_open('summary/listKuantitatif', 'id="formSearch"'); ?>
                    <div class="col-sm-12 form-group">
                        <label>User</label>
                        <?php
                            echo form_dropdown('user', array(1 => 'CO-PMO', 3 => 'PMO'), array(), 'class = "form-control"');
                        ?>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Tanggal Tarik Data</label>
                        <?php
                            echo form_dropdown('bulan', getMonth(true), date('F'), 'class = "form-control"');
                        ?>
                    </div>
                    <div class="col-sm-6 form-group">
                        <?php
                            echo form_submit('', 'Cari', 'class = "form-control btn btn-success"');
                        ?>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="col-sm-6 form-group">
                        <button type="button" class="btn btn-danger">Print</button>
                    </div>
                </div>
            </div>
            <!-- data area -->
            <div class="col-md-10 table-content">
                <table id="example" class="display nowrap">
                    <thead>
                        <tr>
                            <th>Initiative Title</th>
                            <th>Milestone Bulan Berjalan</th>
                            <th>Leading (MTD)</th>
                            <th>Lagging (MTD)</th>
                            <th>Final Monthly Score</th>
                            <th></th>
                            <th>Milestone</th>
                            <th>Leading (YTD)</th>
                            <th>Lagging (YTD)</th>
                            <th>Final Year End Score</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="11" class="text-center"><strong>Final score menggunakan indikator lagging</strong></td>
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
                            $i = '-';
                            foreach ($init_table['type_1'] as $key => $value) {
                                echo "<tr>";
                                    echo "<td>".$value->title."</td>";
                                    echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search)."</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search)."</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search)."</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
                                    // }
                                    echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2)."</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2)."</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2)."</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
                                    // }
                                echo "</tr>";
                            }
                        ?>

                        <tr>
                            <td colspan="11" class="text-center"><strong>Final score menggunakan indikator leading</strong></td>
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
                            $i = '-';
                            foreach ($init_table['type_2'] as $key => $value) {
                                echo "<tr>";
                                    echo "<td>".$value->title."</td>";
                                    echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search)."</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search)."</td>";
                                    echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search)."</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
                                    // }
                                    echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2)."</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2)."</td>";
                                    echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2)."</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
                                    // }
                                echo "</tr>";
                            }
                        ?>

                        <tr>
                            <td colspan="11" class="text-center"><strong>Final score menggunakan indikator milestones</strong></td>
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
                            $i = '-';
                            foreach ($init_table['type_3'] as $key => $value) {
                                echo "<tr>";
                                    echo "<td>".$value->title."</td>";
                                    echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>"; // mtd milestone
                                    echo "<td class = 'leading-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 1, $bulan_search)."</td>";
                                    echo "<td class = 'lagging-month-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 1, $bulan_search)."</td>";
                                    echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
                                    // }
                                    echo "<td>".$controller->countKuantitatif($value->id, 2)." %</td>"; // ytd milestone
                                    echo "<td class = 'leading-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Leading', 2)."</td>";
                                    echo "<td class = 'lagging-year-".$key."'>".$controller->getLeadingLagging($value->init_code, 'Lagging', 2)."</td>";
                                    echo "<td>".$controller->countKuantitatif($value->id, 1)." %</td>";
                                    // if () {
                                    echo "<td><i class='bullet-green'>&#8226</i></td>";
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

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            paging: false,
            searching: false,
            scrollX: true,
            ordering: false,
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
