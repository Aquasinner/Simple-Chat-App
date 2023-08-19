<?php 
    include('../Config/config.php');
    include('./data/data_model.php');
    
    // Return a JSON response to indicate the successful logout
    // $res = ['status' => 'success'];
    $res = $user->logOut($conn); // Call the logOut() function passing the $conn object
    echo json_encode($res);
    exit();
?>