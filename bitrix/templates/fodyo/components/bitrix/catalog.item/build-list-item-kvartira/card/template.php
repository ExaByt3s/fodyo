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

<??>
<? if ($itemHasDetailUrl): ?>
	<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>" data-entity="image-wrapper">
<? else: ?>
	<span class="product-item-image-wrapper" data-entity="image-wrapper">
<? endif; ?>
	<div class="build-item-bg" style="background-image: url('<?=$item['PREVIEW_PICTURE']['SRC']?>');"></div>
<? if ($itemHasDetailUrl): ?>
	</a>
<? else: ?>
	</span>
<? endif; ?>
<?/*<pre><?=print_r($item)?></pre>*/?>
<div class="build-item-prop">
	<div class="build-status fl-row">
		<div>Квартира</div>
		<div>Сдан</div>
	</div>
	<h3>
		<? if ($itemHasDetailUrl): ?>
			<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$productTitle?>">
		<? endif; ?>
		<?=$productTitle?>
		<? if ($itemHasDetailUrl): ?>
			</a>
		<? endif; ?>
	</h3>
	<p><?=$item['PROPERTIES']['SHORT_ADDRESS']['VALUE']?></p>
	<? if($item['PROPERTIES']['STANTION_METRO']['VALUE']): ?>
		<p class="build-near-metro">
			<img src="/images/logo_mos_metro.png">
			<span><?=$item['PROPERTIES']['STANTION_METRO']['VALUE']?></span>
			<img src="/images/logo_mos_metro.png">
			2 мин.
		</p>
	<? endif; ?>
	<?
	
	if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
	{
		foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
		{
			$showProductProps = !empty($item['DISPLAY_PROPERTIES']);
			$showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

			?>
			
			<?
		}
	}
	?>

	<div class="product-item-info-container product-item-hidden" data-entity="props-block">
		<dl class="product-item-properties">
			<?
			
			?>
			<dt>
				Площадь, м2
			</dt>
			<dd>
				72
			</dd>
			<dt>
				Количество комнат
			</dt>
			<dd>
				3
			</dd>
			<dt>
				Этаж
			</dt>
			<dd>
				15
			</dd>
			<dt>
				Стоимость, общ.
			</dt>
			<dd>
				10 226 530Р
			</dd>
			<?
			

			if ($showOfferProps)
			{
				?>
				<span id="<?=$itemIds['DISPLAY_PROP_DIV']?>" style="display: none;"></span>
				<?
			}
			?>
		</dl>
	</div>
	<?
	/*if (
		$arParams['DISPLAY_COMPARE']
		&& (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
	)
	{
		?>
		<div class="product-item-compare-container">
			<div class="product-item-compare">
				<div class="checkbox">
					<label id="<?=$itemIds['COMPARE_LINK']?>">
						<input type="checkbox" data-entity="compare-checkbox">
						<span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
					</label>
				</div>
			</div>
		</div>
		<?
	}*/
	?>
	<div class="build-item-link fl-row">
		<a href="">
			<div>
				Отдел продаж
				<i class="fa fa-phone fa-flip-horizontal" aria-hidden="true"></i>
			</div>
		</a>
		<a href="">
			<div>
				<i class="fa fa-heart" aria-hidden="true"></i>
			</div>
		</a>
	</div>
</div>

