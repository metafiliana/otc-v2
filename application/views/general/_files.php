<?php $user = $this->session->userdata('user');?>
<div style="margin-top:10px">
<?php if($files){ foreach($files as $file){?>
<div title="<?php echo $file->title?>">
    <a href=<?php echo base_url()?><?php echo $file->full_url?>>
        <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file->ext)?>"></span>
        <span title="<?=$file->title?>"><?php long_text_real($file->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
    </a>
    <?php if($user['id'] == $file->user_id||$user['role']=='admin'){?>	
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
<script>
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
            location.reload(config.base+"general/files");
          }else{
            console.log('action after failed');
          }
        }
      });
    },
});
}
</script>

                    