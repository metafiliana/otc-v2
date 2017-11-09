<?php
  $user = $this->session->userdata('user'); $user_disp="";
?>
<div class="container" style="margin-top: 50px; background-color: white; padding: 20px; width: 60%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-bottom: 100px;">
    
    <h1 style="text-align: center; margin: 0 auto !important;">Profile</h1>
    <p style="margin-left: 75%;"><b style="padding-right: 10px;">Last Login</b><?php $datelogin = $last_login; echo date("d/F/Y H:i:s", strtotime($datelogin));?></p>
    <!-- <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div> -->
  	<hr style="margin-bottom: 50px;">
	<div class="row">
      <!-- left column -->
      <div class="col-md-6" style="margin-bottom: 80px; ">
        <div class="text-center">
          <div class="col-lg-12" style="margin-top: -20px; padding-left: 10px;">
          <?php if (empty($foto)): ?>

          <img id="foto" style="width: 250px; height: 250px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" src="<?php echo base_url()?>assets/img/user/<?php echo $username;?>.jpg" class="avatar" alt="<?php echo $user['username'];?>">

          <?php else: ?>

          <img id="foto" style="width: 250px; height: 250px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" src="<?php echo base_url()?>assets/img/upload/<?php echo $foto;?>" class="avatar" alt="">

          <?php endif; ?>
          <br><br>
        </div>
          <form action="<?php echo base_url()?>user/photo_upload" method="post" enctype="multipart/form-data">
            <div class="form-group">
            <div class="col-lg-12">
              <input name="userfile" class="form-control" type="file" value="" required="" style="width: 70%; margin: 0 auto !important;">
              <br>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <?php if(empty($foto)): ?>
              <input id="submit" type="submit" class="btn btn-primary" value="Save Changes">
            <?php else: ?>
              <input id="submit" type="submit" class="btn btn-primary" value="Save Changes">
              <a href="<?php echo base_url()?>user/delete_photo_user/<?php echo $foto?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete</span></a>
          <?php endif;?>
            </div>
          </div>
        </form>
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-6 personal-info">
        <div class="form-group">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <!-- <label class="col-lg-2 control-label" style="padding-right: 20px;">Name</label> -->
            <div class="col-lg-11">
              <h1><?php echo $user['name'];?></h1>
              <hr><br>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-1 control-label">Private Email</label>
            <div class="col-lg-1"></div>
            <div class="col-lg-9">
              <h4 style="margin-top: 14px;"><?php echo $private_email?></h4>
              <hr>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-1 control-label">Work Email</label>
            <div class="col-lg-1"></div>
            <div class="col-lg-9">
              <h4 style="margin-top: 14px;"><?php echo $work_email?></h4>
              <hr>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-1 control-label">Initiative</label>
            <div class="col-lg-1"></div>
            <div class="col-lg-9">
              <?php     foreach($titlecode as $tc) { ?>
              <h4><?php echo $tc->init_code ?>   <?php echo $tc->title ?></h4>
              <hr><br>
<?php  } ?>
              
            </div>
          </div>
        </form>
      </div>
      </div>

      <!-- <div class="col-md-12" style="margin-bottom: 100px;">
        <div class="form-group">
            <label class="col-lg-1 control-label"></label>
            <div class="col-lg-10">
              <table class="table-responsive table table-bordered">
                <thead>
                  <tr>
                    <th>Initiative</th>
                    <th>Deskripsi</th>
                    <th>Aspirasi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $initid?></td>
                  <td><?php echo $deskripsi?></td>
                  <td><?php echo $aspirasi?></td>
                  </tr>
                </tbody>
              </table>
          </div>
          </div>
      </div> -->
</div>
</div>
</div>