<?php
    include_once('includes/config.php');
    include_once('includes/session.php');
    include_once('includes/order_management.php');

    include_once('includes/model/customer.php');
    include_once('includes/model/merchant.php');
    include_once('includes/model/user.php');

    $response = array();

    if(isset($_POST['id_order'], $_POST['username_customer'])){
        $id_order = $_POST['id_order'];
        $username_customer = $_POST['username_customer'];

        $customer = getCustomerByUsername($username_customer);
        $id_customer = $customer->getIdUser();

        updateCustomerOrder($id_order, $id_customer);
        $order_list = verifyQRCodeDataCustomer($id_order);

        if($order_list != null){
            echo json_encode($order_list);
        }
        else{
            echo json_encode($response);
        }
    }
    else if(isset($_POST['id_order'], $_POST['username_merchant'])){
        $id_order = $_POST['id_order'];
        $username_merchant = $_POST['username_merchant'];

        $merchant = getMerchantByUsername($username_merchant);
        $id_merchant = $merchant->getIdUser();

        updateMerchantOrder($id_order, $id_merchant);
        $order_list = verifyQRCodeDataMerchant($id_order);

        if($order_list != null){
            echo json_encode($order_list);
        }
        else{
            echo json_encode($response);
        }
    }
    else{
        exit();
    }
?>
