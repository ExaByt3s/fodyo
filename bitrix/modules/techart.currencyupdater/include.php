<?php

global $DB, $MESS, $APPLICATION;
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/filter_tools.php");

CModule::AddAutoloadClasses(
	"techart.currencyupdater",
	array(
		"CCurrencyUpdater" => "classes/general/currencyupdater.php",
		"CCurrencyRatesUpdater" => "classes/general/currencyupdater.php",
	)
);