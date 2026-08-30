<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
    
if(!Loader::includeModule("iblock"))
{
    return;
}

$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT","DATE_ACTIVE_FROM","DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_".$arParams["PROPERTY_CODE"],"PROPERTY_IT_SMIONAS_SOURCE","PROPERTY_IT_SMIONAS_SOURCE_EN","PROPERTY_IT_SMIONAS_SOURCE_LINK", "PROPERTY_IT_TITLE_EN","IT_DESCR_EN");
$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "ACTIVE"=>"Y", "PROPERTY_".$arParams["PROPERTY_CODE"]."_VALUE" => 'Да');
$res = CIBlockElement::GetList(Array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult[] = $arFields;    
}

$this->includeComponentTemplate();
?>