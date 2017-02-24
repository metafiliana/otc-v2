<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
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

<div id="" class="container no_pad" style="height:100%;">
	<div class="col-md-6 login-form" style="margin 0 auto;  position: relative; top: 30%;">
		<form class="form-signin" action="<?php echo base_url();?>user/userEnter" method="post" role="form" style="width:75%">
			<img src="<?php echo base_url()?>assets/img/general/dreamworks.png" style="width:100%"><br>
			<p class="desc_login_form">Please login here: </p>
			<input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
			<input type="password" class="form-control" placeholder="Password" name="password" required>
			<button class="btn btn-lg btn-info btn-block" type="submit">Log In</button>
		</form>
		<?php if($params){?>
		<div class="login_alert" style="margin-top:20px;">
			<div id="login_failed" class="alert alert-danger fade in">  
				<a class="close" data-dismiss="alert">×</a>  
				<strong>Login Failed ! </strong> Username and password do not match
			</div>
		</div>
		<?php }?>
	</div>
	<div class="col-md-6" style="margin: 0 auto; position: relative; top: 15%;">
		<div style="float:right; margin-top:-70px; margin-bottom:70px;">
			<img src="<?php echo base_url()?>assets/img/general/mandiri.png" style="width:190px"><br>
		</div><div style="clear:both"></div>
		<div style="margin-top:10px"><img src="<?php echo base_url()?>assets/img/general/Transformasi.png" style="width:100%"></div>
	</div>
</div>