<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<h5>Comment</h5>
			<form method ="post" action="<?php echo base_url()?>initiative/submit_remark/<?php echo $init_id?>" method ="post" id="form_remark" role="form">
				<input type="hidden" value="<?php if($remark){echo $remark->id;}?>" name="id">
				<input type="hidden" value="<?php if($user_id){echo $user_id;}?>" name="user_id">
				<div class="form-group">
					<textarea type="text" class="form-control" name="remark"><?php if($remark){echo $remark->content;}?></textarea>
				</div>
				<div class="pull-right">
					<button class="btn btn-sm btn-success" type="submit" onclick="submit_remark();">Submit</button>
				</div>
				<div style="clear:both"></div>
			</form>
		</div>
	</div>
  </div>
</div>
<script>
	CKEDITOR.replace('remark');
</script>