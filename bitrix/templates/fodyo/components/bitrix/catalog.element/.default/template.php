<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
  $templateLibrary[] = 'currency';
  $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
  'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
  'TEMPLATE_LIBRARY' => $templateLibrary,
  'CURRENCIES' => $currencyList,
  'ITEM' => array(
    'ID' => $arResult['ID'],
    'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
    'JS_OFFERS' => $arResult['JS_OFFERS']
  )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
  'ID' => $mainId,
  'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
  'STICKER_ID' => $mainId.'_sticker',
  'BIG__ID' => $mainId.'_big_',
  'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
  '_CONT_ID' => $mainId.'__cont',
  'OLD_PRICE_ID' => $mainId.'_old_price',
  'PRICE_ID' => $mainId.'_price',
  'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
  'PRICE_TOTAL' => $mainId.'_price_total',
  '_CONT_OF_ID' => $mainId.'__cont_',
  'QUANTITY_ID' => $mainId.'_quantity',
  'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
  'QUANTITY_UP_ID' => $mainId.'_quant_up',
  'QUANTITY_MEASURE' => $mainId.'_quant_measure',
  'QUANTITY_LIMIT' => $mainId.'_quant_limit',
  'BUY_LINK' => $mainId.'_buy_link',
  'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
  'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
  'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
  'COMPARE_LINK' => $mainId.'_compare_link',
  'TREE_ID' => $mainId.'_skudiv',
  'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
  'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
  'OFFER_GROUP' => $mainId.'_set_group_',
  'BASKET_PROP_DIV' => $mainId.'_basket_prop',
  'SUBSCRIBE_LINK' => $mainId.'_subscribe',
  'TABS_ID' => $mainId.'_tabs',
  'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
  'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
  'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
  : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
  : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
  : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
  $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
    ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
    : reset($arResult['OFFERS']);
  $showControls = false;

  foreach ($arResult['OFFERS'] as $offer)
  {
    if ($offer['MORE_PHOTO_COUNT'] > 1)
    {
      $showControls = true;
      break;
    }
  }
}
else
{
  $actualItem = $arResult;
  $showControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
  'left' => 'product-item-label-left',
  'center' => 'product-item-label-center',
  'right' => 'product-item-label-right',
  'bottom' => 'product-item-label-bottom',
  'middle' => 'product-item-label-middle',
  'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
  foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
  {
    $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
  }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
  foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
  {
    $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
  }
}


if(strstr($actualItem['MORE_PHOTO'][0]['SRC'], 'no_photo')){
  if($arResult['DETAIL_PICTURE']['SRC']){
    $actualItem['MORE_PHOTO'][0] = $arResult['DETAIL_PICTURE'];
  }
  else{
    $actualItem['MORE_PHOTO'][0] = $arResult['PREVIEW_PICTURE'];
  } 
}else{
  if($arResult['DETAIL_PICTURE']['SRC']){
    $actualItem['MORE_PHOTO'][] = $arResult['DETAIL_PICTURE'];
  }
  if($arResult['PREVIEW_PICTURE']['SRC']){
    $actualItem['MORE_PHOTO'][] = $arResult['PREVIEW_PICTURE'];
  } 
}
if(isset($_REQUEST['offer']) && is_numeric($_REQUEST['offer'])){

  $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*",'PREVIEW_PICTURE','DETAIL_PICTURE', 'DETAIL_TEXT');
  $arFilter = Array("ID"=>IntVal($_REQUEST['offer']));
  $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);

  while($ob = $res->GetNextElement()){ 
    $arFields = $ob->GetFields();  
      //echo "<pre>"; print_r($arFields);echo "</pre>";
    $arProps = $ob->GetProperties();
    //echo "<pre>"; print_r($arProps);echo "</pre>";
  }
  ?>
  <div class="bx-catalog-element bx-<?=$arParams['TEMPLATE_THEME']?>" id="<?=$itemIds['ID']?>"
    itemscope itemtype="http://schema.org/Product">
    <div class="container-fluid bx-wrapper">
      <?
      if ($arParams['DISPLAY_NAME'] === 'Y')
      {
        ?>
        <div class="row">
          <div class="col-xs-12">
            <h1 style="display: none;"><?=$arFields['NAME']?></h1>
            <span class="bx-title textBlue"><?=$arFields['NAME']?> в</span><span class="textOrange"> <?echo $arResult['NAME'];?></span>
          </div>
        </div>
        <?
      }
      ?>
      <div class="row">
        <div class="product-item-detail-info-container">
          <span class="textOrange">
            Цена: 
          </span>
          <div class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>">
            <?
            $getPrice = CPrice::GetBasePrice($arFields['ID']);
            //echo "<pre>"; print_r($getPrice); echo "</pre>";
            ?>
            <?=CurrencyFormat($getPrice['PRICE'], $getPrice['CURRENCY']);?>
          </div>
          <span class="textOrange buttons">Об объекте</span>
          <span class="textOrange buttons">Расположение</span>
          <span class="textOrange buttons">Ход строительства</span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="product-item-detail--container">
            <span class="product-item-detail--close" data-entity="close-popup"></span>
            <div class="product-item-detail--block
              <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail--block-square' : '')?>"
              data-entity="images--block">
              <div class="product-item-detail-images-container" >
                <?
                if($src = CFile::GetPath($arFields['DETAIL_PICTURE'])){
                  ?>
                  <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['DETAIL_PICTURE']['ID']?>">
                    <img src="<?=$src?>">
                  </div>
                  <?
                }elseif($src = CFile::GetPath($arFields['PREVIEW_PICTURE'])){
                  ?>
                  <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['PREVIEW_PICTURE']['ID']?>">
                    <img src="<?=$src?>">
                  </div>
                  <?
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <?
          if (!empty($arProps))
          {
            ?>
            <div class="poperties_detail">
              <?
              //echo "<pre>";print_r($arProps); echo "</pre>";
              foreach ($arProps as $property)
              {
                if($property['USER_TYPE'] != 'SKU'){
                  if($property['NAME']=='Продавец' && !empty($property['DISPLAY_VALUE'][0]) && !empty($property['DISPLAY_VALUE'][1])){
                    //echo '<pre>';print_r($property['DISPLAY_VALUE']);echo "</pre>";
                    ?>
                    <div class="product-item-detail-properties">
                      <span class="textBlack"><?=$property['NAME']?>:</span>
                      <?
                        print_r($property['DISPLAY_VALUE']);
                      ?>
                      <a class="textOrange" href="<?=$property['DISPLAY_VALUE'][1]?>"><?=$property['DISPLAY_VALUE'][0]?></a>
                    </div>
                    <?
                    continue;
                  }
                  if($property['NAME']=='Ипотека / рассрочка' && !empty($property['DISPLAY_VALUE'][0]) && !empty($property['DISPLAY_VALUE'][1])){
                    ?>
                    <div class="product-item-detail-properties">                  
                      <span class="textBlack"><?=$property['NAME']?>:</span>
                      <?
                      if($property['DISPLAY_VALUE'][0] == 'есть'){?><span class="textOrange"><?=$property['DISPLAY_VALUE'][0]?></span><?}
                      else{?><span class="textBlue"><?=$property['DISPLAY_VALUE'][0]?></span><?}
                        ?>
                        <span class="textBlack">/</span>
                        <?
                      if($property['DISPLAY_VALUE'][1] == 'есть'){?><span class="textOrange"><?=$property['DISPLAY_VALUE'][1]?></span><?}
                      else{?><span class="textBlue"><?=$property['DISPLAY_VALUE'][1]?></span><?}
                      ?>
                    </div>
                    <?
                    continue;
                  }
                  if (!empty($property['VALUE'])){
                    ?>
                    <div class="product-item-detail-properties">                  
                      <span class="textBlack"><?=$property['NAME']?>:</span>
                      <span class="textBlue"><?=(
                        is_array($property['VALUE'])
                          ? implode(' / ', $property['VALUE'])
                          : $property['VALUE']
                        )?>
                      </span>
                    </div>
                    <?
                  }
                }
              }
              unset($property);
              ?>
            </div>
            <?
          }
          ?>
        </div>
      </div>

      <div class="row ipoteka_and_description">
        <div class="ipoteka">
          <span class="block_descr_title textBlue">Ипотека</span>
          <div class="flex_images_wrapper">
          <?
            $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM",'PREVIEW_PICTURE');
            $arFilter = Array("IBLOCK_ID"=>'6');
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);

            while($ob = $res->GetNextElement())
            {
              $picFields = $ob->GetFields();
              ?>
                <div class="ipoteka_img">
                  <img src="<?=CFile::GetPath($picFields['PREVIEW_PICTURE'])?>">
                </div>
              <?
              //echo "<pre>"; print_r();echo "</pre>";
            }
          ?>
          </div>
        </div>
        <div class="description">
          <span class="block_descr_title textBlue">Описание объекта</span>
          <p>
            <?=$arFields['DETAIL_TEXT']?>
          </p>
        </div>
      </div>
    </div>
  </div><?
}else{
?>
<div class="bx-catalog-element bx-<?=$arParams['TEMPLATE_THEME']?>" id="<?=$itemIds['ID']?>"
  itemscope itemtype="http://schema.org/Product">
  <div class="container-fluid bx-wrapper">
    <?
    if ($arParams['DISPLAY_NAME'] === 'Y')
    {
      ?>
      <div class="row">
        <div class="col-xs-12">
          <h1 class="bx-title textBlue" style="margin: 30px 0"><?=$name?></h1>
        </div>
      </div>
      <?
    }
    ?>
    <div class="row">
      <div class="product-item-detail-info-container">
        <a href="#about"><span class="textOrange buttons">О проекте</span></a>
        <a href="#location"><span class="textOrange buttons">Расположение</span></a>
        <a href="#developer"><span class="textOrange buttons">Застройщик</span></a>
        <a href="#layouts"><span class="textOrange buttons">Планировки</span></a>
        <a href="#progress"><span class="textOrange buttons">Ход строительства</span></a>
        <?/*a href="#reviews"><span class="textOrange buttons">Отзывы</span></a>*/?>
      </div>
    </div>
    <div class="lot-img-list">
  

      <?///////////////////////////////////////////////////////////////////////////////////////////?>




      <div class="product-description__img-block col-8 noscroll-aside js-product-gallery" id="ajax-gallery">
    <div class="product-gallery">
        <div class="product-gallery__nav">
            <div class="product-gallery__nav_ovh">
                <div data-id="0" data-href="https://images-na.ssl-images-amazon.com/images/I/61ofT365VcL._SL1000_.jpg" data-product-thumbnail="" class="product-gallery__nav-item selected_active 0">
                  <? 
                    if($arResult['DETAIL_PICTURE']['SRC']){
                    ?>
                        <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="product-gallery__nav-img">
                      <?
                    }elseif($arResult['PREVIEW_PICTURE']['SRC']){
                      ?>
                        <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" class="product-gallery__nav-img">
                      <?
                    }
                  ?>
                </div>
                <?php foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]['VALUE'] as $NUMBER => $MPHOTO): ?>
                   <div data-id="<?=($NUMBER+1)?>" data-href="<?=CFile::GetPath($MPHOTO)?>" data-product-thumbnail="" class="product-gallery__nav-item <?=($NUMBER+1)?> ">
                        <img src="<?=CFile::GetPath($MPHOTO)?>" class="product-gallery__nav-img">
                  </div>
                <?php endforeach ?>
             </div>
            <div class="arrow_left-right hidden" style="display: none;">
                <div class="arrow_left" data-id="0">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/arrow_left.png" alt="">
                </div>
                <div class="arrow_right" data-id="0" data-last-id="7" is-add="false">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/arrow_right.png" alt="">
                </div>
            </div>
        </div>
        <div class="product-gallery__body">
            <div data-product-image="" class="product-gallery__img-wrap" id="ex1" style="position: relative; overflow: hidden;">
              <? 
                if($arResult['DETAIL_PICTURE']['SRC']){
                ?>
                    <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="product-gallery__main-img">
                  <?
                }elseif($arResult['PREVIEW_PICTURE']['SRC']){
                  ?>
                    <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" class="product-gallery__main-img">
                  <?
                }
              ?>              
            </div>
            <!--
                <div style="position:absolute;top:35px;left:0px;background-color:#13ce66;color:#ffffff;z-index:1;text-align:center;line-height:40px;width:120px;border-top-right-radius:40px;border-bottom-right-radius:40px;">Предзаказ</div>
            -->                        
            
            
        </div>
    </div>
<script>
    var height = 0;
    $(function () {
        initImageScroll();
    })

    //图片滚动
    function initImageScroll(){
        $(".arrow_left").bind('click',function(){
            var id = parseInt($(this).attr('data-id'));
            if(id > 0){
                $(".product-gallery__nav-item").removeClass('selected_active');
                id = id  - 1;
                $('.arrow_right').attr('data-id',id);
                $('.arrow_left').attr('data-id',id);
                $('.'+id).addClass('selected_active');
                setImage(id);

                id = id - 1;
                if($('.'+id).hasClass('hidden1')){
                    $('.'+id).removeClass('hidden1');
                    var count = id + 4;
                    var i = parseInt($('.arrow_right').attr('data-last-id'));
                    for(i; i > count; i--){
                        $('.'+i).addClass('hidden1');
                    }
                    height += 178;
                    $(".product-gallery__nav_ovh").animate({"left":height},300);
                }
            }
        })
        $(".arrow_right").bind('click',function(){
            var id = parseInt($(this).attr('data-id'));
            var last_id = parseInt($(this).attr('data-last-id'));
            if(last_id > (id + 1) ){
                $(".product-gallery__nav-item").removeClass('selected_active');
                id = id + 1;
                $('.arrow_right').attr('data-id',id);
                $('.arrow_left').attr('data-id',id);
                $('.'+id).addClass('selected_active');
                $('.'+id).removeClass('hidden1');
                setImage(id);

                id = id + 1;

                if($('.'+id).hasClass('hidden1')){
                    $('.'+id).removeClass('hidden1');
                    var count = id - 4;
                    for(var i = 0;i < count; i++){
                        $('.'+i).addClass('hidden1');
                    }
                    height -= 178;
                    $(".product-gallery__nav_ovh").animate({"left":height},300);
                }
            }
        })
        $(".product-gallery__nav-item").bind('click',function(){
            var id = parseInt($(this).attr('data-id'));
            setImage(id);
            
              $('.arrow_right').attr('data-id', id);
              $('.arrow_left').attr('data-id', id);
              var last_id = parseInt($('.arrow_right').attr('data-last-id'));
              if (last_id > (id + 1)) {
                $(".product-gallery__nav-item").removeClass('selected_active');
                $('.' + id).addClass('selected_active');
                $('.' + id).removeClass('hidden1');

                id = id + 1;
                if ($('.' + id).hasClass('hidden1')) {
                  $('.' + id).removeClass('hidden1');
                  var count = id - 4;
                  for (var i = 0; i < count; i++) {
                    $('.' + i).addClass('hidden1');
                  }
                  height -= 178;
                  $(".product-gallery__nav_ovh").animate({
                    "left": height
                  }, 300);
                }
              }

              var id = parseInt($(this).attr('data-id'));
              if (id > 0) {
                $(".product-gallery__nav-item").removeClass('selected_active');
                $('.' + id).addClass('selected_active');
                id = id - 1;
                if ($('.' + id).hasClass('hidden1')) {
                  $('.' + id).removeClass('hidden1');
                  var count = id + 4;
                  var i = parseInt($('.arrow_right').attr('data-last-id'));
                  for (i; i > count; i--) {
                    $('.' + i).addClass('hidden1');
                  }
                  height += 178;
                  $(".product-gallery__nav_ovh").animate({
                    "left": height
                  }, 300);
                }
              }

            

        })
        $('.product-gallery__nav').mouseover(function(){
            $(".arrow_left-right").show();
        })
        $('.product-gallery__nav').mouseout(function(){
            $(".arrow_left-right").hide();
        })
    }


    function setImage(id){
        var img = $("."+id+' .product-gallery__nav-img').attr('src');
        $('.product-gallery__main-img').attr('src',img);
        $('.zoomImg').attr('src',img);
    }
</script>   
</div>



      <?///////////////////////////////////////////////////////////////////////////////////////////?>

<?/* 

    //старый код вывода изображений
     <div>
        <?
        if($arResult['DETAIL_PICTURE']['SRC']){
        ?>
          <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['DETAIL_PICTURE']['ID']?>">
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class='phot_max'>
          </div>
          <?
        }elseif($arResult['PREVIEW_PICTURE']['SRC']){
          ?>
          <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['PREVIEW_PICTURE']['ID']?>">
            <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" class='phot_max'>
          </div>
          <?
        }
        ?>
      </div>
      <div class="lot-img-more-photo">

        <?php foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]['VALUE'] as $MPHOTO): ?>
          <div>
            <?//echo CFile::ShowImage($MPHOTO,0,150,"class='phot_min'");?>
            <img class="background_miniatures" src='<?=CFile::GetPath($MPHOTO)?>'>
          </div>  
        <?php endforeach ?>
      </div>
      <script type="text/javascript">
        //$(document).ready(function() {
          $(".phot_min").click(function(){
            tmp = $(".phot_max").attr('src');
            $(".phot_max").attr('src', $(this).attr('src'));
            $(this).attr('src', tmp);
          });
        //});
      </script>*/?>
    </div>
    <!--<div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="product-item-detail--container" id="<?=$itemIds['BIG__ID']?>">
          <span class="product-item-detail--close" data-entity="close-popup"></span>
          <div class="product-item-detail--block
            <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail--block-square' : '')?>"
            data-entity="images--block">
            <div class="product-item-detail-images-container" >
              <?
              if($arResult['DETAIL_PICTURE']['SRC']){
                ?>
                <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['DETAIL_PICTURE']['ID']?>">
                  <img src="<?=$arResult['DETAIL_PICTURE']?>">
                </div>
                <?
              }elseif($arResult['PREVIEW_PICTURE']['SRC']){
                ?>
                <div class="product-item-detail-image" data-entity="image" data-id="<?=$arResult['PREVIEW_PICTURE']['ID']?>">
                  <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>">
                </div>
                <?
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    <a name="about"></a>
    <div class="row">
      <div class="col-xs-12">
        <?
        if (!empty($arResult['DISPLAY_PROPERTIES']))
        {
          ?>
          <div class="poperties_detail">
            <?
            if (!empty($arResult['DISPLAY_PROPERTIES']))
            {
              foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
              {
                if($property['NAME']=='Продавец'){
                  //echo '<pre>';print_r($property['DISPLAY_VALUE']);echo "</pre>";
                  ?>
                  <div class="product-item-detail-properties">
                    <span class="textBlack"><?=$property['NAME']?>:</span>
                    <?
                    //print_r($property['DISPLAY_VALUE']);
                    ?>
                    <?=$property['DISPLAY_VALUE'][1]?> <?=$property['DISPLAY_VALUE'][0]?>
                  </div>
                  <?
                  continue;
                }
                if($property['NAME']=='Ипотека / рассрочка'){
                  ?>
                  <div class="product-item-detail-properties">                  
                    <span class="textBlack"><?=$property['NAME']?>:</span>
                    <?
                    if($property['DISPLAY_VALUE'][0] == 'есть'){?><span class="textOrange"><?=$property['DISPLAY_VALUE'][0]?></span><?}
                    else{?><span class="textBlue"><?=$property['DISPLAY_VALUE'][0]?></span><?}
                      ?>
                      <span class="textBlack">/</span>
                      <?
                    if($property['DISPLAY_VALUE'][1] == 'есть'){?><span class="textOrange"><?=$property['DISPLAY_VALUE'][1]?></span><?}
                    else{?><span class="textBlue"><?=$property['DISPLAY_VALUE'][1]?></span><?}
                    ?>
                  </div>
                  <?
                  continue;
                }
                ?>
                <div class="product-item-detail-properties">                  
                  <span class="textBlack"><?=$property['NAME']?>:</span>
                  <span class="textBlue"><?=(
                    is_array($property['DISPLAY_VALUE'])
                      ? implode(' / ', $property['DISPLAY_VALUE'])
                      : $property['DISPLAY_VALUE']
                    )?>
                  </span>
                </div>
                <?
              }
              unset($property);
            }
            ?>
          </div>
          <?
        }
        ?>
      </div>
    </div>
    <div class="row map_with_btns">
    </div>
    
    <a name="developer"></a>
    <span class="textBlue">Застройщик</span>

    <h2 class="textBlue" style="margin: 30px 0 15px;">Планировки (типовые)</h2>
    <a name="layouts"></a>
    <div class="fl-row planning">
      <? if ($arResult["PROPERTIES"]["ONE_PLANNING"]["VALUE"]): ?>
        <div>
          <div><?=$arResult["PROPERTIES"]["ONE_PLANNING"]["NAME"]?></div>
          <div>
            <?
            echo CFile::ShowImage($arResult["PROPERTIES"]["ONE_PLANNING"]["VALUE"],0,150,"");
            ?>
          </div>  
        </div>
      <?endif;?>
      <? if ($arResult["PROPERTIES"]["TWO_PLANNING"]["VALUE"]): ?>
        <div>
          <div><?=$arResult["PROPERTIES"]["TWO_PLANNING"]["NAME"]?></div>
          <div>
            <?
            echo CFile::ShowImage($arResult["PROPERTIES"]["TWO_PLANNING"]["VALUE"],0,150,"");
            ?>
          </div>  
        </div>
      <?endif;?>
      <? if ($arResult["PROPERTIES"]["THREE_PLANNING"]["VALUE"]): ?>
        <div>
          <div><?=$arResult["PROPERTIES"]["THREE_PLANNING"]["NAME"]?></div>
          <div>
            <?
            echo CFile::ShowImage($arResult["PROPERTIES"]["THREE_PLANNING"]["VALUE"],0,150,"");
            ?>
          </div>  
        </div>
      <?endif;?>
      <? if ($arResult["PROPERTIES"]["STANDART_PLANNING"]["VALUE"]): ?>
        <div>
          <div><?=$arResult["PROPERTIES"]["STANDART_PLANNING"]["NAME"]?></div>
          <div>
            <?
            echo CFile::ShowImage($arResult["PROPERTIES"]["STANDART_PLANNING"]["VALUE"],0,150,"");
            ?>
          </div>  
        </div>
      <?endif;?>
    </div>
    <pre><?//print_r($arResult["PROPERTIES"]);?></pre>
    <span class="textBlue">Этапы строительства</span>
    
    

    
    <div class="row map_with_btns">
      
    </div>
    <?
    if(!empty($arResult['OFFERS'])){

      ?>
      <table class="flex_table">  
        <tr class="flex-row">
          <td><span class="textBlue">Тип</span></td>
          <td><span class="textBlue">Этаж</span></td>
          <td><span class="textBlue">Площ., м2</span></td>
          <td><span class="textBlue">Цена, руб/м2</span></td>
          <td><span class="textBlue">Цена, руб</span></td>
          <td><span class="textBlue">Планировка</span></td>
        </tr>
        <?
        foreach ($arResult['OFFERS'] as $key => $value) {
          ?>
          <tr class="flex-row">
            <td><span class="textBlack"><?=$value['NAME'] ?></span></td>
            <td><span class="textBlack"><?=$value['PROPERTIES']['FLOOR']['VALUE'] ?></span></td>
            <td><span class="textBlack"><?=$value['PROPERTIES']['AREA_SPACE']['VALUE'] ?></span></td>
            <?

            //echo "<pre>"; print_r(array($value['NAME'], $value['ITEM_PRICES'])); echo "</pre>";

            foreach ($value['ITEM_PRICES'] as $key => $price) {
              if($pricePrint != '' && $pricePrint > $price['RATIO_PRICE']){
                $pricePrint = $price['RATIO_PRICE'];
              }
              else{
                $pricePrint = $price['RATIO_PRICE'];
              }
            }
            ?>
            <td><span class="textBlack"><?=number_format($pricePrint, 0, '', ' ')?></span></td>

            <td><span class="textBlack"><?=number_format($pricePrint*$value['PROPERTIES']['AREA_SPACE']['VALUE'], 0, '', ' ')?></span></td>
            <?
            
            //здесь что-то можно своровать
            $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM",'PREVIEW_PICTURE','DETAIL_PAGE_URL');
            $arFilter = Array("IBLOCK_ID"=>'5', 'ID' => $value['ID']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);

            while($ob = $res->GetNextElement())
            {
              $arFields = $ob->GetFields();
              ?>
                
              <?
              //echo "<pre>"; print_r($arFields);echo "</pre>";
              ?><td><a class="textOrange" href="<?=$arFields['DETAIL_PAGE_URL']?>">Смотреть</a></td><?
            }
            //конец квартир
            ?>
            
          </tr>
          <?
        }
        ?>
      </table><?
    }?>
    <?
    //echo "<pre>"; print_r($arResult['OFFERS']); echo "</pre>";
    ?>

    <div class="row ipoteka_and_description">
      <div class="ipoteka">
        <span class="block_descr_title textBlue">Ипотека</span>
        <div class="flex_images_wrapper">
        <?
          $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM",'PREVIEW_PICTURE');
          $arFilter = Array("IBLOCK_ID"=>'6');
          $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);

          while($ob = $res->GetNextElement())
          {
            $arFields = $ob->GetFields();
            ?>
              <div class="ipoteka_img">
                <img src="<?=CFile::GetPath($arFields['PREVIEW_PICTURE'])?>">
              </div>
            <?
            //echo "<pre>"; print_r();echo "</pre>";
          }
        ?>
        </div>
      </div>
      <div class="description">
        <span class="block_descr_title textBlue">Описание объекта</span>
        <p>
          <?=$arResult['DETAIL_TEXT']?>
        </p>
      </div>
    </div>

    <?/*<a name="reviews"></a>
    <span class="textBlue">Отзывы</span>*/?>
    
    
    <?/*<div class="row">
      <div class="col-sm-8 col-md-9">
        <div class="row" id="<?=$itemIds['TABS_ID']?>">
          <div class="col-xs-12">
            <div class="product-item-detail-tabs-container">
              <ul class="product-item-detail-tabs-list">
                <?
                if ($showDescription)
                {
                  ?>
                  <li class="product-item-detail-tab active" data-entity="tab" data-value="description">
                    <a href="javascript:void(0);" class="product-item-detail-tab-link">
                      <span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
                    </a>
                  </li>
                  <?
                }

                if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
                {
                  ?>
                  <li class="product-item-detail-tab" data-entity="tab" data-value="properties">
                    <a href="javascript:void(0);" class="product-item-detail-tab-link">
                      <span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
                    </a>
                  </li>
                  <?
                }

                if ($arParams['USE_COMMENTS'] === 'Y')
                {
                  ?>
                  <li class="product-item-detail-tab" data-entity="tab" data-value="comments">
                    <a href="javascript:void(0);" class="product-item-detail-tab-link">
                      <span><?=$arParams['MESS_COMMENTS_TAB']?></span>
                    </a>
                  </li>
                  <?
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="row" id="<?=$itemIds['TAB_CONTAINERS_ID']?>">
          <div class="col-xs-12">
            <?
            if ($showDescription)
            {
              ?>
              <div class="product-item-detail-tab-content active" data-entity="tab-container" data-value="description"
                itemprop="description">
                <?
                if (
                  $arResult['PREVIEW_TEXT'] != ''
                  && (
                    $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                    || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                  )
                )
                {
                  echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
                }

                if ($arResult['DETAIL_TEXT'] != '')
                {
                  echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
                }
                ?>
              </div>
              <?
            }

            if ($arParams['USE_COMMENTS'] === 'Y')
            {
              ?>
              <div class="product-item-detail-tab-content" data-entity="tab-container" data-value="comments" style="display: none;">
                <?
                $componentCommentsParams = array(
                  'ELEMENT_ID' => $arResult['ID'],
                  'ELEMENT_CODE' => '',
                  'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                  'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
                  'URL_TO_COMMENT' => '',
                  'WIDTH' => '',
                  'COMMENTS_COUNT' => '5',
                  'BLOG_USE' => $arParams['BLOG_USE'],
                  'FB_USE' => $arParams['FB_USE'],
                  'FB_APP_ID' => $arParams['FB_APP_ID'],
                  'VK_USE' => $arParams['VK_USE'],
                  'VK_API_ID' => $arParams['VK_API_ID'],
                  'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                  'CACHE_TIME' => $arParams['CACHE_TIME'],
                  'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                  'BLOG_TITLE' => '',
                  'BLOG_URL' => $arParams['BLOG_URL'],
                  'PATH_TO_SMILE' => '',
                  'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
                  'AJAX_POST' => 'Y',
                  'SHOW_SPAM' => 'Y',
                  'SHOW_RATING' => 'N',
                  'FB_TITLE' => '',
                  'FB_USER_ADMIN_ID' => '',
                  'FB_COLORSCHEME' => 'light',
                  'FB_ORDER_BY' => 'reverse_time',
                  'VK_TITLE' => '',
                  'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
                );
                if(isset($arParams["USER_CONSENT"]))
                  $componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
                if(isset($arParams["USER_CONSENT_ID"]))
                  $componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
                if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
                  $componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
                if(isset($arParams["USER_CONSENT_IS_LOADED"]))
                  $componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
                $APPLICATION->IncludeComponent(
                  'bitrix:catalog.comments',
                  '',
                  $componentCommentsParams,
                  $component,
                  array('HIDE_ICONS' => 'Y')
                );
                ?>
              </div>
              <?
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-4 col-md-3">
        <div>
          <?
          if ($arParams['BRAND_USE'] === 'Y')
          {
            $APPLICATION->IncludeComponent(
              'bitrix:catalog.brandblock',
              '.default',
              array(
                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'ELEMENT_ID' => $arResult['ID'],
                'ELEMENT_CODE' => '',
                'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                'CACHE_TIME' => $arParams['CACHE_TIME'],
                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                'WIDTH' => '',
                'HEIGHT' => ''
              ),
              $component,
              array('HIDE_ICONS' => 'Y')
            );
          }
          ?>
        </div>
      </div>
    </div>*/?>
    <div class="row">
      <div class="col-xs-12">
        <?
        if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
          $APPLICATION->IncludeComponent(
            'bitrix:sale.prediction.product.detail',
            '.default',
            array(
              'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
              'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
              'POTENTIAL_PRODUCT_TO_BUY' => array(
                'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                'SECTION' => array(
                  'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                  'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                  'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                  'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                ),
              )
            ),
            $component,
            array('HIDE_ICONS' => 'Y')
          );
        }
        ?>
      </div>
    </div>
  </div>
  <meta itemprop="name" content="<?=$name?>" />
  <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
  <?
  if ($haveOffers)
  {
    foreach ($arResult['JS_OFFERS'] as $offer)
    {
      $currentOffersList = array();

      if (!empty($offer['TREE']) && is_array($offer['TREE']))
      {
        foreach ($offer['TREE'] as $propName => $skuId)
        {
          $propId = (int)substr($propName, 5);

          foreach ($skuProps as $prop)
          {
            if ($prop['ID'] == $propId)
            {
              foreach ($prop['VALUES'] as $propId => $propValue)
              {
                if ($propId == $skuId)
                {
                  $currentOffersList[] = $propValue['NAME'];
                  break;
                }
              }
            }
          }
        }
      }

      $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
      ?>
      <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
        <meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
        <meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
        <link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
      </span>
      <?
    }

    unset($offerPrice, $currentOffersList);
  }
  else
  {
    ?>
    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
      <meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
      <link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
    </span>
    <?
  }
  ?>
</div>
<?
  if(isset($_REQUEST['offer']) && is_numeric($_REQUEST['offer'])){
    ?><span class="textBlue">Сравнимые объекты</span><?
    $APPLICATION->IncludeComponent(
      "bitrix:catalog.section", 
      "reccomend_detail", 
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
        "PAGE_ELEMENT_COUNT" => "4",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(
        ),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
        "PRODUCT_DISPLAY_MODE" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
        "PRODUCT_SUBSCRIPTION" => "Y",
        "PROPERTY_CODE_MOBILE" => array(
        ),
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "RCM_TYPE" => "personal",
        "SECTION_CODE" => "",
        "SECTION_ID" => $arResult['SECTION_ID'],
        "SECTION_ID_VARIABLE" => "",
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
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_FROM_SECTION" => "N",
        "SHOW_MAX_QUANTITY" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "SHOW_SLIDER" => "Y",
        "SLIDER_INTERVAL" => "3000",
        "SLIDER_PROGRESS" => "N",
        "TEMPLATE_THEME" => "blue",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "COMPONENT_TEMPLATE" => "reccomend_detail"
      ),
      false
    );
  }else{
    ?><span class="textBlue">Сравнимые объекты</span><?
    $APPLICATION->IncludeComponent(
      "bitrix:catalog.section", 
      "reccomend_detail", 
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
        "PAGE_ELEMENT_COUNT" => "4",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(
        ),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
        "PRODUCT_DISPLAY_MODE" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
        "PRODUCT_SUBSCRIPTION" => "Y",
        "PROPERTY_CODE_MOBILE" => array(
        ),
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "RCM_TYPE" => "personal",
        "SECTION_CODE" => "",
        "SECTION_ID" => $arResult['SECTION_ID'],
        "SECTION_ID_VARIABLE" => "",
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
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_FROM_SECTION" => "N",
        "SHOW_MAX_QUANTITY" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "SHOW_SLIDER" => "Y",
        "SLIDER_INTERVAL" => "3000",
        "SLIDER_PROGRESS" => "N",
        "TEMPLATE_THEME" => "blue",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "COMPONENT_TEMPLATE" => "reccomend_detail"
      ),
      false
    );
  }
}
if ($haveOffers)
{
  $offerIds = array();
  $offerCodes = array();

  $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

  foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
  {
    $offerIds[] = (int)$jsOffer['ID'];
    $offerCodes[] = $jsOffer['CODE'];

    $fullOffer = $arResult['OFFERS'][$ind];
    $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

    $strAllProps = '';
    $strMainProps = '';
    $strPriceRangesRatio = '';
    $strPriceRanges = '';

    if ($arResult['SHOW_OFFERS_PROPS'])
    {
      if (!empty($jsOffer['DISPLAY_PROPERTIES']))
      {
        foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
        {
          $current = '<dt>'.$property['NAME'].'</dt><dd>'.(
            is_array($property['VALUE'])
              ? implode(' / ', $property['VALUE'])
              : $property['VALUE']
            ).'</dd>';
          $strAllProps .= $current;

          if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
          {
            $strMainProps .= $current;
          }
        }

        unset($current);
      }
    }

    if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
    {
      $strPriceRangesRatio = '('.Loc::getMessage(
          'CT_BCE_CATALOG_RATIO_PRICE',
          array('#RATIO#' => ($useRatio
              ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
              : '1'
            ).' '.$measureName)
        ).')';

      foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
      {
        if ($range['HASH'] !== 'ZERO-INF')
        {
          $itemPrice = false;

          foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
          {
            if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
            {
              break;
            }
          }

          if ($itemPrice)
          {
            $strPriceRanges .= '<dt>'.Loc::getMessage(
                'CT_BCE_CATALOG_RANGE_FROM',
                array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
              ).' ';

            if (is_infinite($range['SORT_TO']))
            {
              $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
            }
            else
            {
              $strPriceRanges .= Loc::getMessage(
                'CT_BCE_CATALOG_RANGE_TO',
                array('#TO#' => $range['SORT_TO'].' '.$measureName)
              );
            }

            $strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
          }
        }
      }

      unset($range, $itemPrice);
    }

    $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
    $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
    $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
    $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
  }

  $templateData['OFFER_IDS'] = $offerIds;
  $templateData['OFFER_CODES'] = $offerCodes;
  unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

  $jsParams = array(
    'CONFIG' => array(
      'USE_CATALOG' => $arResult['CATALOG'],
      'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
      'SHOW_PRICE' => true,
      'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
      'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
      'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
      'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
      'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
      'OFFER_GROUP' => $arResult['OFFER_GROUP'],
      'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
      'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
      'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
      'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
      'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
      'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
      'USE_STICKERS' => true,
      'USE_SUBSCRIBE' => $showSubscribe,
      'SHOW_' => $arParams['SHOW_'],
      '_INTERVAL' => $arParams['_INTERVAL'],
      'ALT' => $alt,
      'TITLE' => $title,
      'MAGNIFIER_ZOOM_PERCENT' => 200,
      'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
      'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
      'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
        ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
        : null
    ),
    'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
    'VISUAL' => $itemIds,
    'DEFAULT_PICTURE' => array(
      'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
      'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
    ),
    'PRODUCT' => array(
      'ID' => $arResult['ID'],
      'ACTIVE' => $arResult['ACTIVE'],
      'NAME' => $arResult['~NAME'],
      'CATEGORY' => $arResult['CATEGORY_PATH']
    ),
    'BASKET' => array(
      'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
      'BASKET_URL' => $arParams['BASKET_URL'],
      'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
      'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
      'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
    ),
    'OFFERS' => $arResult['JS_OFFERS'],
    'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
    'TREE_PROPS' => $skuProps
  );
}
else
{
  $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
  if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
  {
    ?>
    <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
      <?
      if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
      {
        foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
        {
          ?>
          <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
          <?
          unset($arResult['PRODUCT_PROPERTIES'][$propId]);
        }
      }

      $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
      if (!$emptyProductProperties)
      {
        ?>
        <table>
          <?
          foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
          {
            ?>
            <tr>
              <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
              <td>
                <?
                if (
                  $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                  && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                )
                {
                  foreach ($propInfo['VALUES'] as $valueId => $value)
                  {
                    ?>
                    <label>
                      <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                        value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
                      <?=$value?>
                    </label>
                    <br>
                    <?
                  }
                }
                else
                {
                  ?>
                  <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
                    <?
                    foreach ($propInfo['VALUES'] as $valueId => $value)
                    {
                      ?>
                      <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
                        <?=$value?>
                      </option>
                      <?
                    }
                    ?>
                  </select>
                  <?
                }
                ?>
              </td>
            </tr>
            <?
          }
          ?>
        </table>
        <?
      }
      ?>
    </div>
    <?
  }

  $jsParams = array(
    'CONFIG' => array(
      'USE_CATALOG' => $arResult['CATALOG'],
      'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
      'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
      'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
      'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
      'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
      'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
      'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
      'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
      'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
      'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
      'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
      'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
      'USE_STICKERS' => true,
      'USE_SUBSCRIBE' => $showSubscribe,
      'SHOW_' => $arParams['SHOW_'],
      '_INTERVAL' => $arParams['_INTERVAL'],
      'ALT' => $alt,
      'TITLE' => $title,
      'MAGNIFIER_ZOOM_PERCENT' => 200,
      'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
      'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
      'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
        ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
        : null
    ),
    'VISUAL' => $itemIds,
    'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
    'PRODUCT' => array(
      'ID' => $arResult['ID'],
      'ACTIVE' => $arResult['ACTIVE'],
      'PICT' => reset($arResult['MORE_PHOTO']),
      'NAME' => $arResult['~NAME'],
      'SUBSCRIPTION' => true,
      'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
      'ITEM_PRICES' => $arResult['ITEM_PRICES'],
      'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
      'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
      'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
      'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
      'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
      '_COUNT' => $arResult['MORE_PHOTO_COUNT'],
      '' => $arResult['MORE_PHOTO'],
      'CAN_BUY' => $arResult['CAN_BUY'],
      'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
      'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
      'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
      'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
      'CATEGORY' => $arResult['CATEGORY_PATH']
    ),
    'BASKET' => array(
      'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
      'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
      'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
      'EMPTY_PROPS' => $emptyProductProperties,
      'BASKET_URL' => $arParams['BASKET_URL'],
      'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
      'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
    )
  );
  unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
  $jsParams['COMPARE'] = array(
    'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH']
  );
}
?>
<script>
  BX.message({
    ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
    TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
    TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
    BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
    BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
    BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
    BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
    BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
    TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
    COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
    COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
    COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
    BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
    PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
    PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
    RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
    RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
    SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
  });

  var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);