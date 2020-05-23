<?php
//Отключаем статистику Bitrix
define("NO_KEEP_STATISTIC", true);
//Подключаем движок
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//устанавливаем тип ответа как xml документ
/*header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';*/

function getElementForSection($block, $sectionId)
{
    $result = Array();
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "CODE","PROPERTY_*", "TIMESTAMP_X");
    $arFilter = Array(
        "IBLOCK_ID"=>$block,
        'ACTIVE' => 'Y',
        "SECTION_ID" => $sectionId
    );
    
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
    //$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false);
    $mass_rez=array();
    while($ob = $res->GetNextElement())
    {
        //echo '<pre>',print_r($ob),'</pre>';
        $result[] = $ob;
    }
    return $result;
}


function workInCatalog($prefix, $block)
{
    global $arrayResult;
    //echo '<pre>',$block,'</pre>';
    $rsSections = CIBlockSection::GetList(
        array("SORT" => "ASC"),
        array("IBLOCK_ID" => 7, "ACTIVE" => "Y"),
        false
        );
    while ($arSect = $rsSections->GetNext())
    {
       // echo '<pre>',print_r($arSect),'</pre>';
        if($arSect['CODE'] !== '')
        {
            $tmp = $arSect['CODE'];
            /*echo '<url>';
            echo '<loc>';
            echo '<![CDATA['.$prefix.'/'.$tmp.'/]]>';
            echo '</loc>';
            echo '<lastmod>';
            echo date('c', strtotime($arSect['TIMESTAMP_X']));
            echo '</lastmod>';
            echo '</url>';*/
            //echo '<pre>',$block.' '.$arSect['ID'],'</pre>';
            $arrayResult[] = '<url>'.
             '<loc>'.
             htmlentities($prefix.'/'.$tmp.'/', ENT_SUBSTITUTE	, "UTF-8").
             '</loc>'.
             '<lastmod>'.
             date('c', strtotime($arSect['TIMESTAMP_X'])).
             '</lastmod>'.
             '</url>';
            
            $element = getElementForSection($block, $arSect['ID']);
            foreach ($element as $obj)
            {
                $tmp2 = $prefix.'/'.$arSect['CODE'].'/'.$obj->GetFields()['CODE'];
                /*echo '<url>';
                echo '<loc>';
                echo '<![CDATA['.$tmp2.'/]]>';
                echo '</loc>';
                echo '<lastmod>';
                echo date('c', strtotime($obj->GetFields()['TIMESTAMP_X']));
                echo '</lastmod>';
                echo '</url>';*/
                $arrayResult[] = '<url>'.
                 '<loc>'.
                 htmlentities($tmp2.'/', ENT_SUBSTITUTE	, "UTF-8").
                 '</loc>'.
                 '<lastmod>'.
                 date('c', strtotime($obj->GetFields()['TIMESTAMP_X'])).
                 '</lastmod>'.
                 '</url>';
            }
        }
    }
    return $prev.'/';
}

if(CModule::IncludeModule("iblock"))
{
    $iblock = 7;
    
    $fileCount = 40000;
    
    $arrayResult = array();
    $prefix = "https://fodyo.com/ru/articles";
    workInCatalog($prefix, $iblock);
    
    
    echo "<pre>iBlock ".$iblock."</pre>";
    echo "<pre>struct sitemap was generated</pre>";
    
    
    $countFiles = ceil(count($arrayResult) / $fileCount);
    
    echo "<pre>Count URLs ".count($arrayResult)."</pre>";
    echo "<pre>Count files ".$countFiles."</pre>";
    
    for ($i = 0; $i < $countFiles; $i++) {
        
        $fp = fopen("./sitemap_iblock_".$iblock."_".$i.".xml", "w+");
        
        
        fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($fp, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
        
        for($j = 0; $j < $fileCount; $j++)
        {
            $index = $i *$fileCount + $j;
            if($index < count($arrayResult))
            {
                fwrite($fp, $arrayResult[$index]);
            }
            
        }
        
        fwrite($fp,  '</urlset>');
        
        fclose($fp);
        
        echo "<pre>".($i+1)." file was writen</pre>";
        
    }
    
    echo "<pre>OK</pre>";
    
}

//echo '</urlset>';
?>