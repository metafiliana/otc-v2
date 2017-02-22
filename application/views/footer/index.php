<link href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet"/>
<?php
	$bahasa = $this->session->userdata('bahasa');
	$class_comp = "";
    $class_pol = "";
    $class_cont = "";
    $class_htb = "";
    $class_term = "";
    if($this->uri->segment(2)=="company"){
    	$class_comp = "active";
    }else if($this->uri->segment(2)=="policy"){
    	$class_pol = "active";
    }else if($this->uri->segment(2)=="contact"){
    	$class_cont = "active";
    }else if($this->uri->segment(2)=="htb"){
    	$class_htb = "active";
    }else if($this->uri->segment(2)=="term"){
    	$class_term = "active";
    }
?>
<style>
	#footer_content a{
		color:#999;
	}
</style>
<div id="fill_scroll">
	<div class="container" margin-bottom:20px;">
		<div class="row">
			<div class="col-md-12">
				<div style="float:right; display:inline; margin-top:20px;">
					<ul class="nav nav-pills">
						<li class="<?php echo $class_comp?>"><a href="<?php echo base_url()?>footer/company/"><?php if($bahasa=='eng'){echo "Company";}else{ echo "Tentang Kami";}?></a></li>
						<li class="<?php echo $class_pol?>"><a href="<?php echo base_url()?>footer/policy/"><?php if($bahasa=='eng'){echo "Policies";}else{ echo "Kebijakan";}?></a></li>
						<li class="<?php echo $class_cont?>"><a href="<?php echo base_url()?>footer/contact/"><?php if($bahasa=='eng'){echo "Contact Us";}else{ echo "Hubungi Kami";}?></a></li>
						<li class="<?php echo $class_term?>"><a href="<?php echo base_url()?>footer/term/"><?php if($bahasa=='eng'){echo "Terms and Agreement";}else{ echo "Syarat dan Ketentuan";}?></a></li>
						<li class="<?php echo $class_htb?>"><a href="<?php echo base_url()?>footer/htb/"><?php if($bahasa=='eng'){echo "How to Buy";}else{ echo "Cara Berbelanja";}?></a></li>
					</ul>
				</div>
				<h2 style="float:left; display:inline; margin-bottom:-10px;">DYNC INFO</h2>
				<div style="clear:both"></div><hr>
				<div id="footer_content">
					<?php echo $footer_content;?>
				</div>
				<?php echo $follow?>
			</div>
		</div>
	</div>
</div>