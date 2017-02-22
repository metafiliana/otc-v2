<!--FORM EDIT BOS -->
	<td colspan=7>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#pic_token_"+<?php echo $init->id?>).
				tokenInput("<?php echo base_url('initiative/get_pic_token');?>", {
						   tokenLimit: 1,
						   prePopulate:$("#pic_token_"+<?php echo $init->id?>).data('load')
						   });
			});
		</script>
		<form class="form-horizontal" action="<?php echo base_url();?>initiative/submit_initiative/<?php echo $init->id?>" method ="post" id="formsignup" role="form">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="">Program</label>
					<input type="hidden" value="<?php echo $segment?>" name="segment">
					<div class="col-sm-8">
						<select class="form-control" name="program">
							<?php foreach($programs as $prg){?>
							<option value="<?php echo $prg->id?>" <?php if($init->program == $prg->title){echo "selected";}?>><?php echo $prg->title?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Initiative</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="title" name="title" placeholder="Initiative" value="<?php echo $init->title?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Id</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="code" id="code" placeholder="Id" value="<?php echo $init->code?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Parent</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="parent" id="parent" placeholder="Parent" value="<?php echo $init->parent_code?>">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-sm-2 control-label">Dependency</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="kickoff" name="kickoff" placeholder="Kick-off" value="<?php if($init->kickoff){echo $init->kickoff;}?>">
					</div>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="completion" name="completion" placeholder="Completion" value="<?php if($init->completion){echo $init->completion;}?>">
					</div><div class="col-sm-2"></div>
					<div class="col-sm-10">
						<small style="color:grey; font-style:italic">jika lebih dari satu pisahkan dengan ","</small>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Date</label>
					<div class="col-sm-5">
						<?php $start=""; if($init->start){$start = date("m/d/Y", strtotime($init->start));}?>
						<input type="date" class="form-control" id="start<?php echo $init->id?>" name="start" placeholder="Start (mm/dd/YYYY)" value="<?php echo $start?>">
					</div>
					<div class="col-sm-5">
						<?php $end=""; if($init->end){$end = date("m/d/Y", strtotime($init->end));}?>
						<input type="date" class="form-control" id="end<?php echo $init->id?>" name="end" placeholder="End (mm/dd/YYYY)" value="<?php echo $end?>">
					</div><div class="col-sm-2"></div>
					<div class="col-sm-10">
						<small style="color:grey; font-style:italic">*format: mm/dd/YYYY</small>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
			<div class="form-group">
				<label class="col-sm-2 control-label">PIC Lead</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="pic_token_<?php echo $init->id?>" name="GH_PIC" data-load='<?php echo $pic;?>' >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label input-sm">Status</label>
				<div class="col-sm-4">
				  <select class="form-control input-sm" name="status" id="status" onchange="">
					<option value="Not Started Yet" <?php if($init){if($init->status == "Not Started Yet"){echo "selected";}}?>>Not Started Yet</option>
					<option value="In Progress" <?php if($init){if($init->status == "In Progress"){echo "selected";}}?>>In Progress</option>
					<option value="Completed" <?php if($init){if($init->status == "Completed"){echo "selected";}}?>>Completed</option>
					<option value="At Risk" <?php if($init){if($init->status == "At Risk"){echo "selected";}}?>>At Risk</option>
					<option value="Delay" <?php if($init){if($init->status == "Delay"){echo "selected";}}?>>Delay</option>
				  </select>
				</div><div style="clear:both"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-9">
					<textarea type="text" class="form-control" id="description<?php echo $init->id?>" name="description"><?php echo $init->description?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label"></label>
				<div class="col-sm-4"><input type="submit" class="btn btn-success" value="Submit"></div>
			</div>
		</form>
		<script>
			 $('#start'+<?php echo $init->id?>).datepicker({
				autoclose: true,
				todayHighlight: true
			});
			$('#end'+<?php echo $init->id?>).datepicker({
				autoclose: true,
				todayHighlight: true
			});
			CKEDITOR.replace('description'+<?php echo $init->id?>);
		</script>
	</td>