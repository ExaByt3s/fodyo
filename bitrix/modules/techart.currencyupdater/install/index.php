<?php

class techart_currencyupdater extends CModule
{
	public $MODULE_ID = "techart.currencyupdater";
	public $MODULE_NAME = 'Обновление курсов валют';
	public $MODULE_DESCRIPTION;
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $PARTNER_NAME;
	public $PARTNER_URI;

	public function __construct()
	{
		global $DOCUMENT_ROOT;
		$this->MODULE_NAME = GetMessage('CURRENCYUPDATER_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('CURRENCYUPDATER_MODULE_DESCRIPTION');
		$this->MODULE_VERSION = '0.0.1';
		$this->MODULE_VERSION_DATE = '2018-01-22 10:00:00';
		$this->PARTNER_NAME = "Techart";
		$this->PARTNER_URI = "https://www.techart.ru";
	}

	public function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		RegisterModule($this->MODULE_ID);

		$this->CreateAgent();

		$APPLICATION->IncludeAdminFile(GetMessage('CURRENCYUPDATER_INSTALL_TITLE'), $DOCUMENT_ROOT.'/bitrix/modules/techart.currencyupdater/install/step1.php');

	}

	public function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		UnRegisterModule($this->MODULE_ID);

		$this->DeleteAgent();

		$APPLICATION->IncludeAdminFile(GetMessage('CURRENCYUPDATER_UNINSTALL_TITLE'), $DOCUMENT_ROOT.'/bitrix/modules/techart.currencyupdater/install/unstep1.php');


	}

	public function CreateAgent()
	{
		CAgent::AddAgent(
			'CCurrencyRatesUpdater::UpdateCurrencyRates();',
			'techart.currencyupdater',
			'Y',
			60,
			"",
			'Y',
			'',
			0
		);
	}

	public function DeleteAgent()
	{
		CAgent::RemoveModuleAgents("techart.currencyupdater");
	}
}