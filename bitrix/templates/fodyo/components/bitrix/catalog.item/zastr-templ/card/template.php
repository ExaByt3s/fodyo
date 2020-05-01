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
<div class="zastr-item-wrapper">

		<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>" data-entity="image-wrapper">

			<div class="build-item-bg" style="background-image: url('<?=$item['PREVIEW_PICTURE']['SRC']?>');"></div>
			
			<div class="zastr-item">
				<h3>
					<?=$productTitle?>
				</h3>
			</div>

		</a>

</div>