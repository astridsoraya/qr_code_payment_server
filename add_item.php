<?php

    include_once('includes/config.php');
    include_once('includes/item_management.php');

    $response = array();

    if(isset($_POST['id_barang'], $_POST['nama_barang'], $_POST['harga'], $_POST['stok'], $_POST['id_merchant'])){
        $id_barang = $_POST['id_barang'];
        $nama_barang = $_POST['nama_barang'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $id_merchant = $_POST['id_merchant'];

        if(getItem($id_barang) != null){
            $response['success'] = 2;
            $response['message'] = "Item's already added before.";
            echo json_encode($response);
        }
        else{
            if(addItem($id_barang, $nama_barang, $harga, $stok, $id_merchant)){
                $response['success'] = 1;
                $response['message'] = "Successfully added an item";
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = "System failed to add an item";
                echo json_encode($response);
            }
        }
    }
?>
