<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>					
				<div>
					<div class="form-signin">
						<h3 class="form-signin-heading">Upload File Init Code:<?php echo $init_code?></h3>
						<form class="form-horizontal" 
	                          action="<?php 
	                        if(isset($dsfile)){echo base_url()."general/submit_file/".$dsfile->id;}
	                        else{echo base_url()."general/submit_file";}?>" 
	                          method ="post" id="formnew" role="form" enctype="multipart/form-data">
	                        <input type="hidden" value="<?php if($init_code){echo $init_code;}?>" name="init_code" id="init_code">
	                        <div class="form-group" style="margin-top:10px">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" placeholder="Title" <?php if(isset($dsfile)){echo "value='".$dsfile->title."'";}?>>
								</div>
							</div>
	                        <div class="form-group">
								<label class="col-sm-2 control-label input-md">Attachment</label>
								<div class="col-sm-10">
									<input type="file" name="attachment[]" class="btn-md">
								</div>
							</div>
							<hr>
							<button class="btn btn-md btn-primary btn-block" type="submit">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('input[type=file]').bootstrapFileInput();
	});
	$('#created').datepicker({
		autoclose: true,
		todayHighlight: true
	});
</script>