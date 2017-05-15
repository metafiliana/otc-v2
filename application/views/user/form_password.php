<div style="padding:5px">
	<div id="succeed" class="alert alert-success col-md-12" style="display:none; height:40px; padding:10px;"><span class="glyphicon glyphicon-ok-sign"></span> <label id="succeed-message"></label></div>
	<h4>Change Password</h4><hr>
	<form class="form-horizontal" action="<?php echo base_url();?>user/change_password" method ="post" id="formpsswd" role="form">
		<div class="form-group">
			<label class="col-sm-2 control-label">Old Password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="password_old" name="password_old" placeholder="Old Password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">New Password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="password_new" name="password_new" placeholder="New Password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Confirm Password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="verify_password_new" name="verify_password" placeholder="Confirm Password">
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-4">
				<button class="btn btn-md btn-success" type="submit">Update Password</button><div id="pass_pw"></div>
			</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		var response2;
		$("#formpsswd").validate({
			rules: {
				password_old: {
					required: true,
					ispasswordtrue: true
				},
				password_new: {
					required: true,
					minlength: 5
				},
				verify_password: {
					required: true,
					equalTo: "#password_new"
				}
			},
			messages: {
				password_new: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				verify_password: {
					equalTo: "Please enter the same password as above"
				}
			}
		
		});
		$("#formpsswd").ajaxForm({	
			beforeSubmit: function() 
    		{
    			please_wait_msg("pass_pw");
    		},
			success: function(resp) 
			{
				if(resp.status==1){
					$("#pass_pw").html('');
					alert('Password was successfully updated');
					$("#formpsswd")[0].reset();
					//location.reload(config.base+'home');
				}
			},
		});
	});
</script>