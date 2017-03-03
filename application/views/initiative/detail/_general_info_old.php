<style>
	.checkbox label{display:block;}
</style>

<div>
	<span style="font-size:16px">Status : <span style="color:<?php echo color_status($stat)?>; font-weight:bold"><?php echo $stat?></span></span>
</div>
<hr style="margin:0">
<div style="width:50%; float:left">
	<h5 style="margin:5px 0 0 0">Intiative Status</h5>
	<canvas style="float:left;" id="myChart2" width="150" height="150"></canvas>
	<div style="clear:both"></div>
</div>
<div style="width:50%; float:left; margin-top:40px;">
	<div class="checkbox">
		<label class="checkbox" style="margin-bottom:10px">
			<input type="checkbox" id="inlineCheckbox1" value="option1" checked> <span style="color:#bbb">Not Started Yet</span>
		</label>
		<label class="checkbox" style="margin-bottom:10px">
			<input type="checkbox" id="inlineCheckbox1" value="option1" checked> <span style="color:#27c24c">In Progress</span>
		</label>
		<label class="checkbox" style="margin-bottom:10px">
			<input type="checkbox" id="inlineCheckbox1" value="option1" checked> <span style="color:#FF0000">Delay</span>
		</label>
		<label class="checkbox" style="margin-bottom:5px">
			<input type="checkbox" id="inlineCheckbox1" value="option1" checked> <span style="color:#337ab7">Completed</span>
		</label>
	</div>
</div><div style="clear:both"></div><hr style="margin:0">
<div style="font-size:11px">
	<h5>Sisa Timeline</h5>
	<?php 
		$start = strtotime($initiative->start); $end = strtotime($initiative->end); $now = strtotime(date('Y-m-d')); 
		if($end-$start == 0) $pcttgl=0;
		else $pcttgl = ($now-$start)/($end-$start)*100;
		if($pcttgl<0){$pcttgl = 0;}
		if($pcttgl>100){$pcttgl = 100;}
		if($pcttgl <= 50 ){$barcol="success";}
		elseif($pcttgl > 50 && $pcttgl <= 80){$barcol="warning";}
		elseif($pcttgl > 80 ){$barcol="danger";}
		$numdays = ($end - $now)/(60 * 60 * 24);
		if($numdays<0){$numdays=0;}
		$strnumday = "";
		if($start<$now){$strnumday = $numdays."-hari (".number_format(100-$pcttgl,0)."%)";}
	?>
	<div class="progress" style="margin-bottom:0">
	  <div class="progress-bar progress-bar-<?php echo $barcol?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pcttgl?>%">
		<span style="color:black;"><?php echo $strnumday?></span>
	  </div>
	</div>
	<span><?php echo date("j M y",$start);?></span>
	<span style="float:right"><?php echo date("j M y",$end);?></span>
</div>
<script>
$(document).ready(function(){
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
</script>