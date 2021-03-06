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
</style>
<div class="component_part" id="list_of_program" style="display: none;"><?php echo $list_program?></div>

<div class="component_part">
    <div class="row well">
          <a href="<?php echo base_url()?>summary/initSummary"><button class="btn btn-warning">Generate Summary</button></a>
          <a onclick="take('chart')" class="btn btn-info-new "><span class="glyphicon glyphicon-print"></span> Print Kuantitatif</a>
          <div class="clearfix" style="float: right;">
          <button class="btn btn-info" disabled="disabled">Summary All</button>
          <a href="<?php echo base_url()?>summary/program_list/"><button class="btn btn-default">Summary Detail</button></a>
          </div>
    </div>
    <div class="row" id='chart'>
        <div class="col-md-12 text-center">
            <h3>Summary</h3>
        </div>
        <div class="col-md-12">
            <div id="chart_initiative" class="col-md-3 chart-4"></div>
            <div id="chart_workstream" class="col-md-3 chart-4"></div>
            <div id="chart_deliverable" class="col-md-3 chart-4"></div>
            <div id="chart_action" class="col-md-3 chart-4"></div>
        </div>
        <div id="event"></div>

        <div id="keterangan-detail-chart" class="text-center"></div>
        <div class="col-md-12" id="content-detail">
          <div class="panel-group" id="accordion">
            <div class="panel panel-default p-delay">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseDelay">
                    Delay
                  </a>
                </h4>
              </div>
              <div id="collapseDelay" class="panel-collapse collapse in">
                <div class="panel-body">
                    <table id="chart-detail-delay" class="table">
                        <thead>
                            <th>No</th>
                            <th>Code</th>
                            <th>Sub Init</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Sisa</th>
                        </thead>
                        <tbody id="chart-detail-body-delay">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default p-nys">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseNYS">
                    Not Yet Started
                  </a>
                </h4>
              </div>
              <div id="collapseNYS" class="panel-collapse collapse in">
                <div class="panel-body">
                  <table id="chart-detail-nys" class="table">
                        <thead>
                            <th>No</th>
                            <th>Code</th>
                            <th>Sub Init</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Sisa</th>
                        </thead>
                        <tbody id="chart-detail-body-nys">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          <div class="panel panel-default p-ip">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseIP">
                    In Progress
                  </a>
                </h4>
              </div>
              <div id="collapseIP" class="panel-collapse collapse in">
                <div class="panel-body">
                  <table id="chart-detail-ip" class="table">
                        <thead>
                            <th>No</th>
                            <th>Code</th>
                            <th>Sub Init</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Sisa</th>
                        </thead>
                        <tbody id="chart-detail-body-ip">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          <div class="panel panel-default p-c">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseC">
                    Completed
                  </a>
                </h4>
              </div>
              <div id="collapseC" class="panel-collapse collapse in">
                <div class="panel-body">
                  <table id="chart-detail-completed" class="table">
                        <thead>
                            <th>No</th>
                            <th>Code</th>
                            <th>Sub Init</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Sisa</th>
                        </thead>
                        <tbody id="chart-detail-body-completed">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
</div>
<div id="delayId" style="display: none;"></div>
<script>
$('#content-detail').hide();
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
            <?php if (strtolower($key) == 'inprog') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif (strtolower($key) == 'notyet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif (strtolower($key) == 'complete') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif (strtolower($key) == 'delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php }else{ ?>
                {
                type: "At Risk",
                color: "orange",
            <?php } ?>
            percent: "<?php echo number_format(($value * $persen_initiative), 2, '.', ''); ?>",
            },
    <?php } ?>
    ];

    var typesDeliverable = [
    <?php foreach ($chart_data_deliverable as $key => $value) { ?>
            <?php if ($value['status'] != null){ ?>
            <?php if (strtolower($value['status']) == 'in progress') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif (strtolower($value['status']) == 'not started yet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif (strtolower($value['status']) == 'completed') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif (strtolower($value['status']) == 'delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php }else{ ?>
                {
                type: "At Risk",
                color: "orange",
            <?php } ?>
            percent: "<?php echo number_format(($value['percent'] * $persen_deliverable), 2, '.', ''); ?>",
            },
    <?php } ?>
  <?php } ?>
    ];

    var typesWorkstream = [
    <?php foreach ($chart_data_workstream as $key => $value) { ?>
        <?php if ($value['status'] != null){ ?>
            <?php if (strtolower($value['status']) == 'in progress') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif (strtolower($value['status']) == 'not started yet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif (strtolower($value['status']) == 'completed') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif (strtolower($value['status']) == 'delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php }else{ ?>
                {
                type: "At Risk",
                color: "orange",
            <?php } ?>
            percent: "<?php echo number_format(($value['percent'] * $persen_workstream), 2, '.', ''); ?>",
            },
        <?php } ?>
    <?php } ?>
    ];

    var typesAction = [
    <?php foreach ($chart_data_action as $key => $value) { ?>
            <?php if (strtolower($value['status']) == 'in progress') { ?>
                {
                type: "In Progress",
                color: "grey",
            <?php }elseif (strtolower($value['status']) == 'not started yet') { ?>
                {
                type: "Not Yet",
                color: "yellow",
            <?php }elseif (strtolower($value['status']) == 'completed') { ?>
                {
                type: "Completed",
                color: "green",
            <?php }elseif (strtolower($value['status']) == 'delay') { ?>
                {
                type: "Delay",
                color: "red",
            <?php } ?>
            percent: "<?php echo number_format(($value['percent'] * $persen_action), 2, '.', ''); ?>",
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

function generateChartDataWorkstream() {
  var chartDataWorkstream = [];
  for (var i = 0; i < typesWorkstream.length; i++) {
    if (i == selected) {
      for (var x = 0; x < typesWorkstream[i].subs.length; x++) {
        chartDataWorkstream.push({
          type: typesWorkstream[i].subs[x].type,
          percent: typesWorkstream[i].subs[x].percent,
          color: typesWorkstream[i].color,
          pulled: true
        });
      }
    } else {
      chartDataWorkstream.push({
        type: typesWorkstream[i].type,
        percent: typesWorkstream[i].percent,
        color: typesWorkstream[i].color,
        id: i
      });
    }
  }
  return chartDataWorkstream;
}

function generateChartDataDeliverable() {
  var chartDataDeliverable = [];
  for (var i = 0; i < typesDeliverable.length; i++) {
    if (i == selected) {
      for (var x = 0; x < typesDeliverable[i].subs.length; x++) {
        chartDataDeliverable.push({
          type: typesDeliverable[i].subs[x].type,
          percent: typesDeliverable[i].subs[x].percent,
          color: typesDeliverable[i].color,
          pulled: true
        });
      }
    } else {
      chartDataDeliverable.push({
        type: typesDeliverable[i].type,
        percent: typesDeliverable[i].percent,
        color: typesDeliverable[i].color,
        id: i
      });
    }
  }
  return chartDataDeliverable;
}

AmCharts.makeChart("chart_initiative", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        "textClickEnabled":true,
        "valueText": "[[value]]%",
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
    "text": "Initiative Chart (<?php echo $total_summary_initiative ?>)",
    "size": 11
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(e) {
      var chart = e.chart;
      var dp = e.dataItem.dataContext;
        displayDetailInitiative(dp.type);
        
      e.chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

function displayDetailInitiative(status)
{
  $('#content-detail').show();
  $(".p-delay").hide();
  $(".p-nys").hide();
  $(".p-ip").hide();
  $(".p-c").hide();
  $("#chart-detail-body-ip").empty();
  $("#chart-detail-body-delay").empty();
  $("#chart-detail-body-nys").empty();
  $("#chart-detail-body-completed").empty();
  $("#keterangan-detail-chart").empty();
  $("#keterangan-detail-chart").html('<h3>Detail Initiative</h3>');

  if (status == 'In Progress'){
    $(".p-ip").show();

    $i = 1;
    <?php foreach ($summary_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_progress[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_progress[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_progress[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_progress[$key]['start']); $b = new DateTime($summary_progress[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
        $i++;
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    $i = 1;
    <?php foreach ($summary_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_delay[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_delay[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_delay[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_delay[$key]['start']); $b = new DateTime($summary_delay[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    $i = 1;
    <?php foreach ($summary_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_completed[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_completed[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_completed[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_completed[$key]['start']); $b = new DateTime($summary_completed[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    $i = 1;
    <?php foreach ($summary_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_not_started[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_not_started[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_not_started[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_not_started[$key]['start']); $b = new DateTime($summary_not_started[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
        $i++;
    <?php endforeach ?>
  }
}

AmCharts.makeChart("chart_action", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        "textClickEnabled":true,
        "valueText": "[[value]]%",
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
    "text": "Action Chart (<?php echo $total_summary_action ?>)",
    "size": 11
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(e) {
      var chart = e.chart;
      var dp = e.dataItem.dataContext;
        displayDetailAction(dp.type);
        
      e.chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

function displayDetailAction(status)
{
  $('#content-detail').show();
  $(".p-delay").hide();
  $(".p-nys").hide();
  $(".p-ip").hide();
  $(".p-c").hide();
  $("#chart-detail-body-ip").empty();
  $("#chart-detail-body-delay").empty();
  $("#chart-detail-body-nys").empty();
  $("#chart-detail-body-completed").empty();
  $("#keterangan-detail-chart").empty();
  $("#keterangan-detail-chart").html('<h3>Detail Action</h3>');

  if (status == 'In Progress'){
    $(".p-ip").show();

    $i = 1;
    <?php foreach ($summary_action_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_progress[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_action_progress[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_action_progress[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_action_progress[$key]['start']); $b = new DateTime($summary_action_progress[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
        $i++;
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    $i = 1;
    <?php foreach ($summary_action_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_delay[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_action_delay[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_action_delay[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_action_delay[$key]['start']); $b = new DateTime($summary_action_delay[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    $i = 1;
    <?php foreach ($summary_action_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_completed[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_action_completed[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_action_completed[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_action_completed[$key]['start']); $b = new DateTime($summary_action_completed[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td><</tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    $i = 1;
    <?php foreach ($summary_action_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_not_started[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_action_not_started[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_action_not_started[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_action_not_started[$key]['start']); $b = new DateTime($summary_action_not_started[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
        $i++;
    <?php endforeach ?>
  }
}

AmCharts.makeChart("chart_workstream", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        "textClickEnabled":true,
        "valueText": "[[value]]%",
        // "marginRight":1000000,
        "autoMargins":true
      },

  "dataProvider": generateChartDataWorkstream(),
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
    "text": "Workstream Chart (<?php echo $total_summary_workstream ?>)",
    "size": 11
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(e) {
      var chart = e.chart;
      var dp = e.dataItem.dataContext;
        displayDetailWorkstream(dp.type);
        
      e.chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

function displayDetailWorkstream(status)
{
  $('#content-detail').show();
  $(".p-delay").hide();
  $(".p-nys").hide();
  $(".p-ip").hide();
  $(".p-c").hide();
  $("#chart-detail-body-ip").empty();
  $("#chart-detail-body-delay").empty();
  $("#chart-detail-body-nys").empty();
  $("#chart-detail-body-completed").empty();
  $("#keterangan-detail-chart").empty();
  $("#keterangan-detail-chart").html('<h3>Detail Workstream</h3>');

  if (status == 'In Progress'){
    $(".p-ip").show();

    $i = 1;
    <?php foreach ($summary_workstream_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_progress[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_workstream_progress[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_workstream_progress[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_workstream_progress[$key]['start']); $b = new DateTime($summary_workstream_progress[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
        $i++;
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    $i = 1;
    <?php foreach ($summary_workstream_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_delay[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_workstream_delay[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_workstream_delay[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_workstream_delay[$key]['start']); $b = new DateTime($summary_workstream_delay[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    $i = 1;
    <?php foreach ($summary_workstream_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_completed[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_workstream_completed[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_workstream_completed[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_workstream_completed[$key]['start']); $b = new DateTime($summary_workstream_completed[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    $i = 1;
    <?php foreach ($summary_workstream_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_not_started[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_workstream_not_started[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_workstream_not_started[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_workstream_not_started[$key]['start']); $b = new DateTime($summary_workstream_not_started[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
        $i++;
    <?php endforeach ?>
  }
}

AmCharts.makeChart("chart_deliverable", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
        "textClickEnabled":true,
        "valueText": "[[value]]%",
        // "marginRight":1000000,
        "autoMargins":true
      },

  "dataProvider": generateChartDataDeliverable(),
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
    "text": "Deliverable Chart (<?php echo $total_summary_deliverable ?>)",
    "size": 11
  }],
  "listeners": [{
    "event": "clickSlice",
    "method": function(e) {
      var chart = e.chart;
      var dp = e.dataItem.dataContext;
        displayDetailDeliverable(dp.type);
        
      e.chart.validateData();
    }
  }],
  // "export": {
  //   "enabled": true
  // }
});

function displayDetailDeliverable(status)
{
  $('#content-detail').show();
  $(".p-delay").hide();
  $(".p-nys").hide();
  $(".p-ip").hide();
  $(".p-c").hide();
  $("#chart-detail-body-ip").empty();
  $("#chart-detail-body-delay").empty();
  $("#chart-detail-body-nys").empty();
  $("#chart-detail-body-completed").empty();
  $("#keterangan-detail-chart").empty();
  $("#keterangan-detail-chart").html('<h3>Detail Deliverable</h3>');

  if (status == 'In Progress'){
    $(".p-ip").show();

    $i = 1;
    <?php foreach ($summary_deliverable_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_progress[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_deliverable_progress[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_deliverable_progress[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_deliverable_progress[$key]['start']); $b = new DateTime($summary_deliverable_progress[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
        $i++;
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    $i = 1;
    <?php foreach ($summary_deliverable_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_delay[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_deliverable_delay[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_deliverable_delay[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_deliverable_delay[$key]['start']); $b = new DateTime($summary_deliverable_delay[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    $i = 1;
    <?php foreach ($summary_deliverable_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_completed[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_deliverable_completed[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_deliverable_completed[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_deliverable_completed[$key]['start']); $b = new DateTime($summary_deliverable_completed[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
        $i++;
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    $i = 1;
    <?php foreach ($summary_deliverable_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_not_started[$key]['code']) ?>;
        <?php $newDateStart = date("d-m-Y", strtotime($summary_deliverable_not_started[$key]['start'])); ?>
        <?php $newDateEnd = date("d-m-Y", strtotime($summary_deliverable_not_started[$key]['end'])); ?>
        $text_start = <?php echo json_encode($newDateStart) ?>;
        $text_end = <?php echo json_encode($newDateEnd) ?>;
        $diff = <?php $a = new DateTime($summary_deliverable_not_started[$key]['start']); $b = new DateTime($summary_deliverable_not_started[$key]['end']); $c = $a->diff($b); echo json_encode($c->days); ?>;
        var newRowContent = '<tr><td>'+$i+'</td><td>'+$text_code+'</td><<td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td><td>'+$diff+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
        $i++;
    <?php endforeach ?>
  }
}

function take(div) {
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
  //location.reload();
}
</script>