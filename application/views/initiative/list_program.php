<div style="padding:5px 10px 5px 0">
	<h2>Programs</h2>
	<div style="">
		<div style="margin-bottom:10px; float:right;">
		<a href="<?php echo base_url()?>initiative/input_program" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Program</a>
		</div>
		
		<div style="margin-bottom:10px; float:left">
			<a href="<?php echo base_url()?>initiative/list_programs" style="color:black">Status:</a>
			<a href="<?php echo base_url()?>initiative/list_programs/nsy" style="color:black"><button class="btn btn-inverse btn-xs"><span style="color:grey" class="glyphicon glyphicon-off"></span></button><span style="margin-right:10px"> Not Started Ye</span></a>
			<a href="<?php echo base_url()?>initiative/list_programs/progress" style="color:black"><button class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-refresh"></span></button><span style="margin-right:10px"> On Progress</span></a>
			<a href="<?php echo base_url()?>initiative/list_programs/completed" style="color:black"><button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button><span style="margin-right:10px"> Completed</span></a>
			<a href="<?php echo base_url()?>initiative/list_programs/delay" style="color:black"><button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><span> Delay</span></a>
		</div>
		<div style="clear:both">
		
		<table class="table table-bordered">
			<thead>
				<tr class="headertab"><th></th><th colspan=2>Programs</th><th>Start Date</th><th>End Date</th></tr>
			</thead>
			<tbody>
				<?php
					usort($programs, function($a, $b) {
						return $a['code'] - $b['code'];
					});
				?>
				<?php 
				$segment=""; $i=1; $segnum=1;
				$statshow=$this->uri->segment(3); 
				if($statshow){
					if($statshow == "progress"){$statshow = "In Progress";}
					elseif($statshow == "completed"){$statshow = "Completed";}
					elseif($statshow == "delay"){$statshow = "Delay";}
					else{$statshow = "Not Started Yet";}
				}
				foreach($programs as $prog){?>
				<?php if(!$statshow || ($statshow && ($statshow == $prog['status']))){if($segment != $prog['prog']->segment){?>
					<tr style="background-color:#F0EBA8; font-size:16px"><td colspan=5>
						<?php echo $segnum.'. ';?><a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $prog['prog']->segment?>"><?php echo $prog['prog']->segment?></a>
					</td></tr>
				<?php $segment=$prog['prog']->segment; $segnum++;}?>
				
				<tr id="prog_<?php echo $prog['prog']->id?>">
					<?php 
						if($prog['status']=="Delay"){$clr="danger"; $icn="remove";}
						elseif($prog['status']=="In Progress"){$clr="warning"; $icn="refresh";}
						elseif($prog['status']=="Completed"){$clr="success"; $icn="ok";}
						else{$clr="inverse"; $icn="off";}
					?>
					<td style="width:40px"><center><button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button></center></td>	
					<td style="width:600px">
						<div style="float:left; width:30px; margin-right:5px;"><?php echo $prog['prog']->code?></div> 
						<div style="float:left; max-width:520px"><?php echo $prog['prog']->title?></div>
						<div style="clear:both"></div>
					</td>
					<td style="width:40px"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-list"></span></button></td>
					<td colspan=2 style="width:400px">
						<?php if($prog['date']->min_start && $prog['date']->max_end){?>
						<?php
							$stdate = strtotime($prog['date']->min_start);
							$eddate = strtotime($prog['date']->max_end);
							$crdate = strtotime(date('Y-m-d'));
							$pcttgl = ($crdate-$stdate)/($eddate-$stdate)*100;
							if($pcttgl<0){$pcttgl = 0;}
							if($pcttgl>100){$pcttgl = 100;}
						?>
						<div style="font-size:12px">
							<span><?php echo date("j M y", $stdate);?></span>
							<span style="float:right"><?php echo date("j M y", $eddate);?></span>
							<?php 
								if($pcttgl <= 50 ){$barcol="success";}
								elseif($pcttgl > 50 && $pcttgl <= 80){$barcol="warning";}
								elseif($pcttgl > 80 ){$barcol="danger";}
							?>
							<div class="progress" style="margin-bottom:0">
							  <div class="progress-bar progress-bar-<?php echo $barcol?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pcttgl?>%">
								<span style="color:black"><?php echo number_format(100-$pcttgl,1)?>%</span>
							  </div>
							</div>
						</div>
						<?php }?>
					</td>
					<?php if($user['role']=='admin' || $user['role']=='PMO'){?><td style="width:70px">
						<button class="btn btn-warning  btn-xs" onclick="toggle_visibility('edit_prog_<?php echo $prog['prog']->id?>');"><span class="glyphicon glyphicon-pencil"></span></button>
						<button class="btn btn-danger btn-xs" onclick="delete_program(<?php echo $prog['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
					</td><?php }?>
				</tr>
				<tr id="edit_prog_<?php echo $prog['prog']->id?>" style="display:none"><td></td>
					<div>
					<td colspan=7>
						<form class="form-horizontal" action="<?php echo base_url();?>initiative/submit_initiative/<?php echo $prog['prog']->id?>" method ="post" id="formsignup" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">Program</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="title" name="title" placeholder="Initiative" value="<?php echo $prog['prog']->title?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Id</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="code" id="code" placeholder="Id" value="<?php echo $prog['prog']->code?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" id="description<?php echo $prog['prog']->id?>" name="description"><?php echo $prog['prog']->description?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label"></label>
								<div class="col-sm-4"><input type="submit" class="btn btn-success"></div></div>
						</form>
						<script>
							CKEDITOR.replace('description'+<?php echo $prog['prog']->id?>);
						</script>
					</div>
				</tr>
				<?php $i++;}}?>
			</tbody>
		</table>
	</div><div style="clear:both"></div><br>
</div>
<script>
	function delete_program(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"initiative/delete_program",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#prog_'+id).animate({'opacity':'toggle'});
							succeedMessage('Workblock berhasil dihapus');
						}
					}
				});
			}
		});
	}
</script>