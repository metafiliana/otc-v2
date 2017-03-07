<style>
	.pmo_header{
		margin-right:40px;
	}
	.pmo_header_active a{
		margin-right:40px;
		color: black;
	}
</style>
<div style="padding:5px 10px 5px 0; margin: 10px 30px 10px 40px;">
	<!-- <div>
		<div style="font-size:16px">
			<span style="color:grey; font-size:11px">Category</span>
			<div>
				<?php 
					foreach($arr_categ as $each){
						$class="pmo_header";
						$segment = str_replace("%20", " ", $this->uri->segment(3));
						if($segment==$each->val){
							$class="pmo_header_active";
						} 
						echo "<span class='".$class."'><a href='".base_url()."program/list_programs/".$each->val."'>".$each->val."</a></span>";
					}
				?>
			</div>
		</div>
	</div>
	<hr>
	<h2><?php echo $segment?></h2> -->
	<div style="">
		<div class="row">
		<div class="col-md-4">
            </div>
		<?php if($page=="all"){?>
			<div class="col-md-3">
				<div class="component_part" style="height: 80px;">
					<div class="dropdown">
					<span class="center_text" style="font-size:14px; margin-right:10px; margin-bottom: 0px;">Filter </span>
	                <select onchange="filter_data();" id="code_filter" name="code_filter" class="dropdown-toggle" data-width="100%" aria-haspopup="true" aria-expanded="true">
	                    <option value="category">Category</option>
	                    <option value="dir_spon">Direktur Sponsor</option>
	                    <option value="pmo_head">PMO Head</option>
	                </select>
	                </div>
	                <div id="list_of_filter" class="dropdown">
	                </div>
                </div>
            </div>
            <?php }?>
            <div class="col-md-5">
				<div class="component_part">
					<table class="table" style="margin-bottom:0">
						<thead>
							<tr class="black_color">
								<th class="grey_color_bg" style="vertical-align:middle;">Not Started Yet</th>
								<th class="green_color_bg" style="vertical-align:middle;">In Progress</th>
								<th class="red_color_bg" style="vertical-align:middle;">At Risk</th>
								<th class="yellow_color_bg" style="vertical-align:middle;">Delay</th>
								<th class="blue_color_bg" style="vertical-align:middle;">Completed</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
								<th class="center_text"><span>0%</span></th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
		<div style="clear:both"></div>
		<div style="clear:both">
			<div class="component_part" id="list_of_program">
				<?php echo $list_program?>
		</div>	
			<!--</div>
		</div>-->
	</div><div style="clear:both"></div><br>
</div>
<script>

$(document).ready(function(){
    $('.dropdown-toggle').dropdown()
});
	function delete_program(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"program/delete_program",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#prog_'+id).animate({'opacity':'toggle'});
							succeedMessage('Workblock berhasil dihapus');
						}
					}
				});
			}
		});
	}

function show_form(id){
    $.ajax({
        type: "GET",
        url: config.base+"program/input_program",
        data: {id:id},
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
            }else{}
        }
    });
}
</script>