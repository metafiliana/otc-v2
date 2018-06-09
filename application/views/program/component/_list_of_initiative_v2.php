<?php
	foreach($programs as $prog){
?>
<div class="row">
	<div class="col-md-11" style="padding-top: 12px; padding-bottom: 20px; padding-left: 15px;">
		<a onclick="show_detail('<?php echo $prog->id?>', '<?php echo $prog->title?>');"><div><b><?php echo $prog->init_code?>. <?php echo $prog->title?></b></div></a>
	</div>
	<div class="col-md-1">
		<?php if($user['role']=='1'){?>
		<button onclick="input_action(<?php echo $prog->id?>,'');" class="btn btn-info-new btn-sm right_text"><span class="glyphicon glyphicon-plus"></span> Action</button>
		<?php } ?>
	</div>
</div>
<hr>
<div id="detail_<?php echo $prog->id?>" style="display:none;">
</div>
<div style="clear:both"></div>
<?php }?>
<script>
function show_detail(id, title){
    	$.ajax({
			type: "GET",
			url: config.base+"program/detail_minitative",
			data: {
				id: id,
				title: title
			},
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
