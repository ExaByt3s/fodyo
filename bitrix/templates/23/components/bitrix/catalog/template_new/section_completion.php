<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] === 'Y')
{
    $basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
    $basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

$getSection = CIBlockSection::GetList(
    Array("SORT"=>"ASC"),
    Array('ID' => $arResult['VARIABLES']['SECTION_ID'], 'IBLOCK_ID' => 4),
    false,
    Array('ID', 'NAME', 'IBLOCK_ID', 'UF_RELATED_CATEGS', 'UF_RELATED_ARTICLES'),
    false
);

while($fetchSection = $getSection -> GetNext()){
    //echo "<pre>"; print_r($fetchSection); echo "</pre>";
    $arrSections = $fetchSection['UF_RELATED_CATEGS'];
    $articlesId = $fetchSection['UF_RELATED_ARTICLES'];
}
if($articlesId){
    $getListArticle = CIBlockSection::GetList(
        Array("SORT"=>"ASC"),
        Array('ID' => $articlesId, 'IBLOCK_ID' => 7),
        false,
        Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'SECTION_PAGE_URL', 'PICTURE'),
        false
    );
    while ($fetchArticles = $getListArticle -> GetNext()){
        //echo "<pre>"; print_r($fetchArticles); echo "</pre>";
        $arrArticle = $fetchArticles;
    }
}

function GetAllSectionInSel($SECTION_ID, $arParent){
   $arR=array();
   for($i=0,$k=count($arParent[$SECTION_ID]);$i<$k;$i++){
       array_push($arR, $arParent[$SECTION_ID][$i]);
       if(isset($arParent[$arParent[$SECTION_ID][$i]])){ //Если ребёнок является родителем
           $arR=array_merge($arR, GetAllSectionInSel($arParent[$SECTION_ID][$i], $arParent));
       }
   }
   return $arR; 
}


function GetAllSectionIn($IBLOCK_ID, $SECTION_ID, $arFilter, $arSelect){
   
   if($arSelect=='ID'){ //если нужны только ид
       $IDon=true;
       $arSelect=array('ID','IBLOCK_SECTION_ID');
   }else{
       $arSelect=array_merge(array('ID','IBLOCK_SECTION_ID'),$arSelect);
   }
   
   $obSection=CIBlockSection::GetList(
       array('NAME' => 'ASC'),
       array_merge(array('IBLOCK_ID'=>$IBLOCK_ID),$arFilter),
       false,
       $arSelect,
       false
   );
   
   $arAlId=array(); //Для хранения результатов
   $arParent=array(); //Для хранения детей разделов
   while($arResult=$obSection->GetNext()){
       
       $arAlId[$arResult['ID']]=$arResult;
       if(!is_array($arParent[$arResult['IBLOCK_SECTION_ID']])){ //Если родителя в списке нет, то добавляем
           $arParent[$arResult['IBLOCK_SECTION_ID']]=array();
       }
       array_push($arParent[$arResult['IBLOCK_SECTION_ID']], $arResult['ID']);
       
   } 
   unset($obSection);
   
   $arR=GetAllSectionInSel($SECTION_ID, $arParent); //Ид всех детей и правнуков
   
   if(!$IDon){ //Если необходим не только ид
       $arId=$arR;
       $arR=array();
       for($i=0,$k=count($arId);$i<$k;$i++){
           array_push($arR,$arAlId[$arId[$i]]);
       }
   }
   
   return $arR;
}



//echo "<pre>"; print_r($arResult); echo "</pre>";
?>

</div></div>

<div class="background-gray">
    <div class="max-width">
        <div class="breadcrumbs">
            <?
            $checkRes = CIBlockSection::GetList(
                Array("SORT" =>" NAME"),
                Array('ID' => $arResult['VARIABLES']['SECTION_ID'], 'IBLOCK_ID' => 4),
                false,
                Array('IBLOCK_ID', 'ID', 'IBLOCK_SECTION_ID', 'NAME', 'DETAIL_URL', 'UF_TOP_DEVELOPER'),
                false
            );
            if($checkFetch = $checkRes -> GetNext()){
                //echo "<pre>"; print_r($testFetch); echo "</pre>";
                $developerPage = $checkFetch['UF_TOP_DEVELOPER'];
            }            
            $getZapas = $getList = CIBlockSection::GetList(
                Array("SORT"=>"ASC"),
                Array('IBLOCK_ID' => 4, 'ID' => $arResult['VARIABLES']['SECTION_ID']),
                false,
                Array('ID', 'NAME', 'IBLOCK_ID', 'CODE', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'SECTION_PAGE_URL', 'UF_HREF_ISO'),
                false
            );
            $fetchZapas = $getZapas->GetNext();
            $exploaded = explode('/', $arResult['VARIABLES']['SECTION_CODE_PATH']);
            if($arResult['VARIABLES']['SECTION_ID'] && $APPLICATION->GetCurDir() == trim('/'.strtolower(LANGUAGE_ID).'-'.$fetchZapas['UF_HREF_ISO'].'/developments/') ){
                    $arrSection = $fetchZapas;                
            }else{
                foreach ($exploaded as $key => $section_code) {
                    $getList = CIBlockSection::GetList(
                        Array("SORT"=>"ASC"),
                        Array('IBLOCK_ID' => 4, 'CODE' => $section_code),
                        false,
                        Array('ID', 'NAME', 'IBLOCK_ID', 'CODE', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'SECTION_PAGE_URL'),
                        false
                    );
                    while($fetchList = $getList -> GetNext()){
                        $arrSection = $fetchList;
                    }
                }
            }
            
            
            ?>
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "fodyo_new3", Array(
    "PATH" => $APPLICATION->GetCurDir(),    // Path for which the navigation chain is to be built (by default, the current site)
        "SITE_ID" => "s1",  // Site (used in multi-site version, if sites have different DOCUMENT_ROOT)
        "START_FROM" => "0",    // Ordinal of item from which to build the chain
    ),
    false
);?>

            <div class="block-title">
                <?
                if(stristr($APPLICATION->GetCurDir(), 'flat')){
                    $part = 'flat';
                }else if(stristr($APPLICATION->GetCurDir(), 'developments')){
                    $part = 'nedv';
                }else{
                    $part = 'cottage';
                }
                if(stristr($APPLICATION->GetCurDir(), 'top-single-family-homes')){
                    $part = 'none';
                }
                ?>
                <span class="huge-title">
                    <?
                    if($arrSection['NAME'] == 'Moscow'){
                        $urlBack = '/bitrix/templates/23/images/moscow-gerb.png';
                    }
                    if(file_exists($urlBack)){
                        ?>
                        <span class="image-gerb" style="background: url(<?=$urlBack?>);"></span>
                        <?
                    }
                    if(stristr($APPLICATION->GetCurDir(), 'neighborhoods')){
                        
                    }elseif($developerPage){
                        echo GetMessage('DEVELOPER_TEXT_CATEORY');
                    }else{
                        echo GetMessage(strtoupper($part).'_IN_MOSCOW');
                    }
                   
                    if(LANGUAGE_ID == 'en'){
                        echo $arrSection['NAME'];
                    }else{
                        $print = $arrSection['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                        $print = str_replace('Москва', 'Москве', $print);
                        $print = str_replace('Россия', 'России', $print);
                        $print = str_replace('Новая', 'Новой', $print);
                        echo $print;
                    }
                    ?></span>
            </div>

            <?/*if(!stristr($APPLICATION->GetCurDir(), 'flat')){
                ?>
                <div class="mini-categories">
                    <a href="<?=str_replace('developments','flat',$APPLICATION->GetCurDir())?>">
                        <div class="flats">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/flats.png">
                            <div class="category_name"><?=GetMessage('FLATS_MINI')?></div>
                        </div>
                    </a>
                    <a href="<?=str_replace('developments','cottage',$APPLICATION->GetCurDir())?>">
                        <div class="villas">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/villas.png">
                            <div class="category_name"><?=GetMessage('VILLAS_MINI')?></div>
                        </div>
                    </a>
                    <div class="invest">
                        <img src="<?=SITE_TEMPLATE_PATH?>/images/invest.png">
                        <div class="category_name"><?=GetMessage('INVEST_MINI')?></div>
                    </div>
                    <?
                    if(is_array($arrArticle) && $arrArticle['NAME'] != ''){

                        //echo "<pre>"; print_r($arrArticle['PICTURE']); echo "</pre>";

                        $file = CFile::ResizeImageGet($arrArticle['PICTURE'], array('width'=>262, 'height'=>262), BX_RESIZE_IMAGE_EXACT, true);

                        ?>
                        <a href="<?=$arrArticle['SECTION_PAGE_URL'];?>">
                            <div class="stati">
                                <img src="<?=$file['src']?>">
                                <div class="category_name"><?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $arrArticle['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $arrArticle['NAME'];
                                    }
                                ?></div>
                            </div>
                        </a>
                        <?
                    }
                    ?>
                    
                </div>
                <?
            }*/?>
        </div>
    </div>
</div>

<div class="max-width"><div class="row">


            <div>
                <?
                if ($arParams["USE_COMPARE"] === "Y")
                {
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.compare.list",
                        "",
                        array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "NAME" => $arParams["COMPARE_NAME"],
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                            "COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
                            "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action"),
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
                            'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
                        ),
                        $component,
                        array("HIDE_ICONS" => "Y")
                    );
                }
                $exploa = explode('/', $APPLICATION->GetCurDir());
                //echo "<pre>"; print_r($exploa); echo "</pre>";
                $xplos = explode('-', $exploa[count($exploa) - 2]);
                //echo "<pre>"; print_r($xplos); echo "</pre>";
                global $filterCompetion;
                $filterCompetion = array('PROPERTY_163' => '%'.$xplos[1].'%');
                $intSectionID = $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "default-flats",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                        "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                        "FILTER_NAME" => 'filterCompetion',
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "MESSAGE_404" => $arParams["~MESSAGE_404"],
                        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                        "SHOW_404" => $arParams["SHOW_404"],
                        "FILE_404" => $arParams["FILE_404"],
                        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                        "PRICE_CODE" => $arParams["~PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                        "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                        "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                        "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                        "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
                        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                        "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                        "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                        'LABEL_PROP' => $arParams['LABEL_PROP'],
                        'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                        'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                        'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                        'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                        'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                        'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                        'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                        'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                        'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
                        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                        'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                        'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                        'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                        'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                        'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                        'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                        'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                        'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                        'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                        "ADD_SECTIONS_CHAIN" => "N",
                        'ADD_TO_BASKET_ACTION' => $basketAction,
                        'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                        'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                        'USE_COMPARE_LIST' => 'Y',
                        'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                        'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                        'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                    ),
                    $component
                );
                ?>
            </div>
            <?
            $GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;

            unset($basketAction);
            ?>
<?if(stristr($APPLICATION->GetCurDir(), 'new-york') && !stristr($APPLICATION->GetCurDir(), 'neighborhoods') && !stristr($APPLICATION->GetCurDir(), 'top-single-family-homes') && !$developerPage && LANGUAGE_ID == 'en'){?>
    <div class="podborki">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">New Developments</span> Locations</div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/manhattan/">New Developments Manhattan</a>
                </div>
                <div class="value">
                    <a href="/en-us/developments/new-york/bronx/">New Developments The Bronx</a>
                </div>
                <div class="value">
                    <a href="/en-us/developments/new-york/brooklyn/">New Developments Brooklyn</a>
                </div>
                <div class="value">
                    <a href="/en-us/developments/new-york/queens/">New Developments Queens</a>
                </div>
                <div class="value">
                    <a href="/en-us/developments/new-york/staten-island/">New Developments Staten Island</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Neighborhoods</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/top-neighborhoods-ny/">Top Neighborhoods New York</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Chicago</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Los Angeles</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Miami</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Washington, D.C.</a>
                </div>
            </div>
        </div>
    </div>
    <div class="podborki">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">Single Family</span> Homes</div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/top-single-family-homes-ny/">Top Single Family New York</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Chicago</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Los Angeles</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Miami</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Washington, D.C.</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Developers</span></div>
            <div class="table">
                <?
                //echo "<pre>"; print_r($arResult['VARIABLES']['SECTION_ID']); echo "</pre>";
                $developRes = CIBlockSection::GetList(
                    Array("SORT"=>" NAME"),
                    Array('ID' => $arResult['VARIABLES']['SECTION_ID']),
                    false,
                    Array('IBLOCK_ID', 'ID', 'IBLOCK_SECTION_ID', 'NAME', 'DETAIL_URL'),
                    false
                );
                if($fetchDevelop = $developRes -> GetNext()){

                    $getSectionsDevelop = GetAllSectionIn(4, $fetchDevelop['IBLOCK_SECTION_ID'], array(), array('ID', 'NAME', 'UF_TOP_DEVELOPER', 'IBLOCK_ID', 'PICTURE', 'UF_NAME_RU', 'UF_IS_PAGE', 'SECTION_PAGE_URL', 'DEPTH_LEVEL'));
                    
                    function sortByOrder($a, $b) {
                        return strcmp($a["NAME"], $b["NAME"]);
                    }

                    usort($getSectionsDevelop, 'sortByOrder');

                    $counter == 0;
                    foreach ($getSectionsDevelop as $key => $sectionDevelop) {
                        if($sectionDevelop['UF_TOP_DEVELOPER'] == '1'){
                            $counter++;
                            //echo "<pre>"; print_r($sectionNeighbor); echo "</pre>";
                            ?>
                            <div class="value">
                                <a href="/<?=strtolower(LANGUAGE_ID)?>-us<?=strtolower()?><?=$sectionDevelop['SECTION_PAGE_URL']?>"><?=$sectionDevelop['NAME']?></a>
                            </div>
                            <?
                        }
                    }

                }
                ?>

                <?/*<div class="value">
                    <a href="/developments/usa/toll-brothers-city-living/">Toll Brothers City Living</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/related/">Related</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/extell-development-company/">Extell Development Company</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/rockefeller-group/">Rockefeller Group</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/brookfield-properties/">Brookfield Properties</a>
                </div>*/?>
            </div>
        </div>
    </div>
<?}?>
<?if(stristr($APPLICATION->GetCurDir(), 'moscow') && !stristr($APPLICATION->GetCurDir(), 'neighborhoods') && !stristr($APPLICATION->GetCurDir(), 'top-single-family-homes') && !$developerPage && LANGUAGE_ID == 'en'){?>
    <div class="podborki">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">Counties</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-ru/developments/moscow/central/">New Developments Central</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/western/">New Developments Western</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/southwestern/">New Developments Southwestern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/northwestern/">New Developments Northwestern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/northern/">New Developments Northern</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Counties</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-ru/developments/moscow/southern/">New Developments Southern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/northeastern/">New Developments Northeastern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/eastern/">New Developments Eastern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/southeastern/">New Developments Southeastern</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/novomoskovsky/">New Developments Novomoskovsky</a>
                </div>
            </div>
        </div>
    </div>
    <div class="podborki">
        <div class="left">
            <div class="title-podb">Estimated <span class="orange-text">Completion</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-ru/developments/moscow/completion-completed/">Completed</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/completion-2019/">2019</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/completion-2020/">2020</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/completion-2021/">2021</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/moscow/completion-2022/">2022</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Developers</span></div>
            <div class="table">
                <?
                //echo "<pre>"; print_r($arResult['VARIABLES']['SECTION_ID']); echo "</pre>";
                $developRes = CIBlockSection::GetList(
                    Array("SORT"=>" NAME"),
                    Array('ID' => $arResult['VARIABLES']['SECTION_ID']),
                    false,
                    Array('IBLOCK_ID', 'ID', 'IBLOCK_SECTION_ID', 'NAME', 'DETAIL_URL'),
                    false
                );
                if($fetchDevelop = $developRes -> GetNext()){

                    $getSectionsDevelop = GetAllSectionIn(4, $fetchDevelop['ID'], array(), array('ID', 'NAME', 'UF_TOP_DEVELOPER', 'IBLOCK_ID', 'PICTURE', 'UF_NAME_RU', 'UF_IS_PAGE', 'SECTION_PAGE_URL', 'DEPTH_LEVEL'));
                    
                    function sortByOrder($a, $b) {
                        return strcmp($a["NAME"], $b["NAME"]);
                    }

                    usort($getSectionsDevelop, 'sortByOrder');

                    $counter == 0;
                    foreach ($getSectionsDevelop as $key => $sectionDevelop) {
                        if($sectionDevelop['UF_TOP_DEVELOPER'] == '1'){
                            $counter++;
                            //echo "<pre>"; print_r($sectionNeighbor); echo "</pre>";
                            ?>
                            <div class="value">
                                <a href="/<?=strtolower(LANGUAGE_ID)?>-us<?=strtolower()?><?=$sectionDevelop['SECTION_PAGE_URL']?>"><?=$sectionDevelop['NAME']?></a>
                            </div>
                            <?
                        }
                    }

                }
                ?>

                <?/*<div class="value">
                    <a href="/developments/usa/toll-brothers-city-living/">Toll Brothers City Living</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/related/">Related</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/extell-development-company/">Extell Development Company</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/rockefeller-group/">Rockefeller Group</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/brookfield-properties/">Brookfield Properties</a>
                </div>*/?>
            </div>
        </div>
    </div>
<?}?>
<?if($APPLICATION->GetCurDir() == '/en-ru/developments/' && !stristr($APPLICATION->GetCurDir(), 'moscow') && !stristr($APPLICATION->GetCurDir(), 'top-single-family-homes') && !$developerPage && LANGUAGE_ID == 'en'){?>
    <div class="podborki" id="collections">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">Counties</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-ru/developments/moscow/">New Developments Moscow</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/saint-petersburg/">New Developments Saint-Petersburg</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/kazan/">New Developments Kazan</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/sochi/">New Developments Sochi</a>
                </div>
                <div class="value">
                    <a href="/en-ru/developments/nizhniy-novgorod/">New Developments Nizhny Novgorod</a>
                </div>
            </div>
        </div>
    </div>
<?}?>
<?if($APPLICATION->GetCurDir() == '/en-us/developments/' && !stristr($APPLICATION->GetCurDir(), 'new-york') && !stristr($APPLICATION->GetCurDir(), 'top-single-family-homes') && !$developerPage && LANGUAGE_ID == 'en'){?>
    <div class="podborki" id="collections">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">New Developments</span> Locations</div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/">New Developments New York</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">New Developments Chicago</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">New Developments Los Angeles</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">New Developments Miami</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">New Developments Washington, D.C.</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Neighborhoods</span></div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/top-neighborhoods-ny/">Top Neighborhoods New York</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Chicago</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Los Angeles</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Miami</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Neighborhoods Washington, D.C.</a>
                </div>
            </div>
        </div>
    </div>
    <div class="podborki">
        <div class="left">
            <div class="title-podb">Top <span class="orange-text">Single Family</span> Homes</div>
            <div class="table">
                <div class="value">
                    <a href="/en-us/developments/new-york/top-single-family-homes-ny/">Top Single Family New York</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Chicago</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Los Angeles</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Miami</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);">Top Single Family Washington, D.C.</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb">Top <span class="orange-text">Developers</span></div>
            <div class="table">
                <?
                //echo "<pre>"; print_r($arResult['VARIABLES']['SECTION_ID']); echo "</pre>";
                $developRes = CIBlockSection::GetList(
                    Array("SORT"=>" NAME"),
                    Array('ID' => $arResult['VARIABLES']['SECTION_ID']),
                    false,
                    Array('IBLOCK_ID', 'ID', 'IBLOCK_SECTION_ID', 'NAME', 'DETAIL_URL'),
                    false
                );
                if($fetchDevelop = $developRes -> GetNext()){

                    $getSectionsDevelop = GetAllSectionIn(4, $fetchDevelop['ID'], array(), array('ID', 'NAME', 'UF_TOP_DEVELOPER', 'IBLOCK_ID', 'PICTURE', 'UF_NAME_RU', 'UF_IS_PAGE', 'SECTION_PAGE_URL', 'DEPTH_LEVEL'));
                    
                    function sortByOrder($a, $b) {
                        return strcmp($a["NAME"], $b["NAME"]);
                    }

                    usort($getSectionsDevelop, 'sortByOrder');

                    $counter == 0;
                    foreach ($getSectionsDevelop as $key => $sectionDevelop) {
                        if($sectionDevelop['UF_TOP_DEVELOPER'] == '1'){
                            $counter++;
                            //echo "<pre>"; print_r($sectionNeighbor); echo "</pre>";
                            ?>
                            <div class="value">
                                <a href="/<?=strtolower(LANGUAGE_ID)?>-us<?=strtolower()?><?=$sectionDevelop['SECTION_PAGE_URL']?>"><?=$sectionDevelop['NAME']?></a>
                            </div>
                            <?
                        }
                    }

                }
                ?>

                <?/*<div class="value">
                    <a href="/developments/usa/toll-brothers-city-living/">Toll Brothers City Living</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/related/">Related</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/extell-development-company/">Extell Development Company</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/rockefeller-group/">Rockefeller Group</a>
                </div>
                <div class="value">
                    <a href="/developments/usa/brookfield-properties/">Brookfield Properties</a>
                </div>*/?>
            </div>
        </div>
    </div>
<?}?>
    <?

    foreach ($arrSections as $key => $value) {
        $APPLICATION->IncludeComponent(
    "bitrix:catalog.section", 
    "catalogAdditional", 
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
        "COMPONENT_TEMPLATE" => "catalogAdditional",
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
        "FILTER_NAME" => "arrFilter",
        "HIDE_NOT_AVAILABLE" => "N",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "IBLOCK_ID" => "4",
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
        "SECTION_ID" => $value,
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
        "SHOW_ALL_WO_SECTION" => "N",
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
    }
    ?>
<? if ($isSidebar): ?>
    <div class="col-md-3 col-sm-4">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => $arParams["SIDEBAR_PATH"],
                "AREA_FILE_RECURSIVE" => "N",
                "EDIT_MODE" => "html",
            ),
            false,
            array('HIDE_ICONS' => 'Y')
        );
        ?>
    </div>
<? endif;