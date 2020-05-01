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
for($index = 0; $index < $itemSize; $index++){   
  
  if($arResult[$index]['LINK'] == '/developments/' || $arResult[$index]['LINK'] == '/condos/' || $arResult[$index]['LINK'] == '/ru/developments/'){
      unset($arResult[$index]);
  }
}

$position = 0;
$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = ($index > 0? ' <i class="fa fa-angle-right"></i> ' : '');

    if (CModule::IncludeModule("iblock")):
        
        $title = str_replace("Newbuildings", GetMessage('NEWBUILDINGS'), $title);
        $title = str_replace("Condos", GetMessage('FLATS'), $title);
        $title = quotemeta($title);
        
        $xplode = explode('-', $title);
        

        if( stristr($APPLICATION->GetCurDir(), 'condos') ){
            $iblockID = 8;
        }elseif(stristr($APPLICATION->GetCurDir(), 'development')){
            $iblockID = 4;
        }
        elseif(stristr($APPLICATION->GetCurDir(), 'single-family-homes')){
            $iblockID = 10;
        }

        $getList = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => 4, 'UF_HREF_ISO' => $xplode[1]),
            false,
            Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'DEPTH_LEVEL', 'UF_HREF_ISO'),
            false
        );
        
        if($fetchList = $getList -> GetNext()){
            if($fetchList['UF_HREF_ISO'] != ''){
                $title = $fetchList['NAME'];
            }
        }
        
        if($arResult[$index]['LINK'] && $index == 0){
            $title = str_replace($title, GetMessage('MAIN_PAGE'), $title);
        }
        
        if($arResult[$index]['LINK'] == $arResult[1]['LINK'] && $index != 1){

            $xplode = explode('/', $arResult[$index]['LINK']);
            
            $xplode = explode('-', $xplode[1]);

            $getList = CIBlockSection::GetList(
                Array("SORT"=>"ASC"),
                Array('IBLOCK_ID' => $iblockID, 'UF_HREF_ISO' => $xplode[1]),
                false,
                Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'DEPTH_LEVEL', 'UF_HREF_ISO', 'SECTION_PAGE_URL'),
                false
            );
            if($fetchList = $getList -> GetNext()){
                if($fetchList['UF_HREF_ISO'] != ''){
                    //$title = $fetchList['NAME'];
                    unset($arResult[$index]);
                    continue;
                }           
            }
        }

        if(preg_match("/".strtolower(LANGUAGE_ID)."-../", trim($arResult[$index]['LINK'])) ){
            $plode = explode('/', $arResult[$index]['LINK']);
            //count($plode);
            if(count($plode) < 4){
                $pll = explode('-', $plode[1]);
                $getList = CIBlockSection::GetList(
                    Array("SORT"=>"ASC"),
                    Array('IBLOCK_ID' => $iblockID, 'UF_HREF_ISO' => $pll[1]),
                    false,
                    Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'DEPTH_LEVEL', 'UF_HREF_ISO', 'SECTION_PAGE_URL'),
                    false
                );
                if($fetchList = $getList -> GetNext()){
                    $title = $fetchList['NAME'];
                    
                }
            }
        }

        $getList = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => $iblockID, 'NAME' => $title),
            false,
            false,
            Array('ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_NAME_'.strtoupper(LANGUAGE_ID))
        );

        while($fetchList = $getList -> GetNext()){

            if(LANGUAGE_ID != 'en' && $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'] ){
                $title = str_replace($title, $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'], $title); 
            }else{
                $title = str_replace($fetchList['CODE'], '', $title); 
            }
            
        }

        $getList = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => $iblockID, 'NAME' => $title),
            false,
            false,
            Array('ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_NAME_'.strtoupper(LANGUAGE_ID))
        );

        while($fetchList = $getList -> GetNext()){
            if(LANGUAGE_ID != 'en' && $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'] ){
                $title = str_replace($title, $fetchList['PROPERTY_NAME_'.strtoupper(LANGUAGE_ID).'_VALUE'], $title); 
            }else{
                $title = str_replace($fetchList['CODE'], '', $title); 
            }
        }

        

        $getList = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array('IBLOCK_ID' => $iblockID, 'NAME' => $title),
            false,
            Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID), 'DEPTH_LEVEL', 'SECTION_PAGE_URL'),
            false
        );

        while($fetchList = $getList -> GetNext()){



            if(LANGUAGE_ID != 'en' && $fetchList['UF_NAME_'.strtoupper(LANGUAGE_ID)] ){

                $title = str_replace($title, $fetchList['UF_NAME_'.strtoupper(LANGUAGE_ID)], $title);
            }            

            if( !stristr($fetchList['SECTION_PAGE_URL'], $arResult[1]['LINK']) && $index > 1){

                if (stristr($fetchList['SECTION_PAGE_URL'], '/ru')) {
                    $fetchList['SECTION_PAGE_URL'] = str_replace('/ru', '', $fetchList['SECTION_PAGE_URL']);
                }
                $replace = str_replace('/', '', $arResult[1]['LINK']);

                $fetchList['SECTION_PAGE_URL'] = '/'.$replace.$fetchList['SECTION_PAGE_URL'];
                $arResult[$index]['LINK'] = $fetchList['SECTION_PAGE_URL'];
            }
            if(!stristr($arResult[$index]['LINK'], $arResult[1]['LINK']) && $index > 1){

                if (stristr($arResult[$index]['LINK'], '/ru')) {
                    $arResult[$index]['LINK'] = str_replace('/ru', '', $arResult[$index]['LINK']);
                }

                $replace = str_replace('/', '', $arResult[1]['LINK']);

                $arResult[$index]['LINK'] = '/'.$replace.$arResult[$index]['LINK'];
            }
        }
    endif;

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
    {
        $position++;
        $strReturn .=  $arrow.'
            <div class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a class="bx-breadcrumb-item-link" href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
                    <span class="bx-breadcrumb-item-text" itemprop="name">'.$title.'</span>
                </a>
                <meta itemprop="position" content="'.($position).'" />
            </div>';
    }
    else
    {
        $position++;
        $strReturn .= $arrow.'
            <div class="bx-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span class="bx-breadcrumb-item-text" itemprop="name">'.$title.'</span>
                <meta itemprop="position" content="'.($position).'" />
            </div>';
    }
}

$strReturn .= '</div>';

return $strReturn;
