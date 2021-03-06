<table class="table table-hover table-striped">
	<thead class="black_color old_grey_color_bg">
		<tr>
			<th style="vertical-align:middle" rowspan=2>Initiative</th>
			<th style="vertical-align:middle" rowspan=2>Sub Initiative</th>
			<th style="vertical-align:middle" rowspan=2>Last Update</th>
			<th style="vertical-align:middle" colspan=5><center>Sign</center></th>
			<th style="vertical-align:middle" rowspan=2><center>Total</center></th>
			<th rowspan=2>
				<div style="margin-bottom:10px; float:right;">
					<a onclick="show_form();" class="btn btn-info-new btn-sm"><span class="glyphicon glyphicon-plus"></span> Sub Initiative</a>
				</div>
			</th>
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
				<div style="float:left; width:50px; margin-right:5px;"><?php echo substr($prog['prog']->code, -1)?></div> 
				<div style="float:left; max-width:300px"><a href="<?php echo base_url()?>initiative/list_program_initiative/<?php echo $prog['prog']->id ?>"><?php echo $prog['prog']->title?></a></div>
				<div style="clear:both"></div>
			</td>
			<td>
				<div style="float:left; width:50px; margin-right:15px;"><?php if(isset($prog['lu']->last_update)) echo $prog['lu']->last_update?></div> 
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
			
			<?php if($user['role']=='admin'){?><td style="width:70px">
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