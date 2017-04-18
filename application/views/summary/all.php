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
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

<div class="component_part">
    <div class="row well">
        <div class="clearfix" style="float: right;">
          <button class="btn btn-default">Summary All</button>
          <a href="<?php echo base_url()?>summary/program_list/"><button class="btn btn-default">Summary Program List</button></a>
        </div>
    </div>
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
        <div id="event"></div>
        <!-- <div class="col-md-12">
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
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

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
                    <table id="chart-detail-delay" class="table text-center">
                        <thead>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                  <table id="chart-detail-nys" class="table text-center">
                        <thead>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                  <table id="chart-detail-ip" class="table text-center">
                        <thead>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                  <table id="chart-detail-completed" class="table text-center">
                        <thead>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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

    <?php foreach ($summary_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_progress[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_progress[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_progress[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    <?php foreach ($summary_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_delay[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_delay[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    <?php foreach ($summary_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_completed[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_completed[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_completed[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    <?php foreach ($summary_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_not_started[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_not_started[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_not_started[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
    <?php endforeach ?>
  }
}

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

    <?php foreach ($summary_action_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_progress[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_action_progress[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_action_progress[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    <?php foreach ($summary_action_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_delay[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_action_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_action_delay[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    <?php foreach ($summary_action_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_completed[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_action_completed[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_action_completed[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    <?php foreach ($summary_action_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_action_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_action_not_started[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_action_not_started[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_action_not_started[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
    <?php endforeach ?>
  }
}

AmCharts.makeChart("chart_workstream", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
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
    "text": "Workstream Chart",
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

    <?php foreach ($summary_workstream_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_progress[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_workstream_progress[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_workstream_progress[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    <?php foreach ($summary_workstream_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_delay[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_workstream_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_workstream_delay[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    <?php foreach ($summary_workstream_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_completed[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_workstream_completed[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_workstream_completed[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    <?php foreach ($summary_workstream_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_workstream_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_workstream_not_started[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_workstream_not_started[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_workstream_not_started[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
    <?php endforeach ?>
  }
}

AmCharts.makeChart("chart_deliverable", {
    "type": "pie",
    "theme": "light",
    "legend":{
        "position":"right",
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
    "text": "Deliverable Chart",
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

    <?php foreach ($summary_deliverable_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_progress[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_progress[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_deliverable_progress[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_deliverable_progress[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-ip"));
    <?php endforeach ?>

  }else if (status == 'Delay'){
    $(".p-delay").show();

    <?php foreach ($summary_deliverable_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_delay[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_delay[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_deliverable_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_deliverable_delay[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-delay"));
    <?php endforeach ?>
  }else if (status == 'Completed'){
    $(".p-c").show();

    <?php foreach ($summary_deliverable_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_completed[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_completed[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_deliverable_completed[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_deliverable_completed[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-completed"));
    <?php endforeach ?>
  }else if (status == 'Not Yet'){
    $(".p-nys").show();

    <?php foreach ($summary_deliverable_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_deliverable_not_started[$key]['b_title']) ?>;
        $text_code = <?php echo json_encode($summary_deliverable_not_started[$key]['code']) ?>;
        $text_start = <?php echo json_encode($summary_deliverable_not_started[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_deliverable_not_started[$key]['end']) ?>;
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_code+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#chart-detail-body-nys"));
    <?php endforeach ?>
  }
}
</script>