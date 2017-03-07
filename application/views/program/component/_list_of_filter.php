<select onchange="change_data()" id="filter" name="filter" class="dropdown" data-width="100%" style="margin-top:10px;">
    <?php foreach($arr as $each){?>
    <option value="<?php echo $each->val?>"><?php echo $each->val?></option>
    <?php }?>
</select>