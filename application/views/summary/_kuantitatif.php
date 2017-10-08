<strong>
    <p align="center">Kuantitatif 
    <?php 
        foreach ($init_code as $key => $value) {
            echo $value.' ';
        }
    ?>
    </p>
</strong>
<div class="panel-group" id="accordion">
    <?php
        echo '<table class="table text-center display">';
        echo '<thead><tr><th>No</th><th>Code</th><th>Title</th><th>Metric</th><th>Realisasi</th><th>Target</th><th>Percentage</th></tr></thead>';
        echo '<tbody>';
        $title = '';
        $i = 1;
        foreach ($kuantitatif as $key => $value) {
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$value['prog']->init_code.'</td>';
            if ($title != $value['prog']->init_code){
                echo '<td style="vertical-align:middle">'.$value['prog']->title.'</td>';
                $title = $value['prog']->init_code;
            }else{
                echo '<td></td>';
            }
            echo '<td>'.$value['prog']->metric.'</td>';
                if($value['update']){ 
                    echo '<td>';
                    echo number_format($value['update']->amount); 
                    echo " (".date('F',mktime(0,0,0, $value['update']->month,10)).")";
                    echo '</td>';
                }else{ 
                    echo '<td>'.number_format($value['prog']->realisasi)." (April)</td>"; 
                }
            echo '<td>'.number_format($value['prog']->target,2).'</td>';
            echo '<td>'.number_format($value['percentage'],2, ',', ',').' %</td>';
            echo '</tr>';
            $i++;
        }
        echo '</tbody>';
        echo '</table>';
    ?>
</div>