<?php
	foreach($programs as $prog){
?>
<div class="row">
	<div class="col-md-11" style="padding-top: 12px; padding-bottom: 20px; padding-left: 15px;">
		<a onclick="show_detail('<?php echo $prog->id?>')"><b><?php echo $prog->init_code?>. <?php echo $prog->title?></b></a>
		
	</div>
	<div class="col-md-1" style="padding-top: 8px; position: relative;">
		<?php if($user['role']=='2'){?>
		<button onclick="input_kuantitatif(<?php echo $prog->id?>,'<?php echo $prog->init_code?>','');" class="btn btn-info-new btn-sm right_text"><span class="glyphicon glyphicon-plus"></span> Kuantitatif</button>
		<?php } ?>
	</div>
</div>
<hr>
<div class="col-md" id="detail_<?php echo $prog->id?>" style="display:none;">
</div>
<div style="clear:both"></div>
<?php }?>
<script>
function show_detail(id){
    	$.ajax({
			type: "GET",
			url: config.base+"kuantitatif/test",
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
