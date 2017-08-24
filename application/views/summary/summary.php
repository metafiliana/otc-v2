<style>
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
</style>
<div class="component_part">
    <div class="row well">
        <strong>List Summary</strong>
        <div class="clearfix" style="float: right;">
            <button class="btn btn-info" disabled="disabled">Summary</button>
            <a href="<?php echo base_url()?>summary/program_list/"><button class="btn btn-default">Milestone</button></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="col-sm-3 form-group">
                <label>User</label>
                <?php 
                    echo form_dropdown('shirts', array(1 => 'CO-PMO', 2 => 'PMO'), array(), 'class = "form-control"');
                ?>
            </div>
            <div class="col-sm-3 form-group">
                <label>Tanggal Tarik Data</label>
                <?php 
                    echo form_dropdown('shirts', array(1 => 'CO-PMO', 2 => 'PMO'), array(), 'class = "form-control"');
                ?>
            </div>
            <div class="col-sm-1 form-group">
                <label></label>
                <?php 
                    echo form_submit('', 'Cari', 'class = "form-control button btn-info"');
                ?>
            </div>
            <div class="col-sm-1 form-group">
                <label></label>
                <button class="button btn-success">Print</button>
            </div>
        </div>
    </div>
</div>