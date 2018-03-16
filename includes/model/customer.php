<?php
    if (strstr($_SERVER["PHP_SELF"], "/model/")) die ("Istighfar, jangan di hack. Makasih :)");
    include_once('user.php');

    class Customer extends User{
        private $first_name;
        private $last_name;

        function __construct($id_customer, $first_name, $last_name, $email_address, $password, $handphone_number, $digital_certificate){
            parent::__construct($id_customer, $email_address, $password, $handphone_number, $digital_certificate);
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }

        function getFirstName(){
            return $this->first_name;
        }

        function getLastName(){
            return $this->last_name;
        }

    }

?>
