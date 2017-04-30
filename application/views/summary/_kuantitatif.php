<strong><p align="center">Kuantitatif</p></strong>
<div class="panel-group" id="accordion">
    <?php
        echo '<table class="table text-center display">';
        echo '<thead><tr><th>Title</th><th>Metric</th><th>Realisasi</th><th>Target</th><th>Precentage</th></tr></thead>';
        echo '<tbody>';
        $title = '';
        foreach ($kuantitatif as $key => $value) {
            echo '<tr>';
            if ($title != $value['prog']->init_code){
                echo '<td style="vertical-align:middle">'.$value['prog']->title.'</td>';
                $title = $value['prog']->init_code;
            }else{
                echo '<td></td>';
            }
            echo '<td>'.$value['prog']->metric.'</td>';
                if($value['update']){ 
                    echo '<td>';
                    echo $value['update']->amount; 
                    echo " (".date('F',mktime(0,0,0, $value['update']->month,10)).")";
                    echo '</td>';
                }else{ 
                    echo '<td>'.$value['prog']->realisasi." (April)</td>"; 
                }
            echo '<td>'.$value['prog']->target.'</td>';
            echo '<td>'.number_format($value['percentage'],2).' %</td>';
            echo '</tr>';


            // echo "<a class = 'filter-value-detail-workblock' data-id = '".$value->id."' data-toggle='collapse' data-parent='#accordion' href='#collapse".$value->id."'>".$value->metric."</a></h4></div>";

            // echo "<div id='collapse".$value->id."' class='panel-collapse collapse'><div class='panel-body' id='panel-initiative-".$value->id."'>";

            // echo "</div></div></div>";
        }
        echo '</tbody>';
        echo '</table>';
        // var_dump($kuantitatif);
    ?>
</div>