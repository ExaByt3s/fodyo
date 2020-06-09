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
$this->setFrameMode(true);
?>
<div class="news-detail">
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
        <img
            class="detail_picture"
            border="0"
            src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
            width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
            height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
            alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
            title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
            />
    <?endif?>
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
    <?endif;?>
    <?
    if($arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]){
        ?><h2><?print_r($arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'])?></h2><?
        $APPLICATION->SetPageProperty('title', $arResult['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
    }
    //echo "<pre>"; print_r($arResult['PROPERTIES']); echo "</pre>";
    if($arResult['PROPERTIES']['DETAIL_'.strtoupper(LANGUAGE_ID)]){
        ?><div><?print_r(htmlspecialcharsBack($arResult["PROPERTIES"]['DETAIL_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT']))?></div><?
    }
    ?>
    <div style="clear:both"></div>
    <br />
    <?
    if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
    {
        ?>
        <div class="news-detail-share">
            <noindex>
            <?
            $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                    "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                    "PAGE_TITLE" => $arResult["~NAME"],
                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "HIDE" => $arParams["SHARE_HIDE"],
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
            ?>
            </noindex>
        </div>
        <?
    }
    ?>
</div>