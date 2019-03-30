<?php
/** 
 * This script will add a contact if the contacts is new, or update the contact's 
 * information if they already exist. 
 * 
 * @copyright Copyright (c) 2018 Bronto Software (http://www.bronto.com) 
 */

$client = new SoapClient('https://api.bronto.com/v4?wsdl', array(
    'trace' => 1,
    'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));

try {
    // Add in a valid API token
    $token = "ADD YOUR TOKEN HERE";
    
    print "logging in\n";
    $sessionId = $client->login(array(
        'apiToken' => $token
    ))->return;
    
    $session_header = new SoapHeader("http://api.bronto.com/v4", 'sessionHeader', array(
        'sessionId' => $sessionId
    ));
    $client->__setSoapHeaders(array(
        $session_header
    ));
    
    // Replace SOME CONTENT with a string. We assume here
    // the field is storing a string. The value you pass in
    // should match the type set for the field.
    // Replace SOME FIELD ID with a valid field ID. Field IDs
    // can be obtained by calling readFields. Field IDs are also
    // available in the footer when viewing an individual field in
    // the UI.
    $field1 = array(
        'fieldId' => 'SOME FIELD ID',
        'content' => 'SOME CONTENT'
    );
    $field2 = array(
        'fieldId' => 'SOME FIELD ID',
        'content' => 'SOME CONTENT'
    );
    
    // Note: The lists you set in this call will be absolute, not 
    // incremental, to lists the contact may already be on. The contact 
    // will be removed from any list(s) not specified in this call and 
    // will only be added to lists you specify in this call. If your intent 
    // is to incrementally add a contact to a list without affecting their 
    // membership on other lists, use the addToList function. If you want to 
    // incrementally remove a contact from a list, use the removeFromList 
    // function. If you want to use this call to incrementally add the contact 
    // to a new list and retain their current list membership, you'll need to 
    // call readContacts, obtain the ids for the lists the contact is currently 
    // a member of, and pass in those ids along with the new list ids when
    // calling updateContacts.
    $contacts = array(
        'email' => 'EMAIL ADDRESS',
        'listIds' => 'LIST ID',
        'fields' => array(
            $field1,
            $field2
        ),
        'customSource' => 'source'
    );
    
    print "Adding contact with the following attributes\n";
    $write_result = $client->addOrUpdateContacts(array(
        $contacts
    ))->return;
    
    if ($write_result->errors) {
        print "There was a problem adding or updating the contact:\n";
        print_r($write_result->results);
    } elseif ($write_result->results[0]->isNew == true) {
        print "The contact has been added.  Contact Id: " . $write_result->results[0]->id . "\n";
    } else {
        print "The contact's information has been updated.  Contact Id: " . $write_result->results[0]->id . "\n";
    }
    
}
catch (Exception $e) {
    print "uncaught exception\n";
    print_r($e);
}
?>