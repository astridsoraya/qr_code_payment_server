<?php

    /**
     * Class item merepresentasikan barang yang dijual
     * oleh merchant
     */

    class Item{
        private $id_barang;
        private $nama_barang;
        private $harga;
        private $stok;
        
        public function __construct($id_barang, $nama_barang, $harga, $stok){
            $this->id_barang = $id_barang;
            $this->nama_barang = $nama_barang;
            $this->harga = $harga;
            $this->stok = $stok;
        }
        
        public function getIdBarang(){
            return $this->id_barang;
        }
        
        public function getNamaBarang(){
            return $this->nama_barang;
        }
        
        public function getHarga(){
            return $this->harga;
        }
        
        public function getStok(){
            return $this->stok;
        }
    }

?>