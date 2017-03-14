<?php $count_completed="";  $count_wb=""; $count_nsy=""; $count_ip=""; $count_delay="";
    foreach($programs as $proga){ 
    	$count_completed+=$proga['wb_status']['complete'];  
    	$count_nsy+=$proga['wb_status']['notyet']; 
    	$count_ip+=$proga['wb_status']['inprog'];
    	$count_delay+=$proga['wb_status']['delay'];
    	$count_wb+=$proga['wb_total'];
    }?>
<table class="table" style="margin-bottom:0">
	<thead>
		<tr class="black_color">
			<th class="grey_color_bg" style="vertical-align:middle;">Not Started Yet</th>
			<th class="green_color_bg" style="vertical-align:middle;">In Progress</th>
			<th class="yellow_color_bg" style="vertical-align:middle;">Delay</th>
			<th class="blue_color_bg" style="vertical-align:middle;">Completed</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th class="center_text"><span><?php echo number_format((($count_nsy/$count_wb)*100),2);?> %</span></th>
			<th class="center_text"><span><?php echo number_format((($count_ip/$count_wb)*100),2);?> %</span></th>
			<th class="center_text"><span><?php echo number_format((($count_delay/$count_wb)*100),2);?> %</span></th>
			<th class="center_text"><span><?php echo number_format((($count_completed/$count_wb)*100),2);?> %</span></th>
		</tr>
	</tbody>
</table>