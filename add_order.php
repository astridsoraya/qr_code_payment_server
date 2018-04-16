<?php
    include_once('includes/config.php');
    include_once('includes/order_management.php');
    include_once('includes/model/order.php');

    $response = array();
    
    $order = addOrder();
    $id_order = $order->getIdOrder();

    if($id_order != NULL){
        $response["success"] = 1;
        $response["message"] = "You've requested to order! Ask merchants to scan your QR code!";
        $response["id_order"] = $id_order;
    }
    else{
        $response["success"] = 0;
        $response["message"] = "Failed to request an order. Please, try again.";
    }

    echo json_encode($response);
?>
