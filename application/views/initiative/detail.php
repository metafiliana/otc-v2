<div style="padding:5px">
	<h3></h3>
	<div style="width:55%; float:left; padding:0px">
		<h5><?php echo $init->program_code?> <?php echo $init->program?></h5>
		<h4><?php echo $init->code?> <?php echo $init->title?></h4>
		<div class="panel panel-primary">
			<div class="panel-heading">Actions <div class="pull-right"><button onclick="edit_workblock('',<?php echo $init->id?>);" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-plus"></span></button></div></div>
			<div class="panel-body" style="padding:0;">
				<div id="form_add_workblocks" style="border-bottom:1px solid #eee; padding:5px 5px 15px 5px; display:none;">
					<?php echo $form_wb?>
				</div>
				<div id="form_progress" style="border-bottom:1px solid #eee; padding:5px 5px 15px 5px; display:none;">
					<?php echo $form_prog?>
				</div>
				<div id="list_workblocks">
					<?php echo $wb?>
				</div>
			</div>
		</div>
	</div>
	<div style="width:45%; float:left; padding:0 15px 0 15px">
		<div class="panel panel-primary">
			<div class="panel-heading">Initiative Info <div class="pull-right"><button onclick="toggle_visibility('body-info');" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-chevron-up"></span></button></div></div>
			<div class="panel-body" style="padding:5px 10px 5px 10px;" id="body-info">
				<?php echo $info?>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">Remarks <div class="pull-right"><button onclick="edit_remark('',<?php echo $init->id?>);;" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-plus"></span></button></div></div>
			<div class="panel-body" style="padding:0;">
				<div id="form_add_remarks" style="border-bottom:1px solid #eee; padding:5px 5px 15px 5px; display:none">
					<?php echo $form_rmrk?>
				</div>
				<div id="list_remarks">
					<?php echo $remarks?>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear:both"></div>
<script>
    //Remarks Function
    function submit_remark(){
		$("#form_remark").ajaxForm({	
    		dataType: 'json',
    		success: function(resp) 
    		{
        		if(resp.status==1){
					$("#list_remarks").html(resp.html);
					toggle_visibility('form_add_remarks');
					if($('#list_remarks').css('display') == 'none'){
						toggle_visibility('list_remarks');
					}
				}else{}
    		},
		});
	}
	function edit_remark(id,init){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/edit_remark",
			data: {id: id, init: init},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					//if($('#form_add_remarks').css('display') == 'none'){
					//$('#form_add_remarks').animate({'height':'toggle','opacity':'toggle'});
					//}
					toggle_visibility('form_add_remarks');
					$("#form_add_remarks").html(resp.html);
					//$("#list_remarks").css('display','none');	
					toggle_visibility('list_remarks');
				}else{}
			}
		});
	}
	function close_form_remark(){
		if($('#list_remarks').css('display') == 'none'){
			toggle_visibility('list_remarks');
		}
		toggle_visibility('form_add_remarks');
	}
	function delete_remark(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"initiative/delete_remark",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#remark_'+id).animate({'opacity':'toggle'});
							succeedMessage('Remark berhasil dihapus');
						}
					}
				});
			}
		});
	}
	//Workblock Function
	function edit_workblock(id,init){
		$.ajax({
			type: "GET",
			url: config.base+"workblock/edit_workblock",
			data: {id: id, init: init},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					if($('#form_add_workblocks').css('display') == 'none'){
						$('#form_add_workblocks').animate({'height':'toggle','opacity':'toggle'});
					}
					$("#list_workblocks").css('display','none');
					$("#form_add_workblocks").html(resp.html);
				}else{}
			}
		});
	}
	function close_form_workblock(){
		if($('#list_workblocks').css('display') == 'none'){
			toggle_visibility('list_workblocks');
		}
		toggle_visibility('form_add_workblocks');
	}
	function submit_workblock(){
		$("#form_workblock").ajaxForm({	
    		dataType: 'json',
    		success: function(resp) 
    		{
        		if(resp.status==1){
					$("#list_workblocks").html(resp.html);
					toggle_visibility('form_add_workblocks');
					if($('#list_workblocks').css('display') == 'none'){
						toggle_visibility('list_workblocks');
					}
					$("#body-info").html(resp.info);
				}else{}
    		},
		});
	}
	function delete_workblock(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"workblock/delete_workblock",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#workblock_'+id).animate({'opacity':'toggle'});
							succeedMessage('Workblock berhasil dihapus');
						}
					}
				});
			}
		});
	}
	//Form Progress
	function edit_progress(id){
		$.ajax({
			type: "GET",
			url: config.base+"workblock/edit_progress",
			data: {id: id},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					toggle_visibility('form_progress');
					$("#form_progress").html(resp.html);
					/*if($('#form_add_workblocks').css('display') == 'none'){
						$('#form_add_workblocks').animate({'height':'toggle','opacity':'toggle'});
					}
					$("#list_workblocks").css('display','none');
					$("#form_add_workblocks").html(resp.html);*/
				}else{}
			}
		});
	}
</script>