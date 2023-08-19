$(document).on("submit", "#log_in_form", function (e) {
  e.preventDefault();

  // var form = new FormData(this);
  // console.log(form)
  if (!navigator.onLine) {
    $("#error_alert").html(
            `<div  class="alert alert-danger" role="alert">No internet connection. Please check your connection and try again.</div>`
          );
  }

  try {
    $.ajax({
      url: "http://chat-app.42web.io/Log_In/action/action.php",
      type: "post",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function (data) {
        // console.log(data)
        if (data.res == "invalid") {
          $("#error_alert").html(
            `<div  class="alert alert-danger" role="alert">${data.invalid}.</div>`
          );
        } else if (data.res == "empty") {
          $("#error_alert").html(
            `<div  class="alert alert-danger" role="alert">${data.empty}.</div>`
          );
        } else if (data.res == "success") {
          window.location.href = "User";
          $("#log_in_form")[0].reset();
        }
      },
    });
  } catch (error) {
    console.error("An error occurred:", error);
  }
});
