<?php
$user = $this->session->userdata('user');
?>
<div class="panel panel-default" style="margin-top: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
<div class="panel-body">
<table class="table table-hover table-responsive">
	<thead class="black_color">
		<tr>
			<th style="width: 50px; vertical-align: middle;" rowspan="2">No</th>
			<th rowspan="2" style="vertical-align: middle;">KPI Metric</th>
			<th rowspan="2" style="vertical-align: middle;">Measurement</th>
			<th rowspan="2" style="vertical-align: middle;">Baseline <br> <?= $year_view-1 ?></th>
			<?php if($user['role']=='1'){?>
			<th colspan="9" style="vertical-align: middle;"><?= $month_view ?> <?= $year_view?></th>
			<?php } else {?>
			<th colspan="8" style="vertical-align: middle;"><?= $month_view ?> <?= $year_view?></th>
			<?php } ?>
		</tr>
		<tr>
			<th><?= $month_view ?></th>
			<?php if($user['role']=='1'|| $user['role']=='2'){?>
			<th></th>
			<?php }?>
			<th>Monthly Target</th>
			<th>Year End Target</th>
			<th>Monthly Kinerja</th>
			<th>Year End Kinerja</th>
			<th>YTD</th>
			<th>Full Year(FY)</th>
			<th></th>
		</tr>
		<tr class="orange_color_bg">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody class="center_text">
	<?php $check=0; $i=1; foreach($leading as $d) { ?>
	<tr id='kuantitatif_<?= $d['prog']->id ?>'>
		<td><?php echo $i++?></td>
    <td><?php echo $d['prog']->metric;?></td>
    <td><?php echo $d['prog']->measurment;?></td>
		<td><?php if($d['prog']->measurment=='%' || $d['prog']->measurment=="Index" || $d['prog']->measurment=="product/customer"){ echo number_format($d['prog']->baseline,2,",","."); } else{ echo number_format($d['prog']->baseline,0,",","."); }?></td>
		<td>
			<?php if($d['prog']->measurment=='%' || $d['prog']->measurment=="Index" || $d['prog']->measurment=="product/customer"){ echo number_format($d['update']->$month_view,2,",","."); } else{echo number_format($d['update']->$month_view,0,",","."); } ?>
		</td>
		<?php if($user['role']=='1' || $user['role']=='2'){?>
		<td>
			<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $d['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
		</td>
		<?php }?>
		<td><?php if($d['prog']->measurment=='%' || $d['prog']->measurment=="Index" || $d['prog']->measurment=="product/customer"){ echo number_format($d['target']->$month_view,2,",","."); } else{ echo number_format($d['target']->$month_view,0,",",".");}?></td>
		<td><?php if($d['prog']->measurment=='%' || $d['prog']->measurment=="Index" || $d['prog']->measurment=="product/customer"){ echo number_format($d['prog']->target,2,",","."); } else { echo number_format($d['prog']->target,0,",","."); }?></td>
		<td><?php echo number_format((($d['month_kiner'])*100),0,",",".");?> %</td>
		<td><?php echo number_format((($d['year_kiner'])*100),0,",",".");?> %</td>
		<?php if($check==0){ ?>
			<td rowspan="<?= $count_leading ?>" style="vertical-align: middle;">
				<div class=circle style='background:<?= warna(($tot_leading['month']*100)/$count_leading)?>'></div>
				<?= number_format(($tot_leading['month']*100)/$count_leading,2,",","."); ?> %
			</td>
			<td rowspan="<?= $count_leading ?>" style="vertical-align: middle;">
				<div class=circle style='background:<?= warna(($tot_leading['year']*100)/$count_leading)?>'></div>
				<?= number_format(($tot_leading['year']*100)/$count_leading,2,",","."); ?> %
			</td>
		<?php } ?>
		<?php if($user['role']=='2'){?>
			<td>
				<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $d['prog']->init_id?>,'<?php echo $d['prog']->init_code?>',<?php echo $d['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $d['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td>
		<?php }?>
	</tr>
    <?php $check=1; } ?>

	</tbody>

	<tr class="orange_color_bg">
		<th>Lagging</th>
	</tr>
	<tbody class="center_text">
	<?php $check=0; $i=1; foreach($lagging as $e) { ?>
		<tr id='kuantitatif_<?= $e['prog']->id ?>'>
			<td><?php echo $i++?></td>
	    <td><?php echo $e['prog']->metric;?></td>
	    <td><?php echo $e['prog']->measurment;?></td>
			<td><?php if($e['prog']->measurment=='%'|| $e['prog']->measurment=="Index" || $e['prog']->measurment=="product/customer"){ echo number_format($e['prog']->baseline,2,",","."); } else { echo number_format($e['prog']->baseline,0,",","."); }?></td>
			<td>
				<?php if($e['prog']->measurment=='%'|| $e['prog']->measurment=="Index" || $e['prog']->measurment=="product/customer"){ echo number_format($e['update']->$month_view,2,",","."); } else{ echo number_format($e['update']->$month_view,0,",","."); }?>
			</td>
			<?php if($user['role']=='1'|| $user['role']=='2'){?>
			<td>
					<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $e['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
			</td>
			<?php }?>
			<td><?php if($e['prog']->measurment=='%' || $e['prog']->measurment=="Index" || $e['prog']->measurment=="product/customer"){ echo number_format($e['target']->$month_view,2,",","."); } else{ echo number_format($e['target']->$month_view,0,",","."); }?></td>
			<td><?php if($e['prog']->measurment=='%'|| $e['prog']->measurment=="Index" || $e['prog']->measurment=="product/customer"){ echo number_format($e['prog']->target,2,",","."); } else{ echo number_format($e['prog']->target,0,",","."); }?></td>
			<td><?php echo number_format(($e['month_kiner']*100),0,",",".");?> %</td>
			<td><?php echo number_format(($e['year_kiner']*100),0,",",".");?> %</td>
			<?php if($check==0){ ?>
				<td rowspan="<?= $count_lagging ?>" style="vertical-align: middle;">
					<div class=circle style='background:<?= warna(($tot_lagging['month']*100)/$count_lagging)?>'></div>
					<?= number_format(($tot_lagging['month']*100)/$count_lagging,2,",","."); ?> %
				</td>
				<td rowspan="<?= $count_lagging ?>" style="vertical-align: middle;">
					<div class=circle style='background:<?= warna(($tot_lagging['year']*100)/$count_lagging)?>'></div>
					<?= number_format(($tot_lagging['year']*100)/$count_lagging,2,",","."); ?> %
				</td>
			<?php } ?>
			<?php if($user['role']=='2'){?>
				<td>
					<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $e['prog']->init_id?>,'<?php echo $e['prog']->init_code?>',<?php echo $e['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
					<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $e['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			<?php }?>
		</tr>
    <?php $check=1;} ?>

	</tbody>
</table>
</div>
</div>
