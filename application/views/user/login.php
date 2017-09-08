<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<style>
	body{
		margin:0;
		background-image:url('<?php echo base_url()?>assets/img/BG.png');
		background-size: cover;
	    background-repeat: no-repeat;
	    background-position: 50% 50%;
	}
	.container{
		width: 25%;
		margin-left: 20%;
		background-color: white;
		border-radius: 5px;
		padding-bottom: 35px;
		padding-left: 20px;
		padding-right: 20px;
	}
	.title{
		margin: 20px 0 0 0;
		padding-top: 10px;
		padding-bottom: 20px;
		background-color: rgb(35,95,111);
	}
	.submit{
		margin: 0 auto;
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
	<div class="col-md-8 login-form container" style="position: relative; margin-top: 5%;">
		<div class="center_text title">
			<h3 style="color: rgb(228,108,10); font-weight: bold;">PMO CORPLAN</h3>
			<h4 style="color: white;">TOP BOD LEVEL INITIATIVES</h4>
		</div>
		<form class="form-signin" action="<?php echo base_url();?>user/userEnter" method="post" role="form">
			<p class="desc_login_form" style="padding-top: 10px;">Username</p>
			<input type="text" class="form-control" placeholder="" name="username" id="username" required autofocus style="border-radius: 7px;">
			<p style="margin-top:5px;" class="desc_login_form">Password</p>
			<input style="border-radius: 7px;" type="password" class="form-control" placeholder="" name="password" required style="margin-bottom: 15px;">
			<button style="margin-top:30px; width: 150px;" class="btn btn-lg btn-primary btn-block submit center_text" type="submit" style="border-radius: 7px;">Log In</button>
		</form>
		<div style="text-align: center; margin-top: 10px;">
			<a href="<?php echo base_url();?>user/troublelogin">>>Trouble Logging in ?</p>
		</div>
		<?php if($params){?>
		<div class="login_alert">
			<div id="login_failed" class="alert alert-danger fade in center_text" style="margin-right: 15px; margin-left: 15px;">  
				<a class="close" data-dismiss="alert">×</a>  
				<strong style="text-align: center;">Login Failed ! Username and Password do not match.</strong>
			</div>
		</div>
		<?php }?>
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-2">
			
		</div>
</div>