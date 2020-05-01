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


<!--<div class="build-item">
				<div class="build-item-bg" style="background-image: url('http://ru-dn.ru/wp-content/uploads/2018/10/новостройки.jpg');">
				</div>
				<h4>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.</h4>
				<p>
					 Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
				</p>
				<div class="news-date-prew">
					 09 января <i class="fa fa-user" aria-hidden="true"></i> 2072
				</div>
</div>-->


<div class="news-line">
	<div class="build-items fl-row">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
				<div class="build-item">
					<div class="art-overflow">
						<div 
							class="build-item-bg" 
							style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');"
							alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
						</div>
						<h4><?echo $arItem["NAME"]?></h4>
						<p>
							<?=$arItem["PREVIEW_TEXT"]?>
						</p>
					</div>	
					<div class="news-date-prew">
						<?=$arItem["DISPLAY_ACTIVE_FROM"]?>
						&nbsp;
						<?php //if ($arItem['SHOW_COUNTER']>0): ?>
							<i class="fa fa-user" aria-hidden="true"></i>
							&nbsp;
							<?=$arItem['SHOW_COUNTER']?>
						<?php //endif; ?>
					</div>
				</div>
			</a>
		<?endforeach;?>
	</div>
</div>
<footer> 
	<a href='/<?=$arItem["IBLOCK_CODE"]?>'>
		<h3>Все статьи &gt;</h3>
	</a>
</footer>
<?/*<pre><?print_r($arItem);?></pre>*/?>