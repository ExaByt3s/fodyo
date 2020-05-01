<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("fotorama-test");
?><?$APPLICATION->IncludeComponent(
	"htc:fotoramabx",
	"",
	Array(
		"ALLOW_FULLSCREEN" => "true",
		"AUTOPLAY" => "0",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHANGE_HASH" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"IBLOCK_ID" => "4",
		"LAZY_LOAD" => "N",
		"LOOP" => "Y",
		"NAVIGATION_POSITION" => "top",
		"NAVIGATION_STYLE" => "false",
		"SHOW_ARROWS" => "Y",
		"SHOW_CAPTION" => "N",
		"SHUFFLE" => "N",
		"SOURCE_ID" => "17",
		"SOURCE_TYPE" => "iblock_section",
		"TRANSITION_EFFECT" => "slide"
	)
);?>Text here....<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>