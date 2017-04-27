<style>
    .pmo_header{
        margin-right:40px;
    }
    .pmo_header_active a{
        margin-right:40px;
        color: black;
    }
    #chartdiv {
      width: 100%;
      height: 100px;
    }
</style>


<div class="component_part">
    <div class="row">
        <div class="col-md-12">
            <h3>Summary Initiative</h3>
            <h4> 30% (6 Initiative) Done dari Total 20 intiative Terdapat 3 initiative delay, dan 2 initiative at Risk.</h4>
        </div>
    <div>
    <div class="row">
        <div class="col-md-12">
             <div id="chartdiv" style="width: 640px; height: 400px;"></div>

        </div>
    </div>
</div>

<script type=”text/javascript”> 
  var chartData = [ {
    "country": "USA",
    "visits": 4252
  }, {
    "country": "China",
    "visits": 1882
  }, {
    "country": "Japan",
    "visits": 1809
  }, {
    "country": "Germany",
    "visits": 1322
  }, {
    "country": "UK",
    "visits": 1122
  }, {
    "country": "France",
    "visits": 1114
  }, {
    "country": "India",
    "visits": 984
  }, {
    "country": "Spain",
    "visits": 711
  }, {
    "country": "Netherlands",
    "visits": 665
  }, {
    "country": "Russia",
    "visits": 580
  }, {
    "country": "South Korea",
    "visits": 443
  }, {
    "country": "Canada",
    "visits": 441
  }, {
    "country": "Brazil",
    "visits": 395
  }, {
    "country": "Italy",
    "visits": 386
  }, {
    "country": "Australia",
    "visits": 384
  }, {
    "country": "Taiwan",
    "visits": 338
  }, {
    "country": "Poland",
    "visits": 328
} ];


AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "dataProvider": chartData,
  "categoryField": "country",
  "graphs": [ {
    "valueField": "visits",
    "type": "column"
  } ]
} );
</script>