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

//echo "<pre>"; print_r($arResult); echo "</pre>";

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();

$strReturn .= '<div class="bx-breadcrumb" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = ($index > 0? ' <i class="fa fa-angle-right"></i> ' : '');

    if (CModule::IncludeModule("iblock")):

        $title = str_replace("Newbuildings", GetMessage('NEWBUILDINGS'), $title);
        $title = str_replace("Flats", GetMessage('FLATS'), $title);
        $title = quotemeta($title);

        //echo "<pre>"; print_r($title); echo "</pre>";

        $getList = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => 4, 'NAME' => $title),
            false,
            false,
            Array('ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_NAME_'.strtoupper(LANGUAGE_ID))
        );

        //echo "<pre>"; print_r($title); echo "</pre>";

        while($fetchList = $getList -> GetNext()){

            //echo "<pre>"; print_r($fetchList); echo "</pre>";

            if(LANGUAGE_ID != 'en' && $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'] ){

                $title = str_replace($title, $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'], $title); 

            }else{
                $title = str_replace($fetchList['CODE'], '', $title); 
            }
            
        }

        $getList = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => 8, 'NAME' => $title),
            false,
            false,
            Array('ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_NAME_'.strtoupper(LANGUAGE_ID))
        );

        //echo "<pre>"; print_r($title); echo "</pre>";

        while($fetchList = $getList -> GetNext()){

            //echo "<pre>"; print_r($fetchList); echo "</pre>";


            if(LANGUAGE_ID != 'en' && $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'] ){

                $title = str_replace($title, $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'], $title); 

            }else{
                $title = str_replace($fetchList['CODE'], '', $title); 
            }
            
        }

        $getList = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => 4, 'NAME' => $title),
            false,
            Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'DEPTH_LEVEL'),
            false
        );

        //echo "<pre>"; print_r($title); echo "</pre>";

        //echo "<pre>"; print_r($getList); echo "</pre>";

        while($fetchList = $getList -> GetNext()){
            //echo "<pre>"; print_r($fetchList); echo "</pre>";
            //echo "<pre>"; print_r($fetchList); echo "</pre>";
            if(LANGUAGE_ID != 'en' && $fetchList['UF_NAME_'.strtoupper(LANGUAGE_ID)] ){

                //$title = $fetchList['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                $title = str_replace($title, $fetchList['UF_NAME_'.strtoupper(LANGUAGE_ID)], $title);

            }
            
        }

    endif;

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
