<?php
    include_once('includes/order_management.php');

    $response = array();

    if(isset($_POST['id_order'], $_POST['user_type'])){
        $id_order = $_POST['id_order'];
        $user_type = $_POST['user_type'];

        if($user_type == "customer"){
            if(updateCustomerOrder($id_order, "0") && updateMerchantOrder($id_order, "0")){
                $response["success"] = 1;
                $response["message"] = "Order was cancelled by customer";
            }
            else{
                $response["success"] = 0;
                $response["message"] = "System failed to cancel the order";
            }
        }
        else if($user_type == "merchant"){
            if(updateMerchantOrder($id_order, "0")){
                $response["success"] = 1;
                $response["message"] = "Order was cancelled by merchant";
            }
            else{
                $response["success"] = 0;
                $response["message"] = "System failed to cancel the order";
            }
        }
    }
    else{
        $response["success"] = 0;
        $response["message"] = "Field is missing.";
    }

    echo json_encode($response);
?>