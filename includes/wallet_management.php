<?php
    include_once('config.php');
    include_once('session.php');
    include_once('model/wallet.php');

    // Mengambil wallet
    function createWallet($pin, $email_address, $user_type){
        $core = Core::getInstance();
        $id_wallet = date('ymdHis') . mt_rand(1000, 9999); // 16 karakter

        $options = [
            'cost' => 12,
        ];
        $hashed_pin = password_hash($pin, PASSWORD_BCRYPT, $options);
        $id_user;
        $saldo = 0;
        $myNull = null;

        $query = "INSERT INTO wallet (id_wallet, saldo, pin, id_customer, id_merchant) VALUES (?, ?, ?, ?, ?)";

        if($insert_stmt = $core->dbh->prepare($query)){
            $insert_stmt->bindParam('1', $id_wallet);
            $insert_stmt->bindParam('2', $saldo);
            $insert_stmt->bindParam('3', $hashed_pin);

            if($user_type == 'merchant'){
                $merchant = getMerchant($email_address);
                $id_user = $merchant->getIdUser();

                $insert_stmt->bindParam('4', $myNull);
                $insert_stmt->bindParam('5', $id_user);
            }
            else{
                $customer = getCustomer($email_address);
                $id_user = $customer->getIdUser();

                $insert_stmt->bindParam('4', $id_user);
                $insert_stmt->bindParam('5', $myNull);
            }

            if(!$insert_stmt->execute()){
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

    // Melakukan login wallet saat mengkonfirmasi pembayaran
    function loginWallet($id_user, $tempPin){
      $core = Core::getInstance();

      $query = "SELECT id_wallet, saldo, pin, id_customer, id_merchant FROM wallet WHERE `id_customer` = :id_user OR `id_merchant` = :id_user";

      if ($stmt = $core->dbh->prepare($query)){
          $stmt->bindParam('id_user', $id_user);
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_NUM);

          $id_wallet = $row[0];
          $saldo = $row[1];
          $pin = $row[2];
          $id_customer = $row[3];
          $id_merchant = $row[4];

          if(password_verify($tempPin, $pin)){
            $wallet = new Wallet($id_wallet, $saldo, $pin, $id_customer, $id_merchant);
            return $wallet;
          }
          else{
            return null;
          }
      }
      else{
          return null;
      }
    }
?>
