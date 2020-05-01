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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

?>
<div class="filter">
    <div class="flex-filter">
        <div class="rooms">
            <div class="title"><?=GetMessage('ROOMS')?></div>

            <div class="checkbox-wrapper">
                <div class="checkbox"><?=GetMessage('STUDY')?></div>
                <div class="checkbox">1</div>
                <div class="checkbox">2</div>
                <div class="checkbox">4</div>
                <div class="checkbox">4+</div>
            </div>
            
        </div>
        <div class="rent-time">
            <div class="title"><?=GetMessage('TIME_SDAN')?></div>
            <div class="checkbox-wrapper">
                <div class="checkbox"><?=GetMessage('DOM_SDAN')?></div>
                <div class="checkbox">2019</div>
                <div class="checkbox">2020</div>
                <div class="checkbox">2021+</div>
            </div>
        </div>
        <div class="location">
            <div class="title"><?=GetMessage('RASPOLOJENIE')?></div>
            <input type="text" name="place" placeholder="<?=GetMessage('RAYON_METRO_SHOSSE')?>">
        </div>
        <div class="more-parametres">
            <a href="javascript:void(0);"><?=GetMessage('MORE_PARAMETERS')?></a>
        </div>

        <div class="price">
            <div class="checkbox-wrapper">
                <div class="checkbox-input"><?=GetMessage('PRICE_TEXT')?></div>
                <div class="checkbox-input"><input type="text" placeholder="<?=GetMessage('TEXT_FROM')?>" name="price_from"></div>
                <div class="checkbox-input"><input type="text" placeholder="<?=GetMessage('TEXT_TO')?>" name="price_to"></div>
            </div>
        </div>
        <div class="input">
            <input type="text" name="place" placeholder="<?=GetMessage('LCD_METRO_ETC')?>">
        </div>
        <div class="on-map">
            <div class="black-button">
                <?=GetMessage('ON_MAP')?>
            </div>
        </div>
        <div class="show-ten">
            <div class="orange-button">
                <?=GetMessage('SHOW_10')?>
            </div>
        </div>
    </div>
    
</div>

</div>

<div class="background-gray">
    <div class="max-width">
        <div class="breadcrumbs">
            <a href="/">Главная</a> - <a href="/catalog">Россия</a> - <a href="/catalog">Москва</a>
        </div>
        <div class="block-title">
            
            <span class="huge-title"><?=GetMessage('NEDV_IN_MOSCOW')?></span>
        </div>

        <div class="mini-categories">
            <div class="flats">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/flats.png">
                <div class="category_name"><?=GetMessage('FLATS_MINI')?></div>
            </div>
            <div class="villas">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/villas.png">
                <div class="category_name"><?=GetMessage('VILLAS_MINI')?></div>
            </div>
            <div class="invest">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/invest.png">
                <div class="category_name"><?=GetMessage('INVEST_MINI')?></div>
            </div>
            <div class="stati">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/moscow-catalog.png">
                <div class="category_name"><?=GetMessage('ARTICLES_ABOUT_MOSCOW_MINI')?></div>
            </div>
        </div>
    </div>
</div>
<div class="max-width">
    <div class="podborki">
        <div class="left">
            <div class="title-podb"><?=GetMessage('PODBORKI')?> <span class="orange-text"><?=GetMessage('ON_GEOGRAPHIC')?></span> <?=GetMessage('WAYS')?></div>
            <div class="table">
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('MOST_DISCUSSED')?> 10</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('WITH_HIGH_RATING')?> 2</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('BUSINESS_CLASS')?> 25</a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('LOW_FLOORED')?> 200</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="title-podb"><?=GetMessage('MORE_TEXT')?> <span class="orange-text"><?=GetMessage('POPULAR')?></span> <?=GetMessage('PODBORKI_IN_MOSCOW')?></div>
            <div class="table">
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('S_OTDELKOY')?></a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('NEDOROHIE_DESHEVIE')?></a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('BEZ_OTDELKI')?></a>
                </div>
                <div class="value">
                    <a href="javascript:void(0);"><?=GetMessage('KOTLOVAN')?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="items-preview-product flex-row">
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop1.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop2.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop3.jpg"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
    </div>

    <div class="items-preview-product flex-row">
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop1.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop2.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>

        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop3.jpg"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
    </div>

    <div class="block-title">
        <span class="block-category-title"><?=GetMessage('NEWBUILDING_CENTRAL_DISTRICT')?></span>
    </div>

    <div class="items-preview-product flex-row">
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop1.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop2.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop3.jpg"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
    </div>

    
    <a class="more-button" href="/catalog/russia/">
        <?=GetMessage('SHOW_ALL')?>
    </a>
   

    <div class="block-title">
        <span class="block-category-title"><?=GetMessage('INVEST_MOSCOW')?></span>
    </div>

    <div class="items-preview-product flex-row">
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop1.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop2.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop3.jpg"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
    </div>


    <a class="more-button" href="/catalog/russia/">
        <?=GetMessage('SHOW_ALL')?>
    </a>


    <div class="block-title">
        <span class="block-category-title"><?=GetMessage('COTTAGES_TOWNHOSES')?></span>
    </div>

    <div class="items-preview-product flex-row">
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop1.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop2.png"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
        <div class="preview-product-item">
            <a href="/catalog/russia/test-tovar/">
                <div class="image"><img src="/images/pop3.jpg"></div>
                <div class="preview-product-title">Квартира в москве, Россия</div>
                <div class="preview-price">271 000 $</div>
                <div class="preview-props">
                    <div class="prop">Общая площадь 75м<sup>2</sup></div>
                    <div class="prop">Тверской р-н (Центральный адм. округ)</div>
                    <div class="prop">Кузнецкий мост ул.</div>
                    <div class="prop">Застройщик KR Properties</div>
                </div>
            </a>
        </div>
    </div>
    <a class="more-button" href="/catalog/russia/">
        <?=GetMessage('SHOW_ALL')?>
    </a>

    <div class="cat-info-block">
        <div class="block-title">
        <span class="block-category-title"><?=GetMessage('NEDV_EXPRESS_REVIEW')?></span>
        </div>

        <div class="category-info">
            <?=GetMessage('CATEGORY_INFO')?>
        </div>

        <a href="/catalog/russia/">
            <?=GetMessage('PODROBNEE_O_POKUPKE')?>
        </a>
    </div>

    <div class="mini-categories bottom-mini-cats">
        <div class="flats">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/flats.png">
            <div class="hrefs">
                <a href="#"><?=GetMessage('MOST_DISCUSSED_BOTTOM')?></a>
                <a href="#"><?=GetMessage('HIGH_RATING')?></a>
                <a href="#"><?=GetMessage('CHEAP')?></a>
                <a href="#"><?=GetMessage('SDANNIE')?></a>
                <a href="#"><?=GetMessage('ELITE')?></a>
            </div>
        </div>
        <div class="villas">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/villas.png">
            <div class="hrefs">
                <a href="#"><?=GetMessage('MOST_DISCUSSED_BOTTOM')?></a>
                <a href="#"><?=GetMessage('HIGH_RATING')?></a>
                <a href="#"><?=GetMessage('CHEAP')?></a>
                <a href="#"><?=GetMessage('SDANNIE')?></a>
                <a href="#"><?=GetMessage('ELITE')?></a>
            </div>
        </div>

        <div class="invest">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/invest.png">
            <div class="hrefs">
                <a href="#"><?=GetMessage('MOST_DISCUSSED_BOTTOM')?></a>
                <a href="#"><?=GetMessage('HIGH_RATING')?></a>
            </div>
        </div>
        <div class="stati">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/moscow-catalog.png">
            <div class="hrefs">
                <a href="#"><?=GetMessage('MOST_DISCUSSED_BOTTOM')?></a>
                <a href="#"><?=GetMessage('HIGH_RATING')?></a>
                <a href="#"><?=GetMessage('MOST_PROFITABLE')?></a>
            </div>
        </div>
    </div>
    
<?

/*if ($isFilter)
{
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
    {
        $arCurSection = $obCache->GetVars();
    }
    elseif ($obCache->StartDataCache())
    {
        $arCurSection = array();
        if (Loader::includeModule("iblock"))
        {
            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

            if(defined("BX_COMP_MANAGED_CACHE"))
            {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                if ($arCurSection = $dbRes->Fetch())
                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

                $CACHE_MANAGER->EndTagCache();
            }
            else
            {
                if(!$arCurSection = $dbRes->Fetch())
                    $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    if (!isset($arCurSection))
        $arCurSection = array();
}
?>
<div class="row">
<?
if ($isVerticalFilter)
    include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
else
    include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
*/?>
</div>