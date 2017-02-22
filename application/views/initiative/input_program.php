<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div id="" class="container no_pad">
				<div class="col-md-12">
					<div class="form-signin">
					<h3 class="form-signin-heading">Input Program</h3>
					<form class="form-horizontal" action="<?php echo base_url();?>program/submit_program" method ="post" id="formsignup" role="form">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="">Category</label>
							<div class="col-sm-9">
								<select class="form-control" name="category">
									<?php foreach($category as $prog1){?>
									<option value="<?php echo $prog1->val?>"><?php echo $prog1->val?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="">Segment</label>
							<div class="col-sm-9">
								<select class="form-control" name="segment">
									<?php foreach($arr_segment as $prog){?>
									<option value="<?php echo $prog->val?>"><?php echo $prog->val?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Program</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="title" name="title" placeholder="Program">
							</div>
						</div>
						 <div class="form-group">
							<label class="col-sm-3 control-label">Id</label>
							<div class="col-sm-9">
								<select class="form-control" name="code" id="code">
									<?php foreach($code as $progs){?>
									<option value="<?php echo $progs->val?>"><?php echo $progs->val?></option>
									<?php }?>
								</select>
								<!-- <input type="text" class="form-control" name="code" id="code" placeholder="Id"> -->
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Inisatif ID</label>
							<div class="col-sm-9">
								<select class="form-control" name="init_code" id="init_code">
									<?php foreach($init_code as $proga){?>
									<option value="<?php echo $proga->val?>"><?php echo $proga->val?></option>
									<?php }?>
								</select>
								<!-- <input type="text" class="form-control" name="code" id="code" placeholder="Id"> -->
							</div>
						</div>
						<hr>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
					</form>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>