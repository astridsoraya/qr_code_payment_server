<?php
    include_once('includes/wallet_management.php');

    $response = array();

    if(isset($_POST['pin'], $_POST['email_address'], $_POST['user_type'])){
        $pin = $_POST['pin'];
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);
        $user_type = $_POST['user_type'];

        if(createWallet($pin, $email_address, $user_type)){
            $response['success'] = 1;
            $response['message'] = 'Successfully created wallet';

            echo json_encode($response);
        }
        else{
            $response['success'] = 0;
            $response['message'] = 'Failed to create wallet';

            echo json_encode($response);
        }
    }
    else{
        $response['success'] = 0;
        $response['message'] = 'Missing fields';

        echo json_encode($response);
    }
?>