<div id="" class="content_cbic" style="padding-right:40px;">
	<div class="each_part_cbic bg_part_one">
		<div class="content_each_part_cbic">
			<form class="form-horizontal" id="form_upload_file" action="<?php echo base_url()?>general/submit_input_file" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<h2 class="center_text">Input File Control Tower</h2><br>
				<div class="form-group">
					<label class="col-sm-1 control-label input-md">For</label>
					<div class="col-sm-3">
						<select class="form-control" name="file_for">
							<option value="action">Action</option>
							<option value="user">User</option>
							<option value="kuantitatif">Kuantitatif</option>
						</select>
					</div><div style="clear:both"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label input-md">File</label>
					<div class="col-sm-6">
						<input type="file" name="userfile" class="btn btn-default">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label input-md">Year</label>
					<div class="col-sm-2">
						<select class="form-control" name="year">
							<?php for($i=2015;$i<=2020;$i++){?>
								<option value="<?php echo $i?>"><?php echo $i?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label input-sm"></label>
					<div class="col-sm-4">
						<div style="margin-bottom:30px;">
							<button class="btn btn-lg btn-wsa-green btn-md" type="submit">Submit</button>
						</div>
						<div id="progress" class="progress"  style="display:none;">
							<div id="bar" class="bar"></div>
							<div id="percent" class="percent"></div >
						</div>
						<div id="message" class="message"></div>
					</div><div style="clear:both"></div>
				</div>
			</form>


			<hr><div style="clear: both;"></div>
			<div class="center_text">
				<h2>Last File Upload</h2>
				<div class="row" style="margin: 0 auto; padding-top:20px;">
					<div class="col-md-2">
						<h4>Action</h4>
							<div style="margin-top:10px">
							<?php if($action){ foreach($action as $file3){?>
							<div>
							    <a href=<?php echo base_url()?><?php echo $file3->full_url?>>
							        <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file3->ext)?>"></span>
							        <span title="<?=$file3->title?>"><?php long_text_real($file3->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
							    </a>
							</div>
							    <?php } } else{  ?>
							    <h5 class="center_text">No File</h5>
							    <?php } ?>
							    <div style="clear:both"></div>
							</div>
					</div>
					<div class="col-md-2">
						<h4>User</h4>
							<div style="margin-top:10px">
							<?php if($user){ foreach($user as $file4){?>
							<div>
							    <a href=<?php echo base_url()?><?php echo $file4->full_url?>>
							        <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file4->ext)?>"></span>
							        <span title="<?=$file4->title?>"><?php long_text_real($file4->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
							    </a>
							</div>
							    <?php } } else{  ?>
							    <h5 class="center_text">No File</h5>
							    <?php } ?>
							    <div style="clear:both"></div>
							</div>
					</div>
					<div class="col-md-2">
						<h4>Kuantitatif Target</h4>
							<div style="margin-top:10px">
							<?php if($kuantitatif){ foreach($kuantitatif as $file5){?>
							<div>
							    <a href=<?php echo base_url()?><?php echo $file5->full_url?>>
							        <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file5->ext)?>"></span>
							        <span title="<?=$file5->title?>"><?php long_text_real($file5->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
							    </a>
							</div>
							    <?php } } else{  ?>
							    <h5 class="center_text">No File</h5>
							    <?php } ?>
							    <div style="clear:both"></div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('.datepicker').datepicker();
		$('input[type=file]').bootstrapFileInput();
	});
</script>
