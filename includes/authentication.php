<?php
    
    // Mengambil detil order barang yang dimiliki oleh seorang merchant 
    // Khusus digunakan saat pelanggan melakukan scanning QR code
    function verifyQRCodeDataMerchant($id_order, $id_merchant){
        $core = Core::getInstance();

        $merchantVerification = array();

        $query = "SELECT `order`.`id_order`, `order`.`id_merchant`, `nama_barang`, `harga`, `kuantitas` FROM `order`
        INNER JOIN `order_items` ON `order`.`id_order` = `order_items`.`id_order` INNER JOIN `barang`
        ON `order_items`.`id_barang` = `barang`.`id_barang` WHERE `order`.`id_order` = :id_order";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();
            $order_items = $stmt->fetchAll(PDO::FETCH_NUM);

           foreach($order_items as $order_item){
                $id_order = $order_item[0];
                $id_merchant_order = $order_item[1];
                $nama_barang = $order_item[2];
                $harga = $order_item[3];
                $kuantitas = $order_item[4];

                if($id_merchant_order == NULL){
                    array_push($order_items_list, array(
                        "id_order" => $id_order,
                        "nama_merchant" => $merchant_name,
                        "nama_barang" => $nama_barang,
                        "harga" => $harga,
                        "kuantitas" => $kuantitas);
                }
                else if($id_merchant_order == $id_merchant){
                    $merchantVerification["success"] = "-1";
                    $merchantVerification["message"] = "This order is already done before! Returning to main menu...";
                    break;
                }
                else{
                    $merchantVerification["success"] = "-1";
                    $merchantVerification["message"] = "THIIIIIIIIIIIIIEEEFFFFFFFFFFFFF!!!!";
                    break;
                }
            }
            return $merchantVerification;
        }
        else{
            $customerVerification["success"] = "-1";
            $customerVerification["message"] = "Order doesn't exist";

            return $customerVerification;
        }
    }

    function verifyQRCodeDataCustomer($id_order, $id_customer){
        $core = Core::getInstance();

        $customerVerification = array();
        $query = "SELECT `id_order`, `id_customer`, `waktu_order` FROM `order` 
        WHERE `id_order` = :id_order";

        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam('id_order', $id_order);
            $stmt->execute();
            $customer_order = $stmt->fetch(PDO::FETCH_NUM);
            $id_order = $customer_order[0];
            $id_customer_order = $customer_order[1];
            $waktu_order = $customer_order[2];

            if($id_customer_order == NULL){
                $customer = getCustomerByID($id_customer);
                $customer_username = $customer->getUsername();
                $customer_name = $customer->getFirstName() . " " . $customer->getLastName();
                $digital_certificate_customer = $customer->getDigitalCertificate();

                $customerVerification["id_order"] = $id_order;
                $customerVerification["customer_name"] = $customer_name;
                $customerVerification["customer_username"] = $customer_username;
                $customerVerification["waktu_order"] = $waktu_order;
                $customerVerification["digital_certificate_customer"] = $digital_certificate_customer;    

                $customerVerification["success"] = "1";
                $customerVerification["message"] = "Customer is valid. Proceed to merchant authentication.";
            }

            else if($id_customer_order == $id_customer){
                $customerVerification["success"] = "-1";
                $customerVerification["message"] = "This order is already done before! Returning to main menu...";
            }

            else{
                $customerVerification["success"] = "-1";
                $customerVerification["message"] = "THIIIIIIIIIIIIIEEEFFFFFFFFFFFFF!!!!";
            }
            return $customerVerification;
        }
        else{
            $customerVerification["success"] = "-1";
            $customerVerification["message"] = "Order doesn't exist";

            return $customerVerification;
        }
    }
?>