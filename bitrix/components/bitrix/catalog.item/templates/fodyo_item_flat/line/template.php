<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>


 <?php 
 /*function debug($param) {
    if ($_COOKIE['debug'] == 1) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
    return 0;
}*/?>
<div class="product-item">
    <a href="javascript:void(0)" class="open-item" title="<?=$imgTitle?>">
        <?
        $res = GetIBlockElement(
            $item['ID']
        );
        //debug($res['PROPERTIES']);
        ?>
        <div class="column text-image">
            <div class="preview-product-title-table">
            <?php 
            
            if(LANGUAGE_ID == 'en')
            {
                if(strpos($res['PROPERTIES']['FLAT_TYPE']['VALUE'], 'комнатная') !== false)
                {
                    $res['PROPERTIES']['FLAT_TYPE']['VALUE'] = $res['PROPERTIES']['BEDS_EN']['VALUE'].'-комнатная';
                }
            }
            ?>
                <div class="table-content-full-size">
                <?
                print_r(  str_replace('Студия', GetMessage('STUDY'), str_replace('Свободная планировка', GetMessage('FREE_LAYOUT_TEXT_FS'), str_replace('комнатная', GetMessage('FLAT_ROOMED_TEXT_FS'),str_replace(' квартира', '', $res['PROPERTIES']['FLAT_TYPE']['VALUE'])))  ));
                ?>
                </div>
                <div class="table-content-mobile-size">
                <?
                print_r(  str_replace('Студия', GetMessage('STUDY'), str_replace('Свободная планировка', GetMessage('FREE_LAYOUT_TEXT_MS'), str_replace('-комнатная', GetMessage('FLAT_ROOMED_TEXT_MS'),str_replace(' квартира', '', $res['PROPERTIES']['FLAT_TYPE']['VALUE']))) ) );
                ?>
                </div>
                
            </div>
        </div>

        <div class="props-square"><?
            if(LANGUAGE_ID == 'en'){
                $squareArea = round((10.764*(float)str_replace(',', '.', $res['PROPERTIES']['SQUARE_AREA']['VALUE'])));
                $squareArea .= ' sq.ft.';
            }else{
                $squareArea = $res['PROPERTIES']['SQUARE_AREA']['VALUE'];
            } 
            print_r($squareArea);?>
        </div>
        <div class="props-floor">
            <?
            if(strtolower(LANGUAGE_ID) == 'en'){
                $res['PROPERTIES']['FLOOR']['VALUE'] = str_replace('из', 'of', $res['PROPERTIES']['FLOOR']['VALUE']);
            }
            ?>
            <?print_r($res['PROPERTIES']['FLOOR']['VALUE']);?>
        </div>      

        <?
        if(is_numeric($res['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($res['PROPERTIES']['PRICE_RU']['VALUE'])){
            if(is_numeric($res['PROPERTIES']['PRICE_EN']['VALUE'])){
                $priceSKU['VAL'] = preg_replace('/\s+/', '', $res['PROPERTIES']['PRICE_EN']['VALUE'] );
                $priceSKU['CURRENCY'] = 'USD';
            }else{
                $priceSKU['VAL'] = preg_replace('/\s+/', '', $res['PROPERTIES']['PRICE_RU']['VALUE']);
                $priceSKU['CURRENCY'] = 'RUB';
            }
        }
        ?>
        <div class="preview-price">
            <?
            if(isset($priceSKU['VAL']) && $priceSKU['VAL'] != '' && $priceSKU['VAL'] != 0){
                
                if($_COOKIE['CURRENCY_SET']){
                    
                    echo "<div class=\"table-content-full-size\">". CustomFormatValue($priceSKU['VAL'], $priceSKU['CURRENCY'], $_COOKIE['CURRENCY_SET'], false, 1000000).'</div>';
                    echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($priceSKU['VAL'], $priceSKU['CURRENCY'], $_COOKIE['CURRENCY_SET'], true, 1000000).'</div>';
                    
                    /*echo CCurrencyLang::CurrencyFormat(
                        ceil(CCurrencyRates::ConvertCurrency(
                            $priceSKU['VAL'],
                            $priceSKU['CURRENCY'],
                            $_COOKIE['CURRENCY_SET'])
                            ),
                        $_COOKIE['CURRENCY_SET']
                        );*/
                }
                else
                {
                    echo "<div class=\"table-content-full-size\">". CustomFormatValue($priceSKU['VAL'], $priceSKU['CURRENCY'], 'USD', false, 1000000).'</div>';
                    echo "<div class=\"table-content-mobile-size\">". CustomFormatValue($priceSKU['VAL'], $priceSKU['CURRENCY'], 'USD', true, 1000000).'</div>';
                    
                }
            }else{
                echo GetMessage('NO_PRICE');
            }
            
            ?>
        </div>
    </a>
    <?
    //echo "<pre>"; print_r($item['PROPERTIES']['GALEREYA']); echo "</pre>";
    if(is_numeric($item['PROPERTIES']['GALEREYA']['VALUE'][0])){
        $getArray = CFile::GetFileArray($item['PROPERTIES']['GALEREYA']['VALUE'][0]);

        //$src = CFile::GetPath($item['PROPERTIES']['GALEREYA']['VALUE'][0]);
        $file = CFile::ResizeImageGet($item['PROPERTIES']['GALEREYA']['VALUE'][0], array('width'=>140, 'height'=>140), BX_RESIZE_IMAGE_EXACT, true);
        $src = $file['src'];
    }else{
        //$src = CFile::GetPath($item['PROPERTIES']['GALEREYA']['VALUE']);
        $getArray = CFile::GetFileArray($item['PROPERTIES']['GALEREYA']['VALUE']);
        //$src = CFile::GetPath($item['PROPERTIES']['GALEREYA']['VALUE'][0]);
        $file = CFile::ResizeImageGet($item['PROPERTIES']['GALEREYA']['VALUE'], array('width'=>140, 'height'=>140), BX_RESIZE_IMAGE_EXACT, true);
        $src = $file['src'];
    }
    ?>
    <div class="open-block">
        <div class="image hidden">
            <a href="<?=$getArray['SRC']?>" data-fancybox>
                <img src="<?=$src?>">
            </a>
        </div>
        <div class="column">
            <div class="props"></div>
            <div class="sku-name">
            <?
            if( LANGUAGE_ID != 'en' && isset($res['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $res['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] != '' ){
                echo $res['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];
            }else{
                echo $res['NAME'];
            }
            ?>
            </div>
            <?
            if(GetMessage('PHONE_SIDEBAR_VALUE') != ''){?>
                <a class="phone-sku" href="tel:<?=GetMessage('PHONE_SIDEBAR_VALUE')?>"><?=GetMessage('PHONE_SIDEBAR_VISUAL')?></a>
            <?
            }
            $db_old_groups = CIBlockElement::GetElementGroups($item['ID'], true);

            while($ar_group = $db_old_groups->Fetch()){
                //echo "<pre style='display:none;'>"; print_r($ar_group); echo "</pre>";
                $getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $ar_group['ID'], 'IBLOCK_ID' => $item['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
                //$ar_new_groups[] = $ar_group["ID"];
                if($fetchList = $getList->GetNext()){
                    if($fetchList['DEPTH_LEVEL'] == 2){
                        $ufPart = $fetchList['UF_HREF_ISO'];
                    }
                    if($fetchList['DEPTH_LEVEL'] == 3){
                        $partUrl = $fetchList['SECTION_PAGE_URL'];
                        $partUrl = str_replace('/ru/', '/', $partUrl);
                    }
                }
            }
            //$explode = explode('/', $APPLICATION->GetCurDir());
            //$item['CODE'] = str_replace('/'.strtolower(LANGUAGE_ID).'/', '', $item['CODE']);
            //echo "<pre style='display:none;'>"; print_r($res['CODE']); echo "</pre>";
            ?>
            <a href="/<?=strtolower(LANGUAGE_ID).'-'.strtolower($ufPart).$partUrl.$item['CODE']?>/"><?=GetMessage('READ_MORE_TEXT')?></a>
        </div>
    </div>
</div>