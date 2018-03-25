<?php
/**
 * Merepresentasikan e-wallet yang dimiliki oleh pelanggan
 */
    class Wallet{
      private $id_wallet;
      private $saldo;
      private $pin;
      private $id_customer;
      private $id_merchant;

      function __construct($id_wallet, $saldo, $pin, $id_customer, $id_merchant){
        $this->id_wallet = $id_wallet;
        $this->saldo = $saldo;
        $this->pin = $pin;
        $this->id_customer = $id_customer;
        $this->id_merchant = $id_merchant;
      }

      function getIdWallet(){
        return $this->idWallet;
      }

      function getSaldo(){
        return $this->saldo;
      }

      function getPin(){
        return $this->pin;
      }

      function getIdMerchant(){
        return $this->id_merchant;
      }

      function getIdCustomer(){
        return $this->id_customer;
      }
    }
 ?>
