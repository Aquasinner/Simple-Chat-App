<?php
$user = new User();

if(isset($_GET['q'])){
    $q = $_GET['q'];
    $user->deleteMessage();
}
class User
{

    function userData($conn, $userid)
    {
        try {
            //code...
            $data = ['userid' => $userid];

            $query = "SELECT * FROM `users` WHERE `id` = :userid";
            $stmt = $conn->prepare($query);

            $r = $stmt->execute($data);

            if ($r) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    # code...
                    return $row;
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // SEARCHER USER
    function searchUser($conn, $search)
    {
        $data = ['search' => '%' . $search . '%'];
        $res = [];
        try {
            $query = "SELECT * FROM users WHERE first_name like :search or last_name like :search";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Generate HTML for the search results
            if ($results) {
                foreach ($results as $result) {
                    $res[] =  ['res' => 'found', 'name' => $result['first_name'] . ' ' . $result['last_name'], 'img' => $result['profile_img'], 'userid' => $result['id']];
                }
            } else {
                $res = ['res' => 'notfound', 'result' => 'No result'];
            }

            return $res;
        } catch (PDOException $e) {
            return 'Error executing query: ' . $e->getMessage();
        }
    }


    // SET CHAT
    function setChat($conn, $recieverId, $senderId)
    {
        $string = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()-";
        $rand_chatid = substr(str_shuffle($string), 0, 8);

        $data = ['chatId' => $rand_chatid, 'recieverId' => $recieverId, 'senderId' => $senderId];

        try {
            $query = "SELECT * FROM `chat` WHERE (`usersender_id` = :senderId AND `userreciever_id` = :recieverId) OR (`usersender_id` = :recieverId AND `userreciever_id` = :senderId)";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);

            if ($stmt->rowCount() == 0) {
                $query = "INSERT INTO `chat` (`chat_id`, `usersender_id`,`userreciever_id`) VALUES (:chatId, :senderId, :recieverId )";
                $stmt = $conn->prepare($query);
                $exec = $stmt->execute($data);

                if ($exec) {
                    $res = ['res' => 'success', 'chat_id' => $data['chatId']];
                } else {
                    $res = ['res' => 'error'];
                }
            } else {
                while ($row = $stmt->fetch()) {
                    $res = ['res' => 'exist', 'chat_id' => $row['chat_id']];
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            $res = ['res' => $th];
        }
        return $res;
    }


    // USER CHAT RECIEVER

    function chatReciever($conn, $userid)
    {
        $data = ['userid' => $userid];

        try {
            $query = "SELECT * FROM `users` WHERE `id` = :userid";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            while ($row = $stmt->fetch()) {
                # code...
                $recieverdata = ['name' => $row['first_name'] . ' ' . $row['last_name'], 'img' => $row['profile_img']];        
            }
            return $recieverdata;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    // CHAT SENDER
    function chatSender($conn, $senderId)
    {

        $data = ['userid' => $senderId];

        try {
            $query = "SELECT * FROM `users` WHERE `id` = :userid";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            while ($row = $stmt->fetch()) {
                # code...
                $res = ['res' => $row['profile_img'], 'name' => $row['first_name'], 'lastname' => $row['last_name'],];
                return $res;
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }


    // SEND MESSAGE TO USER
    function chatUser($conn, $message, $recieverId, $senderId)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['recieverId' => $recieverId, 'senderId' => $senderId];
        $msg_type = 'text';
        try {

            $query = "SELECT * FROM `chat` WHERE (`usersender_id` = :senderId AND `userreciever_id` = :recieverId) OR (`usersender_id` = :recieverId AND `userreciever_id` = :senderId)";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            while ($row = $stmt->fetch()) {
                # code...
                $chatId = $row['chat_id'];
                $chatStatus = 1;
                $date = date('Y-m-d H:i:s', time());
                $data2 = ['msg' => $message, 'msg_type' => $msg_type, 'chat_id' => $chatId, 'recieverId' => $recieverId, 'senderId' => $senderId, 'chat_status' => $chatStatus, 'date' => $date];

                $sendQuery = "INSERT INTO `user_chat` (`chat_id`, `chat_message`, `message_type`, `sender_id`, `reciever_id`, `chat_status`, `date`) VALUES ( :chat_id, :msg, :msg_type, :senderId, :recieverId, :chat_status, :date)";
                $stmt = $conn->prepare($sendQuery);
                $stmt->execute($data2);

                $res = ['res' => 'success'];
                return $res;
            }
        } catch (\Throwable $th) {
            $res = ['res' => $th];
        }
    }

    // SEND IMAGE
    function chatUserFile($conn, $recieverId, $senderId)
    {
        date_default_timezone_set('Asia/Manila');
        $file_name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        $msg_type = 'image';
        $data = ['file' => $file_name, 'recieverId' => $recieverId, 'senderId' => $senderId];

        try {

            $upload_dir = '../image_upload';

            if (move_uploaded_file($temp_name, $upload_dir . '/' . $file_name)) {
                $query = "SELECT * FROM `chat` WHERE (`usersender_id` = :senderId AND `userreciever_id` = :recieverId) OR (`usersender_id` = :recieverId AND `userreciever_id` = :senderId)";
                $stmt = $conn->prepare($query);
                $stmt->execute($data);
                while ($row = $stmt->fetch()) {
                    # code...
                    $chatId = $row['chat_id'];
                    $date = date('Y-m-d H:i:s', time());
                    $data = ['msg' => $file_name, 'msg_type' => $msg_type, 'chat_id' => $chatId, 'recieverId' => $recieverId, 'senderId' => $senderId, 'date' => $date];

                    $sendQuery = "INSERT INTO `user_chat` (`chat_id`, `chat_message`,`message_type`,`sender_id`,`reciever_id`, `date`) VALUES ( :chat_id, :msg, :msg_type, :senderId, :recieverId, :date)";
                    $stmt = $conn->prepare($sendQuery);
                    $stmt->execute($data);

                    $res = ['res' => 'success'];
                    return $res;
                }
            }
        } catch (\Throwable $th) {
            $res = ['res' => $th];
            return $res;
        }
    }


    // FETCHING THE CONVERSATION
    function chatConvo($conn, $chatid, $senderId)
    {
        $data = ['chat_id' => $chatid];

        try {
            $query = "SELECT * FROM `user_chat` WHERE `chat_id` = :chat_id";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            $row = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                if ($row[0]['sender_Id'] == $senderId) {
                    # code...
                    // Update chat_status to 0 for the sender's messages
                    $updateData = ['chat_id' => $chatid, 'senderId' => $senderId];
                    $updateQuery = "UPDATE `user_chat` SET `chat_status` = 0 WHERE `chat_id` = :chat_id AND `reciever_Id` = :senderId";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->execute($updateData);
                } else if ($row[0]['reciever_Id'] == $senderId) {
                    $updateData = ['chat_id' => $chatid, 'senderId' => $senderId];
                    $updateQuery = "UPDATE `user_chat` SET `chat_status` = 0 WHERE `chat_id` = :chat_id AND `reciever_Id` = :senderId";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->execute($updateData);
                }
            }
            return $row;
        } catch (\Throwable $th) {
            return $th;
        }
    }


    // COUNT UNREAD MESSAGES
    function unreadMessages($conn, $recieverId)
    {
        $data = ['recieverId' => $recieverId];

        try {
            $query = "SELECT COUNT(*) AS unreadCount FROM `user_chat` WHERE `sender_Id` = :recieverId AND `chat_status` = 1";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);

            $result = $stmt->fetch();
            $unreadCount = $result['unreadCount'];

            return $unreadCount;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    // IMAGE SENDED
    function uploadedImg($conn, $chatid)
    {
        $messageType = 'image';
        $data = ['chat_id' => $chatid, 'message_type' => $messageType];

        try {
            $query = "SELECT * FROM `user_chat` WHERE `chat_id` = :chat_id AND `message_type` = :message_type";
            $stmt = $conn->prepare($query);

            $stmt->execute($data);
            $rows = $stmt->fetchAll();
            return $rows;
        } catch (\Throwable $th) {
            // Handle any errors or exceptions
        }
    }

    // DELETE YOUR MESSAGE

    function deleteMessage($conn, $messageid){
        $data = ['messageid' => $messageid];

        try{
            $query = "DELETE FROM `user_chat` WHERE `id` = :messageid";
            $stmt = $conn->prepare($query);
            $exec = $stmt->execute($data);

            if($exec){
                $res = ['res' => 'Deleted successfully'];
            }
        }catch(\Throwable $th){
            $res = $th->getMessage();
        }
        return $res;
    }


    // FETCH ALL THE RECIEVER OF THE CHAT WHO HAVE CONVERSATION WITH THE SENDER
    function allChatReciever($conn, $senderId)
    {
        $data = ['senderId' => $senderId];
        try {
            $query = "SELECT chat_id, sender_Id, reciever_Id, chat_message, message_type, date 
                  FROM user_chat 
                  WHERE sender_Id = :senderId OR reciever_Id = :senderId 
                  ORDER BY date DESC";

            $stmt = $conn->prepare($query);

            $stmt->execute($data);
            $rows = $stmt->fetchAll();

            $lastMessages = [];
            foreach ($rows as $row) {
                $chatId = $row['chat_id'];
                $chatMessage = $row['chat_message'];
                $messageType = $row['message_type'];
                $timestamp = $row['date'];

                // Determine the other user ID (either sender or receiver)
                $otherUserId = $row['sender_Id'] != $senderId ? $row['sender_Id'] : $row['reciever_Id'];

                // Check if otherUserId exists in the $lastMessages array
                if (!isset($lastMessages[$otherUserId])) {
                    // If not, assign the message and timestamp
                    $lastMessages[$otherUserId] = [
                        'chatId' => $chatId,
                        'chatMessage' => $chatMessage,
                        'messageType' => $messageType,
                        'timestamp' => $timestamp,
                    ];
                }
            }

            // Fetch the receiver details using the otherUserId as receiverId
            $receiverDetails = [];
            foreach ($lastMessages as $receiverId => $lastMessageData) {
                $data = ['receiverId' => $receiverId];

                $query = "SELECT * FROM `users` WHERE `id` = :receiverId";
                $stmt = $conn->prepare($query);
                $stmt->execute($data);

                $receiver = $stmt->fetch();
                if ($receiver) {
                    $receiverDetails[] = [
                        'id' => $receiver['id'],
                        'profile_img' => $receiver['profile_img'],
                        'user_name' => $receiver['first_name'] . ' ' . $receiver['last_name'],
                        'isOnline' => $receiver['is_online'],
                        'chat_id' => $lastMessageData['chatId'],
                        'msg_type' => $lastMessageData['messageType'],
                        'last_message' => $lastMessageData['chatMessage'], // Assign the last message for the receiver
                        'timestamp' => date('D \a\t g:i A', strtotime($lastMessageData['timestamp'])), // Convert the timestamp to a formatted date
                    ];
                }
            }

            return $receiverDetails;
        } catch (\Throwable $th) {
            // Handle the error gracefully
            // You can log the error or return an error message
            return [];
        }
    }



    // DELETE CONVO
    function deleteConvo($conn, $id)
    {
        $data = ['chatid' => $id];
        try {
            $query = "DELETE FROM `user_chat` WHERE chat_id = :chatid";
            $stmt = $conn->prepare($query);
            $exec = $stmt->execute($data);

            if ($exec) {
                $res = ['res' => 'success'];
                $_SESSION['deleted_conversation_id'] = $id;
            } else {
                $res = ['res' => 'error'];
            }
        } catch (\Throwable $th) {
            //throw $th;
            $res = ['res' => $th];
        }
        return $res;
    }

// LOG OUT
    function logOut($conn)
    {
        // Set is_online to 0 (offline)
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $data = ['user_id' => $userId];
            $query = "UPDATE `users` SET is_online = 0 WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
        }

        // Clear the session variables and destroy the session
        $_SESSION = array();
        session_destroy();
    }

    // UPDATE PASSWORD
    function updatePassword($conn, $userid, $password)
    {
        
        try {
            $data = ['userid' => $userid, 'pass' => sha1($password),];

            $query = "UPDATE `users` SET `password`=:pass  WHERE id=:userid";
            $stmt = $conn->prepare($query);

            $result = $stmt->execute($data);
            if ($result) {
                $query = "UPDATE `user_account` SET `password`=:pass  WHERE `user_id`=:userid";
                $stmt = $conn->prepare($query);
                $result = $stmt->execute($data);
                $res = ['res' => 'success'];

                session_destroy();
            } else {
                $res = ['res' => 'error'];
            }
        } catch (\Throwable $th) {
            $res = ['res' => $th];
        }

        return $res;
    }



    // UPDATE PROFILE
    function updateProfile($conn, $userid, $firstname, $lastname)
    {
        try {
            $file_name = $_FILES['photo']['name'];
            $temp_name = $_FILES['photo']['tmp_name'];
            $data = ['userid' => $userid, 'fname' => $firstname, 'lname' => $lastname, 'file_name' => $file_name];

            $upload_dir = '../../Images';
    
            if (move_uploaded_file($temp_name, $upload_dir . '/' . $file_name)) {
                $query = "UPDATE `users` SET `first_name`=:fname, `last_name`=:lname, `profile_img`=:file_name WHERE `id` = :userid";
                $stmt = $conn->prepare($query);

                $result = $stmt->execute($data);
                if ($result) {
                    $res = ['res' => 'success', 'updatedImageURL' => $file_name ];
                } else {
                    $res = ['res' => 'error'];
                }
            } else {
                $res = ['res' => 'error'];
            }
        } catch (\Throwable $th) {
            $res = ['res' => $th];
        }
        return $res;
    }
}
