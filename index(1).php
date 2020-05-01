<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Недвижимость \"Грильяж\"");
?><div class="main-content">
  <div class="breadcrumps col-orange bx-breadcrumb-item">
   <a href="/"><span>Home</span></a> &gt; <a href="/europe/russia"><span>Russia</span></a> &gt; Moscow
  </div>
  <div class="city-filter fl-col">
    <img src="https://img05.rl0.ru/afisha/c1200x600i/daily.afisha.ru/uploads/images/5/df/5dfebab2bbfb40e4b60a5d0dcd529db3.png">
    <h1>Real estate in Moscow</h1>
    <form class="fl-row">
      <select size="1" name="language">
        <option>City/region</option>
        <option></option>
      </select>
      <select size="1" name="currency">
        <option>Type</option>
        <option></option>
      </select>
      <select size="1" name="currency">
        <option>Price</option>
        <option></option>
      </select>
 <button class="btn-search">
      <div>
      </div>
 </button>
    </form>
  </div>
  <div class="nav-services fl-row">
 <a href="">
    <div>
 <img src="/images/icon-home.jpg">
      <div>
         Flats, apartments
      </div>
    </div>
 </a> <a href="">
    <div>
 <img src="/images/icon-home.jpg">
      <div>
         Villas, Townhouses
      </div>
    </div>
 </a> <a href="">
    <div>
 <img src="/images/icon-home.jpg">
      <div>
         Investment property
      </div>
    </div>
 </a> <a href="">
    <div>
 <img src="/images/icon-home.jpg">
      <div>
         Articles about Moscow
      </div>
    </div>
 </a>
  </div>
  <?

  if(CModule::IncludeModule("iblock"))
    { 
      $getSections = CIBlockSection::GetList(
        Array("SORT"=>"ASC"),
        Array('IBLOCK_ID'=>4, 'SECTION_ID'=>17),
        false,
        Array('ID', 'IBLOCK_ID', 'NAME', 'PICTURE', 'SECTION_PAGE_URL'),
        false
    );
  
    //echo "<pre>";print_r($getSections);echo "</pre>";


    //сюда не помешает навесить фильтр, чтобы выводились только нужные секции
      while($fetchSections = $getSections -> GetNext())
    {
      $massNav[] = $fetchSections;
    }
   }

  

  ?>

  <div class="city-street city-street-item fl-row">
    <div class="fl-col city-street-item">
      <div class="fl-row city-street-item" style="max-width:calc(625px - 0.5vw)">
        <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[0]["PICTURE"]);?>);">
 <a href="<?=$massNav[0]['SECTION_PAGE_URL']?>">
          <div>
            <h4><?=$massNav[0]["NAME"]?></h4>
          </div>
 </a>
        </div>
        <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[1]["PICTURE"]);?>);">
 <a href="<?=$massNav[1]['SECTION_PAGE_URL']?>">
          <div>
            <h4><?=$massNav[1]["NAME"]?></h4>
          </div>
 </a>
        </div>
      </div>
      <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[2]["PICTURE"]);?>); width: 44.5vw; max-width: calc(625px - .5vw);height: 29vw;max-height:calc(480px + 1vw)">
 <a href="<?=$massNav[2]['SECTION_PAGE_URL']?>">
        <div>
          <h4><?=$massNav[2]["NAME"]?></h4>
        </div>
 </a>
      </div>
    </div>
    <div class="fl-col city-street-item">
      <div class="fl-row city-street-item">
        <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[3]["PICTURE"]);?>); height: 29vw; max-height:calc(480px + 1vw)">
 <a href="<?=$massNav[3]['SECTION_PAGE_URL']?>">
          <div>
            <h4><?=$massNav[3]["NAME"]?></h4>
          </div>
 </a>
        </div>
        <div class="fl-col">
          <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[4]["PICTURE"]);?>);">
 <a href="<?=$massNav[4]['SECTION_PAGE_URL']?>">
            <div>
              <h4><?=$massNav[4]["NAME"]?></h4>
            </div>
 </a>
          </div>
          <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[5]["PICTURE"]);?>);">
 <a href="<?=$massNav[5]['SECTION_PAGE_URL']?>">
            <div>
              <h4><?=$massNav[5]["NAME"]?></h4>
            </div>
 </a>
          </div>
        </div>
      </div>
      <div class="fl-row city-street-item">
        <div class="a-item" style="background-image: url(<?=CFile::GetPath($massNav[6]["PICTURE"]);?>);">
 <a href="<?=$massNav[6]['SECTION_PAGE_URL']?>">
          <div>
            <h4><?=$massNav[6]["NAME"]?></h4>
          </div>
 </a>
        </div>
        <div class="a-item">
 <a href="/catalog/moscow">
          <div>
            <h4>Вся Москва</h4>
          </div>
 </a>
        </div>
      </div>
    </div>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2><?$APPLICATION->IncludeComponent(
          "bitrix:main.include",
          "",
          Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => "/include/index_1_block_items.php"
          )
        );?>
      </h2>
    </div>
    <?
    unset($massNav);

    $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/include/index_1_block_section_id.php", true);
    //print_r($file);

    $BEST_NEW_BUILDINGS = array("PROPERTY_BEST_NEW_BUILDINGS_VALUE"=>'Да');

    //print_r($BEST_NEW_BUILDINGS);

    $APPLICATION->IncludeComponent(
    "bitrix:catalog.section", 
    "build-list1-main1_show_copy", 
    array(
        "IBLOCK_TYPE_ID" => "catalog",
        "IBLOCK_ID" => "4",
        "BASKET_URL" => "/personal/cart/",
        "COMPONENT_TEMPLATE" => "build-list1-main1_show_copy",
        "IBLOCK_TYPE" => "catalog",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "Лучшие новостройки",
            2 => "",
        ),
        "ELEMENT_SORT_FIELD" => "timestamp_x",
        "ELEMENT_SORT_ORDER" => "desc",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "BEST_NEW_BUILDINGS",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "HIDE_NOT_AVAILABLE" => "N",
        "PAGE_ELEMENT_COUNT" => "4",
        "LINE_ELEMENT_COUNT" => "3",
        "PROPERTY_CODE" => array(
            0 => "NEWPRODUCT",
            1 => "",
        ),
        "OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_PROPERTY_CODE" => array(
            0 => "COLOR_REF",
            1 => "SIZES_SHOES",
            2 => "SIZES_CLOTHES",
            3 => "",
        ),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "desc",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER2" => "desc",
        "TEMPLATE_THEME" => "site",
        "PRODUCT_DISPLAY_MODE" => "Y",
        "ADD_PICT_PROP" => "-",
        "LABEL_PROP" => array(
            0 => "TYPE_OF",
            1 => "BEST_NEW_BUILDINGS",
        ),
        "OFFER_ADD_PICT_PROP" => "-",
        "OFFER_TREE_PROPS" => array(
            0 => "COLOR_REF",
            1 => "SIZES_SHOES",
            2 => "SIZES_CLOTHES",
        ),
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SEF_MODE" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "N",
        "SET_TITLE" => "Y",
        "SET_BROWSER_TITLE" => "Y",
        "BROWSER_TITLE" => "-",
        "SET_META_KEYWORDS" => "Y",
        "META_KEYWORDS" => "-",
        "SET_META_DESCRIPTION" => "Y",
        "META_DESCRIPTION" => "-",
        "SET_LAST_MODIFIED" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_FILTER" => "N",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "CONVERT_CURRENCY" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRODUCT_PROPERTIES" => "",
        "OFFERS_CART_PROPERTIES" => array(
            0 => "COLOR_REF",
            1 => "SIZES_SHOES",
            2 => "SIZES_CLOTHES",
        ),
        "ADD_TO_BASKET_ACTION" => "ADD",
        "PAGER_TEMPLATE" => "round",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
        "COMPATIBLE_MODE" => "N",
        "CUSTOM_FILTER" => "",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "PROPERTY_CODE_MOBILE" => array(
        ),
        "BACKGROUND_IMAGE" => "",
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
        "ENLARGE_PRODUCT" => "STRICT",
        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
        "SHOW_SLIDER" => "Y",
        "LABEL_PROP_MOBILE" => array(
        ),
        "LABEL_PROP_POSITION" => "top-left",
        "SHOW_MAX_QUANTITY" => "N",
        "RCM_TYPE" => "personal",
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "SHOW_FROM_SECTION" => "N",
        "DISPLAY_COMPARE" => "N",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "LAZY_LOAD" => "N",
        "LOAD_ON_SCROLL" => "N",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "SLIDER_INTERVAL" => "3000",
        "SLIDER_PROGRESS" => "N",
        "SEF_RULE" => "#SECTION_CODE_PATH#/",
        "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"]
    ),
    false
);
    ?>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2><?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
          "AREA_FILE_SHOW" => "file",
          "AREA_FILE_SUFFIX" => "inc",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/include/index_2_block_items.php"
        )
      );?></h2>
    </div>
     <?
$file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/include/index_1_block_section_id.php", true);
    //print_r($file);

    $BEST_NEW_BUILDINGS = array("PROPERTY_BEST_NEW_BUILDINGS_VALUE"=>'Да');

    //print_r($BEST_NEW_BUILDINGS);

    $APPLICATION->IncludeComponent(
  "bitrix:catalog.section", 
  "build-list1-main1_show_copy", 
  array(
    "IBLOCK_TYPE_ID" => "catalog",
    "IBLOCK_ID" => "4",
    "BASKET_URL" => "/personal/cart/",
    "COMPONENT_TEMPLATE" => "build-list1-main1_show_copy",
    "IBLOCK_TYPE" => "catalog",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "Лучшие новостройки",
      2 => "",
    ),
    "ELEMENT_SORT_FIELD" => "timestamp_x",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",
    "FILTER_NAME" => "BEST_NEW_BUILDINGS",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "HIDE_NOT_AVAILABLE" => "N",
    "PAGE_ELEMENT_COUNT" => "4",
    "LINE_ELEMENT_COUNT" => "3",
    "PROPERTY_CODE" => array(
      0 => "NEWPRODUCT",
      1 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
      3 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "desc",
    "OFFERS_SORT_FIELD2" => "id",
    "OFFERS_SORT_ORDER2" => "desc",
    "TEMPLATE_THEME" => "site",
    "PRODUCT_DISPLAY_MODE" => "Y",
    "ADD_PICT_PROP" => "-",
    "LABEL_PROP" => array(
    ),
    "OFFER_ADD_PICT_PROP" => "-",
    "OFFER_TREE_PROPS" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "SHOW_CLOSE_POPUP" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_SUBSCRIBE" => "Подписаться",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "SEF_MODE" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "N",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "-",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "-",
    "SET_LAST_MODIFIED" => "N",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "ADD_SECTIONS_CHAIN" => "N",
    "CACHE_FILTER" => "N",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "CONVERT_CURRENCY" => "N",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => "",
    "OFFERS_CART_PROPERTIES" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "ADD_TO_BASKET_ACTION" => "ADD",
    "PAGER_TEMPLATE" => "round",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "COMPATIBLE_MODE" => "N",
    "CUSTOM_FILTER" => "",
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
    "PROPERTY_CODE_MOBILE" => array(
    ),
    "BACKGROUND_IMAGE" => "",
    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
    "ENLARGE_PRODUCT" => "STRICT",
    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "SHOW_SLIDER" => "Y",
    "LABEL_PROP_MOBILE" => "",
    "LABEL_PROP_POSITION" => "top-left",
    "SHOW_MAX_QUANTITY" => "N",
    "RCM_TYPE" => "personal",
    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
    "SHOW_FROM_SECTION" => "N",
    "DISPLAY_COMPARE" => "N",
    "USE_ENHANCED_ECOMMERCE" => "N",
    "LAZY_LOAD" => "N",
    "LOAD_ON_SCROLL" => "N",
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
    "SLIDER_INTERVAL" => "3000",
    "SLIDER_PROGRESS" => "N",
    "SEF_RULE" => "#SECTION_CODE#/",
    "SECTION_CODE_PATH" => ""
  ),
  false
);
    ?>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2><?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
          "AREA_FILE_SHOW" => "file",
          "AREA_FILE_SUFFIX" => "inc",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/include/index_2_block_items.php"
        )
      );?></h2>
    </div>
     <?
     $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/include/index_2_block_section_id.php", true);
    //print_r($file);

    $arrFilter =  array("PROPERTY_TYPE_OF_VALUE"=>'Новостройка');

    //print_r($BEST_NEW_BUILDINGS);
    //подправить название переменной по свойству
    //$arrFilter = array("!PROPERTY_BEST_NEW_BUILDINGS"=>false);
    $APPLICATION->IncludeComponent(
  "bitrix:catalog.section", 
  "build-list1-main1_show_copy", 
  array(
    "IBLOCK_TYPE_ID" => "catalog",
    "IBLOCK_ID" => "4",
    "BASKET_URL" => "/personal/cart/",
    "COMPONENT_TEMPLATE" => "build-list1-main1_show_copy",
    "IBLOCK_TYPE" => "catalog",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => "",
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "Лучшие новостройки",
      2 => "",
    ),
    "ELEMENT_SORT_FIELD" => "timestamp_x",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",
    "FILTER_NAME" => "arrFilter",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "HIDE_NOT_AVAILABLE" => "N",
    "PAGE_ELEMENT_COUNT" => "4",
    "LINE_ELEMENT_COUNT" => "3",
    "PROPERTY_CODE" => array(
      0 => "NEWPRODUCT",
      1 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
      3 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "desc",
    "OFFERS_SORT_FIELD2" => "id",
    "OFFERS_SORT_ORDER2" => "desc",
    "TEMPLATE_THEME" => "site",
    "PRODUCT_DISPLAY_MODE" => "Y",
    "ADD_PICT_PROP" => "-",
    "LABEL_PROP" => array(
    ),
    "OFFER_ADD_PICT_PROP" => "-",
    "OFFER_TREE_PROPS" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "SHOW_CLOSE_POPUP" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_SUBSCRIBE" => "Подписаться",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "SEF_MODE" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "Y",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "-",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "-",
    "SET_LAST_MODIFIED" => "N",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "ADD_SECTIONS_CHAIN" => "N",
    "CACHE_FILTER" => "N",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "CONVERT_CURRENCY" => "N",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => "",
    "OFFERS_CART_PROPERTIES" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "ADD_TO_BASKET_ACTION" => "ADD",
    "PAGER_TEMPLATE" => "round",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "COMPATIBLE_MODE" => "N",
    "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:4:50\",\"DATA\":{\"logic\":\"Equal\",\"value\":19}}]}",
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
    "PROPERTY_CODE_MOBILE" => array(
    ),
    "BACKGROUND_IMAGE" => "-",
    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
    "ENLARGE_PRODUCT" => "STRICT",
    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "SHOW_SLIDER" => "Y",
    "LABEL_PROP_MOBILE" => "",
    "LABEL_PROP_POSITION" => "top-left",
    "SHOW_MAX_QUANTITY" => "N",
    "RCM_TYPE" => "personal",
    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
    "SHOW_FROM_SECTION" => "N",
    "DISPLAY_COMPARE" => "N",
    "USE_ENHANCED_ECOMMERCE" => "N",
    "LAZY_LOAD" => "N",
    "LOAD_ON_SCROLL" => "N",
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
    "SLIDER_INTERVAL" => "3000",
    "SLIDER_PROGRESS" => "N",
    "SEF_RULE" => "",
    "SECTION_CODE_PATH" => ""
  ),
  false
);?>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2><?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
          "AREA_FILE_SHOW" => "file",
          "AREA_FILE_SUFFIX" => "inc",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/include/index_3_block_items.php"
        )
      );?></h2>
    </div>
     <?
      $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/include/index_3_block_section_id.php", true);
      //print_r($file);

      //$arrFilter = array("SECTION_ID"=>$file);
      $BEST_NEW_BUILDINGS =  array("PROPERTY_TYPE_OF_VALUE"=>'Инвестиционная');
      $APPLICATION->IncludeComponent(
  "bitrix:catalog.section", 
  "build-list1-main1_show_copy", 
  array(
    "IBLOCK_TYPE_ID" => "catalog",
    "IBLOCK_ID" => "4",
    "BASKET_URL" => "/personal/cart/",
    "COMPONENT_TEMPLATE" => "build-list1-main1_show_copy",
    "IBLOCK_TYPE" => "catalog",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "Лучшие новостройки",
      2 => "",
    ),
    "ELEMENT_SORT_FIELD" => "shows",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",
    "FILTER_NAME" => "BEST_NEW_BUILDINGS",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "HIDE_NOT_AVAILABLE" => "N",
    "PAGE_ELEMENT_COUNT" => "4",
    "LINE_ELEMENT_COUNT" => "3",
    "PROPERTY_CODE" => array(
      0 => "NEWPRODUCT",
      1 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
      3 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "desc",
    "OFFERS_SORT_FIELD2" => "id",
    "OFFERS_SORT_ORDER2" => "desc",
    "TEMPLATE_THEME" => "site",
    "PRODUCT_DISPLAY_MODE" => "Y",
    "ADD_PICT_PROP" => "-",
    "LABEL_PROP" => array(
    ),
    "OFFER_ADD_PICT_PROP" => "-",
    "OFFER_TREE_PROPS" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "SHOW_CLOSE_POPUP" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_SUBSCRIBE" => "Подписаться",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "SEF_MODE" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "N",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "-",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "-",
    "SET_LAST_MODIFIED" => "N",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "ADD_SECTIONS_CHAIN" => "N",
    "CACHE_FILTER" => "N",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "CONVERT_CURRENCY" => "N",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => "",
    "OFFERS_CART_PROPERTIES" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "ADD_TO_BASKET_ACTION" => "ADD",
    "PAGER_TEMPLATE" => "round",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "COMPATIBLE_MODE" => "N",
    "CUSTOM_FILTER" => "",
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
    "PROPERTY_CODE_MOBILE" => array(
    ),
    "BACKGROUND_IMAGE" => "-",
    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
    "ENLARGE_PRODUCT" => "STRICT",
    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "SHOW_SLIDER" => "Y",
    "LABEL_PROP_MOBILE" => "",
    "LABEL_PROP_POSITION" => "top-left",
    "SHOW_MAX_QUANTITY" => "N",
    "RCM_TYPE" => "personal",
    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
    "SHOW_FROM_SECTION" => "N",
    "DISPLAY_COMPARE" => "N",
    "USE_ENHANCED_ECOMMERCE" => "N",
    "LAZY_LOAD" => "N",
    "LOAD_ON_SCROLL" => "N",
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
    "SLIDER_INTERVAL" => "3000",
    "SLIDER_PROGRESS" => "N",
    "SEF_RULE" => "#SECTION_CODE#/",
    "SECTION_CODE_PATH" => ""
  ),
  false
);
    ?>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2><?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
          "AREA_FILE_SHOW" => "file",
          "AREA_FILE_SUFFIX" => "inc",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/include/index_4_block_items.php"
        )
      );?></h2>
    </div>
     <?
      //$file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/include/index_4_block_section_id.php", true);

      $APPLICATION->IncludeComponent(
  "bitrix:catalog.section", 
  "build-list1-main1_show_copy", 
  array(
    "IBLOCK_TYPE_ID" => "catalog",
    "IBLOCK_ID" => "4",
    "BASKET_URL" => "/personal/cart/",
    "COMPONENT_TEMPLATE" => "build-list1-main1_show_copy",
    "IBLOCK_TYPE" => "catalog",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "Лучшие новостройки",
      2 => "",
    ),
    "ELEMENT_SORT_FIELD" => "sort",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",
    "FILTER_NAME" => "BEST_NEW_BUILDINGS_4",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "HIDE_NOT_AVAILABLE" => "N",
    "PAGE_ELEMENT_COUNT" => "4",
    "LINE_ELEMENT_COUNT" => "3",
    "PROPERTY_CODE" => array(
      0 => "NEWPRODUCT",
      1 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
      3 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "desc",
    "OFFERS_SORT_FIELD2" => "id",
    "OFFERS_SORT_ORDER2" => "desc",
    "TEMPLATE_THEME" => "site",
    "PRODUCT_DISPLAY_MODE" => "Y",
    "ADD_PICT_PROP" => "-",
    "LABEL_PROP" => array(
    ),
    "OFFER_ADD_PICT_PROP" => "-",
    "OFFER_TREE_PROPS" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "SHOW_CLOSE_POPUP" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_SUBSCRIBE" => "Подписаться",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "SEF_MODE" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "N",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "-",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "-",
    "SET_LAST_MODIFIED" => "N",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "ADD_SECTIONS_CHAIN" => "N",
    "CACHE_FILTER" => "N",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "CONVERT_CURRENCY" => "N",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => "",
    "OFFERS_CART_PROPERTIES" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "ADD_TO_BASKET_ACTION" => "ADD",
    "PAGER_TEMPLATE" => "round",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "COMPATIBLE_MODE" => "N",
    "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:4:49\",\"DATA\":{\"logic\":\"Equal\",\"value\":25}},{\"CLASS_ID\":\"CondIBProp:4:49\",\"DATA\":{\"logic\":\"Equal\",\"value\":26}},{\"CLASS_ID\":\"CondIBProp:4:49\",\"DATA\":{\"logic\":\"Equal\",\"value\":27}}]}",
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
    "PROPERTY_CODE_MOBILE" => array(
    ),
    "BACKGROUND_IMAGE" => "-",
    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
    "ENLARGE_PRODUCT" => "STRICT",
    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "SHOW_SLIDER" => "Y",
    "LABEL_PROP_MOBILE" => "",
    "LABEL_PROP_POSITION" => "top-left",
    "SHOW_MAX_QUANTITY" => "N",
    "RCM_TYPE" => "personal",
    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
    "SHOW_FROM_SECTION" => "N",
    "DISPLAY_COMPARE" => "N",
    "USE_ENHANCED_ECOMMERCE" => "N",
    "LAZY_LOAD" => "N",
    "LOAD_ON_SCROLL" => "N",
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
    "SLIDER_INTERVAL" => "3000",
    "SLIDER_PROGRESS" => "N",
    "SEF_RULE" => "#SECTION_CODE#/",
    "SECTION_CODE_PATH" => ""
  ),
  false
);
    ?>

  </div>
  <div class="build-list">
    <div class="fl-row l_header" style="justify-content: space-between;">
      <h2>Real estate in Moscow. Express Review</h2>
 <a href="">
      Details about buying real estate in Moscow &gt; </a>
    </div>
    <p>
       Many people think that Lorem Ipsum is a pseudo-Latin set of words taken from the ceiling, but this is not entirely true. Its roots go back to one fragment of classical Latin, 45 AD, that is, more than two thousand years ago. Richard McClintock, a Latin professor at Hampden-Sydney, Virginia, took one of the strangest words in Lorem Ipsum, “consectetur,” and took up his quest for classical Latin literature. As a result, he found the undeniable original source of Lorem Ipsum in sections 1.10.32 and 1.10.33 of the book "de Finibus Bonorum et Malorum" ("On the limits of good and evil"), written by Cicero in 45 AD. This treatise on the theory of ethics was very popular in the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet ..", comes from one of the lines in section 1.10.32
    </p>
    <p>
       Many people think that Lorem Ipsum is a pseudo-Latin set of words taken from the ceiling, but this is not entirely true. Its roots go back to one fragment of classical Latin, 45 AD, that is, more than two thousand years ago. Richard McClintock, a Latin professor at Hampden-Sydney, Virginia, took one of the strangest words in Lorem Ipsum, “consectetur,” and took up his quest for classical Latin literature. As a result, he found the undeniable original source of Lorem Ipsum in sections 1.10.32 and 1.10.33 of the book "de Finibus Bonorum et Malorum" ("On the limits of good and evil"), written by Cicero in 45 AD. This treatise on the theory of ethics was very popular in the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet ..", comes from one of the lines in section 1.10.32
    </p>
  </div>
  <div class="build-list">
    <div class="fl-row l_header">
      <h2>Moscow collections</h2>
    </div>
    <div class="build-items fl-row">
      <div class="build-item">
        <div class="a-item" style="background-image: url('http://tvtower.ru/upload/about.jpg');">
 <a href="">
          <div>
            <h4>New buildings</h4>
          </div>
 </a>
        </div>
        <div class="compilation">
          <ul>
            <li><a href="">Most Discussed</a></li>
            <li><a href="">High rating</a></li>
            <li><a href="">Cheap</a></li>
            <li><a href="">Handed over</a></li>
            <li><a href="">Elite</a></li>
          </ul>
        </div>
      </div>
      <div class="build-item">
        <div class="a-item" style="background-image: url('http://tvtower.ru/upload/about.jpg');">
 <a href="">
          <div>
            <h4>Villas / Townhouses</h4>
          </div>
 </a>
        </div>
        <div class="compilation">
          <ul>
            <li><a href="">Most Discussed</a></li>
            <li><a href="">High rating</a></li>
            <li><a href="">Cheap</a></li>
            <li><a href="">Elite</a></li>
          </ul>
        </div>
      </div>
      <div class="build-item">
        <div class="a-item" style="background-image: url('http://tvtower.ru/upload/about.jpg');">
       <a href="/builders">
            <div>
              <h4>Developers / Agents</h4>
            </div>
       </a>
        </div>
        <div class="compilation">
          <ul>
            <li><a href="">Most Discussed</a></li>
            <li><a href="">High rating</a></li>
          </ul>
        </div>
      </div>
      <div class="build-item">
        <div class="a-item" style="background-image: url('http://tvtower.ru/upload/about.jpg');">
 <a href="">
          <div>
            <h4>Investments</h4>
          </div>
 </a>
        </div>
        <div class="compilation">
          <ul>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="build-list">
    <div class="fl-row l_header" style="justify-content: space-between;">
      <h2>The best articles about Moscow Real Estate.</h2>
    </div>
     <?$APPLICATION->IncludeComponent(
  "bitrix:news.line", 
  "best_list_article", 
  array(
    "ACTIVE_DATE_FORMAT" => "f j, Y",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "300",
    "CACHE_TYPE" => "A",
    "COMPONENT_TEMPLATE" => "best_list_article",
    "DETAIL_URL" => "/stati/?ELEMENT_ID=#ELEMENT_ID#",
    "FIELD_CODE" => array(
      0 => "ID",
      1 => "CODE",
      2 => "NAME",
      3 => "SORT",
      4 => "PREVIEW_TEXT",
      5 => "PREVIEW_PICTURE",
      6 => "SHOW_COUNTER",
      7 => "SHOW_COUNTER_START",
      8 => "",
    ),
    "IBLOCKS" => array(
      0 => "9",
    ),
    "IBLOCK_TYPE" => "Article",
    "NEWS_COUNT" => "4",
    "SORT_BY1" => "ACTIVE_FROM",
    "SORT_BY2" => "SORT",
    "SORT_ORDER1" => "DESC",
    "SORT_ORDER2" => "ASC"
  ),
  false
);?> <!--<div class="build-items fl-row">
      <div class="build-item">
        <div class="build-item-bg" style="background-image: url('http://ru-dn.ru/wp-content/uploads/2018/10/новостройки.jpg');">
        </div>
        <h4>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.</h4>
        <p>
           Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
        </p>
        <div class="news-date-prew">
           09 января <i class="fa fa-user" aria-hidden="true"></i> 2072
        </div>
      </div>
      <div class="build-item">
        <div class="build-item-bg" style="background-image: url('http://ru-dn.ru/wp-content/uploads/2018/10/новостройки.jpg');">
        </div>
        <div class="news-prew">
          <h4>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.</h4>
          <p>
             Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
          </p>
          <div class="news-date-prew">
             09 января <i class="fa fa-user" aria-hidden="true"></i> 2072
          </div>
        </div>
      </div>
      <div class="build-item">
        <div class="build-item-bg" style="background-image: url('http://ru-dn.ru/wp-content/uploads/2018/10/новостройки.jpg');">
        </div>
        <div class="news-prew">
          <h4>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.</h4>
          <p>
             Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
          </p>
          <div class="news-date-prew">
             09 января <i class="fa fa-user" aria-hidden="true"></i> 2072
          </div>
        </div>
      </div>
      <div class="build-item">
        <div class="build-item-bg" style="background-image: url('http://ru-dn.ru/wp-content/uploads/2018/10/новостройки.jpg');">
        </div>
        <div class="news-prew">
          <h4>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.</h4>
          <p>
             Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
          </p>
          <div class="news-date-prew">
             09 января <i class="fa fa-user" aria-hidden="true"></i> 2072
          </div>
        </div>
      </div>
    </div>-->
  </div>
</div>
 <?/*if (IsModuleInstalled("advertising")):?>
<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "bootstrap", array(
  "COMPONENT_TEMPLATE" => "bootstrap",
    "TYPE" => "MAIN",
    "NOINDEX" => "Y",
    "QUANTITY" => "3",
    "BS_EFFECT" => "fade",
    "BS_CYCLING" => "N",
    "BS_WRAP" => "Y",
    "BS_PAUSE" => "Y",
    "BS_KEYBOARD" => "Y",
    "BS_ARROW_NAV" => "Y",
    "BS_BULLET_NAV" => "Y",
    "BS_HIDE_FOR_TABLETS" => "N",
    "BS_HIDE_FOR_PHONES" => "Y",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000"
  ),
  false,
  array(
  "ACTIVE_COMPONENT" => "N"
  )
);?>
<?endif?>

<?
global $trendFilter;
$trendFilter = array('PROPERTY_TREND' => '4');
?>
<h2>Тренды сезона</h2>
<?$APPLICATION->IncludeComponent(
  "bitrix:catalog.section",
  ".default",
  array(
    "IBLOCK_TYPE_ID" => "catalog",
    "IBLOCK_ID" => "2",
    "BASKET_URL" => "/personal/cart/",
    "COMPONENT_TEMPLATE" => "",
    "IBLOCK_TYPE" => "catalog",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => "",
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "",
    ),
    "ELEMENT_SORT_FIELD" => "sort",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",
    "FILTER_NAME" => "trendFilter",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "HIDE_NOT_AVAILABLE" => "N",
    "PAGE_ELEMENT_COUNT" => "12",
    "LINE_ELEMENT_COUNT" => "3",
    "PROPERTY_CODE" => array(
      0 => "NEWPRODUCT",
      1 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
      3 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "desc",
    "OFFERS_SORT_FIELD2" => "id",
    "OFFERS_SORT_ORDER2" => "desc",
    "TEMPLATE_THEME" => "site",
    "PRODUCT_DISPLAY_MODE" => "Y",
    "ADD_PICT_PROP" => "MORE_PHOTO",
    "LABEL_PROP" => array(
      0 => "NEWPRODUCT"
    ),
    "OFFER_ADD_PICT_PROP" => "-",
    "OFFER_TREE_PROPS" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "SHOW_CLOSE_POPUP" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_SUBSCRIBE" => "Подписаться",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "SEF_MODE" => "N",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "Y",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "-",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "-",
    "SET_LAST_MODIFIED" => "N",
    "USE_MAIN_ELEMENT_SECTION" => "N",
    "ADD_SECTIONS_CHAIN" => "N",
    "CACHE_FILTER" => "N",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "CONVERT_CURRENCY" => "N",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => array(
    ),
    "OFFERS_CART_PROPERTIES" => array(
      0 => "COLOR_REF",
      1 => "SIZES_SHOES",
      2 => "SIZES_CLOTHES",
    ),
    "ADD_TO_BASKET_ACTION" => "ADD",
    "PAGER_TEMPLATE" => "round",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "MESSAGE_404" => "",
    "COMPATIBLE_MODE" => "N",
  ),
  false
);*/?> <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>