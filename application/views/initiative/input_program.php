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
					<h3 class="form-signin-heading">Input Sub-Initiative</h3>
					<form class="form-horizontal" 
					action="<?php if(isset($all)){
                        echo base_url()."program/submit_program/".$all->id;}
                    else{
                        echo base_url()."program/submit_program/";}?>"
				 	method="post" id="formsignup" role="form">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="">Category</label>
							<div class="col-sm-9">
								<select class="form-control" name="category">
									<?php foreach($category as $prog1){?>
									<option <?php if (isset($all) && $all->category == $prog1->val ) echo 'selected' ; ?> value="<?php echo $prog1->val?>"><?php echo $prog1->val?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="">Initiative Name</label>
							<div class="col-sm-9">
								<select class="form-control" name="segment">
									<?php foreach($arr_segment as $prog){?>
									<option <?php if (isset($all) && $all->segment == $prog->val ) echo 'selected' ; ?> value="<?php echo $prog->val?>"><?php echo $prog->val?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sub Initiative Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="title" name="title" placeholder="Program" value="<?php if (isset($all->title)) echo $all->title ; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Initiative Number</label>
							<div class="col-sm-9">
								<select class="form-control" name="init_code" id="init_code">
									<?php foreach($init_code as $proga){?>
									<option <?php if (isset($all) && $all->init_code == $proga->val ) echo 'selected' ; ?> value="<?php echo $proga->val?>"><?php echo $proga->val?></option>
									<?php }?>
								</select>
								<!-- <input type="text" class="form-control" name="code" id="code" placeholder="Id"> -->
							</div>
						</div>
					 	<div class="form-group">
							<label class="col-sm-3 control-label">Sub Initiative Number</label>
							<div class="col-sm-9">
								<select class="form-control" name="code" id="code">
									<?php foreach($code as $progs){?>
									<option <?php if (isset($all) && $all->code == $progs->val ) echo 'selected' ; ?> value="<?php echo $progs->val?>"><?php echo $progs->val?></option>
									<?php }?>
								</select>
								<!-- <input type="text" class="form-control" name="code" id="code" placeholder="Id"> -->
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Direktur Sponsor</label>
							<div class="col-sm-9">
								<select class="form-control" name="dir_spon" id="dir_spon">
									<?php foreach($dir as $dirs){?>
									<option <?php if (isset($all) && $all->dir_spon == $dirs->val ) echo 'selected' ; ?> value="<?php echo $dirs->val?>"><?php echo $dirs->val?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">PMO Head</label>
							<div class="col-sm-9">
								<select class="form-control" name="pmo_head" id="pmo_head">
									<?php foreach($pmo as $pmos){?>
									<option <?php if (isset($all) && $all->pmo_head == $pmos->val ) echo 'selected' ; ?> value="<?php echo $pmos->val?>"><?php echo $pmos->val?></option>
									<?php }?>
								</select>
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