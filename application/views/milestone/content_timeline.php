<?php foreach($tl as $each){?>
	<div>
		<div style="float:left; font-size:11px; color:grey"><?php echo $each->name?></div>
		<div style="float:left; font-size:11px; color:grey; margin-left:10px"><?php echo date("d M y / h:i",strtotime($each->date_created))?></div><div style="clear:both"></div>
		<div style="font-size:12px; padding-left:20px"><?php echo $each->content?></div>
	</div>
<?php }?>