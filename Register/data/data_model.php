<?php
$register_user = new Register_user();


class Register_user
{

    function registerUser($conn, $first_name, $last_name, $email, $password)
    {
        try {
            $file_name = $_FILES['user_img']['name'];
            $temp_name = $_FILES['user_img']['tmp_name'];
            $string = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()-";
            $rand_id = substr(str_shuffle($string), 0, 8);

            $data = [
                'user_id' => $rand_id,
                'fname' => $first_name,
                'lname' => $last_name,
                'email' => $email,
                'pword' => sha1($password),
                'profile_img' => $file_name
            ];

            $upload_dir = '../../Images';

            if (move_uploaded_file($temp_name, $upload_dir . '/' . $file_name)) {
                # code...

                $query = "SELECT * FROM `users` WHERE `email`= '$email'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $res = ['exist' => 'exist', 'existed' => 'Email already exist, please try another one. Thank you'];
                } else {
                    $query = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `profile_img`) VALUES (:user_id, :fname, :lname, :email, :pword, :profile_img)";
                    $stmt = $conn->prepare($query);
                    $result = $stmt->execute($data);
                    if ($result) {
                        # code...
                        $acc_query = "INSERT INTO `user_account` (`user_id`,`username`,`password`) VALUES ('$rand_id', :email, :pword)";
                        $stmt = $conn->prepare($acc_query);
                        $acc_result = $stmt->execute([
                            'email' => $email,
                            'pword' => sha1($password),
                        ]);
                        if ($acc_result) {
                            # code...
                            $res = ['res' => 'success'];
                        } else {
                            $res = ['error' => 'error'];
                        }
                    } else {
                        $res = ['error' => 'error'];
                    }
                }
            } else {
                $res = ['error' => 'error'];
            }
            // return $data;
        } catch (\Throwable $th) {
            //throw $th;
            $res = ['error' => 'error'];
        }
        return $res;
    }
}
