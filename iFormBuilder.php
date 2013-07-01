<?php
/**
 * This is a singleton class for the iFormBuilder API
 * All OAuth settings are to be configured with this class
 *
 */

require_once('ZCObject.php');
require_once('ZCPage.php');
require_once('ZCElement.php');
require_once('ZCOptionList.php');
require_once('ZCOption.php');
require_once('ZCUser.php');
require_once('ZCProfile.php');


class iFormBuilder {
	public static $ZC_ROLE_SCOPE_OWN = 1; //2^0
    public static $ZC_ROLE_SCOPE_COMPANY = 2; //2^1
    public static $ZC_ROLE_SCOPE_SERVER = 4; //2^2
    public static $ZC_ROLE_FORM = 32; //2^5
    public static $ZC_ROLE_ASSIGN = 256; //2^8
    public static $ZC_ROLE_USER = 512; //2^9
    public static $ZC_ROLE_DEL_RECORD = 1024; //2^10
    public static $ZC_ROLE_COMPANY_INFO = 2048; //2^11
    public static $ZC_ROLE_COMPANY_BILLING = 4096; //2^12
    public static $ZC_ROLE_RECORD_SYNC = 8192; //2^13
    public static $ZC_ROLE_PLUG_SYNC = 16384; //2^14

    public static $ZC_TYPE_TEXT                    =1;
    public static $ZC_TYPE_NUMBER                  =2;
    public static $ZC_TYPE_DATE                    =3;
    public static $ZC_TYPE_TIME                    =4;
    public static $ZC_TYPE_TIMESTAMP               =5;
    public static $ZC_TYPE_TOGGLE                  =6;
    public static $ZC_TYPE_SELECT                  =7;
    public static $ZC_TYPE_PICK_LIST               =8;
    public static $ZC_TYPE_MULTI_SELECT            =9;
    public static $ZC_TYPE_RANGE                   =10;
    public static $ZC_TYPE_IMAGE                   =11;
    public static $ZC_TYPE_SIGNATURE               =12;
    public static $ZC_TYPE_SOUND                   =13;
    public static $ZC_TYPE_LATLON                  =14;
    public static $ZC_TYPE_QRCODE                  =15;
    public static $ZC_TYPE_LABEL                   =16;
    public static $ZC_TYPE_DIVIDER                 =17;
    public static $ZC_TYPE_PAGE                    =18;
    public static $ZC_TYPE_TEXTAREA                =19;
    public static $ZC_TYPE_PHONE                   =20;
    public static $ZC_TYPE_SSN                     =21;
    public static $ZC_TYPE_EMAIL                   =22;
    public static $ZC_TYPE_ZIP                     =23;
    public static $ZC_TYPE_ASSIGN_TO               =24;
    public static $ZC_TYPE_UNIQUE_ID               =25;
    public static $ZC_TYPE_BARCODE                 =26;
    public static $ZC_TYPE_PAYLEAP                 =27;
    public static $ZC_TYPE_DRAWING                 =28;
    public static $ZC_TYPE_VISIBLE_TAG             =29;
    public static $ZC_TYPE_LINEA_PRO_MS            =30;
    public static $ZC_TYPE_RFID                    =31;
    public static $ZC_TYPE_ATTACHMENT              =32;
    public static $ZC_TYPE_READONLY_VALUE          =33;
    public static $ZC_TYPE_IDBLUE_SIM              =34;  // This is used only for IDBlue Simulator.  
    public static $ZC_TYPE_IMAGE_LABEL             =35;
    public static $ZC_TYPE_IMAGE_SELECT            =36; // This is not used on Server or FormBuilder, client-only.  
    public static $ZC_TYPE_LOCATION                =37;
	
	public static $clientId;
	public static $refreshToken;
	public static $serverURL;
	
	private static $accessToken;

	public static function Instance(){
        static $inst = null;
        if ($inst === null) {
            $inst = new iFormBuilder();
        }
        return $inst;
    }

	public static function safeName($name){
		$name = strtolower($name);

	    $replace = array('([\40])','([^a-zA-Z0-9_])','(-{2,})');
	    $with = array('_','','_');
	    $name = preg_replace($replace,$with,$name);

		return $name;
	}

	public static function printOutput($obj) {
		echo "<pre style='font-size:11px;'>";
		print_r($obj);
		echo "</pre>";
	}
	
	
    
    /**
     * Private constructor to prevent the outside world from creating instances.
     */    
    private function __construct(){
		$this->clientId = '';
		$this->refreshToken = '';
		$this->serverURL = '';
		$this->accessToken = '';
		$this->version = '5.1';
    }
 
	private function sendRequest($url,$params,$method) {
		/*
		echo "<!--";
		echo "\n";
		echo "$url\n";
		echo "$params\n";
		echo "\n";
		echo "-->";
		*/
	if ($method=="GET") {
		$ch = curl_init("$url?$params");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	else if ($method=="POST") {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	else if ($method=="POSTJ") {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //params should be JSON String
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($params),
			'Authorization: Bearer '.$this->accessToken,
			'X-IFORM-API-REQUEST-ENCODING: JSON',
			'X-IFORM-API-VERSION: '.$this->version)                                                                       
		);                                                                                                                   
		
	}
	else if ($method=="PUT") {
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $params);
		rewind($fh);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, strlen($params));
		curl_setopt($ch, CURLOPT_PUT, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	else if ($method=="DELETE") {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	else
		throw new Exception("Method-$method not recognized");

	$json = curl_exec($ch);
	curl_close($ch);

	return json_decode($json,true);
	}

	private function getAccessToken(){
		if ($this->accessToken==''){ //Empty or expired...
			$endpoint = $this->serverURL.'/exzact/api/oauth/token';
			$params = "code=$this->refreshToken&client_id=$this->clientId&grant_type=refresh_token";
			$o = $this->sendRequest($endpoint, $params, 'POST');
			$this->accessToken = $o['access_token'];
		}
		return $this->accessToken;
	}
	
	public function sendApiRequest($api, $params, $method){
		$this->getAccessToken();
		$endpoint = $this->serverURL.'/exzact/api/'.$api;
		if ($method!='POSTJ') {
			$params = $params."&ACCESS_TOKEN=$this->accessToken&VERSION=$this->version";
		}
		
		$o = $this->sendRequest($endpoint, $params, $method);
		return $o;
	}

	
}