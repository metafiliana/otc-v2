<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to DYNC</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		display:block;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
	}

	#container{
		min-width: 1016px;
		width: 100%;
	}
	
	#back{
		overflow: hidden;
		position: relative;
		display: block;
	}
	
	#full-screen-background-image {
  		z-index: -999;
  		min-height: 100%;
  		min-width: 1024px;
  		
  		width: 100%;
  		height: auto;
  		position: fixed;
  		top: 0;
  		left: 0;
	}
	
	#front{
		position: absolute;
		top: 50%;
		left: 50%;
		display: block;
		margin-left:-350px;
	}
	
	.styled-select select {
   		background: transparent;
   		width: 268px;
   		padding: 5px;
   		font-size: 16px;
   		line-height: 1;
   		border: 0;
   		border-radius: 0;
   		height: 34px;
   		-webkit-appearance: none;
   }
   
   .styled-select {
   		width: 240px;
   		height: 34px;
   		overflow: hidden;
   		background: url('assets/img/general/down_arrow_select.jpg') no-repeat right #fff;
   		border: 1px solid #ccc;
   }
   
   .styled-box {
   		width: 240px;
   		height: 34px;
   		overflow: hidden;
   		border: 1px solid #ccc;
   		background: no-repeat right #ddd;
   		opacity: 0.7;
   		margin-left: 30px;
   		
   }
   
   .styled-button {
   		background: #fff;
   		width: 88px;
   		padding: 5px;
   		font-size: 16px;
   		line-height: 1;
   		border: 1px solid #ccc;
   		height: 36px;
   }
   
   .styled-button:hover {
   		background: #bbb;
   		color: #fff;
   }
	
	.logo, .styled-box, .styled-select{
		float:left;
	}
	
	.styled-box, .styled-select, .styled-button{
		margin-right: 10px;
		margin-top: 12px;
	}
	
	</style>
</head>
<body>

<div id="container">
	<div id="back">
		<img src="<?php echo base_url();?>assets/img/general/map.png" id="full-screen-background-image">
	</div>
	<div id="front">
		<form action="<?php echo base_url();?>home/input_bahasa" method="post">
			<div class="logo">
				<img src="<?php echo base_url()?>assets/img/general/logo.png" height='60px'>
			</div>
			<div class="styled-box">
				<div style="font-size: 18px; margin-top: 7px; margin-left:23px;">SELECT LANGUAGE</div>
			</div>
			<div class="styled-select">
   				<select name="bahasa">
      				<option value="ind">INDONESIA</option>
      				<option value="eng">ENGLISH</option>
   				</select>
			</div>
		
			<input type="submit" class="styled-button" value="ENTER">
		</form>
	</div>
</div>

</body>
</html>