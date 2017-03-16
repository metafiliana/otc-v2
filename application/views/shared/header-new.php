<style>
	.glyphicon-home:hover  {
 	 border-bottom: 5px solid #A8D8F0;
	}

	.sw-open:hover  {
 	 border-bottom: 5px solid #A8D8F0;
	}

	body a.notif{
		color: #afaaa3;
	}
	body a.notif:hover{
		color: #154391 !important;
	}

	.logo_company a:hover{
		text-decoration: none;
	}
	h1,h2,h3,h4,h5{
		padding:0px;
		margin:0;
	}
	.navbar-top {
		background-color:white;
		padding:0 0px 0 0px;
		border-bottom: 1px solid #d3d3d3;
		position: fixed;
		width: 100%;
		z-index: 10;
		height: 50px;
	}
	.second_head{
		position: fixed;
		width: 100%;
		z-index:9;
		background-color: #f4f4f4;
	}
	/*CSS for new CBIC*/
	.neg_text_color{
		color: #e4ba4c;
	}
	.prim_text_color{
		color: #189cb8;
	}
	.neg_color{
		background-color: #e4ba4c;
	}
	.prim_color{
		background-color: #189cb8;
	}
	.container-fluid, body{
		background-color:#f4f4f4 !important;
	}
	body{
		font-size:14px;
	}
	body a{
		color: #137c93;
	}
	body a:hover{
		color: #0b5e90;
	}
	@media (max-width: 768px) {
	  .small_to_show {
	    display:none;
	  }
	}

	.btn{
		border:0px solid transparent; /* this was 1px earlier */
 	}
</style>
<?php 
	$contr = $this->uri->segment(1);
	$func = $this->uri->segment(2);
	$user = $this->session->userdata('user'); $user_disp="";
	$arr_role = explode(";",$user['role']);
	$page_tit=""; if(isset($page_name)){$page_tit = $page_name;}
?>
<div class="navbar-top">
	<div class="row" style="width:100%; margin:0 auto; padding:0px 5px 0px 5px;background-color: #fff; 
	border-bottom:3px solid rgba(252, 209, 22, .8);">
		<div class="col-md-4">
			<div class="btn-group">
				<a href="<?php echo base_url()?>" class="btn btn-default glyphicon glyphicon-home" style="font-size:18px;"></a>
				<div class="dropdown dropdown-notifications sw-open btn btn-default">
				  <span class="dropdown-toggle glyphicon glyphicon-bell" data-toggle="dropdown" style="font-size:18px; padding-top:5px;">
				    <?php if(isset($notif_count) && $notif_count){ ?><i data-count="<?php echo $notif_count;?>" class="notification-icon" style="margin:-10px 0 0 -10px;"></i><?php } ?>
				    <span class="caret"></span>
				  </span>
				  <div class="dropdown-container">
				   <div class="dropdown-toolbar">
				      <div class="dropdown-toolbar-actions">
				        <a onclick="mark_as_read(<?php echo $user['id']?>,'<?php echo $user['role']?>');"><i></i> Mark all as read</a>
				      </div>
				      <h3 class="dropdown-toolbar-title">Notifications (<?php if($notif_count){echo $notif_count;}?>)</h3>
				    </div>
				    <?php if($notif){ foreach ($notif as $notifs ) { ?>
				    <ul class="dropdown-menu notifications">
				      <a href="<?php echo base_url()?>initiative/list_program_initiative/<?php echo $notifs->init_id;?>" onclick="update_notif(<?php echo $notifs->id;?>,'<?php echo $user['role']?>')">
				      <?php echo $notifs->notification; ?>
				      </a>
				    </ul>
				    <hr>
			     	<?php } } ?>
				    <!-- <div class="dropdown-footer text-center">
	                	<a>View All</a>
	              	</div> -->
				  </div>
				</div>
			</div>
		</div>
		<div class="col-md-4 center_text">
			<img style="height:45px; margin-left:0px; padding-bottom: 5px; padding-top: 5px;" src="<?php echo base_url()?>assets/img/general/tower.png">
		</div>
		<div class="col-md-4" style="height:45px; padding:10px 0px 0px 0px;">
			<div class="row">
				<div class="col-md-4 pull-right">
				<div class="black_color" style="font-size:12px;"><?php long_text_all($user['name'],15);?></div>
				<div class="black_color" style="font-size:10px;"><?php echo $user['role']?></div>
				</div><div style="clear:both"></div>
				<div class="col-md-4 dropdown pull-right">
					<button style="margin:-40px 20px 0 0; float:right;" class="btn btn-link btn-xs dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<div style="height:35px; width:35px; border-radius:30px; overflow:hidden; border:1px solid #e3e3e3">
							<img style="height:50px; margin-left:0px;" width="100%" src="<?php echo base_url()?>assets/img/general/no-profile-img.gif">
						</div>
					</button>
					<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu2">
					<?php if($user['role']=='admin'){?>
						<li role="presentation"><a charset="black_color" href="<?php echo base_url()?>user/">User Management</a></li>
						<li class="divider"></li>
					<?php }?>
					<li role="presentation" style="padding:5px 0 5px;">
						<a class="black_color" href="<?php echo base_url()?>user/form_password"><span class="glyphicon glyphicon-lock" style="height: 7px;"></span> Change Password</a>
					</li>
					<li role="presentation" style="padding:5px 0 5px;">
						<a class="black_color" href="<?php echo base_url()?>user/logout"><span class="btn-sm glyphicon glyphicon-off" style="height: 7px;"></span> Log Out</a>
					</li>
					</ul>
				</div><div style="clear:both"></div>
			</div>
			</div>
		</div>
	</div>	
</div>

<script>
$('.dropdown-toggle').dropdown();

function update_notif(id,role){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/update_notification",
			data: {id: id, role:role},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
				}else{}
			}
		});
}

function mark_as_read(user_id,role){
		$.ajax({
			type: "GET",
			url: config.base+"initiative/mark_as_read",
			data: {user_id: user_id, role:role},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					window.location.reload();
				}else{}
			}
		});
}
</script>