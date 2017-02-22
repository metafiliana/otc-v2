<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>

<script>
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}
        
    $("#formsignup").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				//required: true,
				minlength: 5
			},
			verify_password: {
				//required: true,
				equalTo: "#password"
			},
			name: "required",
		},
		messages: {
			username: {
				required: "Please enter an username"
			},
			password_su: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			verify_password: {
				required: "Please provide a password",
				equalTo: "Please enter the same password as above"
			},
			agree: "Please accept our policy"
		}
	});     
});
</script>

<div id="" class="container no_pad">
	<div class="col-md-7">
		<div class="form-signin">
		<h3 class="form-signin-heading">New User</h3>
		<p class="desc_login_form">Enter new user</p>
		<form class="form-horizontal" action="<?php if($info){echo base_url()."user/register/".$info->id;}else{echo base_url()."user/register";}?>" method ="post" id="formsignup" role="form">
			 <div class="form-group">
				<label class="col-sm-3 control-label">Name</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php if($info){echo $info->name;}?>">
				</div>
			</div>
			 <div class="form-group">
				<label class="col-sm-3 control-label">Username</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php if($info){echo $info->username;}?>">
				</div>
			</div>
			<?php if(!$info){?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Confirm Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Confirm Password">
				</div>
			</div>
			<?php }?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Role</label>
				<div class="col-sm-9">
					<select id="" class="form-control" name="role">
						<option value='PIC' <?php if($info){if($info->role=="PIC"){echo "selected";}}?>>PIC</option>
						<option value='PMO' <?php if($info){if($info->role=="PMO"){echo "selected";}}?>>PMO</option>
						<option value='PIC,PMO' <?php if($info){if($info->role=="PIC,PMO"){echo "selected";}}?>>PIC,PMO</option>
						<option value='admin' <?php if($info){if($info->role=="admin"){echo "selected";}}?>>Admin</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Jabatan</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" value="<?php if($info){echo $info->jabatan;}?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Unit Kerja</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="unitkerja" name="unitkerja" placeholder="Unit Kerja" value="<?php if($info){echo $info->unitkerja;}?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Segment</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="segment" name="segment" placeholder="Segment" value="<?php if($info){echo $info->segment;}?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Initiative</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="initiative" name="initiative" placeholder="Initiative" value="<?php if($info){echo $info->initiative;}?>">
				</div>
			</div>
			<hr>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
		</form>
	</div>
</div>
</div>