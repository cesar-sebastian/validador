<?php

ini_set('max_execution_time', 0);
ini_set("date.timezone", "America/Argentina/Buenos_Aires");

define('DS', DIRECTORY_SEPARATOR);
define('raiz', dirname(__FILE__));

if (!file_exists(raiz . DS . 'parameters.php')) {
    echo 'El archivo que contiene los parámetros de configuración no existe, por favor contactese con su proveedor de software';
    exit();
}

require_once dirname(__FILE__) . DS . 'parameters.php';

if (empty($ida) || empty($bkp) || empty($rta) || empty($logger) || empty($wsdl) || empty($method) || empty($frecuency)) {
    echo 'Hay parámetros que faltan definir en parameters.php';
    exit();
}

while (true) {
    launcher();
    sleep($frecuency);
}

function launcher() {
    //SGF facturador
    //STM *
    //SVC confluencia
    //folders
    GLOBAL $ida;
    GLOBAL $bkp;
    GLOBAL $rta;
    GLOBAL $logger;
    GLOBAL $wsdl;
    GLOBAL $method;

    foreach (glob($ida . DS . "*.xml") as $nombre_fichero) {
        $basename = basename($nombre_fichero);
        logger('(' . date('Y-m-d H:i:s') . ')' . 'Inicio Proceso: ' . $basename . PHP_EOL);
        //solicitud
        logger('(' . date('Y-m-d H:i:s') . ')' . 'Enviamos solicitud a SOAP' . PHP_EOL);
        if (!($fileRequest = file_get_contents($nombre_fichero, "r"))) {
            logger('(' . date('Y-m-d H:i:s') . ')' . 'Error al leer el archivo' . PHP_EOL);
        } else {
            //Proceso de bkp
            logger('(' . date('Y-m-d H:i:s') . ')' . 'Backapeamos el archivo' . PHP_EOL);
            if (!rename($nombre_fichero, $bkp . DS . $basename)) {
                logger('(' . date('Y-m-d H:i:s') . ')' . 'Error al backapear el archivo' . PHP_EOL);
            } else {
                logger('(' . date('Y-m-d H:i:s') . ')' . 'Solicitud' . PHP_EOL);
                $xmlFinal['Solicitud'] = "'".$fileRequest."'" ;
                $xmlResponse = callMethod($wsdl, $method, $xmlFinal);
                //Proceso de respuesta
                logger('(' . date('Y-m-d H:i:s') . ')' . 'Respuesta' . PHP_EOL . PHP_EOL);
                file_put_contents($rta . DS . $basename, $xmlResponse);
            }
        }
    }
}

function callMethod($wsdl, $method, $xmlRequest) {
    $options = array(
        "soap_version" => SOAP_1_2,
        "trace" => 1,
        //"encoding" => 'UTF-8',
        "exception" => 1,
        "features" => SOAP_SINGLE_ELEMENT_ARRAYS
    );

    $client = new \SoapClient($wsdl, $options);
    try {
        logger('(' . date('Y-m-d H:i:s') . ') Intento de conexión ' . PHP_EOL);
        $client->Execute($xmlRequest);    
        $xmlResponse = $client->__getLastResponse();
        $xmlResponse = str_replace('&lt;', '<', $xmlResponse);
        $xmlResponse = str_replace('&gt;', '>', $xmlResponse);        
        return $xmlResponse;
    } catch (\SoapFault $fault) {
        logger('(' . date('Y-m-d H:i:s') . ') faultcode: ' . $fault->faultcode . PHP_EOL . 'faultstring: ' . $fault->faultstring . PHP_EOL);
    }
}

function logger($txt) {
    GLOBAL $logger;
    if (!(file_put_contents(raiz . DS . $logger . DS . date("Y-m-d") . '_log.txt', $txt, FILE_APPEND))) {
        logger('(' . date('Y-m-d H:i:s') . ')' . 'Error al escribir log' . PHP_EOL);
    }
}

?>
