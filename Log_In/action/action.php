<?php 
    include('../../Config/config.php');
    include('../data/data_model.php');

    extract($_POST);

    if (isset($username)) {
        # code...
        $username = $username;
        foreach ($_POST as $value) {
            # code...
            if (empty($value)) {
                # code...
                $res = ['res' => 'empty', 'empty' => 'Please fill up all the fields.'];
                break;
            }else{
                $res = $user->verifyUser($conn, $username, $password);
                break;
            }
        }     
    }

    echo json_encode($res);
?>