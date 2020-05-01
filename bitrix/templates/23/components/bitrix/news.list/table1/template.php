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


    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>
    <?$counterNews = 0;?>
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?
            //echo "<pre>"; print_r($arItem); echo "</pre>";
            ?>
            <div class="image">
                <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="preview-picture lozad" border="0" data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" hspace="0" vspace="2" title="<?=$arItem["NAME"]?>" style="float:left" /></a>
                    <?else:?>
                        <img class="preview-picture lozad" border="0" data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" hspace="0" vspace="2" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" style="float:left" />
                    <?endif;?>
                <?endif?>
            </div>
            <div class="text"> 
                <div class="news-title">
                    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                            <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["PROPERTIES"]['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];?></a><br />
                        <?else:?>
                            <?echo $arItem["PROPERTIES"]['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];?><br />
                        <?endif;?>
                    <?endif;?>
                </div>

                <div class="preview-text">
                    <?if($arItem["PROPERTIES"]['ANOUNCE_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT']):?>
                        <?echo $arItem["PROPERTIES"]['ANOUNCE_'.strtoupper(LANGUAGE_ID)]['VALUE']['TEXT'];?>
                    <?endif;?>
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                        <div style="clear:both"></div>
                    <?endif?>
                </div>
                <a class="detail" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=GetMessage("READ_MORE_TEXT")?></a>
            </div>
        </div>
        <?
        $counterNews++;
        if($counterNews == 3){
            break;
        }
        ?>
    <?endforeach;?>


