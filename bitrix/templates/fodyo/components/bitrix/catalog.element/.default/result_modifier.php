<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (count($arResult["OFFERS"])>0)
{
   if ($arParams["CURRENT_OFFER"]>0)
   {
      $arResult["CURRENT_OFFER"] = $arParams["CURRENT_OFFER"];
   }
}