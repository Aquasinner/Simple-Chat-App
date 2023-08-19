<?php
include('../Config/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat_App</title>

    <link rel="stylesheet" href="../CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/fontawesome.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script>


</head>

<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <div class="card p-3" style="width: 28rem;">
            <div class="d-flex justify-content-center">
                <h3>Just Chat App</h3>
            </div>
            <div id="error_alert">
                
            </div>
            <div class="card-body">
                <form id="register_form" action="" method="POST" enctype="multipart/form-data">
                    <div class="col mb-1 d-flex row">
                        <div class="col-sm-6">
                            <label for="first_name" class="col-sm-12 col-form-label">First Name</label>
                            <div class="col-sm-12">
                                <input type="text" name="first_name" class="form-control form-control-sm" id="first_name" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="last_name" class="col-sm-12 col-form-label">Last Name</label>
                            <div class="col-sm-12">
                                <input type="text" name="last_name" class="form-control form-control-sm" id="last_name" required>
                            </div>
                        </div>

                    </div>

                    <div class="col mb-1">
                        <label for="email" class="col-sm-12 col-form-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" name="email" class="form-control form-control-sm" id="email" required>
                        </div>
                    </div>
                    <div class="col mb-1">
                        <label for="password" class="col-sm-12 col-form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control form-control-sm" title="Password should contains atleast lowercase character, uppercase, number and special character. Password should be 8 characters or 16 characters. " required>
                            <span class="input-group-text hide" id="hide_password"><i class="fa-thin fa fa-eye hide"></i></span>
                        </div>
                        <div id="required"></div>
                    </div>

                    <div class="col mb-1">
                        <label for="confirmpassword" class="col-sm-12 col-form-label">Confirm Password</label>
                        <div class="input-group mb-3">
                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control form-control-sm" required>
                            <span class="input-group-text hide" id="hide_cpassword"><i class="fa-thin fa fa-eye hide"></i></span>
                        </div>
                    </div>

                    <div class="col mb-1">
                        <label for="avatar" class="col-sm-12 col-form-label">Select Image</label>
                        <div class="col-sm-12">
                            <input type="file" name="user_img" class="form-control form-control-sm" id="avatar" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" name="submit">Sign in</button>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        <p>Already have an account? Log in <a href="../">here</a> </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="../Js/script.js"></script>
    <script src="js/function.js"></script>
</body>

</html>