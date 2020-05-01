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

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
    return;

CUtil::InitJSCore();

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
    $APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>

    <nav class="top-menu-container" id="mobile-menu">
        <ul id="ul_<?=$menuBlockId?>">
        <?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>     <!-- first level-->
            <li> 
                <?
                if( stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'condos') || stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'developments') || stristr($arResult["ALL_ITEMS"][$itemID]['LINK'], 'single-family-homes') ){
                    $xplo = explode('/', $APPLICATION->GetCurDir());
                    $checkPlo = explode('-', $xplo[1]);
                    //echo "<pre>"; print_r( array($checkPlo, LANGUAGE_ID));echo "</pre>";
                    //var_dump($checkPlo[0] != strtolower(LANGUAGE_ID));
                    if($checkPlo[0] != strtolower(LANGUAGE_ID)){
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
                    //echo "<pre>"; print_r( array($checkPlo, LANGUAGE_ID));echo "</pre>";
                    if($checkPlo[0] == strtolower(LANGUAGE_ID)){
                        if($checkPlo[0] != 'en'){
                            $arResult["ALL_ITEMS"][$itemID]['LINK'] = '/'.$checkPlo[0].$arResult["ALL_ITEMS"][$itemID]['LINK'];
                        }
                    }
                }
                ?>
                <a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                    <span>
                        <?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemID]["TEXT"])?>
                        <?if (is_array($arColumns) && count($arColumns) > 0):?><?endif?>
                    </span>
                </a>
            </li>
        <?endforeach;?>
        </ul>
    </nav>