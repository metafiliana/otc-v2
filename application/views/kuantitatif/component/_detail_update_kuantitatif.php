<?php $user = $this->session->userdata('user'); ?>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div>
					<h4 class="center_text">Detail Update <?php echo $detail->metric; ?></h4>
					<h5 class="center_text"><?php echo $detail->title; ?></h5>
					<h5 class="center_text">Target <?php echo $detail->target_year; ?>: <?php echo $detail->target; ?></h5>
				</div>
				<table class="table table-hover" style="margin-top:20px;">
				<thead class="black_color old_grey_color_bg">
				    <tr>
				        <th style="vertical-align:middle">Month</th>
				        <th style="vertical-align:middle">Amount</th>
			        	<th style="vertical-align:middle">Update</th>
				    </tr>
			    </thead>
			    <tbody>
				    <?php if($update){ ?>
					    <?php foreach($update as $updates){ ?>
					    	<tr id="update_<?php echo $updates->id?>">
					    		<td class="center_text"><?php echo date('F',mktime(0,0,0, $updates->month,10));?></td>
					    		<td class="center_text"><?php echo $updates->amount; ?></td>
					    		<td>
									<a class="btn btn-link btn-link-edit" onclick="show_form('','Realisasi',<?php echo $updates->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
									<a class="btn btn-link btn-link-delete" onclick="detele_update_kuan(<?php echo $updates->id?>);"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
					    	</tr>
				    	<?php } ?>
		    	 	<?php } else{ ?>
					<tr>
			    		<td class="center_text">No Update</td>
			    		<td class="center_text">No Update</td>
		    		</tr>
		    		<?php }?>
			    </tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function detele_update_kuan(id){
$.confirm({
    title: 'Apa anda yakin?',
    content: '',
    confirmButton: 'Ya',
    confirm: function(){  
      $.ajax({
        type: "GET",
        url: config.base+"kuantitatif/delete_kuantitatif_update",
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(resp){
          console.log(resp);
          if(resp.status==true){
            $('#update_'+id).animate({'opacity':'toggle'});
          }else{
            console.log('action after failed');
          }
        }
      });
    },
});
}	
	

</script>
