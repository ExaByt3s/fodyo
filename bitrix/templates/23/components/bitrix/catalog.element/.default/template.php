 <? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
/*test*/
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
$itemIds = array(
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
<?php
                                $nameValuta = "";
                                $inlineNameValuta = "";
                                    if($_COOKIE['CURRENCY_SET']){
                                        switch ($_COOKIE['CURRENCY_SET']) {
                                           case "RUB":
                                               $nameValuta = "₽";
                                               $inlineNameValuta = (LANGUAGE_ID == "ru") ?"р.": "₽";
                                               break;
                                           case "USD":
                                               $nameValuta = "$";
                                               $inlineNameValuta = "$";
                                               break;
                                           case "EUR":
                                               $nameValuta = "€";
                                               $inlineNameValuta = "€";
                                               break;
                                           default:
                                               break;
                                        }
                                    }else{
                                        $nameValuta = "$";
                                        $inlineNameValuta = "$";
                                    }
                                    if(LANGUAGE_ID == "ru") 
                                    {
                                        $nameValuta = "";
                                    }
                                    ?>
<?
    $APPLICATION->SetAdditionalCSS("/bitrix/templates/23/components/bitrix/catalog.element/.default/CheckBox.css");
    $APPLICATION->AddHeadScript("/bitrix/templates/23/components/bitrix/catalog.element/.default/CheckBox.js");
?>
<div class="breadcrumbs">
    <?$APPLICATION->IncludeComponent(
        "bitrix:breadcrumb", 
        "fodyo_new3", 
        array(
            "PATH" => $APPLICATION->GetCurDir(),
            "SITE_ID" => "s1",
            "START_FROM" => "0",
            "COMPONENT_TEMPLATE" => "fodyo_new3"
        ),
        false
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
                    $xplode = explode('/', $APPLICATION->GetCurDir());
                    $getReq = explode(';', $_REQUEST['item']);
                    $getReqTitle = (LANGUAGE_ID == "ru") ? $getReq : explode(';', $_REQUEST['title']);
                    $plo = explode('-', $getReqTitle[0]);
                    $headerTitlePart = strtoupper($getReqTitle[0]);

                    //echo "<pre style='display:none;'>"; print_r($arResult['DETAIL_PAGE_URL']); echo "</pre>";

                    //$arResult['DETAIL_PAGE_URL'] = str_replace('/'.strtolower(LANGUAGE_ID), '', $arResult['DETAIL_PAGE_URL']);;

                    $detail = explode('/', $arResult['DETAIL_PAGE_URL']);
                    //echo "<pre>"; print_r($detail); echo "</pre>";
                    if(!stristr($detail[1], LANGUAGE_ID.'-')){
                        //echo "<pre style='display:none;'>"; print_r('/'.$xplode[1].$arResult['DETAIL_PAGE_URL']); echo "</pre>";
                        $arResult['DETAIL_PAGE_URL'] = '/'.$xplode[1].$arResult['DETAIL_PAGE_URL'];
                    }

                    //echo "<pre style='display:none;'>"; print_r($arResult['DETAIL_PAGE_URL']); echo "</pre>";

                    if($headerTitlePart == 'STUDIOS'){
                        $getMes = GetMessage($headerTitlePart.'-CONDOS');
                    }elseif($headerTitlePart == "ALL-FLATS"){
                        $getMes = GetMessage('ALL-CONDOS');
                    }elseif($headerTitlePart == "FREE LAYOUT"){
                        $getMes = GetMessage('FREE-LAYOUT');
                    }else{
                        $getMes = $plo[0].' '.GetMessage('BEDROOM-CONDOS');
                    }

                    if(LANGUAGE_ID != 'en'){
                        echo $getMes."<a href=".$arResult['DETAIL_PAGE_URL'].">".str_replace($arResult['CODE'], '', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']).'</a>';
                    }else{
                        echo $getMes."<a href=".$arResult['DETAIL_PAGE_URL'].">".str_replace($arResult['CODE'], '', $arResult['NAME']).'</a>';
                    }
                    ?>
                </span>
            </div>
            <?
           
            ?>
            <div class="flex-sku">
            	<div class="picture-sku">

            		<div class="responsive-box-picture-sku">
            			<div class="item-slide" style="width: 481px;">
            				<?

            				if(is_array($arResult['PROPERTIES']['GALEREYA']['VALUE']) || is_numeric($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]) ){

            					$value = $arResult['PROPERTIES']['GALEREYA']['VALUE'][0];

            					$getArray = CFile::GetFileArray($value);

            					$file = CFile::ResizeImageGet($value, array('width'=>481, 'height'=>271), BX_RESIZE_IMAGE_EXACT, true);
            					?>
            					<img src="<?=$file['src']?>">
            					<?

            				}else{
            					if(is_array($arResult['DETAIL_PICTURE'])){

            						$value = $arResult['DETAIL_PICTURE']['ID'];

            						$getArray = CFile::GetFileArray($value);

            						$file = CFile::ResizeImageGet($value, array('width'=>481, 'height'=>271), BX_RESIZE_IMAGE_EXACT, true);

            						?>
            						<img src="<?=$file['src']?>">
            						<?
            					}elseif(is_array($arResult['PREVIEW_PICTURE'])){

            						$value = $arResult['PREVIEW_PICTURE']['ID'];

            						$getArray = CFile::GetFileArray($value);

            						$file = CFile::ResizeImageGet($value, array('width'=>481, 'height'=>271), BX_RESIZE_IMAGE_EXACT, true);

                                //echo "<pre>"; print_r($arResult['PREVIEW_PICTURE']); echo "</pre>";
            						?>
            						<img src="<?=$file['src']?>">
            						<?
            					}
            				}
            				?>
            			</div>
            		</div>
                </div>
                <div class="map-sku">

                	<div class="responsive-box-map-sku">
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
                		);
                		}
                		?>
                	</div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-content max-width">
        <div class="detail-info">
            <div class="info-table">
                <?
                $getSku = CIBlockElement::GetList(
                    array('PROPERTY_PRICE_'.strtoupper(LANGUAGE_ID).'_VALUE' => 'ASC'),
                    array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE')
                );
                if($fetchList = $getSku->GetNext()){?>
                <span class="block-title">
                    <?
                    echo GetMessage('SKU_BLOCK_PAGE_TEXT_STATIC');//.strtoupper($_REQUEST['item']));
                    ?>
                </span>     
                    <div class="flex-filter sku-filter" data-section-id="">
                        <div class="filter-item">
                            <div class="opener"><span class="chosen_value"></span><?=GetMessage("TEXT_ROOM")?> <span class="arrow-down"></span></div>
                            <div class="closed selector">
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BEDS">
                                    <span class="checkbox-text">1</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BEDS">
                                    <span class="checkbox-text">2</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BEDS">
                                    <span class="checkbox-text">3</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BEDS">
                                    <span class="checkbox-text">4+</span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("PRICE_TEXT")?> <?
                            if($_COOKIE['CURRENCY_SET']){
                                GetMessage("CURRENCY_".$_COOKIE['CURRENCY_SET']);
                            }else{
                                GetMessage("CURRENCY_USD");
                            }
                            ?> <span class="arrow-down"></span></div>
                            <div class="closed numerics">
                                <div class="text-inputs">
                                    <input type="text" name="PRICE_FROM" placeholder="<?=GetMessage('TEXT_FROM')?>">
                                    <input type="text" name="PRICE_TO" placeholder="<?=GetMessage('TEXT_TO')?>">
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("AREA_TEXT")?> <span class="arrow-down"></span></div>
                            <div class="closed numerics">
                                <div class="text-inputs">
                                    <input type="text" name="SQUARE_AREA_FROM" placeholder="<?=GetMessage('TEXT_FROM')?>">
                                    <input type="text" name="SQUARE_AREA_TO" placeholder="<?=GetMessage('TEXT_TO')?>">
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="clear-btn">
                                <div class="oranage-round-arrow"></div>
                                <div class="btn-text"><?=GetMessage('CLEAR')?></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-head sku-items-head">
                        <div class="type">
                            <div class="table-content-full-size"><?=GetMessage('SKU_TYPE_TEXT_FS')?></div>
                            <div class="table-content-mobile-size"><?=GetMessage('SKU_TYPE_TEXT_MS')?></div>
                        <!-- ?=GetMessage("SKU_TYPE_TEXT");?> -->
                        </div>
                        <div class="square">
                            <div class="table-content-full-size"><?=GetMessage('SKU_SQUARE_TEXT_FS')?></div>
                            <div class="table-content-mobile-size"><?=GetMessage('SKU_SQUARE_TEXT_MS')?></div>
                            <!-- ?=GetMessage("SKU_SQUARE_TEXT");?> -->
                        </div>
                        <div class="floor">
                            <div class="table-content-full-size"><?=GetMessage('SKU_FLOOR_TEXT_FS')?></div>
                            <div class="table-content-mobile-size"><?=GetMessage('SKU_FLOOR_TEXT_MS')?></div>
                            <!-- ?=GetMessage("SKU_FLOOR_TEXT");?> -->
                        </div>
                        <div class="price">
                            <div class="table-content-full-size"><?=GetMessage('SKU_PRICE_TEXT_FS')?></div>
                            <div class="table-content-mobile-size"><?=GetMessage('SKU_PRICE_TEXT_MS', Array ("#VALUTA#" => $nameValuta, "#INLINE_VALUTA#" => $inlineNameValuta))?></div>
                            <!-- ?=GetMessage("SKU_PRICE_TEXT");?> -->
                        </div>
                    </div>
                    <div class="table sku-items">
                   
                        <?
                        $getSku = CIBlockElement::GetList(
                            array('PROPERTY_PRICE_'.strtoupper(LANGUAGE_ID).'_VALUE' => 'ASC'),
                            array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                            false,
                            false,
                            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_'.strtoupper(LANGUAGE_ID))
                        );

                        $getItemsReq = explode(';', $_REQUEST['item']);
                        //debug($getItemsReq);
                        while ($fetchList = $getSku->GetNext()) {
                            
                            //debug($fetchList);
                            if($_REQUEST['item'] == 'all-flats' || !isset($_REQUEST['item'])){
                                $arrAdd[] = $fetchList['ID'];
                            }else{
                                foreach ($getItemsReq as $key2 => $valueReq) {
                                    $fetchList['PROPERTY_FLAT_TYPE_VALUE'] = str_replace('Свободная планировка', 'Free Layout', $fetchList['PROPERTY_FLAT_TYPE_VALUE']);
                                    if( isset($valueReq) && 
                                        ($valueReq == strtolower(str_replace('комн', 'bed', $fetchList['PROPERTY_FLAT_TYPE_VALUE'])) || $valueReq == strtolower(str_replace('Студия', 'study', $fetchList['PROPERTY_FLAT_TYPE_VALUE']))) 
                                        && $valueReq != 'all-flats' && $valueReq != '4-bed')
                                        {
                                            $arrAdd[] = $fetchList['ID'];
                                    }
                                    else if(stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], $valueReq) && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], '1'.$valueReq) && isset($valueReq) && $valueReq != '4-bed')
                                    {
                                        $arrAdd[] = $fetchList['ID'];
                                    }
                                    else if( 
                                        ( stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('bed', 'комн', $valueReq)) || stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('studios', 'Студия', $valueReq)) )
                                            && isset($valueReq) && $valueReq != '4-bed' && !stristr($fetchList['PROPERTY_FLAT_TYPE_VALUE'], str_replace('bed', 'комн', '1'.$valueReq)) )
                                        {
                                            $arrAdd[] = $fetchList['ID'];

                                    }
                                    else if($valueReq == '4-bed'){
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
                            /*$getSku = CIBlockElement::GetList(
                                array('PROPERTY_PRICE_'.strtoupper(LANGUAGE_ID).'_VALUE' => 'ASC'),
                                array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_'.strtoupper(LANGUAGE_ID))
                            );
                            while ($fetchList = $getSku->GetNext()) {
                                $arrAdd[] = $fetchList['ID'];
                            }*/
                        }
                        global $arrFilterSKU;
                        $arrFilterSKU = array('ID' => $arrAdd);


                        if(is_array($arrAdd) && $arrAdd[0] != ''){
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
                                    "DETAIL_URL" => '/condos/#ELEMENT_CODE#',
                                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                    "DISPLAY_BOTTOM_PAGER" => "Y",
                                    "DISPLAY_COMPARE" => "N",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "ELEMENT_SORT_FIELD" => "property_PRICE_".strtoupper(LANGUAGE_ID),
                                    "ELEMENT_SORT_FIELD2" => "property_PRICE_".strtoupper(LANGUAGE_ID),
                                    "ELEMENT_SORT_ORDER" => "asc,nulls",
                                    "ELEMENT_SORT_ORDER2" => "asc,nulls",
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
                                    "PAGER_TEMPLATE" => "round",
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
                            );
                        }?>
                    </div>
                <?}?>
            </div>
            <div class="info-table">
                <span class="block-title"><?=GetMessage('PROPERTIES_TITLE_SKU')?></span>
                <div class="table">
                  <?
                  if(is_numeric($arResult['CODE'])){
                      ?>
                      <div class="flex-prop">
                          <div class="left"><?=GetMessage('FLAT_ID')?></div>
                          <div class="right"><?=$arResult['CODE']?></div>
                      </div>
                      <?
                  }
                  foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $value) {

                    if( ($key == "PRICE_FROM_EN" || $key == "PRICE_TO_EN" || $key == "PRICE_SQFT_EN" || $key == 'PRICE_EN' || $key == "PRICE_PER_SQFT_EN") && LANGUAGE_ID == 'en'){
                      if($value['VALUE'] != '' && $value['VALUE'] != '0'){
                        ?>
                        <div class="flex-prop">
                            <div class="left"><?=$value['NAME']?></div>
                            <div class="right">
                                <?
                                if($_COOKIE['CURRENCY_SET']){
                                    echo CCurrencyLang::CurrencyFormat(
                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'USD', $_COOKIE['CURRENCY_SET'])),
                                        $_COOKIE['CURRENCY_SET']
                                    );
                                }else{
                                    echo CCurrencyLang::CurrencyFormat(
                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'USD', 'USD')),
                                        'USD'
                                    );
                                }
                                ?>
                            </div>
                        </div>
                        <?
                      }else{
                          $keyNew = str_replace('RU', 'EN', $key);
                        if($arResult['PROPERTIES'][$keyNew]['VALUE'] != '' && $arResult['PROPERTIES'][$keyNew]['VALUE'] != '0'){
                          ?>
                          <div class="flex-prop">
                              <div class="left"><?=$value['VALUE']?></div>
                              <div class="right">
                                <?
                                $val =  round((float)(float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 
                                if($_COOKIE['CURRENCY_SET']){
                                    echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($val, 'RUB', $_COOKIE['CURRENCY_SET'])),
                                      $_COOKIE['CURRENCY_SET']
                                    );
                                }else{
                                    echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($val, 'RUB', 'USD')),
                                      'USD'
                                    );
                                }?>
                              </div>
                          </div>
                          <?
                        }
                      }
                    }
                    else if(($key == "PRICE_FROM_RU" || $key == "PRICE_TO_RU" || $key == "PRICE_SQFT_RU" || $key == 'PRICE_RU' || $key == "PRICE_PER_SQFT_RU") && LANGUAGE_ID == 'ru'){
                      if($value['VALUE'] != '' && $value['VALUE'] != '0'){
                        ?>
                        <div class="flex-prop">
                            <div class="left"><?=$value['NAME']?></div>
                            <div class="right">
                                <?
                                if($_COOKIE['CURRENCY_SET']){
                                  echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'RUB', $_COOKIE['CURRENCY_SET'])),
                                      $_COOKIE['CURRENCY_SET']
                                  );
                                }else{
                                    echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'RUB', 'USD')),
                                      'USD'
                                  );
                                }
                                ?>
                            </div>
                        </div>
                        <?
                      }else{
                          $keyNew = str_replace('RU', 'EN', $key);
                        if($arResult['PROPERTIES'][$keyNew]['VALUE'] != '' && $arResult['PROPERTIES'][$keyNew]['VALUE'] != '0'){
                          ?>
                          <div class="flex-prop">
                              <div class="left"><?=$value['VALUE']?></div>
                              <div class="right">
                                  <?
                                if($_COOKIE['CURRENCY_SET']){
                                    $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 
                                    echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($val, 'USD', $_COOKIE['CURRENCY_SET'])),
                                      $_COOKIE['CURRENCY_SET']
                                    );
                                }else{
                                    $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 
                                    echo CCurrencyLang::CurrencyFormat(
                                      ceil(CCurrencyRates::ConvertCurrency($val, 'USD', 'USD')),
                                      'USD'
                                    );
                                  
                                }?>
                              </div>
                          </div>
                          <?
                        }
                      }
                    }
                    else if( ($key == "UNIT_SIZE_EN" || $key == "UNIT_SIZE_FROM_EN" || $key == "UNIT_SIZE_TO_EN") && LANGUAGE_ID == 'en'){

                      if($value['VALUE'] != ''){
                        ?>
                        <div class="flex-prop">
                            <div class="left"><?=$value['NAME']?></div>
                            <div class="right">
                                <?
                                  echo number_format($value['VALUE'], 0, '', ' ').' sq.ft.';
                                ?>
                            </div>
                        </div>
                        <?
                      }else{
                          $keyNew = str_replace('RU', 'EN', $key);
                        if($arResult['PROPERTIES'][$keyNew]['VALUE'] != ''){
                          ?>
                          <div class="flex-prop">
                              <div class="left"><?=$value['VALUE']?></div>
                              <div class="right">
                                  <?
                                    $val =  round( (float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE']/10.764 )); 
                                    echo number_format($val, 2, ',', ' ').' sq.ft.';
                                  ?>
                              </div>
                          </div>
                          <?
                        }
                      }
                    }else if(($key == "UNIT_SIZE_RU" || $key == "UNIT_SIZE_FROM_RU" || $key == "UNIT_SIZE_TO_RU") && LANGUAGE_ID == 'ru'){
                      //echo "<pre>"; print_r(floatval(str_replace(',', '.', $value['VALUE']))); echo "</pre>";
                      //echo "<pre>"; print_r($key); echo "</pre>";
                      if($value['VALUE'] != ''){
                        ?>
                        <div class="flex-prop">
                            <div class="left"><?=$value['NAME']?></div>
                            <div class="right">
                                <?
                                  echo number_format(floatval(str_replace(',', '.', $value['VALUE'])), 2, ',', ' ').' м<sup>2</sup>';
                                ?>
                            </div>
                        </div>
                        <?
                      }else{
                        //echo "<pre>"; print_r($key); echo "</pre>";
                        $keyNew = str_replace('RU', 'EN', $key);
                        if($arResult['PROPERTIES'][$keyNew]['VALUE'] != ''){
                          ?>
                          <div class="flex-prop">
                              <div class="left"><?=$value['VALUE']?></div>
                              <div class="right">
                                  <?
                                    $val =  round( floatval ($arResult['PROPERTIES'][$keyNew]['VALUE'])/10.764 ); 
                                    echo number_format(floatval(str_replace(',', '.', $val)), 2, ',', ' ').' м<sup>2</sup>';
                                  ?>
                              </div>
                          </div>
                          <?
                        }
                      }
                    }else if(stristr($key, LANGUAGE_ID)){
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
                                <a href="<?=$value['VALUE']?>" rel="nofollow" target="_blank" class="orange-text"><?=GetMessage('GO_TO_TEXT')?></a>
                            </div>
                        </div>
                        <?
                      }
                    }
                  }
                  ?>
              </div>
            </div>
        </div>
    </div>

<?
}else{?>
    <div class="sidebar-block  max-width">
        <div class="max-width">
            <div class="detail-block">
                <div class="block-title">
                    <span style="text-align: left;">
                        <?
                        /*if(LANGUAGE_ID != 'en'){
                            echo str_replace($arResult['CODE'], '', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                        }else{
                            echo str_replace($arResult['CODE'], '', $arResult['NAME']);
                        }*/
                        ?>    
                    </span>
                </div>
                <?
                

                $getArray = CFile::GetFileArray($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]);
                ?>
                <div class="picture-slider">
                    <?
                    if(is_array($arResult['PROPERTIES']['GALEREYA']['VALUE']) && (is_array($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_numeric($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]))){
                        foreach ($arResult['PROPERTIES']['GALEREYA']['VALUE'] as $key => $value){

                            $getArray = CFile::GetFileArray($value);
                            $resolution = $getArray['WIDTH']/$getArray['HEIGHT'];

                            //echo "<pre>"; print_r($value); echo "</pre>";

                            $file = CFile::ResizeImageGet($value, array('width'=>390, 'height'=>185), BX_RESIZE_IMAGE_EXACT, true);

                            //echo "<pre>"; print_r($file); echo "</pre>";
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="tryFancy" href="<?=CFile::GetPath($value)?>"><img class="lozad" data-src="<?=$file['src']?>"></a>
                            </div>
                            <?
                        }
                    }else{
                        if(is_array($arResult['DETAIL_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="tryFancy" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }elseif(is_array($arResult['PREVIEW_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="tryFancy" href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>
                <div class="newFancy" style="display: none;">
                    <?
                    if(is_array($arResult['PROPERTIES']['GALEREYA']['VALUE']) && (is_array($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_numeric($arResult['PROPERTIES']['GALEREYA']['VALUE'][0]))){
                        foreach ($arResult['PROPERTIES']['GALEREYA']['VALUE'] as $key => $value){

                            $getArray = CFile::GetFileArray($value);
                            $resolution = $getArray['WIDTH']/$getArray['HEIGHT'];

                            //echo "<pre>"; print_r($value); echo "</pre>";

                            $file = CFile::ResizeImageGet($value, array('width'=>390, 'height'=>185), BX_RESIZE_IMAGE_EXACT, true);

                            //echo "<pre>"; print_r($file); echo "</pre>";
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="newFancy" href="<?=CFile::GetPath($value)?>"><img class="lozad" data-src="<?=$file['src']?>"></a>
                            </div>
                            <?
                        }
                    }else{
                        if(is_array($arResult['DETAIL_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="newFancy" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }elseif(is_array($arResult['PREVIEW_PICTURE'])){
                            ?>
                            <div class="item-slide" style="width: 390px; margin-left: 5px; margin-right: 5px;height: 185px; overflow: hidden;">
                                <a class="newFancy" href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"><img class="lozad" data-src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>"></a>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>
                <div class="flex-content">

                    <div class="detail-info">
                    
                             <!--?php echo "<pre>"; print_r($arResult['DISPLAY_PROPERTIES']); echo "</pre>"; ?-->
                        <div>
                            <div class="info-table">
                                <div class="block-title">
                                    <span style="text-align: left;">
                                    <?
                                        if(LANGUAGE_ID != 'en'){
                                            echo str_replace($arResult['CODE'], '', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                                        }else{
                                            echo str_replace($arResult['CODE'], '', $arResult['NAME']);
                                        }
                                    ?>
                                    </span>
                                    <?
                                    echo '<div class="address_under_title">'.$arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'].'</div>';
                                    ?>
                                </div>
                                <div class="table">
                                    <?
                                    if(is_numeric($arResult['CODE'])){
                                        ?>
                                        <div class="flex-prop">
                                            <div class="left"><?=GetMessage('FLAT_ID')?></div>
                                            <div class="right"><?=$arResult['CODE']?></div>
                                        </div>
                                        <?
                                    }
                                    foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $value) {

                                      if( ($key == "PRICE_FROM_EN" || $key == "PRICE_TO_EN" || $key == "PRICE_SQFT_EN" || $key == 'PRICE_EN' || $key == "PRICE_PER_SQFT_EN") && LANGUAGE_ID == 'en'){
                                        if($value['VALUE'] != '' && $value['VALUE'] != '0'){
                                          ?>
                                          <div class="flex-prop">
                                              <div class="left"><?=$value['NAME']?></div>
                                              <div class="right">
                                                  <?
                                                if($_COOKIE['CURRENCY_SET']){
                                                    echo CCurrencyLang::CurrencyFormat(
                                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'USD', $_COOKIE['CURRENCY_SET'])),
                                                        $_COOKIE['CURRENCY_SET']
                                                    );
                                                }else{
                                                    echo CCurrencyLang::CurrencyFormat(
                                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'USD', 'USD')),
                                                        'USD'
                                                    );
                                                }
                                                    
                                                  ?>
                                              </div>
                                          </div>
                                          <?
                                        }else{
                                            $keyNew = str_replace('RU', 'EN', $key);
                                          if($arResult['PROPERTIES'][$keyNew]['VALUE'] != '' && $arResult['PROPERTIES'][$keyNew]['VALUE'] != '0'){
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['VALUE']?></div>
                                                <div class="right">
                                                    <?
                                                    if($_COOKIE['CURRENCY_SET']){
                                                        $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 

                                                        echo CCurrencyLang::CurrencyFormat(
                                                            ceil(CCurrencyRates::ConvertCurrency($val, 'RUB', $_COOKIE['CURRENCY_SET'])),
                                                            $_COOKIE['CURRENCY_SET']
                                                        );
                                                    }else{
                                                        $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 

                                                        echo CCurrencyLang::CurrencyFormat(
                                                            ceil(CCurrencyRates::ConvertCurrency($val, 'RUB', 'USD')),
                                                            'USD'
                                                        );
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                          }
                                        }
                                      }
                                      else if(($key == "PRICE_FROM_RU" || $key == "PRICE_TO_RU" || $key == "PRICE_SQFT_RU" || $key == 'PRICE_RU' || $key == "PRICE_PER_SQFT_RU") && LANGUAGE_ID == 'ru'){
                                        if($value['VALUE'] != '' && $value['VALUE'] != '0'){
                                          ?>
                                          <div class="flex-prop">
                                              <div class="left"><?=$value['NAME']?></div>
                                              <div class="right">
                                                  <?
                                                if($_COOKIE['CURRENCY_SET']){
                                                    echo CCurrencyLang::CurrencyFormat(
                                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'RUB', $_COOKIE['CURRENCY_SET'])),
                                                        $_COOKIE['CURRENCY_SET']
                                                    );
                                                }else{
                                                    echo CCurrencyLang::CurrencyFormat(
                                                        ceil(CCurrencyRates::ConvertCurrency($value['VALUE'], 'RUB', 'USD')),
                                                        'USD'
                                                    );
                                                }
                                                    
                                                  ?>
                                              </div>
                                          </div>
                                          <?
                                        }else{
                                            $keyNew = str_replace('RU', 'EN', $key);
                                          if($arResult['PROPERTIES'][$keyNew]['VALUE'] != '' && $arResult['PROPERTIES'][$keyNew]['VALUE'] != '0'){
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['VALUE']?></div>
                                                <div class="right">
                                                    <?
                                                    if($_COOKIE['CURRENCY_SET']){
                                                        $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 
                                                        echo CCurrencyLang::CurrencyFormat(
                                                            ceil(CCurrencyRates::ConvertCurrency($val, 'USD', $_COOKIE['CURRENCY_SET'])),
                                                            $_COOKIE['CURRENCY_SET']
                                                        );
                                                    }else{
                                                        $val =  round((float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE'])); 
                                                        echo CCurrencyLang::CurrencyFormat(
                                                            ceil(CCurrencyRates::ConvertCurrency($val, 'USD', 'USD')),
                                                            'USD'
                                                        );
                                                        
                                                    
                                                    }?>
                                                </div>
                                            </div>
                                            <?
                                          }
                                        }
                                      }
                                      else if( ($key == "UNIT_SIZE_EN" || $key == "UNIT_SIZE_FROM_EN" || $key == "UNIT_SIZE_TO_EN") && LANGUAGE_ID == 'en'){

                                        if($value['VALUE'] != ''){
                                          ?>
                                          <div class="flex-prop">
                                              <div class="left"><?=$value['NAME']?></div>
                                              <div class="right">
                                                  <?
                                                    echo number_format($value['VALUE'], 0, '', ' ').' sq.ft.';
                                                  ?>
                                              </div>
                                          </div>
                                          <?
                                        }else{
                                            $keyNew = str_replace('RU', 'EN', $key);
                                          if($arResult['PROPERTIES'][$keyNew]['VALUE'] != ''){
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['VALUE']?></div>
                                                <div class="right">
                                                    <?
                                                      $val =  round( (float)str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE']/10.764 )); 
                                                      echo number_format($val, 2, ',', ' ').' sq.ft.';
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                          }
                                        }
                                      }else if(($key == "UNIT_SIZE_RU" || $key == "UNIT_SIZE_FROM_RU" || $key == "UNIT_SIZE_TO_RU") && LANGUAGE_ID == 'ru'){
                                        //echo "<pre>"; print_r(floatval(str_replace(',', '.', $value['VALUE']))); echo "</pre>";
                                        //echo "<pre>"; print_r($key); echo "</pre>";
                                        if($value['VALUE'] != ''){
                                          ?>
                                          <div class="flex-prop">
                                              <div class="left"><?=$value['NAME']?></div>
                                              <div class="right">
                                                  <?
                                                    echo number_format(floatval(str_replace(',', '.', $value['VALUE'])), 2, ',', ' ').' м<sup>2</sup>';
                                                  ?>
                                              </div>
                                          </div>
                                          <?
                                        }else{
                                          //echo "<pre>"; print_r($key); echo "</pre>";
                                          $keyNew = str_replace('RU', 'EN', $key);
                                          if($arResult['PROPERTIES'][$keyNew]['VALUE'] != ''){
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$value['VALUE']?></div>
                                                <div class="right">
                                                    <?
                                                      $val =  round( floatval (str_replace(',', '.', $arResult['PROPERTIES'][$keyNew]['VALUE']))/10.764 ); 
                                                      echo number_format(floatval(str_replace(',', '.', $val)), 2, ',', ' ').' м<sup>2</sup>';
                                                    ?>
                                                </div>
                                            </div>
                                            <?
                                          }
                                        }
                                      }else if(stristr($key, LANGUAGE_ID)){
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
                                                  <a href="<?=$value['VALUE']?>" rel="nofollow" target="_blank" class="orange-text"><?=GetMessage('GO_TO_TEXT')?></a>
                                              </div>
                                          </div>
                                          <?
                                        }
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
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN', 
                                    'PROEPRTY_NAME_'.strtoupper(LANGUAGE_ID), 'PROPERTY_PRICE_PER_SQFT_RU', 'PROPERTY_PRICE_PER_SQFT_EN', 'PROPERTY_SQUARE_AREA', 'PROPERTY_BEDS_EN')
                            );
                            while($fetchSku = $getSku -> Fetch()){
                                
                                //debug($fetchSku);
                                if(LANGUAGE_ID == 'en'){
                                    //debug($fetchSku);
                                    $nameSku = $fetchSku['NAME'];
                                    //debug(strpos($fetchSku['PROPERTY_FLAT_TYPE_VALUE'], 'Студия'));
                                    if(strpos($fetchSku['PROPERTY_FLAT_TYPE_VALUE'], 'Свободная планировка') !== false || strpos($fetchSku['PROPERTY_FLAT_TYPE_VALUE'], 'Студия') !== false)
                                    {
                                        $fetchSku['PROPERTY_FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('Свободная планировка', 'Free Layout', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                        $fetchSku['PROPERTY_FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('Студия', 'Studios', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    }
                                    else {
                                        $fetchSku['PROPERTY_FLAT_TYPE_VALUE_NAME_ROW'] = $fetchSku['PROPERTY_BEDS_EN_VALUE'].'-bed';
                                    }
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE'] = str_replace('Свободная планировка', 'Free Layout', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE'] = str_replace('комнатная квартира', 'bed', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE'] = str_replace('комн', 'bed', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE'] = str_replace('Студия', 'Studios', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    /*$fetchSku['PROPERTY_FLAT_TYPE_VALUE_FOR_URL'] = str_replace('Свободная планировка', 'Free Layout', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE_FOR_URL'] = str_replace('комнатная квартира', 'bed', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE_FOR_URL'] = str_replace('комн', 'bed', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE_FOR_URL'] = str_replace('Студия', 'Studios', $fetchSku['PROPERTY_FLAT_TYPE_VALUE']);*/
                                    
                                    
                                    
                                }else{
                                    $nameSku = $fetchSku['PROEPRTY_NAME_'.strtoupper(LANGUAGE_ID)];
                                    $fetchSku['PROPERTY_FLAT_TYPE_VALUE_NAME_ROW'] = $fetchSku['PROPERTY_FLAT_TYPE_VALUE'];
                                    //$fetchSku['PROPERTY_FLAT_TYPE_VALUE_FOR_URL'] = $fetchSku['PROPERTY_FLAT_TYPE_VALUE'];
                                }

                                $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE'] = str_replace(',', '.', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE']);
                                $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE'] = str_replace(',', '.', $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']);

                                if(is_numeric($fetchSku['PROPERTY_PRICE_EN_VALUE']) || is_numeric($fetchSku['PROPERTY_PRICE_RU_VALUE'])){
                                    if(is_numeric($fetchSku['PROPERTY_PRICE_EN_VALUE'])){

                                        $priceSKU['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'] );
                                        $priceSKU['CURRENCY'] = 'USD';
                                    }else{
                                        $priceSKU['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']);
                                        $priceSKU['CURRENCY'] = 'RUB';
                                    }
                                }

                                if(is_numeric($fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) || is_numeric($fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE'])){
                                    if(is_numeric($fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE'])){

                                        $priceSKUArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE'] );
                                        $priceSKUArea['CURRENCY'] = 'USD';
                                    }else{
                                        $priceSKUArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE']);
                                        $priceSKUArea['CURRENCY'] = 'RUB';
                                    }
                                }else{
                                    if(is_numeric($fetchSku['PROPERTY_PRICE_EN_VALUE']) || is_numeric($fetchSku['PROPERTY_PRICE_RU_VALUE'])){
                                        if(is_numeric($fetchSku['PROPERTY_PRICE_EN_VALUE'])){

                                            $priceSKUArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']);
                                            if(LANGUAGE_ID == 'en'){
                                                $priceSKUArea['VAL'] = $priceSKUArea['VAL']/(10.764*(float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE']));
                                            }else{
                                                $priceSKUArea['VAL'] = $priceSKUArea['VAL']/(float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE']);
                                            }
                                            $priceSKUArea['CURRENCY'] = 'USD';
                                        }else{
                                            $priceSKUArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']);
                                            if(LANGUAGE_ID == 'en'){
                                                $priceSKUArea['VAL'] = $priceSKUArea['VAL']/(10.764*(float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE']));
                                            }else{
                                                $priceSKUArea['VAL'] = $priceSKUArea['VAL']/(float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE']);
                                            }
                                            $priceSKUArea['CURRENCY'] = 'RUB';
                                        }
                                    }
                                }
                                //echo "<hr />";

                                if(LANGUAGE_ID == 'en'){
                                    $squareArea = round((10.764*(float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE'])));
                                    //echo "<pre style='display:none;'>"; print_r(array($fetchSku['PROPERTY_SQUARE_AREA_VALUE'], (float)str_replace(',', '.', $fetchSku['PROPERTY_SQUARE_AREA_VALUE']))); echo "</pre>";
                                    //$squareArea .= ' sq.ft.';
                                }else{
                                    $squareArea = $fetchSku['PROPERTY_SQUARE_AREA_VALUE'];
                                } 
                                
                                //echo "<pre>"; print_r($fetchSku['PROPERTY_SQUARE_AREA_VALUE']); echo "</pre>";
                                //echo "<pre>"; print_r($fetchSku['PROPERTY_FLAT_TYPE_VALUE']); echo "</pre>";

                                $arrResFlats[$fetchSku['PROPERTY_FLAT_TYPE_VALUE']][] = array( 
                                    'NAME' => $nameSku, 
                                    'FLAT_TYPE' => $fetchSku['PROPERTY_FLAT_TYPE_VALUE'],
                                    'FLAT_TYPE_VALUE_NAME_ROW' => $fetchSku['PROPERTY_FLAT_TYPE_VALUE_NAME_ROW'], 
                                    'PRICE' => array( 'VALUE' => $priceSKU['VAL'], 'CURRENCY' => $priceSKU['CURRENCY'] ),
                                    'PRICE_FOR_AREA' => array( 'VALUE' => $priceSKUArea['VAL'], 'CURRENCY' => $priceSKUArea['CURRENCY'] ),
                                    'SQUARE_AREA' => $squareArea
                                );
                            }
                            //debug($arrResFlats);
                            //echo '<pre>'; print_r($arrResFlats); echo '</pre>';
                            if(is_array($arrResFlats)){
                                ?>
                                
                                <table class="SKU-items">
                                    <thead>
                                        <tr>
                                            <th>
                                            <div class="table-content-full-size"><?=GetMessage('FLAT_TYPE_FS')?></div>
                                            <div class="table-content-mobile-size"><?=GetMessage('FLAT_TYPE_MS')?></div>
                                            </th>
                                            <th>
                                            <div class="table-content-full-size"><?=GetMessage('SQUARE_METRES_FS')?></div>
                                            <div class="table-content-mobile-size"><?=GetMessage('SQUARE_METRES_MS')?></div>
                                            </th>
                                            <th>
                                            <div class="table-content-full-size"><?=GetMessage('PRICE_FOR_METER_FS')?></div>
                                            <div class="table-content-mobile-size"><?=GetMessage('PRICE_FOR_METER_MS', Array ("#VALUTA#" => $nameValuta, "#INLINE_VALUTA#" => $inlineNameValuta));?></div>
                                            </th>
                                            <th>
                                            <div class="table-content-full-size"><?=GetMessage('PRICE_FOR_FLAT_FS')?></div>
                                            <div class="table-content-mobile-size"><?=GetMessage('PRICE_FOR_FLAT_MS', Array ("#VALUTA#" => $nameValuta, "#INLINE_VALUTA#" => $inlineNameValuta))?></div>
                                            </th>
                                            <th align="right">
                                            <div class="table-content-full-size"><?=GetMessage('MORE_FS')?></div>
                                            <div class="table-content-mobile-size"><?=GetMessage('MORE_MS')?></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    ksort($arrResFlats, SORT_NATURAL);
                                    foreach ($arrResFlats as $type => $arrFlats) {
                                        foreach ($arrFlats as $key => $itemFlat) {
                                            if(!is_array($minFlat)){
                                                $minFlat = $itemFlat;
                                            }
                                            if($itemFlat['PRICE']['VALUE'] < $minFlat['PRICE']['VALUE']){
                                                $minFlat['PRICE']['VALUE'] = $itemFlat['PRICE']['VALUE'];
                                            }

                                            if($itemFlat['SQUARE_AREA'] < $minFlat['SQUARE_AREA']){
                                                $minFlat['SQUARE_AREA'] = $itemFlat['SQUARE_AREA'];
                                            }

                                            if($itemFlat['PRICE_FOR_AREA']['VALUE'] < $minFlat['PRICE_FOR_AREA']['VALUE']){

                                            }
                                        }
                                        ?>
                                        <tr class="sku-item">
                                            <td>
                                            <div class="table-content-full-size"><?echo $minFlat['FLAT_TYPE_VALUE_NAME_ROW'];?></div>
                                            <div class="table-content-mobile-size"><?
                                            $search = array('-комнатная квартира','-bed', 'Студия', 'Studios');
                                            $replace = array('','','Ст.', 'St.');
                                            echo str_replace($search, $replace, $minFlat['FLAT_TYPE_VALUE_NAME_ROW']);?>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="table-content-full-size"><?echo strtolower(GetMessage('TEXT_FROM')).' '.$minFlat['SQUARE_AREA'];?></div>
                                            <div class="table-content-mobile-size"><?echo str_replace(' м²','',$minFlat['SQUARE_AREA']);?></div>
                                            </td>
                                            <td>
                                                <?
                                                
                                                if(isset($minFlat['PRICE_FOR_AREA']['VALUE']) && $minFlat['PRICE_FOR_AREA']['VALUE'] != '' && $minFlat['PRICE_FOR_AREA']['VALUE'] != 0){
                                                    
                                                    
                                                    if($_COOKIE['CURRENCY_SET']){
                                                        //echo FormatNumber($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'], false);
                                                        //echo FormatNumber($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'], true);
                                                        
                                                        //echo "<div class=\"table-content-full-size\">".strtolower(GetMessage('TEXT_FROM')).' '. CCurrencyLang::CurrencyFormat(
                                                        //    ceil(CCurrencyRates::ConvertCurrency($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                        //    $_COOKIE['CURRENCY_SET']).'</div>';
                                                        
                                                        //echo "<div class=\"table-content-mobile-size\">". CCurrencyLang::CurrencyFormat(
                                                        //    ceil(CCurrencyRates::ConvertCurrency($priceForAreaMobileValue, $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                        //    $_COOKIE['CURRENCY_SET']).$priceForAreaMobileDegree.'</div>';
                                                        
                                                        echo "<div class=\"table-content-full-size\">".strtolower(GetMessage('TEXT_FROM')).' '. CustomFormatValue($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'], false, 1000).'</div>';
                                                        echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], $_COOKIE['CURRENCY_SET'], true, 1000).'</div>';
                                                    }else{
                                                        echo "<div class=\"table-content-full-size\">".strtolower(GetMessage('TEXT_FROM')).' '. CustomFormatValue($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], "USD", false, 1000).'</div>';
                                                        echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($minFlat['PRICE_FOR_AREA']['VALUE'], $minFlat['PRICE_FOR_AREA']['CURRENCY'], 'USD', true, 1000).'</div>';
                                                    }
                                                    
                                                }else{
                                                    echo GetMessage('NO_PRICE');
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                if(isset($minFlat['PRICE']['VALUE']) && $minFlat['PRICE']['VALUE'] != '' && $minFlat['PRICE']['VALUE'] != 0){
                                                    if($_COOKIE['CURRENCY_SET']){
                                                        //echo CCurrencyLang::CurrencyFormat(
                                                        //    ceil(CCurrencyRates::ConvertCurrency($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                         //   $_COOKIE['CURRENCY_SET']
                                                        //);
                                                        echo "<div class=\"table-content-full-size\">".strtolower(GetMessage('TEXT_FROM')).' '. CustomFormatValue($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], $_COOKIE['CURRENCY_SET'], false, 1000000).'</div>';
                                                        echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], $_COOKIE['CURRENCY_SET'], true, 1000000).'</div>';
                                                    }else{
                                                        //echo CCurrencyLang::CurrencyFormat(
                                                        //    ceil(CCurrencyRates::ConvertCurrency($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], 'USD')),
                                                        //    'USD'
                                                        //);
                                                        echo "<div class=\"table-content-full-size\">".strtolower(GetMessage('TEXT_FROM')).' '. CustomFormatValue($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], 'USD', false, 1000000).'</div>';
                                                        echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($minFlat['PRICE']['VALUE'], $minFlat['PRICE']['CURRENCY'], 'USD', true, 1000000).'</div>';
                                                    }
                                                }else{
                                                    echo GetMessage('NO_PRICE');
                                                }
                                                ?>
                                            </td>
                                            <td align="right">
                                                <?
                                                    //echo "<pre>"; print_r($minFlat['FLAT_TYPE']); echo "</pre>";
                                                    $minFlat['FLAT_TYPE'] = str_replace('Свободная планировка', 'Free Layout', $minFlat['FLAT_TYPE']);
                                                    $minFlat['FLAT_TYPE'] = str_replace('комнатная квартира', 'bed', $minFlat['FLAT_TYPE']);
                                                    $minFlat['FLAT_TYPE'] = str_replace('комн', 'bed', $minFlat['FLAT_TYPE']);
                                                    $minFlat['FLAT_TYPE'] = str_replace('Студия', 'studios', $minFlat['FLAT_TYPE']);
                                                    //echo $minFlat['FLAT_TYPE'];
                                                    
                                                    $minFlat['FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('Свободная планировка', 'Free Layout', $minFlat['FLAT_TYPE_VALUE_NAME_ROW']);
                                                    $minFlat['FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('комнатная квартира', 'bed', $minFlat['FLAT_TYPE_VALUE_NAME_ROW']);
                                                    $minFlat['FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('комн', 'bed', $minFlat['FLAT_TYPE_VALUE_NAME_ROW']);
                                                    $minFlat['FLAT_TYPE_VALUE_NAME_ROW'] = str_replace('Студия', 'studios', $minFlat['FLAT_TYPE_VALUE_NAME_ROW']);
                                                    
                                                    $url_more = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'.'&item='.strtolower($minFlat['FLAT_TYPE']).'&title='.strtolower($minFlat['FLAT_TYPE_VALUE_NAME_ROW']);
                                                    echo "<a class=\"table-content-full-size\" href=\"".$url_more."\">".GetMessage('MORE_FS').'</a>';
                                                    echo "<a class=\"table-content-mobile-size\" href=\"".$url_more."\">".GetMessage('MORE_MS').'</a>';
                                                    //echo "<div class=\"table-content-full-size\">"."<a href=\"".$url_more."\">".GetMessage('MORE_FS').'</a>'.'</div>';
                                                ?>
                                                
                                                <!-- a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y'?><?='&item='.strtolower($minFlat['FLAT_TYPE'])?>"><?=GetMessage('MORE')?></a> -->
                                             </td>
                                        </tr>
                                        <?
                                        unset($minFlat);
                                    }
                                    ?>
                                    <tr class="all-flats">
                                        <!-- <td>
                                                
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
                                         </td> -->
                                         <td colspan="5" align="right">
                                            
                                            <a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?sku-preview=Y&item=all-flats'?>"><?=GetMessage('ALL_FLATS')?></a>
                                         </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?
                            }
                            //echo "<pre>"; print_r($arrResFlats); echo "</pre>";
                            ?>
                            <div class="placement">
                                <span class="block-title"><?=GetMessage('OBJECT_PLACEMENT')?></span>
                                <div class="responsive-box">

                                    <?
                                    if(!empty($arResult['PROPERTIES']['MESTOPOLOZHENIE']['VALUE'])){?>
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
                            <?
                            $xploOne = explode( '/',$APPLICATION->GetCurDir());
                            $explodeSec = explode('-', $xploOne[1]);
                            //echo "<pre>"; print_r($explodeSec); echo "</pre>";
                            if( $arResult['PROPERTIES']['PLACEMENT_BLOCK']['VALUE_XML_ID'] == 'Y' ){
                                ?>
                                <div class="info-table getByAjaxPlacementProps">
                                    <span class="block-title"></span>
                                    <div class="placement-props table">

                                        <?if('' != ($arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>

                                        <?if('' != ($arResult['PROPERTIES']['CITY_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['CITY_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['CITY_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>

                                        <?if('' != ($arResult['PROPERTIES']['STATE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['STATE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['STATE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>

                                        <?if('' != ($arResult['PROPERTIES']['ZIP_CODE_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['ZIP_CODE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['ZIP_CODE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if('' != ($arResult['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE']) ):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['COUNTY_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>

                                        <?if('' != ($arResult['PROPERTIES']['BOROU_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $explodeSec[1] == 'us'):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['BOROU_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['BOROU_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?/*if('' != ($arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $explodeSec[1] == 'ru'):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['AREA_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;*/?>
                                        <?/*if('' != ($arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE']) ):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['DISTRICT_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;*/?>
                                        <?
                                        $db_old_groups = CIBlockElement::GetElementGroups($arResult['ID'], true);
                                        //$ar_new_groups = Array($NEW_GROUP_ID);
                                        while($ar_group = $db_old_groups->Fetch()){
                                            if($ar_group['DEPTH_LEVEL'] == 5){
                                                $getSection = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $ar_group['ID'], 'IBLOCK_ID' => $ar_group['IBLOCK_ID']), false, array('ID','IBLOCK_ID','NAME','UF_NAME_'.strtoupper(LANGUAGE_ID)));
                                                if($fetchSection = $getSection -> GetNext()){
                                                    //echo "<pre>"; print_r($fetchSection); echo "</pre>";
                                                    ?>
                                                    <div class="flex-prop">
                                                        <div class="left"><?=GetMessage('NEIGHBORHOOD_TEXT')?></div>
                                                        <div class="right">
                                                            <?
                                                            if(LANGUAGE_ID == 'en'){
                                                                echo $fetchSection['NAME'];
                                                            }else{
                                                                echo $fetchSection['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?
                                                }
                                                //echo "<pre>"; print_r($ar_group); echo "</pre>";
                                            }
                                        }
                                        ?>
                                        

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
                            if( $arResult['PROPERTIES']['DETAIL_BLOCK']['VALUE_XML_ID'] == 'Y' && !stristr($APPLICATION->GetCurDir(), '-ru')){
                                ?>
                                <div class="info-table">
                                    <span class="block-title"><?=GetMessage('DETAIL_BLOCK_TEXT')?></span>
                                    <div class="detail-block-props table">
                                        <?if('' != ($arResult['PROPERTIES']['OWNERSHIP_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['OWNERSHIP_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['OWNERSHIP_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if('' != ($arResult['PROPERTIES']['NOMBER_OF_UNITS_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['NOMBER_OF_UNITS_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['NOMBER_OF_UNITS_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if('' != ($arResult['PROPERTIES']['SALES_STARTED_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['SALES_STARTED_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['SALES_STARTED_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if('' != ($arResult['PROPERTIES']['CONSTRUCTION_STARTED_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['CONSTRUCTION_STARTED_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['CONSTRUCTION_STARTED_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if('' != ($arResult['PROPERTIES']['OPERATING_COSTS_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['OPERATING_COSTS_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['OPERATING_COSTS_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
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
                                <div class="info-table getByAjaxSales">
                                    <span class="block-title"><?=GetMessage('WHERE_TO_BUY_TEXT')?></span>
                                    <div class="where-to-buy-props table">
                                        <?if('' != ($arResult['PROPERTIES']['SALES_COMPANY_'.strtoupper(LANGUAGE_ID)]['VALUE'])):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['SALES_COMPANY_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['SALES_COMPANY_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if($arResult['PROPERTIES']['SALES_COMPANY_LOCATION_'.strtoupper(LANGUAGE_ID)]['VALUE'] != ''):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['SALES_COMPANY_LOCATION_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['SALES_COMPANY_LOCATION_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if($arResult['PROPERTIES']['PHONE_'.strtoupper(LANGUAGE_ID)]['VALUE'] != ''):?>
                                            <div class="flex-prop">
                                                <div class="left"><?=$arResult['PROPERTIES']['PHONE_'.strtoupper(LANGUAGE_ID)]['NAME']?></div>
                                                <div class="right"><?=$arResult['PROPERTIES']['PHONE_'.strtoupper(LANGUAGE_ID)]['VALUE']?></div>
                                            </div>
                                        <?endif;?>
                                        <?if($arResult['PROPERTIES']['OFFICIAL_SITE']['VALUE'] != ''):
                                            if( stristr($arResult['PROPERTIES']['OFFICIAL_SITE']['VALUE'], 'http') === false ){
                                                $arResult['PROPERTIES']['OFFICIAL_SITE']['VALUE'] = "http://".$arResult['PROPERTIES']['OFFICIAL_SITE']['VALUE'];
                                            }
                                            ?>
                                            <div class="flex-prop">
                                                <div class="left"><?=GetMessage('OFFICIAL_SITE')?></div>
                                                <div class="right"><a rel="nofollow" href="<?=$arResult['PROPERTIES']['OFFICIAL_SITE']['VALUE']?>" target="_blank" class="orange-text"><?=GetMessage('GO_TO_TEXT')?></a></div>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                        <div class="ipoteka background-gray" style="padding: 10px 0 50px;">
                            <span class="block-title" style="padding: 0 15px;color: #4b4b4b;font-size: 32px;font-weight: bold;margin: 30px 0;display: block;"><?=GetMessage('IPOTEKA_BANKS')?></span>
                            <div class="max-width">
                                <div class="flex-banks">
                                    <?
                                    $explode = explode('/', $APPLICATION->GetCurDir());
                                    $xplo = explode('-', $explode[1]);
                                    //echo "<pre>"; print_r($xplo); echo "</pre>";
                                    ?>
                                    <?if($xplo[1] == 'ru'){
                                        ?>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/sberbank.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/transkapitalbank.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/абсолютбанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/банквозрождение.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/втб.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/дельтакредитбанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/металлинвестбанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/открытиебанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/связьбанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/снгббанк.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/Татфондбанк.jpg">
                                        </div>
                                        <div class="item-bank hollow">
                                        </div>
                                    <?
                                    }elseif($xplo[1] == 'us'){
                                        ?>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/ba.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/blueleaf.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/chase.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/citi.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/eclick.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/fairway.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/FSB.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/Guaranteed Rate.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/HOMESTAR.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/UHL.jpg">
                                        </div>
                                        <div class="item-bank">
                                            <img class="lozad" data-src="<?=SITE_TEMPLATE_PATH?>/images/<?=$xplo[1]?>/WF.jpg">
                                        </div>
                                        <div class="item-bank hollow">
                                        </div>
                                        <?
                                    }?>

                                </div>
                            </div>
                        </div>
                        <?

                        ?>
                        <div class="description">
                            <div class="max-width">
                                
                                <?

                                $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
                                $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

                                if(is_numeric($arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
                                    if(is_numeric($arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){
                                        $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
                                        $priceItem['CURRENCY'] = 'USD';
                                    }else{
                                        $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_FROM_RU']['VALUE']);
                                        $priceItem['CURRENCY'] = 'RUB';
                                    }
                                }else{
                                    $getSku = CIBlockElement::GetList(
                                        array('SORT' => 'ASC'),
                                        array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                                        false,
                                        false,
                                        array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN')
                                    );
                                    while ($fetchSku = $getSku -> Fetch()) {
                                        if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){
                                            if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) ) < $priceItem['VAL'] ){
                                                $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) );
                                                $priceItem['CURRENCY'] = 'USD';
                                            }else if( !isset($priceItem['VAL']) && !is_numeric($priceItem['VAL']) ){
                                                $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) );
                                                $priceItem['CURRENCY'] = 'USD';
                                            }
                                        }else if(is_numeric( preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) ) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] ) != '0'){
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
                                    if(is_numeric($item['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($arResult['PROPERTIES']['PRICE_RU']['VALUE'])){
                                        if(is_numeric($arResult['PROPERTIES']['PRICE_EN']['VALUE'])){
                                            $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_EN']['VALUE'] );
                                            $priceItem['CURRENCY'] = 'USD';
                                        }else{
                                            $priceItem['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_RU']['VALUE'] );
                                            $priceItem['CURRENCY'] = 'RUB';
                                        }
                                    }
                                }

                                if(is_numeric($arResult['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE']) || is_numeric($arResult['PROPERTIES']['PRICE_PER_SQFT_RU']['VALUE'])){
                                    if(is_numeric($arResult['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE'])){
                                        $priceItemArea['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_PER_SQFT_EN']['VALUE'] );
                                        $priceItemArea['CURRENCY'] = 'USD';
                                        if(LANGUAGE_ID != 'en'){
                                            $priceItemArea['VAL'] = $priceItemArea['VAL']/10.764;
                                        }
                                    }else{
                                        $priceItemArea['VAL'] = preg_replace('/\s+/', '', $arResult['PROPERTIES']['PRICE_PER_SQFT_RU']['VALUE'] );
                                        $priceItemArea['CURRENCY'] = 'RUB';
                                        if(LANGUAGE_ID != 'ru'){
                                            $priceItemArea['VAL'] = $priceItemArea['VAL']*10.764;
                                        }
                                    }
                                }else{
                                    $getSku = CIBlockElement::GetList(
                                        array('SORT' => 'ASC'),
                                        array('PROPERTY_CML2_LINK' => $arResult['ID'], 'IBLOCK_ID' => 8),
                                        false,
                                        false,
                                        array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_PER_SQFT_RU', 'PROPERTY_PRICE_PER_SQFT_EN')
                                    );
                                    while ($fetchSku = $getSku -> Fetch()) {
                                        if( is_numeric($fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) || is_float($fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) || $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE'] != '' ){

                                            if(isset($priceItemArea['VAL']) && preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) ) < $priceItemArea['VAL'] ){
                                                $priceItemArea['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) );
                                                $priceItemArea['CURRENCY'] = 'USD';
                                            }else if( !isset($priceItemArea['VAL']) && !is_numeric($priceItemArea['VAL']) ){

                                                $priceItemArea['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_EN_VALUE']) );
                                                $priceItemArea['CURRENCY'] = 'USD';
                                            }
                                        }else if(is_numeric(preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE']) ) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE']) != '0'){
                                            if(isset($priceItemArea['VAL']) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE']) < $priceItemArea['VAL'] ){

                                                $priceItemArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE'] );
                                                $priceItemArea['CURRENCY'] = 'RUB';
                                            }else if(!isset($priceItemArea['VAL'])){
                                                $priceItemArea['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_PER_SQFT_RU_VALUE'] );
                                                $priceItemArea['CURRENCY'] = 'RUB';
                                            }

                                        }
                                    }
                                }
                                if($arResult['PROPERTIES']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'] == '' && LANGUAGE_ID == 'ru'){
                                    $name = $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    $address = $arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                    ?><span class="block-title"><?echo $arResult['PROPERTIES']['NAME_RU']['VALUE'].' '.GetMessage('DESCRIPTION')?></span><?
                                    echo "<p>";
                                        echo "Современный жилой комплекс ".$name." расположен в одном из самых перспективных районов ".$address.".";
                                        if( (isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0) ||  (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0)){
                                            echo "<br />Стоимость жилья ";
                                        }
                                        if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){

                                            if($_COOKIE['CURRENCY_SET']){

                                                echo 'начинается от '.CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                    $_COOKIE['CURRENCY_SET']
                                                );
                                            }else{
                                                echo 'начинается от '.CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD')),
                                                    'USD'
                                                );
                                            }
                                            if( (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0) ){
                                                echo " соотвественно цена";
                                            }
                                        }
                                        if( (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0) ){
                                            echo " за кв.м. ";

                                            
                                            if($_COOKIE['CURRENCY_SET']){
                                                echo CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItemArea['VAL'], $priceItemArea['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                    $_COOKIE['CURRENCY_SET']
                                                );
                                            }else{
                                                echo CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItemArea['VAL'], $priceItemArea['CURRENCY'], 'USD')),
                                                    'USD'
                                                );
                                            }
                                            echo ".";
                                        }
                                        echo "<br />Застройщик: ".$arResult['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'].'.';
                                    echo "</p>";
                                }else if($arResult['PROPERTIES']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'] == '' && LANGUAGE_ID == 'en'){
                                    $name = $arResult['NAME'];
                                    $address = $arResult['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];

                                    ?><span class="block-title"><?=$arResult['NAME'].' '?><?=GetMessage('DESCRIPTION')?></span><?
                                    echo "<p>";
                                        echo "Modern residential complex ".$name." located in one of the most promising areas of ".$address.".";
                                        
                                        if( (isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0) ||  (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0)){
                                            echo "<br />The cost of housing ";
                                        }
                                        if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){
                                            if($_COOKIE['CURRENCY_SET']){
                                                echo "starts from ".CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                    $_COOKIE['CURRENCY_SET']
                                                );
                                            }else{
                                                echo "starts from ".CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD')),
                                                    'USD'
                                                );
                                            }
                                            
                                            if( (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0) ){
                                                echo " and the price ";
                                            }
                                        }
                                        if( (isset($priceItemArea['VAL']) && $priceItemArea['VAL'] != '' && $priceItemArea['VAL'] != 0) ){
                                            echo " per sq.ft. is ";
                                            if($_COOKIE['CURRENCY_SET']){
                                                echo CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItemArea['VAL'], $priceItemArea['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                                    $_COOKIE['CURRENCY_SET']
                                                );
                                            }else{
                                                echo CCurrencyLang::CurrencyFormat(
                                                    ceil(CCurrencyRates::ConvertCurrency($priceItemArea['VAL'], $priceItemArea['CURRENCY'], 'USD')),
                                                    'USD'
                                                );
                                            }
                                            
                                            echo ".";
                                        }
                                        echo "<br />Developer: ".$arResult['PROPERTIES']['BUILDER_'.strtoupper(LANGUAGE_ID)]['VALUE'].".";
                                    echo "</p>";
                                }else{
                                	echo "<div class='line-heighted-text'>";
                                	if(LANGUAGE_ID == 'en'){
                                		?><span class="block-title"><?=$arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'].' '?><?=GetMessage('DESCRIPTION')?></span><?
                                	}
                                	//echo "<div class='thumb-wrap'>";
                                	print_r(htmlspecialcharsBack($arResult['PROPERTIES']['DESCRIPTION_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT']));
                                	//echo "</div>";
                                	echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <?
                        //echo "<pre>"; print_r($arResult['PROPERTIES']['ABOUT_THE_DEVELOPER_'.strtoupper(LANGUAGE_ID)]); echo "</pre>";
                        if(htmlspecialcharsBack ($arResult['PROPERTIES']['ABOUT_THE_DEVELOPER_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'])){?>

                            <div class="description">
                                <div class="max-width">
                                    <span class="block-title"><?=$arResult['PROPERTIES']['ABOUT_THE_DEVELOPER_'.strtoupper(LANGUAGE_ID)]['NAME']?></span>
                                    <?
                                    echo "<p>"; print_r(htmlspecialcharsBack($arResult['PROPERTIES']['ABOUT_THE_DEVELOPER_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'])); echo "</p>";
                                    ?>
                                </div>
                            </div>
                        <?}
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
                            //echo "<pre>"; print_r($xplo); echo "</pre>";
                            //include '/'.strtolower(LANGUAGE_ID).'-'.$xplo[1].'/sidebar.php';
                            ?>
                            <div class="head">
                                <span class="micro-title"><?=GetMessage('CONSULTING_FREELY')?></span>
                                <img data-src="/bitrix/templates/23/images/circle-line.png" class="lozad">
                            </div>
                            <div class="content flex-content">
                                <img data-src="/bitrix/templates/23/images/<?=strtolower($xplo[1])?>-face.jpg" class="lozad" style="border-radius: 50%;height: 165px;width: 165px;">
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


//echo "<pre>"; print_r($arResult['PROPERTIES']); echo "</pre>";
global $arrFilterSimilar;
$arrFilterSimilar = array('=PROPERTY_SELLING_STEP_EN' => $arResult['PROPERTIES']['SELLING_STEP_EN']['VALUE'], '!ID' => $arResult['ID']);
//echo "<pre>"; print_r($arrFilterSimilar); echo "</pre>";
?>
<div class="preview-product-main carousel-mobile">
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
            "CACHE_TIME" => "0",
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
unset($actualItem, $itemIds, $jsParams);