<?php
    include_once('includes/order_management.php');

    if(isset($_POST['user_type'])){
        $user_type = $_POST['user_type'];

        if($user_type == "customer" && isset($_POST['id_customer'])){
            $id_customer = $_POST['id_customer'];
            $order_list = getAllOrderCustomer($id_customer);

        }
        else if($user_type == "merchant" && isset($_POST['id_merchant'])){
            $id_merchant = $_POST['id_merchant'];
            $order_list = getAllOrderMerchant($id_merchant);
        }

        if(!empty($order_list)){
            echo json_encode($order_list);
        }
    }
    else{
        exit();
    }
 ?>
