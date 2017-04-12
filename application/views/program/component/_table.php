<?php
$user = $this->session->userdata('user');
?>
<table class="table table-hover table-striped">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="vertical-align:middle" rowspan=2>Workstream</th>
			<th style="vertical-align:middle">Last Update</th>
			<th style="vertical-align:middle">Status</th>
			<th style="vertical-align:middle"><center>Completed</center></th>
			<th rowspan=2>
				<?php if($user['role']=='admin'){?><div style="margin-bottom:10px; float:right;">
					<a onclick="show_form();" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Sub Initiative</a>
				</div><?php }?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$segment=""; $i=1; $segnum=1;
		$pv_init = ""; $total_percent="";
		foreach($programs as $prog){?>
		<tr id="prog_<?php echo $prog['prog']->id?>">
			<td style="width:400px" id="detail_<?php echo $prog['prog']->segment?>" style="display:none;">
				<div style="float:left; width:50px; margin-right:5px;"><?php echo substr($prog['prog']->code, -1)?></div> 
				<div style="float:left; max-width:300px"><a href="<?php echo base_url()?>initiative/list_program_initiative/<?php echo $prog['prog']->id ?>"><?php echo $prog['prog']->title?></a></div>
				<div style="clear:both"></div>
			</td>
			<td>
				<div class="center_text" style="float:left; width:100px;"><?php if(isset($prog['lu']->last_update)) echo date("j F Y G:i:s",strtotime($prog['lu']->last_update));?></div> 
			</td>
			<td class="center_text">
				<?php if($prog['wb_total']==0){ ?>
				<span style="font-size:14px; color:<?php echo color_status('Not Started Yet')?>; font-weight:bold">No Action</span>
				<?php } else{ ?>
				<span style="font-size:14px; color:<?php echo color_status($prog['init_status'])?>; font-weight:bold"><?php echo $prog['init_status']?></span>
				<?php } ?> 
			</td>
			<td class="center_text"><?php if($prog['wb_total']==0){"0";}else{ echo number_format((($prog['wb_status']['complete']/$prog['wb_total'])*100),2);}?>%</td>
			<?php if($user['role']=='admin'){?><td style="width:50px">
				<a class="btn btn-link btn-link-edit" onclick="show_form(<?php echo $prog['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_program(<?php echo $prog['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td><?php }?>
		</tr>
		<?php $i++;}?>
	</tbody>
</table>