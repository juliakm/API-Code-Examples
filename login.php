<?php
/**
 * This script will log you in and generate a session.
 *
 * @copyright  Copyright (c) 2018 Bronto Software
 */

$client = new SoapClient('https://api.bronto.com/v4?wsdl', array(
    'trace' => 1,
    'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));

try {
    
    // Add your API token
    $token = "ADD YOUR API TOKEN";
    
    $sessionId = $client->login(array(
        'apiToken' => $token
    ))->return;
    
    $session_header = new SoapHeader("http://api.bronto.com/v4", 'sessionHeader', array(
        'sessionId' => $sessionId
    ));
    $client->__setSoapHeaders(array(
        $session_header
    ));
    
    print "logging in with sessionId: $sessionId\n";
}
catch (Exception $e) {
    print "uncaught exception\n";
    print_r($e);
}
?>