<strong><p align="center">Deliverables ( <?php echo $init_code; ?> )</p></strong>
<div class="panel-group" id="accordion">
    <?php
        foreach ($initiatives as $key => $value) {
        	$percent = 0;
            if ($value->total_w != 0){
                $percent_raw = ($value->total_c / $value->total_w) * 100;
                $percent = number_format($percent_raw, 2, '.', '');
            }
            echo "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'>";

            echo "<a class = 'filter-value-detail-workblock' data-id = '".$value->id."' data-toggle='collapse' data-parent='#accordion' href='#collapse".$value->id."'>".$value->title." (".$percent."%)</a></h4></div>";

            echo "<div id='collapse".$value->id."' class='panel-collapse collapse'><div class='panel-body' id='panel-initiative-".$value->id."'>";

            echo "</div></div></div>";
        }
    ?>
</div>