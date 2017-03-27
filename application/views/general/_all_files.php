<script>
function delete_file(id){
    $.confirm({
		title: 'Apa anda yakin?',
		content: '',
		confirmButton: 'Ya',
		confirm: function(){  
		  $.ajax({
			type: "GET",
			url: config.base+"dsfile/delete_file",
			data: {id:id},
			dataType: 'json',
			cache: false,
			success: function(resp){
			  console.log(resp);
			  if(resp.status==true){
                location.reload(config.base+"dsfile/index");
			  }else{
				  console.log('action after failed');
			  }
			}
		  });
		},
	});
}

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
</script>
<style type="text/css">
	.ds_folder{
		border-bottom:3px solid #189cb8;
	}
</style>

<?php $user = $this->session->userdata('userdb');?>
<div class="row" style="padding:0 10px 0 10px;">
	<?php foreach ($init_code as $code) {?>
	<div class="col-md-3" style="margin-top:10px;">
		<div class="component_part">
			<div style="margin-bottom:0px;" id="">
				<div style="padding-top:10px;">
					<div style="text-align:right;">
						<a onclick="add_files('','<?php echo $code->val;?>')" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-plus"></span></a>
					</div>
					<div class="helper_text">
						<?php echo $code->val;?>. <?php echo long_text_real($code->segment,35);?>
					</div>
	                	<div style="text-align:center">
	                		<a class="btn btn-link btn-link-primary-cbic" onclick="">
	                			<span style="font-size:10px;" class="glyphicon glyphicon-menu-down"></span>
	                		</a>
	                	</div>
	                	<div style="display:none;" id="" class="">
				        	<div style="padding:10px 0 10px 0; border-bottom:1px dashed #c3c3c3;">
					                <div style="float:right;">    
					                    <a href="" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
					                    <a onclick="" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
					                </div>       
							    <div style="font-size:14px;"> 
					                <span style="margin-top:5px; font-size:14px;"></span>
					            </div>
					            
							    <div style="margin-top:10px">
					            </div>
					        </div>
						</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>


                    