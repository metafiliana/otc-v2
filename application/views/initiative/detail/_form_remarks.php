<h5>Data Remark</h5>
<form method ="post" action="<?php echo base_url()?>initiative/submit_remark/<?php echo $init_id?>" method ="post" id="form_remark" role="form">
	<input type="hidden" value="<?php if($remark){echo $remark->id;}?>" name="id">
	<div class="form-group">
		<textarea type="text" class="form-control" name="remark"><?php if($remark){echo $remark->content;}?></textarea>
	</div>
	<div class="pull-right">
		<button class="btn btn-sm btn-success" type="submit" onclick="submit_remark();">Submit</button>
		<input type="button" class="btn btn-danger btn-sm" value="Close" onclick="close_form_remark();">
	</div>
	<div style="clear:both"></div>
</form>
<script>
	CKEDITOR.replace('remark');
</script>