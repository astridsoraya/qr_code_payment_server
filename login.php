<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/model/user.php');
    include_once('includes/model/customer.php');
    include_once('includes/model/merchant.php');

    $response = array();

    if(isset($_POST['email_address'], $_POST['password'])){
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $userByEmail = loginByEmail($email_address, $password);
        $userByUsername = loginByEmail($email_address, $password);

        if ($userByEmail != null) {
            // Login success
            $response["success"] = 1;
            $response["message"] = "Successfully logged in!";

            $response["username"] = $userByEmail->getUsername();
            $response["email_address"] = $userByEmail->getEmailAddress();
            $response["handphone_number"] = $userByEmail->getHandphoneNumber();
            $response["user_type"] = get_class($userByEmail);

            if(get_class($userByEmail) == "Customer"){
                $response["id_customer"] = $userByEmail->getIdUser();
                $response["first_name"] = $userByEmail->getFirstName();
                $response["last_name"] = $userByEmail->getLastName();
            }
            
            else if(get_class($userByEmail) == "Merchant"){
                $response["id_merchant"] = $userByEmail->getIdUser();
                $response["merchant_name"] = $userByEmail->getMerchantName();
                $response["address"] = $userByEmail->getAddress();
            }
            echo json_encode($response);
        }
        else if($userByUsername != null) {
            // Login success
            $response["success"] = 1;
            $response["message"] = "Successfully logged in!";

            $response["username"] = $userByUsername->getUsername();
            $response["email_address"] = $userByUsername->getEmailAddress();
            $response["handphone_number"] = $userByUsername->getHandphoneNumber();
            $response["user_type"] = get_class($userByUsername);

            if(get_class($userByUsername) == "Customer"){
                $response["id_customer"] = $userByUsername->getIdUser();
                $response["first_name"] = $userByUsername->getFirstName();
                $response["last_name"] = $userByUsername->getLastName();
            }
            
            else if(get_class($userByUsername) == "Merchant"){
                $response["id_merchant"] = $userByUsername->getIdUser();
                $response["merchant_name"] = $userByUsername->getMerchantName();
                $response["address"] = $userByUsername->getAddress();
            }
            echo json_encode($response);
        }
        else {
            $response["success"] = 0;
            $response["message"] = "Wrong e-mail address or password";
            echo json_encode($response);
        }

    }
?>