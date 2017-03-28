        <!-- isi disini -->
        <?php 
        	// foreach ($programs as $key => $value) {
        	// 	echo "<tr id='row-".$value['id']."'>";
        	// 	echo "<td>".$value['init_code']."</td>";
        	// 	echo "<td><a class = 'filter-value-detail-initiative' data-id = '".$value['id']."'>".$value['title']."</a></td>";
        	// 	echo "</tr>";
        	// }
        ?>
<strong><p align="center">Programs</p></strong>
<div class="panel-group" id="accordion">
    <?php
        foreach ($programs as $key => $value) {
            echo "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'>";
            echo "<a class = 'filter-value-detail-program-list' data-id = '".$value['init_code']."' data-toggle='collapse' data-parent='#accordion' href='#collapse".$value['id']."'>".$value['segment']." ( ".$value['init_code']." )</a></h4></div>";
            echo "<div id='collapse".$value['id']."' class='panel-collapse collapse'><div class='panel-body' id='panel-program-".$value['init_code']."'>";
            echo "</div></div></div>";
        }
    ?>
</div>