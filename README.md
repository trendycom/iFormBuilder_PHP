iFormBuilder_PHP
================

PHP SDK for accessing iFormBuilder API

	$iFormBuilder = iFormBuilder::Instance();

	$iFormBuilder->clientId = '<Your Client Id>';
	$iFormBuilder->refreshToken = '<Your Refresh Token';
	$iFormBuilder->serverURL = 'https://<Server Name>.iformbuilder.com';

	//Create a new Page
	$p = new ZCPage(155920,0); /*profileId, pageId*/
	$p->NAME = 'new_test_page';
	$p->LABEL = 'New Test Page';
	$p->create();
	echo print_r($p);

	//Get an Element
	$e = new ZCElement(11326,148052,6702919); /*profileId, pageId, elementId*/
	$e->get();
	echo print_r($e);

	//Get All Option Lists
	$o = ZCOptionList::getAllinProfile(155920);
	echo print_r($o);

	//Get a particular Option List
	$o = new ZCOptionList(155920, 222501);
	$o->get();
	echo print_r($o);

	//Delete all Pages in a profile
	$o = ZCPage::getAllinProfile(155920);
	$pages = $o['PAGES'];
	foreach ($pages as $p){
		$page = new ZCPage(155920,$p['ID']);
		$r = $page->delete();
		echo print_r($r);
	}

	//Get all users in a profile
	$allUsers = ZCUser::getAllinProfile(155920);
	print_r($allUsers);

	//Get User ID by User Name
	$u = ZCUser::getUserByName(155920,'arcTest');
	print_r($u);

	//Create a new user
	$u = new ZCUser(155920,0);
	$u->USERNAME = 'aNewUser';
	$u->PASSWORD = 'aPassword';
	$u->FIRSTNAME = 'First Name';
	$u->LASTNAME = 'Last Name';
	$u->EMAIL = 'f@zerionsoftware.com';
	$u->ROLE = 1;
	$o = $u->create();
	print_r($o);

	//Get all profiles in a server
	$p = ZCProfile::getAllProfiles();
	print_r($p);

