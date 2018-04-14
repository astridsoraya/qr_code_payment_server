<?php
    include_once('includes/config.php');
    include_once('includes/merchant_management.php');
    
    $merchants_list = getAllMerchants();
        
    if(!empty($merchants_list)){
        echo json_encode($merchants_list);
    }

?>