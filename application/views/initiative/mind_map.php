<div id="" class="container no_pad">
	<?php 
		$prg=''; $int=''; $wb='';
		foreach($all as $r){
			if($r->program != $prg){
				echo "1. ".$r->program."<br>";
				$prg=$r->program;
			}
			if($r->initiative != $int){
				echo "2. ".$r->initiative."<br>";
				$int=$r->initiative;
			}
			if($r->workblock != $wb){
				echo "3. ".$r->workblock."<br>";
				$wb=$r->workblock;
			}
			echo "4. ".$r->initiative."<br>";
	?>
	<?php }?>
</div>