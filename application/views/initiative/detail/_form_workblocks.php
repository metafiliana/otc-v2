<h5>Data Workblock</h5><hr>
<form method ="post" action="<?php echo base_url()?>workblock/submit_workblock/" method ="post" id="form_workblock" role="form">
	<input type="hidden" value="<?php if($wb){echo $wb->id;}?>" name="id">
	<input type="hidden" value="<?php echo $init_id;?>" name="init_id">
	<div class="form-group">
		<label class="col-sm-2 control-label input-sm">Workblock</label>
		<div class="col-sm-9">
		  <input type="text" class="form-control input-sm" placeholder="Workblock" name="title" value="<?php if($wb){echo $wb->title;}?>">
		</div><div style="clear:both"></div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label input-sm">Status</label>
		<div class="col-sm-9">
		  <select class="form-control input-sm" name="status" id="status" onchange="">
			<option value="Not Started Yet" <?php if($wb){if($wb->status == "Not Started Yet"){echo "selected";}}?>>Not Started Yet</option>
			<option value="In Progress" <?php if($wb){if($wb->status == "In Progress"){echo "selected";}}?>>In Progress</option>
			<option value="Completed" <?php if($wb){if($wb->status == "Completed"){echo "selected";}}?>>Completed</option>
			<option value="Delay" <?php if($wb){if($wb->status == "Delay"){echo "selected";}}?>>Delay</option>
		  </select>
		</div><div style="clear:both"></div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label input-sm">Start Date</label>
		<div class="col-sm-9">
		  <?php $start=""; if($wb){if($wb->start){$start = date("m/d/Y", strtotime($wb->start));}}?>
		  <input type="text" class="form-control input-sm" placeholder="mm/dd/yy" name="start" id="start" value="<?php echo $start?>">
		</div><div style="clear:both"></div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label input-sm">End Date</label>
		<div class="col-sm-9">
		  <?php $end=""; if($wb){if($wb->end){$end = date("m/d/Y", strtotime($wb->end));}}?>
		  <input type="text" class="form-control input-sm" placeholder="mm/dd/yy" name="end" id="end" value="<?php echo $end?>">
		</div><div style="clear:both"></div>
	</div>
	<!--<div class="form-group">
		<label class=" control-label input-sm">Detail</label>
		<div class="">
			<div class="form-group">
				<textarea type="text" class="form-control" name="objective"></textarea>
			</div>
		</div><div style="clear:both"></div>
	</div>-->
	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
			<input type="submit" class="btn btn-success btn-sm" value="Submit" onclick="submit_workblock();">
			<input type="button" class="btn btn-danger btn-sm" value="Close" onclick="close_form_workblock();">
		</div>
	</div>
	<div style="clear:both"></div>
</form>

<script>
	$.validator.addMethod("checkrange", function(value, element) {
		var responsedate;
		$.ajax({
			type: "POST",
			url: config.base+"workblock/check_range_date_init",
			data: {date: value,init_id: <?php echo $init_id?>},
			dataType:"json",
			async: false,
			success: function(result)
			{
				if(result.value===true){responsedate = true;}else if(result.value===false){responsedate=false;}
			}
		})
		return responsedate;
	}, "Date Was Not In the Range");
	
	$('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	
	
	$('#form_workblock').validate({
		rules: {			
			title: {
				required: true,
				//notexistcodeedit: true
			},
			start: {
				required: true,
				checkrange: true
			},
			end: {
				required: true,
				checkrange: true
			}
		}
	});
</script>