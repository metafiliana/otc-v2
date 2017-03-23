<table class="table text-center">
    <thead>
        <th colspan="2">Programs</th>
        <th></th>
    </thead>
    <tbody>
        <!-- isi disini -->
        <?php 
        	foreach ($programs as $key => $value) {
        		echo "<tr id='row-".$value['id']."'>";
        		echo "<td>".$value['code']."</td>";
        		echo "<td><a class = 'filter-value-detail-initiative' data-id = '".$value['id']."'>".$value['title']."</a></td>";
        		echo "</tr>";
        	}
        ?>
    </tbody>
</table>