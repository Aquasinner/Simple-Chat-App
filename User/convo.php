<?php
include('../Config/config.php');
include('./data/data_model.php');
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}
// ID OF RECIVER AND SENDER
$userid = $_GET['user'];
$senderId = $_SESSION['user_id'];

// CHAT ID
$_SESSION['chat_id'] = $_GET['chat_id'];
$chatid = $_SESSION['chat_id'];


// SENDING AND RECIEVING DATA TO THE CLASS METHOD
$user_reciever = $user->chatReciever($conn, $userid);
$user_sender = $user->chatSender($conn, $senderId);
$user_chat = $user->chatConvo($conn, $chatid, $senderId);

?>
<!DOCTYPE html>
<html lang="en">

<?php include('Include/head.php'); ?>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-3" style="width: 24rem; height: 35rem">
            <section class="user">
                <header class="d-flex justify-content-between align-items-center">
                    <div class="content column-gap-2 d-flex justify-content-between align-items-center">
                        <a href="./"><i class="fa-light fa fa-arrow-left"></i></a>
                        <img class="profile_img" src="..\Images\<?php echo $user_reciever['img']; ?>" alt="profile_logo" width="35" height="35">
                        <div class="chat_details">
                            <span><?php echo $user_reciever['name'] ?></span>
                            <p>Active now</p>
                        </div>
                    </div>
                    <a href="setting.php?user=<?php echo $userid ?>&chat_id=<?php echo urlencode($chatid); ?>"><i class="fa-light fa fa-gear"></i></a>
                </header>
            </section>


            <div class="card-body chat_box">
                <div class="c">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            setInterval(function() {

                                $.ajax({
                                    url: "convo_container.php",
                                    method: "POST",
                                    data: {
                                        chat_id: "<?php echo $chatid; ?>",user : "<?php echo $userid; ?>"
                                    },
                                    success: function(response) {
                                        $(".c").html(response);
                                    }
                                });
                            }, 500);
                        });
                    </script>
                </div>
            </div>

            <form id="send_message" action="" method="POST" enctype="multipart/form-data">
                <div class="input-group mt-2 composer">

                    <div class="input-group">
                        <label for="file-input" class="file-label">
                            <i class="fa-light fa fa-image"></i>
                        </label>
                        <input id="file-input" name="file" type="file" style="display: none;">
                        <input type="text" name="message" id="message" class="form-control">
                        <input type="hidden" name="recieverId" value="<?php echo $userid; ?>">
                        <span class="input-group-text hide"><button type="submit" class="btn_send"><i class="fa-regular fa fa-paper-plane"></i></button></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/function.js"></script>
</body>

</html>