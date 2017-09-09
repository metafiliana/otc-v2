<table class="table display" >
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="width: 50px;">No</th>
			<th>KPI Metric</th>
			<th>Measurement</th>
			<th><?= $month_view ?></th>
			<th>Mothly Target</th>
			<th>Year End Target</th>
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
		<td><?= $d['update']->$month_view;?></td>
		<td><?php echo number_format($d['prog']->$month_view,0,",",".");?></td>
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
