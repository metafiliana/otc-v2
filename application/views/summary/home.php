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

      <!-- header area start -->
      <div class="component_part" style="margin-top:10px;">
        <div class="row">
          <h2 class="text-center">Welcome, <?php echo $user['name']; ?></h2>
        </div>
      </div><div style="clear:both;"></div>
      <!-- header area ends -->

      <?php if ($is_admin){ ?>
        <!-- data area top 21 bod start -->
        <div class="component_part">
          <div class="row">
            <h3 class="text-center">Realisasi Pencapaian Top 21 BOD Level Initiatives</h3>
            <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
            <div class="col-md-12 table-content">
              <div class="col-md-6">
                <div id="mtdGauge"></div>
              </div>
              <div class="col-md-6">
                <div id="ytdGauge"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <h4 class="text-center">Show Initiatives</h4>
          <table class="table text-center" border="1px solid black">
            <tr>
              <?php foreach ($initiatives_detail as $key => $value) { ?>
              <td class="showInitiative detail-milestone" data-id="<?php echo $key;?>"><?php echo $value['init_code']; ?></td>
              <?php } ?>
            </tr>
          </table>
        </div>
        <br>

        <!-- data area inititatives start -->
        <div class="component_part">
          <div class="row">
            <?php foreach ($initiatives_detail as $key => $value) { ?>
            <div class="col-md-12 table-content initiative-detail" id="print-<?php echo $key; ?>">
              
              <!-- data area inititatives-kuantitatif start -->
              <div class="col-md-7">
                <h3 class="text-center">Realisasi Pencapaian Initiatives <?php echo $value['init_code']; ?></h3>
                <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
                <div class="col-md-6">
                  <div class="mtd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <div class="col-md-6">
                  <div class="ytd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <button class="detail-initiatives text-center" data-id="<?php echo $value['id'];?>" data-mtd="<?php echo $value['kuantitatif_mtd'];?>" data-ytd="<?php echo $value['kuantitatif_ytd'];?>">Details</button>
              </div>
              <!-- data area inititatives-kuantitatif ends -->
              
              <!-- data area milestone start -->
              <div class="col-md-5">
                <h3 class="text-center">Realisasi Pencapaian Milestone Initiatives <?php echo $value['init_code']; ?></h3>
                <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
                <div class="col-md-6 text-center">
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="1" data-flagged="false">Complete: <?php echo $value['completed']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="2" data-flagged="false">On Track: <?php echo $value['on_track']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="0" data-flagged="false">Future Start: <?php echo $value['future_start']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="false" style="color: red">Flagged: <?php echo $value['flagged']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="2" style="color: red">Overdue: <?php echo $value['overdue']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="1" style="color: red">Delay: <?php echo $value['delay']; ?></p>
                </div>
                <div class="col-md-6 text-center">
                  <span>MTD : <?php echo $value['milestone_mtd']; ?>%</span>
                  <br>
                  <span>FL : <?php echo $value['milestone_ytd']; ?>%</span>
                  <br>
                  <button onclick="take('print-<?php echo $key; ?>')" class="btn btn-info-new">Print</button>
                </div>
              </div>
              <!-- data area milestone start -->

            </div>
            <?php } ?>
          </div>
        </div>
        <!-- data area initiatives ends -->
        <?php } ?>

      <?php if (!$is_admin){ ?>
        <!-- data area inititatives start -->
        <?php foreach ($initiatives_detail as $key => $value) { ?>
        <div class="component_part">
          <div class="row">
            <div class="col-md-12 table-content" id="print-<?php echo $key; ?>">
              
              <!-- data area inititatives-kuantitatif start -->
              <div class="col-md-7">
                <h3 class="text-center">Realisasi Pencapaian Initiatives <?php echo $value['init_code']; ?></h3>
                <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
                <div class="col-md-6">
                  <div class="mtd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <div class="col-md-6">
                  <div class="ytd-gauge-init-<?php echo $value['id'];?>"></div>
                </div>
                <button class="detail-initiatives text-center" data-id="<?php echo $value['id'];?>" data-mtd="<?php echo $value['kuantitatif_mtd'];?>" data-ytd="<?php echo $value['kuantitatif_ytd'];?>">Details</button>
              </div>
              <!-- data area inititatives-kuantitatif ends -->
              
              <!-- data area milestone start -->
              <div class="col-md-5">
                <h3 class="text-center">Realisasi Pencapaian Milestone Initiatives <?php echo $value['init_code']; ?></h3>
                <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
                <div class="col-md-6 text-center">
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="1" data-flagged="false">Complete: <?php echo $value['completed']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="2" data-flagged="false">On Track: <?php echo $value['on_track']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="0" data-flagged="false">Future Start: <?php echo $value['future_start']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="false" style="color: red">Flagged: <?php echo $value['flagged']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="2" style="color: red">Overdue: <?php echo $value['overdue']; ?></p>
                  <p class="detail-milestone" data-id="<?php echo $value['id']; ?>" data-status="3" data-flagged="1" style="color: red">Delay: <?php echo $value['delay']; ?></p>
                </div>
                <div class="col-md-6 text-center">
                  <span>MTD : <?php echo $value['milestone_mtd']; ?>%</span>
                  <br>
                  <span>FL : <?php echo $value['milestone_ytd']; ?>%</span>
                  <br>
                  <button onclick="take('print-<?php echo $key; ?>')" class="btn btn-info-new">Print</button>
                </div>
              </div>
              <!-- data area milestone start -->

            </div>
          </div>
        </div>
        <?php } ?>
        <!-- data area initiatives ends -->
      <?php } ?>

      <!-- activities area start -->
      <div class="component_part" style="margin-top:10px;">
        <div class="row">
          <h2 class="text-center">Next Activities</h2>
        </div>
      </div><div style="clear:both;"></div>
      <!-- activities area ends -->

      <!-- dialog area starts -->
      <div id="modalDiv" title="Detail Initiative"></div>
      <!-- dialog area ends -->

</div>

<!-- <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script> -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script>
<script type="text/javascript" src="http://cdn3.devexpress.com/jslib/15.2.5/js/dx.chartjs.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( document ).ready( function() {
      $(".initiative-detail").hide();
      $( '#modalDiv' ).dialog( { 'autoOpen': false } );
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
      // title: {
      //   text: 'Realisasi Pencapaian Top 21 BOD Level Initiatives',
      //   subtitle: '( as of <?php echo date('F Y'); ?>)',
      //   position: 'top-center'
      // },
      tooltip: {
        enabled: true,
        // format: 'currency',
        customizeText: function (arg) {
          return 'Current ' + arg.valueText;
        }
      },
      subvalueIndicator: {
        type: 'textCloud',
        // format: 'thousands',
        text: {
          // format: 'currency',
          customizeText: function (arg) {
            return arg.valueText + '% MTD';
          }
        }  
      },
      value: <?php echo $top_bod['mtd']; ?>,
      subvalues: [<?php echo $top_bod['mtd']; ?>]
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
      // title: {
      //   text: 'Realisasi Pencapaian Top 21 BOD Level Initiatives',
      //   subtitle: '( as of <?php echo date('F Y'); ?>)',
      //   position: 'top-center'
      // },
      tooltip: {
        enabled: true,
        // format: 'currency',
        customizeText: function (arg) {
          return 'Current ' + arg.valueText;
        }
      },
      subvalueIndicator: {
        type: 'textCloud',
        // format: 'hundreds',
        text: {
          // format: 'currency',
          customizeText: function (arg) {
            return arg.valueText + '% FL';
          }
        }  
      },
      value: <?php echo $top_bod['ytd']; ?>,
      subvalues: [<?php echo $top_bod['ytd']; ?>]
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
        tooltip: {
          enabled: true,
          customizeText: function (arg) {
            return 'Current ' + arg.valueText;
          }
        },
        subvalueIndicator: {
          type: 'textCloud',
          text: {
            customizeText: function (arg) {
              return arg.valueText + '% MTD';
            }
          }  
        },
        value: mtd,
        subvalues: [mtd]
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
        tooltip: {
          enabled: true,
          customizeText: function (arg) {
            return 'Current ' + arg.valueText;
          }
        },
        subvalueIndicator: {
          type: 'textCloud',
          text: {
            customizeText: function (arg) {
              return arg.valueText + '% FL';
            }
          }  
        },
        value: ytd,
        subvalues: [ytd]
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
    }

    $(".detail-milestone").on("click", function(e){
      console.log($(this).data('id'));
      var id = $(this).data('id');
      var status = $(this).data('status');
      var flagged = $(this).data('flagged');

      $.ajax({
          type: 'GET',
          url: '/summary/getDetailInitiative',
          data: 'initiative_id='+id+'&status='+status+'&flagged='+flagged,
          // beforeSend: function(){
          //     $('.tab-rajal').html('');
          //     $('.load-tab').css("display","block");
          //     $('#rekam_medis').html('');
          // },
          success: function(data) {
              $('#modalDiv').empty();

              var template = '<table border="1px solid black"><tr><td>initiatives</td><td>Start</td><td>End</td>';

              $.each(data.data, function( index, value ) {
                template += '<tr>';
                template += '<td>'+ value['title'] + '</td>';
                template += '<td>'+ value['start'] + '</td>';
                template += '<td>'+ value['end'] + '</td>';
                template += '</tr>';
              });

              template += '</table>';

              $("#modalDiv").html(template);

              $("#modalDiv").dialog('open');
              // console.log(data);
              // alert(data.status);
          },
          // complete: function () {
          //     $('img').remove('.original');
          //     $('.tab-rajal:not(.active)').html('');
          // }
      });
    });

    $(".showInitiative").on("click", function(e){
      $(".initiative-detail").hide();

      var id = $(this).data('id');

      $("#print-"+id).show();
    });
</script>
