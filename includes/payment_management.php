<?php
  include_once('order_management.php');
  include_once('model/merchant.php');
  include_once('model/order.php');
  include_once('model/payment.php');
  include_once('order_management.php');

  function insertPayment($id_order, $id_customer){
      $core = Core::getInstance();

      $length = 5;
      $addition = "";
    	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    	$max = count($characters) - 1;
    	for ($i = 0; $i < $length; $i++) {
    		$rand = mt_rand(0, $max);
    		$addition .= $characters[$rand];
    	}

      $id_payment = date("YmdHis") . "-" . $addition; //20 karakter
      $order = getOrder($id_order);
      $id_merchant = $order->getIdMerchant();

      $query = "INSERT INTO `payment` (`id_payment`, `waktu_bayar`, `id_customer`, `id_merchant`, `id_order`) VALUES (?,?,?,?,?)";
      if($insert_stmt = $core->dbh->prepare($query)){
          $null = null;

          $insert_stmt->bindParam('1', $id_payment);
          $insert_stmt->bindParam('2', $null);
          $insert_stmt->bindParam('3', $id_customer);
          $insert_stmt->bindParam('4', $id_merchant);
          $insert_stmt->bindParam('5', $id_order);

          if(!$insert_stmt->execute()){
              print_r($insert_stmt->errorInfo());
              return false;
          }
          else{
              return true;
          }
      }
      else{
          return false;
      }
    }

    function getPaymentByOrder($id_order){
        $core = Core::getInstance();
        $query = "SELECT `id_payment`, `waktu_bayar`, `id_customer`, `id_merchant` FROM `payment` WHERE `id_order` = :id_order";
        $payment = null;

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $item = $stmt->fetch(PDO::FETCH_NUM);

                $id_payment = $item[0];
                $waktu_bayar = $item[1];
                $id_customer = $item[2];
                $id_merchant = $item[3];

                $payment = new Payment($id_payment, $waktu_bayar, $id_customer, $id_merchant, $id_order);  
            }
            
        }

        return $payment;
    }
 ?>
