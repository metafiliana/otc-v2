<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div id="" class="container no_pad">
				<div class="col-md-12">
					<div class="form-signin">
					<h3 class="form-signin-heading">Input Sub-Initiative</h3>
					<form class="form-horizontal" 
					action="<?php if(isset($all)){
                        echo base_url()."program/submit_program/".$all->id;}
                    else{
                        echo base_url()."program/submit_program/";}?>"
				 	method="post" id="formsignup" role="form">
				 		<div class="form-group">
							<label class="col-sm-3 control-label">Initiative Number</label>
							<div class="col-sm-9">
								<select class="form-control" name="init_code" id="init_code" onchange="change_code();">
									<?php foreach($init_code as $proga){?>
									<option <?php if (isset($all) && $all->init_code == $proga->val ) echo 'selected' ; ?> value="<?php echo $proga->val?>"><?php echo $proga->val?></option>
									<?php }?>
								</select>
								<!-- <input type="text" class="form-control" name="code" id="code" placeholder="Id"> -->
							</div>
						</div>
						<?php if(isset($all)){?>
							<?php echo $all_list?>
						<?php } else{?>
						<div id="all_list">
						</div>
						<?php }?>
						<hr>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
					</form>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
function change_code(){
	var init_code = $("#init_code").val();
    $.ajax({
        type: "GET",
        url: config.base+"program/change_code",
        data: {init_code:init_code},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               $('#all_list').html(resp.html);
            }else{}
        }
    });
}
</script>