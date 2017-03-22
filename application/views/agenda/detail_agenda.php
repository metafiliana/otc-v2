<div>
	<div><span class="glyphicon glyphicon-home"></span> : <?php echo $agenda->location?></div>
	<div><span class="glyphicon glyphicon-calendar"></span> : <?php echo date("d M Y", strtotime($agenda->start));?></div>
	<div><span class="glyphicon glyphicon-time"></span> : <?php echo date("h:i", strtotime($agenda->start));?></div>
	<div style="margin-top:20px"><?php echo $agenda->description?></div><hr>
	<div style="margin-top:20px; text-align:center">
		<a onclick="show_form('','','',<?php echo $agenda->id?>)" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
		<a href="<?php echo base_url()?>agenda/delete_agenda/<?php echo $agenda->id?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
	</div>
</div>
<script>
	function show_form(month,day,year,id){
    $.ajax({
        type: "GET",
        url: config.base+"agenda/input_agenda",
        data: {month:month,day:day,year:year,id:id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
	}
</script>