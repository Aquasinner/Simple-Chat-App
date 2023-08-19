$(document).on('submit', '#register_form', function(e){
    e.preventDefault()

    var form = new FormData(this);
    // console.log(form)
    var password = $('#password').val();
    var confirmPassword = $('#confirmpassword').val();
    var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+\-]).{6,16}$/;
    var isValid = pattern.test(password)
   
    if (!navigator.onLine) {
    $("#error_alert").html(
            `<div  class="alert alert-danger" role="alert">No internet connection. Please check your connection and try again.</div>`
          );
  }
    try{
    if (password !== confirmPassword) {
        $('#error_alert').html(`<div  class="alert alert-danger" role="alert">'Password and confirmpassword does not match'</div>`)
        return false; // Prevent form submission
    }else if(!isValid){
        $('#required').html(`<div  class="alert alert-danger required" role="alert">Password should contains atleast lowercase character, uppercase, number and special character.Password should be 8 characters or 16 characters. </div>`)
    }else{
        $.ajax({
            url: 'action/action.php',
            type: 'post',
            dataType: 'JSON',
            data : new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                // console.log(data)
                if(data.res == 'empty_fname'){
                    $('#error_alert').html(`<div  class="alert alert-danger" role="alert">${data.empty_fname}.</div>`)
                }else if(data.exist == 'exist'){
                    $('#error_alert').html(`<div  class="alert alert-danger" role="alert">${data.existed}.</div>`)
                    $('#avatar').val('')
                }else if(data.res == 'success'){
                    window.location.href = '../'
                    $('#register_form')[0].reset()
                }
            }
        })
    }
    }catch(error){
        console.log('There is an error:' + error);
    }
// console.log($(this).serialize())
    
})