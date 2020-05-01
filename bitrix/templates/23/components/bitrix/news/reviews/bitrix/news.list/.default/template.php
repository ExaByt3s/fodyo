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

//echo "<pre>"; print_r($arResult);echo "</pre>";
?>
<div class="reviews">
    <div class="block-title">
        <span class="reviews-title"><?=GetMessage('REVIEWS_TITLE')?></span>
    </div>
    <div class="slider-wrapper">
        <?if(count($arResult['ITEMS']) > 1){?>
            <div class="control-left"><i class="fa fa-angle-left"></i></div>
        <?}?>
        <div class="slides-reviews">
            <?$marker=true;?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                //echo "<pre>"; print_r($arItem['PROPERTIES']['LANGUAGE']['VALUE_ENUM']); echo "</pre>";
                if($arItem['PROPERTIES']['LANGUAGE']['VALUE_ENUM'] == LANGUAGE_ID){
                     $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="slide-item-reviews <?if($marker){$marker=false; echo 'active-slide';}?>">
                        <div class="image-review">
                            <img class="lozad" data-src="<?=CFile::GetPath($arItem["PROPERTIES"]['PICTURE_SLIDER']['VALUE'])?>"/>
                        </div>
                        <div class="review-content">
                            <div class="review-title">
                                <?print_r($arItem["DISPLAY_PROPERTIES"]['UPPER_TEXT']["DISPLAY_VALUE"]);?>
                            </div>
                            <div class="review-text">
                                <?print_r($arItem["DISPLAY_PROPERTIES"]['LOWER_TEXT']["DISPLAY_VALUE"]);?>
                            </div>
                        </div>
                    </div> 
                    <?       
                } 
            endforeach;?>
        </div>
        <?if(count($arResult['ITEMS']) > 1){?>
            <div class="control-right"><i class="fa fa-angle-right"></i></div>
        <?}?>
    </div>
</div>
