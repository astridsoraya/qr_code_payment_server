<?php
    include_once('includes/config.php');
    include_once('includes/order_management.php');

    $response = array();

    if(isset($_POST['id_order'], $_POST['id_customer'])){
        $id_order = $_POST['id_order'];
        $id_customer = $_POST['id_customer'];

        updateCustomerOrder($id_order, $id_customer);
        $order_list = verifyQRCodeDataMerchant($id_order);

        if($order_list != null){
            echo json_encode($order_list);
        }
        else{
            echo json_encode($response);
        }
    }
    else if(isset($_POST['id_order'], $_POST['id_merchant'])){
        $id_order = $_POST['id_order'];
        $order_list = verifyQRCodeDataCustomer($id_order);

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
