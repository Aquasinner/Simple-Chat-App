<?php 
    include('../../Config/config.php');
    include('../data/data_model.php');


    extract($_POST);

    // SEARCH USER
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        if(empty($searchTerm)){
            $res = ['res' => 'empty'];
        }else{
            $res = $user->searchUser($conn, $searchTerm);
        }
        
        echo json_encode($res);
    }
 
    // SEND MESSAGE TO USER
    if (isset($message) &&  isset($recieverId)) {
        # code...
        $msg = $message;
        $rId = $recieverId;
        $sender = $_SESSION['user_id'];
        $res = $user->chatUser($conn,$message, $recieverId, $sender);

        echo json_encode($res);
    }

    if (isset($_FILES['file']) &&  isset($recieverId)) {
        # code...
        $rId = $recieverId;
        $sender = $_SESSION['user_id'];
        $res = $user->chatUserFile($conn, $recieverId, $sender);
// $res =  $recieverId;
        echo json_encode($res);
    }

    // SET CHAT ONCE THE SENDER CLICK THE RECIEVER PROFILE

    if(isset($id)){
        $reciever = $id;
        $sender = $_SESSION['user_id'];

        // $res = $user->setUserChat($conn,$reciever,$sender);
        $res = $user->setChat($conn, $reciever, $sender);

        echo json_encode($res);
    }

// DELETE CONVO
    if(isset($chat_id)){
        $id = $chat_id;

        $res= $user->deleteConvo($conn,$id);

        echo json_encode($res);
    }

// UPDATE PROFILE
    if(isset($userid)){
        $userid = $userid;

        $res= $user->updateProfile($conn,$userid,$firstname,$lastname);

        echo json_encode($res);
    }

    if(isset($updatepass)){
        $userid = $updatepass;

        $res= $user->updatePassword($conn,$userid,$password);

        echo json_encode($res);
    }

// DELETE YOUR MESSAGE

if(isset($message_id)){
    $messageid = $message_id;

    $res = $user->deleteMessage($conn, $messageid);

    echo json_encode($res);
}
?>