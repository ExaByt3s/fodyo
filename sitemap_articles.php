<?php
//Отключаем статистику Bitrix
define("NO_KEEP_STATISTIC", true);
//Подключаем движок
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//устанавливаем тип ответа как xml документ
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

//$array_pages = array();
/*
 //Простые текстовые страницы: начало
 $array_pages[] = array(
 'NAME' => 'Главная страница',
 'URL' => '/',
 );
 $array_pages[] = array(
 'NAME' => 'Компания',
 'URL' => '/kompaniya/',
 );
 $array_pages[] = array(
 'NAME' => 'Новости',
 'URL' => '/novosti/',
 );
 $array_pages[] = array(
 'NAME' => 'Услуги',
 'URL' => '/uslugi/',
 );
 $array_pages[] = array(
 'NAME' => 'Портфолио',
 'URL' => '/portfolio/',
 );
 $array_pages[] = array(
 'NAME' => 'Отзывы',
 'URL' => '/otzyvy/',
 );
 $array_pages[] = array(
 'NAME' => 'Контакты',
 'URL' => '/kontakty/',
 );
 //Простые текстовые страницы: конец
 */

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
    
    //echo '<pre>',print_r($result),'</pre>';
    return $result;
}


function workInCatalog($prefix, $block)
{
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
            echo '<url>';
            echo '<loc>';
            echo '<![CDATA['.$prefix.'/'.$tmp.'/]]>';
            echo '</loc>';
            
            echo '<lastmod>';
            echo $arSect['TIMESTAMP_X'];
            echo '</lastmod>';
            
            echo '</url>';
            //echo '<pre>',$block.' '.$arSect['ID'],'</pre>';
            
            $element = getElementForSection($block, $arSect['ID']);
            foreach ($element as $obj)
            {
                $tmp2 = $prefix.'/'.$arSect['CODE'].'/'.$obj->GetFields()['CODE'];
                echo '<url>';
                echo '<loc>';
                echo '<![CDATA['.$tmp2.'/]]>';
                echo '</loc>';
                
                echo '<lastmod>';
                echo $obj->GetFields()['TIMESTAMP_X'];
                echo '</lastmod>';
                
                echo '</url>';
                //echo '<pre>',($obj.GetFields())['CODE'],'</pre>';
            }
        }
        
    }
    
    return $prev.'/';
    
}



//echo '<pre>',print_r($langArray),'</pre>';
//echo '<pre>',print_r($countrysArray),'</pre>';

if(CModule::IncludeModule("iblock"))
{
    $iblock = 4;
    
                $prefix = "https://develop.fodyo.com/ru/articles";
                workInCatalog($prefix, 7);
             
    
    
    
}


/*
 $array_iblocks_id = array('4'); //ID инфоблоков, разделы и элементы которых попадут в карту сайта
 if(CModule::IncludeModule("iblock"))
 {
 foreach($array_iblocks_id as $iblock_id)
 {
 //Список разделов
 //Список элементов
 $res = CIBlockSection::GetList(
 array(),
 Array(
 "IBLOCK_ID" => $iblock_id,
 "ACTIVE" => "Y" ,
 ),
 false,
 array(
 "ID",
 "NAME",
 "SECTION_PAGE_URL",
 ));
 while($ob = $res->GetNext())
 {
 $array_pages[] = array(
 'NAME' => $ob['NAME'],
 'URL' => $ob['SECTION_PAGE_URL'],
 );
 }
 //Список элементов
 $res = CIBlockElement::GetList(
 array(),
 Array(
 "IBLOCK_ID" => $iblock_id,
 "ACTIVE_DATE" => "Y",
 "ACTIVE" => "Y" ,
 ),
 false,
 false,
 array(
 "ID",
 "NAME",
 "DETAIL_PAGE_URL",
 ));
 while($ob = $res->GetNext())
 {
 $array_pages[] = array(
 'NAME' => $ob['NAME'],
 'URL' => $ob['DETAIL_PAGE_URL'],
 );
 }
 }
 }
 
 //Создаём XML документ: начало
 $xml_content = '';
 $site_url = 'http://'.$_SERVER['HTTP_HOST'];
 $quantity_elements = 0;
 foreach($array_pages as $v)
 {
 $quantity_elements++;
 $xml_content.='
 <url>
 <loc>'.$site_url.$v['URL'].'</loc>
 <priority>1</priority>
 </url>
 ';
 }
 //Создаём XML документ: конец
 
 //Выводим документ
 echo '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
 '.$xml_content.'*/
echo '</urlset>';

?>