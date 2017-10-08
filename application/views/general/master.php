<?php
$user = $this->session->userdata('user');
?>

<div class="row" style="padding: 20px 10px 0 10px;">
<div class=col-md-2>
	<h3>Master Cluster</h3>
	<table class="table display" style="margin-top:10px;">
		<thead class="black_color old_grey_color_bg">
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($cluster as $clus){  ?>
			<tr id="">
				<td>
					<?php echo $clus->id?>
				</td>
				<td>
					<?php echo $clus->title?>
				</td>
				<td class="center_text">
					test
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<hr />
</div>
<div class=col-md-7>
	<h3>Master Initiative</h3>
	<table class="table display" style="margin-top:10px;">
		<thead class="black_color old_grey_color_bg">
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Deskripsi</th>
				<th>Aspirasi</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($initiative as $init){  ?>
			<tr id="">
				<td>
					<?php echo $init->id?>
				</td>
				<td>
					<?php echo $init->title?>
				</td>
				<td class="center_text">
					<?php echo $init->deskripsi?>
				</td>
				<td class="center_text">
					<?php echo $init->aspirasi?>
				</td>
				<td class="center_text">
					edit
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<hr />
</div>
<div class=col-md-3>
	<h3>Kuantitatif Legend</h3>
	<table class="table display" style="margin-top:10px;">
		<thead class="black_color old_grey_color_bg">
			<tr>
				<th>Id</th>
				<th>Initiative Name</th>
				<th>Type</th>
				<th>Metric</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($kuan_legend as $kl){ ?>
				<tr id="">
					<td>
						<?php echo $kl->klid?>
					</td>
					<td>
						<?php echo $kl->title?>
					</td>
					<td class="center_text">
						<?php echo $kl->type?>
					</td>
					<td class="center_text">
						<?php echo $kl->metric?>
					</td>
					<td class="center_text">
						asd
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<hr />
</div>
</div>
<div style="clear:both"></div>

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
