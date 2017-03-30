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
</style>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

<div class="component_part">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Summary</h3>
            <!-- <h4> 30% (6 Initiative) Done dari Total 20 intiative Terdapat 3 initiative delay, dan 2 initiative at Risk.</h4> -->
        </div>
        <!-- <div class="col-md-12">
            <div class="col-md-3">
                <?php //echo $info?>
            </div>
            <div class="col-md-9">
                <table id='initiative-table' class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="headertab">
                            <th>Initiative</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody id='initiative-table-body'>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
        <div class="col-md-12">
            <div id="chart_initiative" class="col-md-3 chart-4"></div>
            <div id="chart_workstream" class="col-md-3 chart-4"></div>
            <div id="chart_deliverable" class="col-md-3 chart-4"></div>
            <div id="chart_action" class="col-md-3 chart-4"></div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 id="filter-value-title" class="panel-title">Charts Detail : <span id="keterangan-detail"></span></h4>
                </div>
                <div class="panel-body">
                    <table id="chart-detail" class="table text-center">
                        <thead>
                            <th>Initiative</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </thead>
                        <tbody id="chart-detail-body">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<div id="delayId" style="display: none;"></div>
<script>
$("document").ready(function() {
    // $("#status").text("In Progress");
    setTimeout(function() {
        $('#delayId').trigger('click');
    },10);
});
var chart;
var legend;
var selected;
    var types = [
    <?php foreach ($wb_status as $key => $value) { ?>
            <?php if ($key == 'inprog') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif ($key == 'notyet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif ($key == 'complete') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif ($key == 'delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php } ?>
            percent: "<?php echo number_format(($value * $persen_initiative), 2, '.', ''); ?>",
            },
    <?php } ?>
    ];

function generateChartData() {
  var chartData = [];
  for (var i = 0; i < types.length; i++) {
    if (i == selected) {
      for (var x = 0; x < types[i].subs.length; x++) {
        chartData.push({
          type: types[i].subs[x].type,
          percent: types[i].subs[x].percent,
          color: types[i].color,
          pulled: true
        });
      }
    } else {
      chartData.push({
        type: types[i].type,
        percent: types[i].percent,
        color: types[i].color,
        id: i
      });
    }
  }
  return chartData;
}

AmCharts.makeChart("chart_initiative", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        // "marginRight":1000000,
        "autoMargins":true
      },

  "dataProvider": generateChartData(),
  "labelText": "",
  "balloonText": "[[title]]: [[value]]%",
  "titleField": "type",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "outlineAlpha": 0.8,
  "outlineThickness": 2,
  "colorField": "color",
  "pulledField": "pulled",
  "titles": [{
    "text": "Initiative Chart",
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(event) {
      var chart = event.chart;
      if (event.dataItem.dataContext.id != undefined) {
        selected = event.dataItem.dataContext.id;
      } else {
        selected = undefined;
      }
      chart.dataProvider = generateChartData();
      chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

$(document).on('click', '#delayId', function () {
    // $("#initiative-table-body").empty();
    $("#chart-detail-body").empty();
    $("#keterangan-detail").empty();
    $("#keterangan-detail").html('<font color="red">Delay</font>');
    // $("#status").text("Delay");
    <?php foreach ($summary_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_delay[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_delay[$key]['end']) ?>;
        // $('#initiative-info').text($text_info);
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        // $(newRowContent).appendTo($("#initiative-table-body"));
        $(newRowContent).appendTo($("#chart-detail-body"));
    <?php endforeach ?>
});
</script>