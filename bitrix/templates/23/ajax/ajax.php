<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

ini_set('memory_limit', '4096M');

//echo "<pre>"; print_r($_REQUEST); echo "<pre>";

$sectionId = $_REQUEST['SECTION_ID'];

if (CModule::IncludeModule("iblock")){
    $getSection = CIBlockSection::GetList(
        Array("SORT"=>"ASC"),
        Array("ID" => $sectionId),
        false,
        Array(),
        false
    );
    while($fetchList = $getSection -> GetNext()){
        $IBLOCK_ID = $fetchList['IBLOCK_ID'];
        //echo "<pre>"; print_r($IBLOCK_ID); echo "<pre>";
    }


    $flatsArr = explode(';', $_REQUEST['flats-filter']);

    if(isset($flatsArr[1]) && is_array($flatsArr)){

        //echo "<pre>"; print_r($flatsArr); echo "<pre>";

        foreach ($flatsArr as $noneed => $typeSku) {
            if($noneed != 0){

                $getSection = CIBlockSection::GetList(
                    Array("SORT"=>"ASC"),
                    Array("ID" => $sectionId),
                    false,
                    Array(),
                    false
                );

                while($fetchList = $getSection -> GetNext()){

                    //echo "<pre>"; print_r($fetchList); echo "</pre>";
                    //echo "<pre>"; print_r(array('SECTION_ID' => $fetchList['ID'], 'IBLOCK_ID' => $fetchList['IBLOCK_ID'] )); echo "</pre>";

                    $getList = CIBlockElement::GetList(
                        array('SORT' => 'ASC'),
                        array('IBLOCK_SECTION_ID' => $fetchList['ID'], 'IBLOCK_ID' => $fetchList['IBLOCK_ID'], 'ACTIVE' => 'Y', '?PROPERTY_FLAT_TYPE' => str_replace('room', 'комн', $typeSku) ),
                        false,
                        false,
                        array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_LINK_SKU')
                    );

                    //$IBLOCK_ID = $fetchList['IBLOCK_ID'];
                    //echo "<pre>"; print_r($IBLOCK_ID); echo "<pre>";
                    if($IBLOCK_ID == 8){
                        while($fetchItem = $getList -> GetNext()){

                            $getSku = CIBlockElement::GetList(
                                array('SORT' => 'ASC'),
                                array('ID' => $fetchItem['PROPERTY_LINK_SKU_VALUE'], '?PROPERTY_FLAT_TYPE' => str_replace('room', 'комн', $typeSku)),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID')
                            );

                            //echo "<pre>"; print_r($typeSku); echo "</pre>";

                            if($fetchSKU = $getSku -> GetNext()){
                        
                                //if( strtolower($fetchSKU['NAME']) == strtolower($typeSku)){
                                    //echo "<pre>"; print_r($fetchItem); echo "</pre>";
                                    $arResult['ITEMS'][] = $fetchItem;
                                //}
                            }
                            

                        }
                    }else{
                        while($fetchItem = $getList -> GetNext()){
                            //echo "<pre>"; print_r($fetchItem); echo "</pre>";

                            //echo "<pre>"; print_r($value); echo "</pre>";
                            $getSku = CIBlockElement::GetList(
                                array('SORT' => 'ASC'),
                                array('PROPERTY_CML2_LINK' => $fetchItem['ID'], 'IBLOCK_ID' => 8, '?PROPERTY_FLAT_TYPE' => str_replace('room', 'комн', $typeSku)),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_FLAT_TYPE')
                            );

                            while ( $fetchSku = $getSku -> GetNext()){
                                //echo "<pre>"; print_r(str_replace('комн', 'room', $fetchSku['PROPERTY_FLAT_TYPE_VALUE'])); echo "</pre>";
                                if($typeSku == str_replace('комн', 'room', $fetchSku['PROPERTY_FLAT_TYPE_VALUE'])){
                                    $fetchItem['SKUS'][] = $fetchSku;
                                }                                
                            }

                            if(is_array($fetchItem['SKUS']) && is_array($fetchItem['SKUS'][0])){
                                $arResult['ITEMS'][] = $fetchItem;
                            }
                        }
                    }
                }
            }
        }
    }

    $deliveredArr = explode(';', $_REQUEST['delivered-filter']);
    
    //echo "<pre>"; print_r($sectionId); echo "</pre>";

    if(isset($deliveredArr[1]) && is_array($deliveredArr)){
        foreach ($deliveredArr as $noneed => $typeSku) {
            if($noneed != 0){
                $getSection = CIBlockSection::GetList(
                    Array("SORT"=>"ASC"),
                    Array("ID" => $sectionId),
                    false,
                    Array(),
                    false
                );
                while($fetchList = $getSection -> GetNext()){

                     //echo "<pre>"; print_r($fetchList); echo "</pre>";

                    $getList = CIBlockElement::GetList(
                        array('SORT' => 'ASC'),
                        array('IBLOCK_SECTION_ID' => $fetchList['ID'], 'IBLOCK_ID' => $fetchList['IBLOCK_ID'], 'ACTIVE' => 'Y'),
                        false,
                        false,
                        array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID), 'PROPERTY_CML2_LINK')
                    );
                    if($IBLOCK_ID == 8){
                        while($fetchItem = $getList -> GetNext()){
                            //echo "<pre>"; print_r($fetchItem); echo "</pre>";
                            //$getInf = CCatalogSku::GetProductInfo($fetchItem['PROPERTY_LINK_SKU_VALUE']);
                            
                            //echo "<pre>"; print_r($getInf); echo "</pre>";

                            $getListSec = CIBlockElement::GetList(
                                array('SORT' => 'ASC'),
                                array('ID' => $fetchItem['PROPERTY_CML2_LINK'], 'IBLOCK_ID' => 4, 'ACTIVE' => 'Y'),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID))
                            );
                            while($fetchItemSec = $getListSec -> GetNext()){
                                //echo "<pre>"; print_r($fetchItemSec); echo "</pre>";

                                if($fetchItemSec['PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID).'_VALUE']){
                                    $getProp = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC", "VALUE"=>"ASC"), Array('VALUE'=>$fetchItemSec['PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID).'_VALUE'], 'CODE' => 'SROK_SDACHI_'.strtoupper(LANGUAGE_ID)) );
                                    if($fetchProp = $getProp -> GetNext()){
                                        if( stristr(strtolower($typeSku), $fetchProp['XML_ID'] ) ){
                                            $arResult['DELIVERED'][] = $fetchItem;
                                        }
                                        //echo "<pre>"; print_r($typeSku); echo "</pre>";
                                    }
                                }
                            }
                        }

                    }else{
                        while($fetchItem = $getList -> GetNext()){

                            //echo "<pre>"; print_r($fetchItem); echo "</pre>";
                            if($fetchItem['PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID).'_VALUE']){
                                $getProp = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC", "VALUE"=>"ASC"), Array('VALUE'=>$fetchItem['PROPERTY_SROK_SDACHI_'.strtoupper(LANGUAGE_ID).'_VALUE'], 'CODE' => 'SROK_SDACHI_'.strtoupper(LANGUAGE_ID)) );
                                if($fetchProp = $getProp -> GetNext()){
                                    
                                    if($typeSku == 'sdan'){
                                        if( stristr($fetchProp['VALUE'], strtolower('сдан')) ){
                                            $arResult['DELIVERED'][] = $fetchItem;
                                        }
                                    }elseif($typeSku == 'plus'){

                                        //var_dump(stristr(strtolower('сдан'), $fetchProp['VALUE'] ));

                                        if( !stristr( $fetchProp['VALUE'], strtolower('сдан') ) && !stristr( $fetchProp['VALUE'], strtolower('completed') ) 
                                            && !stristr($fetchProp['VALUE'], strtolower('2019') ) && !stristr($fetchProp['VALUE'], strtolower('2020') ) )
                                        {
                                            $arResult['DELIVERED'][] = $fetchItem;
                                        }
                                    }else{
                                        //echo "<pre>"; print_r($typeSku); echo "</pre>";
                                        if( stristr($fetchProp['VALUE'], strtolower($typeSku)) ){
                                            $arResult['DELIVERED'][] = $fetchItem;
                                        }
                                    }
                                    //echo "<pre>"; print_r($fetchItem); echo "</pre>";
                                }
                            }

                        }
                    }
                }
            }
        }
    }

    if(isset($_REQUEST['search']) && $_REQUEST['search'] != ''){
        $getList = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array('IBLOCK_SECTION_ID' => $sectionId, 'IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y', array(
                        "LOGIC" => "OR",
                        '%NAME' => $_REQUEST['search'] ,
                        "%PROPERTY_NAME_".strtoupper(LANGUAGE_ID) => $_REQUEST['search']
                    )
                ),
            false,
            false,
            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper(LANGUAGE_ID))
        );
        while($fetchSearch = $getList -> GetNext()){
            $arResult['SEARCH'][] = $fetchSearch;
        }
        
    }
    //echo "<pre>"; print_r($arResult); echo "</pre>";
}
global $arrFilterAjax;
if(is_array($arResult['ITEMS'])){
    foreach ($arResult['ITEMS'] as $key => $value) {
        $arrFilterAjax['=ID'][$value['ID']] = $value['ID'];
    }
}
if(is_array($arResult['DELIVERED'])){
    if(is_array($arResult['ITEMS'])){
        foreach ($arrFilterAjax['=ID'] as $key => $value) {
            foreach ($arResult['DELIVERED'] as $key2 => $value2) {
                if($value2['ID'] == $value){
                    $newArr[$value] = $value;
                }
            }
        }
        $arrFilterAjax['=ID'] = $newArr;
    }else{
        foreach ($arResult['DELIVERED'] as $key => $value) {
            $arrFilterAjax['=ID'][$value['ID']] = $value['ID'];
        }
    }
}
if(is_array($arResult['SEARCH'])){
    if(is_array($arResult['ITEMS']) || is_array($arResult['DELIVERED'])){
        foreach ($arrFilterAjax['=ID'] as $key => $value) {
            foreach ($arResult['SEARCH'] as $key2 => $value2) {
                if($value2['ID'] == $value){
                    $newArr[$value] = $value;
                }
            }
        }
        $arrFilterAjax['=ID'] = $newArr;
    }else{
        //echo "<pre>"; print_r($arResult['SEARCH']);echo "</pre>";
        foreach ($arResult['SEARCH'] as $key => $value) {
            //echo "<pre>"; print_r(array($key => $value));echo "</pre>";
            $arrFilterAjax['=ID'][$value['ID']] = $value['ID'];
        }
    }
}

//echo "<pre>"; print_r($arrFilterAjax); echo "</pre>";
/*if(!is_array($arrFilterAjax)){
    if(LANGUAGE_ID != 'en'){
        echo "<div class='NoResult'>Нет результатов поиска.</div>";
    }else{
        echo "<div class='NoResult'>No search results.</div>";
    }
}else{
    echo "<div class='Count'>".count($arrFilterAjax['=ID'])."</div>";
}*/
?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section", 
    "ajax", 
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
        "FILTER_NAME" => "arrFilterAjax",
        "HIDE_NOT_AVAILABLE" => "N",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "IBLOCK_ID" => $IBLOCK_ID,
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LABEL_PROP" => array(
        ),
        "LAZY_LOAD" => "N",
        "LINE_ELEMENT_COUNT" => "10000",
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
        "PAGE_ELEMENT_COUNT" => "10000",
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
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
        "PRODUCT_SUBSCRIPTION" => "Y",
        "PROPERTY_CODE_MOBILE" => array(
        ),
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "RCM_TYPE" => "personal",
        "SECTION_CODE" => "",
        "SECTION_ID" => $sectionId,
        "SECTION_ID_VARIABLE" => "SECTION_ID_2",
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
        "SHOW_OLD_PRICE" => "Y",
        "SHOW_SLIDER" => "Y",
        "SLIDER_INTERVAL" => "3000",
        "SLIDER_PROGRESS" => "N",
        "TEMPLATE_THEME" => "blue",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRODUCT_QUANTITY" => "N"
    ),
    false
);
?>