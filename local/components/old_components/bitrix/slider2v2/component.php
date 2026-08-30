<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
    
if(!Loader::includeModule("iblock"))
{
    return;
}

$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_".$arParams["PROPERTY_CODE"],"PROPERTY_IT_SLIDER_T","PROPERTY_IT_SLIDER_R","IT_SLIDER_Y","IT_SLIDER_T_EN","IT_SLIDER_R_EN","IT_SLIDER_Y_EN");
$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "SECTION_ID" => IntVal($arParams["SECTION_ID"]), "ACTIVE"=>"Y", "PROPERTY_".$arParams["PROPERTY_CODE"]."_VALUE" => 'Да');
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult[] = $arFields;    
}

$this->includeComponentTemplate();
?>