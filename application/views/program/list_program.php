<style>
	.pmo_header{
		margin-right:40px;
	}
	.pmo_header_active a{
		margin-right:40px;
		color: black;
	}
</style>
<div style="padding:5px 10px 5px 0">
	<!-- <div>
		<div style="font-size:16px">
			<span style="color:grey; font-size:11px">Category</span>
			<div>
				<?php 
					foreach($arr_categ as $each){
						$class="pmo_header";
						$segment = str_replace("%20", " ", $this->uri->segment(3));
						if($segment==$each->val){
							$class="pmo_header_active";
						} 
						echo "<span class='".$class."'><a href='".base_url()."program/list_programs/".$each->val."'>".$each->val."</a></span>";
					}
				?>
			</div>
		</div>
	</div>
	<hr>
	<h2><?php echo $segment?></h2> -->
	<div style="">
		<div class="row">
			<div class="col-md-5">
				<div class="component_part">
					<table class="table" style="margin-bottom:0">
						<thead>
							<tr class="black_color">
								<th class="grey_color_bg" style="vertical-align:middle;">Not Started Yet</th>
								<th class="green_color_bg" style="vertical-align:middle;">In Progress</th>
								<th class="red_color_bg" style="vertical-align:middle;">At Risk</th>
								<th class="yellow_color_bg" style="vertical-align:middle;">Delay</th>
								<th class="blue_color_bg" style="vertical-align:middle;">Completed</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php if($page=="all"){?>
			<div class="col-md-3">
				<div class="component_part" style="padding:10px 5px 5px 5px">
					<div>
					<span class="center_text" style="font-size:14px; margin-right:10px;">Filter </span>
	                <select onchange="filter_data();" id="code_filter" name="code_filter"  class="selectpicker show-tick" data-width="100%">
	                    <option value="category">Category</option>
	                    <option value="dir_spon">Direktur Sponsor</option>
	                    <option value="pmo_head">PMO Head</option>
	                </select>
	                </div>
	                <div id="list_of_filter">
	                </div>
                </div>
            </div>
            <?php }?>
            <div style="margin-bottom:10px; float:right;">
				<a onclick="show_form();" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Program</a>
			</div>
		</div>
		<div style="clear:both"></div>
		<div style="clear:both">
			<div class="component_part">
				<table class="table table-hover table-striped">
				<thead class="black_color old_grey_color_bg">
					<tr>
						<th style="vertical-align:middle" rowspan=2>Initiative</th>
						<th style="vertical-align:middle" rowspan=2>Sub Initiative</th>
						<th style="vertical-align:middle" colspan=5><center>Sign</center></th>
						<th style="vertical-align:middle" rowspan=2><center>Total</center></th>
					</tr>
					<tr>
						<th><span class="circle circle-notyet circle-lg text-left"></span></th>
						<th><span class="circle circle-inprog circle-lg text-left"></span></th>
						<th><span class="circle circle-atrisk circle-lg text-left"></span></th>
						<th><span class="circle circle-delay circle-lg text-left"></span></th>
						<th><span class="circle circle-completed circle-lg text-left"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php
						/*usort($programs, function($a, $b) {
							return $a['code'] - $b['code'];
						});*/
					?>
					<?php 
					$segment=""; $i=1; $segnum=1;
					$pv_init = "";
					foreach($programs as $prog){?>
					<tr id="prog_<?php echo $prog['prog']->id?>">
						<!--<td style="width:40px"><?php echo $prog['status']['Not Started Yet']?></td>-->
						<td style="width:400px">
							<?php if($pv_init != $prog['prog']->segment){?>
								<div style="float:left; width:50px; margin-right:5px;"><?php echo $prog['prog']->init_code?></div> 
								<b><div style="float:left; max-width:300px"><?php echo $prog['prog']->segment?></div></b>
								<div style="clear:both"></div>
								<b><div style="float:left; max-width:300px; margin-top:10px">Direktur Sponsor: <?php echo $prog['prog']->dir_spon?></div></b>
								<div style="clear:both"></div>
								<b><div style="float:left; max-width:300px; margin-top:10px">PMO Head: <?php echo $prog['prog']->pmo_head?></div></b>
								<div style="clear:both"></div>
							<?php $pv_init = $prog['prog']->segment;}?>
						</td>
						<td style="width:400px">
							<div style="float:left; width:50px; margin-right:5px;"><?php echo $prog['prog']->code?></div> 
							<div style="float:left; max-width:300px"><a href="<?php echo base_url()?>initiative/list_program_initiative/<?php echo $prog['prog']->id ?>"><?php echo $prog['prog']->title?></a></div>
							<div style="clear:both"></div>
						</td>
						<?php 
							$allstat = return_arr_status(); $total=0;
							foreach($allstat as $stat){
								$color="";
								if($prog['status'][$stat]){
									$color = color_status($stat);
								}
								echo "<td style='background-color:".$color."'><center>".$prog['status'][$stat]."</center></td>";
								$total = $total + $prog['status'][$stat];
							}
						?>
						<td><center><?php echo $total;?></center></td>
						
						<?php if($user['role']=='admin' || $user['role']=='Co-PMO'){?><td style="width:70px">
							<button class="btn btn-warning  btn-xs" onclick="show_form(<?php echo $prog['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></button>
							<button class="btn btn-danger btn-xs" onclick="delete_program(<?php echo $prog['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></button>
						</td><?php }?>
					</tr>
					<tr id="edit_prog_<?php echo $prog['prog']->id?>" style="display:none">
						<div>
						<td colspan=9>
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
									<label for="" class="col-sm-2 control-label"></label>
									<div class="col-sm-4"><input type="submit" class="btn btn-success"></div></div>
							</form>
						</div>
					</tr>
					<?php $i++;}?>
				</tbody>
			</table>
		</div>	
			<!--</div>
		</div>-->
	</div><div style="clear:both"></div><br>
</div>
<script>
	function delete_program(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"program/delete_program",
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

function show_form(id){
    $.ajax({
        type: "GET",
        url: config.base+"program/input_program",
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function filter_data(){
	var code_filter = $("#code_filter").val();
    $.ajax({
        type: "GET",
        url: config.base+"program/filter_data",
        data: {code_filter:code_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               $('#list_of_filter').html(resp.html);
            }else{}
        }
    });
}
</script>