<?php
class ZCOption /*extends ZCObject */{ //ZCOption is actually no a ZCObject, just a value object.
	
	
	public function __construct($_optionListId, $_optionId){
		$this->OPTION_ID = $_optionId;
		$this->OPTION_LIST_ID = $_optionListId;
		$this->KEY_VALUE  = '';
		$this->LABEL = '';
		$this->SORT_ORDER = 0;
		$this->CONDITION_VALUE = '';
	}
	
	public static function fromServerObj($p){
		$_optionListId = $p['OPTION_LIST_ID'];
		$_optionId = $p['OPTION_ID'];
		$instance = new ZCOption($_optionListId, $_optionId);
		$instance->populateFromServerObj($p);
		return $instance;
	}
	
	protected function populateFromServerObj($p){
		if (isset($p['KEY_VALUE'])) $this->KEY_VALUE  = $p['KEY_VALUE'];
		if (isset($p['LABEL'])) $this->LABEL = $p['LABEL'];
		if (isset($p['SORT_ORDER'])) $this->SORT_ORDER = $p['SORT_ORDER'];
		if (isset($p['CONDITION_VALUE'])) $this->CONDITION_VALUE = $p['CONDITION_VALUE'];
	}
	
}
	

?>