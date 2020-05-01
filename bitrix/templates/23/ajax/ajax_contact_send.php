<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

IncludeTemplateLangFile(__FILE__);

if($_REQUEST['name'] != ''){
	$arEventFields['NAME'] = $_REQUEST['name'];
}
if($_REQUEST['text'] != ''){
	$arEventFields['TEXT'] = $_REQUEST['text'];
}
if(!is_numeric($phone)){
	echo GetMessage('ERROR_NOT_NUMBER');
	exit();
}else{
	$arEventFields['PHONE_NUMBER'] = $_REQUEST['phone'];
	$arrSITE =  SITE_ID;

	session_start();
	if($_REQUEST['captcha'] == $_SESSION['randomnr2']){ 
		if(CEvent::Send("SEND_CONTACTS_".strtoupper(LANGUAGE_ID), $arrSITE, $arEventFields)){
			echo "Success";
		}
	}else{
		echo "captchaError";
	}
}
