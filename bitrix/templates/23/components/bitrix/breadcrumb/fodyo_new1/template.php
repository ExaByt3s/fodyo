<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
    return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();

$strReturn .= '<div class="bx-breadcrumb" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = ($index > 0? ' - ' : '');

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
    {
        $strReturn .=  $arrow.'
            <div class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a class="bx-breadcrumb-item-link" href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
                    <span class="bx-breadcrumb-item-text" itemprop="name">'.$title.'</span>
                </a>
                <meta itemprop="position" content="'.($index + 1).'" />
            </div>';
    }
    else
    {
        $strReturn .= $arrow.'
            <div class="bx-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span class="bx-breadcrumb-item-text" itemprop="name">'.$title.'</span>
                <meta itemprop="position" content="'.($index + 1).'" />
            </div>';
    }
}

$strReturn .= '</div>';

return $strReturn;
