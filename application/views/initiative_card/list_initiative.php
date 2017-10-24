<style type="text/css">
  
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 0;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
  height: auto;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
  height: 100px;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: rgb(15,43,91);
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid rgb(15,43,91);
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
.modalDialog {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0,0,0,0.8);
  z-index: 99999;
  opacity:0;
  -webkit-transition: opacity 400ms ease-in;
  -moz-transition: opacity 400ms ease-in;
  transition: opacity 400ms ease-in;
  pointer-events: none;
}
.modalDialog:target {
  opacity:1;
  pointer-events: auto;
}

.modalDialog > div {
  width: 800px;
  height: 70%;
  position: relative;
  margin: 100px auto;
  padding: 5px 20px 13px 20px;
  border-radius: 10px;
  background: #fff;
  background: -moz-linear-gradient(#fff, #999);
  background: -webkit-linear-gradient(#fff, #999);
  background: -o-linear-gradient(#fff, #999);
}
.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  -moz-box-shadow: 1px 1px 3px #000;
  -webkit-box-shadow: 1px 1px 3px #000;
  box-shadow: 1px 1px 3px #000;
}
#circle {
    width: 30px;
    height: 30px;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50px;
    margin-left: 15px;
}

.close:hover { background: #00d9ff; }
</style>
        <div class="col-lg-11 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container" style="height: auto;">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                 <?php echo $list_cluster?>
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active" id="1">
                      
                      <?php echo $list_initiative?>
                      
                      
                    
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content" id="2">
                    
                         <!-- <?php echo $list_program?> -->
                         <?php echo $list_initiative2?>
                      
                </div>
                <div class="bhoechie-tab-content" id="3">
                    
                         <!-- <?php echo $list_program?> -->
                         <?php echo $list_initiative3?>
                      
                </div>
                <div class="bhoechie-tab-content" id="4">
                    
                         <!-- <?php echo $list_program?> -->
                         <?php echo $list_initiative4?>
                      
                </div>
                <div class="bhoechie-tab-content" id="5">
                    
                         <!-- <?php echo $list_program?> -->
                         <?php echo $list_initiative5?>
                      
                </div>
                <div class="bhoechie-tab-content" id="6">
                    
                         <!-- <?php echo $list_program?> -->
                         <?php echo $list_initiative6?>
                      
                </div>
            </div>
        </div>
<script type="text/javascript">
  $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
<!--<style>
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
      <a href="<?php echo base_url()?>kuantitatif/list_kuantitatif/"><button class="btn btn-default btn-sm btn-info-new">Update Kpi</button></a>
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
</script>-->
