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



if($arResult["VARIABLES"]["SECTION_ID"] == 745 || $arResult['VARIABLES']['SECTION_CODE_PATH'] == 'developments' || $APPLICATION->GetCurDir() == '/'.strtolower(LANGUAGE_ID).'/developments/' || $APPLICATION->GetCurDir() == '/developments/'){
    //parse_url($_SERVER['REQUEST_URI']);
    //echo $_SERVER['REQUEST_URI'];

    if(($APPLICATION->GetCurDir() == '/'.strtolower(LANGUAGE_ID).'/developments/' || $APPLICATION->GetCurDir() == '/developments/')){
        $arResult["VARIABLES"]["SECTION_ID"] = 745;
    }
    //echo "<pre>"; print_r($arResult); echo "</pre>";

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

        /*$obCache = new CPHPCache();
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
        }*/
        /*if (!isset($arCurSection))
            $arCurSection = array();*/
    }

    //echo "<pre>"; print_r($arCurSection); echo "</pre>";
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
        header("HTTP/1.0 404 Not Found");
        include $_SERVER['DOCUMENT_ROOT'].'/404.php';
        die();        //}
    }
}else{
    header("HTTP/1.0 404 Not Found");
    include $_SERVER['DOCUMENT_ROOT'].'/404.php';
    die();
}