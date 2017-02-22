<hr>
<h3 class="form-signin-heading">Input Initiative</h3>
<form class="form-horizontal" action="<?php echo base_url();?>initiative/submit_initiative" method ="post" id="formsignup" role="form">
	<input type="hidden" value="<?php echo $program->id?>" name="program_id">
	<input type="hidden" value="<?php if($int){echo $int->id;}?>" name="id">
	<div>
		<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-2 control-label">Initiative</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="title" name="title" placeholder="Initiative" value="<?php if($int){echo $int->title;}?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Id</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="code" id="code" placeholder="Id" value="<?php if($int){echo $int->code;}?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Parent</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="parent" id="parent" placeholder="Parent">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Dependency</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="depen" name="kickoff" placeholder="Kickoff" value="<?php if($int){echo $int->kickoff;}?>">
			</div>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="depen" name="completion" placeholder="Completion" value="<?php if($int){echo $int->completion;}?>">
			</div>
		</div>
	</div>
		<div class="col-sm-6">
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Start</label>
			<div class="col-sm-9">
				<?php $start=""; if($int){if($int->start){$start = date("m/d/Y", strtotime($int->start));}}?>
				<input type="text" class="form-control" id="start" name="start" placeholder="mm/dd/YYYY" value="<?php echo $start?>">
				<small style="color:grey">*format: mm/dd/YYYY</small>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">End</label>
			<div class="col-sm-9">
				<?php $end=""; if($int){if($int->end){$end = date("m/d/Y", strtotime($int->end));}}?>
				<input type="text" class="form-control" id="end" name="end" placeholder="mm/dd/YYYY" value="<?php echo $end?>">
				<small style="color:grey">*format: mm/dd/YYYY</small>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">PIC</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="pic" id="pic" placeholder="PIC" value="<?php if($int){echo $int->pic;}?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label input-sm">Status</label>
			<div class="col-sm-9">
			  <select class="form-control input-sm" name="status" id="status" onchange="">
				<option value="Not Started Yet" <?php if($int){if($int->status == "Not Started Yet"){echo "selected";}}?>>Not Started Yet</option>
				<option value="In Progress" <?php if($int){if($int->status == "In Progress"){echo "selected";}}?>>In Progress</option>
				<option value="Completed" <?php if($int){if($int->status == "Completed"){echo "selected";}}?>>Completed</option>
				<option value="At Risk" <?php if($int){if($int->status == "At Risk"){echo "selected";}}?>>At Risk</option>
				<option value="Delay" <?php if($int){if($int->status == "Delay"){echo "selected";}}?>>Delay</option>
			  </select>
			</div><div style="clear:both"></div>
		</div>
	</div>
		<div style="clear:both"></div>
	</div>
	<div class="col-sm-12">
		<div class="form-group">
			<label class="col-sm-1 control-label">Description</label>
			<div class="col-sm-11">
				<textarea type="text" class="form-control" name="description"></textarea>
			</div>
		</div>
	</div>
	<input type="submit" class="btn btn-success" value="Submit">
	<input type="button" onclick="close_form_initiative()" class="btn btn-danger" value="Close">
</form>
<hr>

<script>
	CKEDITOR.replace('description');
	$('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
</script>