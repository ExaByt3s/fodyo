<?php
//Отключаем статистику Bitrix
define("NO_KEEP_STATISTIC", true);
//Подключаем движок
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//устанавливаем тип ответа как xml документ

//header('Content-Type: application/xml; charset=utf-8');
/*echo '<?xml version="1.0" encoding="UTF-8"?>';
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
    $mass_rez=array();
    while($ob = $res->GetNextElement())
    {
        //echo '<pre>',print_r($ob),'</pre>';
        $result[] = $ob;
    }
    return $result;
}

function workInCatalog($prefix, $block, $left, $right, $depth, $prev)
{
    global $arrayResult;
    
    $arFilter = array(
        'IBLOCK_ID' => $block,
        '>LEFT_MARGIN' => $left,
        '<RIGHT_MARGIN' => $right,
        '>DEPTH_LEVEL' => $depth,
        'ACTIVE' => 'Y'); 
    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
    while ($arSect = $rsSect->GetNext())
    {
        //echo '<pre>',print_r($arSect),'</pre>';
        if($arSect['CODE'] !== '')
        {
            $tmp =workInCatalog($prefix, $block, $arSect['LEFT_MARGIN'], $arSect['RIGHT_MARGIN'], $arSect['DEPTH_LEVEL'], $prev.'/'.$arSect['CODE']);
            /*echo '<url>';
            echo '<loc>';
            echo '<![CDATA['.$prefix.$tmp.']]>';
            echo '</loc>';
            echo '<lastmod>';
            echo date('c', strtotime($arSect['TIMESTAMP_X']));
            echo '</lastmod>';
            echo '</url>';*/
            //echo '<pre>',$block.' '.$arSect['ID'],'</pre>';
            $arrayResult[] = '<url>'.
             '<loc>'.
             htmlentities($prefix.$tmp, ENT_SUBSTITUTE	, "UTF-8").
             '</loc>'.
             '<lastmod>'.
             date('c', strtotime($arSect['TIMESTAMP_X'])).
             '</lastmod>'.
             '</url>';
            
            
            $element = getElementForSection($block, $arSect['ID']);
            foreach ($element as $obj)
            {
                $tmp2 = $prev.'/'.$arSect['CODE'].'/'.$obj->GetFields()['CODE'];
                /*echo '<url>';
                echo '<loc>';
                echo '<![CDATA['.$prefix.$tmp2.'/]]>';
                echo '</loc>';
                echo '<lastmod>';
                echo date('c', strtotime($obj->GetFields()['TIMESTAMP_X']));
                echo '</lastmod>';
                echo '</url>';*/
                
                $arrayResult[] =  '<url>'.
                 '<loc>'.
                 htmlentities($prefix.$tmp2.'/', ENT_SUBSTITUTE	, "UTF-8").
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

$langArray = array ("ru", "en");

$countrysArray = array(
    "The United Kingdom" => array( "id" => 1348, "SN" => "-uk")
    , "Australia" => array( "id" => 1351, "SN" => "-au")
    , "France" => array( "id" => 1354, "SN" => "-fr")
    , "Spain" => array( "id" => 1355, "SN" => "-es")
    , "Germany" => array( "id" => 1353, "SN" => "-de")
    , "Canada" => array( "id" => 1352, "SN" => "-ca")
    ,
    "USA" => array( "id" => 239, "SN" => "-us")
    ,
    "Russia" => array( "id" => 237, "SN" => "-ru")
);

if(CModule::IncludeModule("iblock"))
{
    $iblock = 8;
    $fileCount = 40000;
    
    $arrayResult = array();
    
    foreach ($langArray as $lang)
    {
        foreach ($countrysArray as $country => $IDs)
        {
            $rsSections = CIBlockSection::GetList(
                array("SORT" => "ASC"),
                array("IBLOCK_ID" => $iblock, "ACTIVE" => "Y", "ID" => $IDs["id"]),
                false
                );
            while ($arSections = $rsSections->GetNext())
            {
                //echo '<pre>',print_r($arSections),'</pre>';
                $prefix = "https://fodyo.com/".$lang.$IDs["SN"]."/condos";
                workInCatalog($prefix, $iblock, $arSections['LEFT_MARGIN'], $arSections['RIGHT_MARGIN'], $arSections['DEPTH_LEVEL'], "");
            }
        }
    }
    
    
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