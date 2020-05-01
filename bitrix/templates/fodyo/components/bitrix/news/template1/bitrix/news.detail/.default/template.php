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
<div class="section_wrap_content">
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

    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
      <h3 class="textBlue"><?=$arResult["NAME"]?></h3>
    <?endif;?>
    <?
    $getList = CIBlockElement::GetList(array(), array('ID'=>$arResult['ID']), false, false, array('ID','NAME','CREATED_BY'));
    if($getFetch = $getList -> Fetch()){
      //echo "<pre>";print_r($getFetch);echo "</pre>";
      $userid = $getFetch['CREATED_BY'];
      $rsUser = CUser::GetByID($userid);
      $arUser = $rsUser->Fetch();
      //print_r($arUser);
      echo '<span class="creator textOrange">'.$arUser["NAME"].' '.$arUser['LAST_NAME'].'</span>';
    }
    ?>
    <span class="news-detail-text">
    <?if($arResult["NAV_RESULT"]):?>
      <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
      <?echo $arResult["NAV_TEXT"];?>
      <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>    
      <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
        <?echo $arResult["DETAIL_TEXT"];?>
      <?else:?>
        <?echo $arResult["PREVIEW_TEXT"];?>
      <?endif?>
    </span>

    <?
      
      //echo "<pre>"; print_r($arResult); echo "</pre>";
      
      //$GLOBALS['users'] = array("CREATED_BY" => $getFetch['CREATED_BY']);
    ?>

    <?foreach($arResult["FIELDS"] as $code=>$value):
      if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
      {
        ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
        if (!empty($value) && is_array($value))
        {
          ?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
        }
      }
      else
      {
        ?><?//=GetMessage("IBLOCK_FIELD_".$code)?><?//=$value;?><?
      }
      ?><br />
    <?endforeach;

    foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

      <?//=$arProperty["NAME"]?>:&nbsp;
      <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
        <?//=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
      <?else:?>
        <?//=$arProperty["DISPLAY_VALUE"];?>
      <?endif?>
      <br />
    <?endforeach;
   // echo "<pre>"; print_r($arResult['DISPLAY_ACTIVE_FROM']); echo "</pre>";
    ?>
    <div class="news-bottom">
      <div class="read-more-news">
          <span class="textBlue">Читайте также: </span>
          <?
          $getList = CIBlockElement::GetList(array(), array('CREATED_BY'=>$userid, 'ACTIVE' => 'Y', 'IBLOCK_ID' => 9), false, false, array('ID','NAME','CREATED_BY','DETAIL_PAGE_URL'));
          while($getFetch = $getList -> GetNext()){
            //echo "<pre>"; print_r($getFetch); echo "</pre>";
            ?>
            <a class="textOrange" href="<?=$getFetch['DETAIL_PAGE_URL']?>">
              <?=$getFetch['NAME']?>
            </a>
            <?
          }
          ?>

      </div>

      <div class="news-text-gray" style="margin-bottom: 20px;color: #707070;font-size: 15px;">Дата публикации <?=$arResult['DISPLAY_ACTIVE_FROM']?></div>
      <span class="news-detail-text">Поделиться с друзьями:</span>
      <div class="share"><img style="height: 40px;margin-top: 10px;" src="<?=SITE_TEMPLATE_PATH?>/images/share.png"></div>
    </div>
  </div>
  <div class="sidebar_section">
    <span class="header_title textBlack">Консультируем бесплатно</span>
    <div class="consultant_info">
      <div class="consult_photo"><img src="/bitrix/templates/eshop_bootstrap_green_copy/images/mihail_test.png"></div>
      <span class="consult_name consult_text">Михаил Веселовский</span>
      <span class="consult_job consult_text">менеджер по продаже</span>
      <span class="consult_number consult_text">+7 (495) 123-45-67</span>
    </div>
    <div class="wrap_content_sidebar">
      <div class="callback_form">
        <input type="text" name="cosult_form_name" placeholder="Имя">
        <input type="text" name="cosult_form_phone" placeholder="Телефон">
        <input type="button" name="cosult_form_submit" id="submit_Consultant_form" value="Оставить заявку">
      </div>
    </div>
  </div>
</div>