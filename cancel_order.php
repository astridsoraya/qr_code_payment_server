<?php
    include_once('includes/order_management.php');

    $response = array();

    if(isset($_POST['id_order'], $_POST['id_customer'])){
        $id_order = $_POST['id_order'];
        $id_customer = $_POST['id_customer'];
            if(updateCustomerOrder($id_order, $id_customer) && updateMutualAuth($id_order, "failed")){
                $response["success"] = 1;
                $response["message"] = "Order was cancelled by customer";
            }
            else{
                $response["success"] = 0;
                $response["message"] = "System failed to cancel the order";
            }
    }
    else if(isset($_POST['id_order'], $_POST['id_merchant'])){
        $id_order = $_POST['id_order'];
        $id_merchant = $_POST['id_merchant'];
            if(updateMerchantOrder($id_order, $id_merchant) && updateMutualAuth($id_order, "failed")){
                $response["success"] = 1;
                $response["message"] = "Order was cancelled by merchant";
            }
            else{
                $response["success"] = 0;
                $response["message"] = "System failed to cancel the order";
            }
    }
    echo json_encode($response);
?>