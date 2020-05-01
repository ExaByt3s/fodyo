<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("sitemap");
?><?$APPLICATION->IncludeComponent("bitrix:main.map", "template1", Array(
	"CACHE_TIME" => "3600",	// Cache time (sec.)
		"CACHE_TYPE" => "A",	// Cache type
		"COL_NUM" => "1",	// Number of columns
		"LEVEL" => "5",	// Maximum number of nested levels (0 - no nested levels)
		"SET_TITLE" => "Y",	// Set page title
		"SHOW_DESCRIPTION" => "N",	// Show descriptions
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>