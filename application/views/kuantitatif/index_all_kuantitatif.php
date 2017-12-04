<?php
$user = $this->session->userdata('user');
$arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
?>
<div class="component_part" style="margin:20px;">
<table class="table display" id="table_ids">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th>No</th>
			<th>Init Code</th>
			<th>Metric</th>
			<?php foreach ($arr_month as $arr) { ?>
			<th>Target <?= $arr ?></th>
			<th>Realisasi <?= $arr ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;
		foreach($all_kuantitatif as $ak){?>
		<tr>
			<td>
				<?php echo $i?>
			</td>
			<td>
				<?php echo $ak->init_code?>
			</td>
			<td>
				<?php echo $ak->metric?>
			</td>
			<?php foreach ($arr_month as $arr) { ?>
			<th><?php echo number_format($ak->$arr,2,",","."); ?></th>
			<th><?php $u_month = 'u_'.$arr; echo number_format($ak->$u_month,2,",","."); ?></th>
			<?php } ?>
		</tr>
		<?php $i++;}?>
	</tbody>
</table>
</div><div style="clear:both"></div>
<hr />
<script>
$(document).ready(function () {
	$('#table_ids').DataTable( {
					dom: 'Bfrtip',
					paging: false,
					buttons: [
							'excelHtml5',
							{
                extend: 'pdfHtml5',
                orientation: 'landscape'
            	}
					]
			} );
});
</script>
