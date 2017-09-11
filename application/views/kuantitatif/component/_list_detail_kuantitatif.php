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
			<th>Final Month Performance</th>
			<th>Final Year End Performance</th>
		</tr>
		<tr style="background-color: yellow;">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=1; foreach($leading as $d) { ?>
	<tr>
		<td><?php echo $i++?></td>
    <td><?php echo $d['prog']->metric;?></td>
    <td><?php echo $d['prog']->measurment;?></td>
		<td><?php echo number_format($d['prog']->baseline,0,",",".");?></td>
		<td><?= $d['update']->$month_view;?></td>
		<td><?php echo number_format($d['target']->$month_view,0,",",".");?></td>
		<td><?php echo number_format($d['prog']->target,0,",",".");?></td>
	</tr>
    <?php } ?>
	</tbody>

	<thead style="background-color: yellow;">
		<tr>
			<th>Lagging</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=1; foreach($lagging->result() as $e) { ?>
	<tr>
		<td><?php echo $i++?></td>
        <td><?php echo $e->metric;?></td>
        <td><?php echo $e->measurment;?></td>
		<td><?php echo $e->target;?></td>
	</tr>
    <?php } ?>
	</tbody>
</table>
<br><br>
