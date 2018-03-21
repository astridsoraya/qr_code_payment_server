<?php
    include_once('includes/session.php');
    include_once('includes/model/merchant.php');
    include_once('includes/model/user.php');
    include_once('includes/model/customer.php');

    $response = array();

    if($_POST['username']){        
        $username = $_POST['username'];
        $merchant = getMerchantByUsername($username);
        $customer = getCustomerByUsername($username);

        if($customer != null){
            $response['success'] = 1;
            $response['message'] = 'Username exists';

            $response["username"] = $customer->getUsername();
            $response["first_name"] = $customer->getFirstName();
            $response["last_name"] = $customer->getLastName();
            $response["digital_certificate"] = $customer->getDigitalCertificate();

            echo json_encode($response);
        }
        else if($merchant != null){
            $response['success'] = 1;
            $response['message'] = 'Username exists';

            $response["username"] = $customer->getUsername();
            $response["merchant_name"] = $merchant->getMerchantName();
            $response["digital_certificate"] = $merchant->getDigitalCertificate();
        }
        else{
            $response['success'] = 0;
            $response['message'] = 'Failed to search username';

            echo json_encode($response);
        }
    }
    else{
        $response['success'] = 0;
        $response['message'] = 'Missing fields';

        echo json_encode($response);
    }
?>