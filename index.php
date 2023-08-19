

<!DOCTYPE html>
<html lang="en">

<?php include('Include/head.php'); ?>

<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-3" style="width: 28rem;">
            <div class="d-flex justify-content-center pt-4">
                <h3>Just Chat App</h3>
            </div>

            <div id="error_alert">
                
            </div>

            <div class="card-body">
                <form id="log_in_form" action="" method="POST" autocomplete="off">

                    <div class="col mb-1">
                        <label for="username" class="col-sm-12 col-form-label">Username</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="username" name="username" required>
                        </div>
                    </div>

                    <div class="col mb-1">
                        <label for="password" class="col-sm-12 col-form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" id="password" class="form-control" name="password" required>
                            <span class="input-group-text hide" id="hide_password"><i class="fa-thin fa fa-eye hide"></i></span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                    <div class="mt-4">
                        <p>Create Account <a href="Register/register.php">here</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
    <script src="Js/script.js"></script> 
    <script src="Log_In/js/function.js"></script>
</body>

</html>