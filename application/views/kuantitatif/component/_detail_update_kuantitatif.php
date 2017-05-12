<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div>
					<h4 class="center_text">Detail Update <?php echo $detail->metric; ?></h4>
					<h5 class="center_text"><?php echo $detail->title; ?></h5>
					<h5 class="center_text">Target <?php echo $detail->target_year; ?>: <?php echo $detail->target; ?></h5>
				</div>
				<table class="table table-hover" style="margin-top:20px;">
				<thead class="black_color old_grey_color_bg">
				    <tr>
				        <th style="vertical-align:middle">Month</th>
				        <th style="vertical-align:middle">Amount</th>
				    </tr>
			    </thead>
			    <tbody>
				    <?php if($update){ ?>
					    <?php foreach($update as $updates){ ?>
					    	<tr>
					    		<td class="center_text"><?php echo date('F',mktime(0,0,0, $updates->month,10));?></td>
					    		<td class="center_text"><?php echo $updates->amount; ?></td>
					    	</tr>
				    	<?php } ?>
		    	 	<?php } else{ ?>
					<tr>
			    		<td class="center_text">No Update</td>
			    		<td class="center_text">No Update</td>
		    		</tr>
		    		<?php }?>
			    </tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
</div>
