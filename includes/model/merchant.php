<?php
    if (strstr($_SERVER["PHP_SELF"], "/model/")) die ("Istighfar, jangan di hack. Makasih :)");
    include_once('user.php');

    class Merchant extends User{
        private $merchant_name;
        private $address;

        function __construct($id_merchant, $merchant_name, $email_address, $password, $address, $handphone_number, $digital_certificate){
            parent::__construct($id_merchant, $email_address, $password, $handphone_number, $digital_certificate);
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
