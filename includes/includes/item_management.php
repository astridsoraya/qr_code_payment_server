<?php
    include_once('config.php');
    include_once('model/item.php');

    // Mengambil barang-barang merchant berdasarkan id merchant
    function getMerchantItems($id_merchant){
        $item_list = array();

        $query = "SELECT id_barang, nama_barang, harga, stok FROM barang WHERE id_merchant = :id_merchant";

        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam(':id_merchant', $id_merchant);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_NUM);

            foreach($items as $item){
                $id_barang = $item[0];
                $nama_barang = $item[1];
                $harga = $item[2];
                $stok = $item[3];

                array_push($item_list, array(
                    "id_barang" => $id_barang,
                    "nama_barang" => $nama_barang,
                    "harga" => $harga,
                    "stok" => $stok));
            }
        }

        return $item_list;
    }

    // Mengambil satu barang berdasarkan id barang
    function getItem($id_barang){
        $query = "SELECT id_barang, nama_barang, harga, stok FROM barang WHERE id_barang = :id_barang LIMIT 1";

        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare($query)){
            $stmt->bindParam(':id_barang', $id_barang);
            $stmt->execute();
            $fetchedItem = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_barang = $fetchedItem[0];
                $nama_barang = $fetchedItem[1];
                $harga = $fetchedItem[2];
                $stok = $fetchedItem[3];

                $item = new Item($id_barang, $nama_barang, $harga, $stok);
                return $item;
            }
            else{
                return null;
            }
        }
        else{
            return null;
            exit();
        }

    }

    // Menambah barang merchant
    function addItem($id_barang, $nama_barang, $harga, $stok, $id_merchant){
        $core = Core::getInstance();

        $query = "INSERT INTO barang (id_barang, nama_barang, harga, stok, id_merchant) VALUES (?,?,?,?,?)";
        if($insert_stmt = $core->dbh->prepare($query)){
            $insert_stmt->bindParam('1', $id_barang);
            $insert_stmt->bindParam('2', $nama_barang);
            $insert_stmt->bindParam('3', $harga);
            $insert_stmt->bindParam('4', $stok);
            $insert_stmt->bindParam('5', $id_merchant);

            if(!$insert_stmt->execute()){
                return false;
                exit();
            }
            else{
                return true;
            }
        }
        else{
            return false;
            exit();
        }
    }
?>
