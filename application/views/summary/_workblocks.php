<table class="table text-center">
    <thead>
        <th colspan="3">Workblocks</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <!-- isi disini -->
        <?php 
            $color_style = 'active';
        	foreach ($workblocks as $key => $value) {
                if ($value->status == 'Delay'){
                    $color_style = 'danger';
                }
                if ($value->status == 'Completed'){
                    $color_style = 'success';
                }
                if ($value->status == 'Not Started Yet'){
                    $color_style = 'warning';
                }
                if ($value->status == 'In Progress'){
                    $color_style = 'info';
                }
                echo "<tr id='row-".$value->id."' class='".$color_style."'>";
                echo "<td>".$value->code."</td>";
                echo "<td>".$value->title."</td>";
        		echo "<td>".$value->status."</td>";
                echo "</tr>";
        	}
        ?>
    </tbody>
</table>