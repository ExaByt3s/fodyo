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


function workInCatalog($prefix, $block, $left, $right, $depth, $prev)
{
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
            echo '<url>';
            echo '<loc>';
            echo '<![CDATA['.$prefix.$tmp.']]>';
            echo '</loc>';
            
            echo '<lastmod>';
            echo $arSect['TIMESTAMP_X'];
            echo '</lastmod>';
            
            echo '</url>';
            //echo '<pre>',$block.' '.$arSect['ID'],'</pre>';
            
            $element = getElementForSection($block, $arSect['ID']);
            foreach ($element as $obj)
            {
                $tmp2 = $prev.'/'.$arSect['CODE'].'/'.$obj->GetFields()['CODE'];
                echo '<url>';
                echo '<loc>';
                echo '<![CDATA['.$prefix.$tmp2.'/]]>';
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

$langArray = array ("ru", "en");

$countrysArray = array(
    "The United Kingdom" => array( "id" => 742, "SN" => "-uk")
    , "Australia" => array( "id" => 743, "SN" => "-au")
    , "France" => array( "id" => 1314, "SN" => "-fr")
    , "Spain" => array( "id" => 1301, "SN" => "-es")
    , "Germany" => array( "id" => 741, "SN" => "-de")
    , "Canada" => array( "id" => 744, "SN" => "-ca")
    , "USA" => array( "id" => 37, "SN" => "-us")
    ,
    "Russia" => array( "id" => 16, "SN" => "-ru")
);

//echo '<pre>',print_r($langArray),'</pre>';
//echo '<pre>',print_r($countrysArray),'</pre>';

if(CModule::IncludeModule("iblock"))
{
    
    //$element = getElementForSection(4, 735);
    foreach ($langArray as $lang)
    {
        foreach ($countrysArray as $country => $IDs)
        {
            $rsSections = CIBlockSection::GetList(
                array("SORT" => "ASC"),
                array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "ID" => $IDs["id"]),
                false
                );
            while ($arSections = $rsSections->GetNext())
            {
                //echo '<pre>',print_r($arSections),'</pre>';
                //echo '<pre>',workInCatalog(4, $arSections['LEFT_MARGIN'], $arSections['RIGHT_MARGIN'], $arSections['DEPTH_LEVEL'], ""),'</pre>';
                $prefix = "https://develop.fodyo.com/".$lang.$IDs["SN"]."/developments";
                workInCatalog($prefix, 4, $arSections['LEFT_MARGIN'], $arSections['RIGHT_MARGIN'], $arSections['DEPTH_LEVEL'], "");
                
            }
        }
    }
    
    
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