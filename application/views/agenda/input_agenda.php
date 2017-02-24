<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>

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
						<form class="form-horizontal" action="<?php if($agenda){echo base_url()."agenda/submit_agenda/".$agenda->id;}else{echo base_url()."agenda/submit_agenda";}?>" method ="post" id="formagenda" role="form">
							 <div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" placeholder="Title">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Location</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="location" name="location" placeholder="Location">
								</div>
							</div>
							 <div class="form-group">
								<label for="" class="col-sm-2 control-label">Date</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="start" name="start" placeholder="mm/dd/YYYY" <?php if($choose_date){echo 'value="'.$choose_date.'"';}?>>
									<small style="color:grey">*format: mm/dd/YYYY</small>
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="start_time" name="start_time" placeholder="hh:mm" value="08:00">
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
									<textarea type="text" class="form-control" name="description"></textarea>
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
	
	$('#start').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	$('#end').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	CKEDITOR.replace('description');
</script>