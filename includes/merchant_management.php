<?php
    include_once('config.php');

    function getAllMerchants(){
        $merchants_list = array();

        $query = "SELECT merchant_name, address, handphone_number, digital_certificate FROM merchant";

        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare($query)){
            $stmt->execute();
            $merchants = $stmt->fetchAll(PDO::FETCH_NUM);

            foreach($merchants as $merchant){
                $merchant_name = $merchant[0];
                $address = $merchant[1];
                $handphone_number = $merchant[2];
                $digital_certificate = $merchant[3];

                array_push($item_list, array(
                    "merchant_name" => $merchant_name,
                    "adress" => $address,
                    "handphone_number" => $handphone_number,
                    "digital_certificate" => $digital_certificate));
            }
        }

        return $merchants_list;
    }
?>