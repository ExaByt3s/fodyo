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

        <div class="image"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>"></div>

        <?
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

        <div class="preview-product-title">
            <?
            //echo "<pre>"; print_r($item['PROPERTIES']['NAME_RU']); echo "</pre>";

            if( LANGUAGE_ID != 'en' && isset($item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] != '' ){

                echo $item['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'];
            }else{
                echo $item['NAME'];
            }
            ?>
        </div>

        <?
        //echo "<pre>"; print_r($price); echo "</pre>";
        if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
        {
            foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
            {
                switch ($blockName)
                {
                    case 'price':
                        //echo "<pre>"; print_r($price);echo "</pre>";
                        if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                        {
                            ?>
                            <span class="product-item-price-old preview-price" id="<?=$itemIds['PRICE_OLD']?>"
                                <?=($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '')?>>
                                <?=$price['PRINT_RATIO_BASE_PRICE']?>
                            </span>
                            <?
                        }
                        ?>
                        <div class="preview-price">
                            <?
                                echo  CCurrencyLang::CurrencyFormat(
                                    ceil(CCurrencyRates::ConvertCurrency($price['RATIO_PRICE'], $price['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
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