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
    <span class="footer-title">USA</span>
    <ul>
        <?
        foreach($arResult["SECTIONS"] as $arSection)
        {
            if($arSection['UF_TOP_DEVELOPER'] != 1 && $arSection['UF_IS_PAGE'] != 1){
                $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

                //echo "<pre>"; print_r(); echo "</pre>";

                $xplo = explode('/', $APPLICATION->GetCurDir());
                $explo = explode('-', $xplo);
                if($explo[0] != strtolower(LANGUAGE_ID)){
                    $arSection["SECTION_PAGE_URL"] = '/en-us'.$arSection["SECTION_PAGE_URL"];
                }else{
                    $arSection["SECTION_PAGE_URL"] = '/'.$xplo[1].$arSection["SECTION_PAGE_URL"];
                }
                if($arSection['CODE'] == ''){
                    $arSection["SECTION_PAGE_URL"] = '#';
                    if(stristr($handle[0], '404')){
                        $arSection["SECTION_PAGE_URL"] = '/#';
                    }
                }
                     
                $link = '<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].$count.'</a>';
                echo "<li>".$link."</li>";
            }
        }
        ?>
    </ul>
</div>

