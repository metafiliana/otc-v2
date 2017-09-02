<?php
	foreach($programs as $prog){
?>
<div class="row">
	<div class="col-md-11">
		<a onclick="show_detail('<?php echo $prog->id?>');"><div><b><?php echo $prog->init_code?>. <?php echo $prog->title?></b></div></a>
	</div>
	<div class="col-md-1">
		<?php if($user['role']=='1'){?>
		<button onclick="input_action(<?php echo $prog->id?>,'');" class="btn btn-info-new btn-sm right_text"><span class="glyphicon glyphicon-plus"></span> Action</button>
		<?php } ?>
	</div>
</div>
<hr>
<div class="col-md" id="detail_<?php echo $prog->id?>" style="display:none;">
</div>
<?php }?>
<script>
function show_detail(id){
    	$.ajax({
			type: "GET",
			url: config.base+"program/detail_minitative",
			data: {id:id},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#detail_"+id).html(resp.html);
					toggle_visibility("detail_"+id);
				}else{}
			}
		});
    }
</script>
