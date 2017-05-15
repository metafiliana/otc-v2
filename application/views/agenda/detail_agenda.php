<div>
	<div><span class="glyphicon glyphicon-home"></span> : <?php echo $agenda->location?></div>
	<div><span class="glyphicon glyphicon-calendar"></span> : <?php echo date("d M Y", strtotime($agenda->start));?></div>
	<div><span class="glyphicon glyphicon-time"></span> : <?php echo date("h:i", strtotime($agenda->start));?></div>
	<div style="margin-top:20px"><?php echo $agenda->description?></div>
    <hr>
    <?php $user = $this->session->userdata('user');?>
    <div style="margin-top:10px">
    <h4>Files</h4>
        <?php if($files){ foreach($files as $file){?>
        <div title="<?php echo $file->title?>" id="file_<?php echo $file->id?>" style="margin-top:10px;">
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
    <hr>
    <div style="margin-top:20px; text-align:center">
        <a onclick="show_form('','','',<?php echo $agenda->id?>)" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
        <a onclick="delete_agenda(<?php echo $agenda->id?>)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
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
                $('#file_'+id).animate({'opacity':'toggle'});
              }else{
                console.log('action after failed');
              }
            }
          });
        },
    });
    }

    function delete_agenda(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"agenda/delete_agenda",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                location.reload(config.base+"agenda"); 
              }else{
                console.log('action after failed');
              }
            }
          });
        },
    });
    }
</script>