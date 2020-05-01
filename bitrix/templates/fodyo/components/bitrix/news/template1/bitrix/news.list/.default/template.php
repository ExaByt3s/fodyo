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
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
  <?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
  <?
  $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
  $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
  ?>
  <div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
      <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
            class="preview_picture"
            border="0"
            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
            width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
            height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
            style="float:left"
            /></a>
      <?else:?>
        <img
          class="preview_picture"
          border="0"
          src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
          width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
          height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
          alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
          title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
          style="float:left"
          />
      <?endif;?>
    <?endif?>
    
    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
      <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a><br/>
      <?else:?>
        <?echo $arItem["NAME"]?>
      <?endif;?>
    <?endif;?>
    <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
      <span class="preview-text-news"><?echo $arItem["PREVIEW_TEXT"];?></span>
    <?endif;?>
    <?foreach($arItem["FIELDS"] as $code=>$value):?>
      <small>
      <?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
      </small><br />
    <?endforeach;?>
    <?/*foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
      <?=$arProperty["NAME"]?>:&nbsp;
      <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
        <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
      <?else:?>
        <?=$arProperty["DISPLAY_VALUE"];?>
      <?endif?>
    <?endforeach;*/?>
    <div class="news-bottom-gray">
      <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
        <span class="news-date-time news-text-gray"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
      <?endif?>
      <img src="<?=SITE_TEMPLATE_PATH?>/images/user_micro_image.png">
       <span class="news-text-gray">33</span>
    </div>

  </div>

<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
  <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
