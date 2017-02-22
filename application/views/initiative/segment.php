<div style="padding:5px">
	<h3>All Segment Initiatives Status</h3>
	<div style="float:right; margin-right:35px">
		<span class="circle circle-notyet circle-lg text-left"></span> Not Started Yet
		<span class="circle circle-inprog circle-lg text-left" style="margin-left:10px"></span> In Progress
		<span class="circle circle-atrisk circle-lg text-left" style="margin-left:10px"></span> At Risk
		<span class="circle circle-delay circle-lg text-left" style="margin-left:10px"></span> Delay
		<span class="circle circle-completed circle-lg text-left" style="margin-left:10px"></span> Completed
	</div><div style="clear:both"></div>
	<div style="width:48%; float:left; padding:0px; margin-right:10px">
		<div class="panel panel-primary">
			<div class="panel-heading">Business PMO</div>
			<div class="panel-body" style="padding:0;">
				<div style="float:left">
					<canvas style="float:left;" id="myChart2" width="200" height="200"></canvas>
				</div>
				<div style="float:left">
					<?php $bisnis = array('Wholesale','SME','Mikro','Individuals'); ?>
					<table class="table">
						<tr><th style="width:100px"></th>
							<th><span class="circle circle-notyet circle-lg text-left"></span></th>
							<th><span class="circle circle-inprog circle-lg text-left"></span></th>
							<th><span class="circle circle-atrisk circle-lg text-left"></span></th>
							<th><span class="circle circle-delay circle-lg text-left"></span></th>
							<th><span class="circle circle-completed circle-lg text-left"></span></th>
						</tr>
						<?php 
							$stss = return_arr_status(); $arrtotbis = array();
							foreach($stss as $stat){
								$arrtotbis[$stat] = 0;
							}
							foreach($bisnis as $each){
							echo "<tr><td><a href='".base_url()."program/list_programs/".$each."'>".$each."</a></td>";
							foreach($stss as $stat){
								echo "<td>".$segment_status[$each]['stat'][$stat]."</td>";
								$arrtotbis[$stat] = $arrtotbis[$stat]+$segment_status[$each]['stat'][$stat];
							}
							echo "</tr>";
							}
							//Total
							echo "<tr><th>Total</th>";
							foreach($stss as $stat){
								echo "<th>".$arrtotbis[$stat]."</th>";
							}
							echo "</tr>";
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div style="width:48%; float:left; padding:0px">
		<div class="panel panel-primary">
			<div class="panel-heading">Support PMO</div>
			<div class="panel-body" style="padding:0;">
				<div>
					<canvas style="float:left;" id="myChart1" width="200" height="200"></canvas>
				</div>
				<div style="float:left">
					<?php $support = array('IT','HC','Distribution','Risk'); ?>
					<table class="table">
						<tr><th style="width:100px"></th>
							<th><span class="circle circle-notyet circle-lg text-left"></span></th>
							<th><span class="circle circle-inprog circle-lg text-left"></span></th>
							<th><span class="circle circle-atrisk circle-lg text-left"></span></th>
							<th><span class="circle circle-delay circle-lg text-left"></span></th>
							<th><span class="circle circle-completed circle-lg text-left"></span></th>
						</tr>
						<?php 
							$arrtotsup = array();
							foreach($stss as $stat){
								$arrtotsup[$stat] = 0;
							}
							foreach($support as $each){
							echo "<tr><td><a href='".base_url()."program/list_programs/".$each."'>".$each."</a></td>";
							foreach($stss as $stat){
								echo "<td>".$segment_status[$each]['stat'][$stat]."</td>";
								$arrtotsup[$stat] = $arrtotsup[$stat]+$segment_status[$each]['stat'][$stat];
							}
							echo "</tr>";
							}
							//Total
							echo "<tr><th>Total</th>";
							foreach($stss as $stat){
								echo "<th>".$arrtotsup[$stat]."</th>";
							}
							echo "</tr>";
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear:both"></div>
<script>
$(document).ready(function(){
	var newopts = {
		inGraphDataShow: true,
		inGraphDataRadiusPosition: 2,
		inGraphDataFontColor: 'black',
		inGraphDataTmpl : "<%=v2%>",
	}
	var data2 = [
		<?php if($arrtotbis['Not Started Yet']){?>{
			value : <?php echo $arrtotbis['Not Started Yet']?>,
			color : "#bbb",
			
		},<?php } if($arrtotbis['In Progress']){?>{
			value : <?php echo $arrtotbis['In Progress']?>,
			color : "#27c24c",
		},<?php } if($arrtotbis['At Risk']){?>{
			value : <?php echo $arrtotbis['At Risk']?>,
			color : "#F6C600",
		},<?php } if($arrtotbis['Delay']){?>{
			value : <?php echo $arrtotbis['Delay']?>,
			color : "#FF0000",
		},<?php } if($arrtotbis['Completed']){?>{
			value : <?php echo $arrtotbis['Completed']?>,
			color : "#337ab7",
		}<?php }?>];
	var ctx2 = new Chart(document.getElementById("myChart2").getContext("2d")).Pie(data2, newopts);
	
	var data1 = [
		<?php if($arrtotsup['Not Started Yet']){?>{
			value : <?php echo $arrtotsup['Not Started Yet']?>,
			color : "#bbb",
			
		},<?php } if($arrtotsup['In Progress']){?>{
			value : <?php echo $arrtotsup['In Progress']?>,
			color : "#27c24c",
		},<?php } if($arrtotsup['At Risk']){?>{
			value : <?php echo $arrtotsup['At Risk']?>,
			color : "#F6C600",
		},<?php } if($arrtotsup['Delay']){?>{
			value : <?php echo $arrtotsup['Delay']?>,
			color : "#FF0000",
		},<?php } if($arrtotsup['Completed']){?>{
			value : <?php echo $arrtotsup['Completed']?>,
			color : "#337ab7",
		}<?php }?>];
	var ctx1 = new Chart(document.getElementById("myChart1").getContext("2d")).Pie(data1, newopts);
});
</script>