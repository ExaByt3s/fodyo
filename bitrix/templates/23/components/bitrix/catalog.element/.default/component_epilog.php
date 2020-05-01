<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
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
        $loadCurrency = Loader::includeModule('currency');
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

if (isset($templateData['JS_OBJ']))
{
    ?>
    <script>
        BX.ready(BX.defer(function(){
            if (!!window.<?=$templateData['JS_OBJ']?>)
            {
                window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
            }
        }));
    </script>

    <?
    // check compared state
    if ($arParams['DISPLAY_COMPARE'])
    {
        $compared = false;
        $comparedIds = array();
        $item = $templateData['ITEM'];

        if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]))
        {
            if (!empty($item['JS_OFFERS']))
            {
                foreach ($item['JS_OFFERS'] as $key => $offer)
                {
                    if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
                    {
                        if ($key == $item['OFFERS_SELECTED'])
                        {
                            $compared = true;
                        }

                        $comparedIds[] = $offer['ID'];
                    }
                }
            }
            elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
            {
                $compared = true;
            }
        }

        if ($templateData['JS_OBJ'])
        {
            ?>
            <script>
                BX.ready(BX.defer(function(){
                    if (!!window.<?=$templateData['JS_OBJ']?>)
                    {
                        window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

                        <? if (!empty($comparedIds)): ?>
                        window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
                        <? endif ?>
                    }
                }));
            </script>
            <?
        }
    }

    // select target offer
    $request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
    $offerNum = false;
    $offerId = (int)$this->request->get('OFFER_ID');
    $offerCode = $this->request->get('OFFER_CODE');

    if ($offerId > 0 && !empty($templateData['OFFER_IDS']) && is_array($templateData['OFFER_IDS']))
    {
        $offerNum = array_search($offerId, $templateData['OFFER_IDS']);
    }
    elseif (!empty($offerCode) && !empty($templateData['OFFER_CODES']) && is_array($templateData['OFFER_CODES']))
    {
        $offerNum = array_search($offerCode, $templateData['OFFER_CODES']);
    }

    if (!empty($offerNum))
    {
        ?>
        <script>
            BX.ready(function(){
                if (!!window.<?=$templateData['JS_OBJ']?>)
                {
                    window.<?=$templateData['JS_OBJ']?>.setOffer(<?=$offerNum?>);
                }
            });
        </script>
        <?
    }
}

//echo "<pre>"; print_r($arResult); echo "</pre>";

$db_old_groups = CIBlockElement::GetElementGroups($arResult['ID'], true);

while($ar_group = $db_old_groups->Fetch())
{
  if($ar_group['DEPTH_LEVEL'] == 3){
    $resGropt = $ar_group;
  }
}

//echo "<pre>"; print_r('UF_NAME_'.strtoupper(LANGUAGE_ID)); echo "</pre>";

$getSecty = CIBlockSection::GetList(array('SORT' => 'ASC'), array('ID' => $resGropt['ID'], 'IBLOCK_ID' => $resGropt['IBLOCK_ID']), false, array('ID', 'IBLOCK_ID', 'NAME', 'UF_NAME_'.strtoupper(LANGUAGE_ID)));

if($fetchSect = $getSecty -> GetNext()){
  $resSect = $fetchSect;
 // echo "<pre>"; print_r($fetchSect); echo "</pre>";
}

if(LANGUAGE_ID != 'en'){
    $titleSet = str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']).' ';
    if('' != ($arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= str_replace(
            strtolower($arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['NAME']),
            '',
            $arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']).' район';
    }

    if($resSect['UF_NAME_'.strtoupper(LANGUAGE_ID)] != ''){
    	//$resSect['UF_NAME_'.strtoupper(LANGUAGE_ID)] = str_replace('Москва', 'Москве', $resSect['UF_NAME_'.strtoupper(LANGUAGE_ID)]);
        $titleSet .= ' ('.$resSect['UF_NAME_'.strtoupper(LANGUAGE_ID)].")";
    }

    if(isset($_REQUEST['sku-preview']) && $_REQUEST['sku-preview'] == 'Y'){
		$APPLICATION->SetPageProperty('title', $titleSet .' - все квартиры в новостройке, цены и планировки на Fodyo.com');
		$descrSet = 'Все квартиры в '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
    }else{
    	$APPLICATION->SetPageProperty('title', $titleSet .' - продажа квартир в новостройке, цены и планировки на Fodyo.com');
    	$descrSet = 'Купить квартиры в '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
    }    

    $descrSet .= ' по ценам от застройщика. Планировки квартир, фото, описание, ход строительства. Адрес:';

    if('' != ($arResult['TEST']['PROPERTIES']['REGION_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= ' '.$arResult['TEST']['PROPERTIES']['REGION_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }

    if('' != ($arResult['TEST']['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
         $descrSet .= ' '.$arResult['TEST']['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }

    if('' != ($arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= ' '.$arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }

    if('' != ($arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= ' '.$arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }

    if('' != ($arResult['TEST']['PROPERTIES']['METRO_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= ' '.$arResult['TEST']['PROPERTIES']['METRO_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }
    
    $APPLICATION->SetPageProperty('description', $descrSet);

    $APPLICATION->setTitle( str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']));

}else{

    $titleSet = str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']).' for sale ';
    if('' != ($arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= str_replace(
            strtolower($arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['NAME']),
            '',
            $arResult['TEST']['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']);
    }

    if(isset($_REQUEST['sku-preview']) && $_REQUEST['sku-preview'] == 'Y'){
    	$titleSet .= ' all apartments sales';
    }else{
    	$titleSet .= ' apartment sales';
    }
    
    //echo "<pre>"; print_r($resSect); echo "</pre>";

    if('' != ($arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= ' '.$arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }
    if($resSect['NAME'] != ''){
        $titleSet .= ' in '.$resSect['NAME'];
    }
    $APPLICATION->SetPageProperty('title', $titleSet .' ');

    if(isset($_REQUEST['sku-preview']) && $_REQUEST['sku-preview'] == 'Y'){
    	$descrSet = 'View detailed information about apartments of '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']);
    }else{
    	$descrSet = 'View detailed information about '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']);
    }

   
    if('' != ($arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= ' is located at: '.$arResult['TEST']['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'].' including ';
    }
    $descrSet .= 'listing details, property photos, open house information and much more.';

    $APPLICATION->SetPageProperty('description', $descrSet);

    $APPLICATION->setTitle( str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']));
}