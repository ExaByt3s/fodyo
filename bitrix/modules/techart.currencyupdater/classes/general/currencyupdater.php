<?php

/**
 * ������ ��������������� ���������� ������ �����.
 * ���� ���� ������, ����� �� �����������, � ����������� �������.
 * ��� ������ ��������� ������������� ������ "������" (currency)
 */

use \Bitrix\Main\Web\HttpClient;

class CCurrencyRatesUpdater
{

	/**
	 * ����������� ����� ��� �������� ������ (�������-�����).
	 * ���������� ��� ������ ��������-������.
	 * � ������ ��������� ������ ������ CCurrencyUpdater
	 * � ����������� �������� ���������� ������ �����, ����������� �� ����.

	 * @return string
	 *
	 */
	public static function UpdateCurrencyRates()
	{
		$updater = new CCurrencyUpdater();
		$updater->updateCurrencies();

		return "CCurrencyRatesUpdater::UpdateCurrencyRates();";
	}

}

class CCurrencyUpdater
{
	/**
	 * @return null
	 */
	public function updateCurrencies()
	{
		if (!\CModule::IncludeModule('currency')) {
			return false;
		}

		/**
		 * @var $currencies array
		 */
		$currencies = $this->currenciesFromXML();

		if (empty($currencies)) {
			return false;
		}

		$this->update($currencies);
		return false;
	}

	/**
	 * ������ ����� (USD, EUR) �����, ������������ �� ����� � ���� �������,
	 * ��� ������ ����� ������
	 *
	 * @return array
	 */
	protected function siteCurrenciesList()
	{
		return array_filter(array_map(function ($currency) {
			return $currency['CURRENCY'] == 'RUB' ? '' : $currency['CURRENCY'];
		}, \CCurrency::GetList($by = 'currency', $order = 'asc')->arResult));
	}

	/**
	 * �������� ����������� ������ �� ��������� �������� ����
	 * � ������� xpath ����� �������� ������ ������
	 *��� ����������� ������������ ����� HttpClient
	 * @return array
	 */
	protected function currenciesFromXML()
	{
		$queryStr = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d/m/Y', strtotime('+ 1 day'));
		$httpClient = new HttpClient();

		$xml = simplexml_load_string($httpClient->get($queryStr));

		if (!$xml) {
			return false;
		}

		return $xml->xpath('/ValCurs/Valute[' . implode(' or ', array_map(function ($code) {
				return 'CharCode="' . $code . '"';
			}, $this->siteCurrenciesList())) . ']');

		return false;
	}

	/**
	 * ����������/���������� ������ �����
	 *
	 * @param $currencies array
	 *
	 * @return null
	 */
	protected function update($currencies)
	{
		array_walk($currencies, function ($currency) {
			$code = $currency->CharCode->__toString();
			$params = array(
				'CURRENCY' => $code,
				'RATE_CNT' => $currency->Nominal->__toString(),
				'RATE' => str_replace(',', '.', $currency->Value->__toString()),
				'DATE_RATE' => date('d.m.Y'),
			);

			/**
			 * @var $ratesDB CDBResult
			 */
			$ratesDB = \CCurrencyRates::GetList($by = 'currency', $order = 'asc', array('CURRENCY' => $code));

			if (!$ratesDB->SelectedRowsCount()) {
				return \CCurrencyRates::Add($params);
			}

			$rate = $ratesDB->Fetch();
			return \CCurrencyRates::Update($rate['ID'], $params);
		});
		return false;

	}
}