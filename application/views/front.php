<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title><?php echo ucwords($title)."";?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/token-input.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/css/sb-admin-2.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/cthree/c3.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>assets/css/shared.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
        <script>
			var config = {
				 base: "<?php echo base_url(); ?>"
			 };
		 </script>
    
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.formatCurrency-1.4.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/application.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/ChartNew.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/sb-admin-2.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/cthree/c3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/cthree/d3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tokeninput.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>
        
        <!-- Highchart -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/highchart/highcharts.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/highchart/modules/exporting.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/grafik.js"></script>
        
    </head>
    
    <body>
        <div id="modal_finder">
        </div>
        <?php if($sidebar){ $cont = "content";?><div class="sidebar_nav_left"><?php echo $sidebar; ?></div><?php }
        	else{ $cont = "content_no_sb";}
        ?>
        <div class="<?php echo $cont?>">
        	<?php echo $content; ?>
        	<?php echo $footer; ?>
    	</div>
        
        <div style="clear:both"></div>
        
    </body>
</html>