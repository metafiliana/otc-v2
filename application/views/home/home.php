<?php $user = $this->session->userdata('user'); ?>
<div class="row" style="margin:30px auto;text-align: center;">
    <div class="col-md-4">
    <figure class="snip1579"><img src="<?php echo base_url()?>/assets/img/inisiatif2.png" alt="profile-sample2"/>
      <figcaption>
        <h3>Summary</h3>
        <blockquote>
          <p style="margin-left:5px">'Detail Activity and Summary Information in each Mandiri Level Initiative.'</p>
        </blockquote>
      </figcaption><a href="<?php echo base_url()?>summary/"></a>
    </figure>
    </div>
    <div class="col-md-4">
    <figure class="snip1579"><img src="<?php echo base_url()?>/assets/img/MyInitiative.png" alt="profile-sample7"/>
      <figcaption>
        <h3>My Initiative</h3>
        <blockquote>
          <p style="margin-left:5px">'Selected Initiatives.'</p>
        </blockquote>
      </figcaption><?php if($user['role']=='admin'){ ?><a href="<?php echo base_url()?>program/list_programs/"></a><?php } else{ ?><a href="<?php echo base_url()?>program/my_inisiatif"></a><?php } ?>
    </figure>
    </div>
    <div class="col-md-4">
    <figure class="snip1579"><img src="<?php echo base_url()?>/assets/img/inisiatif1.png" alt="profile-sample6"/>
      <figcaption>
        <h3>My Metrics</h3>
        <blockquote>
          <p style="margin-left:5px">'Selected Kuantitative.'</p>
        </blockquote>
      </figcaption><?php if($user['role']=='admin'){ ?><a href="<?php echo base_url()?>kuantitatif"></a><?php } else{ ?><a href="<?php echo base_url()?>kuantitatif/my_kuantitatif"></a><?php } ?>
    </figure>
    </div>
</div>
<div class="row" style="margin: 30px auto; text-align: center;">
    <div class="col-md-6">
    <figure class="snip1579"><img src="<?php echo base_url()?>/assets/img/MoM.png" alt="profile-sample2"/>
      <figcaption>
        <h3>Files</h3>
        <blockquote>
          <p style="margin-left:5px">'All files initiative and metric'</p>
        </blockquote>
      </figcaption><a href="<?php echo base_url()?>general/files"></a>
    </figure>
    </div>
    <div class="col-md-6">
    <figure class="snip1579"><img src="<?php echo base_url()?>/assets/img/agenda.png" alt="profile-sample6"/>
      <figcaption>
        <h3>Agenda</h3>
        <blockquote>
          <p style="margin-left:5px">'Technical Meeting and Operation Committee Schedule.'</p>
        </blockquote>
      </figcaption><a href="<?php echo base_url()?>agenda"></a>
    </figure>
    </div>
</div>
