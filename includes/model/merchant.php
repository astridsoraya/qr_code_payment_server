<?php
    include_once('user.php');
    
/**
 * Merepresentasikan merchant yang menjual barang
 */
    class Merchant extends User{
        private $merchant_name;
        private $address;

        function __construct($id_merchant, $username, $merchant_name, $email_address, $password, $address, $handphone_number, $digital_certificate){
            parent::__construct($id_merchant, $username, $email_address, $password, $handphone_number, $digital_certificate);
            $this->merchant_name = $merchant_name;
            $this->address = $address;
        }

        function getMerchantName(){
            return $this->merchant_name;
        }

        function getAddress(){
            return $this->address;
        }

    }

?>
