<?php
    include_once('includes/session.php');
    include_once('includes/authentication.php');
    include_once('includes/model/merchant.php');
    include_once('includes/model/user.php');
    include_once('includes/model/customer.php');

    $response = array();

    if(isset($_POST['username'], $_POST['id_order'], $_POST['user_type'])){        
        $username = $_POST['username'];
        $user_type = $_POST['user_type'];
        $id_order = $_POST['id_order'];

        if($user_type == "customer"){
            $customer = getCustomerByUsername($username);
            if($customer == NULL){
                $response['success'] = "-1";
                $response['message'] = "Username doesn't exist";
            }
            else{
                $id_customer = $customer->getIdUser();
            
                $response = verifyQRCodeDataCustomer($id_order, $id_customer);
                echo json_encode($response);
            }
        }
        else if($user_type == "merchant"){
            $merchant = getMerchantByUsername($username);
            
            if($merchant == NULL){
                $response['success'] = "-1";
                $response['message'] = "Username doesn't exist";
            }
            else{
                $id_merchant = $merchant->getIdUser();
            
                $response = verifyQRCodeDataMerchant($id_order, $id_merchant);
                echo json_encode($response);
            }
        }
    }
    else{
        $response['success'] = 0;
        $response['message'] = 'Missing fields';

        echo json_encode($response);
    }
?>