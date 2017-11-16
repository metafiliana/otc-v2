<table  class="init-table" style="margin-left: 50px;width: 90%; margin-top: 50px;">
  <tr class="head">
    <td><center>Initiative Code</center></td>
    <td><center>Judul Initiative</center></td>
  </tr>
<?php
  foreach($initiative as $init){
?>
  <tr>
    <td style="width:20%; vertical-align: middle;font-size: 16px"><center><?php echo $init->init_code?></center></td>
    <td style="width: 80%; font-size: 16px;"><a href="#openModal<?php echo $init->id?>" onclick="input_init_id(<?php echo $init->id?>)"><?php echo $init->title?></a></td>
  </tr>
<?php }?>

                   
</table>

<?php
  foreach($initiative as $init){
?>
<div id="openModal<?php echo $init->id?>" class="modalDialog">
  
</div>
<?php }?>

<script type="text/javascript">
function input_init_id(id){
  $.ajax({
    type: "POST",
    url: config.base+"program/input_init_id",
    data: {id:id},
    dataType: 'json',
    cache: false,
    success: function(resp){
      console.log(resp.pop_up);
        $("#openModal"+resp.id).html(resp.pop_up);
    }
  });
}
</script>