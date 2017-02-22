<div id="" class="container no_pad">
	<div class="no_pad breadmy" style="margin-bottom: 0px; color:grey; float:left; margin-top:20px">
		<div>
			<div>
				<a href="<?php echo base_url()?>initiative/list_programs">Program</a> : <span><?php echo $initiative['int']->program_code?></span>
				<span style="margin-left:2px; max-width:600px; margin-right:5px"><?php echo $initiative['int']->program?></span>
			</div>
			<div>
				<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $initiative['int']->segment?>">Initiative</a> : <span style="margin-left:5px"><?php echo $initiative['int']->code?></span>
				<span style="margin-left:2px; max-width:600px;"><?php echo $initiative['int']->title?></span>
			</div>
			<div style="clear:both"></div>
		</div>
	</div><div style="clear:both"></div>
	<h3>Workblock Summary</h3>
	<div>
		<?php $inits = explode(';',$user['initiative']); if($user['role']=='admin' || in_array($initiative['int']->code,$inits)){?>
		<button style="float:right; margin-top:-34px;" class="btn btn-info btn-sm" onclick="toggle_visibility('new_workblock');">
			<span class="glyphicon glyphicon-plus"></span> Workblock
		</button>
		<?php }?>
		<div id="new_workblock" style="display:none">
			<hr>
			<h3>New Workblock</h3>
			<form class="form-horizontal" method="post" id="form_src_rm" action="<?php echo base_url();?>workblock/submit_workblock">
				<input type="hidden" value="<?php echo $initiative['int']->id?>" name="initiative">
				<div class="form-group">
					<label class="col-sm-2 control-label">Workblock</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" placeholder="Workblock" name="title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">PIC</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" placeholder="PIC" name="pic">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Objective</label>
					<div class="col-sm-4">
					  <textarea class="form-control" placeholder="Objectives" style="height:90px" name="objective"></textarea>
					</div>
				</div>
				<input type="submit" class="btn btn-success" style="margin-left:200px">
			</form>
			<hr>
		</div>
		<table class="table table-bordered" style="margin-top:20px">
			<thead>
				<tr class="headertab"><th></th><th style="width:90px">Workblock</th><th><a href="#" onclick="show_milestone()" style="color:white">Show Milestone</th><th style="width:90px">Start Date</th><th style="width:90px">End Date</th></tr>
			</thead>
			<tbody>
				<?php $i=1; foreach($workblocks as $wb){?>
				<tr id="wbdtl_<?php echo $wb['wb']->id?>">
					<!--<td rowspan=<?php echo count($wb['ms'])+1?>>-->
					<td>
					<?php 
						if($wb['stat']=="Delay"){$clr="danger"; $icn="remove";}
						elseif($wb['stat']=="In Progress"){$clr="warning"; $icn="refresh";}
						elseif($wb['stat']=="Completed"){$clr="success"; $icn="ok";}
						else{$clr="inverse"; $icn="off";}
					?>
					<center><button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button></center></td>
					<td colspan=2>
						<div style="float:left; width:10px; "><?php echo $i;?>.</div>
						<div style="margin-left:15px; float:left; max-width:95%"><a href="<?php echo base_url()?>workblock/detail_workblock/<?php echo $wb['wb']->id?>"><?php echo $wb['wb']->title?></a></div>
						<div style="clear:both"></div>
					</td>
					<td><?php if($wb['date']->min_start){echo date("j M y", strtotime($wb['date']->min_start));}?></td>
					<td><?php if($wb['date']->max_end){echo date("j M y", strtotime($wb['date']->max_end));}?></td>
					<?php if($user['role']=='admin'){?><td style="width:70px">
						<button class="btn btn-warning  btn-xs" onclick="toggle_visibility('edit_wb_<?php echo $wb['wb']->id?>');"><span class="glyphicon glyphicon-pencil"></span></button>
						<button class="btn btn-danger btn-xs" onclick="delete_workblock(<?php echo $wb['wb']->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
					</td><?php }?>
					
				</tr>
				<tr id="edit_wb_<?php echo $wb['wb']->id?>" style="display:none">	
					<td colspan=5>
						<form class="form-horizontal" method="post" id="form_src_rm" action="<?php echo base_url();?>workblock/submit_workblock/<?php echo $wb['wb']->id?>">
							<input type="hidden" value="<?php echo $initiative['int']->id?>" name="initiative">
							<div class="form-group">
								<label class="col-sm-2 control-label">Workblock</label>
								<div class="col-sm-4">
								  <input type="text" class="form-control" placeholder="Workblock" name="title" value="<?php echo $wb['wb']->title?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">PIC</label>
								<div class="col-sm-4">
								  <input type="text" class="form-control" placeholder="PIC" name="pic" value="<?php echo $wb['wb']->pic?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Objective</label>
								<div class="col-sm-4">
								  <textarea class="form-control" placeholder="Objectives" name="objective" style="height:90px"><?php echo $wb['wb']->objective?></textarea>
								</div>
							</div>
							<input type="submit" class="btn btn-success" style="margin-left:170px">
						</form>
				</tr>
				<?php $j=1; foreach($wb['ms'] as $ms){?>
				<tr class="milestone_toshow" id="ms_wb_<?php echo $wb['wb']->id?>" style="display:none">
					<td></td>
					<td><?php 
						if($ms->status=="Delay"){$clr="danger"; $icn="remove";}
						elseif($ms->status=="In Progress"){$clr="warning"; $icn="refresh";}
						elseif($ms->status=="Completed"){$clr="success"; $icn="ok";}
						else{$clr="inverse"; $icn="off";}
					?>
					<center><button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button></center></td>
					<td><?php echo $j.". ".$ms->title?></td>
					<td><?php if($ms->start){echo date("j M y", strtotime($ms->start));}?></td>
					<td><?php if($ms->end){echo date("j M y", strtotime($ms->end));}?></td>
				</tr>
				<?php $j++;}?>
				<?php $i++; }?>
			</tbody>
		</table>
	</div><div style="clear:both"></div><br>
</div>

<script>
    $('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
    function edit_wb(id){
    	toggle_visibility('edit_wb_'+id);
    	//toggle_visibility('ms_wb_'+id);
    }
    function show_milestone(id){
    	$('.milestone_toshow').animate({'opacity':'toggle'});
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
							$('#wbdtl_'+id).animate({'opacity':'toggle'});
							if($('.ms_wb_'+id).length > 0){$('.ms_wb_'+id).animate({'opacity':'toggle'});}
							succeedMessage('Workblock berhasil dihapus');
						}
					}
				});
			}
		});
	}
</script>