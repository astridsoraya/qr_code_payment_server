<?php
/**
 * Merepresentasikan pesanan yang dibuat saat pelanggan
 * memesan barang
 */
    class Order{
        private $id_order;
        private $waktu_order;
        private $id_merchant;
        private $id_customer;
        
        public function __construct($id_order, $waktu_order, $id_merchant, $id_customer){
            $this->id_order = $id_order;
            $this->waktu_order = $waktu_order;
            $this->id_merchant = $id_merchant;
            $this->id_customer = $id_customer;
        }
        
        public function getIdOrder(){
            return $this->id_order;
        }
        
        public function getWaktuOrder(){
            return $this->waktu_order;
        }
        
        public function getIdMerchant(){
            return $this->id_merchant;
        }

        public function getIdCustomer(){
            return $this->id_customer;
        }
        
    }

?>