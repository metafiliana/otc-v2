<?php
$user = $this->session->userdata('user');
?>

<div class="row" style="padding: 20px 10px 0 10px;">
<div class=col-md-2>
	<div class="row">
			<div class="col-md-10">
					<h3>Master Cluster</h3>
			</div>
			<div class="col-md-2 right_text">
					<a onclick="show_form('cluster','');" class="btn btn-sm right_text"><span class="glyphicon glyphicon-plus"></span></a>
			</div>
	</div>
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
	<div class="row">
			<div class="col-md-10">
					<h3>Master Initiative</h3>
			</div>
			<div class="col-md-2 right_text">
					<a onclick="show_form('initiative','');" class="btn btn-sm right_text"><span class="glyphicon glyphicon-plus"></span></a>
			</div>
	</div>
	<table class="table display" style="margin-top:10px;">
		<thead class="black_color old_grey_color_bg">
			<tr>
				<th>Id</th>
				<th>Code</th>
				<th>ID Cluster</th>
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
					<?php echo $init->init_code?>
				</td>
				<td>
					<?php echo $init->mctitle?>
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
	<div class="row">
			<div class="col-md-10">
					<h3>Kuantitatif Legend</h3>
			</div>
			<div class="col-md-2 right_text">
					<a onclick="show_form('kuan_legend','');" class="btn btn-sm"><span class="glyphicon glyphicon-plus"></span></a>
			</div>
	</div>
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
				<tr id="kuantitatif_legend_<?= $kl->klid?>">
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
						<a class="btn btn-link btn-link-delete" onclick="delete_by_type(<?= $kl->klid?>,'kuantitatif_legend')"><span class="glyphicon glyphicon-trash"></span></a>
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
	$('#table_id').DataTable( {
					dom: 'Bfrtip',
					paging: false,
					buttons: [
							'excelHtml5',
							'pdfHtml5',
					]
			} );
});

function show_form(type,id){
  $.ajax({
    type: "GET",
    url: config.base+"general/show_form",
    data: {type:type, id:id},
    dataType: 'json',
    cache: false,
    success: function(resp){
      if(resp.status==1){
        show_popup_modal(resp.html);
      }else{}
    }
  });
}

function delete_by_type(id, type){
  bootbox.confirm("Apa anda yakin?",
  function(confirmed) {
    if(confirmed===true){
      $.ajax({
        url: config.base+"general/delete_by_type",
        data: {id: id, type:type},
        dataType: 'json',
        type: "POST",
        success: function (resp) {
          if(resp.status == 1){
            $('#'+type+'_'+id).animate({'opacity':'toggle'});
            succeedMessage(''+type+' berhasil dihapus');
          }
        }
      });
    }
  });
}
</script>
