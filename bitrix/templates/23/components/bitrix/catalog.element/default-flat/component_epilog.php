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

if(LANGUAGE_ID != 'en'){

    //echo "<pre>"; print_r(['PROPERTIES']['STATE_CITY_'.strtoupper(LANGUAGE_ID)]); echo "</pre>";

    $titleSet = str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']).' ';

    if('' != ($arResult['TEST']['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= 'от застройщика '.str_replace('By ', '', $arResult['TEST']['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE']).' ';
    }

    if('' != ($arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= $arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'].' по адресу: ';
    }

    if('' != ($arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= $arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'].', ';
    }

    $arResult['TEST']['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $arResult['TEST']['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
    $arResult['TEST']['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $arResult['TEST']['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

    if(is_numeric($arResult['TEST']['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($arResult['TEST']['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
        if(is_numeric($arResult['TEST']['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){

            $priceItem['VAL'] = (int)$arResult['TEST']['PROPERTIES']['PRICE_FROM_EN']['VALUE'];
            $priceItem['CURRENCY'] = 'USD';
        }else{
            $priceItem['VAL'] = (int)$arResult['TEST']['PROPERTIES']['PRICE_FROM_RU']['VALUE'];
            $priceItem['CURRENCY'] = 'RUB';
        }
    }else{

        $getSku = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array('PROPERTY_CML2_LINK' => $arResult['TEST']['ID'], 'IBLOCK_ID' => 8),
            false,
            false,
            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN', 'PRICE_FROM_RU', 'PRICE_FROM_EN')
        );
        while ($fetchSku = $getSku -> Fetch()) {


            if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){

                if(isset($priceItem['VAL']) && (int)str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) < $priceItem['VAL'] ){

                    $priceItem['VAL'] = (int)str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']);

                    $priceItem['CURRENCY'] = 'USD';
                }else if( !isset($priceItem['VAL']) && !is_numeric($priceItem['VAL']) ){

                    $priceItem['VAL'] = (int)str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']);
                    $priceItem['CURRENCY'] = 'USD';

                }
            }else if(is_numeric((int)$fetchSku['PROPERTY_PRICE_RU_VALUE']) && (int)$fetchSku['PROPERTY_PRICE_RU_VALUE'] != '0'){

                if(isset($priceItem['VAL']) && (int)$fetchSku['PROPERTY_PRICE_RU_VALUE'] < $priceItem['VAL'] ){
                    $priceItem['VAL'] = (int)$fetchSku['PROPERTY_PRICE_RU_VALUE'];
                    $priceItem['CURRENCY'] = 'RUB';
                }else if(!isset($priceItem['VAL'])){
                    $priceItem['VAL'] = (int)$fetchSku['PROPERTY_PRICE_RU_VALUE'];
                    $priceItem['CURRENCY'] = 'RUB';
                }

            }
        }
    }

    if(!isset($priceItem) || !is_array($priceItem)){
        $arResult['TEST']['PROPERTIES']['PRICE_EN']['VALUE'] = str_replace('$', '', $arResult['TEST']['PROPERTIES']['PRICE_EN']['VALUE']);
        $arResult['TEST']['PROPERTIES']['PRICE_RU']['VALUE'] = str_replace(',', '', $arResult['TEST']['PROPERTIES']['PRICE_RU']['VALUE']);

        if(is_numeric($arResult['TEST']['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($arResult['TEST']['PROPERTIES']['PRICE_RU']['VALUE'])){
            if(is_numeric($arResult['TEST']['PROPERTIES']['PRICE_EN']['VALUE'])){
                $priceItem['VAL'] = (int)$arResult['TEST']['PROPERTIES']['PRICE_EN']['VALUE'];
                $priceItem['CURRENCY'] = 'USD';
            }else{
                $priceItem['VAL'] = (int)$arResult['TEST']['PROPERTIES']['PRICE_RU']['VALUE'];
                $priceItem['CURRENCY'] = 'RUB';
            }
        }
    }
    if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){
        $titleSet .= 'по цене от '.CCurrencyLang::CurrencyFormat(
            ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
            $_COOKIE['CURRENCY_SET']
        );
    }

    $titleSet .= ' на «Fodyo.com»';

    $APPLICATION->SetPageProperty('title', $titleSet);
   
    
    $descrSet = 'Купить '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);

    if('' != ($arResult['TEST']['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= 'от застройщика '.str_replace('By ', '', $arResult['TEST']['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE']).' ';
    }

    if('' != ($arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= $arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'].' по адресу: ';
    }

    if('' != ($arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $descrSet .= $arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'].', ';
    }
    
    $descrSet .= 'фото и подробная информация об объекте.';

    $descrSet .= str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);

    if($arResult['TEST']['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE'] != ''){

    	//echo "<pre>"; print_r($arResult['TEST']['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE']); echo "</pre>";

    	$priceSqft['VAL'] = $arResult['TEST']['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE'] / 10.7639;
    	$priceSqft['CURRENCY'] = 'USD';

    }elseif($arResult['TEST']['PROPERTIES']['PRICE_PER_SQFT_RU']['VALUE']){

    	$priceSqft['VAL'] = $arResult['TEST']['PROPERTIES']['PRICE_PER_SQFT_RU']['VALUE'];
    	$priceSqft['CURRENCY'] = 'RUB';

    }
    

    if(is_array($priceSqft) && $priceSqft['VAL'] != '' && $priceSqft['VAL'] != 0){
    	$gerPrice = CCurrencyLang::CurrencyFormat(
            ceil(CCurrencyRates::ConvertCurrency($priceSqft['VAL'], $priceSqft['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
            $_COOKIE['CURRENCY_SET']
        );

        $descrSet .= ' '.$gerPrice.' за м²';
    }

    $descrSet .= ' на сайте «Fodyo.com».';

    $APPLICATION->SetPageProperty('description', $descrSet);

    $APPLICATION->setTitle( str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']));
    
}else{
    
    $titleSet = str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']).' is located at: ';

    if('' != ($arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= $arResult['TEST']['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];

    }elseif('' != ($arResult['TEST']['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE'])){

    	$titleSet .= $arResult['TEST']['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }
    if('' != ($arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'])){
        $titleSet .= ' neighborhood '.$arResult['TEST']['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE'];
    }
    
    //echo "<pre>"; print_r(array($APPLICATION->ShowTitle(false), str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']) ) ); echo "</pre>";

    $APPLICATION->setTitle( str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']));

    $APPLICATION->SetPageProperty('title', $titleSet .' ');
    
    $descrSet = 'View detailed information about property '.str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']).' including listing details, property photos, open house information and much more.';
    
    $APPLICATION->SetPageProperty('description', $descrSet);

    //$APPLICATION->SetProperty('page_title', str_replace($arResult['TEST']['CODE'], '', $arResult['TEST']['NAME']));
}