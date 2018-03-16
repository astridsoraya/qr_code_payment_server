<?php
    class Order{
        private $id_order;
        private $waktu_order;
        private $id_merchant;
        
        public function __construct($id_order, $waktu_order, $id_merchant){
            $this->id_order = $id_order;
            $this->waktu_order = $waktu_order;
            $this->id_merchant = $id_merchant;
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
        
    }

?>