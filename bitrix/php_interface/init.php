<?
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MyClass", "OnAfterIBlockElementAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MyClass", "OnAfterIBlockElementAddHandler"));

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

function replace_type($from, $to, $str){
    if($from == 'ru' && $to == 'en'){
        $str = str_replace('Квартиры / Апартаменты', 'Condos / Apts', $str);
        $str = str_replace('Квартиры/Апартаменты', 'Condos / Apts', $str);
        $str = str_replace('Апартаменты', 'Condos / Apts', $str);
        $str = str_replace('Квартиры', 'Condos / Apts', $str);
        $str = str_replace('Таунхаусы', 'Townhouses', $str);
    }
    if($from == 'en' && $to == 'ru'){
        $str = str_replace('Condos / Apts', 'Квартиры / Апартаменты', $str);
        $str = str_replace('Condos/Apts', 'Квартиры / Апартаменты', $str);
        $str = str_replace('Townhouses', 'Таунхаусы', $str);
    }

    return $str; 
}

class MyClass
{
    function OnAfterIBlockElementAddHandler(&$arFields)
    {
        if (CModule::IncludeModule("iblock")){
            $db_old_groups = CIBlockElement::GetElementGroups($arFields['ID'], true);
            while($ar_group = $db_old_groups->Fetch())
            {
                $nav = CIBlockSection::GetNavChain(false, $ar_group['ID']);
                while($item = $nav ->Fetch()) {
                    $arSects[] = $item['ID'];
                }
            }
            CIBlockElement::SetElementSection($arFields['ID'], $arSects);
            $getList = CIBlockElement::GetList(array('SORT'=>'ASC'), array('ID' => $arFields['ID'], 'IBLOCK_ID' => $arFields['IBLOCK_ID']), false, false, array('ID', 'NAME', 'PROPERTY_PRICE_PER_SQFT_EN', 'PROPERTY_PRICE_PER_SQFT_RU', 'PROPERTY_PRICE_FROM_EN', 'PROPERTY_PRICE_FROM_RU', 'PROPERTY_PRICE_TO_EN', 'PROPERTY_PRICE_TO_RU', 'PROPERTY_PRICE_EN', 'PROPERTY_PRICE_RU', 'PROPERTY_PRICE_PER_SQFT_EN', 'PROPERTY_PRICE_PER_SQFT_RU', 'PROPERTY_TYPE_RU', 'PROPERTY_TYPE_EN'));

            if($fetchList = $getList -> GetNext()){
                if($fetchList['PROPERTY_TYPE_EN_VALUE'] == NULL || $fetchList['PROPERTY_TYPE_RU_VALUE'] == NULL){
                    if(!($fetchList['PROPERTY_TYPE_EN_VALUE'] == NULL && $fetchList['PROPERTY_TYPE_RU_VALUE'] == NULL)){
                        if($fetchList['PROPERTY_TYPE_EN_VALUE'] == NULL){

                            AddMessage2Log( array($fetchList['PROPERTY_TYPE_RU_VALUE'], replace_type('ru', 'en', $fetchList['PROPERTY_TYPE_RU_VALUE'])) );

                            $fetchList['PROPERTY_TYPE_RU_VALUE'] = replace_type('ru', 'en', $fetchList['PROPERTY_TYPE_RU_VALUE']);
                            CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], array('TYPE_EN' => $fetchList['PROPERTY_TYPE_RU_VALUE']));
                        }
                        if($fetchList['PROPERTY_TYPE_RU_VALUE'] == NULL){

                            AddMessage2Log( array($fetchList['PROPERTY_TYPE_EN_VALUE'], replace_type('en', 'ru', $fetchList['PROPERTY_TYPE_EN_VALUE'])) );

                            $fetchList['PROPERTY_TYPE_EN_VALUE'] = replace_type('en', 'ru', $fetchList['PROPERTY_TYPE_EN_VALUE']);
                            CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], array('TYPE_RU' => $fetchList['PROPERTY_TYPE_EN_VALUE']));
                        }
                    }
                }

            }                
        }
        
    }
}
?>