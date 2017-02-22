<?php $now2 = $this->uri->segment(2); $now1 = $this->uri->segment(1);?>

<div style="width:100%; background-color:#337ab7; color:white; padding-left:60px; ">
	<!--
	<div class="header_top" style="float:left; margin-right:20px; padding-top:5px;"><img src="<?php echo base_url()?>assets/img/general/mandiri.png" style="width:70px"></div>
	<div class="<?php if($now2 == "overview"){echo "header_active";}else{echo "header_top";}?>" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>general/overview">Overview</a></div>
	<div class="<?php if($now2=="list_programs"){echo "header_active";}else{echo "header_top";}?>" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>initiative/list_programs">Programs</a></div>
	<div class="<?php if(($now1=="initiative" && $now2 !="list_programs")||$now1=="workblock"){echo "header_active";}else{echo "header_top";}?>" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>initiative/list_initiative/Wholesale">Initiatives</a></div>
	<div class="<?php if($now2 =="outlook"){echo "header_active";}else{echo "header_top";}?>" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>general/outlook">Outlook</a></div>
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>logact/">Log</a></div>
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>assets/other/Daftar PIC Wholesale Initiative.pdf">PIC</a></div>
	<div class="<?php if($now2 =="mom"){echo "header_active";}else{echo "header_top";}?>" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>general/mom">MoM</a></div>
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>workblock/detail">Print</a></div>-->
	
	<div class="header_top dropdown" style="float:right; margin-right:20px;">
		<button style="width:40px" class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			<span class="glyphicon glyphicon-cog" style="margin-right:3px"></span>
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" style="right:0; left:auto;" role="menu" aria-labelledby="dropdownMenu1">
		<li role="presentation" class="dropdown-header">Account</li>
		<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>user/form_password">Change Password</a></li>
		<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>user/logout">Logout</a></li>
		<?php if($user['role']=='admin'){?>
		<li class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>user/">User Management</a></li>
		<?php }?>
	  </ul>
	</div>
	<div class="header_top" style="float:right; margin-right:20px;"><?php echo date("d/M/y", strtotime(date('Y-m-d')));?></div>
	<div style="clear:both"></div>
</div>
<?php if($pending){?>
<div class="alert aprv-alert" role="alert" onclick="toggle_visibility('aprv-contentss');">
	<span class="alert-link" disabled>Anda memiliki <?php echo count($pending)?> pending approval milestone</span>
	<div id="aprv-contentss" style="display:none; padding-left:20px; margin-top:10px;">
		<table>
		<?php foreach ($pending as $pend){?>
			<tr><td>
				<div style="margin-bottom:20px">
					<div class="lala"><?php echo $pend->code.". ".$pend->initiative?></div>				
					<div class="lala"><?php echo $pend->workblock?></div>
					<div style="font-size:13;">
						<a href="<?php echo base_url()."workblock/detail_workblock/".$pend->workblock_id."/".$pend->milestone_id?>" style="color:#a94442"><?php echo $pend->milestone?></a>
					</div>
				</div>
			</td></tr>
		<?php }?>
		</table>
	</div>
</div>
<?php }?>

<script>
</script>