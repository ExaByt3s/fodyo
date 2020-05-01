<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

function objectToArray($d) 
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}


//echo "<pre>"; print_r($_REQUEST['PRICE_ARR']); echo "</pre>";

$sectionId = $_REQUEST['SECTION_ID'];
$language = $_REQUEST['LANGUAGE_ID'];

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
    if( strtolower($language) == 'ru'){

        $ruArea[0] = $arrArea[0];
        $enArea[0] = $arrArea[0]*10.764;

        $ruArea[1] = $arrArea[1];
        $enArea[1] = $arrArea[1]*10.764;

    }else if( strtolower($language) == 'en' ){
        $ruArea[0] = $arrArea[0]/10.764;
        $enArea[0] = $arrArea[0];

        $ruArea[1] = $arrArea[1]/10.764;
        $enArea[1] = $arrArea[1];
    }
    if($arrArea[0]){
        $squareFilter[] = array(
            'LOGIC' => 'OR',
            '>=PROPERTY_UNIT_SIZE_RU' => floatval($ruArea[0]),
            '>=PROPERTY_UNIT_SIZE_EN' => floatval($enArea[0])
        );
    }
    if($arrArea[1]){
        $squareFilter[] = array(
            'LOGIC' => 'OR',
            '<=PROPERTY_UNIT_SIZE_RU' => floatval($ruArea[1]),
            '<=PROPERTY_UNIT_SIZE_EN' => floatval($enArea[1])
        );
    }
}

$test = objectToArray(json_decode($_REQUEST['json']));
//echo "<pre>"; print_r($squareFilter); echo "</pre>";

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
                if($key3 == 'PROPERTY_BEDS_RU' && strtolower($language) == 'en'){$value3 = $value3+1;}
                if($key3 == 'PROPERTY_BEDS_EN' && strtolower($language) == 'ru'){$value3 = $value3-1;}
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
//echo "<pre>"; print_r($arExFilt); echo "</pre>";

    if (CModule::IncludeModule("iblock")){
        $getSection = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array("ID" => $sectionId),
            false,
            Array(),
            false
        );
        while($fetchList = $getSection -> GetNext()){
            $IBLOCK_ID = $fetchList['IBLOCK_ID'];
        }
        $counterProducts == 0; 
        $counterSectionExact = 0;
        $counterProductsExact = 0;
        $counterSection == 0;
        if(isset($_REQUEST['search_query']) && $_REQUEST['search_query'] != ''){
            
            $uf_arresult = CIBlockSection::GetList(
                Array("SORT"=>"­­ASC"), 
                Array(
                    "IBLOCK_ID" => array('4', '8'),
                    'NAME' => '%'.$_REQUEST['search_query'].'%'
                ),
                false,
                array('NAME', 'ID', 'IBLOCK_SECTION_ID', 'IBLOCK_ID', 'SECTION_PAGE_URL', "UF_*")
            );
            while($fetchSearch = $uf_arresult -> GetNext()){
                $uf_arresult_sec = CIBlockSection::GetList(
                    Array("SORT"=>"­­ASC"), 
                    Array(
                        "IBLOCK_ID" => $fetchSearch['IBLOCK_ID'],
                        'ID' => $fetchSearch['ID']
                    ),
                    false,
                    array('NAME', 'ID', 'IBLOCK_SECTION_ID', 'IBLOCK_ID', 'SECTION_PAGE_URL', "UF_NAME_".strtoupper($language))
                );
                if($fetchSearch_sec = $uf_arresult_sec -> GetNext()){
                    $fetchSearch['UF_NAME_'.strtoupper($language)] = $fetchSearch_sec['UF_NAME_'.strtoupper($language)];
                    //echo "<pre>"; print_r($fetchSearch_sec); echo "</pre>";
                }
                if( stristr($fetchSearch['NAME'], $_REQUEST['search_query']) ){
                    $arResult['SEARCH'][] = $fetchSearch;
                    $counterSection += 1;
                    if(strtolower($fetchSearch['NAME']) == strtolower($_REQUEST['search_query'])){
                        $counterSectionExact += 1;
                        $arrNext = $fetchSearch;
                    }
                }
            }
            $uf_arresult = CIBlockSection::GetList(
                Array("SORT"=>"­­ASC"), 
                Array(
                    "IBLOCK_ID" => array('4', '8'),
                    'UF_NAME_'.strtoupper($language) => '%'.$_REQUEST['search_query'].'%'
                ),
                false,
                array('NAME', 'ID', 'IBLOCK_SECTION_ID', 'IBLOCK_ID', 'SECTION_PAGE_URL', "UF_NAME_".strtoupper($language))
            );
            while($fetchSearch = $uf_arresult -> GetNext()){
                $uf_arresult_sec = CIBlockSection::GetList(
                    Array("SORT"=>"­­ASC"), 
                    Array(
                        "IBLOCK_ID" => $fetchSearch['IBLOCK_ID'],
                        'ID' => $fetchSearch['ID']
                    ),
                    false,
                    array('NAME', 'ID', 'IBLOCK_SECTION_ID', 'IBLOCK_ID', 'SECTION_PAGE_URL', "UF_NAME_".strtoupper($language))
                );
                if($fetchSearch_sec = $uf_arresult_sec -> GetNext()){
                    $fetchSearch['UF_NAME_'.strtoupper($language)] = $fetchSearch_sec['UF_NAME_'.strtoupper($language)];
                    //echo "<pre>"; print_r($fetchSearch_sec); echo "</pre>";
                }
                if( stristr($fetchSearch['UF_NAME_'.strtoupper($language)], $_REQUEST['search_query']) ){
                    $arResult['SEARCH'][] = $fetchSearch;
                    $counterSection += 1;
                    if(strtolower($fetchSearch['UF_NAME_'.strtoupper($language)]) == strtolower($_REQUEST['search_query'])){
                        $arrNext = $fetchSearch;
                        $counterSectionExact += 1;
                    }
                }
            }
            

            if(is_array($arExFilt) || $priceFilter || $_REQUEST['q']){
                $getList = CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array('ACTIVE' => 'Y',
                            'IBLOCK_ID' => '4',
                            array(
                                "LOGIC" => "OR",
                                'NAME' => '%'.$_REQUEST['q'].'%',
                                "PROPERTY_NAME_".strtoupper($language) => '%'.$_REQUEST['q'].'%'
                            ),
                            $arExFilt,
                            $priceFilter
                            
                        ),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
                );
                while($fetchSearch = $getList -> GetNext()){
                    //echo "<pre>"; print_r($fetchSearch); echo "</pre>";
                    if( stristr($fetchSearch['NAME'], $_REQUEST['search_query']) || stristr($fetchSearch["PROPERTY_NAME_".strtoupper($language)], $_REQUEST['search_query']) ){
                        $arResult['SEARCH'][] = $fetchSearch;
                        $counterProducts += 1;
                        if( strtolower($fetchSearch['NAME']) == strtolower($_REQUEST['search_query']) || strtolower($fetchSearch["PROPERTY_NAME_".strtoupper($language)]) == strtolower($_REQUEST['search_query']) ){
                            $counterProductsExact += 1;
                        }
                    }
                    
                }
            }
            if(is_array($arExFilt) || $priceFilter || $squareFilter || $_REQUEST['q']){
                $getList = CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array('ACTIVE' => 'Y',
                            'IBLOCK_ID' => '8',
                            array(
                                "LOGIC" => "OR",
                                'NAME' => '%'.$_REQUEST['q'].'%',
                                "PROPERTY_NAME_".strtoupper($language) => '%'.$_REQUEST['q'].'%'
                            ),
                            $arExFilt,
                            $priceFilter,
                            $squareFilter
                        ),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
                );
                while($fetchSearch = $getList -> GetNext()){
                    //echo "<pre>"; print_r($fetchSearch); echo "</pre>";
                    if( stristr($fetchSearch['NAME'], $_REQUEST['search_query']) || stristr($fetchSearch["PROPERTY_NAME_".strtoupper($language)], $_REQUEST['search_query']) ){
                        $arResult['SEARCH'][] = $fetchSearch;
                        $counterProducts += 1;
                        if( strtolower($fetchSearch['NAME']) == strtolower($_REQUEST['search_query']) || strtolower($fetchSearch["PROPERTY_NAME_".strtoupper($language)]) == strtolower($_REQUEST['search_query']) ){
                            $counterProductsExact += 1;
                        }
                    }
                }
            }
            
        }else{
            if(is_array($arExFilt) || $priceFilter){
                $getList = CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array('ACTIVE' => 'Y',
                            'IBLOCK_ID' => '4',
                            $arExFilt,
                            $priceFilter
                        ),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
                );
                while($fetchSearch = $getList -> GetNext()){
                    $arResult['SEARCH'][] = $fetchSearch;
                    $counterProducts += 1;
                }
            }
            if(is_array($arExFilt) || $priceFilter || $squareFilter ){
                $getList = CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array('ACTIVE' => 'Y',
                            'IBLOCK_ID' => '8',
                            $arExFilt,
                            $priceFilter,
                            $squareFilter
                        ),
                    false,
                    false,
                    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_NAME_'.strtoupper($language), 'DETAIL_PAGE_URL', 'PROPERTY_UNIT_SIZE_RU', 'PROPERTY_UNIT_SIZE_EN', 'PROPERTY_SELLING_STEP_RU', 'PROPERTY_SELLING_STEP_EN', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN', 'PROPERTY_BEDS_RU', 'PROPERTY_BEDS_EN', 'PROPERTY_BUILDING_STEP_RU', 'PROPERTY_BUILDING_STEP_EN', 'PROPERTY_ESTIMATED_COMPLETION_RU', 'PROPERTY_ESTIMATED_COMPLETION_EN')
                );
                while($fetchSearch = $getList -> GetNext()){
                    $arResult['SEARCH'][] = $fetchSearch;
                    $counterProducts += 1;
                }
            }
        }

        //global $arrFilterAjax;
        //print_r(count($arResult['SEARCH']));
        $explo = $APPLICATION->GetCurDir();
        $explo = explode('/', $explo);

        ?>
        <div class="search-results">
            <?
            $count = 0;
            foreach ($arResult['SEARCH'] as $key => $value) {
                if($count == 5){
                    break;
                }
                $count++;
                if(isset($value['DETAIL_PAGE_URL']) && $value['DETAIL_PAGE_URL']!=''){
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
                                $codePart = $fetchList['CODE'];
                            }
                        }
                    }

                    ?>
                    <div class="result-item">
                        <?
                        $xplodes = explode('/', $value['DETAIL_PAGE_URL']);
                        $xplodes[3] = $xplodes[2];
                        $xplodes[2] = $codePart;
                        $detail = implode('/', $xplodes);
                        if($value['ID'] == $arrNext['ID']){
                            $resHref = "/".strtolower($language)."-".$ufPart.$detail.'/';
                        }
                        ?>
                        <a href="/<?=strtolower($language)?>-<?=$ufPart?><?=$detail.'/'?>">
                            <?
                            if(strtolower($language) == 'en'){
                                echo $value['NAME'];
                            }else{
                                echo $value['PROPERTY_NAME_'.strtoupper($language).'_VALUE'];
                            }
                            ?>
                        </a>
                    </div>
                    <?
                }else{
                    $nav = CIBlockSection::GetNavChain(false, $value['ID']);
                    while($get = $nav->GetNext()){
                        //echo "<pre>"; print_r($get); echo "</pre>";
                        $getList = CIBlockSection::GetList(array('SORT'=>'ASC'), array('ID' => $get['ID'], 'IBLOCK_ID' => $value['IBLOCK_ID']), false, array('ID','IBLOCK_ID','CODE','SECTION_PAGE_URL','UF_HREF_ISO', 'DEPTH_LEVEL'));
                        //$ar_new_groups[] = $ar_group["ID"];
                        if($fetchList = $getList->GetNext()){
                            if($fetchList['DEPTH_LEVEL'] == 2){
                                $ufPart = $fetchList['UF_HREF_ISO'];
                            }
                        }
                    }
                    if($value['ID'] == $arrNext['ID']){
                        $resHref = "/".strtolower($language)."-".$ufPart.$value['SECTION_PAGE_URL'];
                    }
                    ?>
                    <div class="result-item">
                        <a href="/<?=strtolower($language)?>-<?=$ufPart?><?=$value['SECTION_PAGE_URL']?>">
                            <?
                            //echo "<pre>"; print_r($value); echo "</pre>";
                            if(strtolower($language) == 'en'){
                                echo $value['NAME'];
                            }else{
                                echo $value['UF_NAME_'.strtoupper($language)];
                            }
                            ?>
                        </a>
                    </div>
                    <?
                }
            }

            //echo "<pre>"; print_r($arResult['SEARCH']); echo "</pre>";
            ?>
        </div>
        <?
        $search_value = 'search_page';
        if(!$counterProducts){
            $counterProducts=0;
        }
        if(!$counterSection){
            $counterSection=0;
        }

        if($counterSectionExact == 1 && $counterProducts == 0){
            $search_value = "this_one_category";
            $href = $resHref;
        }elseif($counterProductsExact == 1){
            $search_value = "this_one_product";
            $href = $resHref;
        }elseif( ( $counterSectionExact == 2 || $counterSectionExact == 3 ) && $counterProducts == 0){
            $search_value = "get_an_parent_to_decide";
            if($APPLICATION->GetCurDir() != '/'){
                $plos = explode('/', $_REQUEST['CURDIR']);
                $resHref = str_replace('developments', $plos[2], $resHref);
                $resHref = str_replace('condos', $plos[2], $resHref);
                $resHref = str_replace('single-family-homes', $plos[2], $resHref);
            }else{
                //$resHref = str_replace('developments', $plos[2], $resHref);
                $resHref = str_replace('condos', 'developments', $resHref);
                $resHref = str_replace('single-family-homes', 'single-family-homes', $resHref);
            }
            $href = $resHref;
        }elseif($counterSectionExact == 0 && $counterProducts == 0){
            $search_value = "first_from_list";
        }else/*if($counterSectionExact == 0 && $counterProducts > 0)*/{
            $search_value = "search_page";
        }
        ?>
        <input type="hidden" data-new-href="<?=$href?>" data-cur-dir="<?=$_REQUEST['CURDIR']?>" name="whatToUseInSearch" data-exact-pro="<?=$counterProductsExact?>" data-exact-sect="<?=$counterSectionExact?>" data-products-count="<?=$counterProducts?>" data-section-count="<?=$counterSection?>" value="<?=$search_value?>">
        <?/*<div style="display: none;">
            <?
            echo "<pre>"; print_r($_REQUEST); echo "</pre>";
            ?>
        </div>*/?>
        <?
    }