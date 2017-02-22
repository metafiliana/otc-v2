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
	<div>
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
	<h2><?php echo $segment?></h2>
	<div style="">
		<div style="margin-bottom:10px; float:right;">
		<a onclick="show_form();" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> Program</a>
		</div>
		
		<div style="margin-bottom:10px; float:left">
			<span class="circle circle-notyet circle-lg text-left"></span>Not Started Yet
			<span class="circle circle-inprog circle-lg text-left" style="margin-left:10px"></span>In Progress
			<span class="circle circle-atrisk circle-lg text-left" style="margin-left:10px"></span>At Risk
			<span class="circle circle-delay circle-lg text-left" style="margin-left:10px"></span>Delay
			<span class="circle circle-completed circle-lg text-left" style="margin-left:10px"></span>Completed
		</div>
		<div style="clear:both">
				<table class="table table-bordered">
				<thead style="background-color:#5bc0f0; color:white">
					<tr>
						<th style="vertical-align:middle" rowspan=2>Initiative</th>
						<th style="vertical-align:middle" rowspan=2>Sub Initiative</th>
						<th style="vertical-align:middle" colspan=5><center>Initiative Status</center></th>
						<th style="vertical-align:middle" rowspan=2>Total</th>
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
						
						<?php if($user['role']=='admin' || $user['role']=='PMO'){?><td style="width:70px">
							<button class="btn btn-warning  btn-xs" onclick="toggle_visibility('edit_prog_<?php echo $prog['prog']->id?>');"><span class="glyphicon glyphicon-pencil"></span></button>
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
			<!--</div>
		</div>-->
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

	function show_form(){
    $.ajax({
        type: "GET",
        url: config.base+"program/input_program",
        data: {},
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