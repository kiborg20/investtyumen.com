<?global $APPLICATION;
$res = "";

if(NULL!=$arResult["PROPERTIES"]["PROJECT_NAME"]['VALUE'] || $arResult["PROPERTIES"]["PROJECT_NAME"]['VALUE']!=""){
    $res = $arResult["PROPERTIES"]["PROJECT_NAME"]['VALUE'];
}

if(NULL!=$arResult["PROPERTIES"]["PLACE_NAME"]['VALUE'] || $arResult["PROPERTIES"]["PLACE_NAME"]['VALUE']!=""){
    $res = $arResult["PROPERTIES"]["PLACE_NAME"]['VALUE'];
}

$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['MY_TITLE'] = $arParams["HEADER_PREFIX"].$res;
    $cp->SetResultCacheKeys(array('MY_TITLE'));
}?>