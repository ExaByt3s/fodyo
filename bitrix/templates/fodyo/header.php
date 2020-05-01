<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="robots" content="none"/>
    <link rel="shortcut icon" type="image/x-icon" href="<?=htmlspecialcharsbx(SITE_DIR)?>favicon.ico" />
    <?$APPLICATION->ShowCSS();
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();
    $APPLICATION->ShowMeta('keywords');
    $APPLICATION->ShowMeta('description');

    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/colors.css", true);
    //$APPLICATION->SetAdditionalCSS("/bitrix/css/main/bootstrap.css");
    $APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
    //$APPLICATION->SetAdditionalCSS("/bitrix/templates/eshop_bootstrap_green_copy/my_style.css");
    ?>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/my_style.css">
    <title><?$APPLICATION->ShowTitle()?></title>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jQuery_v3.3.js"></script>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<script>
    function changeURL(elem){
        console.log(elem);
        if(elem == 'RU'){
            document.location.href="https://ru.fodyo.com";
        }
        else if(elem == 'EN'){
            document.location.href="https://fodyo.com";
        }
    }
</script>
    
    <div class="bx-wrapper">
        <?
        if ($curPage != SITE_DIR)
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
    <div class="main-content">
    