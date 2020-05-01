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

<div class="product-item">
    <?
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
    
    ?>
    <a href="/<?=strtolower(LANGUAGE_ID).'-'.strtolower($ufPart).$partUrl.$item['CODE']?>/" title="<?=$imgTitle?>">
        <?

        if( !stristr($item['PREVIEW_PICTURE']['SRC'], 'no_photo') && $item['PREVIEW_PICTURE']['SRC'] ){
            $src = $item['PREVIEW_PICTURE']['SRC'];
        }elseif( !stristr($item['DETAIL_PICTURE']['SRC'], 'no_photo') && $item['DETAIL_PICTURE']['SRC'] ){
            $src = $item['DETAIL_PICTURE']['SRC'];
        }elseif( isset($item['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_array($item['PROPERTIES']['GALEREYA']['VALUE']) ){
            $src = CFile::GetPath($item['PROPERTIES']['GALEREYA']['VALUE'][0]);
        }else{
            $src = $item['PREVIEW_PICTURE']['SRC'];
        }
        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
        {
            ?>
            <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>"
                <?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
                <span><?=-$price['PERCENT']?>%</span>
            </div>
            <?
        }
        ?>

        <div class="image"><img class="lozad" data-src="<?=$src?>"></div>

        <div class="preview-product-title gray-product-titcle-card">
            <?
            if( LANGUAGE_ID != 'en' && isset($item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] != '' ){
                echo str_replace($item['CODE'], '', $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
            }else{
                echo str_replace($item['CODE'], '', $item['NAME']);
            }
            ?>
        </div>

        <?

        if(isset($item['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE']))
        {
            ?>
            <div class="black-card-builder">
                <?
                echo $item['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                ?>
            </div>
            <?
        }
        $item['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $item['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
        $item['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $item['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

            if(is_numeric($item['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($item['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
                if(is_numeric($item['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){

                    $priceItem['VAL'] = preg_replace('/\s+/', '', $item['PROPERTIES']['PRICE_FROM_EN']['VALUE'] );
                    $priceItem['CURRENCY'] = 'USD';
                }else{
                    $priceItem['VAL'] = preg_replace('/\s+/', '', $item['PROPERTIES']['PRICE_FROM_RU']['VALUE'] );
                    $priceItem['CURRENCY'] = 'RUB';
                }
            }else{

                $getSku = CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array('PROPERTY_CML2_LINK' => $item['ID'], 'IBLOCK_ID' => 8),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN', 'PRICE_FROM_RU', 'PRICE_FROM_EN')
                );
                while ($fetchSku = $getSku -> Fetch()) {

                    if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){
                        if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) ) < $priceItem['VAL'] ){

                            $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) );

                            $priceItem['CURRENCY'] = 'USD';
                        }else if( !isset($priceItem['VAL']) && !is_numeric($priceItem['VAL']) ){

                            $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']));
                            $priceItem['CURRENCY'] = 'USD';

                        }
                    }else if(is_numeric(preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'])) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) != '0'){

                        if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) < $priceItem['VAL'] ){
                            $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                            $priceItem['CURRENCY'] = 'RUB';
                        }else if(!isset($priceItem['VAL'])){
                            $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                            $priceItem['CURRENCY'] = 'RUB';
                        }

                    }
                }
            }

            if(!isset($priceItem) || !is_array($priceItem)){
                $item['PROPERTIES']['PRICE_EN']['VALUE'] = str_replace('$', '', $item['PROPERTIES']['PRICE_EN']['VALUE']);
                $item['PROPERTIES']['PRICE_RU']['VALUE'] = str_replace(',', '', $item['PROPERTIES']['PRICE_RU']['VALUE']);
                if(is_numeric($item['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($item['PROPERTIES']['PRICE_RU']['VALUE'])){
                    if(is_numeric($item['PROPERTIES']['PRICE_EN']['VALUE'])){
                        $priceItem['VAL'] = preg_replace('/\s+/', '', $item['PROPERTIES']['PRICE_EN']['VALUE'] );
                        $priceItem['CURRENCY'] = 'USD';
                    }else{
                        $priceItem['VAL'] = preg_replace('/\s+/', '', $item['PROPERTIES']['PRICE_RU']['VALUE'] );
                        $priceItem['CURRENCY'] = 'RUB';
                    }
                }
            }
            if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
            {
                foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
                {
                    switch ($blockName)
                    {
                        case 'price':
                            ?>
                            <div class="preview-price">
                                <?
                                echo "<pre style='display:none;'>";print_r($_COOKIE);echo "</pre>";
                                    if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0 && $_COOKIE['CURRENCY_SET']){
                                        echo strtolower(GetMessage('TEXT_FROM')).' '. CCurrencyLang::CurrencyFormat(
                                            ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                            $_COOKIE['CURRENCY_SET']
                                        );
                                    }elseif(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){
                                    	echo strtolower(GetMessage('TEXT_FROM')).' '. CCurrencyLang::CurrencyFormat(
                                            ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], 'USD')),
                                            'USD'
                                        );
                                    }else{
                                        echo GetMessage('NO_PRICE');
                                    }                                 
                                ?>
                            </div>
                            <?
                            break;

                        case 'props':
                            if (!$haveOffers)
                            {
                                if (!empty($item['DISPLAY_PROPERTIES']))
                                {
                                    ?>
                                    <div class="preview-props">
                                        <?
                                        foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
                                        {
                                            ?>
                                            <div class="prop">
                                                <?=$displayProperty['NAME'].' '?>
                                                <?=(is_array($displayProperty['DISPLAY_VALUE'])
                                                    ? implode(' / ', $displayProperty['DISPLAY_VALUE'])
                                                    : $displayProperty['DISPLAY_VALUE'])?>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <?
                                }
                            }
                            else
                            {
                                $showProductProps = !empty($item['DISPLAY_PROPERTIES']);
                                $showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

                                if ($showProductProps || $showOfferProps)
                                {
                                    ?>
                                    <div class="preview-props">
                                        <?
                                        foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
                                        {
                                            ?>
                                            <div class="prop">
                                                <?=$displayProperty['NAME'].' '?>
                                                <?=(is_array($displayProperty['DISPLAY_VALUE'])
                                                    ? implode(' / ', $displayProperty['DISPLAY_VALUE'])
                                                    : $displayProperty['DISPLAY_VALUE'])?>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <?
                                }
                            }

                            break;
                    }
                }
        }?>

    </a>
</div>