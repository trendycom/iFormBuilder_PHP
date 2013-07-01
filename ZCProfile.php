<?php
class ZCProfile extends ZCObject{
	
	public function __construct($_profileId){
		parent::__construct(); 
		
		$this->PROFILE_ID = $_profileId;
		$this->VERSION = 0;
		$this->NAME = '';
		$this->ADDRESS1 = '';
		$this->ADDRESS2 = '';
		$this->CITY = '';
		$this->ZIP = '';
		$this->STATE = '';
		$this->COUNTRY = '';
		$this->PHONE = '';
		$this->FAX = '';
		$this->EMAIL = '';
		$this->MAXUSER = 0;
		$this->MAXPAGE = 0;
		$this->IS_ACTIVE = 0;
		$this->CREATED_DATE = '';
		$this->SUPPORT_HOURS  = 0;
		$this->TIME_ZONE = '';
	}
	
	public static function fromServerObj($p){
		$_profileId = $p['ID'];
		$instance = new ZCProfile($_profileId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
    
	public static function getAllProfiles(){
		$api = "profiles";
		//Sort by ID desc. So the newest is always the first.
		$p['SORT'] = 'ID';
		$p['SORT_BY'] = 'DESC';
		$params = http_build_query($p);
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		return $o;		
	}
	
	public static function getProfileByName($name){
		$api = "profiles";
		$filters = array();
		$filter['KEY'] = 'NAME';
		$filter['CONDITION'] = '=';
		$filter['VALUE'] = $name;
		$filters[] = $filter;
		
		$p['FILTER'] = $filters;
		$params = http_build_query($p);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		
		//Assume one profile.
		$profiles = $o['PROFILES'];
		$profileId = 0;
		if (count ($profiles)>0) {
			$profileId = $profiles[0]['ID'];
		}
		return $profileId;
		
	}
	
	

	protected function populateFromServerObj($p){
		if (isset($p['VERSION'])) $this->VERSION  = $p['VERSION'];
		if (isset($p['NAME'])) $this->NAME = $p['NAME'];
		if (isset($p['ADDRESS1'])) $this->ADDRESS1 = $p['ADDRESS1'];
		if (isset($p['ADDRESS2'])) $this->ADDRESS2 = $p['ADDRESS2'];
		if (isset($p['CITY'])) $this->CITY = $p['CITY'];
		if (isset($p['ZIP'])) $this->ZIP = $p['ZIP'];
		if (isset($p['STATE'])) $this->STATE = $p['STATE'];
		if (isset($p['COUNTRY'])) $this->COUNTRY = $p['COUNTRY'];
		if (isset($p['PHONE'])) $this->PHONE = $p['PHONE'];
		if (isset($p['FAX'])) $this->FAX = $p['FAX'];
		if (isset($p['EMAIL'])) $this->EMAIL = $p['EMAIL'];
		if (isset($p['MAXUSER'])) $this->MAXUSER = $p['MAXUSER'];
		if (isset($p['MAXPAGE'])) $this->MAXPAGE = $p['MAXPAGE'];
		if (isset($p['IS_ACTIVE'])) $this->IS_ACTIVE = $p['IS_ACTIVE'];
		if (isset($p['CREATED_DATE'])) $this->CREATED_DATE = $p['CREATED_DATE'];
		if (isset($p['SUPPORT_HOURS'])) $this->SUPPORT_HOURS = $p['SUPPORT_HOURS'];
		if (isset($p['TIME_ZONE'])) $this->TIME_ZONE = $p['TIME_ZONE'];
	}

	public function get(){
		$api = "profiles/$this->PROFILE_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		$p = $o;
		$this->populateFromServerObj($p);
		
	}

	public function create(){
		$api = "profiles/$this->PROFILE_ID";
		$params = json_encode($this);
		
		echo "\n".$params."\n";
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		if ($o['STATUS']==1) $this->PROFILE_ID = $o['PROFILE_ID'];
		return $o;
	}
	
	public function edit(){
		$api = "profiles/$this->PROFILE_ID";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		return $o;	
	}
	
	public function delete(){
		$api = "profiles/$this->PROFILE_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'DELETE');
		
		return $o;
	}
	
	

}
?>