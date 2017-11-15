<?php
$user = $this->session->userdata('user');
?>
<table class="table display" id="table_id_<?= $id ?>">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th>No</th>
			<th>Title</th>
			<th>Status</th>
			<th>Starting Date</th>
			<th>Completed Date</th>
			<th>Notes</th>
			<?php if($user['role']=='1'){?>
				<th style="vertical-align:middle"></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;
		foreach($programs as $prog){?>
		<tr id="action_<?= $prog->id?>">
			<td>
				<?php echo $i?>
			</td>
			<td>
				<?php echo $prog->title?>
			</td>
			<td class="center_text">
				<?php echo $prog->status?>
			</td>
			<td class="center_text">
				<?php echo date("j M y", strtotime($prog->start_date));?>
			</td>
			<td class="center_text">
				<?php echo date("j M y", strtotime($prog->end_date));?>
			</td>
			<td class="center_text">
				<?= $prog->notes ?>
			</td>
			<?php if($user['role']=='1'){?><td style="width:50px">
				<a class="btn btn-link btn-link-edit" onclick="input_action(<?php echo $prog->initiative_id?>,<?php echo $prog->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_action(<?php echo $prog->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td><?php }?>
		</tr>
		<?php $i++;}?>
	</tbody>
</table>
<hr />
<script>
$(document).ready(function () {
	$('#table_id_<?= $id ?>').DataTable( {
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
