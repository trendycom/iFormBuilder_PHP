<?php

class ZCElement extends ZCObject{
	
	
	public function __construct($_profileId, $_pageId, $_elementId){
		parent::__construct(); 
		
		$this->PROFILE_ID = $_profileId;
		$this->PAGE_ID = $_pageId;
		$this->ID = $_elementId;
		$this->NAME = '';
		$this->LABEL = '';
		$this->DESCRIPTION = '';
		$this->DATA_TYPE = 1;
		$this->DATA_SIZE = 10;
		$this->WIDGET_TYPE = 0;
		$this->SORT_ORDER = 0;
		$this->OPTIONLIST_ID = 0;
		$this->LOW_VALUE = 0;
		$this->HIGH_VALUE = 0;
		$this->DYNAMIC_VALUE = '';
		$this->CONDITION_VALUE = '';
		$this->IS_REQUIRED = 0;
		$this->CLIENT_VALIDATION = '';
		$this->IS_DISABLED = 0;
		$this->REFERENCE_ID_1 = '';
		$this->REFERENCE_ID_2 = '';
		$this->REFERENCE_ID_3 = '';
		$this->REFERENCE_ID_4 = '';
		$this->REFERENCE_ID_5 = '';
		$this->ATTACHMENT_LINK = NULL;
		$this->IS_READONLY = 0;
		$this->VALIDATION_MESSAGE = '';
		$this->IS_ACTION = 0;
		$this->SMART_TBL_SEARCH = '';
		$this->SMART_TBL_SEARCH_COL = '';
		$this->IS_ENCRYPT = 0;
		$this->IS_HIDE_TYPING = 0;
	}	
	
	public static function fromServerObj($p){
		$_profileId = $p['PROFILE_ID'];
		$_pageId = $p['PAGE_ID'];
		$_elementId = $p['ID'];
		$instance = new ZCElement($_profileId, $_pageId, $_elementId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
	protected function populateFromServerObj($p){
		if (isset($p['NAME'])) $this->NAME  = $p['NAME'];
		if (isset($p['LABEL'])) $this->LABEL = $p['LABEL'];
		if (isset($p['DESCRIPTION'])) $this->DESCRIPTION = $p['DESCRIPTION'];
		if (isset($p['VERSION'])) $this->VERSION = $p['VERSION'];
		if (isset($p['CREATED_DATE'])) $this->CREATED_DATE = $p['CREATED_DATE'];
		if (isset($p['CREATED_BY'])) $this->CREATED_BY = $p['CREATED_BY'];
		if (isset($p['MODIFIED_DATE'])) $this->MODIFIED_DATE = $p['MODIFIED_DATE'];
		if (isset($p['MODIFIED_BY'])) $this->MODIFIED_BY = $p['MODIFIED_BY'];
		if (isset($p['DATA_TYPE'])) $this->DATA_TYPE = $p['DATA_TYPE'];
		if (isset($p['DATA_SIZE'])) $this->DATA_SIZE = $p['DATA_SIZE'];
		if (isset($p['WIDGET_TYPE'])) $this->WIDGET_TYPE = $p['WIDGET_TYPE'];
		if (isset($p['OPTIONLIST_ID'])) $this->OPTIONLIST_ID = $p['OPTIONLIST_ID'];
		if (isset($p['HIGH_VALUE'])) $this->HIGH_VALUE = $p['HIGH_VALUE'];
		if (isset($p['LOW_VALUE'])) $this->LOW_VALUE = $p['LOW_VALUE'];
		if (isset($p['CONDITION_VALUE'])) $this->CONDITION_VALUE = $p['CONDITION_VALUE'];
		if (isset($p['DYNAMIC_VALUE'])) $this->DYNAMIC_VALUE = $p['DYNAMIC_VALUE'];
		if (isset($p['IS_REQUIRED'])) $this->IS_REQUIRED = $p['IS_REQUIRED'];
		if (isset($p['CLIENT_VALIDATION'])) $this->CLIENT_VALIDATION = $p['CLIENT_VALIDATION'];
		if (isset($p['IS_DISABLED'])) $this->IS_DISABLED = $p['IS_DISABLED'];
		if (isset($p['REFERENCE_ID_1'])) $this->REFERENCE_ID_1 = $p['REFERENCE_ID_1'];    
		if (isset($p['REFERENCE_ID_2'])) $this->REFERENCE_ID_2 = $p['REFERENCE_ID_2'];    
		if (isset($p['REFERENCE_ID_3'])) $this->REFERENCE_ID_3 = $p['REFERENCE_ID_3'];    
		if (isset($p['REFERENCE_ID_4'])) $this->REFERENCE_ID_4 = $p['REFERENCE_ID_4'];    
		if (isset($p['REFERENCE_ID_5'])) $this->REFERENCE_ID_5 = $p['REFERENCE_ID_5'];    
		if (isset($p['ATTACHMENT_LINK'])) $this->ATTACHMENT_LINK = $p['ATTACHMENT_LINK'];    
		if (isset($p['IS_READONLY'])) $this->IS_READONLY = $p['IS_READONLY'];    
		if (isset($p['VALIDATION_MESSAGE'])) $this->VALIDATION_MESSAGE = $p['VALIDATION_MESSAGE'];    
		if (isset($p['IS_ACTION'])) $this->IS_ACTION = $p['IS_ACTION'];    
		if (isset($p['SMART_TBL_SEARCH'])) $this->SMART_TBL_SEARCH = $p['SMART_TBL_SEARCH'];    
		if (isset($p['SMART_TBL_SEARCH_COL'])) $this->SMART_TBL_SEARCH_COL = $p['SMART_TBL_SEARCH_COL'];    
		if (isset($p['IS_ENCRYPT'])) $this->IS_ENCRYPT = $p['IS_ENCRYPT'];    
		if (isset($p['IS_HIDE_TYPING'])) $this->IS_HIDE_TYPING = $p['IS_HIDE_TYPING'];    
		if (isset($p['ON_CHANGE'])) $this->ON_CHANGE = $p['ON_CHANGE'];    
		if (isset($p['SORT_ORDER'])) $this->SORT_ORDER = $p['SORT_ORDER'];
		if (isset($p['KEYBOARD_TYPE'])) $this->KEYBOARD_TYPE = $p['KEYBOARD_TYPE'];
		if (isset($p['STATUS'])) $this->STATUS = $p['STATUS'];
	}
	
	public function get(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID/elements/$this->ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$p = $ifb->sendApiRequest($api, $params, 'GET');
		$this->populateFromServerObj($p);
	}
	
	public function create(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID/elements";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		if ($o['STATUS']==1) $this->ID = $o['ELEMENT_ID'];
		return $o;
	}
	
	public function edit(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID/elements/$this->ID";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		return $o;	
	}
	
	public function delete(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID/elements/$this->ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'DELETE');
		
		return $o;
	}
	
	
}

?>