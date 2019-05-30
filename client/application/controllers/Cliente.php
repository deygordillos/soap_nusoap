<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        require_once APPPATH . 'libraries/nusoap/nusoap.php';
        $Cliente = new nusoap_client("http://localhost/NuSoap/server/Services?wsdl");
        $error = $Cliente->getError();
 
        if ($error) {
            echo $error;
        } else {
            $res = $Cliente->call("getSumaNumbers", 
                    array("firstNumber" => 3,
                          "secondNumber" => 6)
                );
            if ($Cliente->fault) {
                echo "Ha fallado el servicio."; 
            } else {
                echo $res;
            }
        }
    }
}
