<select class="form-control" name="code" id="code" onchange="view_all();">
	<?php foreach($code as $progs){?>
	<option <?php if (isset($all) && $all->code == $progs->val ) echo 'selected' ; ?> value="<?php echo $progs->val?>"><?php echo $progs->val?></option>
	<?php }?>
</select>