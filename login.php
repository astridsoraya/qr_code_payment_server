
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
        $user = login($email_address, $password);

        if ($user != null) {
            // Login success
            $response["success"] = 1;
            $response["message"] = "Successfully logged in!";

            $response["email_address"] = $user->getEmailAddress();
            $response["handphone_number"] = $user->getHandphoneNumber();
            $response["user_type"] = get_class($user);

            if(get_class($user) == "Customer"){
                $response["id_customer"] = $user->getIdUser();
                $response["first_name"] = $user->getFirstName();
                $response["last_name"] = $user->getLastName();
            }
            
            else if(get_class($user) == "Merchant"){
                $response["id_merchant"] = $user->getIdUser();
                $response["merchant_name"] = $user->getMerchantName();
                $response["address"] = $user->getAddress();
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