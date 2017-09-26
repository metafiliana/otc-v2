<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<?php $user = $this->session->userdata('user');?>
<script>
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}

    $("#formagenda").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				//required: true,
				minlength: 5
			},
			verify_password: {
				//required: true,
				equalTo: "#password"
			},
			name: "required",
		},
		messages: {
			username: {
				required: "Please enter an username"
			},
			password_su: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			verify_password: {
				required: "Please provide a password",
				equalTo: "Please enter the same password as above"
			},
			agree: "Please accept our policy"
		}
	});
});
</script>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
				<div id="" class="container no_pad">
					<div class="col-md-10">
						<div class="form-signin">
						<h3 class="form-signin-heading">Form Agenda</h3>
						<form class="form-horizontal" action="<?php if($agenda){echo base_url()."agenda/submit_agenda/".$agenda->id;}else{echo base_url()."agenda/submit_agenda";}?>" method ="post" id="formagenda" role="form" enctype="multipart/form-data">
							 <div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" placeholder="Title"<?php if($agenda){echo "value='".$agenda->title."'";}?>>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Location</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="location" name="location" placeholder="Location" <?php if($agenda){echo "value='".$agenda->location."'";}?>>
								</div>
							</div>
							 <div class="form-group">
								<label for="" class="col-sm-2 control-label">Date</label>
								<div class="col-sm-8">
									<?php if(isset($choose_date)){$choose_date = $choose_date;} if(isset($agenda->start)){$choose_date = date("m/d/Y", strtotime($agenda->start));}?>
									<input type="text" class="form-control" id="start" name="start" placeholder="mm/dd/YYYY" value="<?php if(isset($choose_date)) echo $choose_date?>" >
									<small style="color:grey">*format: mm/dd/YYYY</small>
								</div>
								<div class="col-sm-2">
									<?php $start_time="08:00"; if($agenda){if($agenda->start){$start_time = date("h:i", strtotime($agenda->start));}}?>
									<input type="text" class="form-control" id="start_time" name="start_time" placeholder="hh:mm" value="<?php echo $start_time?>">
									<small style="color:grey">*format: hh:mm</small>
								</div>
								<!--
								<div class="col-sm-2">
									<input type="text" class="form-control" id="end" name="end" placeholder="mm/dd/YYYY">
									<small style="color:grey">*format: mm/dd/YYYY</small>
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="end_time" name="end_time" placeholder="hh:mm">
									<small style="color:grey">*format: hh:mm</small>
								</div>-->
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" name="description">
									<?php if($agenda){echo $agenda->description;}else{?>
									<?php }?>
									</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label input-md">Attachment</label>
								<div class="col-sm-10">
									<input type="file" name="attachment[]" class="btn-md" multiple="">
								    <div style="margin-top:10px">
								        <?php if($files){ foreach($files as $file){?>
								        <div title="<?php echo $file->title?>" id="file_<?php echo $file->id?>" style="margin-top:10px;">
								        <a href=<?php echo base_url()?><?php echo $file->full_url?>>
								            <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file->ext)?>"></span>
								            <span title="<?=$file->title?>"><?php long_text_real($file->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
								        </a>
								        <?php if($user['id'] == $file->user_id||$user['role']=='2'){?>
								            <a class="pull-right" onclick="delete_file(<?php echo $file->id?>)">
								                <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
								            </a><div style="clear:both"></div>
								        <?php }?>
								        </div>
								        <?php } } else{  ?>
								        <h5 class="center_text">No File</h5>
								        <?php } ?>
								        <div style="clear:both"></div>
								    </div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<button class="btn btn-md btn-primary btn-block" type="submit">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('input[type=file]').bootstrapFileInput();
	});
	$('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	CKEDITOR.replace('description');

	function delete_file(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "GET",
            url: config.base+"general/delete_file",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#file_'+id).animate({'opacity':'toggle'});
              }else{
                console.log('action after failed');
              }
            }
          });
        },
    });
    }
</script>
