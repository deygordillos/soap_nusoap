<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        require_once APPPATH . 'libraries/nusoap/nusoap.php';
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("MyService", "urn:MyServices", "http://localhost/NuSoap/server/Services");
        
        $this->nusoap_server->register("getSumaNumbers", 
                array("firstNumber"  => "xsd:integer",
                      "secondNumber" => "xsd:integer"),
                array("return" => "xsd:string"),
                "urn:MyServices",
                "urn:MyServices#getSumaNumbers",
                "rpc",
                "encoded",
                "Obtener suma de dos números"
            );
    }
    
    public function index()
    {
        function getSumaNumbers($firstNumber = 0, $secondNumber = 0 ) {
            if (isset($firstNumber) && isset($secondNumber)) {
                $res = $firstNumber + $secondNumber;
            } else {
                $res = "Error: No ha enviado uno de los números";
            }
            return "La suma de $firstNumber + $secondNumber es: " . $res;
        }
        $HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        $this->nusoap_server->service($HTTP_RAW_POST_DATA);
    }
}
