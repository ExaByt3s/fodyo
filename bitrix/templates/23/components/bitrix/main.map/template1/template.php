<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!is_array($arResult["arMap"]) || count($arResult["arMap"]) < 1)
    return;

$arRootNode = Array();

foreach($arResult["arMap"] as $index => $arItem)
{
    if ($arItem["LEVEL"] == 0)
        $arRootNode[] = $index;
}

$allNum = count($arRootNode);
$colNum = ceil($allNum / $arParams["COL_NUM"]);

?>
<table class="map-columns">
<tr>
    <td>
        <ul class="map-level-0">
        <?
            //echo "<pre>"; print_r($arResult['arMap']); echo "</pre>";
            $IBLOCK_ID = 4;
            $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y');
            $obSection = CIBlockSection::GetTreeList($arFilter, array('ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'CODE'));

            $arResult["arMap"][] = array('NAME' => 'Каталог', 'FULL_PATH' => '/catalog/', 'LEVEL' => 0, 'STRUCT_KEY' => 6);

            while($arCatalog = $obSection->GetNext()){
                $arResult["arMap"][] = array('NAME' => $arCatalog['NAME'], 'FULL_PATH' => $arCatalog['SECTION_PAGE_URL'], 'LEVEL' => $arCatalog['DEPTH_LEVEL']);

                if($arCatalog['DEPTH_LEVEL'] == 3){

                    $IBLOCK_ID = 4;
                    $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'SECTION_ID' => $arCatalog['ID'],'GLOBAL_ACTIVE'=>'Y');
                    $obItems = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID', 'NAME', 'DETAIL_PAGE_URL', 'CODE'));

                    while($arItem = $obItems->GetNext()){

						$db_old_groups = CIBlockElement::GetElementGroups($arItem['ID'], true);

						while($ar_group = $db_old_groups->Fetch()){
							//echo "<pre style='display:none;'>"; print_r($ar_group); echo "</pre>";
							$getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $arItem['ID'], 'IBLOCK_ID' => $arItem['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
							//$ar_new_groups[] = $ar_group["ID"];
							if($fetchList = $getList->GetNext()){
								if($fetchList['DEPTH_LEVEL'] == 3){
									$partUrl = $fetchList['SECTION_PAGE_URL'];
									$partUrl = str_replace('/ru/', '/', $partUrl);
									$arItem['DETAIL_PAGE_URL']= '/'.strtolower(LANGUAGE_ID).'-'.strtolower($ufPart).$partUrl.$item['CODE'].'/';
								}
							}
						}
                        $arResult["arMap"][] = array('NAME' => $arItem['NAME'], 'FULL_PATH' => $arItem['DETAIL_PAGE_URL'], 'LEVEL' => $arCatalog['DEPTH_LEVEL']+1);
                    }
                }
                //echo $arCatalog['DEPTH_LEVEL'];
            }

			$IBLOCK_ID = 8;
            $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y');
            $obSection = CIBlockSection::GetTreeList($arFilter, array('ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'CODE'));

            $arResult["arMap"][] = array('NAME' => 'Каталог', 'FULL_PATH' => '/catalog/', 'LEVEL' => 0, 'STRUCT_KEY' => 6);

            while($arCatalog = $obSection->GetNext()){
                $arResult["arMap"][] = array('NAME' => $arCatalog['NAME'], 'FULL_PATH' => $arCatalog['SECTION_PAGE_URL'], 'LEVEL' => $arCatalog['DEPTH_LEVEL']);

                if($arCatalog['DEPTH_LEVEL'] == 3){

                    $IBLOCK_ID = 8;
                    $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'SECTION_ID' => $arCatalog['ID'],'GLOBAL_ACTIVE'=>'Y');
                    $obItems = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID', 'NAME', 'DETAIL_PAGE_URL', 'CODE'));

                    while($arItem = $obItems->GetNext()){
						$db_old_groups = CIBlockElement::GetElementGroups($arItem['ID'], true);

						while($ar_group = $db_old_groups->Fetch()){
							//echo "<pre style='display:none;'>"; print_r($ar_group); echo "</pre>";
							$getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $arItem['ID'], 'IBLOCK_ID' => $arItem['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
							//$ar_new_groups[] = $ar_group["ID"];
							if($fetchList = $getList->GetNext()){
								if($fetchList['DEPTH_LEVEL'] == 3){
									$partUrl = $fetchList['SECTION_PAGE_URL'];
									$partUrl = str_replace('/ru/', '/', $partUrl);
									$arItem['DETAIL_PAGE_URL']= '/'.strtolower(LANGUAGE_ID).'-'.strtolower($ufPart).$partUrl.$item['CODE'].'/';
								}
							}
						}
                        $arResult["arMap"][] = array('NAME' => $arItem['NAME'], 'FULL_PATH' => $arItem['DETAIL_PAGE_URL'], 'LEVEL' => $arCatalog['DEPTH_LEVEL']+1);
                    }
                }
                //echo $arCatalog['DEPTH_LEVEL'];
            }
            //echo "<pre>";print_r($arResult['arMap']);echo "</pre>";
        
        $previousLevel = -1;
        $counter = 0;
        $column = 1;
        foreach($arResult["arMap"] as $index => $arItem):
            $arItem["FULL_PATH"] = htmlspecialcharsbx($arItem["FULL_PATH"], ENT_COMPAT, false);
            $arItem["NAME"] = htmlspecialcharsbx($arItem["NAME"], ENT_COMPAT, false);
            $arItem["DESCRIPTION"] = htmlspecialcharsbx($arItem["DESCRIPTION"], ENT_COMPAT, false);
        ?>

            <?if ($arItem["LEVEL"] < $previousLevel):?>
                <?=str_repeat("</ul></li>", ($previousLevel - $arItem["LEVEL"]));?>
            <?endif?>


            <?if ($counter >= $colNum+1 && $arItem["LEVEL"] == 0): 
                    $allNum = $allNum-$counter;
                    $colNum = ceil(($allNum) / ($arParams["COL_NUM"] > 1 ? ($arParams["COL_NUM"]-$column) : 1));
                    $counter = 0;
                    $column++;
            ?>
                </ul></td><td><ul class="map-level-0">
            <?endif?>

            <?if (array_key_exists($index+1, $arResult["arMap"]) && $arItem["LEVEL"] < $arResult["arMap"][$index+1]["LEVEL"]):?>

                <li><a href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a>
                    <ul class="map-level-<?=$arItem["LEVEL"]+1?>">

            <?else:?>

                    <li><a href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a></li>

            <?endif?>


            <?
                $previousLevel = $arItem["LEVEL"];
                if($arItem["LEVEL"] == 0)
                    $counter++;
            ?>

        <?endforeach?>

        <?if ($previousLevel > 1)://close last item tags?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>

        </ul>
    </td>
</tr>
</table>