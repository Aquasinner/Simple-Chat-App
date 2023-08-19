<?php
include('../Config/config.php');
include('./data/data_model.php');
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}
// ID OF RECIVER AND SENDER
$userid = $_POST['user'];
$senderId = $_SESSION['user_id'];

// CHAT ID
$_SESSION['chat_id'] = $_POST['chat_id'];
$chatid = $_SESSION['chat_id'];


// SENDING AND RECIEVING DATA TO THE CLASS METHOD
$user_reciever = $user->chatReciever($conn, $userid);
$user_sender = $user->chatSender($conn, $senderId);
$user_chat = $user->chatConvo($conn, $chatid, $senderId);
?>


<?php if (empty($user_chat)) : ?>
<?php else : ?>
    <?php foreach ($user_chat as $row) : ?>
        <?php if ($senderId == $row['sender_Id']) { ?>
            <div class="content" >
                <p class="text-center"><?php echo date('D \a\t g:i A', strtotime($row['date'])); ?></p>
                <div class="chat outgoing d-flex align-items-end">
                    <div class="chat_details">
                        <?php if ($row['message_type'] == 'text') { ?>
                            <p><?php echo $row['chat_message'] ?></p>
                        <?php } elseif ($row['message_type'] == 'image') { ?>
                            <img src="image_upload/<?php echo $row['chat_message'] ?>" width='200'>
                        <?php } ?>
                    </div>
                    <img src="../Images/<?php echo $user_sender['res']; ?>" alt="" class="sender_img">
                </div>
            </div>
        <?php } else { ?>
            <div class="content">
                <p class="text-center"><?php echo date('D \a\t g:i A', strtotime($row['date'])); ?></p>
                <div class="chat incoming d-flex align-items-end">
                    <img src="../Images/<?php echo $user_reciever['img']; ?>" alt="" class="reciever_img">
                    <div class="chat_details">
                        <?php if ($row['message_type'] == 'text') { ?>
                            <p><?php echo $row['chat_message'] ?></p>
                        <?php } elseif ($row['message_type'] == 'image') { ?>
                            <img src="image_upload/<?php echo $row['chat_message'] ?>" width='200'>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endforeach ?>
<?php endif; ?>