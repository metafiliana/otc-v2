<select onchange="change_data()" id="filter" name="filter" class="dropdown" data-width="100%" style="margin-top:10px;">
    <?php foreach($arr as $each){?>
    <option value="<?php echo array(explode(";", $each->initiative))?>"><?php echo $each->name?></option>
    <?php }?>
</select>