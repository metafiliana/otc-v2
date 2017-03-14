<?php $count_completed="";  $count_wb="";
    foreach($programs as $proga){ 
    	$count_completed+=$proga['wb_status']['complete'];  
    	$count_wb+=$proga['wb_total'];
}?>
<h4 class="blue_color_bg gray_color center_text">Completed</h4>
<h3 class="center_text"><?php echo number_format((($count_completed/$count_wb)*100),2);?> %</h3>