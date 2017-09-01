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
	.title{
		margin: 20px 0 0 0;
		padding-top: 10px;
		padding-bottom: 20px;
		background-color: rgb(35,95,111);
	}
	.recover{
		margin: 20px 0 0 0;
		padding-top: 10px;
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
	<div class="col-md-2">

	</div>

	<div class="col-md-8 login-form container" style="position: relative; margin-top: 5%;">
		<a href="<?php echo base_url();?>user/login" style="text-decoration:none;"><button style="margin-top: 15px; float: left;" class="btn btn-sm btn-default center_text submit" style="border-radius: 7px;">Back</button></a>

	<div class="center_text recover" style="margin-top: 40px;">
		<h3 style="color: rgb(35,95,111); font-weight: bold;">RECOVER PASSWORD</h3>
	</div>
		<form class="form-signin" action="<?php echo base_url();?>user/sendMail" method="post" role="form">
			<p class="desc_login_form center_text" style="padding-top: 10px; margin-bottom: 30px;">Please enter your username, and we will email you updated login detail</p>

			<?php if($this->session->flashdata('email_sent')): ?>
			<div class="alert alert-success alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			    <p><?php echo $this->session->flashdata('email_sent'); ?></p>
			</div>
			<?php elseif($this->session->flashdata('error')) : ?>
    		<div class="alert alert-danger alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			    <p><?php echo $this->session->flashdata('error'); ?></p>
			</div>
			<?php endif; ?>

			<input type="text" class="form-control" placeholder="" name="username" id="username" required autofocus style="border-radius: 7px;">
			<button style="margin-top:30px; width: 150px;" class="btn btn-md btn-primary btn-block center_text submit" type="submit" style="border-radius: 7px;">Submit</button>
		</form>

	<div style="text-align: center; margin-top: 10px;">
		<a data-toggle="modal" data-target="#myModal">>>Contact Us</a>
	</div>

	</div>
	<div class="col-md-2">

	</div>

	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="text-align: center;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">PT Bank Mandiri Tbk</h4>
      </div>
      <div class="modal-body">
        <p>Jl. Gatot Subroto Kav. 36-38
		Plaza Mandiri lantai 18, CTF
		<br>Jakarta Selatan, 12190</p>
		<p>Email : PMO Control Tower (control.tower@bankmandiri.co.id)</p><br>
		<p>Team : <br>
		Tongki Lentari (712 3471)<br>
		Dessy Damayanti (712 7807)<br>
		Nurul Y. Karunia (712 7263)<br>
		Santy Supriyani (712 3076)</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</div>
