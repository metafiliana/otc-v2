<script>
function add_files(id,init_code){
    $.ajax({
        type: "GET",
        url: config.base+"general/input_file",
        data: {id:id, init_code:init_code},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function get_file(init_code){
    	$.ajax({
			type: "GET",
			url: config.base+"general/get_file",
			data: {init_code:init_code},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#file_"+init_code).html(resp.html);
					toggle_visibility("file_"+init_code);
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
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/masonry.pkgd.min.js"></script> -->
<style type="text/css">
	.btn-xs{
    padding: 0px 3px;
    font-size: 12px;
    line-height: 0;
    border-radius: 3px;
	}
.masonry { /* Masonry container */
    column-count: 4;
    column-gap: 1.5em;
    margin: 22px;
    margin-top: 20px;display:flex;
   flex-wrap: wrap;"
}

.item { /* Masonry bricks or child elements */

    display: inline-block;
    background: #fff;
    padding: 0.5em;
    margin: 0 0 1em;
    width: 24.3%;
    margin: 5px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-shadow: 2px 2px 4px 0 #ccc;
    border: 1px solid #fff;
    border-radius: 15px;
}
</style>

<?php $user = $this->session->userdata('user');
$init = explode(';', $user['initiative']);
?>

<div class="masonry">
  <?php foreach ($init_code as $code) {?>
   <div class="item helper_text"><span style="padding: 8px;"><?php echo $code['prog']->init_code;?>. <?php echo long_text_real($code['prog']->title,30);?></span>
     <span style="float: right;"><?php foreach($init as $inits){ if($inits==$code['prog']->init_code || $user['role']=="2"){?>
      <a onclick="add_files('','<?php echo $code['prog']->init_code;?>')" class="btn btns btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span></a>
    <?php } }?></span>
    <div style="margin-top: 10px;">
      <?php if($code['file']){ foreach($code['file'] as $file){?>
      <div title="<?php echo $file->title?>" style="padding: 8px;">
          <a href=<?php echo base_url()?><?php echo $file->full_url?>>
              <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($file->ext)?>"></span>
              <span title="<?=$file->title?>"><?php long_text_real($file->title, 20)?><img style="height:18px; margin-left:7px;" src="<?=get_icon_url('download.png')?>"></span>
          </a>
          <?php if($user['id'] == $file->user_id||$user['role']=='admin'){?>
          <a class="pull-right" onclick="delete_file(<?php echo $file->id?>)">
                  <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
          </a><div style="clear:both"></div>
          <?php }?>
      </div>
          <?php } } else{  ?>
          <h5 class="center_text" style="margin-top: 10px;">No File</h5>
          <?php } ?>
          <div style="clear:both"></div>
    </div>
  </div>
  <?php } ?>

  <div class="item helper_text"><span style="padding: 8px;">Admin</span>
    <?php if($user['role']=="2"){?> <span style="float: right;">
              <a onclick="add_files('','ctf')" class="btn btns btn-default btn-xs right_text"><span class="glyphicon glyphicon-plus"></span></a>
              <?php }?></span>
    <div style="margin-top: 10px;">
    <?php if($ctf){ foreach($ctf as $files){?>
          <div title="<?php echo $files->title?>" style="padding: 8px;">
              <a href=<?php echo base_url()?><?php echo $files->full_url?>>
                  <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($files->ext)?>"></span>
                  <span title="<?=$files->title?>"><?php long_text_real($file->title, 20)?><img style="height:18px; margin-left:7px;" src="<?=get_icon_url('download.png')?>"></span>
              </a>
              <?php if($user['id'] == $files->user_id||$user['role']=='admin'){?>
              <a class="pull-right" onclick="delete_file(<?php echo $files->id?>)">
                      <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
              </a><div style="clear:both"></div>
              <?php }?>
          </div>
              <?php } } else{  ?>
              <h5 class="center_text">No File</h5>
              <?php } ?>
              <div style="clear:both"></div>
    </div>
  </div>
</div>

<!-- <div class="row" style="padding:0 10px 0 10px; margin-top:10px;">
	<?php foreach ($init_code as $code) {?>
	<div class="col-md-3" style="margin-top:10px;">
		<div class="component_part">
			<div style="margin-bottom:0px;" id="">
				<div style="padding-top:10px;">
					<div class="helper_text row">
            <div class="col-sm-10">
              <?php echo $code['prog']->init_code;?>. <?php echo long_text_real($code['prog']->title,30);?>
            </div>
            <div class="col-sm-2 right_text" style="margin-top:-10px;">
              <?php foreach($init as $inits){ if($inits==$code['prog']->init_code || $user['role']=="2"){?>
                <a onclick="add_files('','<?php echo $code['prog']->init_code;?>')" class="btn btns btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span></a>
              <?php } }?>
            </div>
					</div>
          <div style="margin-top:10px">
          <?php if($code['file']){ foreach($code['file'] as $file){?>
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
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="col-md-3" style="margin-top:10px;">
		<div class="component_part">
			<div style="margin-bottom:0px;" id="">
				<div style="padding-top:10px;">
          <div class="helper_text row">
            <div class="col-sm-10">
              Admin
            </div>
            <div class="col-sm-2 right_text" style="margin-top:-10px;">
              <?php if($user['role']=="2"){?>
              <a onclick="add_files('','ctf')" class="btn btns btn-default btn-xs right_text"><span class="glyphicon glyphicon-plus"></span></a>
              <?php }?>
            </div>
					</div>
          <div style="margin-top:10px">
          <?php if($ctf){ foreach($ctf as $files){?>
          <div title="<?php echo $files->title?>">
              <a href=<?php echo base_url()?><?php echo $files->full_url?>>
                  <span><img style="height:18px; margin-right:3px;" src="<?=get_ext_icon($files->ext)?>"></span>
                  <span title="<?=$files->title?>"><?php long_text_real($file->title, 20)?><img style="height:18px; margin-left:3px;" src="<?=get_icon_url('download.png')?>"></span>
              </a>
              <?php if($user['id'] == $file->user_id||$user['role']=='admin'){?>
              <a class="pull-right" onclick="delete_file(<?php echo $files->id?>)">
                      <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
              </a><div style="clear:both"></div>
              <?php }?>
          </div>
              <?php } } else{  ?>
              <h5 class="center_text">No File</h5>
              <?php } ?>
              <div style="clear:both"></div>
          </div>
				</div>
			</div>
		</div>
	</div>
</div>
 -->
