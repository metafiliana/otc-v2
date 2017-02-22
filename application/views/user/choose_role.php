<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>

<div id="" class="container no_pad" style="height:100%">
	<div class="col-md-6 login-form" style="margin 0 auto;  position: relative; top: 30%;">
		<form class="form-signin" action="<?php echo base_url();?>user/chooseRole" method="post" role="form" style="width:75%">
			<input type="hidden" value="<?php echo count($roles)?>">
			<h3 class="form-signin-heading">Mandiri Corplan 2020</h3>
			<p class="desc_login_form">Choose Your Role: </p>
			<?php $i=1; foreach($roles as $role){?>
				<input type="submit" class="btn btn-lg btn-info btn-block" name="<?php echo "role_"$i?>" value="Log In as <?php echo $role?>">
			<?php }?>
		</form>
		
	</div>
	<div class="col-md-6" style="margin: 0 auto; position: relative; top: 15%;">
		<div style="float:right;">
			<img src="<?php echo base_url()?>assets/img/general/mandiri.png" style="width:190px"><br>
			<label style="font-size:21px">Mandiri Corplan 2020</label><br>
		</div><div style="clear:both"></div>
		<div style="margin-top:20px"><img src="<?php echo base_url()?>assets/img/general/Transformasi.png" style="width:100%"></div>
	</div>
</div>