<?php
    include_once('includes/config.php');
    include_once('includes/item_management.php');
    
    if(isset($_POST['id_merchant'])){
        $id_merchant = $_POST['id_merchant'];
        $item_list = getMerchantItems($id_merchant);
        
        if(!empty($item_list)){
            echo json_encode($item_list);
        }
    }
    else{
        exit();
    }

?>