<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h3 class="form-signin-heading"><?= $title ?></h3>
					<form class="form-horizontal"
					action="<?php echo base_url()."general/submit_form/cluster"?>"
				 	method="post" id="formsignup" role="form">
                  <div style="margin-top:20px">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Title Cluster</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title Cluster" value="">
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
