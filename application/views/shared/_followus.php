<hr>
<style>
	.sosmed{
		margin-top:10px;
	}
	a{
		color:#111;
	}
</style>
<div style="width:800px; margin-bottom:20px;">
	<h4 style="margin-bottom:25px">Follow Us On:</h4>
	<?php foreach($sosmed as $s){ if($s->text){?>
		<div class="sosmed"><img src="<?php echo base_url()?>assets/img/social/<?php echo $s->logo?>">
		<span> <?php if($s->link){?><a target="_blank" href="<?php echo $s->link?>"><?php echo $s->text?></a><?php }else{?><?php echo $s->text?><?php }?></span></div>
	<?php }}?>
	<div style="clear:both"></div>
</div>