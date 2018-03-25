<?php

    function createShares($idOrder){
        $script = "java -jar upload\img\binary_vc.jar create_shares " . $idOrder;
        exec($script);
    }

    function reconstructSecretImages($idOrder){
        $script = "java -jar upload\img\binary_vc.jar reconstruct " . $idOrder;
        exec($script);
    }

?>