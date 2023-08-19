<?php
include('../Config/config.php');
include('./data/data_model.php');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}
// ID OF RECIVER AND SENDER
$userid = $_GET['userid'];


// SENDING AND RECIEVING DATA TO THE CLASS METHOD
$user_reciever = $user->chatReciever($conn, $userid);
$user_sender = $user->chatSender($conn, $userid);


?>
<!DOCTYPE html>
<html lang="en">

<?php include('Include/head.php'); ?>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-3" style="width: 24rem; position: relative">
            <section class="user">
                <header class="d-flex justify-content-between align-items-center">
                    <div class="content column-gap-2 d-flex justify-content-between align-items-center">
                        <a href="."><i class="fa-light fa fa-arrow-left"></i></a>
                    </div>
                </header>
            </section>


            <div class="card-body update_box" style="position: relative">
                <div class="mb-2 center">
                    <div class="image_profile mb-2">
                        <img src="..\Images\<?php echo $user_sender['res']; ?>" alt="" width='100' height='100' style="margin: auto;border-radius: 50%">
                    </div>
                    <h4><?php echo $user_sender['name'].' '. $user_sender['lastname']?></h4>
                </div>
                <div class="mb-3">
                <button type="button" class="btn btn-primary btn-sm update_profile" id="update_profile" >Update Profile</button>
                <button type="button" class="btn btn-primary btn-sm update_profile" id="update_pass" >Update Password</button>
                </div>
                
                <div id="error_alert"></div>
                <form id="updateForm" style="display: none; position: relative">
                    <div class="mb-3">
                        <input type="text" name="firstname" class="form-control" value="<?php echo $user_sender['name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="lastname" class="form-control" value="<?php echo $user_sender['lastname']?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="photo" class="form-control" required>
                    </div>
                    <input type="hidden" name="userid" value="<?php echo $userid ?>" class="form-control" required>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

                <form id="update_password" action="" method="POST"  style="display: none; position: relative" >
                    <div class="col mb-1">
                    <span class="required_input">Password should contains atleast lowercase character, uppercase, number and special character.</span>
                        <span class="required_input">Password should be 8 characters or 16 characters.</span>
                        <div class="input-group mb-3">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                            <span class="input-group-text hide" id="hide_password"><i class="fa-thin fa fa-eye hide"></i></span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <input type="hidden" name="updatepass" value="<?php echo $userid ?>">
                        <button type="submit" class="btn btn-primary" id="updatepass">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/function.js"></script>
</body>

</html>