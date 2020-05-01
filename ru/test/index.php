<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$arReplace = array(
    '01.01.2005' => '1-5',
    ".янв" => '1',
    ".фев" => '2',
    ".мар" => '3',
    ".апр" => '4',
    ".май" => '5',
    ".июн" => '6',
    ".июл" => '7',
    ".авг" => '8',
    ".сен" => '9',
    ".окт" => '10',
    ".ноя" => '11',
    ".дек" => '12',
    "01" => '1-',
    "02" => '2-',
    "03" => '3-',
    "3.5" => '3',
    "04" => '4-',
    "05" => '5-',
    "06" => '6-',
    "07" => '7-'
);

//echo "<pre>"; print_r($arReplace); echo "</pre>";

$getSku = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array('?PROPERTY_BEDROOMS_RU' => '.', 'IBLOCK_ID' => 4),
    false,
    false,
    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_PRICE_PER_SQFT_RU', 'PROPERTY_BEDROOMS_RU','PROPERTY_BEDROOMS_EN')
);
while($fetch = $getSku -> Fetch()){
    echo "<pre>"; print_r($fetch); echo "</pre>";
	//echo "<pre>"; print_r(preg_replace('/\s+/', '', strtr($fetch['PROPERTY_BEDROOMS_RU_VALUE'], $arReplace))); echo "</pre>";
	$val = preg_replace('/\s+/', '', strtr($fetch['PROPERTY_BEDROOMS_RU_VALUE'], $arReplace) );
	CIBlockElement::SetPropertyValuesEx($fetch['ID'], 4, array( 'PROPERTY_BEDROOMS_RU' => $val ) );
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>