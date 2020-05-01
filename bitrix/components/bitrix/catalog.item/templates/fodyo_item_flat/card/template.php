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

    <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>">
        <?

        if( !stristr($item['PREVIEW_PICTURE']['SRC'], 'no_photo') ){

            $src = $item['PREVIEW_PICTURE']['SRC'];

        }elseif( stristr($item['DETAIL_PICTURE']['SRC'], 'no_photo') ){

            $src = $item['DETAIL_PICTURE']['SRC'];

        }elseif(is_numeric($item['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_array($item['PROPERTIES']['GALEREYA']['VALUE'][0])){
            $file = CFile::GetById($item['PROPERTIES']['GALEREYA']['VALUE'][0])->Fetch();
            if($file['FILE_SIZE'] == 0){
                $src = $item['PREVIEW_PICTURE']['SRC'];
            }else{
                $src = CFile::GetPath($item['PROPERTIES']['GALEREYA']['VALUE'][0]);
            }
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

        <div class="preview-product-title">
            <?
            //echo "<pre>"; print_r($item['PROPERTIES']['NAME_RU']); echo "</pre>";

            if( LANGUAGE_ID != 'en' && isset($item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] != '' ){
                echo str_replace($item['CODE'], '', $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
            }else{
                echo str_replace($item['CODE'], '', $item['NAME']);
            }
            ?>
        </div>

        <?
        
        //echo "<pre>"; print_r($item); echo "</pre>";

        $item['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $item['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
        $item['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $item['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

        if(is_numeric($item['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($item['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
            if(is_numeric($item['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){

                $priceItem['VAL'] = (int)$item['PROPERTIES']['PRICE_FROM_EN']['VALUE'];
                $priceItem['CURRENCY'] = 'USD';
            }else{
                $priceItem['VAL'] = (int)$item['PROPERTIES']['PRICE_FROM_RU']['VALUE'];
                $priceItem['CURRENCY'] = 'RUB';
            }
        }else{

            $getSku = CIBlockElement::GetList(
                array('SORT' => 'ASC'),
                array('PROPERTY_CML2_LINK' => $item['ID'], 'IBLOCK_ID' => 8),
                false,
                false,
                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN')
            );
            while ($fetchSku = $getSku -> Fetch()) {

                //echo "<pre>";print_r($fetchSku); echo "</pre>";

                if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){
                    $priceItem['VAL'] = (int)str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']);
                    $priceItem['CURRENCY'] = 'USD';
                }else{
                    $priceItem['VAL'] = (int)$fetchSku['PROPERTY_PRICE_RU_VALUE'];
                    $priceItem['CURRENCY'] = 'RUB';
                }
            }
        }

        //echo "<pre>";print_r($_COOKIE); echo "</pre>";

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
                                //echo "<pre>"; print_r(GetMessage('TEXT_FROM'));echo "</pre>";

                                echo strtolower(GetMessage('TEXT_FROM')).' '. CCurrencyLang::CurrencyFormat(
                                    ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                    $_COOKIE['CURRENCY_SET']
                                );
                                 
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