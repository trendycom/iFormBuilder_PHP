<?php

class ZCPage extends ZCObject{
	
	public function __construct($_profileId, $_pageId){
		parent::__construct(); 
		
		$this->PROFILE_ID = $_profileId;
		$this->PAGE_ID = $_pageId;
		$this->NAME = '';
		$this->LABEL = '';
		$this->DESCRIPTION = '';
		$this->REFERENCE_ID_1 = '';
		$this->REFERENCE_ID_2 = '';
		$this->REFERENCE_ID_3 = '';
		$this->REFERENCE_ID_4 = '';
		$this->REFERENCE_ID_5 = '';
		//$this->ICON = '';
		$this->SORT_ORDER = 1;
		$this->JAVASCRIPT = '';
		//$this->LABEL_ICONS_URL = '';
		$this->ELEMENTS = array();
		
	}

	public static function fromServerObj($p){
		$_profileId = $p['PROFILE_ID'];
		$_pageId = $p['PAGE_ID'];
		$instance = new ZCPage($_profileId, $_pageId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
    
	public static function getAllInProfile($profileId){
		$api = "profiles/$profileId/pages";
		//Sort by ID desc. So the newest is always the first.
		$p['SORT'] = 'ID';
		$p['SORT_BY'] = 'DESC';
		$params = http_build_query($p);
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		return $o;		
	}
	
	public function pageAssignment($assignTo, $isCollect, $isView){
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
		if (isset($p['_S_ICON_LINK'])) $this->ICON = $p['_S_ICON_LINK'];
		if (isset($p['SORT_ORDER'])) $this->SORT_ORDER = $p['SORT_ORDER'];
		if (isset($p['PAGE_TYPE'])) $this->PAGE_TYPE = $p['PAGE_TYPE'];
		if (isset($p['REFERENCE_ID_1'])) $this->REFERENCE_ID_1 = $p['REFERENCE_ID_1'];    
		if (isset($p['REFERENCE_ID_2'])) $this->REFERENCE_ID_2 = $p['REFERENCE_ID_2'];    
		if (isset($p['REFERENCE_ID_3'])) $this->REFERENCE_ID_3 = $p['REFERENCE_ID_3'];    
		if (isset($p['REFERENCE_ID_4'])) $this->REFERENCE_ID_4 = $p['REFERENCE_ID_4'];    
		if (isset($p['REFERENCE_ID_5'])) $this->REFERENCE_ID_5 = $p['REFERENCE_ID_5'];    
	}
	
	public function get(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		$p = $o['PAGE'];
		$this->populateFromServerObj($p);
		
		//Next populate elements
		$eList = $o['ELEMENTS'];
		foreach ($eList as $_e){
			$_e->PROFILE_ID = $this->PROFILE_ID;
			$e = ZCElement::fromServerObj($_e);
			$this->ELEMENTS[] = $e;
		}
		
	}
	
	public function create(){
		$api = "profiles/$this->PROFILE_ID/pages";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		if ($o['STATUS']==1) $this->PAGE_ID = $o['PAGE_ID'];
		return $o;
	}
	
	public function edit(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		return $o;	
	}
	
	public function delete(){
		$api = "profiles/$this->PROFILE_ID/pages/$this->PAGE_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'DELETE');
		
		return $o;
	}
	


}

?>
