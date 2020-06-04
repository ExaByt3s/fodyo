<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

IncludeTemplateLangFile(__FILE__);

//print_r($_REQUEST);

if($_REQUEST['name'] != ''){
	$arEventFields['NAME'] = $_REQUEST['name'];
}
if($_REQUEST['email'] != ''){
	$arEventFields['EMAIL'] = $_REQUEST['email'];
}
if(!is_numeric($phone)){
	echo GetMessage('ERROR_NOT_NUMBER');
	exit();
}else{
	$arEventFields['PHONE_NUMBER'] = $_REQUEST['phone'];
	$arEventFields['PAGE_URL'] = $_REQUEST['CURDIR'];
	$arrSITE =  SITE_ID;
	if(CEvent::Send("SEND_ZAYAVKA_".strtoupper(LANGUAGE_ID), $arrSITE, $arEventFields)){
		echo "Success";
	}
}
