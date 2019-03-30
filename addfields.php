<?php
/**
 * This script will add add fields to an account.
 *
 * @copyright  Copyright (c) 2018 Bronto Software (http://www.bronto.com)
 */
$client = new SoapClient('https://api.bronto.com/v4?wsdl', array(
    'trace' => 1,
    'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));
try {
    // Add your API token
    $token = "YOUR API KEY";
    print "logging in\n";
    $sessionId      = $client->login(array(
        'apiToken' => $token
    ))->return;
    $session_header = new SoapHeader("http://api.bronto.com/v4", 'sessionHeader', array(
        'sessionId' => $sessionId
    ));
    $client->__setSoapHeaders(array(
        $session_header
    ));
    // Adding a text field
    // Uncomment and comment out select $fieldObject to use
    // $fieldObject = array('name' => 'MY TEXT FIELD',
    //              "label" => 'MY FIELD TEXT LABEL',
    //              "type" => "text"
    //           );
    $optionGreen = array(
        'value' => 'green',
        "label" => "Green",
        'isDefault' => false
    );
    $optionBlue  = array(
        'value' => 'blue',
        "label" => "Blue",
        'isDefault' => false
    );
    $optionRed   = array(
        'value' => 'red',
        "label" => "Red",
        'isDefault' => true
    );
    //Adding a select option. The values are passed in the options array
    $fieldObject = array(
        'name' => 'MY SELECT FIELD',
        "label" => 'MY FIELD SELECT LABEL',
        "type" => "select",
        "options" => array(
            $optionGreen,
            $optionBlue,
            $optionRed
        )
    );
    print "Adding the field\n";
    $write_result = $client->addFields(array(
        'fields' => $fieldObject,
        'isVisibleInContactList' => false
    ))->return;
    if (isset($write_result->errors)) {
        print "There was a problem adding the field:\n";
        print_r($write_result->results);
    } else {
        print "The field has been added.  Id: " . $write_result->results[0]->id . "\n";
    }
}
catch (Exception $e) {
    print "uncaught exception\n";
    print_r($e);
}
?>