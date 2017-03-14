<table class="table table-hover table-striped">
    <thead class="black_color old_grey_color_bg">
    <tr>
        <th style="vertical-align:middle" rowspan=1>Id</th>
        <th style="vertical-align:middle" rowspan=1>Init Code</th>
        <th style="vertical-align:middle" rowspan=1>Title</th>
        <th style="vertical-align:middle">Metric</th>
        <th style="vertical-align:middle">Realisasi</th>
        <th style="vertical-align:middle">Target 2017</th>


    </tr>
    </thead>
    <tbody>
    <?php foreach($programs as $prog){?>
        <tr >

            <td style="vertical-align:middle">
<!--               -->
<!--                    <div style="float:left; width:50px; margin-right:5px;">--><?php //echo $prog['prog']->init_code?>
<!--                    </div>-->
<!--                    <b><div style="float:left; max-width:300px">--><?php //echo $prog['prog']->segment?><!--</div></b>-->
<!--                    <div style="clear:both"></div>-->
<!--                    <b><div style="float:left; max-width:300px; margin-top:10px">Direktur Sponsor: --><?php //echo $prog['prog']->dir_spon?><!--</div></b>-->
<!--                    <div style="clear:both"></div>-->
<!--                    <b><div style="float:left; max-width:300px; margin-top:10px">PMO Head: --><?php //echo $prog['prog']->pmo_head?><!--</div></b>-->
<!--                    <div style="clear:both"></div>-->
                    <?php echo $prog['id'];?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['init_code'];?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['title'];?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['metric'];?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['realisasi'];?>
            </td>
            <td style="vertical-align:middle">
                <?php echo $prog['target'];?>
            </td>

        </tr>
    <?php }?>
    </tbody>
</table>