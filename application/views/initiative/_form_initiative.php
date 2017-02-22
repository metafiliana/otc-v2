<h3 class="form-signin-heading">Input Initiative</h3>
<form class="form-horizontal" action="<?php echo base_url();?>initiative/submit_initiative" method ="post" id="formsignup" role="form">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Program</label>
		<div class="col-sm-4">
			<select class="form-control" name="program">
				<?php foreach($programs as $prg){?>
				<option value="<?php echo $prg->id?>"><?php echo $prg->title?></option>
				<?php }?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Initiative</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="title" name="title" placeholder="Initiative">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Id</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="code" id="code" placeholder="Id">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Tier</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="tier" id="tier" placeholder="Tier">
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-sm-2 control-label">Start</label>
		<div class="col-sm-4">
			<input type="date" class="form-control" id="start" name="start" placeholder="mm/dd/YYYY">
			<small style="color:grey">*format: mm/dd/YYYY</small>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-sm-2 control-label">End</label>
		<div class="col-sm-4">
			<input type="date" class="form-control" id="end" name="end" placeholder="mm/dd/YYYY">
			<small style="color:grey">*format: mm/dd/YYYY</small>
		</div>
	</div>
	<input type="submit" class="btn btn-success" style="margin-left:200px">
</form>
<hr>

<script>
    $('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
</script>