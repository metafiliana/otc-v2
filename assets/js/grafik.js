function change_table_view(id, code){
	$.ajax({
    	type: "GET",
        url: config.base+"realization/realization_table_view",
        data: {id: id, code: code},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#content_realisasi").html(resp.html);
            }else{}
        }
    });
}

function change_graph_view(id, code){
	$.ajax({
    	type: "GET",
        url: config.base+"realization/realization_graph_view",
        data: {id: id, code: code},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#content_realisasi").html(resp.html);
            }else{}
        }
    });
}