<?php
include('../Config/config.php');
include('./data/data_model.php');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}

if (isset($_SESSION['deleted_conversation_id'])) {
    # code...
    header('location: .');
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
$uploaded_images = $user->uploadedImg($conn, $chatid);

?>
<!DOCTYPE html>
<html lang="en">

<?php include('Include/head.php'); ?>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-3" style="width: 24rem; height: 30rem">
            <section class="user">
                <header class="d-flex justify-content-between align-items-center">
                    <div class="content column-gap-2 d-flex justify-content-between align-items-center">
                        <a href="convo.php?user=<?php echo $userid; ?>&chat_id=<?php echo urlencode($chatid); ?>"><i class="fa-light fa fa-arrow-left"></i></a>
                        <img class="profile_img" src="..\Images\<?php echo $user_reciever['img']; ?>" alt="profile_logo" width="35" height="35">
                        <div class="chat_details">
                            <span><?php echo $user_reciever['name'] ?></span>
                        </div>
                    </div>
                </header>
            </section>


            <div class="card-body chat_box">
                <div class="d-flex flex-column gap-2">
                <a href="message.php?user=<?php echo $userid; ?>&chat_id=<?php echo urlencode($chatid); ?>"><button type="button" class="btn btn-primary btn-sm delete_convo">My Messages</button></a>
                <button type="button" class="btn btn-primary btn-sm delete_convo" id="delete_convo" data-id="<?php echo $chatid ?>">Delete Conversation</button>
                </div>

                <div>
                    <h3>Images</h3>
                    <div class="images">
                        <div class="row">
                            <?php foreach ($uploaded_images as $image) : ?>
                                <div class="col-md-4">
                                    <img src="image_upload/<?php echo $image['chat_message'] ?>" alt="Image" class="img-fluid">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="js/function.js"></script>
    
</body>

</html>