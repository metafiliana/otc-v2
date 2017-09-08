<table class="table display" >
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="width: 50px;">No</th>
			<th>KPI Metric</th>
			<th>Measurement</th>
			<th>Target</th>
		</tr>
		<tr style="background-color: yellow;">
			<th>Leading</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=1; foreach($leading->result() as $d) { ?>
	<tr>
		<td><?php echo $i++?></td>
        <td><?php echo $d->metric;?></td>
        <td><?php echo $d->measurment;?></td>
		<td><?php echo $d->target;?></td>
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
<script>
$(document).ready(function () {
	$('#table_id_<?= $id ?>').DataTable( {
					dom: 'Bfrtip',
					paging: false,
					buttons: [
							'excelHtml5',
							'pdfHtml5',
					]
			} );
});

</script>