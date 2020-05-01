<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$templateData['TEMPLATE_THEME'].'/style.css');
	$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$templateData['TEMPLATE_THEME'].'/style.css', true);
}

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

//	lazy load and big data json answers
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad'))
{
	$content = ob_get_contents();
	ob_end_clean();

	list(, $itemsContainer) = explode('<!-- items-container -->', $content);
	list(, $paginationContainer) = explode('<!-- pagination-container -->', $content);
	list(, $epilogue) = explode('<!-- component-end -->', $content);

	if ($arParams['AJAX_MODE'] === 'Y')
	{
		$component->prepareLinks($paginationContainer);
	}

	$component::sendJsonAnswer(array(
		'items' => $itemsContainer,
		'pagination' => $paginationContainer,
		'epilogue' => $epilogue,
	));
}

if(LANGUAGE_ID == 'en'){
    print_r($arResult['TEST']['DESCRIPTION']);

    //echo "<pre>"; print_r($arResult['TEST']['NAME']); echo "</pre>";

    $APPLICATION->SetPageProperty("title", 'Buy an apartment in a new building in '. $arResult['TEST']['NAME'] .', 🏢 apartments for sale in a new building - Fodyo.com portal');

    $APPLICATION->SetPageProperty("description", 'A complete collection of all new buildings in '. $arResult['TEST']['NAME'] .' at a low price. The 👉🏻 Fodyo.com 👈🏻 portal is useful for those who are interested in information on new buildings in '. $arResult['TEST']['NAME'] .'. Here are new buildings in '. $arResult['TEST']['NAME'] .' for sale on favorable terms. ✅');

    $APPLICATION->setTitle( 'New buildings in '. $arResult['TEST']['NAME']);

}else{

    $getSection = CIBlockSection::GetList(
        Array("SORT"=>"ASC"),
        Array("ID" => $arResult['TEST']['ORIGINAL_PARAMETERS']['SECTION_ID'], 'IBLOCK_ID' => $arResult['TEST']['ORIGINAL_PARAMETERS']['IBLOCK_ID']),
        false,
        Array('ID', 'NAME', 'IBLOCK_ID', 'UF_DESCRIPTION_'.strtoupper(LANGUAGE_ID), 'UF_NAME_'.strtoupper(LANGUAGE_ID)),
        false
    );
    while($fetch = $getSection -> GetNext()){

        print_r($fetch['UF_DESCRIPTION_'.strtoupper(LANGUAGE_ID)]);

        //echo "<pre>"; print_r($fetch); echo "</pre>";
        $titleFor = $fetch['UF_NAME_'.strtoupper(LANGUAGE_ID)];
        $titleFor = str_replace('Россия', 'России', $titleFor);
        $titleFor = str_replace('Москва', 'Москве', $titleFor);

        //echo "<pre>"; print_r($titleFor); echo "</pre>";

        $APPLICATION->SetPageProperty("title", 'Новостройки в '. $titleFor .', 🏢 продажа квартир в новом доме - портал «Fodyo.com»');

        $APPLICATION->SetPageProperty("description", 'Полное собрание всех новостроек в '. $titleFor .' недорого. Портал 👉🏻 Fodyo.com 👈🏻 пригодится тем, кого интересует информация по новостройкам в '. $titleFor .'. Тут осуществляется продажа новостроек в '. $titleFor .' по выгодным условиям. ✅');

        $APPLICATION->setTitle( 'Новостройки в '. $titleFor);
    }
}