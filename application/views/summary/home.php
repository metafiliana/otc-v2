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
      <div class="component_part_summary" style="margin-top:10px;">
      <!-- search area -->
      <div class="row">
        <h2 class="text-center">Welcome, <?php echo $user['name']; ?></h2>
      </div>
      </div><div style="clear:both;"></div>
      <div class="component_part">
        <div class="row">
          <h3 class="text-center">Realisasi Pencapaian Top 21 BOD Level Initiatives</h3>
          <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
          <!-- data area -->
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
      <div class="component_part">
        <div class="row">
          <!-- data area -->
          <div class="col-md-12 table-content">
            <div class="col-md-7">
              <h3 class="text-center">Realisasi Pencapaian Initiatives 1A</h3>
              <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
              <div class="col-md-6">
                <div class="mtdGaugeInit"></div>
              </div>
              <div class="col-md-6">
                <div class="ytdGaugeInit"></div>
              </div>
            </div>
            <div class="col-md-5">
              <h3 class="text-center">Realisasi Pencapaian Milestone Initiatives 1A</h3>
              <h5 class="text-center">( as of <?php echo date('F Y'); ?>)</h5>
              <div class="col-md-6 text-center">
                <p>Complete: 44</p>
                <p>On Track: 44</p>
                <p>Future Start: 44</p>
                <p style="color: red">Flagged: 44</p>
                <p style="color: red">Overdue: 44</p>
                <p style="color: red">Delay: 44</p>
              </div>
              <div class="col-md-6 text-center">
                <button>MTD</button>
                <button>YTD</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<!-- <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script> -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script>
<script type="text/javascript" src="http://cdn3.devexpress.com/jslib/15.2.5/js/dx.chartjs.js"></script>

<script>
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
      value: 96,
      subvalues: [96]
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
            return arg.valueText + '% YTD';
          }
        }  
      },
      value: 65,
      subvalues: [65]
    });

    $(".mtdGaugeInit").dxCircularGauge({
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
      value: 55,
      subvalues: [55]
    });

    $(".ytdGaugeInit").dxCircularGauge({
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
            return arg.valueText + '% YTD';
          }
        }  
      },
      value: 65,
      subvalues: [65]
    });
</script>
