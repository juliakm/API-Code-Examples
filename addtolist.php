<?php
/**
 * This script will incrementally add a contact to a list. The contact will not
 * be dropped from any lists that they have already joined. If you want to add a
 * contact to a list and remove the contact from any existing lists, use the
 * addOrUpdateContacts function. To remove a contact from a list without
 * altering membership to other lists, use the removeFromList function.
 *
 * @copyright Copyright (c) 2018 Oracle + Bronto Software (http://www.bronto.com)
 */

$client = new SoapClient('https://api.bronto.com/v4?wsdl', array(
    'trace' => 1,
    'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));
try {
    // Add your API token
    $token = "ADD YOUR API TOKEN";
    
    print "Logging in\n";
    $sessionId = $client->login(array(
        'apiToken' => $token
    ))->return;
    
    $session_header = new SoapHeader("http://api.bronto.com/v4", 'sessionHeader', array(
        'sessionId' => $sessionId
    ));
    $client->__setSoapHeaders(array(
        $session_header
    ));
    
    /**
     * $mailListObject is an array containing the list information.
     * You can pass the list id and/or the list name.
     * The list id is the unique id assigned to the list. You can obtain
     * the id for a list by calling readLists, or by looking at the footer
     * when viewing the overview page for an individual list in the application.
     * The list name is the internal name for your list. We recommend
     * using the list id instead of the list name to speed up your API calls.
     */
    
    // Example with both id and name included.
    $mailListObject = array(
        "id" => "LIST ID",
        "name" => "LIST NAME"
    );
    
    // Example with only list id.
    //$mailListObject = array("id" => "LIST ID");
    
    // Example with only internal name.
    //$mailListObject = array("name" => "LIST NAME");
    
    /** 
     * $contactObject is an array containing the contact information.
     * The contact API id is a unique identifier assigned to a contact.
     * You can find the contact API id for a contact by looking at the footer when
     * viewing the overview page for an individual contact in the application.
     * The contact email address can also be used as an id when adding contact(s).
     */
    
    // Example using both id and email.
    $contactObject = array(
        "id" => "CONTACT ID",
        "email" => "CONTACT EMAIL ADDRESS"
    );
    
    print "Adding the contact(s) to the list\n";
    
    // Example with id only.
    //$contactObject = array("id" => "CONTACT ID");
    
    // Example with email only.
    //$contactObject = array("email" => "CONTACT EMAIL ADDRESS");
    
    // Example with multiple contacts.
    // $contact1 = array("email" => "FIRST CONTACT EMAIL");
    // $contact2 = array("email" => "SECOND CONTACT EMAIL");
    // $contact3 = array("email" => "THIRD CONTACT EMAIL");
    // $contactObject = array($contact1, $contact2, $contact3);
    
    $write_result = $client->addToList(array(
        'list' => $mailListObject,
        'contacts' => $contactObject
    ))->return;
    
    if ($write_result->errors) {
        print "There was a problem adding the contact(s) to the list:\n";
        print_r($write_result->results);
    } else {
        print "The contact(s) have been added.\n";
    }
}
catch (Exception $e) {
    print "uncaught exception\n";
    print_r($e);
}
?>