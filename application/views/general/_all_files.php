<script>
function add_files(id,init_code){
    $.ajax({
        type: "GET",
        url: config.base+"general/input_file",
        data: {id:id, init_code:init_code},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function get_file(init_code){
    	$.ajax({
			type: "GET",
			url: config.base+"general/get_file",
			data: {init_code:init_code},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#file_"+init_code).html(resp.html);
					toggle_visibility("file_"+init_code);
				}else{}
			}
		});
    }
</script>
<style type="text/css">
	.ds_folder{
		border-bottom:3px solid #189cb8;
	}
</style>

<?php $user = $this->session->userdata('user');
$init = explode(';', $user['initiative']);
?>
<div class="row" style="padding:0 10px 0 10px;">
	<?php foreach ($init_code as $code) {?>
	<div class="col-md-3" style="margin-top:10px;">
		<div class="component_part">
			<div style="margin-bottom:0px;" id="">
				<div style="padding-top:10px;">
					<?php foreach($init as $inits){ if($inits==$code->val || $user['role']=="admin"){?>
					<div style="text-align:right; margin-top:-15px">
						<a onclick="add_files('','<?php echo $code->val;?>')" class="btn btns btn-default  btn-xs"><span class="glyphicon glyphicon-plus"></span></a>
					</div>
					<?php } }?>
					<div class="helper_text">
						<?php echo $code->val;?>. <?php echo long_text_real($code->segment,35);?>
					</div>
	                	<div style="text-align:center">
	                		<a class="btn btn-link btn-link-primary-cbic" onclick="get_file('<?php echo $code->val;?>');">
	                			<span style="font-size:10px;" class="glyphicon glyphicon-menu-down"></span>
	                		</a>
	                	</div>
	                	<div style="display:none;" id="file_<?php echo $code->val?>">
						</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
                    