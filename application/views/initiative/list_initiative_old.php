<div style="padding:5px 10px 5px 0">

	<h2><?php echo $segment?> Initiative</h2>
	<div>
		<?php $roles = explode(',',$user['role']); if(in_array("PMO",$roles) || in_array("admin",$roles)){?><div style="margin-bottom:10px; float:right;">
		<button onclick="toggle_visibility('new_initiative');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Initiative</button>
		</div><?php }?>
		
		<div style="margin-bottom:10px; float:left">
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>" style="color:black">Status:</a>
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>/nsy" style="color:black"><button class="btn btn-inverse btn-xs"><span style="color:grey" class="glyphicon glyphicon-off"></span></button><span style="margin-right:10px"> Not Started Yet</span></a>
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>/progress" style="color:black"><button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-refresh"></span></button><span style="margin-right:10px"> On Progress</span></a>
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>/completed" style="color:black"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-ok"></span></button><span style="margin-right:10px"> Completed</span></a>
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>/risk" style="color:black"><button class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-exclamation-sign"></span></button><span style="margin-right:10px"> At Risk</span></a>
			<a href="<?php echo base_url()?>initiative/list_initiative/<?php echo $this->uri->segment(3)?>/delay" style="color:black"><button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><span> Delay</span></a>
		</div>
		<div style="clear:both"></div>
		
		<div id="new_initiative" style="display:none">
			<?php echo $form_new?>
		</div>
		
		<table class="table table-bordered">
			<thead>
				<tr class="headertab"><th style="width:60px">Prgm</th><th colspan=3>Initiatives</th><th>WB</th><th>PIC</th><th style="width:24%">Date</th></tr>
			</thead>
			<tbody>
				<?php
					usort($ints, function($a, $b) {
						return $a['code'] - $b['code'];
					});
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
				<tr style="background-color:#F0EBA8; font-size:14px">
					<td colspan=7><?php echo $int['int']->progcode?><span style="margin-left:10px"><?php echo $int['int']->program?></span>
					</td>
				</tr>
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
						<div style="float:left; width:<?php echo $codewdth?>%; margin-right:5px;"><?php echo $int['int']->code?></div> 
						<div style="float:left; max-width:88%"><a href="<?php echo base_url()?>initiative/detail/<?php echo $int['int']->id?>"><?php echo $int['int']->title?></a></div>
						<div style="clear:both"></div>
					</td>
					<td style="width:40px"><button class="btn btn-default btn-xs" onclick="show_descript(<?php echo $int['int']->id?>,'<?php echo $segment?>')"><span class="glyphicon glyphicon-list"></span></button></td>
					<td style="text-align:right; width:20px"><?php echo $int['wb']?></td>
					<td>
					<?php $sumpic = count($int['pic']); $i=1;
						if($int['pic'] && !$int['child']){
							foreach($int['pic'] as $pic){
								$namaar = explode(' ',$pic->name);
								echo $namaar[0];
								if($i<$sumpic){
									echo ", ";
								} $i++;
							}
						}?>
					</td>
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
					<?php if($user['role']=='admin' || $user['role']=='PMO'){?><td style="width:80px">
						<button class="btn btn-warning  btn-xs" onclick="edit_init(<?php echo $int['int']->id?>,'<?php echo $segment?>');"><span class="glyphicon glyphicon-pencil"></span></button>
						<button class="btn btn-danger btn-xs" onclick="delete_initiative(<?php echo $int['int']->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
					</td><?php }?>
				</tr>
				
				<!--FORM EDIT BOS -->
				<tr id="edit_int_<?php echo $int['int']->id?>" style="display:none"><td></td></tr>
				
				
				<?php }}?>
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
</script>