<table class="table text-center">
    <thead>
        <th>Initiatives</th>
    </thead>
    <tbody>
        <!-- isi disini -->
        <?php 
        	foreach ($initiatives as $key => $value) {
        		echo "<tr id='row-".$value->id."'>";
        		echo "<td><a class = 'filter-value-detail-workblock' data-id = '".$value->id."'>".$value->title."</a></td>";
        		echo "</tr>";
        	}
        ?>
    </tbody>
</table>