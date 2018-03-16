<?php
    include_once('includes/config.php');
    include_once('includes/session.php');

    $response = array();

    if(isset($_POST['first_name'], $_POST['last_name'], $_POST['email_address'], 
    $_POST['password'], $_POST['handphone_number'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $handphone_number = $_POST['handphone_number'];

        if(registerCustomer($first_name, $last_name, $email_address, $password, $handphone_number)){
            $response["success"] = 1;
            $response["message"] = "Account successfully created!";

            echo json_encode($response);
        }
        else{
            $response["success"] = 0;
            $response["message"] = "There's already an account with the same email!";

            echo json_encode($response);
        }
    }
    else if(isset($_POST['merchant_name'], $_POST['email_address'], $_POST['password'], 
        $_POST['address'], $_POST['handphone_number'])){
        $first_name = $_POST['merchant_name'];
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $address = $_POST['address'];
        $handphone_number = $_POST['handphone_number'];

        if(registerMerchant($first_name, $email_address, $password, $address, $handphone_number)){
            $response["success"] = 1;
            $response["message"] = "Account successfully created!";

            echo json_encode($response);
        }
        else{
            $response["success"] = 0;
            $response["message"] = "There's already an account with the same email!";

            echo json_encode($response);
        }
    }
    else{
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing.";

        echo json_encode($response);
    }
?>  