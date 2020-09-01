<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
    }
}

    function op($data){
        echo "<pre>";
        print_r($data);
    }
    function opd($data){
        echo "<pre>";
        print_r($data);
        die();
    }

/**
 * Api Class
 */
    session_start();
    require_once "./database.php";
    // include_once './barcode128.php';

    class Model extends Database {
        public function __construct(){
            parent::__construct();

            $this->getUsernamesListener();
            $this->registerUserListener();
            $this->loginListener();
            $this->addProductListener();
            $this->getProductsListener();
            $this->deleteProductListener();
            $this->updateProductListener();
            $this->uploadProductImageListener();
            $this->buyItemsListener();
        }

        public function buyItemsListener(){
            if(isset($_POST['buyItems'])){
                $cartItems = json_decode($_POST['items']);
                $values = array();
                $sql = "
                    INSERT INTO sales(transaction_id,itemid,qty,srp)
                    VALUES
                ";

                $transactionId = $this->addTransaction($_POST);

                foreach($cartItems as $idx => $item){
                    $cartItem = (array) $item;
                    $values[] = "(". $transactionId . "," . $cartItem['id'] . ",". $cartItem['qty'] . "," . $cartItem['srp'] .")";

                    $this->deductQuantity($cartItem);
                }

                $sql .= implode(",",$values);

                $this->db->prepare($sql)->execute();

                die(json_encode(true));
            }
        }

        public function deductQuantity($item){
            $sql = "
                UPDATE product
                SET qty = qty - ?
                WHERE id = ?
            ";

            $this->db->prepare($sql)->execute(array($item['qty'], $item['id']));
        }

        public function addTransaction($data){
            $sql = "
                INSERT INTO transaction(userid,total)
                VALUES(?,?)
            ";

            $this->db->prepare($sql)->execute(array($data['userid'], $data['total']));

            return $this->db->lastInsertId();
        }

        public function uploadProductImageListener(){
            if(isset($_FILES["file"])){
                $filetype = explode(".",$_FILES['file']['name']);
                $filename = md5($_FILES['file']['name']).".".end($filetype);

                if(move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$filename)){
                    die(json_encode(array("filename" => $filename)));
                } else {
                    die(json_encode(array("filename" => false)));

                }
            }
        }

        public function getFilename($file){
            $file = explode("/", $file);

            return end($file);
        }

        public function updateProductListener(){
            if(isset($_POST['updateProduct'])){
                $sql = "
                    UPDATE product
                    SET name = ?, qty = ?, photo = ?, base_price = ?, srp = ?
                    WHERE id = ?
                ";

                $filename = $this->getFilename($_POST['photo']);

                $this->db->prepare($sql)->execute(array($_POST['name'], $_POST['qty'],$filename,$_POST['base'], $_POST['srp'], $_POST['id']));

                die(json_encode(array(true)));
            }
        }

        public function deleteProductListener(){
            if(isset($_GET['deleteProduct'])){
                $sql = "
                    UPDATE product
                    SET deleted = 1
                    WHERE id = ?
                ";

                $this->db->prepare($sql)->execute(array($_GET['id']));

                die(true);
            }
        }

        public function getProductsListener(){
            if(isset($_GET['getProducts'])){
                $sql = "
                    SELECT *
                    FROM product
                    WHERE deleted = 0
                    ORDER BY date_created DESC
                    LIMIT 7
                ";

                $record = $this->db->query($sql)->fetchAll();

                die(json_encode($record));
            }
        }

        public function addProductListener(){
            if(isset($_POST['addProduct'])){
                // check if products exists
                $errors = array();

                if($_POST['qty'] < 0){
                    $errors[] = "Invalid Quantity.";
                }

                if( $this->checkIfProductExists($_POST['name'])){
                    $errors[] = "Product already exists.";
                }

                if(count($errors) == 0){
                    $sql = "
                        INSERT INTO product(name,qty,base_price,srp)
                        VALUES(?,?,?,?)
                    ";

                    $this->db->prepare($sql)->execute(array($_POST['name'], $_POST['qty'], $_POST['base'], $_POST['srp']));
                    
                    die(json_encode(array("added"=>true)));
                }

                die(json_encode(array("added"=>false, "errors"=>$errors)));
            }
        }

        public function checkIfProductExists($name){
            $sql = "
                SELECT name
                FROM product
                WHERE name = '".$name."'
                LIMIT 1
            ";

            $record = $this->db->query($sql)->fetchAll();

            return count($record);
        }

        public function loginListener(){
            if(isset($_POST['login'])){
                $record = $this->checkAccount($_POST);

                if(count($record)){
                    $data = array(
                        "found" => true
                        , "id" => $record[0]['id']
                        , "username" => $record[0]['username']
                        , "type" => $record[0]['type']
                    );

                    die(json_encode($data));
                }

                die(json_encode(array("found" => false)));
            }
        }

        public function checkAccount($data){
            $sql = "
                SELECT *
                FROM user
                WHERE username = '".$data['username']."'
                AND password = '".md5($data['password'])."'
                LIMIT 1
            ";

            return $this->db->query($sql)->fetchAll();
        }

        public function registerUserListener(){
            if(isset($_POST['registerUser'])){
                $sql = "
                    INSERT INTO user(username, password)
                    VALUES(?,?)
                ";

                $this->db->prepare($sql)->execute(array($_POST['username'], md5($_POST['password'])));

                $res = Array("added" => true);

                die(json_encode($res));
            }
        }
        public function getUsernamesListener(){
            if(isset($_GET['getUsernames'])){
                $sql = "SELECT username FROM user";
                
                $records = $this->db->query($sql)->fetchAll();

                die(json_encode($records));
            }
        }
        public function signUpListener(){
            if(isset($_POST['signup'])){
                
            }
        }
    }

    $model =  new Model();
?>