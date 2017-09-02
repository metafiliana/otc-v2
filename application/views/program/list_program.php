<style>
.pmo_header{		margin-right:40px;	}
.pmo_header_active a{		margin-right:40px;		color: black;	}
</style>
<div style="padding:5px 10px 5px 0; margin: 10px 30px 10px 40px;">
  <div style="">
    <div style="clear:both"></div>
    <div class="component_part" id="list_of_program">
      <?php echo $list_program?>
    </div><div style="clear:both"></div><br></div>
    <script>
    $(document).ready(function(){
      $('.dropdown-toggle').dropdown()
    });

    function delete_action(id, event){
      bootbox.confirm("Apa anda yakin?",
      function(confirmed) {
        if(confirmed===true){
          $.ajax({
            url: config.base+"program/delete_action",
            data: {id: id},
            dataType: 'json',
            type: "POST",
            success: function (resp) {
              if(resp.status == 1){
                $('#action_'+id).animate({'opacity':'toggle'});
                succeedMessage('Action berhasil dihapus');
              }
            }
          });
        }
      });
    }

    function input_action(init_id,action_id){
      $.ajax({
        type: "GET",
        url: config.base+"program/input_action",
        data: {init_id:init_id, action_id:action_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
          if(resp.status==1){
            show_popup_modal(resp.html);
          }else{}
        }
      });
    }

    function filter_data(){
      var code_filter = $("#code_filter").val();
      $.ajax({
        type: "GET",
        url: config.base+"program/filter_data",
        data: {code_filter:code_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
          if(resp.status==1){
            $('#list_of_filter').html(resp.html);
          }else{}
        }
      });
    }

    function change_data(){
      var code_filter = $("#code_filter").val();
      var filter = $("#filter").val();
      $.ajax({
        type: "GET",
        url: config.base+"program/change_data",
        data: {code_filter:code_filter,filter:filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
          if(resp.status==1){
            $('#list_of_program').html(resp.html);
            $('#wb_count').html(resp.wb);
            $('#count_completed').html(resp.completed);
          }else{}
        }
      });
    }
</script>
