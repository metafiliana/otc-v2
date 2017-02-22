<div style="width:50%; float:left"><h4>Reason</h4></div>
<div style="width:50%; float:left"><h4>Action Plan</h4></div>
<div style="clear:both"></div>

<?php foreach($aprv as $ap){ ?>
	<div>
		<div style="width:50%; float:left"><?php echo $ap->reason?></div>
		<div style="width:50%; float:left"><?php echo $ap->action?></div><div style="clear:both"></div>
		<hr>
	</div>
<?php }?>