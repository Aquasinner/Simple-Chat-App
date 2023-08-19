<?php 
    include('../../Config/config.php');
    include('../data/data_model.php');

    extract($_POST);

    if (isset($email)) {
        $email = $email;
        # code...
        foreach ($_POST as $value) {
            # code...
            if (empty($value)) {
                # code...
                $res = ['res' => 'empty_fname', 'empty_fname' => 'Please fill up all the fields.'];
                break;
            }else{
                $res = $register_user->registerUser($conn,$first_name,$last_name,$email,$password);
                break;
            }
        }
        // $res = $email;
    }

    echo json_encode($res);
?>