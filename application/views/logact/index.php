<div style="padding:5px">
	<h3>Log Activity</h3>
	<div class="" style="padding:0px">
		<?php echo $listlog;?>
	</div>
</div>
<div style="clear:both"></div>

<script>
	
	$('#from').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#until').datepicker({
		autoclose: true,
		todayHighlight: true
	});
</script>