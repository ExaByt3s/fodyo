<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

$explodeSec = explode('/', $arResult["VARIABLES"]["SECTION_CODE_PATH"]);
//echo "<pre>"; print_r($explodeSec); echo "</pre>";
if($arResult["VARIABLES"]["SECTION_ID"] == 745 || $arResult['VARIABLES']['SECTION_CODE_PATH'] == 'developments'){
    //parse_url($_SERVER['REQUEST_URI']);
    //echo $_SERVER['REQUEST_URI'];
    $explo = explode('?', $_SERVER['REQUEST_URI']);

    $explo = explode('/', $explo[0]);
    if($explo[1] == 'developments'){
        $getSectionCode = 'us';
    }
    elseif($explo[1] != 'bitrix'){
        $explo = explode('-', $explo[1]);
        if(empty($explo[1]) || $explo[1] == '' || $explo[0] == "developments"){
            $getSectionCode = 'us';
        }else{
            $getSectionCode = $explo[1];
        }
    }
    $getSectList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'UF_HREF_ISO' => $getSectionCode),false,array('ID', 'NAME', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'IBLOCK_ID', 'UF_HREF_ISO', 'SECTION_PAGE_URL'));

    if($fetchSection = $getSectList -> GetNext()){
        $arResult["VARIABLES"]["SECTION_ID"] = $fetchSection['ID'];
    }
    
    if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
        $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
    $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

    $isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
    $isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
    $isFilter = ($arParams['USE_FILTER'] == 'Y');

    if ($isFilter)
    {
        $arFilter = array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ACTIVE" => "Y",
            "GLOBAL_ACTIVE" => "Y",
        );
        if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
            $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
        elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
            $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

        $obCache = new CPHPCache();
        if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
        {
            $arCurSection = $obCache->GetVars();
        }
        elseif ($obCache->StartDataCache())
        {
            $arCurSection = array();
            if (Loader::includeModule("iblock"))
            {
                $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

                if(defined("BX_COMP_MANAGED_CACHE"))
                {
                    global $CACHE_MANAGER;
                    $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                    if ($arCurSection = $dbRes->Fetch())
                        $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

                    $CACHE_MANAGER->EndTagCache();
                }
                else
                {
                    if(!$arCurSection = $dbRes->Fetch())
                        $arCurSection = array();
                }
            }
            $obCache->EndDataCache($arCurSection);
        }
        if (!isset($arCurSection))
            $arCurSection = array();
    }


    ?>
    <div class="row">
    <?
    if ($isVerticalFilter)
        include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
    else
        include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
    ?>
    </div><?
}elseif(count($explodeSec) >= 2){
    $getSectList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $explodeSec[count($explodeSec) - 1]));

    if($fetchSection = $getSectList -> GetNext()){

        $ibsTreeResource = CIBlockSection::GetNavChain( $arParams['IBLOCK_ID'], $fetchSection['ID']);
        while($sectionItem = $ibsTreeResource->Fetch()){
            //echo "<pre style='display:none;'>"; print_r(array($sectionItem, $fetchSection['ID'])); echo "</pre>";
            $getSectList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $sectionItem['ID']),false,array('ID', 'NAME', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'IBLOCK_ID', 'UF_HREF_ISO', 'SECTION_PAGE_URL'));
            if($fetchListSect = $getSectList -> GetNext()){
                if($fetchListSect['UF_HREF_ISO']){
                    $ufHref = $fetchListSect['UF_HREF_ISO'];
                }
            }  
        }
        $explo = explode('?', $_SERVER['REQUEST_URI']);

        $explo = explode('/', $explo[0]);
        if($explo[1] == 'developments'){
            $getSectionCode = 'us';
        }
        elseif($explo[1] != 'bitrix'){
            $explo = explode('-', $explo[1]);
            if(empty($explo[1]) || $explo[1] == '' || $explo[0] == "developments"){
                $getSectionCode = 'us';
            }else{
                $getSectionCode = $explo[1];
            }
        }
        if($ufHref != $getSectionCode){
            header("HTTP/1.0 404 Not Found");
            include $_SERVER['DOCUMENT_ROOT'].'/404.php';
            die();
            //echo "<pre style='display:none;'>"; print_r(array($ufHref, $getSectionCode)); echo "</pre>";
        }else{
            if(stristr($arResult['VARIABLES']['SECTION_CODE_PATH'], 'completion')){
                $arResult["VARIABLES"]["SECTION_ID"] = $fetchSection['IBLOCK_SECTION_ID'];

                if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
                    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
                $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

                $isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
                $isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
                $isFilter = ($arParams['USE_FILTER'] == 'Y');

                if ($isFilter)
                {
                    $arFilter = array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ACTIVE" => "Y",
                        "GLOBAL_ACTIVE" => "Y",
                    );
                    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
                        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
                    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
                        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

                    $obCache = new CPHPCache();
                    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
                    {
                        $arCurSection = $obCache->GetVars();
                    }
                    elseif ($obCache->StartDataCache())
                    {
                        $arCurSection = array();
                        if (Loader::includeModule("iblock"))
                        {
                            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

                            if(defined("BX_COMP_MANAGED_CACHE"))
                            {
                                global $CACHE_MANAGER;
                                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                                if ($arCurSection = $dbRes->Fetch())
                                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

                                $CACHE_MANAGER->EndTagCache();
                            }
                            else
                            {
                                if(!$arCurSection = $dbRes->Fetch())
                                    $arCurSection = array();
                            }
                        }
                        $obCache->EndDataCache($arCurSection);
                    }
                    if (!isset($arCurSection))
                        $arCurSection = array();
                }

                include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_completion.php");
            }elseif(stristr($arResult['VARIABLES']['SECTION_CODE_PATH'], 'price')){
                $arResult["VARIABLES"]["SECTION_ID"] = $fetchSection['IBLOCK_SECTION_ID'];

                if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
                    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
                $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

                $isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
                $isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
                $isFilter = ($arParams['USE_FILTER'] == 'Y');

                if ($isFilter)
                {
                    $arFilter = array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ACTIVE" => "Y",
                        "GLOBAL_ACTIVE" => "Y",
                    );
                    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
                        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
                    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
                        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

                    $obCache = new CPHPCache();
                    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
                    {
                        $arCurSection = $obCache->GetVars();
                    }
                    elseif ($obCache->StartDataCache())
                    {
                        $arCurSection = array();
                        if (Loader::includeModule("iblock"))
                        {
                            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

                            if(defined("BX_COMP_MANAGED_CACHE"))
                            {
                                global $CACHE_MANAGER;
                                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                                if ($arCurSection = $dbRes->Fetch())
                                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

                                $CACHE_MANAGER->EndTagCache();
                            }
                            else
                            {
                                if(!$arCurSection = $dbRes->Fetch())
                                    $arCurSection = array();
                            }
                        }
                        $obCache->EndDataCache($arCurSection);
                    }
                    if (!isset($arCurSection))
                        $arCurSection = array();
                }

                include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_price.php");
            }else{
                $arResult["VARIABLES"]["SECTION_ID"] = $fetchSection['ID'];

                if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
                    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
                $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

                $isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
                $isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
                $isFilter = ($arParams['USE_FILTER'] == 'Y');

                if ($isFilter)
                {
                    $arFilter = array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ACTIVE" => "Y",
                        "GLOBAL_ACTIVE" => "Y",
                    );
                    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
                        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
                    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
                        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

                    $obCache = new CPHPCache();
                    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
                    {
                        $arCurSection = $obCache->GetVars();
                    }
                    elseif ($obCache->StartDataCache())
                    {
                        $arCurSection = array();
                        if (Loader::includeModule("iblock"))
                        {
                            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

                            if(defined("BX_COMP_MANAGED_CACHE"))
                            {
                                global $CACHE_MANAGER;
                                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                                if ($arCurSection = $dbRes->Fetch())
                                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

                                $CACHE_MANAGER->EndTagCache();
                            }
                            else
                            {
                                if(!$arCurSection = $dbRes->Fetch())
                                    $arCurSection = array();
                            }
                        }
                        $obCache->EndDataCache($arCurSection);
                    }
                    if (!isset($arCurSection))
                        $arCurSection = array();
                }


                ?>
                <div class="row">
                <?
                if ($isVerticalFilter)
                    include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
                else
                    include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
            }
        }
        ?>
        <?
    }else{
        /*$getElemList = CIBlockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $explodeSec[count($explodeSec) - 1]));
        if($fetchElem = $getElemList -> GetNext()){

            $db_old_groups = CIBlockElement::GetElementGroups($fetchElem['ID'], true);
            while($ar_group = $db_old_groups->Fetch()){
                $getSectList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $ar_group["ID"]),false,array('ID', 'NAME', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'IBLOCK_ID', 'UF_HREF_ISO', 'SECTION_PAGE_URL'));
                if($fetchListSect = $getSectList -> GetNext()){
                    if($fetchListSect['UF_HREF_ISO']){
                        $ufHref = $fetchListSect['UF_HREF_ISO'];
                    }
                }
            }
            $explo = explode('?', $_SERVER['REQUEST_URI']);

            $explo = explode('/', $explo[0]);
            if($explo[1] == 'developments'){
                $getSectionCode = 'us';
            }
            elseif($explo[1] != 'bitrix'){
                $explo = explode('-', $explo[1]);
                if(empty($explo[1]) || $explo[1] == '' || $explo[0] == "developments"){
                    $getSectionCode = 'us';
                }else{
                    $getSectionCode = $explo[1];
                }
            }
            echo "<pre style='display:none;'>"; print_r(array($ufHref, $getSectionCode)); echo "</pre>";
            if($ufHref != $getSectionCode){
                header("HTTP/1.0 404 Not Found");
                include $_SERVER['DOCUMENT_ROOT'].'/404.php';
                die();
                //echo "<pre style='display:none;'>"; print_r(array($ufHref, $getSectionCode)); echo "</pre>";
            }else{
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.element",
                    ".default", 
                    array(
                        "ACTION_VARIABLE" => "action",
                        "ADD_DETAIL_TO_SLIDER" => "N",
                        "ADD_ELEMENT_CHAIN" => "N",
                        "ADD_PICT_PROP" => "-",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "ADD_TO_BASKET_ACTION" => array(
                            0 => "BUY",
                        ),
                        "ADD_TO_BASKET_ACTION_PRIMARY" => array(
                            0 => "BUY",
                        ),
                        "BACKGROUND_IMAGE" => "-",
                        "BASKET_URL" => "/personal/basket.php",
                        "BRAND_USE" => "N",
                        "BROWSER_TITLE" => "-",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_SECTION_ID_VARIABLE" => "N",
                        "COMPATIBLE_MODE" => "Y",
                        "COMPONENT_TEMPLATE" => ".default",
                        "CONVERT_CURRENCY" => "N",
                        "DETAIL_PICTURE_MODE" => array(
                            0 => "POPUP",
                            1 => "MAGNIFIER",
                        ),
                        "DETAIL_URL" => "",
                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                        "DISPLAY_COMPARE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PREVIEW_TEXT_MODE" => "E",
                        "ELEMENT_CODE" => "",
                        "ELEMENT_ID" => $fetchElem["ID"],
                        "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
                        "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
                        "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                        "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
                        "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
                        "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
                        "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                        "GIFTS_MESS_BTN_BUY" => "Выбрать",
                        "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                        "GIFTS_SHOW_IMAGE" => "Y",
                        "GIFTS_SHOW_NAME" => "Y",
                        "GIFTS_SHOW_OLD_PRICE" => "Y",
                        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "IBLOCK_TYPE" => "catalog",
                        "IMAGE_RESOLUTION" => "16by9",
                        "LABEL_PROP" => array(
                        ),
                        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                        "LINK_IBLOCK_ID" => "",
                        "LINK_IBLOCK_TYPE" => "",
                        "LINK_PROPERTY_SID" => "",
                        "MAIN_BLOCK_OFFERS_PROPERTY_CODE" => array(
                        ),
                        "MAIN_BLOCK_PROPERTY_CODE" => array(
                        ),
                        "MESSAGE_404" => "",
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                        "MESS_BTN_BUY" => "Купить",
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                        "MESS_COMMENTS_TAB" => "Комментарии",
                        "MESS_DESCRIPTION_TAB" => "Описание",
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                        "MESS_PRICE_RANGES_TITLE" => "Цены",
                        "MESS_PROPERTIES_TAB" => "Характеристики",
                        "META_DESCRIPTION" => "-",
                        "META_KEYWORDS" => "-",
                        "OFFERS_FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_LIMIT" => "0",
                        "OFFERS_SORT_FIELD" => "sort",
                        "OFFERS_SORT_FIELD2" => "id",
                        "OFFERS_SORT_ORDER" => "asc",
                        "OFFERS_SORT_ORDER2" => "desc",
                        "OFFER_ADD_PICT_PROP" => "-",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRICE_CODE" => array(
                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRICE_VAT_SHOW_VALUE" => "N",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
                        "PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_SUBSCRIPTION" => "Y",
                        "SECTION_CODE" => "",
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "SECTION_URL" => "",
                        "SEF_MODE" => "N",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_CANONICAL_URL" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y",
                        "SET_VIEWED_IN_COMPONENT" => "N",
                        "SHOW_404" => "N",
                        "SHOW_CLOSE_POPUP" => "N",
                        "SHOW_DEACTIVATED" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_MAX_QUANTITY" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "SHOW_SLIDER" => "N",
                        "STRICT_SECTION_CHECK" => "N",
                        "TEMPLATE_THEME" => "blue",
                        "USE_COMMENTS" => "N",
                        "USE_ELEMENT_COUNTER" => "Y",
                        "USE_ENHANCED_ECOMMERCE" => "N",
                        "USE_GIFTS_DETAIL" => "Y",
                        "USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
                        "USE_MAIN_ELEMENT_SECTION" => "N",
                        "USE_PRICE_COUNT" => "N",
                        "USE_PRODUCT_QUANTITY" => "N",
                        "USE_RATIO_IN_RANGES" => "N",
                        "USE_VOTE_RATING" => "N"
                    ),
                    false
                );
            }
        }else{*/
            header("HTTP/1.0 404 Not Found");
            include $_SERVER['DOCUMENT_ROOT'].'/404.php';
            die();
        //}
    }
}else{
    header("HTTP/1.0 404 Not Found");
    include $_SERVER['DOCUMENT_ROOT'].'/404.php';
    die();
}