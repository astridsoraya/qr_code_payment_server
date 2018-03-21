<?php
    include_once('config.php');
    include_once('session.php');
    include_once('model/order.php');
    include_once('model/user.php');
    include_once('model/merchant.php');
    include_once('model/customer.php');

    // Mengambil satu order berdasarkan id order
    function getOrder($id_order){
        $core = Core::getInstance();

        $query = "SELECT `id_order`, `waktu_order`, `id_merchant` FROM `order` WHERE `id_order` = :id_order";
        $order;

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_NUM);

            $fetched_id_order = $item[0];
            $waktu_order = $item[1];
            $id_merchant = $item[2];

            $order = new Order($fetched_id_order, $waktu_order, $id_merchant);
        }

        return $order;
    }

    // Mengambil detil order barang yang dimiliki oleh seorang merchant 
    // Khusus digunakan saat pelanggan melakukan scanning QR code
    function verifyQRCodeDataMerchant($id_order){
        $core = Core::getInstance();

        $order_items_list = array();

        $query = "SELECT `order`.`id_order`, `order`.`id_merchant`, `nama_barang`, `harga`, `kuantitas` FROM `order`
        INNER JOIN `order_items` ON `order`.`id_order` = `order_items`.`id_order` INNER JOIN `barang`
        ON `order_items`.`id_barang` = `barang`.`id_barang` WHERE `order`.`id_order` = :id_order";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();
            $order_items = $stmt->fetchAll(PDO::FETCH_NUM);
            $id_merchant;

           foreach($order_items as $order_item){
                $id_order = $order_item[0];
                $id_merchant = $order_item[1];
                $nama_barang = $order_item[2];
                $harga = $order_item[3];
                $kuantitas = $order_item[4];

                $merchant = getMerchantByID($id_merchant);
                $merchant_name = $merchant->getMerchantName();
                $digital_certificate_merchant = $merchant->getDigitalCertificate();

                array_push($order_items_list, array(
                    "id_order" => $id_order,
                    "nama_merchant" => $merchant_name,
                    "nama_barang" => $nama_barang,
                    "harga" => $harga,
                    "kuantitas" => $kuantitas,
                    "digital_certificate_merchant" => $digital_certificate_merchant));
            }
            return $order_items_list;
        }
        else{
            return null;
        }

    }

    function verifyQRCodeDataCustomer($id_order){
        $core = Core::getInstance();
        
        $order_items_list = array();
        $query = "SELECT `order`.`id_order`, `id_customer`, `nama_barang`, `harga`, `kuantitas` FROM `order`
        INNER JOIN `order_items` ON `order`.`id_order` = `order_items`.`id_order` INNER JOIN `barang`
        ON `order_items`.`id_barang` = `barang`.`id_barang` WHERE `order`.`id_order` = :id_order";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();
            $order_items = $stmt->fetchAll(PDO::FETCH_NUM);

           foreach($order_items as $order_item){
                $id_order = $order_item[0];
                $id_customer = $order_item[1];
                $nama_barang = $order_item[2];
                $harga = $order_item[3];
                $kuantitas = $order_item[4];

                $customer = getCustomerByID($id_customer);
                $customer_username = $customer->getUsername();
                $customer_name = $customer->getFirstName() . " " . $customer->getLastName();
                $digital_certificate_customer = $customer->getDigitalCertificate();

                array_push($order_items_list, array(
                    "id_order" => $id_order,
                    "customer_name" => $customer_name,
                    "customer_username" => $customer_username,
                    "nama_barang" => $nama_barang,
                    "harga" => $harga,
                    "kuantitas" => $kuantitas,
                    "digital_certificate_customer" => $digital_certificate_customer));
            }
            return $order_items_list;
        }
        else{
            return null;
        }

        $merchant = getMerchantByID($id_merchant);
        $merchant_name = $merchant->getMerchantName();
        $digital_certificate_merchant = $merchant->getDigitalCertificate();
    }

    // Mengambil pesanan yang sudah dibuat oleh seorang customer
    // Pesanan diambil berdasarkan id customer
    function getAllOrderCustomer($id_customer){
        $core = Core::getInstance();
        // Tabel Order di inner join sama Tabel Order items daaaan tabel Barang untuk mendapatkan nama barang (done)
        // Untuk ngedapetin nama Merchant, id Merchant diambil dan select nama dari tabel merchant (done)
        // Lalu, Order juga dicek apakah sudah dibayar atau belum
        // Jika order tidak ditemukan di tabel Payment, maka pembayaran belum dilakukan konfirmasi
        // Jika order belum memiliki id_customer, QR code belum discan
        // QR scan harus invalid jika 1. sudah melakukan pembayaran (done) 2. Belum discan 3. Belum dilakukan konfirmasi pembayaran

        $order_items_list = array();

        $query = "SELECT `order`.`id_order`, `order`.`id_merchant`, `nama_barang`, `harga`, `kuantitas`, `waktu_bayar` FROM `order`
        INNER JOIN `order_items` ON `order`.`id_order` = `order_items`.`id_order` INNER JOIN `barang`
        ON `order_items`.`id_barang` = `barang`.`id_barang` LEFT JOIN `payment` ON `payment`.`id_customer` = `order`.`id_customer`
        WHERE `order`.`id_customer` = :id_customer";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_customer', $id_customer);
            $stmt->execute();
            $order_items = $stmt->fetchAll(PDO::FETCH_NUM);
            $temp_id_order = "";
            $nama_barang = "";
            $harga = "";
            $kuantitas = "";
            $counter = 0;

           foreach($order_items as $order_item){
                $id_order = $order_item[0];

                if($temp_id_order == ""){
                    $temp_id_order = $id_order;
                }

                if($counter == $stmt->rowCount() - 1 || $temp_id_order != $id_order){
                  $id_merchant = $order_item[1];
                  $waktu_bayar = $order_item[5];

                  $nama_barang .= $order_item[2] . ";";
                  $harga .= $order_item[3] . ";";
                  $kuantitas .= $order_item[4] . ";";

                  $merchant = getMerchantByID($id_merchant);
                  $merchant_name = $merchant->getMerchantName();

                  array_push($order_items_list, array(
                      "id_order" => $temp_id_order,
                      "nama_merchant" => $merchant_name,
                      "nama_barang" => $nama_barang,
                      "harga" => $harga,
                      "kuantitas" => $kuantitas,
                      "waktu_bayar" => $waktu_bayar));

                      $nama_barang = "";
                      $harga = "";
                      $kuantitas = "";
                      $temp_id_order = $id_order;
                }
                else{
                    $nama_barang .= $order_item[2] . ";";
                    $harga .= $order_item[3] . ";";
                    $kuantitas .= $order_item[4] . ";";
                }

                $counter++;

            }
            return $order_items_list;
        }
        else{
            return null;
        }
    }

    // Mengambil semua pesanan yang dimiliki oleh satu merchant
    // Dapat ditunjukkan apakah pesanan sudah dibayar atau belum
    function getAllOrderMerchant($id_merchant){
        $core = Core::getInstance();

        $order_items_list = array();

        $query = "SELECT `order`.`id_order`, `order`.`id_customer`, `nama_barang`, `harga`, `kuantitas`, `waktu_bayar` FROM `order`
        INNER JOIN `order_items` ON `order`.`id_order` = `order_items`.`id_order` INNER JOIN `barang`
        ON `order_items`.`id_barang` = `barang`.`id_barang` LEFT JOIN `payment` ON `payment`.`id_merchant` = `order`.`id_merchant`
        WHERE `order`.`id_merchant` = :id_merchant";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_merchant', $id_merchant);
            $stmt->execute();
            $order_items = $stmt->fetchAll(PDO::FETCH_NUM);

            $temp_id_order = "";
            $nama_barang = "";
            $harga = "";
            $kuantitas = "";
            $counter = 0;

           foreach($order_items as $order_item){
                $id_order = $order_item[0];

                if($temp_id_order == ""){
                    $temp_id_order = $id_order;
                }

                if($counter == $stmt->rowCount() - 1 || $temp_id_order != $id_order){
                  $id_customer = $order_item[1];
                  $waktu_bayar = $order_item[5];

                  $nama_barang .= $order_item[2] . ";";
                  $harga .= $order_item[3] . ";";
                  $kuantitas .= $order_item[4] . ";";

                  $customer = getCustomerByID($id_customer);
                  $nama_customer = $customer->getFirstName() . " " . $customer->getLastName();

                  array_push($order_items_list, array(
                      "id_order" => $id_order,
                      "nama_customer" => $nama_customer,
                      "nama_barang" => $nama_barang,
                      "harga" => $harga,
                      "kuantitas" => $kuantitas,
                      "waktu_bayar" => $waktu_bayar));

                      $nama_barang = "";
                      $harga = "";
                      $kuantitas = "";
                      $temp_id_order = $id_order;
                }
                else{
                    $nama_barang .= $order_item[2] . ";";
                    $harga .= $order_item[3] . ";";
                    $kuantitas .= $order_item[4] . ";";
                }

                $counter++;

            }
            return $order_items_list;
        }
        else{
            return null;
        }
    }

    // Menambah pesanan dengan parameter id merchant
    function addOrder($id_merchant){
        $core = Core::getInstance();

        $length = 5;
        $addition = "";
        
        // membangkitkan 5 karakter secara acak
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
          $rand = mt_rand(0, $max);
          $addition .= $characters[$rand];
        }

        $id_order = date("YmdHis") . "-" . $addition; //20 karakter

        $query = "INSERT INTO `order` (`id_order`, `waktu_order`, `id_merchant`) VALUES (?,?,?)";
        if($insert_stmt = $core->dbh->prepare($query)){
            $null = null;

            $insert_stmt->bindParam('1', $id_order);
            $insert_stmt->bindParam('2', $null);
            $insert_stmt->bindParam('3', $id_merchant);

            if(!$insert_stmt->execute()){
                return null;
            }
            else{
                $order = getOrder($id_order);
                return $order;
            }
        }
        else{
            return null;
        }
    }

    // Menambah order items yang menunjukkan kuantitas barang yang dipesan
    function addOrderItems($id_order, $id_barang, $kuantitas){
        $core = Core::getInstance();

        $query = "INSERT INTO `order_items` (`id_order`, `id_barang`, `kuantitas`) VALUES (?,?,?)";
        if($insert_stmt = $core->dbh->prepare($query)){
            $insert_stmt->bindParam('1', $id_order);
            $insert_stmt->bindParam('2', $id_barang);
            $insert_stmt->bindParam('3', $kuantitas);

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

    // Mengupdate informasi pesanan dari belum dibayar
    // menjadi sudah dibayar
    function updateCustomerOrder($id_order, $id_customer){
      $core = Core::getInstance();

      $query = "UPDATE `order` SET `id_customer`= :id_customer WHERE `id_order`= :id_order";
        
      $core->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


      if($update_stmt = $core->dbh->prepare($query)){
          $update_stmt->bindParam('id_customer', $id_customer);
          $update_stmt->bindParam('id_order', $id_order);

          if(!$update_stmt->execute()){
            print_r($update->errorInfo());
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


?>
