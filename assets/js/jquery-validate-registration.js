function validate_registration(){
    var response1;
    var response2;
    $.validator.addMethod("checkMajor",function(value, element){  
        console.log($(element).parent().parent().find('li').hasClass('token-input-token'))
        if($(element).parent().parent().find('li').hasClass('token-input-token')){
            $(element).parents('.control-group').find('#pilih_jurusan').text('').removeClass('error');
            $(element).parents('.control-group').find('#pilih_jurusan').text('').addClass('success');
            $(element).parents('.control-group').find('#pilih_jurusan').text('').addClass('text_valid').closest('.control-group').addClass('success');
            return true;
        }else{
            $(element).parents('.control-group').removeClass('success');
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').find('#pilih_jurusan').removeClass('text_valid');
            $(element).parents('.control-group').find('#pilih_jurusan').text("Isi Jurusan");
            return false;
        }
    },'<div>Pilih Jurusan Dengan Benar</div>');
    $.validator.addMethod("checkItbEmail", function(value, element) {
      $.ajax({
            type: "POST",
            url: "../user/check_itb_email",
            data: "email="+value,
            dataType:'json',
            async: false,
            success: function(result)
            {
                if(result.value===true){response1 = true;}else if(result.value===false){response1=false;}
            }})
      return response1;}, "Isi dengan email akun ITB");
    $.validator.addMethod("checkExistingItbEmail", function(value, element) {
      $.ajax({
            type: "POST",
            url: "../user/check_existing_itb_email",
            data: "email="+value,
            dataType:"json",
            async: false,
            success: function(result)
            {
                if(result.value===true){response2 = true;}else if(result.value===false){response2=false;}
            }})
      return response2;}, "Email tersebut sudah digunakan");
    $('.reg_form').validate({
        rules: {
          name: {
            required: true
          },
          major:{
            checkMajor:true  
          },
          entranceyear:{
            required: true,
            minlength:4,
            maxlength:4,
            number: true
          },
          email:{
            required: true,
            email: true,
            checkItbEmail: true,
            checkExistingItbEmail :true
          },
          password:{
            required: true,
            minlength:6
          }
        },
        messages:{
            name:"Masukkan nama lengkap",
            entranceyear:{
                required:"Masukkan tahun angkatan YYYY",
                minlength:"Panjang hanya 4 karakter",
                maxlength:"Panjang hanya 4 karakter",
                number:"Hanya dapat memasukkan angka"
            },
            email:{
                required:"Email tidak boleh kosong",
                email: "Format email tidak benar",
                checkItbEmail:"Isi dengan email akun ITB",
                checkExistingItbEmail:"Email tersebut sudah digunakan"
            },
            password:{
                required:"Password minimal 6 karakter",
                minlength:"Password minimal 6 karakter"
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            if($(element).parent().hasClass('token-input-input-token') || $(element).parent().hasClass('token-input-token')){
                //console.log('highlight');
                //$(element).parents('.control-group').removeClass('success');
                //$(element).parents('.control-group').addClass('error');
                //$(element).parents('.control-group').find('#pilih_jurusan').removeClass("text_valid");
            }else{
                $(element).parents('.control-group').removeClass('success');
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').find('span').removeClass("text_valid");               
            }
            
        },
        unhighlight: function(element, errorClass, validClass) {
            if($(element).parent().hasClass('token-input-input-token') || $(element).parent().hasClass('token-input-token')){
                //console.log('unhighlight');
                //$(element).parents('.control-group').find('#pilih_jurusan').text('').removeClass('error');
                //$(element).parents('.control-group').find('#pilih_jurusan').text('').addClass('success');
            }else{
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        },
        success: function(element, errorClass, validClass){
            if($(element).parent().hasClass('token-input-input-token') || $(element).parent().hasClass('token-input-token')){
                //element.parents('.control-group').find('#pilih_jurusan').text('').addClass('text_valid')
                //.closest('.control-group').addClass('success');
            }else{
                element
                .text('').addClass('text_valid')
                .closest('.control-group').addClass('success');
            }
        }
      });
}

$(document).ready(function(){
    validate_registration();
}); // end document.ready