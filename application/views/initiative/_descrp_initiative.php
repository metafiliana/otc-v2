<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" id="description_li" class="choice active" onclick="change_view('description_li')"><a>Description</a></li>
  <li role="presentation" id="dependency_li" class="choice" onclick="change_view('dependency_li')"><a>Dependency</a></li>
</ul>
<br>
<div id="description">
	<?php $dependen = array('ko','cp'); echo $int['init']->description?>
</div>
<div style="display:none;" id="dependency">
	<?php foreach($dependen as $one_dep){?>
	<div>
		<h4><?php if($one_dep == "ko"){if($int['ko']){echo "Kick off";}}else{if($int['cp']){echo "Completion";}}?></h4>
		<?php foreach($int[$one_dep] as $ko){?>
			<div style="margin-bottom:5px">
				<?php 
					if($ko['stat']=="Delay"){$clr="danger"; $icn="remove";}
					elseif($ko['stat']=="In Progress"){$clr="success"; $icn="refresh";}
					elseif($ko['stat']=="Completed"){$clr="primary"; $icn="ok";}
					elseif($ko['stat']=="At Risk"){$clr="warning"; $icn="exclamation-sign";}
					else{$clr="inverse"; $icn="off";}
					
				?>
				<div style="float:left; width:5%; margin-right:5px;">
					<button class="btn btn-<?php echo $clr?> btn-xs" disabled><span class="glyphicon glyphicon-<?php echo $icn?>"></span></button>
				</div>
				<!--<div style="color:#337ab7; float:left; width:10%;">
					<center><h5><?php echo segment_abv($log->segment)?></h5></center>
				</div>-->
				<div style="float:left; width:7%; margin-right:5px;"><?php echo $ko['init']->code?></div> 
				<div style="float:left; max-width:70%"><a href="<?php echo base_url()?>initiative/detail/<?php echo $ko['init']->id?>"><?php echo $ko['init']->title?></a></div>
				<div style="clear:both"></div>
			</div>
		<?php }?>
	</div>
	<?php }?>
</div>

<script>
	function edit_init(id){
    	$.ajax({
			type: "GET",
			url: config.base+"initiative/edit_initiative",
			data: {id: id,segment: segment},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#edit_int_"+id).html(resp.html);
				}else{}
			}
		});
    }
    function change_view(view){
    	toggle_visibility('description');
    	toggle_visibility('dependency');
    	$(".choice").removeClass('active');
    	$("#"+view).addClass('active');
    }
</script>