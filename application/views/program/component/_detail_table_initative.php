<?php
$user = $this->session->userdata('user');
?>
<table class="table table-hover table-striped">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="vertical-align:middle">No</th>
			<th style="vertical-align:middle">Title</th>
			<th style="vertical-align:middle">Status</th>
			<th style="vertical-align:middle">Start Date</th>
			<th style="vertical-align:middle">Completed Date</th>
			<?php if($user['role']=='1'){?>
				<th style="vertical-align:middle"></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;
		foreach($programs as $prog){?>
		<tr>
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
				<?php echo $prog->start_date?>
			</td>
			<td class="center_text">
				<?php echo $prog->end_date?>
			</td>
			<?php if($user['role']=='1'){?><td style="width:50px">
				<a class="btn btn-link btn-link-edit" onclick="show_form(<?php echo $prog->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
				<a class="btn btn-link btn-link-delete" onclick="delete_program(<?php echo $prog->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
			</td><?php }?>
		</tr>
		<?php $i++;}?>
	</tbody>
</table>
