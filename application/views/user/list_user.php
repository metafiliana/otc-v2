<div id="" class="container no_pad">
	<div class="no_pad" style="margin-bottom: 50px;">
		<h2 style="">All User</h2>
	</div>
	<div>
		<div style="margin-bottom:10px; float:right;">
		<a href="<?php echo base_url()?>user/input_user"  class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> User</a>
		</div><div style="clear:both"></div>
		
		<table class="table table-bordered">
			<thead>
				<tr class="headertab"><th>No</th><th>Nama</th><th>Role</th><th>Initiative</th><th></th></tr>
			</thead>
			<tbody>
				<?php $i=1; foreach($user as $usr){?>
				<tr id="usersu_<?php echo $usr->id?>">
					<td><?php echo $i;?></td>
					<td><?php echo $usr->name;?></td>
					<td><?php echo $usr->role;?></td>
					<td><?php echo $usr->initiative;?></td>
					<td>
						<a href="<?php echo base_url()?>user/input_user/<?php echo $usr->id?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
						<button class="btn btn-danger btn-xs" onclick="delete_user(<?php echo $usr->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
					</td>
				</tr>
				
				<?php $i++; }?>
			</tbody>
		</table>
	</div><div style="clear:both"></div><br>
</div>

<script>
	function delete_user(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"user/delete_user",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#usersu_'+id).animate({'opacity':'toggle'});
							succeedMessage('User berhasil dihapus');
						}
					}
				});
			}
		});
	}
</script>