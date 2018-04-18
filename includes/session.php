<?php
    if (strstr($_SERVER["PHP_SELF"], "/includes/")) die ("Istighfar, jangan di hack. Makasih :)");
    include_once('config.php');
    include_once('model/merchant.php');
    include_once('model/customer.php');

    // Meregistrasi customer
    function registerCustomer($first_name, $last_name, $username, $email_address, $password, $no_handphone){
        $core = Core::getInstance();
        if(getCustomer($email_address) == null){
            $date = date_create();
            $id_customer = date_format($date, 'U');
            $options = [
                'cost' => 12,
            ];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO customer (id_customer, first_name, last_name, username, email_address, password, handphone_number, digital_certificate) VALUES (?,?,?,?,?,?,?,?)";
			      $myNull = null;
            if($insert_stmt = $core->dbh->prepare($query)){
                $insert_stmt->bindParam('1', $id_customer);
                $insert_stmt->bindParam('2', $first_name);
                $insert_stmt->bindParam('3', $last_name);
                $insert_stmt->bindParam('4', $username);
                $insert_stmt->bindParam('5', $email_address);
                $insert_stmt->bindParam('6', $hashed_password);
                $insert_stmt->bindParam('7', $no_handphone);
				$insert_stmt->bindParam('8', $myNull);
                if(!$insert_stmt->execute()){
                    return false;
                }
                else{
                    return true;
                }

            }
        }
        else{
            return false;
        }
    }

    // Meregistrasi merchant
    function registerMerchant($merchant_name, $username, $email_address, $password, $address, $no_handphone){
        $core = Core::getInstance();
        if(getMerchant($email_address) == null){
            $date = date_create();
            $id_merchant = date_format($date, 'U');
            $options = [
                'cost' => 12,
            ];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO merchant (id_merchant, merchant_name, username, email_address, password, address, handphone_number, digital_certificate) VALUES (?,?,?,?,?,?,?,?)";
            if($insert_stmt = $core->dbh->prepare($query)){
                $insert_stmt->bindParam('1', $id_merchant);
                $insert_stmt->bindParam('2', $merchant_name);
                $insert_stmt->bindParam('3', $username);
                $insert_stmt->bindParam('4', $email_address);
                $insert_stmt->bindParam('5', $hashed_password);
                $insert_stmt->bindParam('6', $address);
                $insert_stmt->bindParam('7', $no_handphone);
				$insert_stmt->bindParam('8', $myNull);

                if(!$insert_stmt->execute()){
                    return false;
                }
                else{
                    return true;
                }

            }
        }
        else{
            return false;
        }
    }

    //Melakukan login
    function loginByEmail($email_address, $temp_password) {
        $customer = getCustomer($email_address);
        $merchant = getMerchant($email_address);

        if($customer != null){
            if(password_verify($temp_password, $customer->getPassword())){
                return $customer;
            }
            else{
                return null;
            }
        }
        else if($merchant != null){
            if(password_verify($temp_password, $merchant->getPassword())){
                return $merchant;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }

    //Melakukan login
    function loginByUsername($username, $temp_password) {
        $customer = getCustomerByUsername($username);
        $merchant = getMerchantByUsername($username);

        if($customer != null){
            if(password_verify($temp_password, $customer->getPassword())){
                return $customer;
            }
            else{
                return null;
            }
        }
        else if($merchant != null){
            if(password_verify($temp_password, $merchant->getPassword())){
                return $merchant;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
    // Mengambil merchant dengan parameter email address
    function getMerchant($email_address){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_merchant, username, merchant_name, email_address, password, address, handphone_number, digital_certificate FROM merchant WHERE email_address = :email_address LIMIT 1")) {
            $stmt->bindParam(':email_address', $email_address);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_merchant = $row[0];
                $username = $row[1];
                $merchant_name = $row[2];
                $email_address = $row[3];
                $password = $row[4];
                $address = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $merchant = new Merchant($id_merchant, $username, $merchant_name, $email_address, $password, $address, $handphone_number, $digital_certificate);
                return $merchant;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }

    }

    // Mengambil merchant berdasarkan id merchant
    function getMerchantByUsername($username){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_merchant, username, merchant_name, email_address, password, address, handphone_number, digital_certificate FROM merchant WHERE username = :username LIMIT 1")) {
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_merchant = $row[0];
                $username = $row[1];
                $merchant_name = $row[2];
                $email_address = $row[3];
                $password = $row[4];
                $address = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $merchant = new Merchant($id_merchant, $username, $merchant_name, $email_address, $password, $address, $handphone_number, $digital_certificate);
                return $merchant;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }
    }

// Mengambil merchant berdasarkan id merchant
    function getMerchantByID($id_merchant){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_merchant, username, merchant_name, email_address, password, address, handphone_number, digital_certificate FROM merchant WHERE id_merchant = :id_merchant LIMIT 1")) {
            $stmt->bindParam(':id_merchant', $id_merchant);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_merchant = $row[0];
                $username = $row[1];
                $merchant_name = $row[2];
                $email_address = $row[3];
                $password = $row[4];
                $address = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $merchant = new Merchant($id_merchant, $username, $merchant_name, $email_address, $password, $address, $handphone_number, $digital_certificate);
                return $merchant;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }
    }

    // Mengambil customer dengan parameter email address
    function getCustomerByUsername($username){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_customer, username, first_name, last_name, email_address, password, handphone_number, digital_certificate FROM customer WHERE username = :username LIMIT 1")) {
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_customer = $row[0];
                $username = $row[1];
                $first_name = $row[2];
                $last_name = $row[3];
                $email_address = $row[4];
                $password = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $customer = new Customer($id_customer, $username, $first_name, $last_name, $email_address, $password, $handphone_number, $digital_certificate);
                return $customer;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }

    }

    // Mengambil customer dengan parameter email address
    function getCustomer($email_address){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_customer, username, first_name, last_name, email_address, password, handphone_number, digital_certificate FROM customer WHERE email_address = :email_address LIMIT 1")) {
            $stmt->bindParam(':email_address', $email_address);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_customer = $row[0];
                $username = $row[1];
                $first_name = $row[2];
                $last_name = $row[3];
                $email_address = $row[4];
                $password = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $customer = new Customer($id_customer, $username, $first_name, $last_name, $email_address, $password, $handphone_number, $digital_certificate);
                return $customer;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }

    }

    // Mengambil customer dengan parameter id customer
    function getCustomerByID($id_customer){
        $core = Core::getInstance();
        if ($stmt = $core->dbh->prepare("SELECT id_customer, username, first_name, last_name, email_address, password, handphone_number, digital_certificate FROM customer WHERE id_customer = :id_customer LIMIT 1")) {
            $stmt->bindParam(':id_customer', $id_customer);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if($stmt->rowCount() == 1){
                $id_customer = $row[0];
                $username = $row[1];
                $first_name = $row[2];
                $last_name = $row[3];
                $email_address = $row[4];
                $password = $row[5];
                $handphone_number = $row[6];
                $digital_certificate = $row[7];

                $customer = new Customer($id_customer, $username, $first_name, $last_name, $email_address, $password, $handphone_number, $digital_certificate);
                return $customer;
            }
            else{
                return null;
            }
        }
        else{
            exit();
        }

    }

    /**function login_check() {
        $core = Core::getInstance();

        // Check if all session variables are set
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];

            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            if ($stmt = $core->dbh->prepare("SELECT password FROM account WHERE id_account = :id LIMIT 1")) {
                // Bind "$user_id" to parameter.
                $stmt->bindParam(':id', $user_id);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    while($row=$stmt->fetch()){
                        $db_password=$row['password'];
                    }

                    $login_check = hash('sha256', $db_password . $user_browser);

                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                exit();
            }
        } else {
            // Not logged in
            return false;
        }
    }

    function sec_session_start() {
        $session_name = 'sec_session_id';
        $secure = false;
        $httponly = true;

        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            echo "Could not initiate a safe session (ini_set)";
            exit();
        }

        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

        session_name($session_name);

        session_start();
        session_regenerate_id();
    }

    if ($stmt = $core->dbh->prepare("SELECT id_user, email_address, password FROM account WHERE email_address = :email_address LIMIT 1")) {
            $stmt->bindParam(':email_address', $email);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_NUM);

            foreach($row as $row){
                $id_user=$row[0];
                $email_address=$row[1];
                $password=$row[2];
            }

            //$password = hash('sha256', $password . $salt);

            if ($stmt->rowCount() == 1) {
                    if ($tempPassword == $password) {
                        // Password is correct!
                        // Get the user-agent string of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];

                        // XSS protection as we might print this value
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION['user_id'] = $user_id;

                        // XSS protection as we might print this value
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                        $_SESSION['username'] = $username;
                        $_SESSION['login_string'] = hash('sha256', $password . $user_browser);

                        // Login successful.
                        return true;
                    } else {

                        return false;
                    }

            } else {
                return false;
            }
        } else {
            exit();
        }
    **/
?>
