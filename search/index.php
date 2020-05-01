<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");

$sectionId = $_REQUEST['SECTION_ID'];
//$language = $_REQUEST['LANGUAGE_ID'];

function objectToArray($d) 
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}


$arrPrice = explode('-_-', $_REQUEST['PRICE_ARR']);
if (CModule::IncludeModule('currency')) {
    if($_COOKIE['CURRENCY_SET']){
        $priceFilter = array('LOGIC' => 'AND');
        if($arrPrice[0]){
            $priceFilter[] = array(
                'LOGIC' => 'OR',
                '>=PROPERTY_PRICE_FROM_RU' => CCurrencyRates::ConvertCurrency($arrPrice[0], $_COOKIE['CURRENCY_SET'], 'RUB'),
                '>=PROPERTY_PRICE_FROM_EN' => CCurrencyRates::ConvertCurrency($arrPrice[0], $_COOKIE['CURRENCY_SET'], 'USD')
            );
        }
        if($arrPrice[1]){
            $priceFilter[] = array(
                'LOGIC' => 'OR',
                "<=PROPERTY_PRICE_FROM_RU" => CCurrencyRates::ConvertCurrency($arrPrice[1], $_COOKIE['CURRENCY_SET'], 'RUB'),
                "<=PROPERTY_PRICE_FROM_EN" => CCurrencyRates::ConvertCurrency($arrPrice[1], $_COOKIE['CURRENCY_SET'], 'USD')
            );
        }
    }
}

$arrArea = explode('-_-', $_REQUEST['SQUARE_ARR']);

if ($arrArea[0] || $arrArea[1]) {
    $squareFilter = array('LOGIC' => 'AND');

    if( strtolower(LANGUAGE_ID) == 'ru'){

        $ruArea[0] = $arrArea[0];
        $enArea[0] = $arrArea[0]*10.764;

        $ruArea[1] = $arrArea[1];
        $enArea[1] = $arrArea[1]*10.764;

    }else if( strtolower(LANGUAGE_ID) == 'en' ){

        $ruArea[0] = $arrArea[0]/10.764;
        $enArea[0] = $arrArea[0];

        $ruArea[1] = $arrArea[1]/10.764;
        $enArea[1] = $arrArea[1];

    }
    if($arrArea[0]){
        $squareFilter[] = array(
            'LOGIC' => 'OR',
            '>=PROPERTY_UNIT_SIZE_RU' => $ruArea[0],
            '>=PROPERTY_UNIT_SIZE_EN' => $enArea[0],
        );
    }
    if($arrArea[1]){
        $squareFilter[] = array(
            'LOGIC' => 'OR',
            "<=PROPERTY_UNIT_SIZE_RU" => $ruArea[1],
            "<=PROPERTY_UNIT_SIZE_EN" => $enArea[1],
        );
    }

    //echo "<pre>"; print_r($squareFilter); echo "</pre>";
}

$test = objectToArray(json_decode($_REQUEST['json']));
//echo '<pre>'; print_r($test); echo "</pre>";
foreach ($test as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $arrNewFilter[$key][] = array( "LOGIC" => 'OR',
            'PROPERTY_'.$key."_RU" => $value2,
            'PROPERTY_'.$key."_EN" => $value2
        );
    }
}
$counterProps = 0;
foreach ($arrNewFilter as $key => $value) {
    $counterProps += 1;
    foreach ($value as $key2 => $value2) {
        foreach ($value2 as $key3 => $value3) {
            if(trim($key3) == 'PROPERTY_BEDS_RU' || trim($key3) == 'PROPERTY_BEDS_EN'){
                if($key3 == 'PROPERTY_BEDS_RU' && strtolower(LANGUAGE_ID) == 'en'){$value3 = $value3+1;}
                if($key3 == 'PROPERTY_BEDS_EN' && strtolower(LANGUAGE_ID) == 'ru'){$value3 = $value3-1;}
                //echo "<pre>"; print_r(array($key3, $value3)); echo "</pre>";
                if(trim($value3) == 4){
                    $arExFilt[$counterProps]['>='.$key3][] = $value3;
                }else{
                    if($key3 == 'LOGIC'){
                        $arExFilt[$counterProps][$key3] = 'OR';
                    }else{
                        $arExFilt[$counterProps][$key3][] = $value3;
                    }
                }
            }else{
                if($key3 == 'LOGIC'){
                    $arExFilt[$counterProps][$key3] = 'OR';
                }else{
                    $arExFilt[$counterProps][$key3][] = $value3;
                }
            }
        }
    }
}

if (CModule::IncludeModule("iblock")){
    //echo "<pre>"; print_r(array($arExFilt, $priceFilter, $squareFilter)); echo "</pre>";
    //$arTestFilter = array($arExFilt, $priceFilter, $squareFilter);
    if(isset($_REQUEST['q']) && $_REQUEST['q'] != ''){        
        $getList = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array('ACTIVE' => 'Y',
                    'IBLOCK_ID' => array('4', '8'),
                    array(
                        "LOGIC" => "OR",
                        'NAME' => '%'.$_REQUEST['q'].'%',
                        "PROPERTY_NAME_".strtoupper(LANGUAGE_ID) => '%'.$_REQUEST['q'].'%'
                    ),
                    $arExFilt,
                    $priceFilter,
                    $squareFilter,
                ),
            false,
            false,
            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
        );
    }else{
        
        $getList = CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array('ACTIVE' => 'Y',
                    'IBLOCK_ID' => array('4', '8'),
                    $arExFilt,
                    $priceFilter,
                    $squareFilter,
                ),
            false,
            false,
            array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
        );
    }


        $nav = $getList;
        $nav->NavStart(12);

        while($fetchSearch = $getList -> GetNextElement()){
            
            $arItem = $fetchSearch->GetFields();
            $arItem["PROPERTIES"] = $fetchSearch->GetProperties();
            $productsResult[] = $arItem;;
            
        }
}
?>
<div class="items-preview-product flex-row" data-entity="items-row" style="flex-wrap: wrap;">
    <?
    foreach ($productsResult as $key => $value) {
        unset($priceItem);
        $db_old_groups = CIBlockElement::GetElementGroups($value['ID'], true);
        while($ar_group = $db_old_groups->Fetch()){
            $getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $ar_group['ID'], 'IBLOCK_ID' => $value['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
            if($fetchList = $getList->GetNext()){
                if($fetchList['DEPTH_LEVEL'] == 2){
                    $ufPart = $fetchList['UF_HREF_ISO'];
                }
                if($fetchList['DEPTH_LEVEL'] == 3){
                    $partUrl = $fetchList['SECTION_PAGE_URL'];
                    $partUrl = str_replace('/ru/', '/', $partUrl);
                }
            }
        }
        ?>
        <div class="preview-product-item">
            <div class="product-item-container">
                <div class="product-item">
                    <?
                    $db_old_groups = CIBlockElement::GetElementGroups($value['ID'], true);

                    while($ar_group = $db_old_groups->Fetch()){
                        //echo "<pre style='display:none;'>"; print_r($ar_group); echo "</pre>";
                        $getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $ar_group['ID'], 'IBLOCK_ID' => $value['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
                        //$ar_new_groups[] = $ar_group["ID"];
                        if($fetchList = $getList->GetNext()){
                            if($fetchList['DEPTH_LEVEL'] == 2){
                                $ufPart = $fetchList['UF_HREF_ISO'];
                            }
                            if($fetchList['DEPTH_LEVEL'] == 3){
                                $partUrl = $fetchList['SECTION_PAGE_URL'];
                                $partUrl = str_replace('/ru/', '/', $partUrl);
                            }
                        }
                    }
                    //echo "<pre>"; print_r($value); echo "</pre>";
                    ?>
                    <a href="/<?=strtolower(LANGUAGE_ID).'-'.strtolower($ufPart).$partUrl.$value['CODE']?>/" title="<?=$imgTitle?>">
                    <?
                        if( $value['PREVIEW_PICTURE'] ){
                            $src = CFile::GetPath($value['PREVIEW_PICTURE']);
                        }elseif( $value['DETAIL_PICTURE'] ){
                            $src = CFile::GetPath($value['DETAIL_PICTURE']);
                        }elseif( isset($value['PROPERTIES']['GALEREYA']['VALUE'][0]) || is_array($value['PROPERTIES']['GALEREYA']['VALUE']) ){
                            $src = CFile::GetPath($value['PROPERTIES']['GALEREYA']['VALUE'][0]);
                        }else{
                            $src = '/bitrix/templates/23/components/bitrix/catalog.section/default-flats/images/no_photo.png';
                        }
                        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                        {
                            ?>
                            <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$valueIds['DSC_PERC']?>"
                                <?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
                                <span><?=-$price['PERCENT']?>%</span>
                            </div>
                            <?
                        }
                        ?>
                        <div class="image"><img class="lozad" data-src="<?=$src?>"></div>
                        <div class="preview-product-title gray-product-titcle-card">
                            <?
                            if( LANGUAGE_ID != 'en' && isset($value['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']) && $value['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE'] != '' ){
                                echo str_replace($value['CODE'], '', $value['PROPERTIES']['NAME_'.strtoupper(LANGUAGE_ID)]['VALUE']);
                            }else{
                                echo str_replace($value['CODE'], '', $value['NAME']);
                            }
                            ?>
                        </div>

                        <?

                        if(isset($value['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE']))
                        {
                            ?>
                            <div class="black-card-builder">
                                <?
                                echo $value['PROPERTIES']['ADDRESS_'.strtoupper(LANGUAGE_ID)]['VALUE'];
                                ?>
                            </div>
                            <?
                        }

                        //echo "<pre>"; print_r($value['ID']); echo "</pre>";

                        $value['PROPERTIES']['PRICE_FROM_EN']['VALUE'] = str_replace('$', '', $value['PROPERTIES']['PRICE_FROM_EN']['VALUE']);
                        $value['PROPERTIES']['PRICE_FROM_RU']['VALUE'] = str_replace(',', '', $value['PROPERTIES']['PRICE_FROM_RU']['VALUE']);

                        if(is_numeric($value['PROPERTIES']['PRICE_FROM_EN']['VALUE']) || is_numeric($value['PROPERTIES']['PRICE_FROM_RU']['VALUE'])){
                            if(is_numeric($value['PROPERTIES']['PRICE_FROM_EN']['VALUE'])){
                                $priceItem['VAL'] = preg_replace('/\s+/', '', $value['PROPERTIES']['PRICE_FROM_EN']['VALUE'] );
                                $priceItem['CURRENCY'] = 'USD';
                            }else{
                                $priceItem['VAL'] = preg_replace('/\s+/', '', $value['PROPERTIES']['PRICE_FROM_RU']['VALUE'] );
                                $priceItem['CURRENCY'] = 'RUB';
                            }
                        }else{

                            $getSku = CIBlockElement::GetList(
                                array('SORT' => 'ASC'),
                                array('PROPERTY_CML2_LINK' => $value['ID'], 'IBLOCK_ID' => 8),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_FLAT_TYPE', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_EN', 'PRICE_FROM_RU', 'PRICE_FROM_EN')
                            );
                            while ($fetchSku = $getSku -> Fetch()) {

                                if(is_numeric(trim(str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE'])))){
                                    if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) ) < $priceItem['VAL'] ){

                                        $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']) );

                                        $priceItem['CURRENCY'] = 'USD';
                                    }else if( !isset($priceItem['VAL']) && !is_numeric($priceItem['VAL']) ){

                                        $priceItem['VAL'] = preg_replace('/\s+/', '', str_replace('$', '', $fetchSku['PROPERTY_PRICE_EN_VALUE']));
                                        $priceItem['CURRENCY'] = 'USD';

                                    }
                                }else if(is_numeric(preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'])) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) != '0'){

                                    if(isset($priceItem['VAL']) && preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE']) < $priceItem['VAL'] ){
                                        $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                                        $priceItem['CURRENCY'] = 'RUB';
                                    }else if(!isset($priceItem['VAL'])){
                                        $priceItem['VAL'] = preg_replace('/\s+/', '', $fetchSku['PROPERTY_PRICE_RU_VALUE'] );
                                        $priceItem['CURRENCY'] = 'RUB';
                                    }

                                }
                            }
                        }

                        if(!isset($priceItem) || !is_array($priceItem)){
                            $value['PROPERTIES']['PRICE_EN']['VALUE'] = str_replace('$', '', $value['PROPERTIES']['PRICE_EN']['VALUE']);
                            $value['PROPERTIES']['PRICE_RU']['VALUE'] = str_replace(',', '', $value['PROPERTIES']['PRICE_RU']['VALUE']);
                            if(is_numeric($value['PROPERTIES']['PRICE_EN']['VALUE']) || is_numeric($value['PROPERTIES']['PRICE_RU']['VALUE'])){
                                if(is_numeric($value['PROPERTIES']['PRICE_EN']['VALUE'])){
                                    $priceItem['VAL'] = preg_replace('/\s+/', '', $value['PROPERTIES']['PRICE_EN']['VALUE'] );
                                    $priceItem['CURRENCY'] = 'USD';
                                }else{
                                    $priceItem['VAL'] = preg_replace('/\s+/', '', $value['PROPERTIES']['PRICE_RU']['VALUE'] );
                                    $priceItem['CURRENCY'] = 'RUB';
                                }
                            }
                        }
                        //echo "<pre>"; print_r($priceItem); echo "</pre>";
                        ?>
                        <div class="preview-price">
                            <?
                                if(isset($priceItem['VAL']) && $priceItem['VAL'] != '' && $priceItem['VAL'] != 0){
                                    echo strtolower(GetMessage('TEXT_FROM')).' '. CCurrencyLang::CurrencyFormat(
                                        ceil(CCurrencyRates::ConvertCurrency($priceItem['VAL'], $priceItem['CURRENCY'], $_COOKIE['CURRENCY_SET'])),
                                        $_COOKIE['CURRENCY_SET']
                                    );
                                }else{
                                    echo GetMessage('NO_PRICE');
                                }                                 
                            ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?
    }
    ?>    
</div>
<?
echo $nav->NavPrint("Товары", false, "text", "/bitrix/components/bitrix/system.pagenavigation/templates/round/template_not_component.php");;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>