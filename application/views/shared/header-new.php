<style>
	span.glyphicon-home:hover  {
 	 color: #154391 !important;
	}
	.home_glyph{
		color: #afaaa3;
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
	#popup_cbic_menu{
		border:1px solid #dedede; 
		margin:0px 0 0 20px; 
		border-radius:5px; 
		width:840px;
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
			<span style="margin-right:5px;margin-left: 40px;" class="btn btn-lg glyphicon glyphicon-home home_glyph" aria-hidden="true"></span>
		  	<span style="margin-right:5px;" class="btn btn-lg glyphicon glyphicon-home dropdown-toggle home_glyph" aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
			  <ul class="dropdown-menu">
			    <li><a href="#">Action</a></li>
			    <li><a href="#">Another action</a></li>
			    <li><a href="#">Something else here</a></li>
			    <li role="separator" class="divider"></li>
			    <li><a href="#">Separated link</a></li>
			  </ul>
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
					<button style="margin:-40px 30px 0 0; float:right;" class="btn btn-link btn-xs dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<div style="height:35px; width:35px; border-radius:30px; overflow:hidden; border:1px solid #e3e3e3">
							<img style="height:50px; margin-left:0px;" width="100%" src="<?php echo base_url()?>assets/img/general/no-profile-img.gif">
						</div>
					</button>
					<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu2">
					<li role="presentation" style="padding:5px 0 5px;">
						<a role="menuitem" tabindex="-1" href="<?php echo base_url()?>updates" style="color:#189cb8;">
							<img style="height:18px; margin-right:10px;" src=""> Home
						</a>
					</li>
					<li role="presentation" style="padding:5px 0 5px;">
						<a role="menuitem" tabindex="-1" href="<?php echo base_url()?>mypage" style="color:#189cb8;">
							<img style="height:18px; margin-right:10px;" src=""> My Page
						</a>
					</li>
					<li role="presentation" style="padding:5px 0 5px;">
						<a role="menuitem" tabindex="-1" onclick="show_external_link()" style="color:#189cb8;">
							<img style="height:18px; margin-right:10px;" src=""> External Link
						</a>
					</li>
					<li role="presentation" style="padding:5px 0 5px;">
						<a class="black_color" href="<?php echo base_url()?>user/logout"><span class="btn-lg glyphicon glyphicon-off" style="height: 10px;"></span> Log Out</a>
					</li>
					<li class="divider"></li>
					</ul>
				</div><div style="clear:both"></div>
			</div>
			</div>
		</div>
	</div>	
</div>

<script>
$(document).ready(function(){
    $('.dropdown-toggle').dropdown()
});
</script>