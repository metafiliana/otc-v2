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
<!-- Trigger the modal with a button -->
<button id="modalTrigger" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;"></button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Initiatives</h4>
      </div>
      <div class="modal-body" id="modalDiv"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="panel-body">
      <div class="component_part_summary" style="margin-top:10px;">
        <div class="row">
            <!-- search area -->
            <div class="col-md-3" style="margin-right:-50px;">
              <a href="<?php echo base_url()?>summary/listKuantitatif/"><button class="btn btn-info-new btn-sm btn-default">Kuantitatif</button></a>
              <a href="<?php echo base_url()?>summary/listMilestone/"><button class="btn btn-info-new btn-sm btn-default">Milestone</button></a>
              <!-- <button class="btn btn-sm btn-info-new" disabled="disabled">Home</button> -->
              <?php 
                if ($is_admin){
              ?>
              <a href="<?php echo base_url()?>initiative/generateTransaksi/"><button class="btn btn-info-new btn-sm btn-default">Update Summary</button></a>
              <?php 
                }
              ?>
            </div>
            <div class="col-md-6">
              <?php echo form_open('summary/home', 'id="formSearch"'); ?>
              <div class="col-sm-10 form-group row">
                  <div>
                    <label class="control-label col-sm-1">Month</label>
                    <div class="col-sm-3" style="margin-left:12px;">
                      <?php
                          echo form_dropdown('bulan', getMonth(true), $bulan_search ? $bulan_search : date('F'), 'class = "form-control"');
                      ?>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <?php
                        echo form_submit('', 'Find', 'class = "form-control btn btn-info-new-submit"');
                    ?>
                  </div>
              </div>
              <?php echo form_close(); ?>
            </div>
            <div class="col-md-3" style="margin-left:50px;">
              <div class="right_text">
                  <h3 style="color:#91aef9;">Home</h3>
              </div>
              <div>
                <h5 class="text-right">Last Updated: <?php echo $summary_info->date; ?></h5>
              </div>
                <!-- <button type="button" class="btn btn-danger">Print</button> -->
            </div><div style="clear:both;"></div>
        </div>
      </div><div style="clear:both;"></div>

      <!-- header area start -->
      <div class="component_part" style="margin-top:10px;">
        <div class="row">
          <h2 class="text-center">Welcome, <?php echo $user['name']; ?></h2>
        </div>
      </div><div style="clear:both;"></div>
      <!-- header area ends -->

        <!-- data area top 21 bod start -->
        <div class="col-md-4">
          <div class="component_part" style="margin:10px;">
            <div class="row" id="printTopBod">
              <h3 class="text-center">Realisasi Pencapaian Top 21 BOD Level Initiatives</h3>
              <h5 class="text-center">( as of <?php echo ($bulan_search !== null) ? date('F Y', strtotime($bulan_search)) : date('F Y'); ?>)</h5>
              <div class="col-md-12">
                <div id="mtdGauge"></div>
              </div>
              <div class="col-md-12">
                <div id="ytdGauge"></div>
              </div>
            </div>
              <button onclick="take('printTopBod')" class="btn btn-info-new">Print</button>
          </div>
        </div>

        <!-- activities area start -->
        <div class="col-md-4">
          <div class="component_part" style="margin:10px;">
           <h3 class="text-center">Next Activities</h3>
           <div><h4 style="float:right; margin-bottom:10px;">Last Agenda</h4></div><div style="clear:both"></div>
           <?php foreach ($last_agenda as $la) { ?>
           <div>
            <a onclick="show_detail(<?php echo $la->id?>)">
            <div>
             <div style="margin-bottom:0px; font-size:16px">
              <?php echo substr($la->title, 0,60); if(strlen($la->title)>60){echo "...";}?>
             </div>
             <div style="font-size:12px" class="helper-text"><?php echo date('j M y', strtotime($la->start))?></div>
            </div>
            </a>
          </div>
          <hr>
          <?php } ?>
          </div>
        </div>
        <!-- activities area ends -->

        <div class="col-md-4">
          <div class="component_part" style="margin:10px;">
           <h3 class="text-center">Show Initiatives</h3>
            <!-- <div class="btn-group"> -->
              <select class="form-control" id="showInitiativeOption">
              <?php foreach ($list_initiatives as $key => $value) { ?>
                <option value="<?php echo $value['init_code'];?>" class="form-control showInitiative" data-id="<?php echo $key;?>"><?php echo "(".$value['init_code'] . ") " . $value['title']; ?></option>
              <?php } ?>
              </select>
            <!-- </div> -->
          </div>
        </div>

        <!-- data area inititatives start -->
        <div class="col-md-8">
        <div class="component_part">
          <div class="row">
            <?php foreach ($initiatives_detail as $key => $value) { ?>
            <div class="col-md-12 table-content initiative-detail" id="print-<?php echo $value['init_code']; ?>">

              <!-- data area inititatives-kuantitatif start -->
              <div class="col-md-12">
                <h3 class="text-center">Realisasi Pencapaian Initiatives <?php echo $value['init_code']; ?></h3>
                <h4 class="text-center"><?php echo $value['title']; ?></h4>
                <h5 class="text-center">( as of <?php echo ($bulan_search !== null) ? date('F Y', strtotime($bulan_search)) : date('F Y'); ?>)</h5>
                <div class="col-md-6">
                  <div class="mtd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <div class="col-md-6">
                  <div class="ytd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <button class="detail-initiatives text-center" data-id="<?php echo $value['id'];?>" data-mtd="<?php echo $value['kuantitatif_mtd'];?>" data-ytd="<?php echo $value['kuantitatif_ytd'];?>" style="display: none;">Details</button>
              </div>
              <!-- data area inititatives-kuantitatif ends -->

              <!-- data area milestone start -->
              <div class="col-md-12">
                <h3 class="text-center">Realisasi Pencapaian Milestone Initiatives <?php echo $value['init_code']; ?></h3>
                <h5 class="text-center">( as of <?php echo ($bulan_search !== null) ? date('F Y', strtotime($bulan_search)) : date('F Y'); ?>)</h5>
                <div class="col-md-6 text-center">
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="1" data-month="<?php echo $bulan_search; ?>" data-flagged="false">Complete: <?php echo $value['completed']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="2" data-month="<?php echo $bulan_search; ?>" data-flagged="false">On Track: <?php echo $value['on_track']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="0" data-month="<?php echo $bulan_search; ?>" data-flagged="false">Future Start: <?php echo $value['future_start']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-month="<?php echo $bulan_search; ?>" data-flagged="false" style="color: red">Flagged: <?php echo $value['flagged']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-month="<?php echo $bulan_search; ?>" data-flagged="2" style="color: red">Overdue: <?php echo $value['overdue']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-month="<?php echo $bulan_search; ?>" data-flagged="1" style="color: red">Delay: <?php echo $value['delay']; ?></p>
                </div>
                <div class="col-md-6 text-center">
                  <span>YTD : <?php echo $value['milestone_mtd']; ?>%</span>
                  <br>
                  <span>FY : <?php echo $value['milestone_ytd']; ?>%</span>
                  <br>
                  <button onclick="take('print-<?php echo $key; ?>')" class="btn btn-info-new btnPrintHide">Print</button>
                </div>
              </div>
              <!-- data area milestone start -->

            </div>
            <?php } ?>
          </div>
        </div>
        </div>
        <!-- data area initiatives ends -->

      <!-- dialog area starts -->
      <!-- <div id="modalDiv" title="Detail Initiative"></div> -->
      <!-- dialog area ends -->

</div>

<!-- <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script> -->
<!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script> -->
<!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script> -->
<!-- <script type="text/javascript" src="http://cdn3.devexpress.com/jslib/15.2.5/js/dx.chartjs.js"></script> -->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<script type="text/javascript" src="<?php echo base_url();?>assets/js/globalize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dx.chartjs.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>

<script>
    $( document ).ready( function() {
      $(".initiative-detail").hide();
      // $( '#modalDiv' ).dialog( { 'autoOpen': false } );
      $( ".detail-initiatives" ).click().delay( 800 );
      // $( "#modalTrigger" ).click().delay( 800 );
      $( ".initiative-detail" ).first().show().delay( 800 );
    });

    $("#mtdGauge").dxCircularGauge({
      rangeContainer: {
        offset: 10,
        ranges: [
          { startValue: 0, endValue: 95, color: 'red' },
          { startValue: 95, endValue: 100, color: 'yellow' },
          { startValue: 100, endValue: 200, color: '#2DD700' }
        ]
      },
      scale: {
        startValue: 0,  endValue: 200,
        majorTick: { tickInterval: 20 },
        label: {
          // format: 'currency'
        }
      },
      title: {
        text: '<?php echo $top_bod['mtd']; ?> % (YTD)',
        position: 'bottom-center',
      },
      tooltip: {
        enabled: true,
        // format: 'currency',
        customizeText: function (arg) {
          return 'Current ' + arg.valueText;
        }
      },
      subvalueIndicator: {
        type: 'triangleMarker',
        // format: 'thousands',
        text: {
          // format: 'currency',
          customizeText: function (arg) {
            return arg.valueText + '% YTD';
          }
        }
      },
      value: <?php echo $top_bod['mtd']; ?>,
      subvalues: [<?php echo $top_bod['mtd']; ?>],
      valueIndicator: {
          color: 'black',
          width: 6,
          spindleSize: 20,
          spindleGapSize: 15
      },
    });

    $("#ytdGauge").dxCircularGauge({
      rangeContainer: {
        offset: 10,
        ranges: [
          { startValue: 0, endValue: 95, color: 'red' },
          { startValue: 95, endValue: 100, color: 'yellow' },
          { startValue: 100, endValue: 200, color: '#2DD700' }
        ]
      },
      scale: {
        startValue: 0,  endValue: 200,
        majorTick: { tickInterval: 20 },
        label: {
          // format: 'currency'
        }
      },
      title: {
        text: '<?php echo $top_bod['ytd']; ?> % (FY)',
        position: 'bottom-center'
      },
      tooltip: {
        enabled: true,
        // format: 'currency',
        customizeText: function (arg) {
          return 'Current ' + arg.valueText;
        }
      },
      subvalueIndicator: {
        type: 'triangleMarker',
        // format: 'hundreds',
        text: {
          // format: 'currency',
          customizeText: function (arg) {
            return arg.valueText + '% FY';
          }
        }
      },
      value: <?php echo $top_bod['ytd']; ?>,
      subvalues: [<?php echo $top_bod['ytd']; ?>],
      valueIndicator: {
          color: 'black',
          width: 6,
          spindleSize: 20,
          spindleGapSize: 15
      },
    });

    $(".detail-initiatives").on("click", function(data){
      var id = $(this).data("id");
      var mtd = $(this).data("mtd");
      var ytd = $(this).data("ytd");

      $(".mtd-gauge-init-"+id).dxCircularGauge({
        rangeContainer: {
          offset: 10,
          ranges: [
            { startValue: 0, endValue: 95, color: 'red' },
            { startValue: 95, endValue: 100, color: 'yellow' },
            { startValue: 100, endValue: 200, color: '#2DD700' }
          ]
        },
        scale: {
          startValue: 0,  endValue: 200,
          majorTick: { tickInterval: 50 },
          label: {
          }
        },
        title: {
          text: mtd+' % (YTD)',
          position: 'bottom-center'
        },
        tooltip: {
          enabled: true,
          customizeText: function (arg) {
            return 'Current ' + arg.valueText;
          }
        },
        subvalueIndicator: {
          type: 'triangleMarker',
          text: {
            customizeText: function (arg) {
              return arg.valueText + '% YTD';
            }
          }
        },
        value: mtd,
        subvalues: [mtd],
        valueIndicator: {
            color: 'black',
            width: 6,
            spindleSize: 20,
            spindleGapSize: 15
        },
      });

      $(".ytd-gauge-init-"+id).dxCircularGauge({
        rangeContainer: {
          offset: 10,
          ranges: [
            { startValue: 0, endValue: 95, color: 'red' },
            { startValue: 95, endValue: 100, color: 'yellow' },
            { startValue: 100, endValue: 200, color: '#2DD700' }
          ]
        },
        scale: {
          startValue: 0,  endValue: 200,
          majorTick: { tickInterval: 50 },
          label: {
          }
        },
        title: {
          text: ytd+' % (FY)',
          position: 'bottom-center'
        },
        tooltip: {
          enabled: true,
          customizeText: function (arg) {
            return 'Current ' + arg.valueText;
          }
        },
        subvalueIndicator: {
          type: 'triangleMarker',
          text: {
            customizeText: function (arg) {
              return arg.valueText + '% FY';
            }
          }
        },
        value: ytd,
        subvalues: [ytd],
        valueIndicator: {
            color: 'black',
            width: 6,
            spindleSize: 20,
            spindleGapSize: 15
        },
      });
    });

    //jstopdf
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
       $('.btnPrintHide').hide();
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

      $('.btnPrintHide').show();
    }

    $(".detail-milestone").on("click", function(e){
      console.log($(this).data('id'));
      var id = $(this).data('id');
      var status = $(this).data('status');
      var flagged = $(this).data('flagged');

      $.ajax({
          type: 'GET',
          url: '<?php echo base_url()."summary/getDetailInitiative"; ?>',
          data: 'initiative_id='+id+'&status='+status+'&flagged='+flagged,
          // beforeSend: function(){
          //     $('.tab-rajal').html('');
          //     $('.load-tab').css("display","block");
          //     $('#rekam_medis').html('');
          // },
          success: function(data) {
              $('#modalDiv').empty();

              var template = '<table class="table"><tr><td>No.</td><td>Initiatives</td><td>Start</td><td>End</td>';

              $.each(data.data, function( index, value ) {
                template += '<tr>';
                template += '<td>'+ (index + 1) + '</td>';
                template += '<td>'+ value['title'] + '</td>';
                template += '<td>'+ value['start'] + '</td>';
                template += '<td>'+ value['end'] + '</td>';
                template += '</tr>';
              });

              template += '</table>';

              $("#modalDiv").html(template);

              // $("#modalDiv").dialog('open');
              $( "#modalTrigger" ).click();
              // console.log(data);
              // alert(data.status);
          },
          // complete: function () {
          //     $('img').remove('.original');
          //     $('.tab-rajal:not(.active)').html('');
          // }
      });
    });

    // $(".showInitiative").on("click", function(e){
    //   $(".initiative-detail").hide();

    //   var id = $(this).data('id');

    //   $("#print-"+id).show();
    // });

    $("#showInitiativeOption").on("change", function(e){
      $(".initiative-detail").hide();

      var optionSelected = $("option:selected", this);
      var id = this.value;

      $("#print-"+id).show();
    });

    function show_detail(id){
  		$.ajax({
  			type: "GET",
  			url: config.base+"agenda/get_detail",
  			data: {id: id},
  			dataType: 'json',
  			cache: false,
  			success: function(resp){
  				if(resp.status==1){
  					bootbox.dialog({
  						title: resp.title,
  						message: resp.message
  					});
  				}else{}
  			}
  		});
  	}
</script>
