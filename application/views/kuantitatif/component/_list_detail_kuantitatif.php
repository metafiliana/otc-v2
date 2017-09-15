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
			<th colspan="7"><?= $month_view ?> <?= $year_view?></th>
		</tr>
		<tr style="background-color: teal;">
			<th><?= $month_view ?></th>
			<th>Monthly Target</th>
			<th>Year End Target</th>
			<th>Monthly Kinerja</th>
			<th>Year End Kinerja</th>
			<th></th>
		</tr>
		<tr style="background-color: yellow;">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody class="center_text">
	<?php $totmonth=""; $totyear=""; $i=1; foreach($leading as $d) { ?>
	<tr id='kuantitatif_<?= $d['prog']->id ?>'>
		<?php $totmonth += ($d['update']->$month_view/$d['target']->$month_view); ?>
		<?php $totyear += ($d['update']->$month_view/$d['prog']->target); ?>
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
		<td><?php echo number_format((($d['update']->$month_view/$d['target']->$month_view)*100),2,",",".");?> %</td>
		<td><?php echo number_format((($d['update']->$month_view/$d['prog']->target)*100),2,",",".");?> %</td>
		<?php if($user['role']=='2'){?>
			<td>
				<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $d['prog']->init_id?>,'<?php echo $d['prog']->init_code?>',<?php echo $d['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $d['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td>
		<?php }?>
	</tr>
    <?php } ?>
		<hr>
		<tr>
			<td colspan="6" style="background-color:black"></td>
			<td><b>Final</b></td>
			<td>
				<?= number_format(($totmonth*100)/$count_leading,2,",","."); ?> %
			</td>
			<td>
				<?= number_format(($totyear*100)/$count_leading,2,",","."); ?> %
			</td>
		</tr>
	</tbody>

	<thead style="background-color: yellow;">
		<tr>
			<th>Lagging</th>
		</tr>
	</thead>
	<tbody class="center_text">
	<?php $i=1; $totmonth2=""; $totyear2=""; foreach($lagging as $e) { ?>
		<tr>
			<?php $totmonth2 += ($e['update']->$month_view/$e['target']->$month_view); ?>
			<?php $totyear2 += ($e['update']->$month_view/$e['prog']->target); ?>
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
			<td><?php echo number_format(($e['update']->$month_view/$e['target']->$month_view),0,",",".");?> %</td>
			<td><?php echo number_format(($e['update']->$month_view/$e['prog']->target),0,",",".");?> %</td>
			<?php if($user['role']=='2'){?>
				<td>
					<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $e['prog']->init_id?>,'<?php echo $e['prog']->init_code?>',<?php echo $e['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
					<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $e['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			<?php }?>
		</tr>
    <?php } ?>
		<tr>
			<td colspan="6" style="background-color:black"></td>
			<td><b>Final</b></td>
			<td>
				<?= number_format(($totmonth2*100)/$count_leading,2,",","."); ?> %
			</td>
			<td>
				<?= number_format(($totyear2*100)/$count_leading,2,",","."); ?> %
			</td>
		</tr>
	</tbody>
</table>
