<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<style>
	body{
		margin:0;padding:20px 430px 20px 430px;
		background-size:cover;
		background-image:url('<?php echo base_url()?>assets/img/BG.png');
		opacity: 0.9;
	}
	.container{
		background-color: white;
		border-radius: 5px;
		padding-bottom: 20px;
		padding-left: 20px;
		padding-right: 20px;
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
	<div class="col-md-2">
	</div>
	<div class="col-md-8 login-form container" style="position: relative; margin-top: 5%;">
		<form class="form-signin" action="<?php echo base_url();?>user/userEnter" method="post" role="form">
			<div class="center_text">
				<img style="height:80px; margin-left:0px; padding-top: 5px; text-align: center;" src="<?php echo base_url()?>assets/img/general/tower.png">
			<h3 class="center_text">Restart Corplan</h3></div>
			<p class="desc_login_form" style="padding-top: 10px;">Username</p>
			<input type="text" class="form-control" placeholder="" name="username" id="username" required autofocus style="border-radius: 7px;">
			<p style="margin-top:5px;" class="desc_login_form">Password</p>
			<input style="border-radius: 7px;" type="password" class="form-control" placeholder="" name="password" required style="margin-bottom: 15px;">
			<button style="margin-top:15px; width: 150px; float: right;" class="btn btn-lg btn-info btn-block center_text" type="submit" style="border-radius: 7px;">Log In</button>
		</form>
		<?php if($params){?>
		<div class="login_alert" style="margin-top:70px;">
			<div id="login_failed" class="alert alert-danger fade in center_text" style="margin-right: 15px; margin-left: 15px;">  
				<a class="close" data-dismiss="alert">×</a>  
				<strong style="text-align: center;">Login Failed ! Username and Password do not match.</strong>
			</div>
		</div>
		<?php }?>
	</div>
	<div class="col-md-2">
			
		</div>
</div>