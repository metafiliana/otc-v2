<?php
$user = $this->session->userdata('user');
?>
<table class="table display" >
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="width: 50px;" rowspan="2">No</th>
			<th rowspan="2">KPI Metric</th>
			<th rowspan="2">Measurement</th>
			<th rowspan="2">Baseline <?= $year_view-1 ?></th>
			<th colspan="8"><?= $month_view ?> <?= $year_view?></th>
		</tr>
		<tr style="background-color: teal;">
			<th><?= $month_view ?></th>
			<th>Monthly Target</th>
			<th>Year End Target</th>
			<th>Monthly Kinerja</th>
			<th>Year End Kinerja</th>
			<th>Sign Monthly</th>
			<th>Sign Year End</th>
			<th></th>
		</tr>
		<tr style="background-color: yellow;">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody class="center_text">
	<?php $check=0; $i=1; foreach($leading as $d) { ?>
	<tr id='kuantitatif_<?= $d['prog']->id ?>'>
		<td><?php echo $i++?></td>
    <td><?php echo $d['prog']->metric;?></td>
    <td><?php echo $d['prog']->measurment;?></td>
		<td><?php echo number_format($d['prog']->baseline,0,",",".");?></td>
		<td>
			<?= number_format($d['update']->$month_view,0,",",".");?>
			<?php if($user['role']=='1'){?>
				<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $d['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
			<?php }?>
		</td>
		<td><?php echo number_format($d['target']->$month_view,0,",",".");?></td>
		<td><?php echo number_format($d['prog']->target,0,",",".");?></td>
		<td><?php echo number_format((($d['month_kiner'])*100),0,",",".");?> %</td>
		<td><?php echo number_format((($d['year_kiner'])*100),0,",",".");?> %</td>
		<?php if($user['role']=='2'){?>
			<td>
				<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $d['prog']->init_id?>,'<?php echo $d['prog']->init_code?>',<?php echo $d['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $d['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td>
		<?php }?>
		<?php if($check==0){ ?>
			<td rowspan="<?= $count_leading ?>" style="vertical-align: middle;">
				<?= number_format(($tot_leading['month']*100)/$count_leading,2,",","."); ?> %
			</td>
			<td rowspan="<?= $count_leading ?>" style="vertical-align: middle;">
				<?= number_format(($tot_leading['year']*100)/$count_leading,2,",","."); ?> %
			</td>
		<?php } ?>
	</tr>
    <?php $check=1; } ?>
		<hr>
	</tbody>

	<thead style="background-color: yellow;">
		<tr>
			<th>Lagging</th>
		</tr>
	</thead>
	<tbody class="center_text">
	<?php $check=0; $i=1; foreach($lagging as $e) { ?>
		<tr>
			<td><?php echo $i++?></td>
	    <td><?php echo $e['prog']->metric;?></td>
	    <td><?php echo $e['prog']->measurment;?></td>
			<td><?php echo number_format($e['prog']->baseline,0,",",".");?></td>
			<td>
				<?= number_format($e['update']->$month_view,0,",",".");?>
				<?php if($user['role']=='1'){?>
					<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $e['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
				<?php }?>
			</td>
			<td><?php echo number_format($e['target']->$month_view,0,",",".");?></td>
			<td><?php echo number_format($e['prog']->target,0,",",".");?></td>
			<td><?php echo number_format(($e['month_kiner']*100),0,",",".");?> %</td>
			<td><?php echo number_format(($e['year_kiner']*100),0,",",".");?> %</td>
			<?php if($user['role']=='2'){?>
				<td>
					<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $e['prog']->init_id?>,'<?php echo $e['prog']->init_code?>',<?php echo $e['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
					<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $e['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			<?php }?>
			<?php if($check==0){ ?>
				<td rowspan="<?= $count_lagging ?>" style="vertical-align: middle;">
					<?= number_format(($tot_lagging['month']*100)/$count_lagging,2,",","."); ?> %
				</td>
				<td rowspan="<?= $count_lagging ?>" style="vertical-align: middle;">
					<?= number_format(($tot_lagging['year']*100)/$count_lagging,2,",","."); ?> %
				</td>
			<?php } ?>
		</tr>
    <?php $check=1;} ?>
	</tbody>
</table>
