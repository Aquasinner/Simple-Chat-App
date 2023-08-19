<?php
include('../Config/config.php');
include('./data/data_model.php');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}

$senderId = $_SESSION['user_id'];

// $user_data = $user->userData($conn, $_SESSION['user_id']);
$fetch_reciever = $user->allChatReciever($conn, $senderId);

?>

<div class="card-body user_list z-index-n1">
    <?php
    // Sort the receiver details array based on timestamp in descending order
    usort($fetch_reciever, function ($a, $b) {
        return strtotime($b['timestamp']) - strtotime($a['timestamp']);
    });

    foreach ($fetch_reciever as $row) :
        // Check if the last message is from the sender or receiver
        $unread_message = $user->unreadMessages($conn, $row['id']);
        $last_message = '';
        $msg_type = '';
        if (!empty($row['last_message'])) {
            $last_message = $row['last_message'];
            $msg_type = $row['msg_type']; // Fetch the message type
        }

    ?>
        <a href="convo.php?user=<?php echo urlencode($row['id']) ?>&chat_id=<?php echo urlencode($row['chat_id']) ?> " class="d-flex justify-content-between align-items-center">
            <div class="user_details d-flex column-gap-2 justify-content-between align-items-center">
                <div class="avatar" style="position: relative;">
                    <img class="profile_img" src="..\Images\<?php echo $row['profile_img']; ?>" alt="profile_logo" width="45" height="45">

                    <?php if ($unread_message != 0) : ?>
                        <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;top: 10%">
                            <?php echo $unread_message ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    <?php endif; ?>
                </div>

                <div>
                    <span class="name"><?php echo $row['user_name']; ?></span>
                    <?php if (!empty($last_message)) : ?>
                        <?php if ($msg_type == 'image') : ?>
                            <p>Received: Photo</p>
                        <?php else : ?>
                            <p class="message" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; width: 200px;"><?php echo $last_message; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($row['isOnline'] == 0) : ?>
                <div class="status_dot offline"><i class="fa-light fa fa-circle-dot"></i></div>
            <?php else : ?>
                <div class="status_dot online"><i class="fa-light fa fa-circle-dot"></i></div>
            <?php endif; ?>
        </a>
    <?php endforeach ?>
</div>
</div>