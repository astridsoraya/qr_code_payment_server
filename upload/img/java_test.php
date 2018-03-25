<?php
    function createShares($idOrder){
        $script = "java jar/binary_vc.jar " . "create_shares " . $idOrder;
        exec($script);
    }

    function reconstructSecretImage($idOrder){
        $script = "java jar/binary_vc.jar " . "reconstruct " . $idOrder;
        exec($script);
    }
?>