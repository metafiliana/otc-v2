<?php
$user = $this->session->userdata('user');
?>
<a id="dlink_<?= $id ?>" style="display:none;"></a>
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
				<?php echo date("d-M-Y", strtotime($prog->start_date));?>
			</td>
			<td class="center_text">
				<?php echo date("d-M-Y", strtotime($prog->end_date));?>
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

<table id="table_print_id_<?= $id ?>" style="display: none;">
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
			<td class="center_text" style="mso-number-format:'Medium Date'">
				<?php echo date("d-M-Y", strtotime($prog->start_date));?>
			</td>
			<td class="center_text" style="mso-number-format:'Medium Date'">
				<?php echo date("d-M-Y", strtotime($prog->end_date));?>
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
	function ExcelDateToJSDate(date) {
	  return new Date(Math.round((date - 25569)*86400*1000));
	}

	$('#table_id_<?= $id ?>').DataTable( {
					dom: 'Bfrtip',
					paging: false,
					buttons: [
		            	{
			                text: '<span style="margin-right:5px;" class="glyphicon glyphicon-file"></span> Export to Excel',
			                className: 'btn btn-sm btn-collect buttons-pdf buttons-html5 btn-success',
			                action: function ( e, dt, node, config ) {
			                    // alert( 'Button activated' );
			                    download();
			                }
			            },
						{
			                extend: 'pdfHtml5',
			                orientation: 'landscape'
		            	}
					]
			} );

	var tableToExcel = (function () {
		var uri = 'data:application/vnd.ms-excel;base64,',
				template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
				base64 = function (s) {
						return window.btoa(unescape(encodeURIComponent(s)))
				}, format = function (s, c) {
						return s.replace(/{(\w+)}/g, function (m, p) {
								return c[p];
						})
				}
		return function (table, name, filename) {
				if (!table.nodeType) table = document.getElementById(table)
				var ctx = {
						worksheet: name || 'Worksheet',
						table: table.innerHTML
				}

				document.getElementById("dlink_<?= $id ?>").href = uri + base64(format(template, ctx));
				document.getElementById("dlink_<?= $id ?>").download = filename;
				document.getElementById("dlink_<?= $id ?>").traget = "_blank";
				document.getElementById("dlink_<?= $id ?>").click();

		}
	})();
	function download(){
			var name = 'Export Initiative <?= $title ?>';
			tableToExcel('table_print_id_<?= $id ?>', 'Sheet 1', name+'.xls')
	}
});

</script>
