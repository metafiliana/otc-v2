<?php $user = $this->session->userdata('user'); ?>
<table class="table table-hover">
    <thead class="black_color old_grey_color_bg">
    <tr>
        <th style="vertical-align:middle">Code & Initiative Name</th>
        <th style="vertical-align:middle">Metric</th>
        <th style="vertical-align:middle">Realisasi</th>
        <th style="vertical-align:middle">Target <?php if(isset($target_year)) echo $target_year; ?></th>
        <th style="vertical-align:middle">Percentage</th>
        <th style="vertical-align:middle">Percentage All</th>
        <th>Update Realisasi</th>
        <?php if($user['role']=='admin') {?>
        <th>Update Target</th>
        <?php }?>
    </tr>
    </thead>
    <tbody>
    <?php $pv_init=""; $code=""; $i=1; foreach($programs as $prog){?>
        <tr>
            <td style="vertical-align:middle">
            <?php if($code != $prog['prog']->init_code){?>
                <div><?php echo $prog['prog']->init_code;?>. <?php echo $prog['prog']->title;?></div>
             <?php $code = $prog['prog']->init_code; } ?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->metric;?>
            </td>
            <td style="vertical-align:middle">
                <a onclick="detail_update(<?php echo $prog['prog']->id?>,<?php echo $prog['prog']->target_year?>);"><?php if($prog['update']){ echo $prog['update']->amount; echo " (".date('F',mktime(0,0,0, $prog['update']->month,10)).")";}else{ echo $prog['prog']->realisasi; echo " (".$prog['prog']->real_month.")"; }?></a>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->target;?>
            </td>
            <td style="vertical-align:middle">
                <?php echo number_format($prog['percentage'],2)." %";?>
            </td>
            <?php if($pv_init != $prog['prog']->init_code){?>
                <?php foreach($init_code as $inits){ if($prog['prog']->init_code==$inits['code']->init_code){?>
            <td style="vertical-align:middle" rowspan=<?php echo $inits['count_code'];?>>
                <?php echo number_format($total[$inits['code']->init_code]/($inits['count_code']),2) ; ?> %
            </td>
                <?php } }?>
            <?php $pv_init = $prog['prog']->init_code; } ?>
            <td style="vertical-align:middle">
                <a class="btn" onclick="show_form(<?php echo $prog['prog']->id?>,'Realisasi','');"><?php echo plus_icon()?> Update</a>
            </td>
            <?php if($user['role']=='admin') {?>
            <td style="vertical-align:middle">
                <a class="btn" onclick="show_form(<?php echo $prog['prog']->id?>,'Target','');"><?php echo icon_small('plus_blue.png')?> Update Target</a>
            </td>
            <?php }?>
        </tr>
    <?php $i++; }?>
    </tbody>
</table>