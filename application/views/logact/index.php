<div style="padding:5px">
	<h3>Log Activity</h3>
	<div style="width:70%; float:left; padding:0px">
		<?php echo $listlog;?>
	</div>
	<div style="width:25%; float:left; margin-left:20px">
		<div class="panel panel-primary">
			<div class="panel-heading">Setup <div class="pull-right"><button class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-refresh"></span></button></div></div>
			<div class="panel-body">
				<form class="form-horizontal">
					<h5 style="margin-top:-5px;">Date :</h5>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="text" class="form-control input-sm" id="from" name="from" placeholder="From">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="text" class="form-control input-sm" id="until" name="until" placeholder="Until">
						</div>
					</div>
					<hr>
					<h5 style="margin-bottom:0px;">Segment :</h5>
					<div class="checkbox">
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Wholesale
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> SME
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Mikro
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Individuals
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> IT
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Human Capital
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Risk
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Performance Management
						</label>
						<label class="checkbox">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Organization
						</label>
					</div>
				</form>
			</div>
		</div>
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