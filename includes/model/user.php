<?php
    /**
     * Merepresentasikan pengguna aplikasi QR code payment
     */
    class User{
        private $id_user;
        private $email_address;
        private $password;
        private $handphone_number;
        private $digital_certificate;

        function __construct($id_user, $email_address, $password, $handphone_number, $digital_certificate){
            $this->id_user = $id_user;
            $this->email_address = $email_address;
            $this->password = $password;
            $this->handphone_number = $handphone_number;
            $this->digital_certificate = $digital_certificate;
        }

        function getIdUser(){
            return $this->id_user;
        }

        function getEmailAddress(){
            return $this->email_address;
        }

        function getPassword(){
            return $this->password;
        }

        function getHandphoneNumber(){
            return $this->handphone_number;
        }

        function getDigitalCertificate(){
          return $this->digital_certificate;
        }
    }
?>
