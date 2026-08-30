<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
if(!Loader::includeModule("iblock"))
{
    return;
}

$arParams['HEROTITLE'] = html_entity_decode($arParams['HEROTITLE']);
$arSelect = ["ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_*", "PROPERTY_IT_YEAR",
    "PROPERTY_IT_ICON", "PROPERTY_IT_LINK", "PROPERTY_IT_RAIT", "PROPERTY_IT_NOMINATION"];
$arFilter = ["IBLOCK_ID" => (int)$arParams["IBLOCK_ID"], "ACTIVE" => "Y", "PROPERTY_" . $arParams["PROPERTY_CODE"] . "_VALUE" => 'Да'];
$res = CIBlockElement::GetList(['SORT' => 'asc'], $arFilter, false, false, $arSelect);
while ($arFields = $res->GetNext())
{
    if($arFields["PROPERTY_IT_ICON_VALUE"]) {
        $arFields["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width' => 1920,'height' => 1080), BX_RESIZE_IMAGE_EXACT, true);
    }
    if($arFields["~PROPERTY_IT_ICON_VALUE"]) {
        $arFields["PROPERTY_IT_ICON_VALUE"] = CFile::GetPath($arFields["~PROPERTY_IT_ICON_VALUE"]);
    }
    $arFields["PROPERTY_IT_NOMINATION_VALUE"] = $arFields["~PROPERTY_IT_NOMINATION_VALUE"];
    $arFields["PROPERTY_IT_RAIT_VALUE"] = $arFields["~PROPERTY_IT_RAIT_VALUE"];

    $arResult['ITEMS'][] = $arFields;
}

$this->includeComponentTemplate();
?>