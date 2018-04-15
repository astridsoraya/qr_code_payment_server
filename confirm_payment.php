<?php
    include_once('includes/payment_management.php');
    include_once('includes/wallet_management.php');
    include_once('includes/model/wallet.php');
    $response = array();

    if(isset($_POST['pin'], $_POST['id_customer'], $_POST['id_order'])){
        $pin = $_POST['pin'];
        $id_customer = $_POST['id_customer'];
        $id_order = $_POST['id_order'];

        $wallet = loginWallet($id_customer, $pin);

        if($wallet != null){
            if(getPaymentByOrder($id_order) == null){
                if(insertPayment($id_order, $id_customer)){
					
                  $response['success'] = 1;
                  $response['message'] = "Payment successful!";
                  echo json_encode($response);

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
          $response['message'] = "Wrong PIN. Please try again.";
          echo json_encode($response);
        }
    }
    else if(isset($_POST['id_merchant'], $_POST['id_order'])){
        $id_merchant = $_POST['id_merchant'];
        $id_order = $_POST['id_order'];

        $wallet = loginWallet($id_customer, $pin);

            if(getPaymentByOrder($id_order) == null){
                if(updateMerchantPayment($id_order, $id_merchant)){
					
                  $response['success'] = 1;
                  $response['message'] = "Merchant is updated!";
                  echo json_encode($response);

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
