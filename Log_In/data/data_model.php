<?php

// WE CAN CALL THIS VARIABLE BY INCLUDING THIS PAGE TO THE OTHER PAGE
$user = new User();


class User
{
    // VERIFY USER PASSWORD AND USERNAME TO LOG IN
    function verifyUser($conn, $username, $password)
    {
        try {
            $data = [
                'uname' => $username,
                'pword' => sha1($password),
            ];
    
            $query = "SELECT * FROM `user_account` WHERE `username` = :uname AND `password` = :pword";
            $stmt = $conn->prepare($query);
            $stmt->execute($data);
            
            if ($stmt->rowCount() > 0) {
                // $res = ['found' => 'found'];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['id'] = $row['id'];
    
                    $data2 = ['user_id' => $_SESSION['user_id']];
                    $query2 = "UPDATE `users` SET `is_online` = 1 WHERE `id` = :user_id";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->execute($data2);

                    $res = ['res' => 'success'];;
                }
            } else {
                $res = ['res' => 'invalid', 'invalid' => 'Username and password do not match. Please try again'];
            }
        } catch (\Throwable $th) {
            $res = ['error' => 'error'];
        }
        return $res;
    }
    
    
}
