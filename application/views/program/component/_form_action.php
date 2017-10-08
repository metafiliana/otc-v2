<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:65%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading"><?= $title ?></h3>
					<form class="form-horizontal"
					action="<?php if(isset($action_id)){
                        echo base_url()."program/submit_action/".$action_id;}
                    else{
                        echo base_url()."program/submit_action/";}?>"
				 	method="post" id="formsignup" role="form">
                  <div style="margin-top:20px">
                    <input type="hidden" name="initiative_id" value="<?php echo $init_id; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Title Action</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title Action" value="<?php if (isset($action->title)){ echo $action->title ; }?>">
                        </div>
                    </div>
                    <div class="form-group">
            					<label class="col-sm-2 control-label input-sm">Status</label>
            					<div class="col-sm-3">
            					  <select class="form-control input-sm" name="status" id="status" onchange="">
                        <option value="Completed" <?php if(isset($action->status)){if($action->status == "Completed"){echo "selected";}}?>>Completed</option>
                        <option value="On track, no issues" <?php if(isset($action->status)){if($action->status == "On track, no issues"){echo "selected";}}?>>On track, no issues</option>
            						<option value="On track, with issues" <?php if(isset($action->status)){if($action->status == "On track, with issues"){echo "selected";}}?>>On track, with issues</option>
                        <option value="Not started" <?php if(isset($action->status)){if($action->status == "Not started"){echo "selected";}}?>>Not started</option>
            					  </select>
            					</div><div style="clear:both"></div>
            				</div>
                    <div class="form-group">
                  		<label for="" class="col-sm-2 control-label">Start Date</label>
                  		<div class="col-sm-4">
                  			<input type="date" class="form-control" id="start" name="start" placeholder="mm/dd/YYYY" value="<?php if(isset($action->start_date)){echo date("m/d/Y", strtotime($action->start_date));}?>">
                  			<small style="color:grey">format: mm/dd/YYYY</small>
                  		</div>
                  	</div>
                  	<div class="form-group">
                  		<label for="" class="col-sm-2 control-label">End Date</label>
                  		<div class="col-sm-4">
                  			<input type="date" class="form-control" id="end" name="end" placeholder="mm/dd/YYYY" value="<?php if(isset($action->end_date)){echo date("m/d/Y", strtotime($action->end_date));}?>">
                  			<small style="color:grey">format: mm/dd/YYYY</small>
                  		</div>
                  	</div>
                    <hr>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                  </div>
					</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
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
