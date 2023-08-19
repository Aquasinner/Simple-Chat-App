// SEARCH USER
$(document).on("submit", "#searchform", function (e) {
  e.preventDefault();

  var searchuser = $("#searchuser").val();
  $.ajax({
    url: "action/action.php",
    method: "GET",
    dataType: "JSON",
    data: { search: searchuser },
    success: function (data) {
      var html = '';
            if (data.length > 0) {
                data.forEach(function(user) {
                    html += `<a href="convo.php?user=${user.userid}" id="reciever_id" class=" d-flex justify-content-between align-items-center z-index-1000" style="text-decoration: none; padding: .25rem 1rem">
                    <div class="user_details d-flex column-gap-2 justify-content-between align-items-center">
                    <img class="profile_img" src="./../Images/${user.img}" alt="profile_logo" width="30" height="30">
                        <div>
                            <span>${user.name}</span>
                        </div>
                    </div>
                </a> `
                });
            } else if (data.res == "notfound") {
                html = data.result;
            } else if (data.res == "empty") {
                $("#searchResults").hide();
            }
            $('#searchResults').html(html);
    },
  });
});

// SAVE THE SENDER ID AND ALSO RECIEVER TO SET THE CHAT

$(document).on("click", "#reciever_id", function (e) {
    e.preventDefault();

    var link = $(this).attr("href"); // Get the link URL
    var reciever_id = link.split("=")[1]; // Extract the ID from the URL
    $.ajax({
        url: "action/action.php",
        method: "POST",
        dataType: "JSON",
        data: { id: reciever_id },
        success: function (data) {
            // console.log(link + "&chat_id=" + data.chat_id);
            window.location.href = link + "&chat_id=" + data.chat_id;
        },
    });
    //
});

// CHAT USER

$(document).on("submit", "#send_message", function (e) {
    e.preventDefault();

    var fileInput = $("#file-input")[0];
    var textInput = $("#message");

    // Check if there is a file attached
    if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append("file", file);
        formData.append("recieverId", $("input[name=recieverId]").val());

        // Make AJAX request to save the file
        $.ajax({
            url: "action/action.php",
            type: "POST",
            data: formData,
            // dataType: "JSON",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                // console.log(response);
                $("#send_message")[0].reset();
            },
        });
    } else {
        // SEND TEXT
        $.ajax({
            url: "action/action.php",
            method: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function (data) {
                // console.log(data);
                $("#send_message")[0].reset();
            },
        });
    }
});

// LOG OUT USER
$(document).on("click", "#log_out", function () {
    $.ajax({
        url: "log_out.php",
        type: "POST",
        success: function (response) {
            // Handle successful logout
            console.log(response);
            window.location.href = "..";
        },
    });
});

// DELETE CONVERSATION
$(document).on("click", "#delete_convo", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $.ajax({
        url: "action/action.php",
        method: "POST",
        dataType: "JSON",
        data: { chat_id: id },
        success: function (response) {
            // Handle the response from the server
            // console.log(response);
            window.location.href = ".";
        },
    });
});

$(document).on("click", "#profile", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    window.location.href = "profile.php?userid=" + id;
});

$(document).on("click", "#update_profile, #update_pass", function (e) {
    e.preventDefault();

    if (this.id === "update_profile") {
        $("#updateForm").css({ display: "block" });
        $("#update_profile").hide(); // Hide the update_pass element
    } else if (this.id === "update_pass") {
        $("#update_password").show();
        $("#update_pass").hide(); // Hide the update_profile element
        $("#updateForm").hide();
        $("#update_profile").show();
    }
});

// UPDATE PROFILE
$(document).on("submit", "#updateForm", function (e) {
    e.preventDefault();

    // Get form data
    var formData = new FormData(this);
    // Make AJAX request
    $.ajax({
        url: "action/action.php", // Replace with the actual PHP file to handle the update process
        type: "POST",
        dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (response) {
            // Show success or error message 
            if (response.res == 'success') {
                console.log(response);
                var updatedImageURL = `../Images/${response.updatedImageURL}`
                $(".image_profile img").attr("src", updatedImageURL);
            }
        },
    });
});

//   UPDATE PASSWORD
$(document).on("submit", "#update_password", function (e) {
    e.preventDefault();

    var password = $('#password').val();
    var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+\-]).{6,16}$/;
    var isValid = pattern.test(password)
    // Get form data
    // Make AJAX request
    if(isValid){
        $.ajax({
        url: "action/action.php", // Replace with the actual PHP file to handle the update process
        type: "POST",
        dataType: 'JSON',
        data: $(this).serialize(),
        success: function (response) {
            // Show success or error message
            // console.log(response);
            window.location.href = ".";
        },
    });
    }else{
        $('#error_alert').html(`<div  class="alert alert-danger" role="alert">Please follow the required input. </div>`)
    }
    
});

$(document).on("click", "#hide_password", function () {
    const password_type = $("#password");
    $("#hide_password").toggleClass("active");
    $("#hide_password").hasClass("active") &&
        password_type.attr("type") === "password"
        ? ($("#hide_password").html(
            '<i class="fa-sharp fa-light fa fa-eye-slash"></i>'
        ),
            password_type.attr("type", "text"))
        : ($("#hide_password").html('<i class="fa-thin fa fa-eye hide"></i>'),
            password_type.attr("type", "password"));
});

$(document).on("click", "#hide_cpassword", function () {
    const cpassword_type = $("#confirmpassword");
    $("#hide_cpassword").toggleClass("active");
    $("#hide_cpassword").hasClass("active") &&
        cpassword_type.attr("type") === "password"
        ? ($("#hide_cpassword").html(
            '<i class="fa-sharp fa-light fa fa-eye-slash"></i>'
        ),
            cpassword_type.attr("type", "text"))
        : ($("#hide_cpassword").html('<i class="fa-thin fa fa-eye hide"></i>'),
            password_type.attr("type", "password"));
});

// DELETE YOUR MESSAGE 

$(document).on("click",".delete_message", function(event) {
    // Start a timer when mouse button is pressed down
    var messageId = $(this).data("id");
    var divId = 'messages'
      $.ajax({
        url: 'action/action.php',
        method: 'POST',
        // dataType: 'JSON',
        cache : false,
        data: { message_id: messageId },
        success: function(response) {
            // $('.messageContainer[data-id="' + messageId + '"]').parent().remove();
            $('#' + divId).load(location.href + ' #' + divId + ' > *');
        },
        error: function() {
          // Handle the error response (if any)
        //   alert('An error occurred while deleting the message.');
        console.log('An error occurred while deleting the message.')
        }
      });
  });
