<style>
.pmo_header{
		margin-right:40px;
	}
.pmo_header_active a{
		margin-right:40px;
		color: black;
	}
</style>
<div style="padding:5px 10px 5px 0; margin: 10px 30px 10px 40px;">
  <div class="row" style="margin-top:5px;">
    <div class="col-md-10">
      <button class="btn btn-info-new btn-sm" disabled="disabled">Update Activity</button>
      <a href="<?php echo base_url()?>kuantitatif/list_kuantitatif/"><button class="btn btn-default btn-sm btn-info-new">Update KPI</button></a>
    </div>
    <div class="col-md-2 right_text">
      <a onclick="take('list_of_program')" class="btn btn-info-new btn-sm left_text" style="margin-bottom:10px;"><span class="glyphicon glyphicon-print"></span> Print</a>
    </div>
  </div>
    <div style="clear:both"></div>
    <div class="component_part" id="list_of_program">
      <?php echo $list_program?>
    </div><div style="clear:both"></div><br>
</div>

<script>


$(document).ready(function(){
      $('.dropdown-toggle').dropdown()

    });

function delete_action(id, event){
  bootbox.confirm("Apa anda yakin?",
  function(confirmed) {
    if(confirmed===true){
      $.ajax({
        url: config.base+"program/delete_action",
        data: {id: id},
        dataType: 'json',
        type: "POST",
        success: function (resp) {
          if(resp.status == 1){
            $('#action_'+id).animate({'opacity':'toggle'});
            succeedMessage('Action berhasil dihapus');
          }
        }
      });
    }
  });
}



function input_action(init_id,action_id){
  $.ajax({
    type: "GET",
    url: config.base+"program/input_action",
    data: {init_id:init_id, action_id:action_id},
    dataType: 'json',
    cache: false,
    success: function(resp){
      if(resp.status==1){
        show_popup_modal(resp.html);
      }else{}
    }
  });
}



function filter_data(){
      var code_filter = $("#code_filter").val();
      $.ajax({
        type: "GET",
        url: config.base+"program/filter_data",
        data: {code_filter:code_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
          if(resp.status==1){
            $('#list_of_filter').html(resp.html);
          }else{}
        }
      });
    }


function change_data(){
      var code_filter = $("#code_filter").val();
      var filter = $("#filter").val();
      $.ajax({
        type: "GET",
        url: config.base+"program/change_data",
        data: {code_filter:code_filter,filter:filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
          if(resp.status==1){
            $('#list_of_program').html(resp.html);
            $('#wb_count').html(resp.wb);
            $('#count_completed').html(resp.completed);
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
