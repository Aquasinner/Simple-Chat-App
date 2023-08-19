$(function(){

    $(document).on('click','#hide_password', function(){
        const password_type = $('#password');
        $('#hide_password').toggleClass('active')
        $('#hide_password').hasClass('active') &&  password_type.attr('type')==='password' ? ($('#hide_password').html('<i class="fa-sharp fa-light fa fa-eye-slash"></i>'), password_type.attr('type','text')) : ($('#hide_password').html('<i class="fa-thin fa fa-eye hide"></i>'),password_type.attr('type','password'))
    })

    $(document).on('click','#hide_cpassword', function(){
        const cpassword_type = $('#confirmpassword');
        $('#hide_cpassword').toggleClass('active')
        $('#hide_cpassword').hasClass('active') &&  cpassword_type.attr('type')==='password' ? ($('#hide_cpassword').html('<i class="fa-sharp fa-light fa fa-eye-slash"></i>'), cpassword_type.attr('type','text')) : ($('#hide_cpassword').html('<i class="fa-thin fa fa-eye hide"></i>'),password_type.attr('type','password'))
    })
})