<?php
$user = $this->session->userdata('user');
?>
<div style="padding:5px 10px 5px 0; margin: 10px 30px 10px 40px;">
	<div class="row">
		<div class="col-md-4">
			<div class="component_part" style="min-height: 90px;">
				<div>
					<a class="btn btn-info-new btn-sm" href="<?php echo base_url();?><?php if($user['role']=="admin"){ echo "program/list_programs/";} else{ echo "program/my_inisiatif/"; } ?>">Back</a>
					<h5 style="margin:5px 0 0 0;"><span style="margin-right:15px"><?php echo $program->init_code?></span><?php echo $program->segment?></h5>
					<h5 style="margin:5px 0 0 0;"><span style="margin-right:15px"><?php echo $program->code?></span><?php echo $program->title?></h5>
				</div>
			</div>
		</div>
		<div class="col-md-4">
				<div class="component_part" style="min-height: 90px;">
					<table class="table" style="margin-bottom:0">
						<thead>
							<tr class="black_color">
								<th class="grey_color_bg" style="vertical-align:middle;">Not Started Yet</th>
								<th class="green_color_bg" style="vertical-align:middle;">In Progress</th>
								<th class="yellow_color_bg" style="vertical-align:middle;">Delay</th>
								<th class="blue_color_bg" style="vertical-align:middle;">Completed</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="center_text"><span><?php if($wb_total_all==0){echo '0';} else{ echo number_format((($wb_all['notyet']/$wb_total_all)*100),2) ;}?> %</span></th>
								<th class="center_text"><span><?php if($wb_total_all==0){echo '0';} else{ echo number_format((($wb_all['inprog']/$wb_total_all)*100),2) ;}?> %</span></th>
								<th class="center_text"><span><?php if($wb_total_all==0){echo '0';} else{ echo number_format((($wb_all['delay']/$wb_total_all)*100),2) ;}?> %</span></th>
								<th class="center_text"><span><?php if($wb_total_all==0){echo '0';} else{ echo number_format((($wb_all['complete']/$wb_total_all)*100),2) ;}?> %</span></th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<div class="col-md-2">
			<div class="component_part" style="min-height: 90px;">
			<h5 style="margin:3px 0 5px 0">Direktur Sponsor : <span style="margin-right:15px"><?php echo $program->dir_spon?></span></h5>
			<h5 style="margin:3px 0 5px 0">PMO Head : <span style="margin-right:15px"><?php echo $program->pmo_head?></span></h5>
			</div>
		</div>
			<div class="col-md-2">
			<div class="component_part" style="min-height: 90px;" >
				<div class="row">
					<div class="col-md-3">
						<img src="<?php echo base_url();?>assets/img/general/no-profile-img.gif" alt="..." class="img-circle" style="height:66px;padding-left: 5px;">
					</div>
					<div class="col-md-9">
						<div>
							<h5 style="margin:3px 0 5px 0; padding-left: 15px;"><span style="margin-right:15px;"><?php echo $user_init->name?></span></h5>
						</div>
						<div>
							<h5 style="padding-left: 15px;">Co-Pmo<h5>
						</div>
					</div>
				</div>
			</div>
		</div>	
			</div>
		
		<div style="clear:both"></div>
		
		<div id="new_initiative">
			
		</div>
		
		<div class="component_part" id="initiative_content">
			<table class="table table-stripped">
				<thead class="black_color old_grey_color_bg">
				<tr><th colspan=3>Deliverable</th><th>Actions</th><th style="width:20%">Date</th><th>Last Update</th><th>Completed</th>
				<th>
					<?php $roles = explode(',',$user['role']); if(in_array("admin",$roles)){?><div style="float:left;">
						<button onclick="input_initiative('',<?php echo $program->id?>);" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Deliverable</button>
					</div><?php }?>
				</th>
				</tr>
			</thead>
				<tbody>
					<?php
						/*usort($ints, function($a, $b) {
							return $a['code'] - $b['code'];
						});*/
					?>
					<?php 
						$statshow=$this->uri->segment(4); $prog=""; $np=1; 
						if($statshow){
							if($statshow == "progress"){$statshow = "In Progress";}
							elseif($statshow == "completed"){$statshow = "Completed";}
							elseif($statshow == "delay"){$statshow = "Delay";}
							elseif($statshow == "risk"){$statshow = "At Risk";}
							else{$statshow = "Not Started Yet";}
						} $arr_descript = array();
						foreach($ints as $int){  ?>
					<?php if(!$statshow || ($statshow && ($statshow == $int['stat']))){if($prog != $int['int']->program){?>
					<?php $prog=$int['int']->program; $np++;}?>
					<tr id="initia_<?php echo $int['int']->id?>">
						<?php 
							if($int['stat']=="Delay"){$clr="danger"; $icn="remove";}
							elseif($int['stat']=="In Progress"){$clr="success"; $icn="refresh";}
							elseif($int['stat']=="Completed"){$clr="primary"; $icn="ok";}
							elseif($int['stat']=="At Risk"){$clr="warning"; $icn="exclamation-sign";}
							else{$clr="inverse"; $icn="off";}
						?>
						<?php if(!$int['child'] && $int['int']->parent_code){?>
						<td style="width:40px"></td><td style="width:40px">
							<center><button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button></center>
						</td>				
						<?php }else{?>
						<td style="width:40px">
							<center><button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button></center>
						</td>
						<?php }?>
				
						<?php if($int['int']->parent_code){ $codewdth = 9; ?><td style="width:45%"><?php }else{ $codewdth = 7; ?><td style="width:45%" colspan=2><?php }?>
							<div style="float:left; width:9%; margin-right:5px;"><?php echo $int['int']->code?></div> 
							<div style="float:left; max-width:88%"><a onclick="show_wb(<?php echo $int['int']->id?>,'<?php echo $program->init_code?>');"><?php echo $int['int']->title?></a></div> <!-- href="<?php echo base_url()?>initiative/detail/<?php echo $int['int']->id?>" -->
							<div style="clear:both"></div>
						</td>
						<td style="text-align:center;"><?php echo $int['wb']?></td>
						<td>
							<?php if($int['int']->start && $int['int']->end){?>
							<?php
								$stdate = strtotime($int['int']->start);
								$eddate = strtotime($int['int']->end);
								$crdate = strtotime(date('Y-m-d'));
								$selisih_edst = $eddate-$stdate; if(!$selisih_edst){$selisih_edst = 1;}
								$pcttgl = ($crdate-$stdate)/($selisih_edst)*100;
								if($pcttgl<0){$pcttgl = 0;}
								if($pcttgl>100){$pcttgl = 100;}
							?>
							<div style="font-size:12px">
								<span><?php echo date("j M y", $stdate);?></span>
								<span style="float:right"><?php echo date("j M y", $eddate);?></span>
								<?php 
									/*if($pcttgl <= 50 ){$barcol="success";}
									elseif($pcttgl > 50 && $pcttgl <= 80){$barcol="warning";}
									elseif($pcttgl > 80 ){$barcol="black";}*/
									$barcol = "black";
								?>
								<div class="progress" style="margin-bottom:0">
								  <div class="progress-bar progress-bar-<?php echo $barcol?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pcttgl?>%">
									<span style="color:black"><?php echo number_format(100-$pcttgl,1)?>%</span>
								  </div>
								</div>
							</div>
							<?php }?>
						</td>
						<td><?php echo $int['int']->last_update?></td>
						<td>
							<h5 style="color:#337ab7">Completed</h5>
							<h5><?php if($int['wb_total']==0){echo "No Action";} else{echo number_format((($int['wb_status']['complete']/$int['wb_total'])*100),2)."%";}?></h5>
						</td>
						<td>
						<?php if($user['role']=='admin'){?>
							<button class="btn btn-warning  btn-xs" onclick="input_initiative(<?php echo $int['int']->id?>,<?php echo $program->id?>);"><span class="glyphicon glyphicon-pencil"></span></button>
							<button class="btn btn-danger btn-xs" onclick="delete_initiative(<?php echo $int['int']->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
						<?php }?>
						</td>
					</tr>
					<tr id="wb_<?php echo $int['int']->id?>" style="display:none">
						<td colspan="3" id="list_workblocks_<?php echo $int['int']->id?>">
						</td>
						<td colspan="2" id="list_remarks_<?php echo $int['int']->id?>">
						</td>
						<td>
							<button onclick="edit_remark('',<?php echo $int['int']->id?>,<?php echo $user_init->id?>);" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Comment</button>
							<?php if($user['role']=='admin'){?>
							<button onclick="edit_workblock('',<?php echo $int['int']->id?>);" class="btn btn-info-new btn-sm" style="margin-top:10px;"><span class="glyphicon glyphicon-plus"></span> Action</button>
							<?php }?>
						</td>
						<td id="info_<?php echo $int['int']->id?>">
						</td>
					</tr>
					<!--FORM EDIT BOS -->
					<tr id="edit_int_<?php echo $int['int']->id?>" style="display:none"><td></td></tr>
					<?php }}?>
				</tbody>
		</table>
		</div>
	</div><div style="clear:both"></div><br>
</div>
<script>
	function delete_initiative(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"initiative/delete_initiative",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#initia_'+id).animate({'opacity':'toggle'});
							succeedMessage('Initiative berhasil dihapus');
						}
					}
				});
			}
		});
	}
	function show_descript(id,segment){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/get_description",
			data: {id: id,segment:segment},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					bootbox.dialog({
						title: resp.title,
						message: resp.message
					});
				}else{}
			}
		});
	}
	function edit_init(id,segment){
    	toggle_visibility('edit_int_'+id);
    	$.ajax({
			type: "GET",
			url: config.base+"initiative/edit_initiative",
			data: {id: id,segment: segment},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#edit_int_"+id).html(resp.html);
				}else{}
			}
		});
    }
    function show_wb(id,init_code){
    	$.ajax({
			type: "GET",
			url: config.base+"initiative/detail_wb",
			data: {id: id,init_code:init_code},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$('#wb_'+id).show();
					$("#list_workblocks_"+id).html(resp.html);
					$("#list_remarks_"+id).html(resp.remarks);
					$("#info_"+id).html(resp.info);
				}else{}
			}
		});
    }

    function input_initiative(id,program){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/input_initiative",
			data: {program: program, id: id},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					show_popup_modal(resp.html);
					//$("#new_initiative").html(resp.html);
				}else{}
			}
		});
	}

	function edit_remark(id,init,user_id){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/edit_remark",
			data: {id: id, init: init, user_id:user_id},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					show_popup_modal(resp.html);
				}else{}
			}
		});
	}

	function submit_remark(){
		$("#form_remark").ajaxForm({	
    		dataType: 'json',
    		success: function(resp) 
    		{
        		if(resp.status==1){
					$('#popup_Modal').modal('hide');
					$("#list_remarks_"+resp.id).html(resp.html);
				}else{}
    		},
		});
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
						}
					}
				});
			}
		});
	}

	function close_form_initiative(){
		$("#new_initiative").html('');
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
					show_popup_modal(resp.html);
				}else{}
			}
		});
	}
	function submit_workblock(){
		$("#form_workblock").ajaxForm({	
    		dataType: 'json',
    		success: function(resp) 
    		{
        		if(resp.status==1){
					$('#popup_Modal').modal('hide');
					$("#list_workblocks_"+resp.html_id).html(resp.html);
					$("#info_"+resp.html_id).html(resp.info);
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
</script>