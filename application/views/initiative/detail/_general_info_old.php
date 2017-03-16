<style>
    .checkbox label{display:block;}
</style>
<div>
    <!-- <span style="font-size:16px">Status : <span style="color:<?php //echo color_status($stat)?>; font-weight:bold"><?php //echo $stat?></span></span> -->
    <span style="font-size:16px">Status : <span style="font-weight:bold" id="status"></span></span>
</div>
<hr style="margin:0">
<div style="width:50%; float:left">
    <h5 style="margin:5px 0 0 0">Intiative Status</h5>
    <canvas style="float:left;" id="myChart2" width="150" height="150"></canvas>
    <div style="clear:both"></div>
</div>
<div style="width:50%; float:left; margin-top:40px;">
    <div class="checkbox list-group">
        <input type="button" class='list-group-item' id="notStartedId" value="Not Started Yet">
        <input type="button" class='list-group-item' id="inProgressId" value="In Progress">
        <input type="button" class='list-group-item' id="delayId" value="Delay">
        <input type="button" class='list-group-item' id="completeId" value="Completed">
    </div>
</div>
<div style="clear:both"></div><hr style="margin:0">
<div style="font-size:11px">
    <!-- <h5>Sisa Timeline</h5> -->
    <?php 
        // $start = strtotime($initiative->start); 
        // $end = strtotime($initiative->end); 
        // $now = strtotime(date('Y-m-d')); 
        // $numdays = ($end - $now)/(60 * 60 * 24);
        // $strnumday = "";
        
        // if($end-$start == 0){
        //     $pcttgl=0;
        // }else{
        //     $pcttgl = ($now-$start)/($end-$start)*100;
        // };

        // if($pcttgl<0){
        //     $pcttgl = 0;
        // }

        // if($pcttgl>100){
        //     $pcttgl = 100;
        // }
        
        // if($pcttgl <= 50 ){
        //     $barcol="success";
        // }elseif($pcttgl > 50 && $pcttgl <= 80){
        //     $barcol="warning";
        // }elseif($pcttgl > 80 ){
        //     $barcol="danger";
        // }

        // if($numdays<0){
        //     $numdays=0;
        // }

        // if($start<$now){
        //     $strnumday = $numdays."-hari (".number_format(100-$pcttgl,0)."%)";
        // }
    ?>
    <!-- <div class="progress" style="margin-bottom:0">
      <div class="progress-bar progress-bar-<?php //echo $barcol?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php //echo $pcttgl?>%">
        <span style="color:black;"><?php //echo $strnumday?></span>
      </div>
    </div>
    <span><?php //echo date("j M y",$start);?></span>
    <span style="float:right"><?php //echo date("j M y",$end);?></span> -->
</div>
<script>
$("document").ready(function() {
    $("#status").text("In Progress");
    setTimeout(function() {
        $('#delayId').trigger('click');
    },10);
});
$(document).ready(function(){
    // $('#initiative-table').DataTable();
    var newopts = {
        inGraphDataShow: true,
        inGraphDataRadiusPosition: 2,
        inGraphDataFontColor: 'white',
        inGraphDataTmpl : "<%=v2%>",
    }
    var data2 = [
        <?php if($wb['notyet']){?>
        {
            value : <?php echo $wb['notyet'];?>,
            color : "#bbb",
            
        },<?php }?>
        <?php if($wb['inprog']){?>{
            value : <?php echo $wb['inprog'];?>,
            color : "#27c24c",
        },<?php }?>/*{
            value : 1,
            color : "#F6C600",
        },*/
        <?php if($wb['delay']){?>{
            value : <?php echo $wb['delay'];?>,
            color : "#FF0000",
        },<?php }?>
        <?php if($wb['complete']){?>{
            value : <?php echo $wb['complete'];?>,
            color : "#337ab7",
        }<?php }?>];
    var ctx2 = new Chart(document.getElementById("myChart2").getContext("2d")).Pie(data2, newopts);
});

$(document).on('click', '#notStartedId', function () {
    $("#initiative-table-body").empty();
    // $("#status").text("Not Started Yet");
    <?php foreach ($summary_not_started as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_not_started[$key]['b_title']) ?>;
        $text_start = <?php echo json_encode($summary_not_started[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_not_started[$key]['end']) ?>;
        // $('#initiative-info').text($text_info);
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#initiative-table-body"));
    <?php endforeach ?>
});
$(document).on('click', '#inProgressId', function () {
    $("#initiative-table-body").empty();
    // $("#status").text("Delay");
    <?php foreach ($summary_progress as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_progress[$key]['b_title']) ?>;
        $text_start = <?php echo json_encode($summary_progress[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_progress[$key]['end']) ?>;
        // $('#initiative-info').text($text_info);
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#initiative-table-body"));
    <?php endforeach ?>
});
$(document).on('click', '#delayId', function () {
    $("#initiative-table-body").empty();
    // $("#status").text("Delay");
    <?php foreach ($summary_delay as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_delay[$key]['b_title']) ?>;
        $text_start = <?php echo json_encode($summary_delay[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_delay[$key]['end']) ?>;
        // $('#initiative-info').text($text_info);
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#initiative-table-body"));
    <?php endforeach ?>
});
$(document).on('click', '#completeId', function () {
    $("#initiative-table-body").empty();
    // $("#status").text("Delay");
    <?php foreach ($summary_completed as $key => $value): ?>
        $text_info = <?php echo json_encode($summary_completed[$key]['b_title']) ?>;
        $text_start = <?php echo json_encode($summary_completed[$key]['start']) ?>;
        $text_end = <?php echo json_encode($summary_completed[$key]['end']) ?>;
        // $('#initiative-info').text($text_info);
        var newRowContent = '<tr><td>'+$text_info+'</td><td>'+$text_start+'</td><td>'+$text_end+'</td></tr>';
        $(newRowContent).appendTo($("#initiative-table-body"));
    <?php endforeach ?>
});
</script>