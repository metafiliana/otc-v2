<select onchange="change_data()" id="cust_grouping_filter" name="cust_grouping_filter" class="selectpicker show-tick form-control" data-width="100%">
    <?php foreach($arr as $each){?>
    <option value="<?php echo $each->val?>"><?php echo $each->val?></option>
    <?php }?>
</select>