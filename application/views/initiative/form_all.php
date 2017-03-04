<div class="form-group">
    <label class="col-sm-3 control-label">Sub Initiative Number</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" id="code" name="code" placeholder="Category" value="<?php if (isset($all->code)){ echo $all->code ; } else{echo $code.'.';}?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label" for="">Category</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="category" name="category" placeholder="Category" value="<?php if (isset($all->category)) echo $all->category ; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label" for="">Initiative Name</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="segment" name="segment" placeholder="Initiative Name" value="<?php if (isset($all->segment)) echo $all->segment ; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Direktur Sponsor</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="dir_spon" name="dir_spon" placeholder="Direktur Sponsor" value="<?php if (isset($all->dir_spon)) echo $all->dir_spon ; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">PMO Head</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="pmo_head" name="pmo_head" placeholder="PMO Head" value="<?php if (isset($all->pmo_head)) echo $all->pmo_head ; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Sub Initiative Name</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="title" name="title" placeholder="Program" value="<?php if (isset($all->title)) echo $all->title ; ?>">
    </div>
</div>