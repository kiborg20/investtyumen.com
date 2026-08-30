<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(CModule::IncludeModule("iblock"))
{

    $res = CIBlock::GetByID($arParams["IBLOCK_ID"]);
    if($ar_res = $res->fetch()){
        $arResult['IBLOCK_ID'] =  $arParams["IBLOCK_ID"];
        $arResult['TITLE'] =  $ar_res['NAME'];
        $arResult['CODE'] =  $ar_res['CODE'];
        $arResult['DESCRIPTION'] =  $ar_res['DESCRIPTION'];
    }

    $props = CIBlockProperty::GetList(Array("sort"=>"asc", "ID"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arParams["IBLOCK_ID"]));
    $properties = [];
    while ($prop_fields = $props->GetNext())
    {
        $properties[] = $prop_fields;
    }

    $arResult['PROPERTIES'] = $properties;
}

$this->IncludeComponentTemplate();
?>