<?php
    include_once('includes/config.php');
    include_once('includes/order_management.php');
    include_once('includes/model/order.php');

    $response = array();

    $counter = 0;
    $id_merchant = "";
    $order = null;

    $order = addOrder();
    $id_order = $order->getIdOrder();

    if($order != null){
        while(isset($_POST['id_barang_'.$counter], $_POST['kuantitas_'.$counter])){
            $id_barang = $_POST['id_barang_'.$counter];
            $kuantitas = $_POST['kuantitas_'.$counter];

            if(!addOrderItems($id_order, $id_barang, $kuantitas)){
                $counter = 0;
                break;
            }

            else{
                $counter++;
            }
        }
    }

    if($counter != 0){
        $response["success"] = 1;
        $response["message"] = "Successfully ordered items!";
        $response["id_order"] = $id_order;
    }
    else{
        $response["success"] = 0;
        $response["message"] = "Failed to order items.";
    }

    echo json_encode($response);
?>
