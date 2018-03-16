<?php
    class Payment{
        private $id_payment;
        private $waktu_bayar;
        private $id_customer;
        private $id_merchant;
        private $id_order;

        function __construct($id_payment, $waktu_bayar, $id_customer, $id_merchant, $id_order){
            $this->id_payment = $id_payment;
            $this->waktu_bayar = $waktu_bayar;
            $this->id_customer = $id_customer;
            $this->id_merchant = $id_merchant;
            $this->id_order = $id_order;
        }

        function getIdPayment(){
            return $this->id_payment;
        }

        function getWaktuBayar(){
            return $this->waktu_bayar;
        }

        function getIdCustomer(){
            return $this->id_customer;
        }

        function getIdMerchant(){
            return $this->$id_merchant;
        }

        function getIdOrder(){
          return $this->id_order;
        }
    }
 ?>
