<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$arResultIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] > 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}
?>
<?
    $APPLICATION->SetAdditionalCSS("/bitrix/templates/23/components/bitrix/catalog.element/default-flat/CheckBox.css");
    $APPLICATION->AddHeadScript("/bitrix/templates/23/components/bitrix/catalog.element/default-flat/CheckBox.js");
?>
<div class="breadcrumbs">
    <?$APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "fodyo_new3",
        Array(
            "PATH" => $APPLICATION->GetCurDir(),
            "SITE_ID" => "s1",
            "START_FROM" => "0"
        )
    );?>
</div>
<?


if(isset($_REQUEST['sku-preview']) && $_REQUEST['sku-preview'] == 'Y'){
    ?>
    <div class="max-width">
        <div class="detail-block">
            <div class="block-title">
                <span style="text-align: left;">
                    <?
                    if(LANGUAGE_ID != 'en'){
                        echo GetMessage('FLATS-STUDIOS').str_replace($arResult['CODE'], '', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                    }else{
                        echo GetMessage('FLATS-STUDIOS').str_replace($arResult['CODE'], '', $arResult['NAME']);
                    }
                    ?>
                </span>
            </div>
            <div class="flex-sku">
                <div class="picture-sku">
                    <div class="item-slide" style="width: 370px;">
                        <img style="width: inherit;" class="lozad" data-src="<?=CFile::GetPath($arResult['PROPERTIES']['GALEREYA']['VALUE'][0])?>">
                    </div>
                </div>
                <div class="map-sku">
                    <?
                    if(!empty($arResult['PROPERTIES']['MESTOPOLOZHENIE']['VALUE'])){

                       $arPosititon = explode(",", $arResult['PROPERTIES']['MESTOPOLOZHENIE']['VALUE']);?>                 
                       <?$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                             "INIT_MAP_TYPE" => "MAP",
                             "MAP_DATA" => serialize(array(
                                'google_lat' => $arPosititon[0],
                                'google_lon' => $arPosititon[1],
                                'google_scale' => 13,
                                'PLACEMARKS' => array (
                                   array(
                                      'TEXT' => $arResult['NAME'],
                                      'LON' => $arPosititon[1],
                                      'LAT' => $arPosititon[0],
                                   ),
                                ),
                             )),
                             "MAP_HEIGHT" => "208",
                             "CONTROLS" => array(
                                "SMALL_ZOOM_CONTROL",
                                "SCALELINE"
                             ),
                             "OPTIONS" => array(
                                "ENABLE_SCROLL_ZOOM",
                                "ENABLE_DBLCLICK_ZOOM",
                                "ENABLE_DRAGGING",
                                "ENABLE_KEYBOARD"
                             ),
                             "MAP_ID" => ""
                          ), 
                          false
                       );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-content max-width">
        <div class="detail-info">
            <div class="info-table">
                <span class="block-title"><?=GetMessage('PROPERTIES_TITLE')?></span>
                <div class="table">
                    <?
                    foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $value) {

                        if(strripos($key, LANGUAGE_ID)){
                            ?>
                            <div class="flex-prop">
                                <div class="left"><?=$value['NAME']?></div>
                                <div class="right"><?=$value['VALUE']?></div>
                            </div>
                            <?
                        }
                        if($key == 'OFFICIAL_SITE'){
                            ?>
                            <div class="flex-prop">
                                <div class="left"><?=GetMessage('OFFICIAL_SITE')?>:</div>
									<div class="right">
									<?
									if( stristr($value['VALUE'], 'http') === false ){
										$value['VALUE'] = "http://".$value['VALUE'];
									}
									?>
									<a href="<?=$value['VALUE']?>" target="_blank" class="orange-text"><?=GetMessage('GO_TO_TEXT')?></a>
                                </div>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="info-table">
                <span class="block-title">
                    <?
                    echo GetMessage('SKU_BLOCK_PAGE_TEXT_'.strtoupper($_REQUEST['item']));
                    ?>
                </span>
                <div class="flex-filter sku-filter">
                    <div class="rooms" style="width: unset;margin-right: 30px;">
                        <div class="checkbox-wrapper">
                            <?
                            $getReq = explode(';',$_REQUEST['item']);

                            foreach ($getReq as $key => $value) {
                                if($value == 'study' || $value == 'Study'){
                                    $studyClass = 'active-filter';
                                }
                                if($value == '1-room'){
                                    $room1Class = 'active-filter';
                                }
                                if($value == '2-room'){
                                    $room2Class = 'active-filter';
                                }
                                if($value == '3-room'){
                                    $room3Class = 'active-filter';
                                }
                                if($value == '4-room'){
                                    $room4Class = 'active-filter';
                                }
                            }

                            ?>
                            <div class="checkbox study <?=$studyClass?>" data-filt='study'>
                                <?=GetMessage('STUDY')?>
                             </div>
                            <div class="checkbox 1-room <?=$room1Class?>" data-filt='1-room'>
                                1
                            </div>
                            <div class="checkbox 2-room <?=$room2Class?>" data-filt='2-room'>
                                2
                            </div>
                            <div class="checkbox 3-room <?=$room3Class?>" data-filt='3-room'>
                                3
                            </div>
                            <div class="checkbox 4-room <?=$room4Class?>" data-filt='4-room'>
                                4+
                            </div>
                        </div>
                    </div>
                    <div class="price" style="width: unset;">
                        <div class="checkbox-wrapper">
                            <div class="checkbox-input"><?=GetMessage('PRICE_TEXT')?></div>
                            <div class="checkbox-input"><input type="text" placeholder="<?=GetMessage('TEXT_FROM')?>" name="price_from"></div>
                            <div class="checkbox-input"><input type="text" placeholder="<?=GetMessage('TEXT_TO')?>" name="price_to"></div>
                        </div>
                    </div>
                </div>
                <div class="table-head sku-items-head">
                    <div class="type"><?=GetMessage("SKU_TYPE_TEXT");?></div>
                    <div class="square"><?=GetMessage("SKU_SQUARE_TEXT");?></div>
                    <div class="floor"><?=GetMessage("SKU_FLOOR_TEXT");?></div>
                    <div class="price"><?=GetMessage("SKU_PRICE_TEXT");?></div>
                </div>
                <div class="table sku-items">
                    <?
                    $getSku = CIBlockElement::GetList(
                        array('SORT' => 'ASC'),
                        array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                        false,
                        false,
                        array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE')
                    );

                    $getItemsReq = explode(';', $_REQUEST['item']);

                    while ($fetchList = $getSku->GetNext()) {
                        if($_REQUEST['item'] == 'all-flats' || !isset($_REQUEST['item'])){
                            $arrAdd[] = $fetchList['ID'];
                        }else{
                            foreach ($getItemsReq as $key2 => $valueReq) {
                                if( isset($valueReq) && 
                                    ($valueReq == strtolower(str_replace('комн', 'room', $fetchList['PROPERTY_FLAT_TYPE_VALUE'])) || $valueReq == strtolower(str_replace('Студия', 'study', $fetchList['PROPERTY_FLAT_TYPE_VALUE']))) 
                                    && $valueReq != 'all-flats' && $valueReq != '4-room'){
                                    $arrAdd[] = $fetchList['ID'];
                                }else if(stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], $valueReq) && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '1'.$valueReq) && isset($valueReq) && $valueReq != '4-room'){
                                    $arrAdd[] = $fetchList['ID'];
                                }else if( 
                                    ( stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('room', 'комн', $valueReq)) || stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('Study', 'Студия', $valueReq)) )
                                        && isset($valueReq) && $valueReq != '4-room' && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('room', 'комн', '1'.$valueReq)) )
                                    {
                                        $arrAdd[] = $fetchList['ID'];

                                }else if($valueReq == '4-room'){
                                    if(isset($valueReq)
                                        && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '1-комн')
                                        && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '2-комн')
                                        && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '3-комн')
                                        && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], 'Студия')
                                    ){
                                       $arrAdd[] = $fetchList['ID'];
                                    }else{
                                        if(
                                            stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '11')
                                            || stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '12')
                                            || stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '13')
                                        ){
                                            $arrAdd[] = $fetchList['ID'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(!is_array($arrAdd)){
                        $getSku = CIBlockElement::GetList(
                            array('SORT' => 'ASC'),
                            array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                            false,
                            false,
                            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE')
                        );
                        while ($fetchList = $getSku->GetNext()) {
                            $arrAdd[] = $fetchList['ID'];
                        }
                    }
                    global $arrFilterSKU;
                    $arrFilterSKU = array('ID' => $arrAdd);



                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section", 
                        "template-flats", 
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "-",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/personal/basket.php",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COMPATIBLE_MODE" => "Y",
                            "COMPONENT_TEMPLATE" => "template-flats",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "",
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrFilterSKU",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => "8",
                            "IBLOCK_TYPE" => "Flats",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array(
                            ),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "3",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_LIMIT" => "5",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "fodyo",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "6",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => array(
                            ),
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'9','BIG_DATA':false},{'VARIANT':'9','BIG_DATA':false},{'VARIANT':'9','BIG_DATA':false},{'VARIANT':'9','BIG_DATA':false},{'VARIANT':'9','BIG_DATA':false},{'VARIANT':'9','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "RCM_TYPE" => "personal",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "Y",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N",
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],
                            "SECTION_CODE" => "",
                            "PROPERTY_CODE_MOBILE" => array(
                            ),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "SECTION_ID_VARIABLE" => "SECTION_ID"
                        ),
                        false
                    );?>
                </div>
            </div>
        </div>
    </div>

<?
}else{
    ?>
    <div class="sidebar-block  max-width">
        <div class="max-width">
            <div class="detail-block">
                <div class="block-title">
                    <span style="text-align: left;">
                        <?
                        $getList = CIBlockElement::GetList(array('SORT' => 'ASC'), array('NAME' => $arResult['PROPERTIES']['PROJECT_BRAND_NAME_EN']['VALUE'], 'IBLOCK_ID' => 4));
                        $getUrl = $getList->GetNext();

                        $explode = explode('/', $APPLICATION->GetCurDir());

                        //echo "<pre style='display:none;'>"; print_r($getUrl); echo "</pre>";
                        //echo "<pre style='display:none;'>"; print_r($APPLICATION->GetCurDir()); echo "</pre>";

                        $getUrl['DETAIL_PAGE_URL'] = str_replace('/'.strtolower(LANGUAGE_ID).'/', '', $getUrl['DETAIL_PAGE_URL']);
                        $getUrl['DETAIL_PAGE_URL'] = str_replace($arResult['CODE'], $getUrl['CODE'], $APPLICATION->GetCurDir());
                        $getUrl['DETAIL_PAGE_URL'] = str_replace('condos', 'developments', $getUrl['DETAIL_PAGE_URL']);


                        if(LANGUAGE_ID != 'en'){
                            $replace = "<a href=".$getUrl['DETAIL_PAGE_URL'].">".$arResult['PROPERTIES']['PROJECT_BRAND_NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'].'</a>';
                            $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] = str_replace($arResult['PROPERTIES']['PROJECT_BRAND_NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] , $replace, $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                            echo str_replace($arResult['CODE'], '', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                        }else{
                            $replace = "<a href=".$getUrl['DETAIL_PAGE_URL'].">".$arResult['PROPERTIES']['PROJECT_BRAND_NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'].'</a>';
                            $arResult['NAME'] = str_replace($arResult['PROPERTIES']['PROJECT_BRAND_NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] , $replace,  $arResult['NAME']);
                            echo str_replace($arResult['CODE'], '', $arResult['NAME']);
                        }
                        ?>    
                    </span>
                </div>
                <div class="price-huge">
                    <?
                    $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
                    $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

                    if(is_numeric($arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
                        if(is_numeric($arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){

                            $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE'] );
                            $priceItem['CURRENCY'] = 'USD';
                        }else{
                            $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE'] );
                            $priceItem['CURRENCY'] = 'RUB';
                        }
                    }else{

                        $getSku = CIBlockElement::GetList(
                            array('SORT' => 'ASC'),
                            array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                            false,
                            false,
                            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN', 'PRICE_FROM_RU', 'PRICE_FROM_EN')
                        );
                        while ($fetchSku = $getSku -> Fetch()) {

                            if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){
                                if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) ) < $priceItem['VAL'] ){

                                    $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) );

                                    $priceItem['CURRENCY'] = 'USD';
                                }else if( !isset($priceItem['VAL']) && !is_numeric($priceItem['VAL']) ){

                                    $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']));
                                    $priceItem['CURRENCY'] = 'USD';

                                }
                            }else if(is_numeric(preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'])) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) != '0'){

                                if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) < $priceItem['VAL'] ){
                                    $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                                    $priceItem['CURRENCY'] = 'RUB';
                                }else if(!isset($priceItem['VAL'])){
                                    $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                                    $priceItem['CURRENCY'] = 'RUB';
                                }

                            }
                        }
                    }

                    if(!isset($priceItem) || !is_array($priceItem)){
                        $arResult['PROPERTIES']['PRICE_EN']['VALUE'] = str_replace('$', '', $arResult['PROPERTIES']['PRICE_EN']['VALUE']);
                        $arResult['PROPERTIES']['PRICE_RU']['VALUE'] = str_replace(',', '', $arResult['PROPERTIES']['PRICE_RU']['VALUE']);
                        if(is_numeric($arResult['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($arResult['PROPERTIES']['PRICE_RU']['VALUE'])){
                            if(is_numeric($arResult['PROPERTIES']['PRICE_EN']['VALUE'])){
                                $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_EN']['VALUE'] );
                                $priceItem['CURRENCY'] = 'USD';
                            }else{
                                $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_RU']['VALUE'] );
                                $priceItem['CURRENCY'] = 'RUB';
                            }
                        }
                    }

                    if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){
                        if($_COOKIE['CURRENCY_SET']){
                            echo CCurrencyLang::CurrencyFormat(
                                ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                $_COOKIE['CURRENCY_SET']
                            );
                        }else{
                            echo CCurrencyLang::CurrencyFormat(
                                ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD')),
                                'USD'
                            );
                        }
                        
                    }else{
                        echo GetMessage('NO_PRICE');
                    }
                    ?>
                </div>
                <div class="picture-slider">
                    <?
                    if(is_array($arResult['PROPERTIES']['GALEREYA']['VALUE']) && (is_array($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_numeric($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]))){
                        foreach ($arResult['PROPERTIES']['GALEREYA']['VALUE'] as $key => $value){

                            $getArray = CFile::GetFileArray($value);
                            $resolution = $getArray['WIDTH']/$getArray['HEIGHT'];
                            //if($resolution > 2){

                                $file = CFile::ResizeImageGet($value, array('width'=>370, 'height'=>185), BX_RESIZE_IMAGE_EXACT, true);
                                ?>
                                <div class="item-slide" style="width: 370px; margin-left: 15px; margin-right: 15px;">
                                    <a data-fancybox href="<?=CFile::GetPath($value)?>"><img class="lozad" data-src="<?=$file['src']?>"></a>
                                </div>
                                <?
                            /*}
                            ?>
                            <div class="item-slide" style="width: 370px; margin-left: 15px; margin-right: 15px;">
                                <a data-fancybox href="<?=CFile::GetPath($value)?>"><img src="<?=CFile::GetPath($value)?>"></a>
                            </div>
                            <?*/
                        }
                    }else{
                        if(is_array($arResult['DETAIL_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 370px; margin-left: 15px; margin-right: 15px;">
                                <a data-fancybox href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }elseif(is_array($arResult['PREVIEW_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 370px; margin-left: 15px; margin-right: 15px;">
                                <a data-fancybox href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>

                <div class="flex-content">
                    <div class="detail-info">
                        <div class="info-table">
                            <span class="block-title"><?=GetMessage('PROPERTIES_TITLE')?></span>
                            <div class="table">
                                <?
                                /*if(is_numeric($arResult['CODE'])){
                                    ?>
                                    <div class="flex-prop">
                                        <div class="left"><?=GetMessage('FLAT_ID')?></div>
                                        <div class="right"><?=$arResult['CODE']?></div>
                                    </div>
                                    <?
                                }*/
                                
                                //debug($priceItem);
                                //debug($arResult);
                                
                                foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $value) {
                                    if($key =='FLOOR'){
                                        ?>
                                        <div class="flex-prop">
                                            <div class="left"><?=GetMessage('SKU_FLOOR_TEXT')?></div>
                                            <div class="right">
                                                <?
												if($value['VALUE']['TYPE'] != 'HTML'){
													echo $value['VALUE'];
												}else{
													echo $value['VALUE']['TEXT'];
												}
                                                ?>
                                            </div>
                                        </div>
                                        <?
                                    }
                                    elseif($key == 'PROJECT_BRAND_NAME_'.strtoupper(LANGUAGE_ID)){
                                        ?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$value['NAME']?></div>
                                             <div class="right">
                                            <?
                                            $getList = CIBlockElement::GetList(array('SORT' => 'ASC'), array('NAME' => $arResult['PROPERTIES']['PROJECT_BRAND_NAME_EN']['VALUE'], 'IBLOCK_ID' => 4));
                                            $getUrl = $getList->GetNext();
                                            $explode = explode('/', $APPLICATION->GetCurDir());

                                            $getUrl['DETAIL_PAGE_URL'] = str_replace('/'.strtolower(LANGUAGE_ID), '', $getUrl['DETAIL_PAGE_URL']);

                                            ?>
                                                <a href="/<?=$explode[1].$getUrl['DETAIL_PAGE_URL']?>" target="_blank" class="orange-text">
                                                    <?
                                                    if($value['VALUE']['TYPE'] != 'HTML'){
                                                        echo $value['VALUE'];
                                                    }else{
                                                        echo $value['VALUE']['TEXT'];
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                        </div>
                                        <?
                                    }else if(stristr($key, LANGUAGE_ID)){
                                        if(stristr($key, 'PRICE')){
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['NAME']?></div>
                                                <div class="right">
                                                    <?
                                                    $areaLot =str_replace(',','.',$arResult['PROPERTIES']['UNIT_SIZE_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                                                    
                                                    //debug($areaLot);
                                                    //debug($priceLot);
                                                    //debug(ceil($priceLot/$areaLot));
                                                    if(LANGUAGE_ID == 'en'){
                                                        $currency = 'USD';
                                                    }else{
                                                        $currency = "RUB";
                                                    }
													if ((CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET']) == 0)or(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD')==0)) {
														if(LANGUAGE_ID == 'en'){ echo'Price on request';} else {echo'Цена по запросу';};
													}else{
														if($_COOKIE['CURRENCY_SET']){
															/*echo CCurrencyLang::CurrencyFormat(
																ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], $currency, $_COOKIE['CURRENCY_SET'])),
																$_COOKIE['CURRENCY_SET']
																);*/
															$priceLot = CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET']);
															echo CCurrencyLang::CurrencyFormat(ceil($priceLot/$areaLot),
															$_COOKIE['CURRENCY_SET']
															);
														}else{
															/*echo CCurrencyLang::CurrencyFormat(
																ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], $currency, 'USD')),
																'USD'
																);*/
															$priceLot = CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD');
															echo CCurrencyLang::CurrencyFormat(ceil($priceLot/$areaLot),
															'USD'
															);
														}
													}
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                        }else{
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['NAME']?></div>
                                                <div class="right">
                                                    <?
                                                    if($value['VALUE']['TYPE'] != 'HTML'){
                                                        echo $value['VALUE'];
                                                    }else{
                                                        echo $value['VALUE']['TEXT'];
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                        }
                                     }
                                     if($key == 'OFFICIAL_SITE'){
                                        ?>
                                        <div class="flex-prop">
                                            <div class="left"><?=GetMessage('OFFICIAL_SITE')?>:</div>
                                            <div class="right">
                                                <?
                                                    if( stristr($value['VALUE'], 'http') === false ){
                                                       $value['VALUE'] = "http://".$value['VALUE'];
                                                    }
                                                ?>
                                                <a href="<?=$value['VALUE']?>" target="_blank" class="orange-text"><?=GetMessage('GO_TO_TEXT')?></a>
                                            </div>
                                        </div>
                                        <?
                                     }
                                }
                                ?>
                            </div>
                        </div>
                        <?
                        $getSku = CIBlockElement::GetList(
                            array('SORT' => 'ASC'),
                            array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                            false,
                            false,
                            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN')
                        );
                        if($fetchSku = $getSku -> Fetch()){
                            $true = 'Y';
                        }
                        if($true){
                            if(isset($arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                || isset($arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                || isset($arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'])
                                || isset($arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'])
                            ){
                                ?>
                                <table class="SKU-items">
                                    <thead>
                                        <tr>
                                            <th><?=GetMessage('FLAT_TYPE')?></th>
                                            <th><?=GetMessage('SQUARE_METRES')?></th>
                                            <th><?=GetMessage('PRICE_FOR_METER')?></th>
                                            <th><?=GetMessage('PRICE_FOR_FLAT')?></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    if(isset($arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                        && $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0] 
                                        && $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1] 
                                        && $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2]){

                                        ?>
                                        <tr class="sku-item">
                                            <td>
                                                <?echo $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'];?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_1_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2];
                                                ?>
                                             </td>
                                             <td>
                                                
                                                <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'?><?='&item='.strtolower('1-room')?>"><?=GetMessage('MORE')?></a>
                                             </td>
                                        </tr>
                                        <?

                                    }
                                    if(isset($arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                        && $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0] 
                                        && $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1] 
                                        && $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2]){

                                        ?>
                                        <tr class="sku-item">
                                            <td>
                                                <?echo $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'];?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_2_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2];
                                                ?>
                                             </td>
                                             <td>
                                                
                                                <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'?><?='&item='.strtolower('1-room')?>"><?=GetMessage('MORE')?></a>
                                             </td>
                                        </tr>
                                        <?

                                    }
                                    if(isset($arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                        && $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0] 
                                        && $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1] 
                                        && $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2]){

                                        ?>
                                        <tr class="sku-item">
                                            <td>
                                                <?echo $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'];?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_3_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2];
                                                ?>
                                             </td>
                                             <td>
                                                
                                                <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'?><?='&item='.strtolower('1-room')?>"><?=GetMessage('MORE')?></a>
                                             </td>
                                        </tr>
                                        <?

                                    }
                                    if(isset($arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME']) 
                                        && $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0] 
                                        && $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1] 
                                        && $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2]){

                                        ?>
                                        <tr class="sku-item">
                                            <td>
                                                <?echo $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['NAME'];?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][0];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][1];
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                echo $arResult['PROPERTIES']['FLAT_4_ROOM_'.strtoupper(LANGUAGE_ID)]['VALUE'][2];
                                                ?>
                                             </td>
                                             <td>
                                                
                                                <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'?><?='&item='.strtolower('1-room')?>"><?=GetMessage('MORE')?></a>
                                             </td>
                                        </tr>
                                        <?

                                    }
                                    ?>
                                        <tr class="all-flats">
                                            <td>
                                                    
                                            </td>
                                            <td>
                                                <?
                                                
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                
                                                ?>
                                             </td>
                                             <td>
                                                
                                                <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y&item=all-flats'?>"><?=GetMessage('ALL_FLATS')?></a>
                                             </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?
                            }
                        }
                        
                        if(!empty($arResult['PROPERTIES']['MESTOPOLOZHENIE']['VALUE'])){?>

                            <div class="placement">
                                <span class="block-title"><?=GetMessage('OBJECT_PLACEMENT')?></span>
                                <?                              

                                   $arPosititon = explode(",", $arResult['PROPERTIES']['MESTOPOLOZHENIE']['VALUE']);?>                 
                                   <?$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                                         "INIT_MAP_TYPE" => "MAP",
                                         "MAP_DATA" => serialize(array(
                                            'google_lat' => $arPosititon[0],
                                            'google_lon' => $arPosititon[1],
                                            'google_scale' => 13,
                                            'PLACEMARKS' => array (
                                               array(
                                                  'TEXT' => $arResult['NAME'],
                                                  'LON' => $arPosititon[1],
                                                  'LAT' => $arPosititon[0],
                                               ),
                                            ),
                                         )),
                                         "MAP_WIDTH" => "600",
                                         "MAP_HEIGHT" => "300",
                                         "CONTROLS" => array(
                                            "SMALL_ZOOM_CONTROL",
                                            "SCALELINE"
                                         ),
                                         "OPTIONS" => array(
                                            "ENABLE_SCROLL_ZOOM",
                                            "ENABLE_DBLCLICK_ZOOM",
                                            "ENABLE_DRAGGING",
                                            "ENABLE_KEYBOARD"
                                         ),
                                         "MAP_ID" => ""
                                      ), 
                                      false
                                   );?>
                            </div>
                        <?}
                        if( $arResult['PROPERTIES']['PLACEMENT_BLOCK']['VALUE_XML_ID'] == 'Y' ){
                            ?>
                            <div class="info-table">
                                <span class="block-title"></span>
                                <div class="placement-props table">
                                    <?if('' != ($arResult['PROPERTIES']['REGION_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['REGION_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['REGION_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right">
                                                <?=str_replace(
                                                    strtolower($arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['NAME']),
                                                    '',
                                                    $arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']
                                                )?>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['STREET_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['METRO_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['METRO_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['METRO_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['HOW_TO_GET_THERE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['HOW_TO_GET_THERE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['HOW_TO_GET_THERE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                        <?
                        if( $arResult['PROPERTIES']['DETAIL_BLOCK']['VALUE_XML_ID'] == 'Y' ){
                            ?>
                            <div class="info-table">
                                <span class="block-title"><?=GetMessage('DETAIL_BLOCK_TEXT')?></span>
                                <div class="detail-block-props table">
                                    <?if('' != ($arResult['PROPERTIES']['HOUSING_CLASS_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['HOUSING_CLASS_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['HOUSING_CLASS_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['FLOOR_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['FLOOR_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['FLOOR_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['CEILING_HEIGHT_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['CEILING_HEIGHT_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['CEILING_HEIGHT_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['BUILDING_TYPE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['BUILDING_TYPE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['BUILDING_TYPE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['FINISH_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['FINISH_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['FINISH_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['WITHOUT_TRASH_CHUTE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['WITHOUT_TRASH_CHUTE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['WITHOUT_TRASH_CHUTE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['PANORAMIC_GLAZING_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['PANORAMIC_GLAZING_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['PANORAMIC_GLAZING_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['PARKING_SPACES_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['PARKING_SPACES_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['PARKING_SPACES_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['INSTALLMENT_PLAN_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['INSTALLMENT_PLAN_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['INSTALLMENT_PLAN_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['FENCED_AREA_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['FENCED_AREA_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['FENCED_AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    
                                    <?if('' != ($arResult['PROPERTIES']['LIVING_SPACE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['LIVING_SPACE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['LIVING_SPACE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if('' != ($arResult['PROPERTIES']['KITCH_SPACE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['KITCH_SPACE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['KITCH_SPACE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <?
                        }
                        ?>
                        <?
                        if( $arResult['PROPERTIES']['WHERE_TO_BUY']['VALUE_XML_ID'] == 'Y'){
                            ?>
                            <div class="info-table">
                                <span class="block-title"><?=GetMessage('WHERE_TO_BUY_TEXT')?></span>
                                <div class="where-to-buy-props table">
                                    <?if('' != ($arResult['PROPERTIES']['DEVELOPER_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['DEVELOPER_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['DEVELOPER_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                    <?if($arResult['PROPERTIES']['AGENCIES_'.strtoupper(LANGUAGE_ID)]['VALUE'] != ''):?>
                                        <div class="flex-prop">
                                            <div class="left"><?=$arResult['PROPERTIES']['AGENCIES_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                            <div class="right"><?=$arResult['PROPERTIES']['AGENCIES_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <?
                        }
                        ?>



                        <div class="description">
                            <div class="max-width">
                                <span class="block-title"><?=GetMessage('DESCRIPTION')?></span>
                                <?
                                $getListItem = CIBlockElement::GetList( 
                                    array('SORT' => 'ASC'), 
                                    array('ID' => $arResult['PROPERTIES']['CML2_LINK']['VALUE']), 
                                    falfe, 
                                    false, 
                                    array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_METRO_'.strtoupper(LANGUAGE_ID), 'PROPERTY_MESTOPOLOZHENIE') 
                                );
                                if($fetchFather = $getListItem -> GetNext()){
                                    $exp = explode(',', $fetchFather['PROPERTY_METRO_'.strtoupper(LANGUAGE_ID).'_VALUE']);
                                    $metro = $exp[0];
                                    $placementMapProp = $fetchFather['PROPERTY_MESTOPOLOZHENIE_VALUE'];
                                }

                                
                                
                                if($arResult['PROPERTY']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'] == '' && LANGUAGE_ID == 'ru'){

                                    $name = $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    if($arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE']){
                                        $address = $arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    }elseif($arResult['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE']){
                                        $address = $arResult['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    }

                                    echo "<p>";
                                        print_r($name.', это стильный дизайн фасадов и удобная планировка жилых пространств, где полностью учитываются потребности жильцов. Покупатели обязательно оценят перспективный район '.$address.', где они будут обеспечены всей необходимой инфраструктурой.');
                                        
                                        print_r('<br />Реализацией проекта занимается: ');
                                        echo $arResult['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    echo "</p>";
                                }else if($arResult['PROPERTY']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'] == '' && LANGUAGE_ID == 'en'){

                                    $name = str_replace($arResult['CODE'], '', $arResult['NAME']);
                                    if($arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE']){
                                        $address = $arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    }elseif($arResult['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE']){
                                        $address = $arResult['PROPERTIES']['ADDRESS1_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    }

                                    echo "<p>";
                                        print_r('A '.$name.', it is a stylish design of facades and convenient layout of living spaces, which fully takes into account the needs of residents. Buyers will appreciate the prospective '.$address.', where they will be provided with all the necessary infrastructure.');
                                        

                                        if($metro){
                                            echo '<br />Subway station'.': '.$metro;
                                        }
                                        print_r('<br />The project is implemented by: ');

                                        echo $arResult['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'];

                                    echo "</p>";
                                }else{
                                    echo "<div class='line-heighted-text'>";
                                        print_r(htmlspecialchars($arResult['PROPERTY']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT']));
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                        

                        <div class="placement">
                            <?
                                /*echo $placementMapProp;
                                echo '<pre>';
                                print_r($arResult);
                                echo '</pre>';*/
                            ?>
                            <span class="block-title"><?=GetMessage('OBJECT_PLACEMENT')?></span>
                            
                                <div class="responsive-box">
                            <?
                            if(!empty($placementMapProp)){?>
                                <?
                                   //$arPosititon = explode(",", $placementMapProp);
                                    $arPosititon = explode(",", $arResult['PROPERTIES']['KARTA']['VALUE']);
                                    /*echo $arResult['PROPERTIES']['KARTA']['VALUE'];
                                    echo '<pre>';
                                    print_r($arPosititon);
                                    echo '</pre>';*/
                                ?>                 
                                   <?$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                                         "INIT_MAP_TYPE" => "MAP",
                                         "MAP_DATA" => serialize(array(
                                            'google_lat' => $arPosititon[0],
                                            'google_lon' => $arPosititon[1],
                                            'google_scale' => 13,
                                            'PLACEMARKS' => array (
                                               array(
                                                  'TEXT' => $arResult['NAME'],
                                                  'LON' => $arPosititon[1],
                                                  'LAT' => $arPosititon[0],
                                               ),
                                            ),
                                         )),
                                         "MAP_WIDTH" => "auto",
                                         "MAP_HEIGHT" => "auto",
                                         "CONTROLS" => array(
                                            "SMALL_ZOOM_CONTROL",
                                            "SCALELINE"
                                         ),
                                         "OPTIONS" => array(
                                            "ENABLE_SCROLL_ZOOM",
                                            "ENABLE_DBLCLICK_ZOOM",
                                            "ENABLE_DRAGGING",
                                            "ENABLE_KEYBOARD"
                                         ),
                                         "MAP_ID" => ""
                                      ), 
                                      false
                                   );?>
                                
                            <?}
                            ?>
                        </div>
                        </div>

                        <div class="ajaxGetCondoPlacement"></div>
                        <div class="ajaxGetCondoSales"></div>
                        <?
                            $getListItem = CIBlockElement::GetList( array('SORT' => 'ASC'), array('ID' => $arResult['PROPERTIES']['CML2_LINK']['VALUE']), falfe, false, array('ID', 'CODE', 'NAME', 'DETAIL_PAGE_URL','IBLOCK_SECTION_ID', 'IBLOCK_ID') );

                            if($fetchFather = $getListItem -> GetNext()){
                                
                                $fetchFather['DETAIL_PAGE_URL'] = str_replace('/'.strtolower(LANGUAGE_ID).'/', '', $fetchFather['DETAIL_PAGE_URL']);

                                $fetchFather["DETAIL_PAGE_URL"] = str_replace('condos', 'developments', $APPLICATION->GetCurDir());

                                $fetchFather["DETAIL_PAGE_URL"] = str_replace($arResult['CODE'], $fetchFather['CODE'], $fetchFather["DETAIL_PAGE_URL"]);
                                ?>
                                <script>
                                    $(document).ready(function(){
                                        $.ajax({
                                          type: "POST",
                                          //type: 'html',
                                          url: '<?=$fetchFather["DETAIL_PAGE_URL"]?>',
                                          success: function(msg){
                                            console.log(msg)
                                            $('.ajaxGetCondoPlacement').html( '<div class="info-table">'+$($.parseHTML(msg)).find('.getByAjaxPlacementProps').html()+'</div>' );
                                            $('.ajaxGetCondoSales').html( '<div class="info-table">'+$($.parseHTML(msg)).find('.getByAjaxSales').html()+'</div>' );
                                          }
                                        });
                                    })
                                </script>
                                <?
                            }
                        ?>
                        

                        <div class="ipoteka background-gray" style="padding: 10px 0 50px;">
                            <span class="block-title" style="padding: 0 15px;color: #4b4b4b;font-size: 32px;font-weight: bold;margin: 30px 0;display: block;"><?=GetMessage('IPOTEKA_BANKS')?></span>
                            <div class="max-width">
                                <div class="flex-banks">
                                    <?
                                    $explode = explode('/', $APPLICATION->GetCurDir());
                                    $xplo = explode('-', $explode[1]);
                                    ?>
                                    <?if($xplo[1] == 'ru'){
                                        ?>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/sberbank.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/transkapitalbank.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/абсолютбанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/банквозрождение.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/втб.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/дельтакредитбанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/металлинвестбанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/открытиебанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/связьбанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/снгббанк.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/Татфондбанк.png">
                                        </div>
                                        <div class="item-bank hollow">
                                        </div>
                                    <?
                                    }elseif($xplo[1] == 'us'){
                                        ?>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/ba.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/blueleaf.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/chase.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/citi.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/eclick.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/fairway.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/FSB.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/Guaranteed Rate.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/HOMESTAR.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/UHL.png">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/WF.png">
                                        </div>
                                        <div class="item-bank hollow">
                                        </div>
                                        <?
                                    }?>

                                </div>
                            </div>
                        </div>
                        <?
                        if(is_array($arResult['PROPERTIES']['HOD_STROITELSTVA']['VALUE'])){?>
                            <div class="etaps">
                                <span class="block-title"><?=GetMessage('BUILDING_STEPS')?></span>
                                <div class="flex-content">
                                    <?
                                    foreach ($arResult['PROPERTIES']['HOD_STROITELSTVA']['VALUE'] as $key => $value) {
                                        $buildSteps[] = $value;
                                    }
                                    ?>
                                    <div class="big-img">
                                        <div class="image-background" <? if( is_numeric($buildSteps[0]) ){?>style="background-image: url('<?=CFile::GetPath($buildSteps[0])?>')"<?}else{ echo "style='background-color: transparent;'"; }?> >
                                            <a data-fancybox="buildSteps" href="<?=CFile::GetPath($buildSteps[0])?>"></a>
                                        </div>
                                    </div>
                                    <div class="img4">
                                        <div class="image-background" <? if( is_numeric($buildSteps[1]) ){?>style="background-image: url('<?=CFile::GetPath($buildSteps[1])?>')"<?}else{ echo "style='background-color: transparent;'"; }?> >
                                            <a data-fancybox="buildSteps" href="<?=CFile::GetPath($buildSteps[1])?>"></a>
                                        </div>
                                        <div class="image-background" <? if( is_numeric($buildSteps[2]) ){?>style="background-image: url('<?=CFile::GetPath($buildSteps[2])?>')"<?}else{ echo "style='background-color: transparent;'"; }?> >
                                            <a data-fancybox="buildSteps" href="<?=CFile::GetPath($buildSteps[2])?>"></a>
                                        </div>
                                        <div class="image-background" <? if( is_numeric($buildSteps[3]) ){?>style="background-image: url('<?=CFile::GetPath($buildSteps[3])?>')"<?}else{ echo "style='background-color: transparent;'"; }?> >
                                            <a data-fancybox="buildSteps" href="<?=CFile::GetPath($buildSteps[3])?>"></a>
                                        </div>
                                        <div class="image-background" <? if( is_numeric($buildSteps[4]) ){?>style="background-image: url('<?=CFile::GetPath($buildSteps[4])?>')"<?}else{ echo "style='background-color: transparent;'"; }?> >
                                            <a data-fancybox="buildSteps" href="<?=CFile::GetPath($buildSteps[4])?>"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?}?>
                    </div>
                    <div class="absolute">
                        <div class="sidebar-right">
                            <?
                            $explo = explode('/', $APPLICATION->GetCurDir());
                            $xplo = explode('-', $explo[1]);
                            ?>
                            <div class="head">
                                <span class="micro-title"><?=GetMessage('CONSULTING_FREELY')?></span>
                                <img class="lozad" data-src="/bitrix/templates/23/images/circle-line.png">
                            </div>
                            <div class="content flex-content">
                                <img class="lozad" data-src="/bitrix/templates/23/images/<?=strtolower($xplo[1])?>-face.jpg" style="border-radius: 50%;height: 165px;width: 165px;">
                                <div class="side-info">
                                    <div class="cons-name">
                                        <?=GetMessage('IO_'.strtolower($xplo[1]))?>
                                    </div>
                                    <div class="job">
                                        <?=GetMessage('JOB_TEXT')?>
                                    </div>
                                    <div class="phone-numb-cons">
                                        <a href="tel:<?=GetMessage('PHONE_SIDEBAR_VALUE_'.strtolower($xplo[1]))?>"><?=GetMessage('PHONE_SIDEBAR_VISUAL_'.strtolower($xplo[1]))?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-cons">
                                <input type="text" name="name" placeholder="<?=GetMessage('WRITE_YOUR_NAME')?>">
                                <input type="text" name="phone" placeholder="<?=GetMessage('WRITE_YOUR_PHONE')?>">
                                <div class="form-cons-submit form-submit" id="hrefButtonSidebarForm">
                                    <?=GetMessage('LEFT_APPLICATION')?>
                                </div>
                                <div class="checkboxAgrementBlockInSidebar">
                                    <input type="checkbox" id="idCheckboxInSidebar" onchange="funcOnchangeCheckboxInSidebar()">
                                    <div class="black">
                                        <?=GetMessage('SENDING_TEXT')?>
                                        <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                                    </div>
                                </div>
                                <div class="checkboxPolicyBlockInSidebar">
                                    <input type="checkbox" id="idCheckboxPolicyInSidebar" onchange="funcOnchangeCheckboxInSidebar()">
                                    <div class="black">
                                        <?=GetMessage('SENDING_TEXT2')?>
                                        <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT2')?></a>
                                    </div>
                                </div>
                                <!--<div class="black">
                                    <?=GetMessage('SENDING_TEXT')?>
                                    <a href="/agreement/" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="preview-product-main carousel-mobile">
    <?
    global $arrFilterSimilar;
    $getListItem = CIBlockElement::GetList( 
        array('SORT' => 'ASC'), 
        array('ID' => $arResult['PROPERTIES']['CML2_LINK']['VALUE']), 
        falfe, 
        false, 
        array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_SELLING_STEP_EN') 
    );
    if($fetchAgain = $getListItem -> GetNext()){
         $getListAgain = CIBlockElement::GetList(
            array('RAND' => 'ASC'), 
            array('PROPERTY_SELLING_STEP_EN' => $fetchAgain['PROPERTY_SELLING_STEP_EN_VALUE']),
            falfe, 
            array('nPageSize' => 15), 
            array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_SELLING_STEP_EN')
        );
        while($fetchListAgain = $getListAgain -> GetNext() ){
            $getListFlats = CIBlockElement::GetList(
                array('RAND' => 'ASC'),
                array('PROPERTY_CML2_LINK' => $fetchListAgain['ID'], 'IBLOCK_ID' => 8),
                falfe,
                array('nTopCount' => 1), 
                array()
            );
            while($fetchListFlats = $getListFlats -> GetNext() ){
                $arrIds[] = $fetchListFlats['ID'];
            }
        }
    }
    
    $arrFilterSimilar['ID'] = $arrIds;
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section", 
        "similarDetail", 
        array(
            "ACTION_VARIABLE" => "action",
            "ADD_PICT_PROP" => "-",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_TO_BASKET_ACTION" => "ADD",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BACKGROUND_IMAGE" => "-",
            "BASKET_URL" => "/personal/basket.php",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COMPATIBLE_MODE" => "Y",
            "COMPONENT_TEMPLATE" => "popularOnMain",
            "CONVERT_CURRENCY" => "N",
            "CUSTOM_FILTER" => "",
            "DETAIL_URL" => "",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_COMPARE" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER" => "asc",
            "ELEMENT_SORT_ORDER2" => "desc",
            "ENLARGE_PRODUCT" => "STRICT",
            "FILTER_NAME" => "arrFilterSimilar",
            "HIDE_NOT_AVAILABLE" => "N",
            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
            "IBLOCK_TYPE" => "catalog",
            "INCLUDE_SUBSECTIONS" => "Y",
            "LABEL_PROP" => array(
            ),
            "LAZY_LOAD" => "N",
            "LINE_ELEMENT_COUNT" => "3",
            "LOAD_ON_SCROLL" => "N",
            "MESSAGE_404" => "",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "OFFERS_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_LIMIT" => "5",
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_ORDER2" => "desc",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Товары",
            "PAGE_ELEMENT_COUNT" => "3",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array(
                0 => "BASE",
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "N",
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
            "PRODUCT_DISPLAY_MODE" => "N",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false}]",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "PROPERTY_CODE_MOBILE" => array(
            ),
            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
            "RCM_TYPE" => "personal",
            "SECTION_CODE" => "",
            "SECTION_ID" => $arResult['IBLOCK_SECTION_ID'],
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SEF_MODE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SHOW_CLOSE_POPUP" => "N",
            "SHOW_DISCOUNT_PERCENT" => "N",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_MAX_QUANTITY" => "N",
            "SHOW_OLD_PRICE" => "N",
            "SHOW_SLIDER" => "Y",
            "SLIDER_INTERVAL" => "3000",
            "SLIDER_PROGRESS" => "N",
            "TEMPLATE_THEME" => "blue",
            "USE_ENHANCED_ECOMMERCE" => "N",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "USE_PRODUCT_QUANTITY" => "N"
        ),
        false
    );?>
    </div>
    <?

    if ($arParams['DISPLAY_COMPARE'])
    {
        $jsParams['COMPARE'] = array(
            'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
            'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
            'COMPARE_PATH' => $arParams['COMPARE_PATH']
        );
    }
    ?>
    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
    <?
}
unset($actualItem, $arResultIds, $jsParams);