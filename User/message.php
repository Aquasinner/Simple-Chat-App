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
$user_chat = $user->chatConvo($conn, $chatid, $senderId);

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
            <h3>Sended Messages</h3>
                <div>   
                    <div class="mt-4" id="messages">
                        <div class="row">
                            <?php foreach ($user_chat as $message) : ?>
                            <?php if($senderId == $message['sender_Id']): ?>
                                <div class="d-flex justify-content-between align-items-center mb-1" >
                                    <div class="d-flex gap-1">
                                        <?php if ($message['message_type'] == 'text') { ?>
                                        <p><?php echo $message['chat_message'] ?></p>
                                        <?php } elseif ($message['message_type'] == 'image') { ?>
                                        <img src="image_upload/<?php echo $message['chat_message'] ?>" width='200'>
                                        <?php } ?>-
                                        <p class="text-center"><?php echo date('D \a\t g:i A Y', strtotime($message['date'])); ?></p>
                                    </div>
                                    <button class="delete_message" name="delete_message" data-id="<?php echo $message['id'] ?>" style="padding: .1rem .25rem;
border-radius: .5rem;color: #ffffff;background-color: #000000;">
                                      Delete
                                    </button>
                                </div>
                                <hr/>
                            <?php endif; ?>
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