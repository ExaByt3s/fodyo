<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$handle = headers_list();

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
    return;

CUtil::InitJSCore();

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
    $APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>
<div class="top-menu-wrapper">
    <nav class="top-menu-container">
        <ul class="top-menu-1-lvl">
        <?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?> 
            <?
            if( stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'condos') || stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'developments') || stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'single-family-homes') ){
                $xplo = explode('/', $APPLICATION->GetCurDir());
                $checkPlo = explode('-', $xplo[1]);
                if( $checkPlo[0] != strtolower(LANGUAGE_ID) || stristr($handle[0], '404') ){
                    $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/en-us'.$arResult["ALL_ITEMS"][$itemID]['LINK'];
                }else{
                    if(isset($checkPlo[1])){
                        $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/'.$checkPlo[0].'-'.$checkPlo[1].$arResult["ALL_ITEMS"][$itemID]['LINK'];    
                    }else{
                        if($checkPlo[0] == 'en'){
                            $part = 'us';
                        }elseif($checkPlo[0] == 'ru'){
                            $part = 'ru';
                        }
                        $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/'.$checkPlo[0].'-'.$part.$arResult["ALL_ITEMS"][$itemID]['LINK'];
                    }     
                }
                
            }
            if($arResult["ALL_ITEMS"][$itemID]['LINK'] == '/mortgage/'){
                $xplo = explode('/', $APPLICATION->GetCurDir());
                $checkPlo = explode('-', $xplo[1]);
                if($checkPlo[0] == strtolower(LANGUAGE_ID)){
                    if($checkPlo[0] != 'en'){
                        $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/'.$checkPlo[0].$arResult["ALL_ITEMS"][$itemID]['LINK'];
                    }else if($checkPlo[1] == 'us'){
                        $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/'.$checkPlo[0].'-us'.$arResult["ALL_ITEMS"][$itemID]['LINK'];
                    }
                }
            }
            ?>    <!-- first level-->
            <li class="top-menu-1-lvl <?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?>top-menu-active<?endif?>">
                <a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                    <span>
                        <?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemID]["TEXT"])?>
                        <?if (is_array($arColumns) && count($arColumns) > 0):?><?endif?>
                    </span>
                </a>
            </li>
        <?endforeach;?>
        </ul>
        <div style="clear: both;"></div>
    </nav>
</div>