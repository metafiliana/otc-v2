<?php $segment=""; $i=1; $segnum=1; $pv_init = ""; $total_percent=""; $code="";
	foreach($programs as $prog){
?>
<div class="row">
	<div style="text-align:center" class="col-md-3">
		<?php if($pv_init != $prog['prog']->segment){
			if(str_replace(".",'',$prog['prog']->init_code)){$code=str_replace(".",'',$prog['prog']->init_code); }
			else{$code=$prog['prog']->init_code;}
		?>
		<a onclick="show_detail('<?php echo $prog['prog']->init_code?>','<?php echo $code?>');"><div style="float:left; max-width:300px"><b><?php echo $prog['prog']->init_code?>. <?php echo $prog['prog']->segment?></b></div></a>
		<b><div style="float:left; max-width:300px; margin-top:10px">Direktur Sponsor: <?php echo $prog['prog']->dir_spon?></div></b>
		<div style="clear:both"></div>
		<b><div style="float:left; max-width:300px; margin-top:10px">PMO Head: <?php echo $prog['prog']->pmo_head?></div></b>
		<div style="clear:both"></div>
		<b><div style="float:left; max-width:300px; margin-top:10px">Total Completed: <?php if($prog['wb_completed']!=0) {echo number_format((($prog['wb_completed']/$prog['tot_wb_init_code'])*100),2);} else{echo "0";}?> %</div></b>
		<div style="clear:both"></div>
		<hr>
		<?php $pv_init = $prog['prog']->segment;}?>
	</div>
	<div class="col-md-9" id="detail_<?php echo $code?>" style="display:none;">
	</div>
</div>
<?php $i++;}?>
<script>
function show_detail(init_code,code){
    	$.ajax({
			type: "GET",
			url: config.base+"program/detail_program",
			data: {init_code:init_code,code:code},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#detail_"+code).html(resp.html);
					toggle_visibility("detail_"+code);
				}else{}
			}
		});
    }
</script>