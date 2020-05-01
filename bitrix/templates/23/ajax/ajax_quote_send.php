<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

IncludeTemplateLangFile(__FILE__);

if($_REQUEST['name'] != ''){
	$arEventFields['NAME'] = $_REQUEST['name'];
}
if(!is_numeric($phone)){
	echo GetMessage('ERROR_NOT_NUMBER');
	exit();
}else{
	$arEventFields['PHONE_NUMBER'] = $_REQUEST['phone'];
	$arEventFields['BANK'] = $_REQUEST['bankname'];
	$arrSITE =  SITE_ID;
	if(CEvent::Send("SEND_QUOTE_".strtoupper(LANGUAGE_ID), $arrSITE, $arEventFields)){
		echo "Success";
	}
}
