<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$handle = headers_list();
$strTitle = "";
?>
<div class="catalog-section-list-footer">
    <span class="footer-title"><?=GetMessage('COUNTRIES')?></span>
    <ul>
        <?
        foreach($arResult["SECTIONS"] as $arSection)
        {
            if(LANGUAGE_ID == 'en'){
                $name = $arSection['NAME'];
            }else{
                $getSection = CIBlockSection::GetList(
                    Array("SORT"=>"ASC"),
                    Array("ID" => $arSection['ID'], 'IBLOCK_ID' => $arSection['IBLOCK_ID']),
                    false,
                    Array('ID', 'NAME', 'IBLOCK_ID', 'UF_NAME_'.strtoupper(LANGUAGE_ID)),
                    false
                );
                while($fetch = $getSection -> GetNext()){
                    $name = $fetch['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                }
            }

            $arSection["SECTION_PAGE_URL"] = '/'.strtolower(LANGUAGE_ID).'-'.strtolower($arSection['UF_HREF_ISO']).'/';
            if($arSection['UF_HREF_ISO'] == ''){
                $arSection["SECTION_PAGE_URL"] = '#';
                if(stristr($handle[0], '404')){
				    $arSection["SECTION_PAGE_URL"] = '/#';
				}
            }

            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

            $link = '<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$name.'</a>';
            echo "<li>".$link."</li>";
        }
        ?>
    </ul>
</div>

