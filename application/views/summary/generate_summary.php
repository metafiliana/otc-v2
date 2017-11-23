<style>
    .detail-milestone {
      cursor: pointer;
    }
    .pmo_header{
        margin-right:40px;
    }
    .pmo_header_active a{
        margin-right:40px;
        color: black;
    }
    .chart-4 {
      width: 25%;
      height: 300px;
    }
    .panel-default {
        margin: 25px;
    }
    .well {
        margin: 25px;
    }
    .bullet-red {
        color: red;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }
    .bullet-yellow {
        color: yellow;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }
    .bullet-green {
        color: green;
        border-radius: 50%;
        width: 2px;
        height: 2px;
    }

    .component_part_summary {
    background-color: white;
    border-radius: 10px;
    border: 1px solid #d3d3d3;
    padding: 10px 10px 0 10px;
    margin-bottom: 10px;
    overflow: auto;
    }

    .btn-danger{
      border-color:unset;
    }
</style>

<div class="panel-body">
      <div class="component_part_summary" style="margin-top:10px; margin-right: 5px; margin-left: 5px;">
        <div class="row">
            <!-- search area -->
            <div class="col-md-3" style="margin-right:-50px;">
              <a href="<?php echo base_url()?>summary/listKuantitatif/"><button class="btn btn-info-new btn-sm btn-default">Kuantitatif</button></a>
              <a href="<?php echo base_url()?>summary/listMilestone/"><button class="btn btn-info-new btn-sm btn-default">Milestone</button></a>
              <!-- <button class="btn btn-sm btn-info-new" disabled="disabled">Home</button> -->
              <?php
                if ($is_admin){
              ?>
              <button class="btn btn-sm btn-info-new" disabled="disabled">Update Summary</button>
              <?php
                }
              ?>
            </div>
            <div class="col-md-3" style="float: right;">
              <div class="right_text">
                  <h3 style="color:#91aef9;">Generate Summary</h3>
              </div>
              <div>
                <h5 class="text-right">Last Updated: <?php echo $summary_info->date; ?></h5>
              </div>
                <!-- <button type="button" class="btn btn-danger">Print</button> -->
            </div><div style="clear:both;"></div>
        </div>
      </div><div style="clear:both;"></div>

      <!-- header area start -->
      <div class="col-md-12">
        <div class="component_part">
          <div class="row text-center">
            <?php echo form_open('', 'id="formSearch"'); ?>
            <div class="col-sm-12 form-group row">
              <p class="col-sm-4">Pilih bulan sebagai pivot (update date) summary</p>
            </div>
            <div class="col-sm-12 form-group row">
              <div class="col-sm-4">
                <?php
                    echo form_dropdown('bulan', getMonth(true), date('F'), 'class = "form-control" id = "form-bulan"');
                ?>
              </div>
            </div>
            <div class="col-sm-12 form-group row">
                <div class="col-sm-4">
                  <?php
                      echo form_submit('', 'Generate', 'class = "form-control btn btn-info-new-submit"');
                  ?>
                </div>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div><div style="clear:both;"></div>
      </div>
      <!-- header area ends -->
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/globalize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dx.chartjs.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>

<script>
    $( document ).ready( function() {
      $(".btn-info-new-submit").click(function(e){
        e.preventDefault();
        if (confirm('Apakah anda sudah yakin?')) {
            let bulan = $("#form-bulan").val();
            $.ajax({
              type: 'GET',
              url: '<?php echo base_url()."initiative/generateTransaksi"; ?>',
              data: 'bulan='+bulan,
              beforeSend: function(){
                $(this).text("Loading ...");
                $(this).prop("disabled", true);
              },
              success: function(data) {
                  alert("Data summary berhasil di generate!");
                  window.location.href = '<?php echo base_url()."summary/home"; ?>';
              },
              complete: function(){
                $(this).text("Generate");
                $(this).prop("disabled", false);
              }
          });
        }
      });
    });
</script>
