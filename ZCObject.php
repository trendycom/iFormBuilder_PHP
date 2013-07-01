<?php
abstract class ZCObject {

	public function __construct(){
	}

	/**
	 * Take a JSON object from the server, populate a PHP object.
	 * the function assumes all IDs are in the JSON object.
	 * For example, the ZCPage object should have Page['PROFILE_ID'] and Page['PAGE_ID'].
	 * For ZCElement, there should be Element['PROFILE_ID'], Element['PAGE_ID'] and Element['ID'].
	 */
	abstract public static function fromServerObj($p);
	
	/**
	 * Internally used function to populate from JSON to PHP. 
	 * The internal version assumes all IDs are set in the object already.
	 * Use during get operation.
	 */
	abstract protected function populateFromServerObj($p);
	
	/**
	 * Get, or load the object from the server
	 * first create a PHP object with the right IDs then call this function
	 * to populate the rest
	 *
	 * example: $p = new ZCPage(23445,0); //Profile Id, Page Id
	 * $p->get();
	 */
	abstract public function get();
	
	/**
	 * Create the local PHP object on the server
	 * The returning ID will be assigned to the object.
	 * First, create the object with 0 as the ID, then populate the other attributes.
	 * Then call create() on the object.
	 *
	 */
	abstract public function create();
	
	
	abstract public function edit();
	abstract public function delete();
	
	
	
}

?>