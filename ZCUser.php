<?php
class ZCUser extends ZCObject{
	
	public function __construct($_profileId, $_userId){
		parent::__construct(); 
		
		$this->PROFILE_ID = $_profileId;
		$this->USER_ID = $_userId;
		$this->FIRSTNAME = '';
		$this->LASTNAME = '';
		$this->EMAIL = '';
		$this->IS_ACTIVE = 0;
		$this->ROLE = 0;
		$this->CREATED_DATE = NULL;
		$this->HEARTBEAT = '';
	}
	
	public static function fromServerObj($p){
		$_profileId = $p['PROFILE_ID'];
		$_userId = $p['ID'];
		$instance = new ZCUser($_profileId, $_userId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
    
	public static function getAllInProfile($profileId){
		$api = "profiles/$profileId/users";
		//Sort by ID desc. So the newest is always the first.
		$p['SORT'] = 'ID';
		$p['SORT_BY'] = 'DESC';
		$params = http_build_query($p);
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		return $o;		
	}
	
	public static function getUserByName($profileId, $username){
		$api = "profiles/$profileId/users";
		$filters = array();
		$filter['KEY'] = 'USERNAME';
		$filter['CONDITION'] = '=';
		$filter['VALUE'] = $username;
		$filters[] = $filter;
		$p['FILTER'] = $filters;
		$params = http_build_query($p);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		
		//Assume one user.
		$users = $o['USERS'];
		$userid = 0;
		if (count ($users)>0) {
			$userid = $users[0]['ID'];
		}
		return $userid;
		
	}
	
	

	protected function populateFromServerObj($p){
		if (isset($p['USERNAME'])) $this->USERNAME  = $p['USERNAME'];
		if (isset($p['FIRSTNAME'])) $this->FIRSTNAME = $p['FIRSTNAME'];
		if (isset($p['LASTNAME'])) $this->LASTNAME = $p['LASTNAME'];
		if (isset($p['EMAIL'])) $this->EMAIL = $p['EMAIL'];
		if (isset($p['IS_ACTIVE'])) $this->IS_ACTIVE = $p['IS_ACTIVE'];
		if (isset($p['ROLE'])) $this->ROLE = $p['ROLE'];
		if (isset($p['CREATED_DATE'])) $this->CREATED_DATE = $p['CREATED_DATE'];
		if (isset($p['HEARTBEAT'])) $this->HEARTBEAT = $p['HEARTBEAT'];
	}

	public function get(){
		$api = "profiles/$this->PROFILE_ID/users/$this->USER_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'GET');
		$p = $o;
		$this->populateFromServerObj($p);
		
	}

	public function create(){
		$api = "profiles/$this->PROFILE_ID/users/$this->USER_ID";
		$params = json_encode($this);
		
		echo "\n".$params."\n";
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		if ($o['STATUS']==1) $this->USER_ID = $o['USER_ID'];
		return $o;
	}
	
	public function edit(){
		$api = "profiles/$this->PROFILE_ID/users/$this->USER_ID";
		$params = json_encode($this);
		
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'POSTJ');
		return $o;	
	}
	
	public function delete(){
		$api = "profiles/$this->PROFILE_ID/users/$this->USER_ID";
		$params = '';
		$ifb = iFormBuilder::Instance();
		$o = $ifb->sendApiRequest($api, $params, 'DELETE');
		
		return $o;
	}
	
	

}
?>