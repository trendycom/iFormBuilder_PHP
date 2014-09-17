<?php
class ZCOptionList extends ZCObject{
	
	public function __construct($_profileId, $_optionListId){
		parent::__construct(); 
		
		$this->PROFILE_ID = $_profileId;
		$this->OPTIONLIST_ID = $_optionListId;
		$this->NAME = '';
		$this->VERSION = 0;
		$this->CREATED_DATE = NULL;
		$this->CREATED_BY = NULL;
		$this->MODIFIED_DATE = NULL;
		$this->MODIFIED_BY = NULL;
		$this->IS_DOWNLOADABLE = 0;
		$this->REFERENCE_ID = NULL;
		$this->OPTION_ICONS_URL = NULL;
		$this->OPTIONS = array();
	}

	public static function fromServerObj($p){
		$_profileId = $p['PROFILE_ID'];
		$_optionListId = $p['OPTIONLIST_ID'];
		$instance = new ZCOptionList($_profileId, $_optionListId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
	public static function getAllinProfile($profileId){
		$api = "profiles/$profileId/optionlists";
		//Sort by ID desc. So the newest is always the first.
		$p['SORT'] = 'ID';
		$p['SORT_BY'] = 'DESC';
		$params = http_build_query($p);
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		return $o;
	}

	protected function populateFromServerObj($p){
		if (isset($p['NAME'])) $this->NAME  = $p['NAME'];
		if (isset($p['VERSION'])) $this->VERSION = $p['VERSION'];
		if (isset($p['CREATED_DATE'])) $this->CREATED_DATE = $p['CREATED_DATE'];
		if (isset($p['CREATED_BY'])) $this->CREATED_BY = $p['CREATED_BY'];
		if (isset($p['MODIFIED_DATE'])) $this->MODIFIED_DATE = $p['MODIFIED_DATE'];
		if (isset($p['MODIFIED_BY'])) $this->MODIFIED_BY = $p['MODIFIED_BY'];
		if (isset($p['IS_DOWNLOADABLE'])) $this->IS_DOWNLOADABLE = $p['IS_DOWNLOADABLE'];
		if (isset($p['REFERENCE_ID'])) $this->REFERENCE_ID = $p['REFERENCE_ID'];
		if (isset($p['OPTION_ICONS_URL'])) $this->OPTION_ICONS_URL = $p['OPTION_ICONS_URL'];
	}
	
	

	public function get(){
		$api = "profiles/$this->PROFILE_ID/optionlists/$this->OPTIONLIST_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		echo "Here".$this->OPTIONLIST_ID."\n";
		echo '[]';
		
		
		$p = $o['OPTIONLIST'];
		$this->populateFromServerObj($p);
		
		//Next populate options
		$eList = $o['OPTIONS'];
		foreach ($eList as $_e){
			$e = ZCOption::fromServerObj($_e);
			$this->OPTIONS[] = $e;
		}
	}
	
	public function create(){
		$api = "profiles/$this->PROFILE_ID/optionlists";
		$params = json_encode($this);
		
		echo "\n".$params."\n";
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		if ($o['STATUS']==1) $this->OPTIONLIST_ID = $o['OPTIONLIST_ID'];
		return $o;
	}

	public function edit(){
		$api = "profiles/$this->PROFILE_ID/optionlists/$this->OPTIONLIST_ID";
		$params = array( "NAME"=>$this->NAME, "OPTIONS"=>$this->OPTIONS);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, http_build_query($params), 'PUT');
		return $o;	
	}
	
	public function append($options){
		$api = "profiles/$this->PROFILE_ID/optionlists/$this->OPTIONLIST_ID/append";
		$params = json_encode($options);
		$this->OPTIONS = array_merge($this->OPTIONS, $options);
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, http_build_query($params), 'POSTJ');
		return $o;	
	}
	
	public function delete(){
		$api = "profiles/$this->PROFILE_ID/optionlists/$this->OPTIONLIST_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'DELETE');
		
		return $o;
	}
	
}

?>