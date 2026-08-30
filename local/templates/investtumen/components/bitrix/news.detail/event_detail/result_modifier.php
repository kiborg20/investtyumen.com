<?global $APPLICATION;
$res = "";

if(NULL!=$arResult["PROPERTIES"]["EVENT_NAME"]['VALUE'] || $arResult["PROPERTIES"]["EVENT_NAME"]['VALUE']!=""){
    $res = $arResult["PROPERTIES"]["EVENT_NAME"]['VALUE'];
}
$data = [];
$data["EVENT_NAME"] = $arResult["PROPERTIES"]["EVENT_NAME"]['VALUE'];
$data["EVENT_THEME"] = $arResult["PROPERTIES"]["EVENT_THEME"]['VALUE'];
$data["EVENT_DATE"] = $arResult["PROPERTIES"]["EVENT_DATE"]['VALUE'];
$data["EVENT_TIME"] = $arResult["PROPERTIES"]["EVENT_TIME"]['VALUE'];
$data["EVENT_PLACE"] = $arResult["PROPERTIES"]["EVENT_PLACE"]['VALUE'];

$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['MY_TITLE'] = $arParams["HEADER_PREFIX"].$res;
    $cp->arResult['EVENT_DATA'] = $data;
    $cp->SetResultCacheKeys(array('MY_TITLE','EVENT_DATA'));
}?>