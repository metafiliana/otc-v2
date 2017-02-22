<?php $user = $this->session->userdata('user'); ?>
<div style="margin-top:75px;" class="grey_color">
	<div style="padding-left:20px">
		<div style="margin-bottom:10px; margin-left:10px;"><img src="<?php echo base_url();?>assets/img/general/no-profile-img.gif" alt="..." class="img-circle" style="height:80px;"></div>
		<div class="black_color" style="font-size:13px;"><?php echo $user['name']?></div>
		<div class="black_color" style="font-size:11px;"><?php echo $user['role']?></div>
	</div>
	<hr style="margin:10px 0 0 0">
	<ul class="nav" id="side-menu">
		<li>
			<a class="black_color" href="<?php echo base_url()?>home"><span class="btn-lg glyphicon glyphicon-home"></span> Home</a>
		</li>
		
		<li>
			<a class="black_color" href="<?php echo base_url()?>user/logout"><span class="btn-lg glyphicon glyphicon-off"></span> Log Out</a>
		</li>
		<?php if($user['role']=='admin'){?>
		<li>
			<a class="black_color" href="<?php echo base_url()?>user/"><span class="btn-lg glyphicon glyphicon-cog"></span> User Management</a>
		</li>
		<?php }?>
	</ul>
</div>
