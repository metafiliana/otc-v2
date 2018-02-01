<?php
	foreach($programs as $prog){
?>
<div class="row">
		<?php if($user['role']=='1'){?>
		<div class="col-md" style="padding-top: 12px;">
			<div style="padding-left: 15px;">
				<b><?php echo $prog['prog']->init_code?>. <?php echo $prog['prog']->title?></b>
			</div>
			<div>
				<div class="panel panel-default" style="margin-top: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
				<div class="panel-body">
				<table class="table table-hover table-responsive">
					<thead class="black_color">
						<tr>
							<th style="width: 50px; vertical-align: middle;" rowspan="2">No</th>
							<th rowspan="2" style="vertical-align: middle;">KPI Metric</th>
							<th rowspan="2" style="vertical-align: middle;">Measurement</th>
							<th rowspan="2" style="vertical-align: middle;">Baseline <br> <?= $year_view-1 ?></th>
							<?php if($user['role']=='1'){?>
							<th colspan="9" style="vertical-align: middle;"><?= $month_view ?> <?= $year_view?></th>
							<?php } else {?>
							<th colspan="8" style="vertical-align: middle;"><?= $month_view ?> <?= $year_view?></th>
							<?php } ?>
						</tr>
						<tr>
							<th><?= $month_view ?></th>
							<?php if($user['role']=='1'|| $user['role']=='2'){?>
							<th></th>
							<?php }?>
							<th>Monthly Target</th>
							<th>Year End Target</th>
							<th>Monthly Kinerja</th>
							<th>Year End Kinerja</th>
							<th>YTD</th>
							<th>Full Year(FY)</th>
							<th></th>
						</tr>
						<tr class="orange_color_bg">
							<th>Leading</th>
						</tr>
					</thead>
					<tbody class="center_text">
					<?php $check=0; $i=1; foreach($prog['leading'] as $d) { ?>
					<tr id='kuantitatif_<?= $d['prog']->id ?>'>
						<td><?php echo $i++?></td>
				    <td><?php echo $d['prog']->metric;?></td>
				    <td><?php echo $d['prog']->measurment;?></td>
						<td><?php echo number_format($d['prog']->baseline,2,",","."); ?></td>
						<td>
							<?php echo number_format($d['update']->$month_view,2,",","."); ?>
						</td>
						<?php if($user['role']=='1' || $user['role']=='2'){?>
						<td>
							<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $d['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
						</td>
						<?php }?>
						<td><?php echo number_format($d['target']->$month_view,2,",",".");?></td>
						<td><?php echo number_format($d['prog']->target,2,",","."); ?></td>
						<td><?php echo number_format((($d['month_kiner'])*100),0,",",".");?> %</td>
						<td><?php echo number_format((($d['year_kiner'])*100),0,",",".");?> %</td>
						<?php if($check==0){ ?>
							<td rowspan="<?= $prog['count_leading'] ?>" style="vertical-align: middle;">
								<div class=circle style='background:<?= warna(($prog['tot_leading']['month']*100)/$prog['count_leading'],'Leading')?>'></div>
								<?= number_format(maxscore(($prog['tot_leading']['month']*100)/$prog['count_leading'],'Leading'),2,",","."); ?> %
							</td>
							<td rowspan="<?= $prog['count_leading'] ?>" style="vertical-align: middle;">
								<div class=circle style='background:<?= warna(($prog['tot_leading']['year']*100)/$prog['count_leading'],'Leading')?>'></div>
								<?= number_format(maxscore(($prog['tot_leading']['year']*100)/$prog['count_leading'],'Leading'),2,",","."); ?> %
							</td>
						<?php } ?>
						<?php if($user['role']=='2'){?>
							<td>
								<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $d['prog']->init_id?>,'<?php echo $d['prog']->init_code?>',<?php echo $d['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
								<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $d['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
						<?php }?>
					</tr>
				    <?php $check=1; } ?>

					</tbody>

					<tr class="orange_color_bg">
						<th>Lagging</th>
					</tr>
					<tbody class="center_text">
					<?php $check=0; $i=1; foreach($prog['lagging'] as $e) { ?>
						<tr id='kuantitatif_<?= $e['prog']->id ?>'>
							<td><?php echo $i++?></td>
					    <td><?php echo $e['prog']->metric;?></td>
					    <td><?php echo $e['prog']->measurment;?></td>
							<td><?php echo number_format($e['prog']->baseline,2,",","."); ?></td>
							<td>
								<?php echo number_format($e['update']->$month_view,2,",","."); ?>
							</td>
							<?php if($user['role']=='1'|| $user['role']=='2'){?>
							<td>
									<a class="btn btn-link btn-link-edit" onclick="update_realisasi(<?php echo $e['prog']->id?>,'<?= $month_view ?>','<?= $month_number?>');"><span class="glyphicon glyphicon-pencil"></span></a>
							</td>
							<?php }?>
							<td><?php echo number_format($e['target']->$month_view,2,",","."); ?></td>
							<td><?php echo number_format($e['prog']->target,2,",","."); ?></td>
							<td><?php echo number_format(($e['month_kiner']*100),0,",",".");?> %</td>
							<td><?php echo number_format(($e['year_kiner']*100),0,",",".");?> %</td>
							<?php if($check==0){ ?>
								<td rowspan="<?= $prog['count_lagging'] ?>" style="vertical-align: middle;">
									<div class=circle style='background:<?= warna(($prog['tot_lagging']['month']*100)/$prog['count_lagging'],'Lagging')?>'></div>
									<?= number_format(maxscore(($prog['tot_lagging']['month']*100)/$prog['count_lagging'],'Lagging'),2,",","."); ?> %
								</td>
								<td rowspan="<?= $prog['count_lagging'] ?>" style="vertical-align: middle;">
									<div class=circle style='background:<?= warna(($prog['tot_lagging']['year']*100)/$prog['count_lagging'],'Lagging')?>'></div>
									<?= number_format(maxscore(($prog['tot_lagging']['year']*100)/$prog['count_lagging'],'Lagging'),2,",","."); ?> %
								</td>
							<?php } ?>
							<?php if($user['role']=='2'){?>
								<td>
									<a class="btn btn-link btn-link-edit" onclick="input_kuantitatif(<?php echo $e['prog']->init_id?>,'<?php echo $e['prog']->init_code?>',<?php echo $e['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
									<a class="btn btn-link btn-link-delete" onclick="delete_kuantitatif(<?php echo $e['prog']->id?>)"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							<?php }?>
						</tr>
				    <?php $check=1;} ?>
					</tbody>
				</table>
				</div>
				</div>
			</div>
		</div>
	<?php } else if($user['role']=='2'){ ?>
		<div class="col-md-11" style="padding-top: 12px; padding-bottom:20px; padding-left: 15px;">
		<a onclick="show_detail('<?php echo $prog->id?>')"><b><?php echo $prog->init_code?>. <?php echo $prog->title?></b></a>
		</div>
		<div class="col-md-1" style="padding-top: 8px; position: relative;">
			<button onclick="input_kuantitatif(<?php echo $prog->id?>,'<?php echo $prog->init_code?>','');" class="btn btn-info-new btn-sm right_text"><span class="glyphicon glyphicon-plus"></span> Kuantitatif</button>
		</div><div style="clear:both"></div>
		<div class="col-md" id="detail_<?php echo $prog->id?>" style="display:none;">
		</div>
	<?php } ?>
</div>
<hr />
<div style="clear:both"></div>
<?php }?>
<script>
function show_detail(id){
    	$.ajax({
			type: "GET",
			url: config.base+"kuantitatif/test",
			data: {id:id, month:$("#month").val(), year:$("#year").val()},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#detail_"+id).html(resp.html);
					toggle_visibility("detail_"+id);
				}else{}
			}
		});
    }
</script>
