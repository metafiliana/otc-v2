<table class="table table-hover table-striped">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th>No</th>
			<th>Initiative</th>
			<th>Sign</th>
			<th>Total %</th>
			<th>Kuantitatif</th>
			<th>Kualitatif</th>
		</tr>
	</thead>
	<tbody>
		<?php $pv_init = ""; foreach($programs as $prog){?>
		<tr>
			<?php $i=0; if($pv_init != $prog['prog']->segment){?>
			<td><?php echo $prog['prog']->init_code?></td>
			<td><?php echo $prog['prog']->segment?></td>
			<?php $pv_init = $prog['prog']->segment;}?>
			<td>
			<?php if($prog['wb_total']==0){ ?>
				<span style="font-size:14px; color:<?php echo color_status('Not Started Yet')?>; font-weight:bold">No Action</span>
			<?php } else{ ?>
			<?php if(($prog['wb_status']['complete']/$prog['wb_total'])*100==0){ ?>
				<span style="font-size:14px; color:<?php echo color_status('Delay')?>; font-weight:bold">Delay</span>
			<?php } else{ ?>
				<span style="font-size:14px; color:<?php echo color_status($prog['init_status'])?>; font-weight:bold"><?php echo $prog['init_status']?></span>
			<?php } }?> </td>
			<td><?php if($prog['total']!=null && $prog['tot_kual']!=null && isset($prog['tot_kual'])){echo (number_format((($prog['total']+$prog['tot_kual'])/2), 2, ',', ' ')).'%';}else{}?></td>
		</tr>
		<?php }?>
	</tbody>
</table>