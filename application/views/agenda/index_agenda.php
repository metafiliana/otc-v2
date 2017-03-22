<?php
	$sumdate = date("t", mktime(0,0,0, $datereq['month'], 1, $datereq['year']));
	$day = date("N", mktime(0,0,0, $datereq['month'], 1, $datereq['year'])); $firstday = true;
?>
<div class="row">
	<div class="col-md-9">
		<div class="component_part" style="margin-top:50px;">
			<div id="" class="">
				<div style="padding:12px">
					<div>
						<a href="#" onclick="toggle_visibility('tochange_date');" ><h3 style="float:right"><?php echo date("F", mktime(0,0,0, $datereq['month'], 1, $datereq['year']))." ".$datereq['year']?></h3></a>
					</div>
					<div style="margin-top:20px;">
						<a onclick="show_form('','','','');" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Agenda</a>
					</div>
					<div style="clear:both"></div>
					<div style="display:none" id="tochange_date">
						<hr><h4>Change Date</h4>
						<form method="post" action="<?php echo base_url()?>agenda/change_month">
							<select name="month">
								<?php for($m=1;$m<=12;$m++){?>
								<option value="<?php echo $m?>" <?php if($m == $datereq['month']){echo "selected";}?>><?php echo date("F", mktime(0,0,0, $m, 1, $datereq['year']))?></option>
								<?php }?>
							</select>
							<input type="text" placeholder="year" name="year" value="<?php echo $datereq['year']?>">
							<input type="submit" class="btn btn-primary btn-sm">
						</form>
					</div>
				</div>
				<div>
					<div id="agendatable" style="width:100%;">
						<div>
							<div>
								<div class="as headeras">Senin</div>
								<div class="as headeras">Selasa</div>
								<div class="as headeras">Rabu</div>
								<div class="as headeras">Kamis</div>
								<div class="as headeras">Jumat</div>
								<div class="as headeras" style="color:red">Sabtu</div>
								<div class="as headeras" style="color:red">Minggu</div>
							</div>
							<?php 
								$i=1; 
								while($i<=$sumdate){
									echo "<div>";
									for($diw=1;$diw<=7;$diw++){
										if($i<=$sumdate){
											if($firstday && ($day != $diw)){?>
												<div class="as"></div>
											<?php }else{?>
												<div class="as">
													<div><hr style="margin-bottom:5px;"><div style="float:left; top:2px;"><a onclick="show_form(<?php echo $datereq['month'];?>,<?php echo $i;?>,<?php echo $datereq['year'];?>,'');"><?php echo $i?></a></div></div><div style="clear:both"></div>
													<div id="agendaisi">
														<div>
															<?php 
																foreach ($agendas[$i] as $agd){?>
																<div style="margin-bottom:5px;">
																	<div style="float:right; color:grey"><?php echo date("g A", strtotime($agd->start));?></div>
																	<div style="float:left; width:79%"><a href="#" onclick="show_detail(<?php echo $agd->id?>)"><?php echo $agd->title;?></a></div>
																	<div style="clear:both"></div>
																</div>
															<?php }?>
														</div>
														<div style="clear:both"></div>
													</div>
												</div>
												<?php 
												$i++; $firstday=false;
											}
										}
									}
									echo "<div style='clear:both'></div></div>";
							}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="component_part" style="margin-top:50px;">
			<div><h3 style="float:right; margin-bottom:10px;">Last Agenda</h3></div><div style="clear:both"></div>
			<?php foreach ($last_agenda as $la) { ?>
			<div>
				<a onclick="show_detail(<?php echo $la->id?>)">
				<div>
					<div style="margin-bottom:0px; font-size:16px">
						<?php echo substr($la->title, 0,60); if(strlen($la->title)>60){echo "...";}?>
					</div>
					<div style="font-size:12px" class="helper-text"><?php echo date('j M y', strtotime($la->start))?></div>
				</div>
				</a>
			</div>
			<hr>	
			<?php } ?>
		</div>
	</div>
</div>

<script>
	function show_form(month,day,year,id){
    $.ajax({
        type: "GET",
        url: config.base+"agenda/input_agenda",
        data: {month:month,day:day,year:year,id:id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
	}

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
	function show_detail(id){
		$.ajax({
			type: "GET",
			url: config.base+"agenda/get_detail",
			data: {id: id},
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
</script>
<style>
	#agendatable th{
		text-align:center;
		width:14%;
	}
	#agendaisi{
		font-size:11px;
	}
	.as{
		float:left;
		width:14%;
		padding:5px;
	}
	.headeras{
		text-align:center;
		font-weight:bold;
	}
</style>