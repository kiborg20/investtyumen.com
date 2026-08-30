<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
    
if(!Loader::includeModule("iblock"))
{
    return;
}

$arSelect = [
  'ID',
  'LEFT_MARGIN',
  'DEPTH_LEVEL',
  'NAME',
  'DESCRIPTION',
  'PICTURE',
  'DETAIL_PICTURE',
  'UF_TITLE'
];
$arOrder = [
  'LEFT_MARGIN' => 'ASC'
];
$arFilter = Array("IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "ACTIVE"=>"Y", "PROPERTY_".$arParams["PROPERTY_CODE"]."_VALUE" => 'Да');
$res = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult[] = $arFields;    
}

$this->includeComponentTemplate();
?>