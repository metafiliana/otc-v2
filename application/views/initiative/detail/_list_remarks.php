<?php $user = $this->session->userdata('user'); ?>
<?php foreach($remarks as $remark){?>
	<div style="border-bottom:1px solid #eee; padding:5px 0 5px 5px;" id="remark_<?php echo $remark->id?>">
	<h5>Comment</h5>
		<div style="padding-right: 10px; padding-left:5px; font-size:11px; color:#bbb;">
			<div style="float:left">
				<div><b><?php echo date("d M y",strtotime($remark->created))?></b></div>
				<div>by : <?php echo $remark->user_name ?></div>
			</div>
			<div style="float:right">
				<?php if($user['role']=='admin' || $remark->user_name==$user['name']){?>
				<button onclick="edit_remark(<?php echo $remark->id?>,<?php echo $remark->initiative_id?>,'');" class="btn btn-warning btn-xs" style="height:20px; width:20px; padding:0; margin-left:5px"><span class="glyphicon glyphicon-pencil"></span></button>
				<button onclick="delete_remark(<?php echo $remark->id?>);"class="btn btn-danger btn-xs" style="height:20px; width:20px; padding:0; margin-left:0px"><span class="glyphicon glyphicon-trash"></span></button>
				<?php } ?>
			</div>
			<div style="clear:both"></div>
		</div>
		<div style="padding-right: 10px; padding-left:5px; margin-top:5px;">
			<p><?php echo $remark->content ?></p>
		</div>
	</div>
<?php }?>