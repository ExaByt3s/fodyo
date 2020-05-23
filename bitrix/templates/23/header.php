<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*use Bitrix\Main\Loader,
       Rover\GeoIp\Location;

//echo "<pre>"; print_r($_COOKIE); echo "</pre>";


if (Loader::includeModule('rover.geoip'))
{
    $location = Location::getInstance(Location::getCurIp());
}

echo 'ip: '                 . $location->getIp() . '<br>';          // 5.255.255.88
echo 'город: '              . $location->getCityName() . '<br>';        // Москва
echo 'iso-код страны: '     . $location->getCountryCode() . '<br>';     // RU
echo 'название страны: '    . $location->getCountryName() . '<br>'; // Россия
echo 'id страны в Битриксе: '    . $location->getCountryId() . '<br>'; // 1
echo 'регион: '             . $location->getRegionName() . '<br>';      // Москва
echo 'iso-код региона: '    . $location->getRegionCode() . '<br>';      // 
echo 'округ: '              . $location->getDistrict() . '<br>';    // Центральный федеральный округ
echo 'широта: '             . $location->getLat() . '<br>';         // 55.755787
echo 'долгота: '            . $location->getLng() . '<br>';         // 37.617634
echo 'диапазон адресов: '   . $location->getInetnum() . '<br>';     // 5.255.252.0 - 5.255.255.255
echo 'сервис: '             . $location->getService() . '<br><br>';     // IpGeoBase
*/

$getUrl = $_SERVER['REQUEST_URI'];
$plo = explode('?', $getUrl);
$url = $plo[0];
/*if(stristr($url, '//') || preg_match('*[A-Z]*',$url)){
    while (stristr($url, '//')) {
        $url = str_replace('//', '/', $url);
    }
    $plo[0] = strtolower($url);
    //echo "<pre style='display:none;'>"; print_r($url); echo "</pre>";
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: ".implode('?', $plo)); 
    exit(); 
}*/

IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

function debug($param) {
    if ($_COOKIE['debug']) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
    return 0;
}

?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>

    <script data-skip-moving="true"  src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link media="print" onload="this.setAttribute('media', 'all')" rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="google-site-verification" content="ifcVWmhh3YtPhBimT5vHzFe1RcQ7ge56FEll5UXMcmU" />
   <?
        if (substr_count($_SERVER['SERVER_NAME'], 'develop.fodyo') > 0) {

        // $APPLICATION->SetPageProperty("robots", "noindex, nofollow");
            echo '<meta name="robots" content="noindex, nofollow"/>';
 
        }else{
            $dir = $APPLICATION->GetCurDir();
            if( strrpos($dir,  '/agreement' ) !== false ){
                ?>
                    <meta name="robots" content="noindex, nofollow"/>
                <?
            }
            $url = $APPLICATION->GetCurUri();
            if(stristr($url, 'PAGEN')){
                ?>
                    <meta name="robots" content="noindex, follow"/>
                <?
            }
        }
    ?>
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#da532c">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="yandex-verification" content="b2612b948fdc3e4d" />
    <?$APPLICATION->ShowCSS();
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();
    $APPLICATION->ShowMeta('keywords');
    $APPLICATION->ShowMeta('description');

    $APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.min.css");


    $APPLICATION->SetAdditionalCSS("/bitrix/templates/23/css/CookieContainer.css");
    $APPLICATION->SetAdditionalCSS("/bitrix/templates/23/css/MobileButtonBlock.css");
    $APPLICATION->SetAdditionalCSS("/bitrix/templates/23/css/CheckBox.css");
    ?>
    <title><?$APPLICATION->ShowTitle("title")?></title>
    <!--script src="<?=SITE_TEMPLATE_PATH?>/js/jQuery_v3.3.js"></script-->    
    <script defer src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" media="print" onload="$(this).attr('media', 'all')" href="/bitrix/templates/23/js/mmenu/mmenu.css" />
    <link rel="stylesheet" media="print" onload="$(this).attr('media', 'all')" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script defer src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script defer src="/bitrix/templates/23/js/jquery.cookie.js"></script>
    <script defer src="/bitrix/templates/23/js/jquery.mask.js"></script>
    <?
    
    $APPLICATION->AddHeadScript("/bitrix/templates/23/js/CookieContainer.js");
    $APPLICATION->AddHeadScript("/bitrix/templates/23/js/MobileButtonBlock.js");
    $APPLICATION->AddHeadScript("/bitrix/templates/23/js/CheckBox.js");

    ?>
    <!--script defer src="/bitrix/templates/23/components/bitrix/menu/new-fodyo-top-menu/script2.js"></script-->

	

    <?
    $slpitParams = explode('?', $_SERVER['REQUEST_URI']);
    $parameters = $slpitParams[1];
    $exploRus = explode('/', $slpitParams[0]);

    if($exploRus[1] == '' || empty($exploRus[1]) || $exploRus[1] == 'ru'){
        $exploRus[0] = '/ru/';
        unset($exploRus[1]);
    }else{
        $plodeSec = explode('-', $exploRus[1]);
        if(isset($plodeSec[1])){
            $plodeSec[0] = str_replace('en', 'ru', $plodeSec[0]);
            $exploRus[1] = implode('-', $plodeSec);
        }else{
            $exploRus[0] = '/ru/';
        }
    }

    $slpitParams[0] = implode('/', $exploRus);
    //$exploRus = implode('/', $exploRus);
    $exploRus = implode('?', $slpitParams);

    $slpitParams = explode('?', $_SERVER['REQUEST_URI']);
    $exploEn = explode('/', $slpitParams[0]);
    if(stristr($exploEn[1], 'ru-')){
        $plodeSec = explode('-', $exploEn[1]);
        $plodeSec[0] = str_replace('ru', 'en', $plodeSec[0]);
        $exploEn[1] = implode('-', $plodeSec);
    }else if(!stristr($exploEn[1], 'en-')){
        $plodeSec = explode('-', $exploEn[1]);
        $plodeSec[0] = str_replace('ru', '', $plodeSec[0]);
        $exploEn[1] = implode('-', $plodeSec);
        //unset($exploEn[0]);
    }
    $slpitParams[0] = implode('/', $exploEn);
    $exploEn = implode('?', $slpitParams);

    while (stristr($exploEn, '//') || stristr($exploRus, '//')){
        $exploEn = str_replace('//', '/', $exploEn);
        $exploRus = str_replace('//', '/', $exploRus);
    }
    ?>

    <?
    if(stristr($parameters, 'PAGEN') || stristr($_SERVER['REQUEST_URI'], '//') || stristr($parameters, 'sku-preview') || stristr($parameters, 'item')){
        $res_canon = str_replace('//', '/', $APPLICATION->GetCurDir());
        ?>
        <link rel="canonical" href="<?=$res_canon?>"/>
        <?
    }
    
    ?>
 <?if (substr_count($_SERVER['SERVER_NAME'], 'develop.fodyo') > 0) {?>

    <link rel="alternate" hreflang="x-default" href="<?='https://develop.fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="en" href="<?='https://develop.fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="ru" href="<?='https://develop.fodyo.com'.$exploRus;?>" /> 
        <?}else{?> 
        
    <link rel="alternate" hreflang="x-default" href="<?='https://fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="en" href="<?='https://fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="ru" href="<?='https://fodyo.com'.$exploRus;?>" />
    <?}?>
<!--     <link rel="alternate" hreflang="x-default" href="<?//='https://fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="en" href="<?//='https://fodyo.com'.$exploEn;?>" />
    <link rel="alternate" hreflang="ru" href="<?//='https://fodyo.com'.$exploRus;?>" /> -->

	<?php 
	function CustomFormatValue($value, $currencyFrom, $currencyTo, $flagMobile, $k) {
	    $numberValue = CCurrencyRates::ConvertCurrency($value, $currencyFrom, $currencyTo);
	    $numberValueStr = "";
	    $numberPrefix = "";
	    $numberSuffix = "";
	    switch ($currencyTo) {
	        case "RUB":
	            if(LANGUAGE_ID == 'ru')
	            {
	                $numberSuffix = ($flagMobile == true) ?"" :"руб.";
	            }
	            else
	            {
	                $numberPrefix = "₽";
	            }
	            break;
	        case "USD":
	            $numberPrefix = "$";
	            break;
	        case "EUR":
	            $numberPrefix = "€";
	            break;
	        default:
	            break;
	    }
	    if($flagMobile == true)
	    {
	        $numberValue = $numberValue/$k;
	        $delimer = (ceil($numberValue*10)%10 == 0)?0:1;
	        $numberValueStr = (LANGUAGE_ID == 'ru') ? number_format($numberValue, $delimer, ',', ' ') : number_format($numberValue, $delimer, '.', ' ');
	        if($k == 1000)
	        {
	            $numberSuffix = (LANGUAGE_ID == 'ru') ? (($flagMobile == true) ?"" :" тыс.").$numberSuffix : "K";
	        }
	        else if($k == 1000000)
	        {
	            $numberSuffix = (LANGUAGE_ID == 'ru') ? (($flagMobile == true) ?"" :" млн.").$numberSuffix : "M";
	        }
	    }
	    else
	    {
	        $numberValue = $numberValue;
	        $numberValueStr = (LANGUAGE_ID == 'ru') ? number_format($numberValue, 0, ',', ' ') : number_format($numberValue, 0, '.', ' ');
	        $numberSuffix = (LANGUAGE_ID == 'ru') ? (" ").$numberSuffix: "";
	    }
	    
	    return $numberPrefix.$numberValueStr.$numberSuffix;
	}
	?>
	
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<script>
    function changeURL(elem){
        //console.log(elem);
        if(elem == 'RU'){
            //console.log(window.location.href);
            $.removeCookie('LANGUAGE_SET', { path: '/'})
            if ($.cookie('hideModal')) {
            	$.cookie('LANGUAGE_SET', 'ru', { path: '/'})
            }
            window.location = $('link[hreflang="ru"]').attr('href');
                    
        }
        else if(elem == 'EN'){
            //console.log(window.location.href);
            $.removeCookie('LANGUAGE_SET', { path: '/'})
            if ($.cookie('hideModal')) {
            	$.cookie('LANGUAGE_SET', 'en', { path: '/'})
        	}
            window.location = $('link[hreflang="en"]').attr('href');
        }
    }
    function changeCurrency(val){
        $.removeCookie('CURRENCY_SET', { path: '/'})
        $.removeCookie('CURRENCY_SET')
        if ($.cookie('hideModal')) {
        	$.cookie('CURRENCY_SET', val, { path: '/'})
    	}
        location.reload();
    }

</script>

<div class="top-menu-btn-mobileBlock">
    <span class="top-menu-btn-mobileButton"><?=GetMessage('TITLE_APPLICATION');?></span>
</div>

<div class="cookie-container">
	<div class="cookie-container-text">
		<?if(LANGUAGE_ID == 'ru'){?>
			На этом веб-сайте используются файлы cookie, которые обеспечивают работу всех функций для наиболее эффективной навигации по странице. Если вы не хотите принимать постоянные файлы cookie, пожалуйста, выберите соответствующие настройки на своем компьютере или мобильном устройстве. Продолжая навигацию по сайту, вы косвенно предоставляете свое согласие на использование файлов cookie на этом веб-сайте и обработку ваших персональных данных . Внимание! Если вы заблокируете файлы cookie, необходимые для корректной работы сайта, это может привести к его неработоспособности. Более подробная информация предоставляется в нашей <a href="https://fodyo.com/ru/policy/">Политике конфиденциальности</a>
        <?}else{?>
        	This site uses cookies to provide you with a more responsive and personalized service. If you don't want to accept permanent cookies please configure the appropriate settings in your browser or on your mobile device. By using this site you agree to our use of cookies and processing of your personal data. Attention! If you block cookies which are necessary for correct work of this site it may cause problems with the use of the site. Please read the <a href="https://fodyo.com/policy/">Privacy policy</a> for more information on the cookies we use and how to delete or block them.
        <?}?>
	</div>
	<div class="cookie-container-button">
		<a href="javascript:void(0);" class="accept">
		<?if(LANGUAGE_ID == 'ru'){?>
			Принять и закрыть
        <?}else{?>
        	Accept and close
        <?}?>
	</a>
	</div>
</div>


<div class="top-menu-mobile">
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu", 
        "new-fodyo-top-menu", 
        array(
            "ROOT_MENU_TYPE" => "top",
            "MENU_CACHE_TYPE" => "A",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_THEME" => "site",
            "CACHE_SELECTED_ITEMS" => "N",
            "MENU_CACHE_GET_VARS" => array(
            ),
            "MAX_LEVEL" => "3",
            "CHILD_MENU_TYPE" => "left",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "COMPONENT_TEMPLATE" => "new-fodyo-top-menu"
        ),
        false
    );?>
</div>
<div class="content">
  <? if ($APPLICATION->GetCurPage(false) === '/' || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."/" || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."-".strtolower(ISO)."/"){
      if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
          $src = 'data-background-image="/bitrix/templates/23/images/'.LANGUAGE_ID.'-background.webp"';
      }
      else
      {
          $src = 'data-background-image="/bitrix/templates/23/images/'.LANGUAGE_ID.'-background.jpg"';
      }
    ?>
    <header class="bx-header">
        <div class="background-image lozad" <?=$src?>>
            <div class="flex-row">
                <div class="choose-lang-valuta">
                    <?

                    ?>
                    <select size="1" name="language" onchange="changeURL($(this).val());">
                        <?
                        if(LANGUAGE_ID != 'ru'){
                            ?>
                            <option>EN</option>
                            <option>RU</option>
                            <?
                        }else{
                            ?>
                            <option>RU</option>
                            <option>EN</option>
                            <?
                        }
                        ?>
                        
                    </select>
                    <?
                    if (CModule::IncludeModule("iblock")):
                        $getTree = CIBlockSection::GetTreeList(
                            Array('IBLOCK_ID' => 4, 'UF_TOP_DEVELOPER' => 'NO', 'ACTIVE' => 'Y', 'ID' => array(17, 90)),
                            Array('ID','IBLOCK_ID','SECTION_ID','NAME','UF_NAME_RU','DEPTH_LEVEL','SECTION_PAGE_URL','IBLOCK_SECTION_ID')
                        );
                    endif;
                    /*$key=0;
                    while($fetchTreeList = $getTree -> GetNext()){
                        if($fetchTreeList['DEPTH_LEVEL'] == 2){
                            $key++;
                            $arrResultCities[$fetchTreeList['ID']]["FATHER"] = $fetchTreeList;
                        }
                        elseif($fetchTreeList['DEPTH_LEVEL'] == 3){
                            $arrResultCities[$fetchTreeList['IBLOCK_SECTION_ID']]["CHILDREN"][] = $fetchTreeList;
                        }
                    }*/
                    
                    //echo "<pre style='display:none;'>"; print_r($arrResultCities); echo "</pre>";

                    ?>
                    <select size="1" name="currency" onchange="changeCurrency($(this).val());">
                        <?
                        if(CModule::IncludeModule("currency")){
                            $getListCurr = CCurrency::GetList(($by="sort"), ($order="asc"), LANGUAGE_ID);
                            while($lcur_res = $getListCurr->Fetch())
                            {
                                if($lcur_res['CURRENCY'] == $_COOKIE['CURRENCY_SET']){
                                    $selected = 'selected';
                                }else{ $selected = ''; }

                                ?><option <?=$selected?> ><?echo($lcur_res['CURRENCY']);?></option><?
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="logotype">
                    <div class="bx-logo">
                        <?

                        if(strtolower(LANGUAGE_ID) != 'en'){
                            $gref = strtolower(LANGUAGE_ID);
                        }else{
                            $gref = '';
                        }
                        ?>
                        <a class="bx-logo-block hidden-xs" href="/<?=$gref?>">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/company_logo.php"), false);?>
                        </a>
                    </div>
                </div>
                <div class="top-menu">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu", 
                        "new-fodyo-top-menu1", 
                        array(
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "36000000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_THEME" => "site",
                            "CACHE_SELECTED_ITEMS" => "N",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "3",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => "new-fodyo-top-menu"
                        ),
                        false
                    );?>
                </div>
                <div class="choose-lang-valuta-mobile">
                    <?

                    ?>
                    <select size="1" name="language" onchange="changeURL($(this).val());">
                        <?
                        if(LANGUAGE_ID != 'ru'){
                            ?>
                            <option>EN</option>
                            <option>RU</option>
                            <?
                        }else{
                            ?>
                            <option>RU</option>
                            <option>EN</option>
                            <?
                        }
                        ?>
                        
                    </select>
                    <?
                    if (CModule::IncludeModule("iblock")):
                        $getTree = CIBlockSection::GetTreeList(
                            Array('IBLOCK_ID' => 4, 'UF_TOP_DEVELOPER' => 'NO', 'ACTIVE' => 'Y', 'ID' => array(16, 17, 37, 90)),
                            Array('ID','IBLOCK_ID','SECTION_ID','NAME','UF_NAME_RU','DEPTH_LEVEL','SECTION_PAGE_URL','IBLOCK_SECTION_ID', 'UF_HREF_ISO')
                        );
                    endif;
                    $key=0;
                    while($fetchTreeList = $getTree -> GetNext()){
                        if($fetchTreeList['DEPTH_LEVEL'] == 2){
                            $key++;
                            $arrResultCities[$fetchTreeList['ID']]["FATHER"] = $fetchTreeList;
                        }
                        elseif($fetchTreeList['DEPTH_LEVEL'] == 3){
                            $arrResultCities[$fetchTreeList['IBLOCK_SECTION_ID']]["CHILDREN"][] = $fetchTreeList;
                        }
                    }
                    ?>
                    <select size="1" name="currency" onchange="changeCurrency($(this).val());">
                        <?
                        if(CModule::IncludeModule("currency")){
                            $getListCurr = CCurrency::GetList(($by="sort"), ($order="asc"), LANGUAGE_ID);
                            while($lcur_res = $getListCurr->Fetch())
                            {
                                if($lcur_res['CURRENCY'] == $_COOKIE['CURRENCY_SET']){
                                    $selected = 'selected';
                                }else{ $selected = ''; }

                                ?><option <?=$selected?> ><?echo($lcur_res['CURRENCY']);?></option><?
                            }
                        }
                        ?>
                    </select>
                </div>
                <a href="#mobile-menu">
                    <div class="hamburger">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </a>

                <div class="bx-inc-orginfo">
                    <div>
                        <span class="bx-inc-orginfo-phone">
                            <?
                            if(LANGUAGE_ID != 'en'){
                                $toPath = '/ru';
                            }else{
                                $toPath = '';
                            }
                            ?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include", 
                                ".default", 
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => $toPath."/include/telephone.php",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "EDIT_TEMPLATE" => ""
                                ),
                                false
                            );?>  
                        </span>
                    </div>
                </div>
            </div>

            <div class="h1-wrapper">
                <h1><?=GetMessage('MAIN_PAGE_TITLE');?></h1>
            </div>
            <div class="search-inputs">
                <select name="city-region">
                    <option><?=GetMessage('CITY_REGION');?></option>
                    <?
                    foreach ($arrResultCities as $key => $value) {

                        //echo "<pre>"; print_r($value['FATHER']); echo "</pre>";

                        $iso = strtolower($value['FATHER']['UF_HREF_ISO']);

                        foreach ($value['CHILDREN'] as $key => $item) {

                            //$nav = CIBlockSection::GetNavChain(false, $item['ID']);

                            $item['SECTION_PAGE_URL'] = str_replace('/ru/', '/', $item['SECTION_PAGE_URL']);
                            $item['SECTION_PAGE_URL'] = str_replace('/en/', '/', $item['SECTION_PAGE_URL']);

                            $item['SECTION_PAGE_URL'] = '/'.strtolower(LANGUAGE_ID).'-'.$iso.$item['SECTION_PAGE_URL'];

                            echo "<option data-href=".$item['SECTION_PAGE_URL'].">";
                            if(LANGUAGE_ID == 'en'){
                                echo $value['FATHER']['NAME'].', '.$item['NAME'];
                            }else{
                                echo $value['FATHER']['UF_NAME_'.strtoupper(LANGUAGE_ID)].', '.$item['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                            }
                            echo "</option>";
                        }
                    }
                    ?>
                </select>
                <select name="type">
                    <option><?=GetMessage('HOUSING_TYPE');?></option>
                    <option data-type="developments"><?=GetMessage('HOUSING_TYPE_NEWBUILDINGS');?></option>
                    <option data-type="condos"><?=GetMessage('HOUSING_TYPE_FLATS');?></option>
                    <option data-type="single-family-homes"><?=GetMessage('HOUSING_TYPE_COTTAGES');?></option>
                </select>
                <div class="price-filter-main">
                    <div class="price-input-wrapper">
                        <div class="inputstyles">
                            <?=GetMessage("COST");?>
                        </div>
                        <div class="inputs-price">
                            <div class="price-from">
                                <span class="price-text"><?=GetMessage('PRICE_FROM');?></span>
                                <input type="text" name="price-from">
                            </div>
                            <div class="price-to">
                                <span class="price-text"><?=GetMessage('PRICE_TO');?></span>
                                <input type="text" name="price-to">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="confirm-search"><?=GetMessage('FIND_BUTTON');?></button>
            </div>
        </div>
    </header>
    <?}else{
        ?>
        <?php 
        if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
            $formatSrc = 'webp';
        }
        else
        {
            $formatSrc = 'jpg';
        }
        ?>
        <header class="bx-header not-main-page">
            <div class="background-image" style="background: url(/bitrix/templates/23/images/<?=LANGUAGE_ID?>-background-nomain.<?=$formatSrc?>);">
                <div class="flex-row">
                    <div class="choose-lang-valuta">
                        <select size="1" name="language" onchange="changeURL($(this).val());">
                            <?
                            if(LANGUAGE_ID != 'ru'){
                                ?>
                                <option>EN</option>
                                <option>RU</option>
                                <?
                            }else{
                                ?>
                                <option>RU</option>
                                <option>EN</option>
                                <?
                            }
                            ?>
                            
                        </select>
                        <?
                        if (CModule::IncludeModule("iblock")):
                            $getTree = CIBlockSection::GetTreeList(
                                Array('IBLOCK_ID' => 4, 'ACTIVE' => 'Y'),
                                Array('ID','IBLOCK_ID','SECTION_ID','NAME','UF_NAME_RU','DEPTH_LEVEL','SECTION_PAGE_URL','IBLOCK_SECTION_ID')
                            );
                        endif;
                        $key=0;
                        while($fetchTreeList = $getTree -> GetNext()){
                            if($fetchTreeList['DEPTH_LEVEL'] == 1){
                                $key++;
                                $arrResultCities[$fetchTreeList['ID']]["FATHER"] = $fetchTreeList;
                            }
                            elseif($fetchTreeList['DEPTH_LEVEL'] == 2){
                                $arrResultCities[$fetchTreeList['IBLOCK_SECTION_ID']]["CHILDREN"][] = $fetchTreeList;
                            }
                        }
                        ?>
                        <select size="1" name="currency" onchange="changeCurrency($(this).val());">
                            <?
                            function strbool($value)
                            {
                                return $value ? 'true' : 'false';
                            }
                            //echo  "<br>curencyset ".$_COOKIE['CURRENCY_SET']."<br>";
                            //echo  "<br>Bcurencyset ".strbool(isset($_COOKIE['CURRENCY_SET']))."<br>";
                            //echo  "<br>!Bcurencyset ".strbool(!isset($_COOKIE['CURRENCY_SET']))."<br>";
                            //echo  "<br>LANGUAGE_ID ".strbool(LANGUAGE_ID == "ru")."<br>";
                            /*if(LANGUAGE_ID == "ru" && !isset($_COOKIE['CURRENCY_SET'])){
                                //echo  "<br>Unic1if<br>";
                                setcookie("CURRENCY_SET", "RUB", time()+36000, "/");
                                header('Status: 301 OK');
                                Header('Location: '.$_SERVER['REQUEST_URI']);
                                exit();
                            }elseif(LANGUAGE_ID == "en" && !isset($_COOKIE['CURRENCY_SET'])){
                                //echo  "<br>Unic2if<br>";
                                setcookie("CURRENCY_SET", "USD", time()+36000, "/");
                                header('Status: 301 OK');
                                Header('Location: '.$_SERVER['REQUEST_URI']);
                                exit();
                            }
                            if(!isset($_COOKIE['REDIRECTED']) && $APPLICATION->GetCurDir() == '/'){
                                //echo  "<br>Unic3if<br>";
                                setcookie("REDIRECTED", "Y", time()+36000, "/");
                                header("Location:".$url);
                            }*/
                            //echo  "<br>Unic4if<br>";
                                        

                            if(CModule::IncludeModule("currency")){
                                $getListCurr = CCurrency::GetList(($by="sort"), ($order="asc"), LANGUAGE_ID);
                                while($lcur_res = $getListCurr->Fetch())
                                {
                                    if($lcur_res['CURRENCY'] == $_COOKIE['CURRENCY_SET']){
                                        $selected = 'selected';
                                    }else{ $selected = ''; }
                                    ?><option <?=$selected?> ><?echo($lcur_res['CURRENCY']);?></option><?
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="logotype">
                        <div class="bx-logo">
                            <?
                            if(strtolower(LANGUAGE_ID) != 'en'){
                                $gref = strtolower(LANGUAGE_ID);
                            }else{
                                $gref='';
                            }
                            ?>
                            <a class="bx-logo-block hidden-xs" href="/<?=$gref?>">
                                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/company_logo.php"), false);?>
                            </a>
                        </div>
                    </div>
                    <div class="top-menu">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "new-fodyo-top-menu1", 
                            array(
                                "ROOT_MENU_TYPE" => "top",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "CACHE_SELECTED_ITEMS" => "N",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "3",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "new-fodyo-top-menu1"
                            ),
                            false
                        );?>
                    </div>

<!---->
<div class="choose-lang-valuta-mobile">
    <?

    ?>
    <select size="1" name="language" onchange="changeURL($(this).val());">
        <?
        if(LANGUAGE_ID != 'ru'){
            ?>
            <option>EN</option>
            <option>RU</option>
            <?
        }else{
            ?>
            <option>RU</option>
            <option>EN</option>
            <?
        }
        ?>
        
    </select>
    <?
    if (CModule::IncludeModule("iblock")):
        $getTree = CIBlockSection::GetTreeList(
            Array('IBLOCK_ID' => 4, 'UF_TOP_DEVELOPER' => 'NO', 'ACTIVE' => 'Y', 'ID' => array(16, 17, 37, 90)),
            Array('ID','IBLOCK_ID','SECTION_ID','NAME','UF_NAME_RU','DEPTH_LEVEL','SECTION_PAGE_URL','IBLOCK_SECTION_ID', 'UF_HREF_ISO')
        );
    endif;
    $key=0;
    while($fetchTreeList = $getTree -> GetNext()){
        if($fetchTreeList['DEPTH_LEVEL'] == 2){
            $key++;
            $arrResultCities[$fetchTreeList['ID']]["FATHER"] = $fetchTreeList;
        }
        elseif($fetchTreeList['DEPTH_LEVEL'] == 3){
            $arrResultCities[$fetchTreeList['IBLOCK_SECTION_ID']]["CHILDREN"][] = $fetchTreeList;
        }
    }
    ?>
    <select size="1" name="currency" onchange="changeCurrency($(this).val());">
        <?
        if(CModule::IncludeModule("currency")){
            $getListCurr = CCurrency::GetList(($by="sort"), ($order="asc"), LANGUAGE_ID);
            while($lcur_res = $getListCurr->Fetch())
            {
                if($lcur_res['CURRENCY'] == $_COOKIE['CURRENCY_SET']){
                    $selected = 'selected';
                }else{ $selected = ''; }

                ?><option <?=$selected?> ><?echo($lcur_res['CURRENCY']);?></option><?
            }
        }
        ?>
    </select>
</div>

                    <a href="#mobile-menu">
                      <div class="hamburger">
                          <div class="line"></div>
                          <div class="line"></div>
                          <div class="line"></div>
                      </div>
                    </a>

                    <div class="bx-inc-orginfo">
                        <div>
                            <span class="bx-inc-orginfo-phone">
                                <?if(LANGUAGE_ID != 'en'){
                                    $toPath = '/ru';
                                }else{
                                    $toPath = '';
                                }
                                ?>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => $toPath."/include/telephone.php",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "EDIT_TEMPLATE" => ""
                                    ),
                                    false
                                );?>  
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?}?>
    <div class="bx-wrapper">
        <?
        if ($curPage != "/index.php" && strripos($curPage, '/catalog'))
        {
            ?>
            <div class="row">
                <div class="col-lg-12" id="navigation">
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
                            "START_FROM" => "2",
                            "PATH" => "",
                            "SITE_ID" => "-"
                        ),
                        false,
                        Array('HIDE_ICONS' => 'Y')
                    );?>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    
    <div class="main-content <?if ($APPLICATION->GetCurPage(false) === '/' || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."/" || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."-".strtolower(ISO)."/"){echo('mainsitepage');}?>">
        <div class="max-width">
            <?
            if (!($APPLICATION->GetCurPage(false) === '/' || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."/" || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."-".strtolower(ISO)."/")){
                ?>
                <div class="filter">
                    <div class="location">
                        <div class="input-search">
                            <input type="text" name="place" placeholder="<?=GetMessage('RAYON_METRO_SHOSSE')?>">
                            <span class="lens"><i class="fa fa-search"></i></span>
                        </div>
                        <a href="javascript:void(0)" class="on_map" style="display: none;"><?=GetMessage('ON_MAP')?></a>
                        <a href="javascript:void(0)" class="results"><?=GetMessage('RESULTS')?> <span class="results_num" style="display: none;">0</span></a>
                    </div>
                    <div class="flex-filter" data-section-id="<?=$arResult['VARIABLES']['SECTION_ID']?>">
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("SELLING_STATUS")?> <span class="arrow-down"></span></div>
                            <div class="closed selector">
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SELLING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("SELLING_STATUS_SELLING")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SELLING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("SELLING_STATUS_RESERVING")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SELLING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("SELLING_STATUS_SOON")?></span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("HOUSING_TYPE")?> <span class="arrow-down"></span></div>
                            <div class="closed selector">
                                <label class="checkbox-new">
                                    <input type="checkbox" name="TYPE">
                                    <span class="checkbox-text"><?=GetMessage("HOUSING_TYPE_FLATS")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="TYPE">
                                    <span class="checkbox-text"><?=GetMessage("HOUSING_TYPE_APTS")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="TYPE">
                                    <span class="checkbox-text"><?=GetMessage("HOUSING_TYPE_TOWNHOUSES")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="TYPE">
                                    <span class="checkbox-text"><?=GetMessage("HOUSING_TYPE_HOUSES")?></span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("PRICE_TEXT")?> <?=GetMessage("CURRENCY_".$_COOKIE['CURRENCY_SET'])?> <span class="arrow-down"></span></div>
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
                            <div class="opener"><?=GetMessage("BUILDING_STATUS")?> <span class="arrow-down"></span></div>
                            <div class="closed selector">
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BUILDING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("BUILDING_STATUS_CONTINUES")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BUILDING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("BUILDING_STATUS_FINISHED")?></span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="BUILDING_STEP">
                                    <span class="checkbox-text"><?=GetMessage("BUILDING_STATUS_NOT_STARTED")?></span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="opener"><?=GetMessage("TIME_SDAN")?> <span class="arrow-down"></span></div>
                            <div class="closed selector">
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SROK_SDACHI">
                                    <span class="checkbox-text">2020</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SROK_SDACHI">
                                    <span class="checkbox-text">2021</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SROK_SDACHI">
                                    <span class="checkbox-text">2022</span>
                                </label>
                                <label class="checkbox-new">
                                    <input type="checkbox" name="SROK_SDACHI">
                                    <span class="checkbox-text">2023+</span>
                                </label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="clear-btn">
                                <div class="oranage-round-arrow"></div>
                                <div class="btn-text"><?=GetMessage('CLEAR')?></div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-button-hide-filter"><?=GetMessage('HIDE_FILTER')?></div>
                    <div class="mobile-button-show-filter"><?=GetMessage('SHOW_FILTER')?></div>
                </div><?
            }
            ?>
            <? if ($APPLICATION->GetCurPage(false) === '/' || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."/" || $APPLICATION->GetCurPage(false) == "/".strtolower(LANGUAGE_ID)."-".strtolower(ISO)."/"){ ?>
                <h1 style="display: none;"><?
                    if($APPLICATION->GetProperty('page_title')){
                        echo $APPLICATION->ShowProperty("page_title");
                    }else{
                        $APPLICATION->ShowTitle(false);
                    }
                ?>
                </h1>
                
                
                
            <?}?>
            