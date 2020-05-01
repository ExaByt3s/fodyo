<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Loader,
       Rover\GeoIp\Location;

function GetAllSectionInSel($SECTION_ID, $arParent){
   $arR=array();
   for($i=0,$k=count($arParent[$SECTION_ID]);$i<$k;$i++){
       array_push($arR, $arParent[$SECTION_ID][$i]);
       if(isset($arParent[$arParent[$SECTION_ID][$i]])){ //Если ребёнок является родителем
           $arR=array_merge($arR, GetAllSectionInSel($arParent[$SECTION_ID][$i], $arParent));
       }
   }
   return $arR; 
}


function GetAllSectionIn($IBLOCK_ID, $SECTION_ID, $arFilter, $arSelect){
   
   if($arSelect=='ID'){ //если нужны только ид
       $IDon=true;
       $arSelect=array('ID','IBLOCK_SECTION_ID');
   }else{
       $arSelect=array_merge(array('ID','IBLOCK_SECTION_ID'),$arSelect);
   }
   
   $obSection=CIBlockSection::GetList(
       array(),
       array_merge(array('IBLOCK_ID'=>$IBLOCK_ID),$arFilter),
       false,
       $arSelect,
       false
   );
   
   $arAlId=array(); //Для хранения результатов
   $arParent=array(); //Для хранения детей разделов
   while($arResult=$obSection->GetNext()){
       
       $arAlId[$arResult['ID']]=$arResult;
       if(!is_array($arParent[$arResult['IBLOCK_SECTION_ID']])){ //Если родителя в списке нет, то добавляем
           $arParent[$arResult['IBLOCK_SECTION_ID']]=array();
       }
       array_push($arParent[$arResult['IBLOCK_SECTION_ID']], $arResult['ID']);
       
   } 
   unset($obSection);
   
   $arR=GetAllSectionInSel($SECTION_ID, $arParent); //Ид всех детей и правнуков
   
   if(!$IDon){ //Если необходим не только ид
       $arId=$arR;
       $arR=array();
       for($i=0,$k=count($arId);$i<$k;$i++){
           array_push($arR,$arAlId[$arId[$i]]);
       }
   }
   
   return $arR;
}

$getCount = CIBlockSection::GetSectionElementsCount(90, Array());
$getCount += CIBlockSection::GetSectionElementsCount(16, Array());
$getCount += CIBlockSection::GetSectionElementsCount(239, Array());
$getCount += CIBlockSection::GetSectionElementsCount(237, Array());

//echo "<pre>"; print_r($getCount); echo "</pre>";

$APPLICATION->SetPageProperty('title', 'Selling real eastate, condos, newbuildings, townhouses - more than '. $getCount .' ADs on Fodyo.com');



$APPLICATION->SetPageProperty('description', 'base of real estate ADs worldwide on Fodyo.com. Comfortable search ✅ Newbuildings, flats, townhouses ✅ ADs from owners, builders and real eastate agencies ✅ Real estate portal Fodyo.com offers more than '. $getCount .' ADs');



?>


<div class="main-categories">
    <div class="flex-row">
        <?
        $getSect = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => 4, 'DEPTH_LEVEL' => 2),
            false,
            array('ID', 'NAME', 'PICTURE', 'UF_NAME_RU', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'UF_HREF_ISO'),
            false
        );
        while ($getItem = $getSect->GetNext()) {
            $getSections[] = $getItem;
        }
        foreach ($getSections as $key => $value) {
            $value['SECTION_PAGE_URL'] = '/'.strtolower(LANGUAGE_ID).'-'.strtolower($value['UF_HREF_ISO']).'/';
            if($value['UF_HREF_ISO'] == ''){
              $value['SECTION_PAGE_URL'] = '#';
            }
            if($key == 0){
                
                ?>
                <div class="stolb">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <?
                        $pict = CFile::GetPath($value['PICTURE']);
                        ?>
                        <div class="vertical-cat piter lozad" data-background-image='<?=$pict?>'>
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
            <?}elseif($key==1){
                ?>
                <div class="mini-cat popular">
                        <div class="sticker-star"></div>

                        <a href="#">
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID == 'ru'){
                                        echo 'Популярные подборки';
                                    }else{
                                        echo 'Popular collections';
                                    }
                                    ?>
                                </span>
                            </div>
                        </a>
                    </div>    
                </div>
                <?

                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="stolb">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat krasnodar lozad" data-background-image='<?=$pict?>'>
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div> 
                    </a> 
                <?
            }elseif($key == 2){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <a href="<?=$value['SECTION_PAGE_URL']?>">
                    <div class="mini-cat moscow lozad" data-background-image='<?=$pict?>'>
                        
                        <div class="cat-title">
                            <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                    </div>
                </a> 
                <?
            }elseif($key == 3){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat vostoch lozad" data-background-image='<?=$pict?>'>
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?
            }elseif($key == 4){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="stolb">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat novostroi lozad" data-background-image='<?=$pict?>'>
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?
            }elseif($key == 5){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="vertical-cat center lozad" data-background-image='<?=$pict?>'>
                            

                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div> 
                    </a>
                </div>
                <?
            }
        }
        ?>
    </div>

    <div class="flex-column-mobile">
        <?
        foreach ($getSections as $key => $value) {
            $value['SECTION_PAGE_URL'] = '/'.strtolower(LANGUAGE_ID).'-'.strtolower($value['UF_HREF_ISO']).'/';
            if($value['UF_HREF_ISO'] == ''){
                $value['SECTION_PAGE_URL'] = '#';
            }
            if($key == 0){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="row">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="vertical-cat piter lozad" data-background-image='<?=$pict?>'>
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?
            }elseif($key == 1){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="row">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat krasnodar lozad" data-background-image='<?=$pict?>'>
                            
                            <div class="cat-title">
                                <div class="cat-opacity"></div>
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div> 
                    </a> 
                <?
            }elseif($key == 2){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat moscow lozad" data-background-image='<?=$pict?>'>
                            <div class="cat-opacity"></div>
                            <div class="cat-title">
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?
            }elseif($key == 3){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="row">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat vostoch lozad" data-background-image='<?=$pict?>'>
                            <div class="cat-opacity"></div>
                            <div class="cat-title">
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
            <?}elseif($key == 4){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                        <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat novostroi lozad" data-background-image='<?=$pict?>'>
                            <div class="cat-opacity"></div>
                            <div class="cat-title">
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?
            }elseif($key == 5){
                $pict = CFile::GetPath($value['PICTURE']);
                ?>
                <div class="row">
                    <a href="<?=$value['SECTION_PAGE_URL']?>">
                        <div class="mini-cat center lozad" data-background-image='<?=$pict?>'>
                            <div class="cat-opacity"></div>
                            <div class="cat-title">
                                <span>
                                    <?
                                    if(LANGUAGE_ID != 'en'){
                                        echo $value['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                                    }else{
                                        echo $value['NAME'];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div> 
                    </a>
                <?

                ?>  <div class="mini-cat popular">
                        <div class="sticker-star"></div>
                        <a href="#">
                            <div class="cat-title">
                                <span>
                                    Популярные подборки
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                <?
            }
        }
        ?>
        </div>
    </div>
</div>

<div class="other-cities">
    <div class="max-width">
        <div class="block-title">
            <span>Explore other countries on Fodyo</span>
        </div>
        <ul class="flex-countries">
            <?
            $getSect = CIBlockSection::GetList(
                Array("SORT"=>"ASC"),
                Array('DEPTH_LEVEL' => '2', 'IBLOCK_ID' => 4),
                false,
                array('ID', 'NAME', 'PICTURE', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'UF_FLAG', 'UF_HREF_ISO'),
                false
            );
            while ($nextSection = $getSect->GetNext()) {
                $file = CFile::ResizeImageGet($nextSection['UF_FLAG'], array('width'=>125, 'height'=>75), BX_RESIZE_IMAGE_PROPORTIONAL, true);  
                //echo "<pre>"; print_r($file); echo "</pre>";
                $nextSection['SECTION_PAGE_URL'] = '/'.strtolower(LANGUAGE_ID).'-'.$nextSection['UF_HREF_ISO'].'/';
                if($nextSection['UF_HREF_ISO'] == ''){
                  $nextSection['SECTION_PAGE_URL'] = '#';
                }
                ?>
                <li><img src="<?=$file['src']?>" height="15" width="25"><a href="<?=$nextSection['SECTION_PAGE_URL']?>"><span><?=$nextSection['NAME']?></span></a></li>
                <?
            }
            ?>
        </ul>
    </div>
</div>
<div class="news-main">
    <div class="block-title">
        <span class="news-title">Articles about USA</span>
        <a class="read_all_news" href="/articles/">read all articles</a>
    </div>
    <div class="items-news flex-row max-width">
        <?$APPLICATION->IncludeComponent(
    "bitrix:news.list", 
    "table1", 
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "7",
        "IBLOCK_TYPE" => "Articles",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "20",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "ANOUNCE_EN",
            2 => "ANOUNCE_RU",
            3 => "DETAIL_EN",
            4 => "DETAIL_RU",
            5 => "NAME_EN",
            6 => "NAME_RU",
            7 => "",
        ),
        "SET_BROWSER_TITLE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "table1"
    ),
    false
);?>
    </div>
</div>

</div><!-- CLOSE MAX-WIDTH -->

<div class="background-gray">
    <div class="max-width">
        <div class="about-main">
            <div class="block-title">
                <span class="company-title">About the portal</span>
            </div>
            <div class="company-text">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/".strtolower(LANGUAGE_ID)."_about_prev"
                    )
                );?>
            </div>
            <a class="read_more" href="/about/">read more</a>
        </div>
    </div>
</div>

<div class="max-width"><!-- OPEN MAX-WIDTH -->

<?$APPLICATION->IncludeComponent(
    "bitrix:news", 
    "reviews", 
    array(
        "ADD_ELEMENT_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COLOR_NEW" => "3E74E6",
        "COLOR_OLD" => "C0C0C0",
        "COMPONENT_TEMPLATE" => "reviews",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DISPLAY_AS_RATING" => "rating",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FONT_MAX" => "50",
        "FONT_MIN" => "10",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "9",
        "IBLOCK_TYPE" => "reviews",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "LANGUAGE",
            1 => "UPPER_TEXT",
            2 => "LOWER_TEXT",
            3 => "",
        ),
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "NEWS_COUNT" => "20",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PERIOD_NEW_TAGS" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "SEF_MODE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "N",
        "SHOW_404" => "Y",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "TAGS_CLOUD_ELEMENTS" => "150",
        "TAGS_CLOUD_WIDTH" => "100%",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_RATING" => "N",
        "USE_REVIEW" => "N",
        "USE_RSS" => "N",
        "USE_SEARCH" => "N",
        "USE_SHARE" => "N",
        "VARIABLE_ALIASES" => array(
            "SECTION_ID" => "SECTION_ID",
            "ELEMENT_ID" => "ELEMENT_ID",
        )
    ),
    false
);?>

<div class="preview-product-main carousel-mobile">
    <?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section", 
    "popularOnMain", 
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
        "CACHE_TYPE" => "N",
        "COMPATIBLE_MODE" => "Y",
        "COMPONENT_TEMPLATE" => "popularOnMain",
        "CONVERT_CURRENCY" => "N",
        "CUSTOM_FILTER" => "",
        "DETAIL_URL" => "",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_COMPARE" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => "shows",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => "desc",
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
        "PAGE_ELEMENT_COUNT" => "3",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "N",
        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
        "PRODUCT_DISPLAY_MODE" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false}]",
        "PRODUCT_SUBSCRIPTION" => "Y",
        "PROPERTY_CODE_MOBILE" => array(
        ),
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "RCM_TYPE" => "personal",
        "SECTION_CODE" => "",
        "SECTION_ID" => "",
        "SECTION_ID_VARIABLE" => "SECTION_ID_2",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SEF_MODE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "N",
        "SHOW_404" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_FROM_SECTION" => "N",
        "SHOW_MAX_QUANTITY" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_SLIDER" => "Y",
        "SLIDER_INTERVAL" => "3000",
        "SLIDER_PROGRESS" => "N",
        "TEMPLATE_THEME" => "blue",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRODUCT_QUANTITY" => "N"
    ),
    false
);?>
</div>
<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
