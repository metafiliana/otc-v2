<?php
$arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
?>
<style>
.pmo_header{
		margin-right:40px;
	}
.pmo_header_active a{
		margin-right:40px;
		color: black;
}
.form-control-this {
 width:auto;
 height:30px;
 font-size:14px;
 line-height:1.42857143;
 color:#555;
 background-color:#fff;
 background-image:none;
 border:1px solid #ccc;
 border-radius:4px;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
 -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
 transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
}
</style>
  <div style="padding:5px 10px 5px 0; margin: 10px 30px 10px 40px;">
    <div class="row" style="margin:5px 0 5px -5px;">

      <div class="col-md-12 row">
				<div class="col-sm-3">
					<a href="<?php echo base_url()?>program/list_programs/">
	          <button class="btn btn-default btn-sm btn-info-new">Update Activity</button>
	        </a>
	          <button class="btn btn-info-new btn-sm" disabled="disabled">Update KPI</button>
				</div>
					<?php if($user['role']=='1'){?>
						<div class="col-sm-6 row">
						<form id="formSearch" action="<?php echo base_url()."kuantitatif/list_kuantitatif/";?>" method="post" role="form" accept-charset="utf-8">
								<div class="col-sm-5" style="margin-left:-70px;">
									<label class="control-label col-sm" style="margin:0 10px 0 10px;">Month</label>
									<select class="input-sm form-control-this" name="month" id="month">
									<?php foreach ($arr_month as $arr) { ?>
										<option value="<?= $arr ?>" <?php if($arr == $month_view){echo "selected";} ?>><?= $arr ?></option>
									<?php } ?>
				 					</select>
								</div>
								<div class="col-sm-2" style="margin-left:-30px;">
									<button class="form-control btn btn-info-new-submit" type="submit">Find</button>
								</div>
						</form>
					</div>
					<?php } else{?>
						<div class="col-sm-3" style="margin-left:-70px;">
							<label class="control-label col-sm" style="margin:0 10px 0 10px;">Month</label>
							<select class="input-sm form-control-this" name="month" id="month">
							<?php foreach ($arr_month as $arr) { ?>
								<option value="<?= $arr ?>" <?php if($arr == date('F')){echo "selected";} ?>><?= $arr ?></option>
							<?php } ?>
		 					</select>
						</div>
					<?php } ?>

        <div class="col-md-2 right_text" style="float: right;">
          <a onclick="take('list_of_program')" class="btn btn-info-new btn-sm left_text" style="margin-bottom:10px;"><span class="glyphicon glyphicon-print"></span> Print</a>
        </div>

      </div>

    </div>
    <div class="component_part">
      <div class="" id="list_of_program">
        <?php echo $list_program?>
      </div><div style="clear:both"></div><br>
    </div>
  </div>
<script>
$(document).ready(function(){
      $('.dropdown-toggle').dropdown()

    });

function delete_kuantitatif(id, event){
  bootbox.confirm("Apa anda yakin?",
  function(confirmed) {
    if(confirmed===true){
      $.ajax({
        url: config.base+"kuantitatif/delete_kuantitatif",
        data: {id: id},
        dataType: 'json',
        type: "POST",
        success: function (resp) {
          if(resp.status == 1){
            $('#kuantitatif_'+id).animate({'opacity':'toggle'});
            succeedMessage('Kuantitatif berhasil dihapus');
          }
        }
      });
    }
  });
}

function input_kuantitatif(init_id,init_code,kuan_id){
  $.ajax({
    type: "GET",
    url: config.base+"kuantitatif/input_kuantitatif",
    data: {init_id:init_id, init_code:init_code , kuan_id:kuan_id},
    dataType: 'json',
    cache: false,
    success: function(resp){
      if(resp.status==1){
        show_popup_modal(resp.html);
      }else{}
    }
  });
}

function update_realisasi(id,month_view,month_number){
  $.ajax({
    type: "GET",
    url: config.base+"kuantitatif/update_realisasi",
    data: {id:id, month_view:month_view, month_number:month_number},
    dataType: 'json',
    cache: false,
    success: function(resp){
      if(resp.status==1){
        show_popup_modal(resp.html);
      }else{}
    }
  });
}

function take(div) {
// First render all SVGs to canvases
var svgElements= $("#"+div).find('svg');

//replace all svgs with a temp canvas
svgElements.each(function () {
 var canvas, xml;

 canvas = document.createElement("canvas");
 canvas.className = "screenShotTempCanvas";
 //convert SVG into a XML string
 xml = (new XMLSerializer()).serializeToString(this);

 // Removing the name space as IE throws an error
 xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');

 //draw the SVG onto a canvas
 canvg(canvas, xml);
 $(canvas).insertAfter(this);
 //hide the SVG element
 this.className = "tempHide";
 $(this).hide();
});

html2canvas($("#"+div), {
     allowTaint: true,
     onrendered: function (canvas) {
         var myImage = canvas.toDataURL("image/pdf");
         var tWindow = window.open("");
         $(tWindow.document.body).html("<img id='Image' src=" + myImage + " style='width:100%;'></img>").ready(function () {
             tWindow.focus();
             tWindow.print();
         });
     }
});
//location.reload();
}
</script>
