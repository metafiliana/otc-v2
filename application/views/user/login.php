<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<style>
	body{
		margin:0;padding:20px 430px 20px 430px;
		background-size:cover;
		background-image:url('<?php echo base_url()?>assets/img/tower.jpg');
		opacity: 0.9;
		
	}
</style>
<script>
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}
});
</script>

<div style="height:100%;">
	<div class="col-md-12 login-form" style="margin 0 auto;  position: relative; top: 30%;">
		<form class="form-signin" action="<?php echo base_url();?>user/userEnter" method="post" role="form" style="width:100%; margin-top:150px;">
			<h3 class="center_text">Control Tower</h3>
			<p class="desc_login_form">Username:</p>
			<input type="text" class="form-control" placeholder="" name="username" id="username" required autofocus>
			<p style="margin-top:5px;" class="desc_login_form">Password:</p>
			<input type="password" class="form-control" placeholder="" name="password" required>
			<button style="margin-top:10px;" class="btn btn-lg btn-info btn-block" type="submit">Log In</button>
		</form>
		<?php if($params){?>
		<div class="login_alert" style="margin-top:20px;">
			<div id="login_failed" class="alert alert-danger fade in">  
				<a class="close" data-dismiss="alert">×</a>  
				<strong>Login Failed ! </strong> Username and Password do not match.
			</div>
		</div>
		<?php }?>
	</div>
</div>