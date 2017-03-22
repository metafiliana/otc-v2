<table class="table table-hover">
    <thead class="black_color old_grey_color_bg">
    <tr>
        <th style="vertical-align:middle">No</th>
        <th style="vertical-align:middle">Init Code</th>
        <th style="vertical-align:middle">Initiative Name</th>
        <th style="vertical-align:middle">Metric</th>
        <th style="vertical-align:middle">Realisasi</th>
        <th style="vertical-align:middle">Target <?php if(isset($target_year)) echo $target_year; ?></th>
        <th style="vertical-align:middle">Percentage</th>
        <th>Update</th>
    </tr>
    </thead>
    <tbody>
    <?php $pv_init=""; $i=1; foreach($programs as $prog){?>
        <tr>
            <td style="vertical-align:middle">
                <?php echo $i;?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->init_code;?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->title;?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->metric;?>
            </td>
            <td style="vertical-align:middle">
                <?php if($prog['update']){ echo $prog['update']->amount; }else{ echo $prog['prog']->realisasi; }?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['prog']->target;?>
            </td>
            <?php if($pv_init != $prog['prog']->init_code){?>
                <?php foreach($init_code as $inits){ if($prog['prog']->init_code==$inits['code']->init_code){?>
            <td style="vertical-align:middle" rowspan=<?php echo $inits['count_code'];?>>
                <?php echo $total[$inits['code']->init_code]/($inits['count_code']) ; ?> %
            </td>
                <?php } }?>
            <?php $pv_init = $prog['prog']->init_code; } ?>
            <td style="vertical-align:middle">
                <a class="btn btn-link btn-link-edit" onclick="show_form(<?php echo $prog['prog']->id?>);"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
        </tr>
    <?php $i++; }?>
    </tbody>
</table>