<td colspan=8>
	<div>
		<div style="width:100%" id="header_upd">
			<h4>Updates Issue</h4>
			<div>
				<div id="content_ui_<?php echo $ms->id?>" style="width:45%; float:left;">Content</div>
				<div style="width:55%; float:left;">
					<h5>New Update Issue</h5>
					<div class="form-group">
						<div class="col-sm-12">
							<form class="form-horizontal" action="<?php echo base_url()?>milestone/submit_update_issue/<?php echo $ms->id?>" method ="post" id="formupdateissue_<?php echo $ms->id?>" role="form">
								<textarea type="text" class="form-control" id="updateissue_ipt_<?php echo $ms->id?>" name="content">
									<b>Perkembangan / Issue : </b><br><hr>
									<b>Action Plan : </b><br><hr>
									<b>Notes : </b><br><hr>
								</textarea>
								<br>
								<button class="btn btn-success" onclick="submit_update_issue(<?php echo $ms->id?>)">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div><div style="clear:both"></div>
		</div>
	</div>
	<hr>
	<div>
		<div style="width:100%" id="header_tl">
			<h4>Chat Kordinasi</h4>
			<button class="btn btn-default btn-xs" onclick="ipt_tl(<?php echo $ms->id?>)"><span class="glyphicon glyphicon-pencil"></span> Write</button>
			<div id="ipt_tl_<?php echo $ms->id?>" style="margin-top:20px; display:none;">
				<form class="form-horizontal" action="<?php echo base_url()?>milestone/submit_timeline/<?php echo $ms->id?>" method ="post" id="formtimeline_<?php echo $ms->id?>" role="form">
					<div class="col-sm-12">
						<div class="form-group">
							<div class="col-sm-12">
								<textarea type="text" class="form-control" id="timeline_ipt_<?php echo $ms->id?>" name="content"></textarea>
							</div>
						</div>
						<button class="btn btn-success" onclick="submit_timeline(<?php echo $ms->id?>)">Submit</button>
					</div><div style="clear:both"></div>
					
					<hr>
				</form>
			</div>
		</div>
		<div id="content_tl_<?php echo $ms->id?>" style="margin-top:20px">
			<?php echo $cnt;?>
		</div>
	</div>

	<script type="text/javascript">
		CKEDITOR.replace("timeline_ipt_<?php echo $ms->id?>");
		CKEDITOR.replace("updateissue_ipt_<?php echo $ms->id?>");
		
		function ipt_tl(id){
			toggle_visibility('ipt_tl_'+id);
		}
	</script>
</td>