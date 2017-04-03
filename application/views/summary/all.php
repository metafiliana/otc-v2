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
    var typesInitiative = [
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

    var typesDeliverable = [
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

    var typesWorkstream = [
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

    var typesAction = [
    <?php foreach ($chart_data_action as $key => $value) { ?>
      <?php //echo $value['percent'];exit(); ?>
            <?php if ($value['status'] == 'In Progress') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif ($value['status'] == 'Not Started Yet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif ($value['status'] == 'Completed') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif ($value['status'] == 'Delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php } ?>
            percent: "<?php echo $value['percent']; ?>",
            },
    <?php } ?>
    ];

function generateChartDataInitiative() {
  var chartData = [];
  for (var i = 0; i < typesInitiative.length; i++) {
    if (i == selected) {
      for (var x = 0; x < typesInitiative[i].subs.length; x++) {
        chartData.push({
          type: typesInitiative[i].subs[x].type,
          percent: typesInitiative[i].subs[x].percent,
          color: typesInitiative[i].color,
          pulled: true
        });
      }
    } else {
      chartData.push({
        type: typesInitiative[i].type,
        percent: typesInitiative[i].percent,
        color: typesInitiative[i].color,
        id: i
      });
    }
  }
  return chartData;
}

function generateChartDataAction() {
  var chartDataAction = [];
  for (var i = 0; i < typesAction.length; i++) {
    if (i == selected) {
      for (var x = 0; x < typesAction[i].subs.length; x++) {
        chartDataAction.push({
          type: typesAction[i].subs[x].type,
          percent: typesAction[i].subs[x].percent,
          color: typesAction[i].color,
          pulled: true
        });
      }
    } else {
      chartDataAction.push({
        type: typesAction[i].type,
        percent: typesAction[i].percent,
        color: typesAction[i].color,
        id: i
      });
    }
  }
  return chartDataAction;
}

AmCharts.makeChart("chart_initiative", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        // "marginRight":1000000,
        "autoMargins":true
      },

  "dataProvider": generateChartDataInitiative(),
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
      chart.dataProvider = generateChartDataInitiative();
      chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

AmCharts.makeChart("chart_action", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        // "marginRight":1000000,
        "autoMargins":true
      },

  "dataProvider": generateChartDataAction(),
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
    "text": "Action Chart",
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
      chart.dataProvider = generateChartDataAction();
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