function change_cntry_input(){
	if($('#country').val()=='Other'){
		$('#cntry_adr').load(config.base+'user/form_otr_input');
	}else{
		$('#cntry_adr').load(config.base+'user/form_indo_input');
	}
}
function please_wait_msg(dom){
	$("#"+dom).html('Please wait. . .<br><img src='+config.base+'assets/img/general/loading.gif>');
}
var RESIZEABLE_CANVAS=true;
$.validator.addMethod("ispasswordtrue", function(value, element) {
	var responsepass;
	$.ajax({
		type: "POST",
		url: config.base+"user/check_user_password",
		data: {password: value},
		dataType:"json",
		async: false,
		success: function(result)
		{
			if(result.value===true){responsepass = true;}else if(result.value===false){responsepass=false;}
		}
	})
	return responsepass;
}, "Password Wrong");



$.validator.addMethod(
	"dateTrio",
	function(value, element) {
		var check = false;
		var re = /^\d{1,2}\-\d{1,2}\-\d{4}$/;
		if( re.test(value)){
			var adata = value.split('-');
			var dd = parseInt(adata[0],10);
			var mm = parseInt(adata[1],10);
			var yyyy = parseInt(adata[2],10);
			var xdata = new Date(yyyy,mm-1,dd);
			if ( ( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) )
				check = true;
			else
				check = false;
		} else
			check = false;
		return this.optional(element) || check;
	},
	"Please enter a date in the format dd-mm-yyyy"
);
function toggle_visibility(id) {
    $('#'+id).animate({'height':'toggle','opacity':'toggle'});
}
function toggle_visibility_cart(id) {
    if (!$('#'+id).is(":visible")){
    $('#'+id).show();}
    else{
    	$('#'+id).hide();
    }
    //$($('#'+id)).animate({'height':'toggle','opacity':'toggle'});
    if($('#cart_header').hasClass('active')){$('#cart_header').removeClass('active');}
    else{$('#cart_header').addClass('active');}
}

function succeedMessage(msg){
    $('#succeed-message').text(msg);
    $('#succeed').animate({'height':'toggle','opacity':'toggle'});
    window.setTimeout( function(){$('#succeed').slideUp();}, 2500);   
}

function succeedMessageOwn(msg,div,label){
    $(label).text(msg);
    $(div).animate({'height':'toggle','opacity':'toggle'});
    window.setTimeout( function(){$(div).slideUp();}, 2500);   
}

function CKupdate(){
    CKEDITOR.instances.editor108.getData();
}

function delete_cart_item(base_url, id, event){
	bootbox.confirm("Apa anda yakin ?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: base_url+"user/delete_cart_item",
        		data: {cart_item_id: id},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#eachcartitemtr_'+id).animate({'opacity':'toggle'});
            			$('#tablecarttddiv').load(base_url+'user/load_cart_items', function(){
            				$("#sum_ci_hdr").html(resp.sum_ci);
        				});
            		}
        		}
    		});
        }
    });
}

$(document).mouseup(function (e)
{
    var container = $("#tablecarttddiv");
	var navbar = $('.navbar');
	var dialog = $('.modal-dialog');
	var detail = $('.dataItemDetail');
    if ($("#shopping_list").is(":visible")
    	&& !detail.is(e.target)
    	&& detail.has(e.target).length === 0
    	&& !dialog.is(e.target)
    	&& dialog.has(e.target).length === 0
    	&& !navbar.is(e.target)
    	&& navbar.has(e.target).length === 0
    	&& !container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
       toggle_visibility_cart('shopping_list');
    }
});

function form_edtadr_val(form){
	$("#"+form).validate({
		rules: {
			name: "required",
			address: "required",
			province: "required",
			city: "required",
			postcode: {
				required: true,
				number: true
			},
			agree: "required"
		}
	});
}

function change_city(){
	var prov = $("#province").val();
	$('#city').load(config.base+'user/load_cities/'+prov);
}

function show_popup_modal(resp){
	$('#popup_Modal').modal('hide');
	setTimeout(function(){
  		$('#modal_finder').html(resp);
    	$('#popup_Modal').modal('show');
    	$('[data-toggle="tooltip"]').tooltip();
	}, 500);
}