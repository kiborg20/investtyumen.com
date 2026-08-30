<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
    
if(!Loader::includeModule("iblock"))
{
    return;
}

$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE","PREVIEW_TEXT", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_".$arParams["PROPERTY_CODE"],"PROPERTY_IT_CONT_DOL","PROPERTY_IT_CONT_PH","PROPERTY_IT_CONT_EM");
$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "SECTION_ID" => IntVal($arParams["SECTION_ID"]), "ACTIVE"=>"Y", "PROPERTY_".$arParams["PROPERTY_CODE"]."_VALUE" => 'Да');
$res = CIBlockElement::GetList(Array('SORT' => 'asc'), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult[] = $arFields;    
}

$this->includeComponentTemplate();
?>