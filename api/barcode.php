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
    include_once './barcode128.php';

    class Barcode {
        public function __construct(){
            $this->generateBarcodeListener();
        }
        
        public function generateBarcodeListener(){
            if(isset($_POST['generateBarcode'])){
                for($i=1;$i<=$_POST['qty'];$i++){
                    echo "<p style='display:inline-block;'><span ><b>Item: ".$_POST['name']."</b></span>".bar128(stripcslashes($_POST['id']))."
                    <span ><b>Price: ".$_POST['srp']." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
                    
                }
            }
        }
    }

    $barcode =  new Barcode();

    ?>
    <style>
div.b128{
 border-left: 1px black solid;
 height: 30px;
} 
</style>

