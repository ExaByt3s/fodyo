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

//  lazy load and big data json answers
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

    //echo "<pre>"; print_r($arResult['TEST']['NAME']); echo "</pre>";

    $APPLICATION->SetPageProperty("title", 'Buy an apartment in '. $arResult['TEST']['NAME'] .', 🏢 apartments for sale in the capital, ads and prices on Fodyo.com');

    $APPLICATION->SetPageProperty("description", 'A complete collection of allapartments in '. $arResult['TEST']['NAME'] .' at a low price. The 👉🏻 Fodyo.com 👈🏻 portal is useful for those who are interested in information on apartments in '. $arResult['TEST']['NAME'] .'. Here are apartments in '. $arResult['TEST']['NAME'] .' for sale on favorable terms. ✅');

    $APPLICATION->setTitle( 'Apartments in '. $arResult['TEST']['NAME']);

}else{

    $getSection = CIBlockSection::GetList(
        Array("SORT"=>"ASC"),
        Array("ID" => $arResult['TEST']['ORIGINAL_PARAMETERS']['SECTION_ID'], 'IBLOCK_ID' => $arResult['TEST']['ORIGINAL_PARAMETERS']['IBLOCK_ID']),
        false,
        Array('ID', 'NAME', 'IBLOCK_ID', 'UF_DESCRIPTION_'.strtoupper(LANGUAGE_ID), 'UF_NAME_'.strtoupper(LANGUAGE_ID)),
        false
    );
    while($fetch = $getSection -> GetNext()){

        //echo "<pre>"; print_r($fetch); echo "</pre>";
        $titleFor = $fetch['UF_NAME_'.strtoupper(LANGUAGE_ID)];
        $titleFor = str_replace('Россия', 'России', $titleFor);
        $titleFor = str_replace('Москва', 'Москве', $titleFor);

        //echo "<pre>"; print_r($titleFor); echo "</pre>";

        $APPLICATION->SetPageProperty("title", 'Купить квартиру в '. $titleFor .', 🏢 продажа квартир в '.$titleFor.', объявления и цены на «Fodyo.com»');

        $APPLICATION->SetPageProperty("description", 'Полное собрание всех квартир в '. $titleFor .' недорого. Портал 👉🏻 Fodyo.com 👈🏻 пригодится тем, кого интересует квартиры в '. $titleFor .'. Тут осуществляется продажа квартир в '. $titleFor .' по выгодным условиям. ✅');

        $APPLICATION->setTitle( 'Квартиры в '. $titleFor);
    }
}