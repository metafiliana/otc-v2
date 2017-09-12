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
		</tr>
		<tr style="background-color: yellow;">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody>
	<?php $totmonth=""; $totyear=""; $i=1; foreach($leading as $d) { ?>
	<tr>
		<?php $totmonth += ($d['update']->$month_view/$d['target']->$month_view); ?>
		<?php $totyear += ($d['update']->$month_view/$d['prog']->target); ?>
		<td><?php echo $i++?></td>
    <td><?php echo $d['prog']->metric;?></td>
    <td><?php echo $d['prog']->measurment;?></td>
		<td><?php echo number_format($d['prog']->baseline,0,",",".");?></td>
		<td><?= $d['update']->$month_view;?></td>
		<td><?php echo number_format($d['target']->$month_view,0,",",".");?></td>
		<td><?php echo number_format($d['prog']->target,0,",",".");?></td>
		<td><?php echo number_format((($d['update']->$month_view/$d['target']->$month_view)*100),2,",",".");?> %</td>
		<td><?php echo number_format((($d['update']->$month_view/$d['prog']->target)*100),2,",",".");?> %</td>
	</tr>
    <?php } ?>
		<hr>
		<tr>
			<td colspan="7">Final</td>
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
	<tbody>
	<?php $i=1; $totmonth2=""; $totyear2=""; foreach($lagging as $e) { ?>
		<tr>
			<?php $totmonth2 += ($e['update']->$month_view/$e['target']->$month_view); ?>
			<?php $totyear2 += ($e['update']->$month_view/$e['prog']->target); ?>
			<td><?php echo $i++?></td>
	    <td><?php echo $e['prog']->metric;?></td>
	    <td><?php echo $e['prog']->measurment;?></td>
			<td><?php echo number_format($e['prog']->baseline,0,",",".");?></td>
			<td><?= $e['update']->$month_view;?></td>
			<td><?php echo number_format($e['target']->$month_view,0,",",".");?></td>
			<td><?php echo number_format($e['prog']->target,0,",",".");?></td>
			<td><?php echo number_format(($e['update']->$month_view/$e['target']->$month_view),0,",",".");?> %</td>
			<td><?php echo number_format(($e['update']->$month_view/$e['prog']->target),0,",",".");?> %</td>
		</tr>
    <?php } ?>
		<tr>
			<td colspan="7">Final</td>
			<td>
				<?= number_format(($totmonth2*100)/$count_leading,2,",","."); ?> %
			</td>
			<td>
				<?= number_format(($totyear2*100)/$count_leading,2,",","."); ?> %
			</td>
		</tr>
	</tbody>
</table>
<br><br>
