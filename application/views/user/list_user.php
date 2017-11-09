<div id="" class="container no_pad">
	<div class="no_pad" style="margin:15px 0 30px 0;">
		<h2 style="">All User</h2>
	</div>
	<div class="component_part">
		<div style="margin-bottom:10px; float:right;">
		<a href="<?php echo base_url()?>user/input_user"  class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> User</a>
		</div><div style="clear:both"></div>

		<table class="table display" id="table_user">
			<thead>
				<tr class="headertab"><th>No</th><th>Nama</th><th>Role</th><th>Initiative</th><th>Last Login</th><th></th></tr>
			</thead>
			<tbody>
				<?php $i=1; foreach($user as $usr){?>
				<tr id="usersu_<?php echo $usr->id?>">
					<td><?php echo $i;?></td>
					<td><?php echo $usr->name;?></td>
					<td><?php echo user_role($usr->role);?></td>
					<td><?php echo $usr->initiative;?></td>
					<td><?php if($usr->last_login=="0000-00-00 00:00:00"){
						echo "Null";
					}
					else{
						$myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $usr->last_login); echo date_format($myDateTime,'d/F/Y H:i:s');
					}?>
					</td>
					<td>
						<a href="<?php echo base_url()?>user/input_user/<?php echo $usr->id?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
						<button class="btn btn-danger btn-xs" onclick="delete_user(<?php echo $usr->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
						<button class="btn btn-primary btn-xs" onclick="reset_user(<?php echo $usr->id?>)"><span class="glyphicon glyphicon-refresh"></span></button>
						<button class="btn btn-primary btn-xs" onclick="reset_photo(<?php echo $usr->id?>)"><span class="glyphicon glyphicon-camera"></span></button>
					</td>
				</tr>

				<?php $i++; }?>
			</tbody>
		</table>
	</div><div style="clear:both"></div><br>
</div>

<script>
	function delete_user(id, event){
		bootbox.confirm("Apa anda yakin menghapus user?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"user/delete_user",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#usersu_'+id).animate({'opacity':'toggle'});
							alert('User berhasil dihapus');
						}
					}
				});
			}
		});
	}

	function reset_user(id, event){
		bootbox.confirm("Apa anda yakin mengganti password?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"user/reset_user",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							alert('User berhasil memakai password default');
						}
					}
				});
			}
		});
	}

	function reset_photo(id, event){
		bootbox.confirm("Apa anda yakin menghapus photo ke formal?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"user/reset_photo",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							alert('User berhasil memakai photo formal');
						}
					}
				});
			}
		});
	}

	$(document).ready(function () {
		$('#table_user').DataTable( {
						dom: 'Bfrtip',
						paging: false,
						buttons:[

						]
				} );
	});
</script>
