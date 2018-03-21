<?php
    /**
     * Merepresentasikan pengguna aplikasi QR code payment
     */
    class User{
        private $id_user;
        private $username;
        private $email_address;
        private $password;
        private $handphone_number;
        private $digital_certificate;

        function __construct($id_user, $username, $email_address, $password, $handphone_number, $digital_certificate){
            $this->id_user = $id_user;
            $this->username = $username;
            $this->email_address = $email_address;
            $this->password = $password;
            $this->handphone_number = $handphone_number;
            $this->digital_certificate = $digital_certificate;
        }

        function getIdUser(){
            return $this->id_user;
        }

        function getUsername(){
            return $this->username;
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
