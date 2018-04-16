<?php
    include_once('includes/payment_management.php');
    include_once('includes/wallet_management.php');
    include_once('includes/order_management.php');

    include_once('includes/model/user.php');
    include_once('includes/model/customer.php');
    include_once('includes/model/merchant.php');
    include_once('includes/model/wallet.php');
    include_once('includes/model/order.php');

    $response = array();

    if(isset($_POST['pin'], $_POST['id_customer'], $_POST['id_order'])){
        $pin = $_POST['pin'];
        $temp_id_customer = $_POST['id_customer'];
        $id_order = $_POST['id_order'];
    
            if(getPaymentByOrder($id_order) == null){
                $order = getOrder($id_order);
                $id_merchant = $order->getIdMerchant();
                $id_customer = $order->getIdCustomer();

                if($temp_id_customer != $id_customer){
                    $response['success'] = 0;
                    $response['message'] = "Mau nipu ya, bang?";
                    echo json_encode($response);
                }

                else if($order->getMutualAuth() != "success"){
                    $response['success'] = 0;
                    $response['message'] = "Mau nipu ya, bang?";
                }

                else if($temp_id_customer == $id_customer 
                && $order->getMutualAuth() == "success"
                && insertPayment($id_order, $id_customer, $id_merchant)){
                    $wallet = loginWallet($id_customer, $pin);

                    if($wallet != null){
                        $response['success'] = 1;
                        $response['message'] = "Payment successful!";
                        echo json_encode($response);
                    }
                    else{
                        $response['success'] = 0;
                        $response['message'] = "Wrong PIN. Please try again.";
                        echo json_encode($response);
                    }
                }

                else{
                  $response['success'] = 0;
                  $response['message'] = "System failed to confirm payment.";
                  echo json_encode($response);
                }
            }
            else{
                $response['success'] = 0;
                $response['message'] = "The order has already been paid.";
                echo json_encode($response);
            }
        
    }
    else{
        $response['success'] = 0;
        $response['message'] = "Fields are missing.";
        echo json_encode($response);
      }
 ?>
