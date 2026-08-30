<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
    
if(!Loader::includeModule("iblock"))
{
    return;
}

$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_".$arParams["PROPERTY_CODE"],"PROPERTY_IT_SLIDER_TITLE","PROPERTY_IT_SLIDER_TITLE_EN","PROPERTY_IT_SLIDER_LINK");
$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "ACTIVE"=>"Y", "PROPERTY_".$arParams["PROPERTY_CODE"]."_VALUE" => 'Да');
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult[] = $arFields;    
}

$this->includeComponentTemplate();
?>