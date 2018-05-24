<?php
$user = $this->session->userdata('user');
$arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
?>
<div class="component_part" style="margin:20px;">
<a id="dlink" style="display:none;"></a>
<button id="btn" class="btn btn-sm btn-collect buttons-excel buttons-html5 btn-success">Export to Excel</button>
<table class="table display" id="table_ids">
	<!-- <thead class="black_color old_grey_color_bg"> -->
		<tr>
			<th>No</th>
			<th>Init Code</th>
			<th>Type</th>
			<th>Metric</th>
			<th>Target</th>
			<th>Baseline</th>
			<?php foreach ($arr_month as $arr) { ?>
			<th>Target <?= $arr ?></th>
			<th>Realisasi <?= $arr ?></th>
			<?php } ?>
		</tr>
	<!-- </thead> -->
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
				<?php echo $ak->type?>
			</td>
			<td>
				<?php echo $ak->metric?>
			</td>
			<td style='mso-number-format:"#,##0.00"'>
				<?php echo number_format($ak->target,2,",",".");?>
			</td>
			<td style='mso-number-format:"#,##0.00"'>
				<?php echo number_format($ak->baseline,2,",",".");?>
			</td>
			<?php foreach ($arr_month as $arr) { ?>
			<th style='mso-number-format:"#,##0.00"'><?php echo number_format($ak->$arr,2,",","."); ?></th>
			<th style='mso-number-format:"#,##0.00"'><?php $u_month = 'u_'.$arr; echo number_format($ak->$u_month,2,",","."); ?></th>
			<?php } ?>
		</tr>
		<?php $i++;}?>
	</tbody>
</table>
</div><div style="clear:both"></div>
<hr />
<script>
// $(document).ready(function () {
// 	$('#table_ids').DataTable( {
// 					dom: 'Bfrtip',
// 					paging: false,
// 					scrollX: true,
// 					buttons: [
// 							'excelHtml5',
// 							{
//                 extend: 'pdfHtml5',
//                 orientation: 'landscape'
//             	}
// 					]
// 			} );
// });

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

				document.getElementById("dlink").href = uri + base64(format(template, ctx));
				document.getElementById("dlink").download = filename;
				document.getElementById("dlink").traget = "_blank";
				document.getElementById("dlink").click();

		}
})();
function download(){
		$(document).find('tfoot').remove();
		var name = 'Export Kuantitatif';
		tableToExcel('table_ids', 'Sheet 1', name+'.xls')

}
var btn = document.getElementById("btn");
btn.addEventListener("click",download);
</script>
