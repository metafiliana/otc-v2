<div style="margin-top:50px;">
	<div style="padding-left:20px">
		<div style="margin-bottom:10px; margin-left:10px;"><img src="<?php echo base_url();?>assets/img/general/no-profile-img.gif" alt="..." class="img-circle" style="height:80px;"></div>
		<div style="font-size:13px;"><?php echo $user['name']?></div>
		<div style="font-size:11px;"><?php echo $user['role']?></div>
	</div>
	<hr style="margin:10px 0 0 0">
	<ul class="nav" id="side-menu">
		<li>
			<a href="<?php echo base_url()?>general/overview"><i class="fa fa-lightbulb-o fa-fw"></i> Overview</a>
		</li>
		<li>
			<a href="<?php echo base_url()?>initiative/segment"><i class="fa fa-sitemap fa-fw"></i> Segment</a>
		</li>
		<li>
			<a href="<?php echo base_url()?>program/list_programs/"><i class="fa fa-dashboard fa-fw"></i> Programs</a>
		</li>
		<!--<li>
			<a href="<?php echo base_url()?>initiative/list_initiative/Wholesale"><i class="fa fa-bar-chart-o fa-fw"></i> Initiative</a>
		</li>-->
		<li>
			<a href="<?php echo base_url()?>general/outlook"><i class="fa fa-table fa-fw"></i> Outlook</a>
		</li>
		<li>
			<a href="<?php echo base_url()?>logact"><i class="fa fa-edit fa-fw"></i> Log</a>
		</li>
		<li>
			<a href="<?php echo base_url()?>general/mom"><i class="fa fa-file-text fa-fw"></i> MoM</a>
		</li>
		<li>
			<a href="<?php echo base_url()?>agenda"><i class="fa fa-calendar fa-fw"></i> Agenda</a>
		</li>
		
	</ul>
</div>