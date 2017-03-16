<table class="table table-hover table-striped">
    <thead class="black_color old_grey_color_bg">
    <tr>
        <th style="vertical-align:middle" rowspan=1>Id</th>
        <th style="vertical-align:middle" rowspan=1>Init Code</th>
        <th style="vertical-align:middle" rowspan=1>Title</th>
        <th style="vertical-align:middle">Metric</th>
        <th style="vertical-align:middle">Realisasi</th>
        <th style="vertical-align:middle">Target 2017</th>
        <th>Button</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($programs as $prog){?>
        <tr >
            <td style="vertical-align:middle">
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
            <td style="vertical-align:middle">
                <a class="btn btn-link btn-link-edit" onclick="show_form(<?php echo $prog['id']?>);"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>